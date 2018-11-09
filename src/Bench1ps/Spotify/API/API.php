<?php

namespace Bench1ps\Spotify\API;

use Bench1ps\Spotify\API\Exception\NoActiveSessionException;
use Bench1ps\Spotify\Client;
use Bench1ps\Spotify\Exception\ClientException;
use Bench1ps\Spotify\Session\SessionHandler;

class API extends Client
{
    /**
     * Supported API endpoints.
     */
    const ENDPOINT_GET_ALBUM = '/v1/albums/{album_id}';
    const ENDPOINT_ME = '/v1/me';
    const ENDPOINT_ME_TOP_ARTISTS = '/v1/me/top/artists';
    const ENDPOINT_ME_TOP_TRACKS = '/v1/me/top/tracks';
    const ENDPOINT_RECOMMENDATIONS = 'v1/recommendations';
    const ENDPOINT_FOLLOW_PLAYLIST = 'v1/playlists/{playlist_id}/followers';
    const ENDPOINT_PLAYLIST_CREATE = '/v1/users/{user_id}/playlists';
    const ENDPOINT_PLAYLIST_ADD_TRACKS = '/v1/users/{user_id}/playlists/{playlist_id}/tracks';
    const ENDPOINT_PLAYLIST_UPLOAD_IMAGE = '/v1/playlists/{playlist_id}/images';
    const ENDPOINT_USER_PUBLIC_PROFILE = '/v1/users/{user_id}';
    const ENDPOINT_USER_DEVICES = '/v1/me/player/devices';
    const ENDPOINT_PLAYBACK_INFO = '/v1/me/player';
    const ENDPOINT_PAUSE_PLAYBACK = '/v1/me/player/pause';
    const ENDPOINT_START_OR_RESUME_PLAYBACK = '/v1/me/player/play';
    const ENDPOINT_NEXT_TRACK = '/v1/me/player/next';
    const ENDPOINT_TRANSFER_PLAYBACK = '/v1/me/player';
    const ENDPOINT_TRACK_ANALYSIS = '/v1/audio-analysis/{track_id}';

    /**
     * Available ranges for calls returning top artists and tracks.
     */
    const RANGE_SHORT = 'short_term';
    const RANGE_MEDIUM = 'medium_term';
    const RANGE_LONG = 'long_term';

    /** @var array List of supported tuneable track attributes */
    public static $trackAttributes = [
        'min_acousticness',
        'max_acousticness',
        'taget_acousticness',
        'min_danceability',
        'max_danceability',
        'target_danceability',
        'min_duration',
        'max_duration',
        'target_duration',
        'min_energy',
        'max_energy',
        'target_energy',
        'min_instrumentalness',
        'max_instrumentalness',
        'target_instrumentalness',
        'min_key',
        'max_key',
        'target_key',
        'min_liveness',
        'max_liveness',
        'target_liveness',
        'min_loudness',
        'max_loudness',
        'target_loudness',
        'min_mode',
        'max_mode',
        'target_mode',
        'min_popularity',
        'max_popularity',
        'target_popularity',
        'min_speechiness',
        'max_speechiness',
        'target_speechiness',
        'min_tempo',
        'max_tempo',
        'target_tempo',
        'min_timesignature',
        'max_timesignature',
        'target_timesignature',
        'min_valence',
        'max_valence',
        'target_valence',
    ];

    /** @var SessionHandler */
    private $sessionHandler;

    /**
     * @param array          $configuration
     * @param SessionHandler $sessionHandler
     */
    public function __construct(array $configuration, SessionHandler $sessionHandler)
    {
        parent::__construct($configuration['base_url'], $configuration['proxy'] ?? null);

        $this->sessionHandler = $sessionHandler;
    }

    /**
     * Returns an album information.
     *
     * @param string $albumId
     *
     * @return \stdClass
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function getAlbum(string $albumId): \stdClass
    {
        $this->assertSession();

        $options = array_merge($this->getDefaultOptions(), [
            'query' => [
                'id' => $albumId,
            ],
        ]);

        $response = $this->request('GET', str_replace('{album_id}', $albumId, self::ENDPOINT_GET_ALBUM), $options);

        return json_decode($response->getBody());
    }

    /**
     * Returns the current user's profile information.
     *
     * @return \stdClass
     *
     * @throws NoActiveSessionException
     * @throws ClientException
     */
    public function getCurrentUserProfile(): \stdClass
    {
        $this->assertSession();
        $response = $this->request('GET', self::ENDPOINT_ME, $this->getDefaultOptions());

        return json_decode($response->getBody());
    }

