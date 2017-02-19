<?php
/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-18
 * Time: 下午10:39
 */

require "../vendor/autoload.php";
require 'config.php';



$accessToken = 'xxx';

try {

    $auth = new Veda\Aliexpress\Auth($clientId, $clientSecret);

    $authUrl = $auth->getAuthenticateUrl(['redirect_uri' => 'http://127.0.0.1', 'state' => 1]);


    header("Location:".$authUrl);
    exit();
    $config = new Veda\Aliexpress\Config($clientId, $clientSecret, $accessToken);
    $request = new Veda\Aliexpress\Request\Message\Create($config);

    $request->setXXX("asjdflksa");

    $client = new Veda\Aliexpress\Client($request);

    $client->send($request);

}catch (Veda\Aliexpress\Exception\ResponseException $e) {
    echo $e->getMessage();
    #echo $e->getResponse()->getStatusCode();
}


/*





*/
