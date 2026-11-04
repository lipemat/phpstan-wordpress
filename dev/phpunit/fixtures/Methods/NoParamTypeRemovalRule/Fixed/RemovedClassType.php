<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Failure;

use Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Success\Service;
use Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Success\TypedParent;

class RemovedClassType extends TypedParent {
	public function object( Service $value ): void {
	}
}
