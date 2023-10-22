<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\FinalInAbstractClassRule\Failure;

abstract class AbstractClassWithProtectedMethod {
	protected function method(): void {
	}
}
