#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Bench1ps\Spotify\SpotifyClient;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyClientException;

/** @var string $accessToken The access token issued on behalf of the user. Replace by a valid access token. */
$accessToken = 'BQCuCrBcBuPKSb9H05MCxYMjMEv3IAOGak54ShRF0ueoasUnkvt4BFHN2G2FWNGBZnggkXGks-GUY2_-0Y8uWGpKoa-Pt1YT_pvLVhqy-53eEQH2ymNaL8n4vD92GqXkR0bskb83FYaJOxYHNNKW3j7BwKWFW0B3hX4hpsYaqqHuRj0HJkBfcvIYA-_d3NTBx_Lofdjxk6L2mE5KFAogv1vS628xhamhgWXxaL8hNLqEPjr4xWOez_YN23HW7xgxr1Ls-tyK1Wwgxi-VZ42AQP-Vqt2brEIMWYuWyY8nEkvGvsqcIefHD62EmQ';

$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $accessToken, '', 3600));
$client = new SpotifyClient($sessionHandler);

try {
    $client->createUserPlaylist('Example playlist', false);
} catch (SpotifyClientException $e) {
    echo $e->getMessage()."\n";
    die;
}

echo "Playlist successfully created\n";