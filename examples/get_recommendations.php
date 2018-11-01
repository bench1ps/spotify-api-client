#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\API\API;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyException;

$nbRecommendations = 10;

try {
    $credentials = SpotifyExample::load();
    $sessionHandler = new SessionHandler();
    $sessionHandler->addSession(new Session('foobar', $credentials['access_token'], '', 3600));
    $client = new API($sessionHandler);

    $seedArtists = [
        '5B7uXBeLc2TkR5Jk23qKIZ' // Gustav Holst
    ];

    $seedGenres = [
        'classical' // Classical music
    ];

    $seedTracks = [
        '7pHdkCXkeC8AYHMcIDzUdf' // The Planets, Op. 32: Jupiter, the Bringer of Jollity
    ];

    $trackAttributes = [
        'target_key' => 2,       // D key
        'target_mode' => 0,      // Minor mode
        'target_valence' => 0.9, // Musical positiveness
    ];

    $result = $client->getRecommendations($nbRecommendations, null, $trackAttributes, $seedArtists, $seedGenres, $seedTracks);

    SpotifyExample::printSuccess(sprintf('Found %d recommended tracks:', count($result->tracks)));
    SpotifyExample::printList($result->tracks, function(stdClass $track) {
        return sprintf('%s, by %s (%s)', $track->name, $track->artists[0]->name, $track->external_urls->spotify);
    });

} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}
