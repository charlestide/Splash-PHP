<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-07
 * Time: 15:03
 */

namespace SplashPhp\Libraries\Splash;


class Options
{
    /**
     * @var int
     */
    protected $timeout = 30;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * Options constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = $options;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool {
        return isset($this->options[$key]);
    }

    /**
     * @param string $key
     * @return bool|mixed
     */
    public function get(string $key) {
        if ($this->has($key)) {
            return $this->options[$key];
        } else {
            return false;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value) {
        $this->options[$key] = $value;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout) {
        $this->set('timeout',$timeout);
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->get('timeout');
    }

    /**
     * @param string $host
     * @param int $port
     */
    public function setProxy(string $host, int $port) {
        $this->set('proxy',"{$host}:{$port}");
    }

    /**
     * @return string
     */
    public function getProxy(): string {
        return $this->get('proxy');
    }

    /**
     * @return array
     */
    public function all(): array {
        return $this->options;
    }

    /**
     * @return string
     */
    public function toQuery() :string {
        return http_build_query($this->options);
    }
}