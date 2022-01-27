<?php

namespace Tests\Traits;

trait Loggedin
{
    public function setUp() : void
    {
        parent::setUp();

        $this->login();
    }
}