#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

$scopes = [
    'playlist-read-private',
    'playlist-read-collaborative',
    'playlist-modify-public',
    'playlist-modify-private',
    'streaming',
    'user-follow-modify',
    'user-follow-read',
    'user-library-read',
    'user-library-modify',
    'user-read-private',
    'user-read-birthdate',
    'user-read-email',
    'user-top-read',
    'user-read-playback-state',
    'user-read-currently-playing',
    'user-modify-playback-state',
    'ugc-image-upload',
];

try {
    $authentication = SpotifyExample::loadAuthorization();
    $query = $authentication->getAuthorizationQuery($scopes, true);

    SpotifyExample::printSuccess('Call this URL to fetch an authorization code:');
    SpotifyExample::printInfo($query);
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}