<?php

namespace Spotify\API\Exception;

use Spotify\Exception\SpotifyException;

/**
 * Class APIException
 *
 * @author Benjamin Fraud <benjamin.fraud@gmail.com>
 *
 * This is the base class for all exceptions that may be thrown in the Spotify API service.
 */
abstract class APIException extends SpotifyException
{
    /**
     * APIException constructor.
     *
     * @param string          $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, \Throwable $previous = null)
    {
        parent::__construct(sprintf('Error while calling Spotify API service: ', lcfirst($message)), 0, $previous);
    }
}
