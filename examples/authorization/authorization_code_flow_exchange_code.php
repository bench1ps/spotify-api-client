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
$authorizationCode = 'AQBR2Y2OEuF0Tdjhz0xuHbvvqBeA_Gtlr2RtpPIhugIBh9drEEcn-3EN4E9EEF3pL9c95IKCAKxsjqc0d2c3eSSOoZ8e0CQwjYUkRfsrC_0PVstSLsLd8SW7rF2ckjnFp4HVxczv6nGoaFBoL5PpA5oGggZX-8rLLn5g0FKYdwUpOVjRLfxFZtMUSWIXxYIW4zYMZfv5t9v-vzKYAipw4eHTcvSeTCBJ-fCPk6tpXPGAZO4_fF8fGmtpdDrxRDKYgIwEkkPxj6XOk3JkiwjKfWMFKkR3DrdEerki3GcBRkjWfje8sfYMq-zkCdp3sHOmmPcAEHuz-C1uKnDUzi8iueJcqbIB15is7ZlkjL_rKRdWI0KTsXTGEkxwyjqfoxxchSsIVkqlXPvSDaU0mVlS-zSrGBE_CBkNd4Ezsg3n_dYPl5PzPrCK_NZn4u5i8K2YCo2NXyEc00LbVpHod15Dbpis5Qc8AztraMM2NX8hLmjVpOQxxQ4Z1qjykN2iwJCEumI_-DKhwCmJLrjCUOnRGIsunuF37VLIB_34I1LM6419Nu-xZyZJNocqTApOm1n3yGGeprx6A0abuq0V0VeVpCWeYn9qfq_MEK5h5U6CnWx2cIjrHIWegomJmsKHLFAvToNtZGCvFwW77qzQ6hst';

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