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
    $result = $client->getCurrentUserTopArtists($limit, $offset, $timeRange);
} catch (SpotifyClientException $e) {
    echo $e->getMessage()."\n";
    die;
}

echo "User's top artists:\n";
foreach ($result->items as $item) {
    echo "- ".$item->name." (".$item->external_urls->spotify.")\n";
}