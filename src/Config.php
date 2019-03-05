<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-05
 * Time: 23:14
 */

namespace SplashPhp;


class Config
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Config constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string|null
     */
    public function getSplashUrl(): ?string {
        if (isset($this->config['splash_url'])) {
            return $this->config['splash_url'];
        } else {
            return false;
        }
    }

}