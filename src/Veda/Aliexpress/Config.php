<?php
/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-15
 * Time: 下午11:12
 */

namespace Veda\Aliexpress;

use Veda\Aliexpress\Utils\UrlTrait;

class Config
{
    use UrlTrait;

    const AUTHORIZE_SITE = 'aliexpress';

    const API_ENDPOINT = 'https://gw.api.alibaba.com/openapi/param2/1/aliexpress.open/';
    const AUTHORIZE_ENDPOINT = 'http://gw.api.alibaba.com/auth/authorize.htm';
    const ACCESS_TOKEN_ENDPOINT = 'https://gw.api.alibaba.com/openapi/http/1/system.oauth2/getToken/%s?grant_type=authorization_code&need_refresh_token=true&client_id=%s&client_secret=%s&redirect_uri=%s&code=%s';
    const REFRESH_TOKEN_ENDPOINT = 'https://gw.api.alibaba.com/openapi/param2/1/system.oauth2/getToken/%s';


    protected $clientId;
    protected $clientSecret;
    protected $accessToken;


    public function __construct($clientId, $clientSecret, $accessToken)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->accessToken = $accessToken;
    }
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function getClientId()
    {
        return $this->clientId;
    }
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret($clientSecret);
    }
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }
    public function getAccessToken()
    {
        return $this->accessToken;
    }


    public function getApiUrl($apiMethod)
    {
        $arguments = $this->getArguments();

        if (!isset($arguments['_aop_timestamp'])) {
            $arguments['_aop_timestamp'] = number_format(microtime(true), 3, '', '');
        }

        $arguments['access_token'] = $this->getAccessToken();
        //$this->api = $api;
        return $this->buildUrl(self::API_ENDPOINT, $apiMethod, $arguments);
    }

    public function __clone()
    {
        $this->setArguments([]);

    }

}