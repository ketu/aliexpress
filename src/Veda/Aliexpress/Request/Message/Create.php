<?php
/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-15
 * Time: 下午11:05
 */

namespace Veda\Aliexpress\Request\Message;

use Veda\Aliexpress\RequestAbstract;


/**
 * Class Create
 * @package Veda\Aliexpress\Request\Message
 * @desc 新增站内信/订单留言
 */
class Create extends RequestAbstract
{
    public function getMethod()
    {
        return 'api.addMsg';
    }

}