    /**
     * Returns a user's public profile information.
     *
     * @param string $userId
     *
     * @return \stdClass
     *
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function getUserPublicProfile(string $userId): \stdClass
    {
        $this->assertSession();
        $response = $this->request('GET', str_replace('{user_id}', $userId, self::ENDPOINT_USER_PUBLIC_PROFILE), $this->getDefaultOptions());

        return json_decode($response->getBody());
    }

    /**
     * Returns the current user's top artists.
     *
     * @param int    $limit
     * @param int    $offset
     * @param string $timeRange
     *
     * @throws NoActiveSessionException
     * @throws ClientException
     *
     * @return \stdClass
     */
    public function getCurrentUserTopArtists($limit = 20, $offset = 0, $timeRange = self::RANGE_MEDIUM)
    {
        $this->assertSession();
        $options = array_merge($this->getDefaultOptions(), [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
                'time_range' => $timeRange,
            ],
        ]);

        $response = $this->request('GET', self::ENDPOINT_ME_TOP_ARTISTS, $options);

        return json_decode($response->getBody());
    }

    /**
     * Returns the current user's top tracks.
     *
     * @param int    $limit
     * @param int    $offset
     * @param string $timeRange
     *
     * @throws NoActiveSessionException
     * @throws ClientException
     *
     * @return \stdClass
     */
    public function getCurrentUserTopTracks($limit = 20, $offset = 0, $timeRange = self::RANGE_MEDIUM)
    {
        $this->assertSession();
        $options = array_merge($this->getDefaultOptions(), [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
                'time_range' => $timeRange,
            ],
        ]);

        $response = $this->request('GET', self::ENDPOINT_ME_TOP_TRACKS, $options);

        return json_decode($response->getBody());
    }

    /**
     * Returns a list of recommendations based on seeds and track specification.
     *
     * @param int         $limit
     * @param string|null $market
     * @param array       $trackAttributes
     * @param array       $seedArtists
     * @param array       $seedGenres
     * @param array       $seedTracks
     *
     * @return \stdClass
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function getRecommendations($limit = 20, $market = null, array $trackAttributes = [], array $seedArtists = [], array $seedGenres = [], array $seedTracks = [])
    {
        $this->assertSession();
        $trackAttributes = $this->filterTrackAttributes($trackAttributes);

        $options = array_merge($this->getDefaultOptions(), [
            'query' => [
                'limit' => $limit,
            ],
        ]);

        if (null !== $market) {
            $options['query']['market'] = $market;
        }

        if (null !== $trackAttributes) {
            foreach ($trackAttributes as $attribute => $value) {
                $options['query'][$attribute] = $value;
            }
        }

        if (!empty($seedArtists)) {
            $options['query']['seed_artists'] = implode(',', $seedArtists);
        }

        if (!empty($seedGenres)) {
            $options['query']['seed_genres'] = implode(',', $seedGenres);
        }

        if (!empty($seedTracks)) {
            $options['query']['seed_tracks'] = implode(',', $seedTracks);
        }

        $response = $this->request('GET', self::ENDPOINT_RECOMMENDATIONS, $options);

        return json_decode($response->getBody());
    }

    /**
     * @param string $playlistId
     *
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function followPlaylist(string $playlistId)
    {
        $this->assertSession();
        $this->request('PUT', str_replace('{playlist_id}', $playlistId, self::ENDPOINT_FOLLOW_PLAYLIST), $this->getDefaultOptions());
    }

    /**
     * Creates a playlist on the user's account.
     *
     * @param string      $name
     * @param bool        $public
     * @param bool        $collaborative
     * @param string|null $userId
     * @param string|null $description
     *
     * @return \stdClass
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function createUserPlaylist($name, $public = true, bool $collaborative = false, ?string $userId = null, ?string $description = null)
    {
        $this->assertSession();
        if (null === $userId) {
            $userId = $this->getCurrentUserProfile()->id;
        }

        $options = array_merge($this->getDefaultOptions(), [
            'json' => [
                'name' => $name,
                'public' => $public,
                'collaborative' => $collaborative,
                'description' => $description,
            ],
        ]);

        $response = $this->request('POST', str_replace('{user_id}', $userId, self::ENDPOINT_PLAYLIST_CREATE), $options);

        return json_decode($response->getBody());
    }

    /**
     * Adds a collection of tracks to an existing user's playlist.
     *
     * @param string $playlistId The playlist identifier to add tracks in.
     * @param array  $trackIds   An array of Spotify URIs representing tracks:
     *                           [
     *                               "spotify:track:foobar",
     *                               "spotify:track:barbaz",
     *                               ...
     *                           ]
     * @param int    $userId     The identifier of the user owning the playlist.
     *
     * @throws NoActiveSessionException
     * @throws ClientException
     */
    public function addTracksToUserPlaylist($playlistId, array $trackIds, $userId = null)
    {
        $this->assertSession();
        if (null === $userId) {
            $userId = $this->getCurrentUserProfile()->id;
        }

        $options = array_merge($this->getDefaultOptions(), [
            'json' => [
                'uris' => $trackIds,
            ],
        ]);

        $path = str_replace('{user_id}', $userId, self::ENDPOINT_PLAYLIST_ADD_TRACKS);
        $path = str_replace('{playlist_id}', $playlistId, $path);

        $this->request('POST', $path, $options);
    }

    /**
     * @param string $playlistId
     * @param string $imageData
     *
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function uploadPlaylistCoverImage(string $playlistId, string $imageData)
    {
        $this->assertSession();

        $options = array_merge_recursive($this->getDefaultOptions(), [
            'headers' => [
                'Content-Type' => 'image/jpeg',
            ],
            'body' => $imageData,
        ]);

        $this->request('PUT', str_replace('{playlist_id}', $playlistId, self::ENDPOINT_PLAYLIST_UPLOAD_IMAGE), $options);
    }

    /**
     * Returns the current user's available devices.
     *
     * @return \stdClass
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function getUserDevices(): \stdClass
    {
        $this->assertSession();
        $response = $this->request('GET', self::ENDPOINT_USER_DEVICES, $this->getDefaultOptions());

        return json_decode($response->getBody());
    }

    /**
     * @return \stdClass|null
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function getPlaybackInfo(): ?\stdClass
    {
        $this->assertSession();
        $response = $this->request('GET', self::ENDPOINT_PLAYBACK_INFO, $this->getDefaultOptions());

        return json_decode($response->getBody());
    }

    /**
     * Pauses the current user's playback.
     *
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function pausePlayback()
    {
        $this->assertSession();
        $this->request('PUT', self::ENDPOINT_PAUSE_PLAYBACK, $this->getDefaultOptions());
    }

    /**
     * Starts or resumes the playback on a current user's device.
     * Only one parameter of either $context or $URIs should be specified.
     *
     * @param string|null $deviceId   The identifier of the user's device.
     *                                If omitted, the playback will be started or resumed on the user's active device.
     * @param string|null $contextURI Spotify URI of the context to play. Can be either an album, artist, or playlist.
     * @param array       $URIs       Array of Spotify track URIs to play.
     * @param int|string  $offset     From where in the context the playback should start.
     *                                Use this parameter only when $contextURI is an album or a playlist, or when $URIs in not empty.
     *                                Can be either an integer or a Spotify URI.
     * @param null        $position   From where the playback should start in milliseconds.
     *
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function startOrResumePlayback(string $deviceId = null, string $contextURI = null, array $URIs = [], $offset = null, $position = null)
    {
        $this->assertSession();

        $options = $this->getDefaultOptions();
        if ($deviceId) {
            $options['query']['device_id'] = $deviceId;
        }

        if ($contextURI) {
            $options['json']['context_uri'] = $contextURI;
        }

        if ($URIs) {
            $options['json']['uris'] = $URIs;
        }

        if ($offset) {
            if (is_int($offset)) {
                $options['json']['offset'] = $offset;
            } elseif (is_string($offset)) {
                $options['json']['offset'] = [
                    'uri' => $offset,
                ];
            }
        }

        if ($position) {
            $options['body']['position_ms'] = $position;
        }

        $this->request('PUT', self::ENDPOINT_START_OR_RESUME_PLAYBACK, $options);
    }

    /**
     * Transfer the playback from the active device to another device.
     *
     * @param string $deviceId
     *
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function transferPlayback(string $deviceId)
    {
        $this->assertSession();
        $options = array_merge($this->getDefaultOptions(), [
            'json' => [
                'device_ids' => [
                    $deviceId,
                ],
                'play' => true,
            ],
        ]);

        $this->request('PUT', self::ENDPOINT_TRANSFER_PLAYBACK, $options);
    }

    /**
     * Skip current playback to the next track.
     *
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function nextTrack()
    {
        $this->assertSession();
        $this->request('POST', self::ENDPOINT_NEXT_TRACK, $this->getDefaultOptions());
    }

    /**
     * Returns a detailed audio analysis of a track.
     *
     * @param string $trackId
     *
     * @return \stdClass
     * @throws ClientException
     * @throws NoActiveSessionException
     */
    public function getTrackAnalysis(string $trackId): \stdClass
    {
        $this->assertSession();
        $response = $this->request('GET', str_replace('{track_id}', $trackId, self::ENDPOINT_TRACK_ANALYSIS), $this->getDefaultOptions());

        return json_decode($response->getBody());
    }

    /**
     * Asserts that an active session is managed by the session handler.
     * If no session is handled, a {@see NoActiveSessionException} will be thrown.
     *
     * @throws NoActiveSessionException
     */
    private function assertSession()
    {
        if (!$this->sessionHandler->isHandlingSession()) {
            throw new NoActiveSessionException();
        }
    }

    /**
     * @return array
     */
    private function getDefaultOptions(): array
    {
        return [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->sessionHandler->getCurrentSession()->getAccessToken()),
            ],
        ];
    }

    /**
     * @param array $trackAttributes
     *
     * @return array
     */
    private function filterTrackAttributes(array $trackAttributes): array
    {
        return array_filter($trackAttributes, function (string $trackAttribute) {
            return in_array($trackAttribute, self::$trackAttributes);
        });
    }
}
