#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Bench1ps\Spotify\Authentication;
use Bench1ps\Spotify\Session\SessionHandler;

$configuration = [
    'client_id' => 'b3d3fa5d017043e78038b70f6990b840',
    'redirect_uri' => 'http://localhost:8888/callback',
];

$scopes = [
    'playlist-read-private',
    'playlist-read-collaborative',
    'playlist-modify-public',
    'playlist-modify-private',
    'streaming',
    'user-follow-modify',
    'user-follow-read',
    'user-library-read',
    'user-library-modify',
    'user-read-private',
    'user-read-birthdate',
    'user-read-email',
    'user-top-read'
];

$sessionHandler = new SessionHandler();
$authentication = new Authentication($configuration, $sessionHandler);
$query = $authentication->getAuthorizationQuery($scopes);

echo "> Call this URL to fetch an authorization code:\n";
echo $query;
echo "\n";