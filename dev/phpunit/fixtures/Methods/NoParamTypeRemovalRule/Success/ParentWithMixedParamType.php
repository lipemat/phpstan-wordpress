<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoParamTypeRemovalRule\Success;

class ParentWithMixedParamType extends TypedParent {
	public function mixed( $value ): void {
	}
}
