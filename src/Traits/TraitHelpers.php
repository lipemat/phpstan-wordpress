<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Traits;

use PHPStan\Type\ObjectType;

trait TraitHelpers {
	private function hasTrait( ObjectType $objectType, string $traitName ): bool {
		$classReflection = $objectType->getClassReflection();
		if ( null === $classReflection ) {
			return false;
		}

		$traits = $classReflection->getTraits( true );

		foreach ( $traits as $trait ) {
			if ( $trait->getName() === $traitName ) {
				return true;
			}
		}

		return false;
	}
}
