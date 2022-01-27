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

        $this->post(route('register'), [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password
        ]);

        $this->assertDatabaseHas('users', ['name' => $request->name]);
    }
}
