<?php

declare( strict_types=1 );

namespace Lipe\Lib\Phpstan\Services;

use Lipe\Project\Security\Plugin_Endpoint\TestDb;
use function PHPStan\Testing\assertType;

// All columns via "*"
assertType( 'object{user_id: string, content_id: string, content_type: string, amount: string, date: string}|null', ( new TestDb() )->get( '*', [], 1 ) );
assertType( 'array<int, object{user_id: string, content_id: string, content_type: string, amount: string, date: string}>|null', ( new TestDb )->get( '*', [], 10 ) );
assertType( 'array<int, object{user_id: string, content_id: string, content_type: string, amount: string, date: string}>|null', ( new TestDb )->get( '*' ) );

// Partial columns
assertType( 'array<int, object{user_id: string, amount: string}>|null', ( new TestDb )->get( 'user_id, amount', [], 10 ) );
assertType( 'array<int, object{content_type: string, date: string}>|null', ( new TestDb )->get( 'content_type,date' ) );
assertType( 'array<int, object{content_type: string, date: string}>|null', ( new TestDb )->get( 'content_type,date' ) );

// Single column
assertType( 'string|null', ( new TestDb )->get( 'one-column', [], 1 ) );
assertType( 'array<int, string>', ( new TestDb )->get( 'one-column', [], 10 ) );
