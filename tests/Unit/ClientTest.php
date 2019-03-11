<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-11
 * Time: 12:17
 */

use SplashPhp\Libraries\Splash\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var string
     */
    private $host = 'localhost';

    /**
     * @var int
     */
    private $port = 8050;
    /**
     * @var Client
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = new Client($this->host,$this->port);
    }

    public function testGetClient()
    {
        $this->assertInstanceOf(\GuzzleHttp\Client::class,$this->client->getClient());
    }

    public function testGetOptions()
    {
        $this->assertInstanceOf(\SplashPhp\Libraries\Splash\Options::class,$this->client->getOptions());
    }

    public function test__construct()
    {
        $this->assertInstanceOf(\GuzzleHttp\Client::class,$this->client->getClient());
        $this->assertInstanceOf(\SplashPhp\Libraries\Splash\Options::class,$this->client->getOptions());
        $this->assertEquals($this->host,$this->client->getClient()->getConfig('base_uri')->getHost());
        $this->assertEquals($this->port,$this->client->getClient()->getConfig('base_uri')->getPort());
    }

    /**
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testHtml() {
        $response = $this->client->html('http://www.950d.com');
        $this->assertInstanceOf(\Symfony\Component\DomCrawler\Crawler::class,$response);
        $this->client->html('http://www.950d');
        $this->expectException(\GuzzleHttp\Exception\ServerException::class);
    }
}
