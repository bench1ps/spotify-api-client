<?php

namespace Spotify\Session\Exception;

use Spotify\Exception\SpotifyException;

class SessionException extends SpotifyException
{
    /**
     * SessionException constructor.
     *
     * @param string          $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, \Throwable $previous = null)
    {
        parent::__construct(sprintf('Session exception: ', lcfirst($message)), 0, $previous);
    }
}