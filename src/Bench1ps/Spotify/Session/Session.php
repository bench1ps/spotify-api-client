<?php

namespace Bench1ps\Spotify\Session;

class Session
{
    /** @var string */
    private $sessionId;

    /** @var string */
    private $accessToken;

    /** @var string */
    private $refreshToken;

    /** @var int */
    private $expiresIn;

    /**
     * @param string $sessionId
     * @param string $accessToken
     * @param string $refreshToken
     * @param int    $expiresIn
     */
    public function __construct($sessionId, $accessToken, $refreshToken, $expiresIn)
    {
        $this->sessionId = $sessionId;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param string $accessToken
     * @param int    $expiresIn
     */
    public function refreshToken($accessToken, $expiresIn)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
    }
}
