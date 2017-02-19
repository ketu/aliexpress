<?php
/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-15
 * Time: 下午11:05
 */

namespace Veda\Aliexpress\Request\Message;

use Veda\Aliexpress\RequestAbstract;

class Create extends RequestAbstract
{
    public function getMethod()
    {
        return 'api.addMsg';
    }


}
