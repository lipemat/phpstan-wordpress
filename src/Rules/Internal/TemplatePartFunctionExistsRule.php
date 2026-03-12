<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Internal;

use PhpParser\Node;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\File\FileHelper;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Custom rule specific to `lipe_template_part()` and `lipe_template_contents()` functions.
 *
 * @author Mat Lipe
 * @since  4.4.0
 *
 * @internal
 *
 * @implements Rule<Node\Expr\FuncCall>
 */
class TemplatePartFunctionExistsRule implements Rule {
	public function __construct(
		protected string $themePath,
		protected FileHelper $fileHelper,
	) {
	}


	public function getNodeType(): string {
		return Node\Expr\FuncCall::class;
	}


	/**
	 * @param Node\Expr\FuncCall $node
	 * @param Scope              $scope
	 *
	 * @return list<IdentifierRuleError>
	 */
	public function processNode( Node $node, Scope $scope ): array {
		if ( '' === $this->themePath || ! $node->name instanceof Node\Name ) {
			return [];
		}

		$function_name = $node->name->toLowerString();
		if ( ! \in_array( $function_name, [ 'lipe_template_part', 'lipe_template_contents' ], true ) ) {
			return [];
		}

		if ( ! isset( $node->getArgs()[0] ) ) {
			return [];
		}

		$arg = $node->getArgs()[0]->value;
		if ( ! $arg instanceof String_ ) {
			return [];
		}

		$value = $arg->value;
		$path = $this->getTemplatePath( $value );

		if ( ! \file_exists( $path ) ) {
			$error_builder = RuleErrorBuilder::message(
				\sprintf(
					'Template part file "%s.php" does not exist.',
					$value
				)
			);
			$error_builder->identifier( 'lipemat.templatePartFunctionExists' );

			return [ $error_builder->build() ];
		}

		return [];
	}


	public function getTemplatePath( string $raw_path ): string {
		$theme_path = $this->sanitize_path( $this->themePath );

		$full_path = $this->fileHelper->absolutizePath( "{$theme_path}/template-parts/{$raw_path}.php" );
		return $this->fileHelper->normalizePath( $full_path, '/' );
	}


	public function sanitize_path( string $path ): string {
		$path = $this->fileHelper->normalizePath( $path, '/' );
		return \rtrim( $path, '/\\' );
	}
}
