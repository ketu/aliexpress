<?php
/**
 * Created by PhpStorm.
 * User: ketu
 * Date: 17-2-15
 * Time: 下午10:57
 */

namespace Veda\Aliexpress;


abstract class ModuleAbstract
{
    protected $config;


    public function __construct(ConfigAbstract $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function create()
    {

    }

}