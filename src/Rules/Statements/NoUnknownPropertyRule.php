<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Statements;

use Lipe\Lib\Phpstan\Traits\UnknownSubjectError;
use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PHPStan\Analyser\Scope;
use PHPStan\DependencyInjection\RegisteredRule;
use PHPStan\Rules\Rule;
use PHPStan\Type\MixedType;

/**
 * Prevent using property fetch on an unknown object.
 *
 * Level 6 is where PHPStan starts requiring the missing types.
 *
 * @implements Rule<PropertyFetch>
 */
#[RegisteredRule( level: 6 )]
class NoUnknownPropertyRule implements Rule {
	use UnknownSubjectError;

	/**
	 * @var string
	 */
	public const ERROR_MESSAGE = 'Accessing `%s` property on unknown `%s` can skip important errors. Make sure the type is known.';


	public function getNodeType(): string {
		return PropertyFetch::class;
	}


	public function processNode( Node $node, Scope $scope ): array {
		$callerType = $scope->getType( $node->var );
		if ( ! $callerType instanceof MixedType ) {
			return [];
		}

		return [
			$this->unknownSubjectError( $node, self::ERROR_MESSAGE, 'lipemat.noUnknownProperty' ),
		];
	}
}
