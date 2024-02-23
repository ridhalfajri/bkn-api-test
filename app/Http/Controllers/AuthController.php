<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function get_token_mws()
    {
        $username = env('APIWMS_BKN_USERNAME');
        $password = env('APIWMS_BKN_PASSWORD');
        $grant_type = 'client_credentials';
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('APIWMS_BKN_TOKEN_URL'),
            // You can set any number of default request options.
            // 'timeout'  => 2.0,
        ]);
        $auth = [$username, $password];
        $body = [
            'grant_type' => $grant_type
        ];
        $response = $client->request('POST', '', [
            'auth' => $auth,
            'form_params' => $body
        ]);

        return response()->json([
            'response' => json_decode($response->getBody(), true),
        ]);
    }
    public function get_token_sso()
    {
        $client_id = env('SSO_SIASN_CLIENT_ID');
        $grant_type = env('SSO_SIASN_GRANT_TYPE');
        $username = env('SSO_SIASN_USERNAME');
        $password = env('SSO_SIASN_PASSWORD');
        $client = new Client([
            'base_uri' => env('SSO_SIASN_TOKEN_URL'),
        ]);
        $auth = [$username, $password];
        $body = [
            'client_id' => $client_id,
            'grant_type' => $grant_type,
            'username' => $username,
            'password' => $password,
        ];
        $response = $client->request('POST', '', [
            'form_params' => $body
        ]);
        return response()->json([
            'response' => json_decode($response->getBody(), true),
        ]);
    }
}
