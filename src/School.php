<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-05
 * Time: 23:12
 */

namespace SplashPhp;


class School
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * School constructor.
     * @param array $config
     */
    public function __construct(array $config, $workerClass)
    {
        $this->config = new Config($config);
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    public function produce(bool $useSplash = true): Worker {
    }

}