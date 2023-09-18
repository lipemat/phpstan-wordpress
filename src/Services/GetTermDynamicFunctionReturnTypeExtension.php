<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

/**
 * The `get_term` function returns different results based on the arguments passed
 * to the function.
 *
 * @author Mat Lipe
 * @since  2.7.0
 *
 * @todo Consider submitting a pull request to `szepeviktor/phpstan-wordpress`
 *
 */
class GetTermDynamicFunctionReturnTypeExtension implements DynamicFunctionReturnTypeExtension {
	protected static $supported = [
		'get_term',
	];

	protected static function termsType() : Type {
		return TypeCombinator::union(
			new ObjectType( 'WP_Term' ),
			new ObjectType( 'WP_Error' )
		);
	}


	public function isFunctionSupported( FunctionReflection $functionReflection ) : bool {
		return \in_array( $functionReflection->getName(), static::$supported );
	}


	/**
	 * - Return `string[]` if default or `$output = 'names'`.
	 * - Return `WP_Post_Type[]` if `$output` is anything but 'names';
	 *
	 * @link https://developer.wordpress.org/reference/functions/get_post_types/#parameters
	 */
	public function getTypeFromFunctionCall( FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope ) : ?Type {
		$args = $functionCall->getArgs();

		if ( count( $args ) < 3 ) {
			return static::termsType();
		}

		$argumentType = $scope->getType( $args[2]->value );
		if ( count( $argumentType->getConstantStrings() ) === 1 ) {
			switch ( $argumentType->getConstantStrings()[0]->getValue() ) {
				case 'ARRAY_A':
					$returnType[] = new ArrayType( new StringType(), new MixedType() );
					break;
				case 'ARRAY_N':
					$returnType[] = new ArrayType( new IntegerType(), new MixedType() );
					break;
				default:
					return static::termsType();
			}

			$returnType[] = new ObjectType( 'WP_Error' );
			return TypeCombinator::union( ...$returnType );
		}

		return static::termsType();
	}
}
