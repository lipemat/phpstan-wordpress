<?php
declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Rules\Test\Fixture\Internal\TemplatePartExistsRule\Failure\Theme\NonBacked;

enum TemplatePart {
	case BLOCKS__TEST;
	case HEADER__NAV;
	case EMAIL__DAILY_REPORT;
	case WOOCOMMERCE__TEST;
}
