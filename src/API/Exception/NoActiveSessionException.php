<?php

namespace Spotify\API\Exception;

class NoActiveSessionException extends APIException
{
    public function __construct()
    {
        parent::__construct('No active session is managed in the session handler');
    }
}
