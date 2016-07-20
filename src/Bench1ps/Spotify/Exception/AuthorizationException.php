<?php

namespace Bench1ps\Spotify\Exception;

class AuthorizationException extends \Exception
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
        parent::__construct("Authorization call failed: ".$exception->getMessage());

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