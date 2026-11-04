<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Classes;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\DependencyInjection\AutowiredParameter;
use PHPStan\DependencyInjection\Conditional;
use PHPStan\DependencyInjection\RegisteredRule;
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
#[Conditional( new RegisteredRule( level: 0 ), if: '%lipemat.nonDistributed%' )]
class FinalRule implements Rules\Rule {
	/**
	 * @var array<int, string>
	 */
	private static $defaultAllowedToBeAbstract = [
		'Lipe_Project_WP_Object_Cache',
	];

	/**
	 * @var bool
	 */
	protected $allowAbstractClasses;

	/**
	 * @var array<int, string>
	 */
	private $classesAllowedToBeAbstract;

	/**
	 * @var string
	 */
	private $errorMessageTemplate = 'Class %s is not final.';

	/**
	 * @var string
	 */
	private $identifier = 'lipemat.classMustBeFinal';


	/**
	 * @param bool                     $disallowAbstractClasses
	 * @param array<int, class-string> $classesAllowedToBeAbstract
	 */
	public function __construct(
		#[AutowiredParameter( ref: '%lipemat.noExtends%' )]
		bool $disallowAbstractClasses,
		#[AutowiredParameter( ref: '%lipemat.allowedToBeExtended%' )]
		array $classesAllowedToBeAbstract,
	) {
		$this->allowAbstractClasses = ! $disallowAbstractClasses;

		$this->classesAllowedToBeAbstract = \array_merge( self::$defaultAllowedToBeAbstract, \array_values( $classesAllowedToBeAbstract ) );

		if ( $this->allowAbstractClasses ) {
			$this->errorMessageTemplate = 'Class %s is neither abstract nor final.';
		}
		if ( \count( $this->classesAllowedToBeAbstract ) > \count( self::$defaultAllowedToBeAbstract ) ) {
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
