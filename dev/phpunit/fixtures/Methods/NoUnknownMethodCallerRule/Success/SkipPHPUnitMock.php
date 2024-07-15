<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoUnknownMethodCallerRule\Success;

use PHPUnit\Framework\TestCase;
use Rector\TypePerfect\Tests\Rules\NoMixedMethodCallerRule\Source\SomeFinalClass;

final class SkipPHPUnitMock extends TestCase {
	public function test() {
		$someClassMock = $this->createMock( SomeFinalClass::class );

		$someClassMock->expects( $this->once() )
		              ->method( 'some' )
		              ->with( $this->any() )
		              ->willReturn( 1000 );
	}
}
