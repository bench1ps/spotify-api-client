<?php

require __DIR__ . '/../vendor/autoload.php';

class SpotifyExample
{
    const CREDENTIALS_FILE_PATH = 'credentials/credentials.json';

    /**
     * @var string
     */
    static $credentials;

    /**
     * Loads the credentials file
     *
     * @return array
     */
    public static function load()
    {
        if (!file_exists(self::CREDENTIALS_FILE_PATH)) {
            die("> Credentials file was not found. Please copy the file named credentials.dist.json to credentials.json and add your own parameters.\n");
        }

        self::$credentials = json_decode(file_get_contents(self::CREDENTIALS_FILE_PATH), true);

        return self::$credentials;
    }

    /**
     * Dumps the updated credentials file
     */
    public static function dump()
    {
        $fp = fopen('credentials/credentials.json', 'w+');
        fwrite($fp, json_encode(self::$credentials, JSON_PRETTY_PRINT));
        fclose($fp);
    }
}