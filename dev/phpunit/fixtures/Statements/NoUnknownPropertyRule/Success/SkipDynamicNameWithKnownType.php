<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoUnknownPropertyRule\Success;

use Rector\TypePerfect\Tests\Rules\NoMixedPropertyFetcherRule\Source\KnownType;

final class SkipDynamicNameWithKnownType {
	public function runOnType( KnownType $knownType ) {
		$knownType->{$name};
	}
}
