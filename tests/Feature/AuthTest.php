<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_right_credentials(): void
    {
      $email = 'test@test.com';
      $company = 'Test User';
      $password = '12345678';

      $this->createUser($email, $company, $password);

      $login_response = $this->login($email, $password);

      $login_response->assertStatus(200);

      $login_response->assertJson(fn (AssertableJson $json) =>
        $json->has('user', fn(AssertableJson $user) =>
          $user
            ->has('company')
            ->has('email')
            ->has('id')
            ->etc()
        )
        ->has('authorization', fn(AssertableJson $authorization) =>
          $authorization
            ->has('token')
            ->has('type')
        )
      );
    }

    public function test_login_with_wrong_credentials()
    {
      $email = 'test@test.com';
      $company = 'Test User';
      $password = '12345678';

      $this->createUser($email, $company, $password);

      $response = $this->login($email, 'wrong_password');

      $response->assertStatus(401);
    }

    public function test_user_registration()
    {
      $email = 'test@test.com';
      $company = 'Test User';
      $password = '12345678';

      $response = $this->register($email, $company, $password);

      $response->assertStatus(200);

      $response->assertJson(fn (AssertableJson $json) =>
        $json
          ->where('message', 'User created successfully')
          ->has('user', (fn (AssertableJson $user) =>
            $user
              ->where('company', $company)
              ->where('email', $email)
              ->has('id')
              ->etc()
          ))
      );

      $login_response = $this->login($email, $password);

      $login_response->assertStatus(200);
    }

    private function createUser($email, $company, $password)
    {
      $this->user = User::create([
          'company' => 'Test user',
          'password' => $password,
          'email' => $email,
      ]);
    }

    private function login($email, $password) {
        $response = $this
        ->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
            ])
                    ->postJson(
                        '/api/login',
                        [
                            'email' => $email,
                            'password' => $password,
                            ]
                        );
                        
        return $response;
    }

    private function register($email, $company, $password) {
      $response = $this
      ->withHeaders([
          'Content-Type' => 'application/json',
          'Accept' => 'application/json'
          ])
                  ->postJson(
                      '/api/register',
                      [
                          'email' => $email,
                          'company' => $company,
                          'password' => $password,
                          ]
                      );
                      
      return $response;
  }
}
            