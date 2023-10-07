<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser;
use PHPStan\Reflection;
use PHPStan\Rules;
use PHPStan\ShouldNotHappenException;

final class PrivateInFinalClassRule implements Rules\Rule {
	public function getNodeType(): string {
		return Node\Stmt\ClassMethod::class;
	}


	public function processNode( Node $node, Analyser\Scope $scope ): array {
		if ( ! $node instanceof Node\Stmt\ClassMethod ) {
			throw new ShouldNotHappenException( \sprintf(
				'Expected node to be instance of "%s", but got instance of "%s" instead.',
				Node\Stmt\ClassMethod::class,
				''
            ) );
		}

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

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message( \sprintf(
			'Method %s::%s() is protected, but since the containing class is final, it can be private.',
			$containingClass->getName(),
			$methodName
        ) );

		return [
			$ruleErrorBuilder->build(),
		];
	}
}
