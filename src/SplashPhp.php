<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-02
 * Time: 21:55
 */

class SplashPhp
{
    /**
     * @var array
     */
    protected $config;

    /**
     * SplashPhp constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}