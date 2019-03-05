<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-05
 * Time: 22:22
 */

namespace SplashPhp;

use Beanbun\Beanbun;

class Worker
{
    /**
     * @var Beanbun
     */
    protected $bean;

    /**
     * Worker constructor.
     * @param array $seed
     */
    public function __construct(array $seed)
    {
        $this->bean = new Beanbun;
        $this->bean->seed = $seed;
    }

    public function start(bool $splash = true) {
        $this->bean->start();
    }

    protected function useSplash() {
        $this->bean->downloadPage = function (Beanbun $beanbun) {

        };
    }
}