#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Spotify\Exception\SpotifyException;

/** @var string $userId The Spotify id of the user to get. */
$userId = 'benchips';

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->getUserPublicProfile($userId);

    SpotifyExample::printSuccess('User public profile information:');
    SpotifyExample::printList([
        'Name' => $result->display_name,
        'Public URI' => $result->external_urls->spotify,
        'Number of followers' => $result->followers->total,
    ], true);
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}