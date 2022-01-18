<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\User;

class UserTest extends AppTest
{
    /** @test */
    public function users_can_create_an_account()
    {
        $request = make(User::class);

        $this->post(route('register'), $request);

        $this->assertDatabaseHas('users', ['name' => $request->name]);
    }
}
