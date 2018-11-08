<?php

require __DIR__ . '/../vendor/autoload.php';

use Bench1ps\Spotify\Session\SessionHandler;
use Bench1ps\Spotify\Session\Session;
use Bench1ps\Spotify\Authorization\Authorization;
use Bench1ps\Spotify\API\API;

class SpotifyExample
{
    const CREDENTIALS_FILE_PATH = __DIR__.'/credentials.json';

    /** @var array */
    static $credentials;

    /**
     * @param bool $withSession
     *
     * @return Authorization
     * @throws \Bench1ps\Spotify\Session\Exception\SessionException
     */
    public static function loadAuthorization($withSession = false): Authorization
    {
        $credentials = self::loadCredentials();
        $sessionHandler = new SessionHandler();

        if ($withSession) {
            $sessionHandler->addSession(new Session(
                uniqid(),
                self::$credentials['access_token'],
                self::$credentials['refresh_token'],
                3600
            ));
        }

        return new Authorization([
            'client_id' => $credentials['client_id'],
            'client_secret' => $credentials['client_secret'],
            'redirect_uri' => $credentials['redirect_uri'],
            'base_url' => 'https://accounts.spotify.com'
        ], $sessionHandler);
    }

    /**
     * @return API
     * @throws \Bench1ps\Spotify\Session\Exception\SessionException
     */
    public static function loadAPI(): API
    {
        $credentials = self::loadCredentials();
        $sessionHandler = new SessionHandler();
        $sessionHandler->addSession(new Session('foobar', $credentials['access_token'], '', 3600));

        return new API([
            'base_url' => 'https://api.spotify.com',
        ], $sessionHandler);
    }

    /**
     * Loads the credentials file.
     *
     * @return array
     */
    private static function loadCredentials()
    {
        if (!file_exists(self::CREDENTIALS_FILE_PATH)) {
            die("> Credentials file was not found. Please copy the file named credentials.dist.json to credentials.json and add your own parameters.\n");
        }

        self::$credentials = json_decode(file_get_contents(self::CREDENTIALS_FILE_PATH), true);

        return self::$credentials;
    }

    /**
     * Dumps the updated credentials file.
     */
    public static function dump()
    {
        $fp = fopen(self::CREDENTIALS_FILE_PATH, 'w+');
        fwrite($fp, json_encode(self::$credentials, JSON_PRETTY_PRINT));
        fclose($fp);
    }

    /**
     * @param string $message
     */
    public static function printInfo(string $message)
    {
        echo sprintf("> %s\n", $message);
    }

    /**
     * @param string $message
     */
    public static function printSuccess(string $message)
    {
        echo sprintf("\033[32m> %s\033[0m\n", $message);
    }

    /**
     * Prints an exception in the CLI and rethrows it.
     *
     * @param Throwable $e
     *
     * @throws Throwable
     */
    public static function printException(Throwable $e)
    {
        echo sprintf("\033[31m> %s\033[0m\n", $e->getMessage());

        throw $e;
    }

    /**
     * @param array         $items
     * @param bool          $withKeys
     * @param callable|null $function
     */
    public static function printList(array $items, bool $withKeys = false, callable $function = null)
    {
        if (is_null($function)) {
            $function = function ($item) {
                return $item;
            };
        }

        foreach ($items as $key => $item) {
            echo sprintf(
                "- %s%s\n",
                $withKeys ? $key.': ' : '',
                $function($item)
            );
        }
    }

    /**
     * @param stdClass $object
     */
    public static function printStdClass(\stdClass $object)
    {
        print_r($object);
    }
}