<?php

namespace Tests;

use Tests\Support\ExceptionHandling;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, ExceptionHandling;

    public function setUp() : void
    {
        parent::setUp();

        $this->disableExceptionHandling();
    }
}

// PROJECT
// name
// description
// creator + team
// template

// FOLDERS
// many revisions
// limbo
// when adding a new subfolder, the the revisions are moved to the limbo of that original folder
// new folders ask for creator's approval

// FILES
// name (auto-generate)
// description
// comments (chat)
// supporting files (file, folder, links, email)
// activity log