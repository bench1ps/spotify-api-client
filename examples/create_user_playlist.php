#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\API\API;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyException;

try {
    $credentials = SpotifyExample::load();
    $sessionHandler = new SessionHandler();
    $sessionHandler->addSession(new Session('foobar', $credentials['access_token'], '', 3600));

    $client = new API($sessionHandler);
    $result = $client->createUserPlaylist(sprintf('Example playlist (%s)', date('Y-m-d H:i:s')), false);

    SpotifyExample::printSuccess(sprintf(
        "Playlist %s successfully created (%s)",
        $result->id,
        $result->external_urls->spotify
    ));
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}
