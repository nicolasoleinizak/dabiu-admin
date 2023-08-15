<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

class WCCredentialTest extends TestCase
{
    use RefreshDatabase;

    public function test_credential_creation(): void
    {
        $token = $this->getToken();

        $body = [
          'url' => 'https://testurl.com',
          'username' => 'username',
          'password' => 'password',
        ];

        $credential_creation_response = $this->createCredential($body, $token);
        
        $credential_creation_response->assertStatus(200);

        $credential_creation_response->assertJsonIsObject();

        $credential_creation_response->assertJson(fn (AssertableJson $json) => 
        $json
            ->has('message')
            ->where('message', 'Credential created')
        );
    }

    public function test_credential_update(): void
    {
        $token = $this->getToken();

        $body = [
          'url' => 'https://testurl.com',
          'username' => 'username',
          'password' => 'password',
        ];

        $credential_creation_response = $this->createCredential($body, $token);

        $body['password'] = 'new password';
  
        $credential_update_response = $this->createCredential($body, $token);
        
        $credential_update_response->assertStatus(200);

        $credential_update_response->assertJsonIsObject();

        $credential_update_response->assertJson(fn (AssertableJson $json) =>
        $json
            ->has('message')
            ->where('message', 'Credential updated')
        );
    }

    public function test_credential_check(): void
    {
        $token = $this->getToken();

        $body = [
          'url' => 'https://testurl.com',
          'username' => 'username',
          'password' => 'password',
        ];

        
        $credential_check_response = $this->checkCredential($token);
        
        $credential_check_response->assertStatus(200);

        $credential_check_response->assertJsonIsObject();
        
        $credential_check_response->assertJson(fn (AssertableJson $json) => 
            $json
            ->where('credential', ['exists' => false])
        );

        $credential_creation_response = $this->createCredential($body, $token);

        $credential_check_response = $this->checkCredential($token);
        
        $credential_check_response->assertStatus(200);

        $credential_check_response->assertJsonIsObject();

        $credential_check_response->assertJson(fn (AssertableJson $json) => 
            $json
            ->where('credential', ['exists' => true])
        );
    }

    private function getToken() {
        $email = 'test@test.com';
        $password = 'password123';
        
        $this->user = User::create([
            'company' => 'Test company',
            'password' => $password,
            'email' => $email,
        ]);
        
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
                        
        $token = $response->baseResponse->original['authorization']['token'];
        return $token;
    }
                
    private function createCredential($body, $token) {
        $response = $this
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
                ])
            ->postJson(
                '/api/credentials/wc',
                [
                    'url' => $body['url'],
                    'username' => $body['username'],
                    'password' => $body['password'],
                ]
                );
        return $response;
    }

    private function checkCredential($token) {
        $response = $this
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
                ])
            ->getJson(
                '/api/credentials/wc/check'
                );
        return $response;
    }
}
            