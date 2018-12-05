<?php

namespace Spotify\Exception;

class ClientException extends SpotifyException
{
    /**
     * ClientException constructor.
     *
     * @param string          $path
     * @param \Throwable|null $previous
     */
    public function __construct(string $path, \Throwable $previous = null)
    {
        parent::__construct(sprintf('Call to the Spotify API failed [%s]', $path), 0, $previous);
    }
}
