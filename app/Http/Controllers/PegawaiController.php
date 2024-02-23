<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Laravel\Lumen\Routing\Controller as BaseController;

class PegawaiController extends BaseController
{

    public function find_pns_by_nip($nip)
    {
        $bearer = $this->get_token_mws();
        $auth = $this->get_token_sso();
        $client = new Client([
            'base_uri' => env('BKN_API_BASE_URL'),
        ]);
        $headers = [
            'authorization' => 'Bearer ' . $bearer,
            'auth' => 'Bearer ' . $auth
        ];
        $response = $client->request('GET', 'pns/data-utama/' . $nip, [
            'headers' => $headers,
        ]);
        $data =  json_decode($response->getBody(), true);
        return $data;
    }
    protected function get_token_mws()
    {
        $username = env('APIWMS_BKN_USERNAME');
        $password = env('APIWMS_BKN_PASSWORD');
        $grant_type = 'client_credentials';
        $client = new Client([
            'base_uri' => env('APIWMS_BKN_TOKEN_URL'),
        ]);
        $auth = [$username, $password];
        $body = [
            'grant_type' => $grant_type
        ];
        $response = $client->request('POST', '', [
            'auth' => $auth,
            'form_params' => $body
        ]);
        $data =  json_decode($response->getBody(), true);
        return $data['access_token'];
    }
    protected function get_token_sso()
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
        $data =  json_decode($response->getBody(), true);
        return $data['access_token'];
    }
}
