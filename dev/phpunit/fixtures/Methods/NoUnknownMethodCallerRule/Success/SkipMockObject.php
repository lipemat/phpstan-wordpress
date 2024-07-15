<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoUnknownMethodCallerRule\Success;

use PHPUnit\Framework\TestCase;

final class SkipMockObject extends TestCase {
	public function test() {
		$mock = $this->createMock( MagicMethodName::class );

		$mock
			->method( 'run' )
			->willReturn( true );
	}
}
