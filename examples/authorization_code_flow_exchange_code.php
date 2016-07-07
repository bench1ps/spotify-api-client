#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Bench1ps\Spotify\Authentication;
use Bench1ps\Spotify\Session\SessionHandler;

$configuration = [
    'client_id' => 'b3d3fa5d017043e78038b70f6990b840',
    'client_secret' => 'f3408f0cdb9042648d1f2647a1ec6860',
    'redirect_uri' => 'http://localhost:8888/callback',
];

/** @var string $authorizationCode The authorization code provided after the user has approved the application */
$authorizationCode = 'AQCFjsoF1EjgDdNeCZzx8uOhVhO3Z30rqlvAY0hu4dK3V96ogo1_FsPXK_EkmhutbJdG1Xs1Az93op9PTN6EEjCS5FuIwBqrttj6SFZZc89QgGjzJgFp_bbVDHf5SBZQFPgyEwWIDPckj95IFtli_dfH8Y-kwb8ch0jisVopTnexE8yJnI7z62bCY55sUBPHEJjR9g';

$sessionHandler = new SessionHandler();
$authentication = new Authentication($configuration, $sessionHandler);
$authentication->exchangeCode($authorizationCode);


echo "> Authorization code successfully exchanged for access token:\n";
echo $authentication->getCurrentSession()->getAccessToken()."\n";
echo "> Use this refresh token to get a new access token:\n";
echo $authentication->getCurrentSession()->getRefreshToken()."\n";