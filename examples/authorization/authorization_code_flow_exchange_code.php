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
$authorizationCode = 'AQD-6S_WWeEz3LRjaoC6k-oyGUI9M1Nz5MdvYTwm6WZr98OgTYZ0uw6hbNZbUurithB82f_sXu2Ik3uS5q_Aj0-xo_Ggy-BUPROAhLhX2BiXYbAJEmFqA7Qk-swZi8XsXga9Nwy8jtcs3EwBxfG8-uWVofAuKTPb9TCKhTZLeuxdM9Me3iP_yF18673JB3lygJUkB66uEw1W-rG-7lcE2Cpw5egxB51k9PmEclkD5aGtj6hILCZf15OPTkZxrZT4KIl75d5kedVoIJK0iQaC8ezzL9BUAGdegYXD855vfQK8zn4GM3x5Wh7jigQORYNrAi2aNNCZR5sD2wE9lBQ0VPDyyMANUJC7vR-6r2rGTIJfRUHAoL-BWjuYW3OYnLGfByKCboNG33nZgUG9nj0LqJgdDMXVdlzSn3oxxYC2mvDMH157H6CA4vGAbzfbyhNiCVAt8ZuFMJlDT4xvRRQKVTPs6UI2nRIihTrPXaksXkENQ8Y7uLqapyYBCJkfuvoYAdWvRF9jLlVgJVn7WmPqkQjHoOS_hCaWkx8k5ZdCy27QxEL5Kay3X9rt19eK07WPPg9RsV0fKsHmvmiBHg7tr9qMDT6ORW6rX3Qb32x_SqtmQh7zIg7ZDazGM_MUiO2Wwyxt9lASb6X0pvGOawq7';

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