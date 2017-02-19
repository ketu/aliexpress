<?php
/**
 * Created by PhpStorm.
 * User: ketu <${EMAIL}>
 * Date: 17-2-19
 * Time: 上午11:29
 */

namespace Veda\Aliexpress\Request\Message;

/**
 * Class Info
 * @package Veda\Aliexpress\Request\Message
 * @desc 站内信/订单留言查询详情列表
 */
class Info  extends RequestAbstract
{
    public function getMethod()
    {
        return 'api.queryMsgDetailList';
    }

}