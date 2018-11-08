#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

/**
 * @var string $authorizationCode
 *
 * The authorization code provided after the user has approved the application.
 * Use the authorization_code_flow_get_code example to get a new one.
 */
$authorizationCode = 'AQA7sTi8GcPubLDmDaV9o9Vz_MVMh3DNrnzXhI9HiumRp3-EpDE7FvfcWucrbzsOSQukkhLKL6Hlu809UK8o94d0R_ZFisaXPCJtFu2QhzCP2mwkVieW_UQFtzSF2Oa3iuc94KldpPGhfUiN3ByOfPXGlcmdxBZf11riuQwfk9ZbX5MytRhFFDUwra0yEZxIUv4ZOW50FIwhPv4SXF_rw52YaoVL8-PQO5QAAer0e65Sg4QI1ebkLIIHmcWlK89vsYfvGqOWZFGGFcnfXw51HR_pwowZBOheXhrnJMnLHE9hK80svW0es3PwoS2pH7510dA14oFQH_zSc_GaT4bSNGO1qWyvCC3JrslgUv4nU3LpixlpyA7VG3n4ZWzV-aWZqC67TOJoNshv02ZQPwdIgFLdff7WwLLAQYv4LQAxlwdrIkochMi4JdKldHlJbmgef6rqrWjX-sL2nUjwLVRmAvyiaPyEMK8jRIPbtr2FVhNU8b4raQ3BSp_uVCP0A3XgTdNlOx7spvcUophchvd3pliEAkNMGZOicblUe1naO1md3rT8sbTtrNlJVpYZknPNd-8bjB5nmLoRAx0cr9wJokCSpIfEtv-CXKdczRyYqtRIEFHX-Ns0hiqUf9Jv5AvbbU-_QByXGIna1dA02gej';

try {
    $authentication = SpotifyExample::loadAuthorization();
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