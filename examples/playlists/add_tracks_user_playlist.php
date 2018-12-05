#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Spotify\Exception\SpotifyException;

/**
 * @var string $playlistId
 *
 * The Spotify identifier of the playlist.
 * Use one of your own, or create a new one using the create_user_playlist example.
 */
$playlistId = '';
$trackIds = [
    'spotify:track:4ubm9BQUCnhCvISFcJy8oS', // Toccata And Fugue In D Minor, BWV 565, Johann Sebastian Bach
    'spotify:track:34wVUI4PNxDG4MRfehQLin'  // Adagio For Strings And Organ In G Minor, Tomaso Albinoni
];

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->addTracksToUserPlaylist($playlistId, $trackIds);

    SpotifyExample::printSuccess(sprintf("Successfully added %d track(s) to user's playlist %s", count($trackIds), $playlistId));
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}
