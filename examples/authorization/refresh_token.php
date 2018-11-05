#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

try {
    $authentication = SpotifyExample::loadAuthorization();
    $authentication->refreshToken();
    SpotifyExample::$credentials['access_token'] = $authentication->getCurrentSession()->getAccessToken();
    SpotifyExample::dump();

    SpotifyExample::printSuccess('Successfully fetched a new access token using the refresh token');
    SpotifyExample::printInfo('New access token was copied to examples/credentials/credentials.json.');
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}