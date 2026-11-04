<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Failure;

use Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Success\TypedParent;

class RemovedNullableIntersectionType extends TypedParent {
	public function nullableIntersection( (\Countable&\Traversable)|null $value ): void {
	}
}
