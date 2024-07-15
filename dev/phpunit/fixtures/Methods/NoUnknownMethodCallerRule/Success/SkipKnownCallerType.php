<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\NoUnknownMethodCallerRule\Success;

use Rector\TypePerfect\Tests\Rules\NoMixedMethodCallerRule\Source\KnownType;

final class SkipKnownCallerType {
	public function run( KnownType $knownType ) {
		$knownType->call();
	}
}
