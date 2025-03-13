<?php

namespace Tests\Unit;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testRegister()
    {
        $request = Request::create('/register', 'POST', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'client',
        ]);

        $controller = new AuthController();
        $response = $controller->register($request);

        $this->assertEquals(201, $response->status());
        $this->assertArrayHasKey('token', $response->getData(true));
        $this->assertArrayHasKey('user', $response->getData(true));
    }

    public function testLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $controller = new AuthController();
        $response = $controller->login($request);

        $this->assertArrayHasKey('token', $response->getData(true));
        $this->assertArrayHasKey('user', $response->getData(true));
    }

    public function testLoginWithInvalidCredentials()
    {
        $request = Request::create('/login', 'POST', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);

        $this->expectException(ValidationException::class);

        $controller = new AuthController();
        $controller->login($request);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $request = Request::create('/logout', 'POST', []);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $controller = new AuthController();
        $response = $controller->logout($request);

        $this->assertEquals('Logged out successfully', $response->getData(true)['message']);
    }
}
