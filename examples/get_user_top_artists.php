#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Bench1ps\Spotify\SpotifyClient;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyClientException;

/** @var string $accessToken The access token issued on behalf of the user. Replace by a valid access token. */
$accessToken = 'BQDRWmbRG6v9ypcFBKOg44rdzglOywD7KWM3yIxZsF4eFcYzMqW0wspcOxtS15sN5WiLtJABwaUcBgnz41IY1r8kMZ4ei3AJfVQ_jk7-ktgvxDDlaQaUWcmLm9WB3sjzX2_VaQ6ugSYsM6BTaLwcJ6KdD7lBOSq6quIRCdhK4p70MedsdsnPPbB0gT6eymnBG3yPa383Xile1Bx7K5B_Oh01CWom-TrqywsC40-HQxy3dl18H2ry0-6V9HymL3WVogjR9kzfbtf1d40NpRHpzp8MgNWQWlk3Ch2IxVeoEM8nDPe-Tx15RghPdg';

$limit = 10;
$offset = 0;
$timeRange = SpotifyClient::TERM_LONG;

$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $accessToken, '', 3600));
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