<?php
/**
 * Created by PhpStorm.
 * User: ketu <${EMAIL}>
 * Date: 17-2-19
 * Time: 下午1:48
 */

namespace Veda\Aliexpress\Request\Message;


use Veda\Aliexpress\RequestAbstract;

class Processed extends RequestAbstract
{
    public function getMethod()
    {
        // TODO: Implement getMethod() method.
        return 'api.updateMsgProcessed';
    }
}