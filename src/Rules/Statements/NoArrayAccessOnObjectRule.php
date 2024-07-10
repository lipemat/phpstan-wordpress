<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Statements;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\ObjectType;

/**
 * Prevent using ArrayAccess on an object.
 *
 * @implements Rule<ArrayDimFetch>
 */
class NoArrayAccessOnObjectRule implements Rule {
	/**
	 * @var string
	 */
	public const ERROR_MESSAGE = 'Use explicit methods over array access on object';

	/**
	 * @var string[]
	 */
	private const ALLOWED_CLASSES = [ 'SplFixedArray', 'SimpleXMLElement', 'Iterator', 'Aws\ResultInterface', 'Symfony\Component\Form\FormInterface', 'Symfony\Component\OptionsResolver\Options', 'Pimple\Container' ];


	public function getNodeType(): string {
		return ArrayDimFetch::class;
	}


	/**
	 * @param ArrayDimFetch $node
	 *
	 * @return string[]
	 */
	public function processNode( Node $node, Scope $scope ): array {
		$varType = $scope->getType( $node->var );
		$classes = $varType->getObjectClassNames();
		if ( [] === $classes ) {
			return [];
		}
		foreach ( $varType->getObjectClassNames() as $class ) {
			if ( $this->isAllowedObjectType( new ObjectType( $class ) ) ) {
				return [];
			}
		}

		return [
			self::ERROR_MESSAGE,
		];
	}


	private function isAllowedObjectType( ObjectType $objectType ): bool {
		foreach ( self::ALLOWED_CLASSES as $allowedClass ) {
			if ( $objectType->isInstanceOf( $allowedClass )->yes() ) {
				return true;
			}
		}

		return false;
	}
}
