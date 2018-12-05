#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Spotify\Exception\SpotifyException;

/** @var string $playlistId The Spotify identifier of the playlist. */
$playlistId = '7a6yKYLGE17RXsEpMT8QqB';
$imagePath = __DIR__.'/cover.jpg';

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->uploadPlaylistCoverImage($playlistId, base64_encode(file_get_contents($imagePath)));

    SpotifyExample::printSuccess('Successfully uploaded playlist cover image');
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}
