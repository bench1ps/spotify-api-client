#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\API\API;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyException;

$limit = 10;
$offset = 0;
$timeRange = API::RANGE_LONG;

try {
    $credentials = SpotifyExample::load();
    $sessionHandler = new SessionHandler();
    $sessionHandler->addSession(new Session('foobar', $credentials['access_token'], '', 3600));

    $client = new API($sessionHandler);
    $result = $client->getCurrentUserTopTracks($limit, $offset, $timeRange);

    SpotifyExample::printSuccess(sprintf('Found %d top tracks (%s):', count($result->items), $timeRange));
    SpotifyExample::printList($result->items, function (stdClass $track) {
        return sprintf('%s by %s (%s)', $track->name, $track->artists[0]->name, $track->external_urls->spotify);
    });
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}