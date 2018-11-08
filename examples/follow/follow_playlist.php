#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

/** @var string The id of the playlist to follow $playlistId */
$playlistId = '36qQ3naFyPxCbbr7QpdADN';

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->followPlaylist($playlistId);

    SpotifyExample::printSuccess('User now follows this playlist');
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}