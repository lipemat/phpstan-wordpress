<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Reflection;
use PHPStan\Rules;

/**
 * Prevent any methods in a final class from being protected.
 * They should be private instead.
 *
 * @implements Rules\Rule<Node\Stmt\ClassMethod>
 */
class PrivateInFinalClassRule implements Rules\Rule {
	public function getNodeType(): string {
		return Node\Stmt\ClassMethod::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		/** @var Reflection\ClassReflection $containingClass */
		$containingClass = $scope->getClassReflection();

		if ( ! $containingClass->isFinal() ) {
			return [];
		}

		if ( $node->isPublic() ) {
			return [];
		}

		if ( $node->isPrivate() ) {
			return [];
		}

		$methodName = $node->name->toString();

		$parentClass = $containingClass->getNativeReflection()->getParentClass();

		if ( $parentClass instanceof \ReflectionClass && $parentClass->hasMethod( $methodName ) ) {
			$parentMethod = $parentClass->getMethod( $methodName );

			if ( $parentMethod->isProtected() ) {
				return [];
			}
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message(
			\sprintf(
				'Method %s::%s() is protected, but since the containing class is final, it can be private.',
				$containingClass->getName(),
				$methodName
			)
		);
		$ruleErrorBuilder->identifier( 'lipemat.privateInFinalClass' );

		return [
			$ruleErrorBuilder->build(),
		];
	}
}
