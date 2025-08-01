<?php
declare( strict_types=1 );

use PHPStan\Rules\Rule;

trait StaticRule {
	protected static Rule $rule;


	/**
	 * Share the same rule object for all fixtures to discover
	 * side effects.
	 *
	 * @param Rule $rule
	 *
	 * @return Rule
	 */
	final protected static function staticRule( Rule $rule ): Rule {
		if ( ! isset( self::$rule ) ) {
			self::$rule = $rule;
		}
		return self::$rule;
	}
}
