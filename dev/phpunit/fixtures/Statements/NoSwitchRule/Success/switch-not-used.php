<?php

declare( strict_types=1 );

if ( 'foo' === $foo ) {
	return 'It is foo!';
}

if ( 'bar' === $foo ) {
	return 'It is bar!';
}

match ( $foo ) {
	'foo' => 'It is foo!',
	'bar' => 'It is bar!',
	default => 'It is something else!',
};
