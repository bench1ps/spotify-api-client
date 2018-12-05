#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Spotify\API\API;
use Spotify\Exception\SpotifyException;

$nbArtists = 10;
$offset = 0;
$timeRange = API::RANGE_LONG;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->getCurrentUserTopArtists($nbArtists, $offset, $timeRange);

    SpotifyExample::printSuccess(sprintf('Found %d top artists (%s):', count($result->items), $timeRange));
    SpotifyExample::printList($result->items, false, function (stdClass $artist) {
        return sprintf('%s (%s)', $artist->name, $artist->external_urls->spotify);
    });
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}
