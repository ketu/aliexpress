<?php
/**
 * Created by PhpStorm.
 * User: ketu <${EMAIL}>
 * Date: 17-2-19
 * Time: 下午8:15
 */

namespace Veda\Aliexpress\Exception;

use Psr\Http\Message\ResponseInterface;

class ResponseException extends \Exception
{
    private $response;

    public function __construct($message, ResponseInterface $response, \Exception $previous = null)
    {

        $code = $response->getStatusCode();

        $body = \json_decode($response->getBody(), true);

        parent::__construct($body['error_message'], $code, $previous);

        $this->response = $response;
    }

    /**
     * Get the associated response
     *
     * @return ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getRequest()
    {

    }

    public function getResponseBody()
    {
        return $this->getResponse()->getBody();
    }


}