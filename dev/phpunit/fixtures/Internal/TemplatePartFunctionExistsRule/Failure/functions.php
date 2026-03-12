<?php
declare( strict_types=1 );

lipe_template_part( 'header/nav' );
lipe_template_contents( 'blocks/test' );
lipe_template_part( 'email/daily-report' );
lipe_template_contents( '../woocommerce/test' );
