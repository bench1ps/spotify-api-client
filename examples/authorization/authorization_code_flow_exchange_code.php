#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Spotify\Exception\SpotifyException;

/**
 * @var string $authorizationCode
 *
 * The authorization code provided after the user has approved the application.
 * Use the authorization_code_flow_get_code example to get a new one.
 */
$authorizationCode = 'AQD_IXYc-1h0fg6SLd-VwRn5uRJskAd1EvvS1IIz2pvc-zts8xXfy_A7Bthi2QxhQLWMy0zSfJHn91L-Uak5xqGsHIC8OesYgb0cQhrBgsOfQ6B27kUHtFyuUKaHTzHljZHBkNYA3neHBwhUbKpVZB8aJbLt8V5HbJNZ3MXx-5NAqKDIjBaWj8IADUxsx31ZFeqhu3EvW_2JoNxA7uGVRcKVsB72XzhdnJsunyhcG2msLjGc8bCOBLGPnr7dTHpyvoo8ItEM8Jc5hddSHvkAhQa4x5XGiZvdBq1_hkxcAtzKCFNRCSs_WIoRbm_Y6cAc0kCj4rv8nwIGb9cHriKN3xFOYxqYXbDKdyVX0BIjFArdgOy7SZ3wZnvUx23gywZJZ1xRE_Eci-OWwpBzFAHXJPSaNGdlJ7dfLkaoGtWbFkMMb49C0NG0vqZMLycbBRLe88QwJHgoOrojOx7rPgojB7js1d77rhMEQJumEiY076K7SfYKxu4s3kXZeOM48Ky9-wg8V9l_OzhazD0hWfuf1pPkmUkTvjd8Z75uo0a0Hl5XVCWtEDWs6f46B1bvCqvmM_PHrEhGXJMqmf4hvhutgo0v-43yYh2nVEmHfTV0cVbxy1JbPlCGlB8r1C_03S_oWjxznkFct-hPSVxef5WBYwVIlGsUw4IWjoP0zL_rR9yh';

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