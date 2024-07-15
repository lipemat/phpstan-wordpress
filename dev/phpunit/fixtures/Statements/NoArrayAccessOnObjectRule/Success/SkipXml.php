<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Success;

use SimpleXMLElement;

final class SkipXml {
	public function run( SimpleXMLElement $values ) {
		return $values['key'];
	}
}
