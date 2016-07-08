#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\Authentication;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;

$configuration = [
    'client_id' => 'b3d3fa5d017043e78038b70f6990b840',
    'client_secret' => 'f3408f0cdb9042648d1f2647a1ec6860',
    'redirect_uri' => 'http://localhost:8888/callback',
];

$credentials = SpotifyExample::load();
$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $credentials['access_token'], $credentials['refresh_token'], 3600));
$authentication = new Authentication($configuration, $sessionHandler);
$authentication->refreshToken();

SpotifyExample::$credentials['access_token'] = $authentication->getCurrentSession()->getAccessToken();
SpotifyExample::dump();

echo "Successfully fetched a new access token using the refresh token:\n";
echo $authentication->getCurrentSession()->getAccessToken()."\n";