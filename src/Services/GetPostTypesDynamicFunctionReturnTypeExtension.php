<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;

/**
 * The `get_post_types` function returns different results based on the
 * arguments passed to the function.
 *
 * @author Mat Lipe
 * @since  2.6.0
 *
 * @todo   Remove this extension if the pull request gets merged and released upstream
 *
 * @link   https://github.com/szepeviktor/phpstan-wordpress/pull/177
 * @link   https://phpstan.org/developing-extensions/dynamic-return-type-extensions
 *
 */
class GetPostTypesDynamicFunctionReturnTypeExtension implements DynamicFunctionReturnTypeExtension {
	public function isFunctionSupported( FunctionReflection $functionReflection ) : bool {
		return $functionReflection->getName() === 'get_post_types';
	}


	/**
	 * - Return `string[]` if default or `$output = 'names'`.
	 * - Return `WP_Post_Type[]` if `$output` is anything but 'names';
	 *
	 * @link https://developer.wordpress.org/reference/functions/get_post_types/#parameters
	 */
	public function getTypeFromFunctionCall( FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope ) : ?Type {
		$args = $functionCall->getArgs();

		if ( count( $args ) < 2 ) {
			return new ArrayType( new IntegerType(), new StringType() );
		}

		$argumentType = $scope->getType( $args[1]->value );
		if ( count( $argumentType->getConstantStrings() ) === 1 ) {
			if ( 'names' === $argumentType->getConstantStrings()[0]->getValue() ) {
				return new ArrayType( new IntegerType(), new StringType() );
			}
		}

		return new ArrayType( new IntegerType(), new ObjectType( 'WP_Post_Type' ) );
	}
}
