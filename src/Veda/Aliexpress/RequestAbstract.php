<?php
/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-16
 * Time: 下午10:56
 */

namespace Veda\Aliexpress;

abstract class RequestAbstract
{

    private $params;
    private $config;


    private $apiUrl;
    private $postData = [];

    protected $isStreamRequest = false;


    private $uploadFile;

    abstract public function getMethod();


    public function __construct(Config $config)
    {
        $this->config = clone $config;
    }


    public function __call($name, $args)
    {
        $key = lcfirst(substr($name, 3));
        if ('get' === substr($name, 0, 3)) {
            return isset($this->params[$key])
                ? $this->params[$key]
                : null;
        } elseif ('set' === substr($name, 0, 3)) {
            $value = 1 == count($args) ? $args[0] : null;
            $this->params[$key] = $value;
        }
    }

    public function getUrl()
    {
        return $this->apiUrl;
    }

    public function getPostData()
    {
        return $this->postData;
    }

    public function getIsStreamRequest()
    {
        return $this->isStreamRequest;
    }

    public function withFile($file)
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException("file (%s) not found ", $file);
        }

        if (is_readable($file)) {
            throw new \InvalidArgumentException("file (%s) not readable ", $file);
        }
        $this->uploadFile = $file;
    }

    final public function build()
    {
        $this->config->setArguments($this->getParams());
        if (!$this->getMethod()) {
            throw new \InvalidArgumentException('api method is invalid');
        }

        $this->apiUrl = $this->config->getApiUrl($this->getMethod());

        $this->postData = [
            'form_params' => $this->getParams()
        ];
        if ($this->getIsStreamRequest()) {
            unset($this->postData['form_params']);

            $this->postData['body'] = fopen($this->uploadFile, 'r');
        }

    }


    public function getParams()
    {
        return $this->params;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setParams(array $params, $override = false)
    {
        if ($override) {
            array_merge($this->params, $params);
        } else {
            $this->params = $params;
        }
    }
}