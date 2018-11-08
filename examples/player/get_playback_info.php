#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->getPlaybackInfo();

    SpotifyExample::printSuccess('Current playback information:');
    SpotifyExample::printStdClass($result->context);
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}