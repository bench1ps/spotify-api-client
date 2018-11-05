#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->pausePlayback();

    SpotifyExample::printSuccess("Current user's playback was paused");
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}