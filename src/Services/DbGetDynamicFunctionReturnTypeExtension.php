<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectShapeType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

/**
 * Compile the return type for the `Db::get` method based on the
 * user provided arguments.
 *
 * You can see from the complexity of this service the `Db::get` method,
 * and the `Db` class in general could use some rewriting which will happen
 * at some point to remove inheritance.
 *
 * For now this service provided a good reference for the various ways
 * to interact with classes, inheritance and arguments.
 *
 * @author Mat Lipe
 * @since  2.8.0
 *
 */
class DbGetDynamicFunctionReturnTypeExtension implements DynamicMethodReturnTypeExtension {
	/**
	 * @var string[]
	 */
	protected static $supported = [
		'get',
	];

	/**
	 * @var ReflectionProvider
	 */
	private $reflectionProvider;


	public function __construct( ReflectionProvider $reflectionProvider ) {
		$this->reflectionProvider = $reflectionProvider;
	}


	/**
	 * Used by PHPStan to determine which class this service supports.
	 *
	 * @return string
	 */
	public function getClass(): string {
		return 'Lipe\Lib\Schema\Db';
	}


	/**
	 * Used by PHPStan to determine which methods this service supports.
	 *
	 * @param MethodReflection $methodReflection
	 *
	 * @return bool
	 */
	public function isMethodSupported( MethodReflection $methodReflection ): bool {
		return \in_array( $methodReflection->getName(), static::$supported, true );
	}


	/**
	 * The method that is called by PHPStan to determine the return type.
	 *
	 * @param MethodReflection $methodReflection
	 * @param MethodCall       $methodCall
	 * @param Scope            $scope
	 *
	 * @return Type|null
	 */
	public function getTypeFromMethodCall( MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope ): ?Type {
		$args = $methodCall->getArgs();
		$columnsArg = $scope->getType( $args[0]->value );
		if ( ! isset( $args[2] ) ) {
			return $this->defaultType( $columnsArg, $methodCall );
		}

		$countType = $scope->getType( $args[2]->value );
		if ( $countType->isInteger()->yes() && 1 === $countType->getConstantScalarValues()[0] ) {
			if ( $this->isMulitipleColumns( $columnsArg ) ) {
				return TypeCombinator::union(
					new NullType(),
					new ObjectShapeType( $this->getClassColumns( $methodCall, $columnsArg ), [] )
				);
			} else {
				return TypeCombinator::union(
					new NullType(),
					new StringType()
				);
			}
		}

		return $this->defaultType( $columnsArg, $methodCall );
	}


	/**
	 * The default return type for the `Db::get` method.
	 *
	 * @param Type       $columns
	 * @param MethodCall $methodCall
	 *
	 * @return Type
	 */
	protected function defaultType( Type $columns, MethodCall $methodCall ): Type {
		if ( $this->isMulitipleColumns( $columns ) ) {
			return TypeCombinator::union(
				new NullType(),
				new ArrayType( new IntegerType(), new ObjectShapeType( $this->getClassColumns( $methodCall, $columns ), [] ) )
			);
		}

		return new ArrayType( new IntegerType(), new StringType() );
	}


	/**
	 * Get the columns provided by the user as the for $columns argument.
	 *
	 * @param Type $columnsArg
	 *
	 * @return array<string>|null
	 */
	protected function getUserColumns( Type $columnsArg ): ?array {
		$columns = $columnsArg->getConstantScalarValues()[0];
		if ( false !== \strpos( (string) $columns, '*' ) ) {
			return null;
		}
		return \array_map( '\trim', \explode( ',', (string) $columns ) );
	}


	/**
	 * Determine if the user provided a set of columns or the "*" wildcard.
	 *
	 * @param Type $columnsArg
	 *
	 * @return bool
	 */
	protected function isMulitipleColumns( Type $columnsArg ): bool {
		$columns = $columnsArg->getConstantScalarValues()[0];
		if ( false !== \strpos( (string) $columns, '*' ) || false !== \strpos( (string) $columns, ',' ) ) {
			return true;
		}
		return false;
	}


	/**
	 * Get the columns assigned to the class via the `COLUMNS` class constant.
	 *
	 * If a user provided a set other than '*' then we limit the return to those columns.
	 *
	 * @note This method provides a good example of working with class inheritance.
	 *
	 * @param MethodCall $methodCall
	 * @param Type       $columnsArg
	 *
	 * @return array<string, Type>
	 */
	protected function getClassColumns( MethodCall $methodCall, Type $columnsArg ): array {
		if ( ! isset( $methodCall->var->class ) || ! $methodCall->var->class instanceof FullyQualified ) {
			return [];
		}
		$className = $methodCall->var->class->toString();
		$childClass = $this->reflectionProvider->getClass( $className );
		if ( ! $childClass->hasConstant( 'COLUMNS' ) ) {
			return [];
		}
		$childClass = $childClass->getConstant( 'COLUMNS' )->getValueExpr();
		$columns = [];
		if ( property_exists( $childClass, 'items' ) && 0 < \count( $childClass->items ) ) {
			foreach ( $childClass->items as $values ) {
				$columns[ (string) $values->key->value ] = new StringType();
			}
		}

		$userColumns = $this->getUserColumns( $columnsArg );
		if ( null !== $userColumns ) {
			$columns = \array_intersect_key( $columns, \array_flip( $userColumns ) );
		}
		return $columns;
	}


	/**
	 * For future use if we ever add validation to the `where` column argument.
	 * Probaly not part of this class because it is not a return, but rather
	 * what is passed to the `where` argument.
	 *
	 * @todo Look into validating the `where` argument.
	 *
	 * @param string $valueType
	 *
	 * @return Type
	 */
	protected function mapColumnToType( string $valueType ): Type {
		switch ( $valueType ) {
			case '%d':
				return new IntegerType();
			case '%f':
				return new FloatType();
			default:
				return new StringType();
		}
	}
}
