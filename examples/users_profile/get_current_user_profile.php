#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->getCurrentUserProfile();

    SpotifyExample::printSuccess('Current user profile information:');
    SpotifyExample::printList([
        'Name' => $result->display_name,
        'E-mail' => $result->email,
        'Country' => $result->country,
        'Birth date' => $result->birthdate,
        'Public URI' => $result->external_urls->spotify,
        'Number of followers' => $result->followers->total,
        'Spotify ID' => $result->id,
    ], true);
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}