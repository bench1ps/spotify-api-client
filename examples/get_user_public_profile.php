#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\API\API;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyException;

$userSpotifyId = 'benchips';

try {
    $credentials = SpotifyExample::load();
    $sessionHandler = new SessionHandler();
    $sessionHandler->addSession(new Session('foobar', $credentials['access_token'], '', 3600));

    $client = new API($sessionHandler);
    $result = $client->getUserPublicProfile($userSpotifyId);

    SpotifyExample::printSuccess('User public profile information:');
    SpotifyExample::printList([
        'Name' => $result->display_name,
        'Public URI' => $result->external_urls->spotify,
        'Number of followers' => $result->followers->total,
    ], true);
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}