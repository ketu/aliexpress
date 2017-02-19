<?php
/**
 * Created by PhpStorm.
 * User: ketu <${EMAIL}>
 * Date: 17-2-19
 * Time: 下午1:20
 */

namespace Veda\Aliexpress\Request\Message;

use Veda\Aliexpress\RequestAbstract;

/**
 * Class Query
 * @package Veda\Aliexpress\Request\Message
 * @desc 获取当前用户下与当前用户建立消息关系的列表
 */
class Query extends RequestAbstract
{

    public function getMethod()
    {
        return 'api.queryMsgRelationList';
    }
}