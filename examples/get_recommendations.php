#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Bench1ps\Spotify\SpotifyClient;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\TrackSpecification;
use Bench1ps\Spotify\Exception\SpotifyClientException;

/** @var string $accessToken The access token issued on behalf of the user. Replace by a valid access token. */
$accessToken = 'BQDeX-K4qeYTq_KqJOVR9ymsKs43bdYSR4tObpVbqSdhhjY4gFLYcRlSOCodNTzQos-2dJXMbzZFMHbrMycJayljbU0NcW_omOad3gl59c8u8B8nBMGxrOjfmmdvD0erMOWuLML1Knxpg-WgoI7jzwxfmMAOU_CppekRiPDgVmuTz3pClFLUITfP0uJLsWNEZgqfItNRUqm7HcTWWLycVFk';

$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $accessToken, '', 3600));
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
    $resource = $client->getRecommendations(10, null, $bag, $seedArtists, $seedGenres, $seedTracks);
} catch (SpotifyClientException $e) {
    echo $e->getMessage()."\n";
    die;
}

echo "Recommended tracks based on seeds:\n";
foreach ($resource['tracks'] as $track) {
    echo "- ".$track['name']."\n";
}