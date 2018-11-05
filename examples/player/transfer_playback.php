#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

$deviceId = 'd1da4cbddbccdc5f27f0ead4ae51596fcffd3405';

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->transferPlayback($deviceId);

    SpotifyExample::printSuccess("Playback was transferred to device");
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}