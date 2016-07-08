#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\SpotifyClient;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\TrackSpecification;
use Bench1ps\Spotify\Exception\SpotifyClientException;


$credentials = SpotifyExample::load();
$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $credentials['access_token'], '', 3600));
$client = new SpotifyClient($sessionHandler);

$bag = new TrackSpecification();
$bag
    ->add('target_key', 2)        // Tracks in D
    ->add('target_mode', 0)       // Tracks in minor mode
    ->add('target_valence', 0.9); // Tracks with musical positiveness

$seedArtists = [
    '5B7uXBeLc2TkR5Jk23qKIZ' // Gustav Holst
];

$seedGenres = [
    'classical'
];

$seedTracks = [
    '7pHdkCXkeC8AYHMcIDzUdf' // The Planets, Op. 32: Jupiter, the Bringer of Jollity
];

try {
    $result = $client->getRecommendations(10, null, $bag, $seedArtists, $seedGenres, $seedTracks);
} catch (SpotifyClientException $e) {
    echo $e->getMessage()."\n";
    die;
}

echo "Recommended tracks based on seeds:\n";
foreach ($result->tracks as $track) {
    echo "- ".$track->name."\n";
}