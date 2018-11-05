#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

/** @var string $trackId The Spotify id of the track to analyse. */
$trackId = '2ZuFFeKzcZvSPn45SGW7iF'; // Volcano (feat. Phoene Somsavath), by Saycet.

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->getTrackAnalysis($trackId);

    SpotifyExample::printSuccess('Track audio analysis:');
    SpotifyExample::printStdClass($result);
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}