<?php

namespace TaskForce\extauth;

use yii\authclient\clients\VKontakte;


class AuthVk extends VKontakte
{

    private string $redirectUri;
    public array $requestData;
    public string $userEmail;

    public function __construct($config = [])
    {
        $this->clientId = '51661227';
        $this->clientSecret = 'UTbku0zOJyU2wPYdbDii';
        $this->apiVersion = '5.131';
        $this->redirectUri = 'http://taskforce/auth';
        $this->requestData = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'display' => 'popup',
            'scope' => 'email'
        ];
        
    }

    public function getAuthUrl()
    {
        return $this->buildAuthUrl($this->requestData);
    }

    public function getVkAccessToken($code)
    {
        $this->requestData['code'] = $code;
        $this->requestData['client_secret'] = $this->clientSecret;
        $accessToken = $this->createRequest()
            ->setUrl($this->tokenUrl)
            ->setMethod('GET')
            ->setData($this->requestData)
            ->send()
            ->getData();
        $this->userEmail = $accessToken['email'];
        return $accessToken;
    }


    public function getUserInfo($accessToken)
    {
        $params = [
            'uids' => $accessToken['user_id'],
            'fields' => 'first_name,last_name',
            'access_token' => $accessToken['access_token'],
            'v' => '5.131'
        ];

        return $this->createRequest()
            ->setUrl('https://api.vk.com/method/users.get')
            ->setData($params)
            ->send()
            ->getData()["response"][0];
    }
}
