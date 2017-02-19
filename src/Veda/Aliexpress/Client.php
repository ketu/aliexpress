<?php
/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-16
 * Time: 下午10:56
 */

namespace Veda\Aliexpress;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Veda\Aliexpress\Exception\ResponseException;

class Client
{
    /**
     * @var RequestAbstract request 实例
     */
    protected $request;


    /**
     * @param RequestAbstract $request
     */
    public function __construct(RequestAbstract $request = null)
    {
        $this->request = $request;
        $this->httpClient = new HttpClient();
    }


    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest(RequestAbstract $request)
    {
        $this->request = $request;
    }
    /**
     * @param RequestAbstract $request Request实例
     */
    public function send(RequestAbstract $request = null)
    {
        if (null !== $request) {
            $this->setRequest($request);
        }

        try {
            $this->getRequest()->build();
            $httpClient = new HttpClient();

            $response = $httpClient->request('POST', $this->getRequest()->getUrl(), $this->getRequest()->getPostData());


            $responseObject = json_decode($response->getBody()->__toString(), true);
            if (!isset($responseObject['error_code'])) {
                return $responseObject;
            }

        } catch (ClientException $e) {
            throw new ResponseException($e->getMessage(), $e->getResponse());
        }

    }

}