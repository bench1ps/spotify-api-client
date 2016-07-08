#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\Authentication;
use Bench1ps\Spotify\Session\SessionHandler;

/** @var string $authorizationCode The authorization code provided after the user has approved the application */
$authorizationCode = 'AQDU6X2MLGMVBFFt95naFhqexBk91syHSoTbiC5zDp5j7HMa_JXGMdWvcdY5-5b90DYefxYARoo0B1SLdzWozgIgAlxbbylxmmufac84VIJcdmnfSqe-QbffqPyQbLJ-tggKMIlpufTlgjaUYpww7x3lI7VJd7tkyhgxSHu7lOsxiSinv5ybgUdIgbXedwwK9b_xmg';

$credentials = SpotifyExample::load();
$sessionHandler = new SessionHandler();
$authentication = new Authentication($credentials, $sessionHandler);
$authentication->exchangeCode($authorizationCode);

SpotifyExample::$credentials['access_token'] = $authentication->getCurrentSession()->getAccessToken();
SpotifyExample::$credentials['refresh_token'] = $authentication->getCurrentSession()->getRefreshToken();
SpotifyExample::dump();

echo "> Authorization code successfully exchanged for access token:\n";
echo $authentication->getCurrentSession()->getAccessToken()."\n";
echo "> Use this refresh token to get a new access token:\n";
echo $authentication->getCurrentSession()->getRefreshToken()."\n";