<?php

namespace Bench1ps\Spotify;

use Bench1ps\Spotify\Exception\ClientException;
use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Message\ResponseInterface;

abstract class Client
{
    /** @var BaseClient */
    private $client;

    /**
     * Client constructor.
     *
     * @param string      $baseURI
     * @param string|null $proxy
     */
    public function __construct(string $baseURI, string $proxy = null)
    {
        $parameters = [
            'base_url' => $baseURI,
        ];

        if ($proxy) {
            $parameters['defaults'] = [
                'proxy' => $proxy,
            ];
        }

        $this->client = new BaseClient($parameters);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $options
     *
     * @return ResponseInterface
     * @throws ClientException When the call to the Spotify API request path fails.
     */
    protected function request($method, $path, array $options = []): ResponseInterface
    {
        try {
            $request = $this->client->createRequest($method, $path, $options);

            return $this->client->send($request);
        } catch (\Exception $e) {
            throw new ClientException($path, $e);
        }
    }
}