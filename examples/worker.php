<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-10
 * Time: 22:25
 */

require_once __DIR__. "/../vendor/autoload.php";

use SplashPhpExamples\TMallWorker;

$worker = new TMallWorker();
$worker->start();