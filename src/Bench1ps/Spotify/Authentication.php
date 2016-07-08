<?php

namespace Bench1ps\Spotify;

use Bench1ps\Spotify\Exception\AuthenticationException;
use Bench1ps\Spotify\Session\Session;
use GuzzleHttp\Client;
use Bench1ps\Spotify\Session\SessionHandler;

class Authentication
{
    const BASE_URI = 'https://accounts.spotify.com';
    const ENDPOINT_AUTHORIZATION_FLOW = 'authorize';
    const ENDPOINT_TOKEN = 'api/token';

    /**
     * @var array
     */
    private $configuration = [];

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var SessionHandler
     */
    private $sessionHandler;

    /**
     * @param array          $configuration
     * @param SessionHandler $sessionHandler
     */
    public function __construct(array $configuration, SessionHandler $sessionHandler)
    {
        $this->configuration = $configuration;
        $this->httpClient = new Client([
            'base_url' => self::BASE_URI,
        ]);
        $this->sessionHandler = $sessionHandler;
    }

    /**
     * Returns the authorization URL to get an authorization code from the Spotify API.
     * This will trigger an authorization request from the user if the application has not been approved yet or if the request is forced.
     *
     * @param array       $scopes An array of scopes for which the authorization is asked.
     *                            If empty, authorization will be granted only to access public information.
     * @param bool        $force  If set to true, the user will be asked to explicitly approve the application
     *                            even if already approved.
     * @param string|null $state  May be passed to perform additional check when receiving an authorization request
     *                            on the redirect URI specified.
     *
     * @return string
     */
    public function getAuthorizationQuery(array $scopes = [], $force = false, $state = null)
    {
        $params = [
            'client_id' => $this->configuration['client_id'],
            'response_type' => 'code',
            'redirect_uri' => $this->configuration['redirect_uri'],
            'scopes' => implode(',', $scopes),
            'show_dialog' => $force
        ];

        if (null !== $state) {
            $params['state'] = $state;
        }

        return sprintf('%s/%s?%s', self::BASE_URI, self::ENDPOINT_AUTHORIZATION_FLOW, http_build_query($params));
    }

    /**
     * @param string $authorizationCode
     */
    public function exchangeCode($authorizationCode)
    {
        $options = [
            'auth' => [
                $this->configuration['client_id'],
                $this->configuration['client_secret'],
                'basic'
            ],
            'body' => [
                'grant_type' => 'authorization_code',
                'code' => $authorizationCode,
                'redirect_uri' => $this->configuration['redirect_uri'],
            ]
        ];

        $response = $this->request('POST', self::ENDPOINT_TOKEN, $options);
        $body = $response->json();
        $this->sessionHandler->addSession(new Session(uniqid(), $body['access_token'], $body['refresh_token'], $body['expires_in']));
    }

    /**
     * Fetches a new access token from the current session's refresh token.
     * The newly acquired access token may be used to perform new API calls as long as it is valid.
     */
    public function refreshToken()
    {
        $options = [
            'auth' => [
                $this->configuration['client_id'],
                $this->configuration['client_secret'],
                'basic'
            ],
            'body' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->sessionHandler->getCurrentSession()->getRefreshToken(),
            ]
        ];

        $response = $this->request('POST', self::ENDPOINT_TOKEN, $options);
        $body = json_decode($response->getBody());
        $this->sessionHandler->getCurrentSession()->refreshToken($body->access_token, $body->expires_in);
    }

    /**
     * @return Session
     */
    public function getCurrentSession()
    {
        return $this->sessionHandler->getCurrentSession();
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $options
     *
     * @return \GuzzleHttp\Message\ResponseInterface
     *
     * @throws AuthenticationException
     */
    private function request($method, $path, array $options = [])
    {
        try {
            switch ($method) {
                case 'GET':
                    return $this->httpClient->get($path, $options);
                case 'POST':
                    return $this->httpClient->post($path, $options);
                default:
                    throw new \Exception("Unknown method $method");
            }
        } catch (\Exception $e) {
            throw new AuthenticationException($e);
        }
    }
}