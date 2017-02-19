<?php

/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-18
 * Time: 下午10:04
 */

use PHPUnit\Framework\TestCase;

use Veda\Aliexpress\Config;
use Veda\Aliexpress\Request\Message\Create;
use Veda\Aliexpress\Client;
use Veda\Aliexpress\RequestAbstract;


class ClientTest extends TestCase
{
    public function testGetRequest()
    {
        $config = new Config('xxx', 'xxx', 'xxx');
        $request = new Create($config);
        $client = new Client($request);

        $this->assertInstanceOf(RequestAbstract::Class, $client->getRequest());


    }
}