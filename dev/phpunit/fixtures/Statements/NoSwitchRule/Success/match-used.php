<?php

declare( strict_types=1 );

match ( $foo ) {
	'foo' => 'It is foo!',
	'bar' => 'It is bar!',
	default => 'It is something else!',
};
