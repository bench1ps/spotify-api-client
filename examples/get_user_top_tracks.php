#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\SpotifyClient;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyClientException;

$limit = 10;
$offset = 0;
$timeRange = SpotifyClient::TERM_LONG;

$credentials = SpotifyExample::load();
$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $credentials['access_token'], '', 3600));
$client = new SpotifyClient($sessionHandler);

try {
    $result = $client->getCurrentUserTopTracks($limit, $offset, $timeRange);
} catch (SpotifyClientException $e) {
    echo $e->getMessage()."\n";
    die;
}

echo "User's top tracks:\n";
foreach ($result->items as $item) {
    $artists = [];
    foreach ($item->artists as $artist) {
        $artists[] = $artist->name;
    }
    echo "- ".$item->name." by ".implode(',', $artists)." (".$item->external_urls->spotify.")\n";
}