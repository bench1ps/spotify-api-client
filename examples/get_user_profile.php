#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Bench1ps\Spotify\SpotifyClient;
use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Exception\SpotifyClientException;

/** @var string $accessToken The access token issued on behalf of the user. Replace by a valid access token. */
$accessToken = 'BQBFqykGQ-EQmrN-zSngmA3fEiGZJ00xpIk5nnYg6Yvc_X1eq5R3Oit6iwjE_mu144TjacROMEwkX1U5v_RhY5tpBiC24jvX8hydInpvfapn-3aYHpDUZ3u6a40LutCKTQF873yNw71Hjxfd1_n1pZ_Lraa5lF0TXbWeqaeJVcgHXGsWtWwEdhFx0qwZG8lX0s6kEhyDAV6DB4beGj59qCP47VTIuV_22zde3W_TAShOdV9TuJ5hz4Yjys9DvC6y1e8-I0jXhW6kgD3txUw5obmkoUPpqJNox6t9oxeCPh2KIskasc8DnFee';

$sessionHandler = new SessionHandler();
$sessionHandler->addSession(new Session('foobar', $accessToken, '', 3600));
$client = new SpotifyClient($sessionHandler);

try {
    $result = $client->getCurrentUserProfile();
} catch (SpotifyClientException $e) {
    echo $e->getMessage()."\n";
    die;
}

echo "User profile information:\n";
echo "- E-mail: ".$result->email."\n";
echo "- Country: ".$result->country."\n";
echo "- Birth date: ".$result->birthdate."\n";
echo "- Spotify URI: ".$result->uri."\n";