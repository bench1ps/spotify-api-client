#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Spotify\API\API;
use Spotify\Exception\SpotifyException;

$limit = 10;
$offset = 0;
$timeRange = API::RANGE_LONG;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->getCurrentUserTopTracks($limit, $offset, $timeRange);

    SpotifyExample::printSuccess(sprintf('Found %d top tracks (%s):', count($result->items), $timeRange));
    SpotifyExample::printList($result->items, false, function (stdClass $track) {
        return sprintf('%s by %s (%s)', $track->name, $track->artists[0]->name, $track->external_urls->spotify);
    });
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}