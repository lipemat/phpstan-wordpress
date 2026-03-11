<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Custom;

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
 * @notice Currently and Easter Egg not yet stable enough to be added to general usage.
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
		protected FileHelper $fileHelper
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

			$raw_path = $this->fileHelper->normalizePath( \dirname( $scope->getFile() ) . '/' . $value . '.php' );
			$path = $this->translateTempPath( $raw_path );

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


	/**
	 * PHPStorm uses a temporary folder to store the PHP files when running
	 * through PHPStan. This method translates the temporary path to the
	 * real path.
	 *
	 * @param string $raw_path - Path with possible PHPStorm temporary folder.
	 *
	 * @return string
	 */
	public function translateTempPath( string $raw_path ): string {
		\preg_match( '/(?<dir>PHPStantemp_folder\d{3,5})/', $raw_path, $matches, \PREG_OFFSET_CAPTURE );
		if ( ! isset( $matches['dir'] ) ) {
			return $this->fileHelper->normalizePath( $raw_path, '/' );
		}

		$offset = $matches['dir'][1];
		$dir_length = \strlen( $matches['dir'][0] );

		return $this->fileHelper->normalizePath( \getcwd() . \DIRECTORY_SEPARATOR . \substr( $raw_path, $offset + $dir_length ), '/' );
	}
}
