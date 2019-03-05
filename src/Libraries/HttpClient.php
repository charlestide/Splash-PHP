<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-02
 * Time: 22:04
 */

use GuzzleHttp\Client as GuzzleClient;

class HttpClient
{
    protected $host;
    protected $port;

    protected $client;

    /**
     * HttpClient constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct(string $host, int $port = 8080)
    {
        $this->host = $host;
        $this->port = $port;
        $this->client = new GuzzleClient([
            'base_uri' => "{$host}:{$port}",
        ]);
    }

}