<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Internal;

use PhpParser\Node;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\EnumCase;
use PHPStan\Analyser\Scope;
use PHPStan\File\FileHelper;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Custom rule specific to TemplatePart enums.
 *
 * @notice Currently an Easter Egg not yet stable enough to be added to general usage.
 *
 * @author Mat Lipe
 * @since  4.4.0
 *
 * @internal
 *
 * @implements Rule<Enum_>
 */
class TemplatePartExistsRule implements Rule {
	public function __construct(
		protected string $themePath,
		protected FileHelper $fileHelper,
	) {
	}


	public function getNodeType(): string {
		return Enum_::class;
	}


	/**
	 * @param Enum_ $node
	 * @param Scope $scope
	 *
	 * @return list<IdentifierRuleError>
	 */
	public function processNode( Node $node, Scope $scope ): array {
		if ( '' === $this->themePath ) {
			return [];
		}
		$fqn = $scope->getNamespace() . '\\' . $node->name?->toString();
		if ( 'Lipe\Project\Theme\TemplatePart' !== $fqn ) {
			return [];
		}

		$errors = [];
		foreach ( $node->stmts as $stmt ) {
			if ( ! $stmt instanceof EnumCase ) {
				continue;
			}
			if ( ! $stmt->expr instanceof String_ ) {
				continue;
			}

			$value = $stmt->expr->value;
			$path = $this->getTemplatePath( $value );

			if ( ! \file_exists( $path ) ) {
				$error_builder = RuleErrorBuilder::message(
					\sprintf(
						'Template part file "%s.php" does not exist.',
						$value
					)
				);
				$errors[] = $error_builder
					->line( $stmt->getStartLine() )
					->identifier( 'lipemat.templatePartExists' )
					->build();
			}
		}

		return $errors;
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
