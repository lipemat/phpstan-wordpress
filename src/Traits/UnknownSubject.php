<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Traits;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * Error for a method call or property fetch on an unknown subject.
 */
trait UnknownSubject {
	/**
	 * @param string $message    - `sprintf` format receiving the member name, then the subject.
	 * @param string $identifier - Error identifier.
	 *
	 * @phpstan-return IdentifierRuleError
	 *
	 * @throws ShouldNotHappenException
	 */
	private function unknownSubjectError( MethodCall|PropertyFetch $node, string $message, string $identifier ): RuleError {
		$ruleErrorBuilder = RuleErrorBuilder::message(
			\sprintf(
				$message,
				$this->memberName( $node ),
				( new Standard() )->prettyPrintExpr( $node->var )
			)
		);

		$ruleErrorBuilder->addTip( 'Try checking `instanceof` first.' );
		return $ruleErrorBuilder->identifier( $identifier )->build();
	}


	/**
	 * `$subject->$method()` reports the variable's name.
	 */
	private function memberName( MethodCall|PropertyFetch $node ): string {
		if ( $node->name instanceof Identifier ) {
			return $node->name->name;
		}
		if ( $node->name instanceof Variable && \is_string( $node->name->name ) ) {
			return $node->name->name;
		}
		return 'unknown';
	}
}
