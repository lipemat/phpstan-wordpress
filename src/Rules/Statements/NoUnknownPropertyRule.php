<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Statements;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\Scope;
use PHPStan\Rules;
use PHPStan\Rules\Rule;
use PHPStan\Type\MixedType;

/**
 * Prevent using property fetch on an unknown object.
 *
 * @implements Rule<PropertyFetch>
 */
class NoUnknownPropertyRule implements Rule {
	/**
	 * @var ?Standard
	 */
	private $printerStandard;

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

		if ( ! $this->printerStandard instanceof Standard ) {
			$this->printerStandard = new Standard();
		}

		$ruleErrorBuilder = Rules\RuleErrorBuilder::message(
			\sprintf(
				self::ERROR_MESSAGE,
				$node->name->name ?? 'unknown',
				$this->printerStandard->prettyPrintExpr( $node->var )
			)
		);

		$ruleErrorBuilder->addTip( 'Try checking `instanceof` first.' );
		$ruleErrorBuilder->identifier( 'lipemat.noUnknownProperty' );

		return [
			$ruleErrorBuilder->build(),
		];
	}
}
