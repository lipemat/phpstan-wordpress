<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Statements\NoArrayAccessOnObjectRule\Success;

use SimpleXMLElement;

final class SkipXmlElementForeach {
	public function run( SimpleXMLElement $simpleXMLElement ) {
		foreach ( $simpleXMLElement->children() as $name => $childElement ) {
			return isset( $childElement['some'] );
		}
	}
}
