#!/usr/bin/env php
<?php

require 'bootstrap.php';

use Bench1ps\Spotify\Authorization\Authorization;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Exception\SpotifyException;

/**
 * @var string $authorizationCode
 *
 * The authorization code provided after the user has approved the application.
 * Use the authorization_code_flow_get_code example to get a new one.
 */
$authorizationCode = 'AQCL-loLuhkz1S1JuXL9FBGnhyZxjmWi22ah1aTv-CZAdGAt-BNE8NnucXgZloHfv0Ja74HW3rY5Q0jRd2r6FtAYgknaMc425T8bZokYu37HXloieuisHpoGLBrwJa9B56eh1d3XUBsECr1u9Fn_QCxpPCrVECK2oGfeOdGbJts7QSQ2FcGu_Q0tiyh_-mHZe1YZDP1kWetXBs-raG3X9g0eM840DXVEV4Maq30WONSVJDO7Z5hYSz-1iTlRdB5P6coTENTDPpRRe5gTKnb7B289WpQr_P_yXdwhAtZJ06-DjiqnC-U4RB3CT7_Oxp3bv5o_RV4iRMYUEI1DnU6nKE1bAB2qRN1Z8oNRrkSOR64n_nHwSo9dGYHdvMuOiA8MmNqqFn1BZVa4dPw1Lh51J62X2FQWpCukOv99X7uPXkZiFxsCBqCAMGJWerzPEpMeyw0nZizmtqyVUbQm7en-pAXvD3iBjbML6Q3onJ33Zcr5qd6nXJGjAv9GOyP2uUUmAGdo56lVw3-u_T5mx8Ed6R7qTCqjo2W8OTTKNw';

try {
    $credentials = SpotifyExample::load();
    $sessionHandler = new SessionHandler();
    $authentication = new Authorization($credentials, $sessionHandler);
    $authentication->exchangeCode($authorizationCode);

    SpotifyExample::$credentials['access_token'] = $authentication->getCurrentSession()->getAccessToken();
    SpotifyExample::$credentials['refresh_token'] = $authentication->getCurrentSession()->getRefreshToken();
    SpotifyExample::dump();

    SpotifyExample::printSuccess('Authorization code successfully exchanged for access token.');
    SpotifyExample::printInfo('Credentials were copied to examples/credentials/credentials.json.');
    SpotifyExample::printInfo('You can now run the other examples to query the Spotify API.');
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}