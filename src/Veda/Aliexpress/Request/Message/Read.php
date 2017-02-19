<?php
/**
 * Created by PhpStorm.
 * User: ketu <${EMAIL}>
 * Date: 17-2-19
 * Time: 下午1:49
 */

namespace Veda\Aliexpress\Request\Message;


use Veda\Aliexpress\RequestAbstract;

class Read extends RequestAbstract
{

    public function getMethod()
    {
        // TODO: Implement getMethod() method.
        return 'api.updateMsgRead';
    }
}