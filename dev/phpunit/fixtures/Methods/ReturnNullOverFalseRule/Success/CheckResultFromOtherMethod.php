<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\ReturnNullOverFalseRule\Success;

class CheckResultFromOtherMethod {
	/**
	 * @return bool
	 */
	public function exists( string $name ) {
		if ( ! $this->loadFromDb( $name ) ) {
			return false;
		}

		return true;
	}


	private function loadFromDb( string $name ): ?array {
		if ( mt_rand( 1, 0 ) ) {
			return null;
		}

		return [ 'test' => 'foo' ];
	}
}
