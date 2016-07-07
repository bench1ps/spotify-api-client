#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Bench1ps\Spotify\SpotifyClient;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyClientException;

/** @var string $accessToken The access token issued on behalf of the user. Replace by a valid access token. */
$accessToken = 'BQBmWFk7a15R-roWHiw91yrbrKIkEpCeSpK-CWRCDVtPh5rG2sJJjyHHtgF5hMgyELCqIS3GIZdQsKZ7hrLfJrVxq2QLQGhXgmgtwV8MySx1pCy1P-M3Mh9uH_Hji0d5O0zDeOEH9-svVw78_1s2FQbHIF8tD7ptrlx6akHp5gnxG-UNLw8yTWCFQsRJCEoJiVCd0u670QJabe0ddhEx4WjWs3K7FOSbTCLGaUMeYrnTESJ17oLdvZEhd97rgyl_u0AeJ6SSqsm0bfJ9a5EDECbwxBsCm11r42eu08hc36bzHa9egIKbhTP5fA';

$limit = 10;
$offset = 0;
$timeRange = SpotifyClient::TERM_LONG;

$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $accessToken, '', 3600));
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