<?php
/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-16
 * Time: 下午10:58
 */

namespace Veda\Aliexpress;

use GuzzleHttp\Client as HttpClient;
use Veda\Aliexpress\Utils\UrlTrait;

class Auth
{

    use UrlTrait;

    /**
     * @var string APP KEY 字符串
     */
    protected $clientId;

    /**
     * @var string APP 密钥
     */
    protected $clientSecret;

    /**
     * @var string accessToken
     */
    protected $accessToken;

    /**
     * @var string refreshToken
     */
    protected $refreshToken;

    /**
     * @var string 临时令牌
     */
    protected $authorizationCode;

    /**
     * @var string 授权完成之后的跳转链接
     */
    protected $redirectUrl = 'http://127.0.0.1';

    /**
     * @param $clientId APP KEY
     * @param $clientSecret APP 密钥
     * @param null $refreshToken refreshToken
     */
    public function __construct($clientId, $clientSecret, $refreshToken = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->refreshToken = $refreshToken;
    }

    /**
     * @param $clientId APP KEY
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed 返回APP KEY
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param $clientSecret APP密钥
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret($clientSecret);
    }

    /**
     * @return mixed 返回APP密钥
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }


    /**
     * @param $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }


    /**
     * @return null 返回refreshToken
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param $authorizationCode 临时令牌
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * @return mixed 返回临时令牌
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param $redirectUrl 授权完成之后的跳转链接
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return string 返回跳转链接
     */

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @return mixed 返回accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param array $params 额外参数，如返回链接redirect_uri, 自定义参数state
     * @return string 返回发起授权请求链接。
     * @throws \Exception
     */
    public function getAuthenticateUrl($params = [])
    {
        $defaultParams = array(
            'client_id' => $this->getClientId(),
            'site' => Config::AUTHORIZE_SITE
        );

        $params = array_merge($defaultParams, $params);


        /**
         * 使用UrlTrait里面的buildUrl函数进行拼装，签名
         */
        return $this->buildUrl(Config::AUTHORIZE_ENDPOINT, null, $params, true);
    }

    /**
     * @param null $refreshToken
     * @param bool|false $onlyAccessToken 是否只返回accessToken
     * @return mixed|null 返回accessToken或者返回整个token数据
     * @throws \Exception
     */
    public function getAccessTokenByRefreshToken($refreshToken = null, $onlyAccessToken = false)
    {

        if ($refreshToken) {
            $this->setRefreshToken($refreshToken);
        }

        $refreshTokenUrl = $this->getRefreshTokenUrl();

        $postData = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'refresh_token' => $this->getRefreshToken(),
        ];


        $httpClient = new HttpClient();

        $response = $httpClient->request('POST', $refreshTokenUrl,  ['form_params' => $postData]);

        if ($response->getStatusCode() == 200) {

            $tokenData = json_decode($response->getBody()->__toString(), true);

            if ($onlyAccessToken) {
                return $tokenData['access_token'];
            }

            $dateTime = new \DateTime();

            $tokenData['expires_in'] = $dateTime->getTimestamp() + (int)$tokenData['expires_in'];

            return $tokenData;
        }

        throw new \Exception(sprintf('AliExpress get access token by refresh token, error code: %s, error message: %s ', $response->getStatusCode(), $response->getBody()));

    }

    /**
     * @param null $authorizationCode 临时令牌
     * @return string 返回用临时令牌获取accessToken的链接
     * @throws \Exception
     */
    private function getAccessTokenUrl($authorizationCode = null)
    {
        if ($authorizationCode) {
            $this->authorizationCode = $authorizationCode;
        }
        if (!$this->getAuthorizationCode()) {
            throw new \Exception('authorization code not found');
        }
        return sprintf(Config::ACCESS_TOKEN_ENDPOINT, $this->getClientId(), $this->getClientId(), $this->getClientSecret(), $this->getRedirectUrl(), $this->getAuthorizationCode());

    }

    /**
     * @return string 返回用refreshToken换取accessToken的API链接地址
     */
    public function getRefreshTokenUrl()
    {
        return sprintf(Config::REFRESH_TOKEN_ENDPOINT, $this->getClientId());
    }
}