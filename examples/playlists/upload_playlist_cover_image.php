#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

/** @var string $playlistId The Spotify identifier of the playlist. */
$playlistId = '7LdfI23xCLvCFA5122WePz';
$imagePath = __DIR__.'/cover.jpg';

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->uploadPlaylistCoverImage($playlistId, base64_encode(file_get_contents($imagePath)));

    SpotifyExample::printSuccess(sprintf("Successfully added %d track(s) to user's playlist %s", count($trackIds), $playlistId));
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}
