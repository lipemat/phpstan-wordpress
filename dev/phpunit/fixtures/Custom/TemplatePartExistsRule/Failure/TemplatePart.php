<?php
declare( strict_types=1 );

namespace Lipe\Project\Theme;

enum TemplatePart: string {
	case BLOCKS__TEST        = 'blocks/test';
	case HEADER__NAV         = 'header/nav';
	case EMAIL__DAILY_REPORT = 'email/daily-report';
	case WOOCOMMERCE__TEST   = '../woocommerce/test';
}
