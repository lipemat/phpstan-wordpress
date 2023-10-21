<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Classes;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Rules;

/**
 * Make sure all classes are final.
 *
 * Abstract classes are allowed, but only if:
 * 1. Abstract classes are not disallowed.
 * OR
 * 2. The abstract class is in the list of allowed abstract classes.
 *
 * @implements Rules\Rule<Node\Stmt\Class_>
 */
class FinalRule implements Rules\Rule {
	/**
	 * @var bool
	 */
	protected $allowAbstractClasses;

	/**
	 * @var array<int, class-string>
	 */
	private $classesAllowedToBeAbstract = [];

	/**
	 * @var string
	 */
	private $errorMessageTemplate = 'Class %s is not final.';

	/**
	 * @var string
	 */
	private $identifier = 'lipemat.classMustBeFinal';


	/**
	 * Receives the arguments from these parameter in the `rules.neon` file.
	 * - lipemat.noExtends
	 * - lipemat.allowedToBeExtended
	 *
	 * @param bool  $disallowAbstractClasses
	 * @param list<class-string> $classesAllowedToBeAbstract
	 */
	public function __construct( bool $disallowAbstractClasses, array $classesAllowedToBeAbstract ) {
		$this->allowAbstractClasses = ! $disallowAbstractClasses;
		$this->classesAllowedToBeAbstract = \array_values( $classesAllowedToBeAbstract );

		if ( $this->allowAbstractClasses ) {
			$this->errorMessageTemplate = 'Class %s is neither abstract nor final.';
		}
		if ( count( $this->classesAllowedToBeAbstract ) > 0 ) {
			$this->errorMessageTemplate = 'Class %s is not final.';
		}
	}


	public function getNodeType(): string {
		return Node\Stmt\Class_::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! isset( $node->namespacedName ) ) {
			return [];
		}
		$error = $this->errorMessageTemplate;
		$id = $this->identifier;

		if ( $node->isFinal() ) {
			return [];
		}
		if ( $node->isAbstract() ) {
			if ( $this->allowAbstractClasses ) {
				return [];
			}

			if ( \in_array( $node->namespacedName->toString(), $this->classesAllowedToBeAbstract, true ) ) {
				return [];
			}
			$error = 'Class %s is not an allowed abstract.';
			$id = 'lipemat.classMustBeAllowedAbstract';
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message(
			\sprintf(
				$error,
				$node->namespacedName->toString()
			)
		);

		$ruleErrorBuilder->identifier( $id );

		return [ $ruleErrorBuilder->build() ];
	}
}
