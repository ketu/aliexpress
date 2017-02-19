<?php
/**
 * Created by PhpStorm.
 * User: ketu <${EMAIL}>
 * Date: 17-2-19
 * Time: 下午1:52
 */

namespace Veda\Aliexpress\Exception;

class ClientException extends \Exception
{
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}