<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Statements;

use Lipe\Lib\Phpstan\Traits\TraitHelpers;
use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Rules;
use PHPStan\Rules\Rule;
use PHPStan\Type\ObjectType;

/**
 * Prevent using ArrayAccess on an object.
 *
 * @implements Rule<ArrayDimFetch>
 */
class NoArrayAccessOnObjectRule implements Rule {
	use TraitHelpers;

	/**
	 * @var string
	 */
	public const ERROR_MESSAGE = 'Array access is not allowed on objects. Use methods instead.';

	/**
	 * These classes may be used for reading and writing.
	 *
	 * @var string[]
	 */
	private const ALLOWED_CLASSES = [
		'Aws\ResultInterface',
		'Iterator',
		'Pimple\Container',
		'SimpleXMLElement',
		'SplFixedArray',
		'Symfony\Component\Form\FormInterface',
		'Symfony\Component\OptionsResolver\Options',

	];
	/**
	 * These classes have working types when reading, but
	 * unable to properly resolve when writing.
	 *
	 * @var string[]
	 */
	private const ALLOWED_TO_READ_ONLY = [
		'WP_REST_Request',
		'Lipe\Lib\Meta\Mutator_Trait',
	];


	public function getNodeType(): string {
		return ArrayDimFetch::class;
	}


	/**
	 * @param ArrayDimFetch $node
	 */
	public function processNode( Node $node, Scope $scope ): array {
		$varType = $scope->getType( $node->var );
		$classes = $varType->getObjectClassNames();
		if ( [] === $classes ) {
			return [];
		}

		$parentNode = $node->getAttribute( 'parent' );
		$isBeingSet = ( $parentNode instanceof Node\Expr\Assign && $parentNode->var === $node );
		$ruleErrorBuilder = Rules\RuleErrorBuilder::message( self::ERROR_MESSAGE );

		foreach ( $varType->getObjectClassNames() as $class ) {
			if ( $this->isAllowed( new ObjectType( $class ), self::ALLOWED_CLASSES ) ) {
				return [];
			}
			if ( $this->isAllowedToReadOnly( new ObjectType( $class ), self::ALLOWED_TO_READ_ONLY ) ) {
				if ( $isBeingSet ) {
					$ruleErrorBuilder->addTip( "Reading is allowed on `{$class}`, but writing is not." );
				} else {
					return [];
				}
			}
		}

		$ruleErrorBuilder->identifier( 'lipemat.noArrayAccessOnObject' );
		return [
			$ruleErrorBuilder->build(),
		];
	}


	/**
	 * @param ObjectType    $objectType
	 * @param array<string> $allowed
	 *
	 * @return bool
	 */
	private function isAllowed( ObjectType $objectType, array $allowed ): bool {
		foreach ( $allowed as $allowedClass ) {
			if ( $allowedClass === $objectType->getClassName() ) {
				return true;
			}
			if ( $objectType->isInstanceOf( $allowedClass )->yes() ) {
				return true;
			}
		}
		return false;
	}


	/**
	 * @param ObjectType    $objectType
	 * @param array<string> $allowed
	 *
	 * @return bool
	 */
	private function isAllowedToReadOnly( ObjectType $objectType, array $allowed ): bool {
		foreach ( $allowed as $allowedClass ) {
			if ( $allowedClass === $objectType->getClassName() ) {
				return true;
			}
			if ( $objectType->isInstanceOf( $allowedClass )->yes() ) {
				return true;
			}
			if ( $this->hasTrait( $objectType, $allowedClass ) ) {
				return true;
			}
		}
		return false;
	}
}
