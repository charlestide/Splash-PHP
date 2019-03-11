<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-02
 * Time: 22:04
 */

namespace SplashPhp\Libraries\Splash;

use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler;

class Client
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @var Options
     */
    protected $options;

    /**
     * HttpClient constructor.
     * @param string $host Splash的Host
     * @param int $port Splash的port
     */
    public function __construct(string $host = 'localhost', int $port = 8050)
    {
        $this->host = $host;
        $this->port = $port;
        $this->client = new GuzzleClient([
            'base_uri' => "{$host}:{$port}",
        ]);

        $this->options = new Options();
    }

    /**
     * @return GuzzleClient
     */
    public function getClient(): GuzzleClient
    {
        return $this->client;
    }

    /**
     * @return Options
     */
    public function getOptions(): Options
    {
        return $this->options;
    }

    /**
     * @param string $host
     * @param int $port
     */
    public function setProxy(string $host, int $port) {
        $this->getOptions()->setProxy($host,$port);
    }

    /**
     * @param string $url
     * @return Crawler|null
     */
    public function html(string $url): ?Crawler {

//        $renderUrl = "render.html?url={$url}";
//        if ($this->getOptions()->toQuery()) {
//            $renderUrl .= "&{$this->getOptions()->toQuery()}";
//        }

        $query = $this->getOptions()->all();
        $query['url'] = $url;
        $response = $this->client->post('render.html',[
            'json' => $query
        ]);
        if ($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $body->seek(0);
            return new Crawler($body->getContents());
        } else {
            return null;
        }
    }
}