<?php

namespace Spotify\Authorization\Exception;

use Spotify\Exception\SpotifyException;

/**
 * Class AuthorizationException
 *
 * @author Benjamin Fraud <benjamin.fraud@gmail.com>
 */
class AuthorizationException extends SpotifyException
{
    /**
     * AuthorizationException constructor.
     *
     * @param string          $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, \Throwable $previous = null)
    {
        parent::__construct(sprintf('Error while calling Spotify authorization service: ', lcfirst($message)), 0, $previous);
    }
}
