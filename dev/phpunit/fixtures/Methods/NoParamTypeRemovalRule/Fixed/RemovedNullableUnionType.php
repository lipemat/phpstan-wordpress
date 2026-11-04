<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Failure;

use Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Success\TypedParent;

class RemovedNullableUnionType extends TypedParent {
	public function nullableUnion( int|string|null $value ): void {
	}
}
