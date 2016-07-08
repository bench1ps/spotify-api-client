#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\SpotifyClient;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyClientException;

$credentials = SpotifyExample::load();
$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $credentials['access_token'], '', 3600));
$client = new SpotifyClient($sessionHandler);

try {
    $result = $client->createUserPlaylist(sprintf('Example playlist (%s)', date('Y-m-d H:i:s')), false);
} catch (SpotifyClientException $e) {
    echo $e->getMessage()."\n";
    die;
}

echo sprintf("Playlist %s successfully created\n", $result->id);