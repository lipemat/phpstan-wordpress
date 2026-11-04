<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Success;

class KeptParamTypes extends TypedParent {
	public function scalar( string $value ): void {
	}


	public function nullableUnion( int|string|null $value ): void {
	}
}
