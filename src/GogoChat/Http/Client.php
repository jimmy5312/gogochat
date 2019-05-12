<?php

namespace GogoChat\Http;

class Client {
    protected $client = null;
    function __construct() {
        $this->client = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://chat.gogoempire.asia',
            // You can set any number of default request options.
            'timeout'  => 5.0,
        ]);
    }

    function getHeaders($extra = []) {
        $headers = [
            'Accept'    => 'application/json',
            'AppSecret' => 'AppSecret ' . config('app.chat_app_secret')
        ];

        if ($extra && is_array($extra)) {
            foreach ($extra as $key => $value) {
                $headers[$key] = $value;
            }
        }
        return $headers;
    }

    function postJSON($path, $object) {
        $response = $this->client->request("POST", "api$path", [
            'headers'   => $this->getHeaders(),
            'json'      => $object
        ]);
        return $response;
    }
}