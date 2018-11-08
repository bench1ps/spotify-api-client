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
$authorizationCode = 'AQDOrJa3SDz8PRmlZUw5YuPEkvrVQpunhC15oIMgPrlbNkdFDl79cPrjgcVMJWooUZulOa33nxP4bwAodz_PFSXtqtV5s-X68eCE1rSBf39p-2zy73f7WWEaIo6SRn68RSQZcBIXxZUcgoTBvAYUCOdvHq0S9ANMy90GGkvJd5MndjjFFTL1Xe_q5oY2uB9-PNvZZhXntriskarwHCWcSKE8EMLbMie_4czcmN7bbR_zbNWvO4rtUFHBawJd3cdjxjN7J1RpH3BHEQVixBByAUxVPUj2u0UYfM7_dl6arlvL6Lj4ugk0YkzcxSFTtkH9rFv0uL539fm4pFPsT151RTtzO_6w3D0ll79qAyeigZfznSQnUW9KXIxYPYVioMiPZv3G6dYtwltJgzFg3AC2wTNblpVjCFSdw54wBm5HtaCVeYnbNip2NZI5kgLuMR7O0GX8Y6GO_qSrX_Q1nlxObqaZFxsfugojfZyt0mjCtg13u10HkjTuDAF6ZpEAhJnwRFjvIijOSL-PRF5W8NK739FghXwWrP8eDRTqknlLvQR1UtmR9HaYnKlyudWj9aN_IZZo73Z3EgLVXrE8uhUvpOqcIv7ooAtC_yGyi0DYdw4C_n4pY1oW1qWA5050-fj3Mri3KnJ83Q2DI3ZD4Rpw';

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