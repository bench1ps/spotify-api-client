#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\Authorization\Authorization;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyException;

$configuration = [
    'client_id' => 'b3d3fa5d017043e78038b70f6990b840',
    'client_secret' => 'f3408f0cdb9042648d1f2647a1ec6860',
    'redirect_uri' => 'http://localhost:8888/callback',
];

try {
    $credentials = SpotifyExample::load();
    $sessionHandler = new SessionHandler();
    $sessionHandler->addSession(
        new Session('foobar', $credentials['access_token'], $credentials['refresh_token'], 3600)
    );

    $authentication = new Authorization($configuration, $sessionHandler);
    $authentication->refreshToken();
    SpotifyExample::$credentials['access_token'] = $authentication->getCurrentSession()->getAccessToken();
    SpotifyExample::dump();

    SpotifyExample::printSuccess('Successfully fetched a new access token using the refresh token');
    SpotifyExample::printInfo('New access token was copied to examples/credentials/credentials.json.');
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}