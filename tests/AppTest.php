<?php

namespace Tests;

use App\Models\User;

class AppTest extends TestCase
{
    protected function login($user = null)
    {
        $user = $user ?? create(User::class);
        
        return $this->actingAs($user, 'web');
    }

    protected function logout()
    {
        \Auth::logout();
    }
}