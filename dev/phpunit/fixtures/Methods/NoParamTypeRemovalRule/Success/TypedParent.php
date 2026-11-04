<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Success;

class TypedParent {
	public function scalar( string $value ): void {
	}


	public function nullable( ?int $value ): void {
	}


	public function union( int|string $value ): void {
	}


	public function nullableUnion( int|string|null $value ): void {
	}


	public function object( Service $value ): void {
	}


	public function self( self $value ): void {
	}


	public function intersection( \Countable&\Traversable $value ): void {
	}


	public function nullableIntersection( (\Countable&\Traversable)|null $value ): void {
	}


	public function second( string $first, int $second ): void {
	}


	public function untyped( $value ): void {
	}


	public function mixed( mixed $value ): void {
	}
}
