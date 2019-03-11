<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-05
 * Time: 22:22
 */

namespace SplashPhp;

use Beanbun\Beanbun;
use SplashPhp\Libraries\Output;
use SplashPhp\Libraries\Splash\Client;
use Symfony\Component\DomCrawler\Crawler;

abstract class Worker
{
    /**
     * @var Beanbun
     */
    protected $bean;

    /**
     * @var Output
     */
    protected $output;

    /**
     * @var int
     */
    protected $theadCount = 10;

    /**
     * @var string
     */
    protected $name = 'Unnamed Worker';

    /**
     * @var array
     */
    protected $headers = [
        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36'
    ];

    /**
     * @var bool 是否使用Splash
     */
    protected $useSplash = false;

    protected $splashHost = 'localhost';
    protected $splashPost = 8050;

    protected $proxyHost;
    protected $proxyPort;

    /**
     * Worker constructor.
     */
    public function __construct()
    {
        $this->bean = new Beanbun;
        $this->bean->seed = $this->getSeed();
        $this->output = new Output();
    }

    /**
     * @return Beanbun
     */
    public function getBean(): Beanbun
    {
        return $this->bean;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Output
     */
    public function getOutput(): Output
    {
        return $this->output;
    }

    public function start() {
        $this->listen();
        $this->bean->start();
    }

    /**
     * 注册监听
     */
    public function listen() {

        $this->getBean()->beforeDownloadPage = function (Beanbun $beanbun) {
            $this->getOutput()->arrow('Start Download');
        };
        $this->bean->afterDownloadPage = function (Beanbun $beanbun) {
//            $body = $beanbun->page;
//            $body->seek(0);
//            $content = $body->getContents();
//            $this->getOutput()->arrow('Completing Download');
//            $this->getOutput()->line("Response Length: ".strlen($content));
//            $crawler = new Crawler($content);
            $crawler = $beanbun->page;
            $this->downloadedPage($crawler);
        };

        if ($this->isUseSplash()) {
            $this->getBean()->downloadPage = function (Beanbun $beanbun) {
                $this->downloadBySplash($beanbun);
            };
        } else {
            $this->getBean()->options['headers'] = $this->headers;
        }
    }

    /**
     * @return array
     */
    abstract public function getSeed(): array;

    /**
     * @param Crawler $crawler
     * @return mixed
     */
    abstract protected function downloadedPage(Crawler $crawler);

    /**
     * @param Beanbun $beanbun
     */
    private function downloadBySplash(Beanbun $beanbun) {
        $client = new Client($this->splashHost,$this->splashPost);
        if ($this->getProxy()) {
            $client->getOptions()->set('proxy',$this->getProxy());
        }
        $client->getOptions()->set('headers',$this->headers);
        $beanbun->page = $client->html($beanbun->url);

    }

    /**
     * @return int
     */
    public function getTheadCount(): int
    {
        return $this->theadCount;
    }

    /**
     * @param int $theadCount
     */
    public function setTheadCount(int $theadCount): void
    {
        $this->theadCount = $theadCount;
    }

    /**
     * @return bool
     */
    public function isUseSplash(): bool
    {
        return $this->useSplash;
    }

    /**
     * @param bool $useSplash
     */
    public function setUseSplash(bool $useSplash): void
    {
        $this->useSplash = $useSplash;
    }

    /**
     * @return string
     */
    public function getSplash(): string
    {
        return "{$this->splashHost}:{$this->splashPost}";
    }

    /**
     * @param string $host
     * @param int $port
     */
    public function setSplash(string $host, int $port): void
    {
        $this->splashHost = $host;
        $this->splashPost = $port;
    }

    /**
     * @param string $host
     * @param int $port
     */
    public function setProxy(string $host, int $port) {
        $this->proxyHost = $host;
        $this->proxyPort = $port;
    }

    /**
     * @return string|null
     */
    public function getProxy(): ?string {
        if ($this->proxyHost and $this->proxyPort) {
            return "{$this->proxyHost}:{$this->proxyPort}";
        } else {
            return null;
        }
    }
}