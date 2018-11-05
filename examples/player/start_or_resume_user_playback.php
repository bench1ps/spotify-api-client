#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

// Start or resume current context on active device.
$deviceId = null;
$contextURI = null;
$URIS = [];
$offset = null;
$position = null;

// Start or resume current context on a specific device.
//$deviceId = ''; // Replace by one of your devices.
//$contextURI = null;
//$URIS = [];
//$offset = null;
//$position = null;

// Jump to an album or artist.
//$deviceId = null;
//$contextURI = 'spotify:album:6H7maziO6BNZy6aYebiWjE'; // Essential Adagios, bu various artists.
//$URIS = [];
//$offset = null;
//$position = null;

// Jump to a list of tracks.
//$deviceId = null;
//$contextURI = null;
//$URIS = [
//    'spotify:track:7B0ShcXuS8BcUYTPfkjItz', // The Snowstorm: I. Troika, by Georgy Sviridov.
//    'spotify:track:2kAgCRZPG3YQR2VMqRvLmb', // The Lark Ascending, by Ralph Vaughan Williams.
//];
//$offset = null;
//$position = null;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->startOrResumePlayback($deviceId, $contextURI, $URIS, $offset, $position);

    SpotifyExample::printSuccess("Current user's playback was started/resumed");
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}