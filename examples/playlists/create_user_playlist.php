#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->createUserPlaylist(sprintf('Example playlist (%s)', date('Y-m-d H:i:s')), false);

    SpotifyExample::printSuccess(sprintf(
        "Playlist %s successfully created (%s)",
        $result->id,
        $result->external_urls->spotify
    ));
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}
