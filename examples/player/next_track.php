#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Spotify\Exception\SpotifyException;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->nextTrack();

    SpotifyExample::printSuccess("Current user's playback was moved to next track");
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}