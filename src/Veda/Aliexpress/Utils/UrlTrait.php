<?php
/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-19
 * Time: 上午12:39
 */

namespace Veda\Aliexpress\Utils;


trait UrlTrait
{
    protected $arguments = [];

    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param $url 未签名api链接
     * @param null $method API接口
     * @param array $params api所需相关参数
     * @param bool|false $isAuthUrl 所签名的URL是否为授权url
     * @return string 返回已经签名的api链接
     */
    public function buildUrl($url, $method = null, $params, $isAuthUrl = false)
    {

        if (!$this->getClientId() || !$this->getClientSecret()) {
            throw new \InvalidArgumentException('Client id and secret must be set');
        }

        if ($method) {
            $url .=  $method . '/';
        }

        $signatureString = '';
        if (false === $isAuthUrl) {
            $url = $url . $this->getClientId();
            $signatureString = substr($url, stripos($url, 'param2'), strlen($url));
        }


        ksort($params);
        $this->setArguments($params);

        foreach ($params as $key => $value) {
            $signatureString .= $key . $value;
        }

        $aopSignature = $this->signature($signatureString);

        $params['_aop_signature'] = $aopSignature;


        $systemParams = array(
            'access_token' => '',
            '_aop_signature' => '',
            '_aop_timestamp' => ''
        );

        if (in_array($method, array('api.postAeProduct', 'api.editAeProduct'))) {
            $params = array_intersect_key($params, $systemParams);
        }
        ksort($params);

        $url .= '?' . http_build_query($params);

        return $url;
    }

    /**
     * @param $needSignature 用来做签名因子的拼合参数字符串
     * @return string 返回签名
     */
    private function signature($needSignature)
    {
        return strtoupper(bin2hex(hash_hmac('sha1', $needSignature, $this->getClientSecret(), true)));

    }

}