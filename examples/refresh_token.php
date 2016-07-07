#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Bench1ps\Spotify\Authentication;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;

$configuration = [
    'client_id' => 'b3d3fa5d017043e78038b70f6990b840',
    'client_secret' => 'f3408f0cdb9042648d1f2647a1ec6860',
    'redirect_uri' => 'http://localhost:8888/callback',
];

/** @var string $accessToken The access token issued on behalf of the user. Replace by a valid access token. */
$accessToken = 'BQD4rsSqn48MXLJPwwZbjYitft_9qew_XJGviGK59PN7kzEuzqVrFGPlQbiwADlvioAdiRf0vMs9cjKFYNe0JMv5sH-ny6d8ARdRTbG7bjxR32VNwGotMr4mu2hrr4Mt0CtE61QF-tKVyGd1k8p_PP9g-4ndSo8yqzva7h-MpCkdO8cV3eiiFWm1GV6sEUPpCRo6GxCdnqGYGcXZK2XowdhxmEA-iHowrGXw697KxvFnPNw1dV_kBYjlGVnreQ01WEM1RDAm8tGJrTRCfZj7QozQf9XTSkoQNJ-W0ZB0xcfz52uayB9eRWzLUA';
$refreshToken = 'AQBLgZyKcj1gCjaHRr51eqyiw2H75CAEHAmsweSTY7sUF9xt-rwAIak5EwgeRYL5geUrgh6m7joKFm86ZeQ8iRuixMOOyLE5m1JOfQlKwYJN_XvmKCYEAUaZ_kY8EKFPFV0';

$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $accessToken, $refreshToken, 3600));
$authentication = new Authentication($configuration, $sessionHandler);
$authentication->refreshToken();

echo "Successfully fetched a new access token using the refresh token:\n";
echo $authentication->getCurrentSession()->getAccessToken()."\n";