<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Failure;

use Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Success\TypedParent;

class RemovedSecondParamType extends TypedParent {
	public function second(
		string $first,
		int $second
	): void {
	}
}
