<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Classes;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Rules;

/**
 * Prevent any classes from extending other classes.
 *
 * @implements Rules\Rule<Node\Stmt\Class_>
 */
class NoExtendsRule implements Rules\Rule {
	/**
	 * @var array<int, string>
	 */
	private static $defaultClassesAllowedToBeExtended = [
		'PHPUnit\\Framework\\TestCase',
		'WP_Block',
	];

	/**
	 * @var array<int, string>
	 */
	private $classesAllowedToBeExtended;


	/**
	 * @param array<int, class-string> $classesAllowedToBeExtended
	 */
	public function __construct( array $classesAllowedToBeExtended ) {
		$this->classesAllowedToBeExtended = \array_unique(
			\array_merge(
				self::$defaultClassesAllowedToBeExtended,
				\array_map(
					function ( string $classAllowedToBeExtended ): string {
						return $classAllowedToBeExtended;
					},
					$classesAllowedToBeExtended
				)
			)
		);
	}


	public function getNodeType(): string {
		return Node\Stmt\Class_::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! $node->extends instanceof Node\Name ) {
			return [];
		}

		$extendedClassName = $node->extends->toString();

		if ( \in_array( $extendedClassName, $this->classesAllowedToBeExtended, true ) ) {
			return [];
		}

		if ( ! isset( $node->namespacedName ) ) {
			$ruleErrorBuilder = Rules\RuleErrorBuilder::message(
				\sprintf(
					'Anonymous class is not allowed to extend "%s".',
					$extendedClassName
				)
			);
			$ruleErrorBuilder->identifier( 'anonymousClassExtendsNotAllowed' );

			return [ $ruleErrorBuilder->build() ];
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message(
			\sprintf(
				'Class "%s" is not allowed to extend "%s".',
				$node->namespacedName->toString(),
				$extendedClassName
			)
		);
		$ruleErrorBuilder->identifier( 'classExtendsNotAllowed' );

		return [ $ruleErrorBuilder->build() ];
	}
}
