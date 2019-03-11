<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-10
 * Time: 22:20
 */

namespace SplashPhpExamples;

use SplashPhp\Worker;
use Symfony\Component\DomCrawler\Crawler;

class TMallWorker extends Worker
{
    protected $useSplash = true;
    protected $splashHost = 'localhost';
    protected $splashPost = 8050;

    /**
     * @return array
     */
    public function getSeed(): array
    {
        return ['https://www.tmall.com'];
    }


    protected function downloadedPage(Crawler $crawler)
    {
        echo $crawler->filter('title')->first()->text();
    }

}