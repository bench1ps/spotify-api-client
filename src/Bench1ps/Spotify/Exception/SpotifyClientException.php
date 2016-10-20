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
     * @param string     $method
     * @param string     $path
     * @param array      $options
     */
    public function __construct(\Exception $exception, $method, $path, array $options = [])
    {
        parent::__construct("Could not perform Spotify API call $method $path: ".$exception->getMessage().(!empty($options) ? ' - Body: '.json_encode($options) : ''));

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