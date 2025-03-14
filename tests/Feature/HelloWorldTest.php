<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('hello world!', function () {
    expect('Hello, World!')->toBe('Hello, World!');
});