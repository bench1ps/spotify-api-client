#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Spotify\Exception\SpotifyException;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->getPlaybackInfo();

    if ($result) {
        SpotifyExample::printSuccess('Current playback information:');
        SpotifyExample::printStdClass($result->context);
    } else {
        SpotifyExample::printSuccess('No playback was found');
    }
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}