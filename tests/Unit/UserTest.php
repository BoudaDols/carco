<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    public function test_user_has_fillable_attributes()
    {
        $user = new User();
        
        $this->assertEquals([
            'name',
            'email',
            'active',
        ], $user->getFillable());
    }

    public function test_user_has_hidden_attributes()
    {
        $user = new User();
        
        $this->assertEquals([
            'remember_token',
        ], $user->getHidden());
    }

    public function test_user_password_is_hashed()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_user_active_is_cast_to_boolean()
    {
        $user = User::factory()->create(['active' => 1]);
        
        $this->assertIsBool($user->active);
        $this->assertTrue($user->active);
    }
}