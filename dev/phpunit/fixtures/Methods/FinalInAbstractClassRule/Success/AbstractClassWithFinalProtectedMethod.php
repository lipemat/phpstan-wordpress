<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\FinalInAbstractClassRule\Success;

abstract class AbstractClassWithFinalProtectedMethod {
	final protected function method(): void {
	}
}
