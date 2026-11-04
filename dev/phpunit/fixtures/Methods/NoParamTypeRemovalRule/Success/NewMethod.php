<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Success;

class NewMethod extends TypedParent {
	public function notInParent( $value ): void {
	}
}
