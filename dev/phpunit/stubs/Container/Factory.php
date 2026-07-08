<?php

declare( strict_types=1 );

namespace Lipe\Lib\Container;

/**
 * Minimal stub of the `Factory` trait from `lipemat/wordpress-libs`
 * for exercising the `FactorizeConstructorArgsRule`.
 *
 * Intentionally omits the `@template CONSTRUCT_PARAMS` annotation, which is
 * the annotation the rule makes redundant.
 */
trait Factory {
	protected static function factorize( ...$construct_args ): static {
		return new static( ...$construct_args );
	}
}
