<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

/**
 * The `get_term_by` function returns different results based on the arguments passed
 * to the function.
 *
 * @author Mat Lipe
 * @since  2.7.0
 *
 * @link https://github.com/php-stubs/wordpress-stubs/pull/105
 * @todo Remove when pull request is merged and new version is available.
 */
class GetTermByDynamicFunctionReturnTypeExtension implements DynamicFunctionReturnTypeExtension {
	protected static $supported = [
		'get_term_by',
	];


	protected static function termsType(): Type {
		return TypeCombinator::union(
			new ObjectType( 'WP_Term' ),
			new ObjectType( 'WP_Error' ),
			new ConstantBooleanType( \false )
		);
	}


	public function isFunctionSupported( FunctionReflection $functionReflection ): bool {
		return \in_array( $functionReflection->getName(), static::$supported );
	}


	/**
	 * - Return `array<int|string>` if `$output = 'ARRAY_N`.
	 * - Return `array<string, int|string>` if default or `$output = 'ARRAY_A`.
	 * - Return `WP_Term` if default or `$output` is 'OBJECT';
	 *
	 * @link https://developer.wordpress.org/reference/functions/get_term_by/#parameters
	 */
	public function getTypeFromFunctionCall( FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope ): ?Type {
		$args = $functionCall->getArgs();

		if ( count( $args ) < 4 ) {
			return static::termsType();
		}

		$value = TypeCombinator::union(
			new StringType(),
			new IntegerType()
		);
		$argumentType = $scope->getType( $args[3]->value );
		if ( count( $argumentType->getConstantStrings() ) === 1 ) {
			switch ( $argumentType->getConstantStrings()[0]->getValue() ) {
				case 'ARRAY_A':
					$returnType[] = new ArrayType( new StringType(), $value );
					break;
				case 'ARRAY_N':
					$returnType[] = new ArrayType( new IntegerType(), $value );
					break;
				default:
					return static::termsType();
			}

			$returnType[] = new ObjectType( 'WP_Error' );
			$returnType[] = new ConstantBooleanType( \false );
			return TypeCombinator::union( ...$returnType );
		}

		return static::termsType();
	}
}
