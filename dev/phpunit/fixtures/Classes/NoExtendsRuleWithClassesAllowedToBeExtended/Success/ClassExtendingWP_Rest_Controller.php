<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Classes\NoExtendsRuleWithClassesAllowedToBeExtended\Success;

/**
 * @author Mat Lipe
 * @since  October 2023
 *
 */
final class ClassExtendingWP_Rest_Controller extends \WP_REST_Controller {

}
