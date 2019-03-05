<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-05
 * Time: 21:56
 */

require_once(__DIR__ . '/vendor/autoload.php');

use SplashPhp\Worker;

$worker = new Worker([
    'https://www.tmall.com'
]);
