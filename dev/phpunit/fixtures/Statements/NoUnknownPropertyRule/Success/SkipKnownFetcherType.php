<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoUnknownPropertyRule\Success;

use Rector\TypePerfect\Tests\Rules\NoMixedPropertyFetcherRule\Source\KnownType;

final class SkipKnownFetcherType {
	public function run( KnownType $knownType ) {
		$knownType->name;
	}
}
