<?php
/**
 * @name: GoogleAuth
 * @type: Auth API Handler
 * @namespace: Sadiq
 * @author: Sadiq <sadiq.developer.bd@gmail.com>
 */

namespace Sadiq;

class GoogleAuth {

    private $oauth_client_id = '';
    private $oauth_client_secret = '';
    private $oauth_redirect_uri = '';
    private $oauth_version = '';

    private $access_token = '';

    private $fetchResponse = '';
    
    private $errorInfo = '';

    public function __construct(
        string $client_id = '',
        string $client_secret = '',
        string $redirect_uri = '',
        string $version = 'v3'
    ) {

        $this->oauth_client_id = $client_id;

        $this->oauth_client_secret = $client_secret;

        $this->oauth_redirect_uri = $redirect_uri;

        $this->oauth_version = $version;
     
    }

    public function setClientId(string $client_id) {

        $this->oauth_client_id = $client_id;
    
    }

    public function setClientSecret(string $client_secret) {

        $this->oauth_client_secret = $client_secret;
    
    }

    public function setRedirectUri(string $redirect_uri) {

        $this->oauth_redirect_uri = $redirect_uri;
    
    }

    public function setAccessToken(string $token) {

        $this->access_token = $token;
    
    }

    public function createAuthUrl() {

        return 'https://accounts.google.com/o/oauth2/auth?' .
                http_build_query([
                    'response_type' => 'code',
                    'client_id' => $this->oauth_client_id,
                    'redirect_uri' => $this->oauth_redirect_uri,
                    'scope' => implode(' ', [
                        'https://www.googleapis.com/auth/userinfo.email',
                        'https://www.googleapis.com/auth/userinfo.profile'
                    ]),
                    'access_type' => 'offline',
                    'prompt' => 'consent'
                ]);

    }

    public function redirectToAuthPage() {
        header('Location: ' . filter_var($this->createAuthUrl(), FILTER_SANITIZE_URL));
        exit;
    }

    public function fetchAccessTokenWithAuthCode(string $code) {
        
        // Execute cURL request to retrieve the access token
        return $this->fetchApi(
            'https://accounts.google.com/o/oauth2/token',
            [],
            [
                'code' => $code,
                'client_id' => $this->oauth_client_id,
                'client_secret' => $this->oauth_client_secret,
                'redirect_uri' => $this->oauth_redirect_uri,
                'grant_type' => 'authorization_code'
            ]
        )->jsonObj()->access_token;
    }


    public function getUserInfo(bool $asObj = false) {

        // Execute cURL request to retrieve the user info associated with the Google account
        $userInfo = $this->fetchApi(
            'https://www.googleapis.com/oauth2/' . $this->oauth_version . '/userinfo',
            [
                'Authorization: Bearer ' . $this->access_token
            ]
        );

        if ($asObj) {
            return $userInfo->jsonObj();
        }

        return $userInfo->json();
    }


    public function response() {
        return $this->fetchResponse;
    }

    public function json() {
        return @json_decode($this->response(), true);
    }

    public function jsonObj() {
        return @json_decode($this->response(), null);
    }

    public function getErrorInfo() {
        return $this->errorInfo;
    }

    private function fetchApi(string $url, array $headers = [], array $postData = []) {
        
        $curl = curl_init($url);
        if (!empty($headers)) curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_POST, true);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        if (!empty($postData)) curl_setopt($curl,CURLOPT_POSTFIELDS, http_build_query($postData));
        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if (strlen($err) > 1) {
            $this->errorInfo = $err;
        }
        $this->fetchResponse = $result;
        
        return $this;
    }

}

