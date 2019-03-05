<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-05
 * Time: 21:43
 */


use Beanbun\Beanbun;

class TMallProduct {

    /**
     * @var Beanbun
     */
    protected $beanbun;

    public function __construct()
    {
        $this->beanbun = new Beanbun;
        $this->beanbun->seed = [
            'https://chaoshi.detail.tmall.com/item.htm?id=539760220639',
        ];

//        $this->beanbun->beforeDownloadPage = function (Beanbun $beanbun) {
//            $beanbun->
//        };

        $this->beanbun->afterDownloadPage = function(Beanbun $beanbun) {
            file_put_contents(__DIR__ . './' . md5($beanbun->url), $beanbun->page);
        };

    }

    public function start() {
        $this->beanbun->start();
    }
}


