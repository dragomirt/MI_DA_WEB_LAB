<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_generateApiTokens() {
        $user = User::factory()->create();
        $tokens = $user->tokens;
        self::assertCount(0, $tokens);

        $token = $user->generateApiToken();
        self::assertIsString($token);

        $user = User::find($user->id)->first();
        $tokens = $user->tokens;
        self::assertCount(1, $tokens);
    }
}
