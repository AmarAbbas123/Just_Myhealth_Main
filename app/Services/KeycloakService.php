<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KeycloakService
{
    private function base()
    {
        return config('services.keycloak.base_url');
    }

    private function realm()
    {
        return config('services.keycloak.realm');
    }

    public function getAdminToken()
    {
        $response = Http::asForm()->post(
            $this->base() . '/realms/' . $this->realm() . '/protocol/openid-connect/token',
            [
                'grant_type' => 'client_credentials',
                'client_id' => config('services.keycloak.admin_client'), 
                'client_secret' => config('services.keycloak.admin_secret'),
            ]
        );

        if (!$response->ok()) {
            Log::error('Keycloak admin token error', $response->json());
            return null;
        }

        return $response['access_token'] ?? null;
    }

    public function createUser($username, $email, $password, $firstName, $lastName)
    {
        $token = $this->getAdminToken();

        if (!$token) {
            return null;
        }

        $response = Http::withToken($token)->post(
            $this->base() . '/admin/realms/' . $this->realm() . '/users',
            [
                'username' => $username,
                'email' => $email,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'enabled' => true,
                'emailVerified' => true,
                'credentials' => [[
                    'type' => 'password',
                    'value' => $password,
                    'temporary' => false
                ]]
            ]
        );

        if ($response->status() != 201) {
            Log::error('Keycloak user creation failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;
        }

        $location = $response->header('Location');

        if (!$location) {
            return null;
        }

        $segments = explode('/', $location);

        return end($segments); // real keycloak UUID
    }

    public function loginDirectGrant($username, $password)
    {
        $response = Http::asForm()->post(
            $this->base() . '/realms/' . $this->realm() . '/protocol/openid-connect/token',
            [
                'grant_type' => 'password',
                'client_id' => config('services.keycloak.client_id'), 
                'client_secret' => config('services.keycloak.client_secret'),
                'username' => $username,
                'password' => $password,
                'scope' => 'openid profile email'
            ]
        );

        if (!$response->ok()) {
            Log::warning('Keycloak login failed', $response->json());
            return null;
        }

        return $response->json();
    }

    public function resetPassword($keycloakUserId, $newPassword)
    {
        $token = $this->getAdminToken();

        if (!$token) {
            return false;
        }

        $response = Http::withToken($token)->put(
            $this->base() . '/admin/realms/' . $this->realm() . '/users/' . $keycloakUserId . '/reset-password',
            [
                'type' => 'password',
                'value' => $newPassword,
                'temporary' => false
            ]
        );

        return $response->ok();
    }

    public function updateUser($keycloakUserId, array $data)
    {
        $token = $this->getAdminToken();
        if (!$token) return false;

        $response = Http::withToken($token)->put(
            $this->base() . '/admin/realms/' . $this->realm() . '/users/' . $keycloakUserId,
            $data
        );

        return $response->ok();
    }

    public function getAuthorizationUrl($redirectUri)
    {
        $url = $this->base() . "/realms/{$this->realm()}/protocol/openid-connect/auth";
        $params = http_build_query([
            'client_id' => config('services.keycloak.client_id'),
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid profile email',
        ]);

        return "{$url}?{$params}";
    }

    public function getTokenByAuthorizationCode($code, $redirectUri)
    {
        $response = Http::asForm()->post(
            $this->base() . "/realms/{$this->realm()}/protocol/openid-connect/token",
            [
                'grant_type' => 'authorization_code',
                'client_id' => config('services.keycloak.client_id'),
                'client_secret' => config('services.keycloak.client_secret'),
                'code' => $code,
                'redirect_uri' => $redirectUri,
            ]
        );

        return $response->ok() ? $response->json() : null;
    }

    public function getUserInfo($accessToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($this->base() . "/realms/{$this->realm()}/protocol/openid-connect/userinfo");

        return $response->ok() ? $response->json() : null;
    }
}
