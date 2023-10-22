<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Reflection;
use PHPStan\Rules;

/**
 * Require any concrete methods in abstract classes to be `final` or `private`.
 *
 * This prevents the method with body from being overridden in a child class.
 * Overriding an abstract method break the signature contract and should be
 * avoided.
 *
 * It is preferred not to have abstract class at all, but if we do have them,
 * we will at least know where a called method comes from and can convert
 * any methods requiring overriding to abstract methods.
 *
 * @implements Rules\Rule<Node\Stmt\ClassMethod>
 */
class FinalInAbstractClassRule implements Rules\Rule {
	public function getNodeType(): string {
		return Node\Stmt\ClassMethod::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		/** @var Reflection\ClassReflection $containingClass */
		$containingClass = $scope->getClassReflection();

		if ( ! $containingClass->isAbstract() ) {
			return [];
		}

		if ( $containingClass->isInterface() ) {
			return [];
		}

		if ( $node->isAbstract() ) {
			return [];
		}

		if ( $node->isFinal() ) {
			return [];
		}

		if ( $node->isPrivate() ) {
			return [];
		}

		if ( '__construct' === $node->name->name ) {
			return [];
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message(
			\sprintf(
				'Method %s::%s() is not final, but since the containing class is abstract, it should be.',
				$containingClass->getName(),
				$node->name->toString()
			)
		);
		$ruleErrorBuilder->identifier( 'lipemat.finalInAbstractClass' );
		$ruleErrorBuilder->addTip( 'If overriding is necessary, an abstract method should be used instead.' );

		return [ $ruleErrorBuilder->build() ];
	}
}
