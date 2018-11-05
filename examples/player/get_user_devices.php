#!/usr/bin/env php
<?php

require __DIR__.'/../bootstrap.php';

use Bench1ps\Spotify\Exception\SpotifyException;

try {
    $API = SpotifyExample::loadAPI();
    $result = $API->getUserDevices();

    SpotifyExample::printSuccess(sprintf('Current user has %d available device(s)', count($result->devices)));
    SpotifyExample::printList($result->devices, false, function (stdClass $device) {
        return sprintf('%s (%s%s)', $device->name, $device->id, $device->is_active ? ', current active device' : '');
    });
} catch (SpotifyException $e) {
    SpotifyExample::printException($e);
}