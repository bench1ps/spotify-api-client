#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\SpotifyClient;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyClientException;

/** @var string $playlistId The Spotify identifier of the playlist */
$playlistId = '5uPgSsLEa2j71K1J55OvrI';
$trackIds = [
    'spotify:track:4ubm9BQUCnhCvISFcJy8oS', // Toccata And Fugue In D Minor, BWV 565
    'spotify:track:4ubm9BQUCnhCvISFcJy8oS'  // Adagio For Strings And Organ In G Minor
];

$credentials = SpotifyExample::load();
$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $credentials['access_token'], '', 3600));
$client = new SpotifyClient($sessionHandler);

try {
    $client->addTracksToUserPlaylist($playlistId, $trackIds);
} catch (SpotifyClientException $e) {
    echo $e->getMessage()."\n";
    die;
}

echo sprintf("> Successfully added %d track(s) to user's playlist %s.\n", count($trackIds), $playlistId);