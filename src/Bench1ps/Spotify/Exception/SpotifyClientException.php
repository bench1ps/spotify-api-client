<?php

namespace Bench1ps\Spotify\Exception;

class SpotifyClientException extends \Exception
{
    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @param \Exception $exception
     */
    public function __construct(\Exception $exception)
    {
        parent::__construct("Could not perform Spotify API call: ".$exception->getMessage());

        $this->exception = $exception;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}