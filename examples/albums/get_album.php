#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Spotify\Exception\SpotifyException;

/** @var string $albumId The Spotify id of the album to get. */
$albumId = '09ZGdaL9F1eSqKS8U9sKFt'; // Mozart: Requiem, by Wolfgang Amadeus Mozart.

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->getAlbum($albumId);

    SpotifyExample::printSuccess('Album information:');
    SpotifyExample::printList([
        'Name' => $result->name,
        'Artist' => $result->artists[0]->name,
        'Label' => $result->label,
        'Number of tracks' => $result->tracks->total,
        'Genres' => !empty($result->genres) ? implode(', ', $result->genres) : 'Unknown',
        'Spotify ID' => $result->id,
    ], true);
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}