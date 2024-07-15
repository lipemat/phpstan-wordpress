<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Methods\ReturnNullOverFalseRule\Success;

class CheckResultFromOtherMethod2 {
	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function __isset( $name ) {
		if ( ! $this->isPropertyVisible( $name ) ) {
			return false;
		}

		return isset( $this->$name );
	}


	private function isPropertyVisible( string $name ): bool {
		if ( mt_rand( 1, 0 ) ) {
			return true;
		}

		return false;
	}
}
