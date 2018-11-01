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
    const BASE_URI = 'https://api.spotify.com';
    const ENDPOINT_ME = 'v1/me';
    const ENDPOINT_ME_TOP_ARTISTS = 'v1/me/top/artists';
    const ENDPOINT_ME_TOP_TRACKS = 'v1/me/top/tracks';
    const ENDPOINT_RECOMMENDATIONS = 'v1/recommendations';
    const ENDPOINT_PLAYLIST_CREATE = '/v1/users/{user_id}/playlists';
    const ENDPOINT_PLAYLIST_ADD_TRACKS = '/v1/users/{user_id}/playlists/{playlist_id}/tracks';
    const ENDPOINT_USER_PUBLIC_PROFILE = '/v1/users/{user_id}';

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
     * @param SessionHandler $sessionHandler
     */
    public function __construct(SessionHandler $sessionHandler)
    {
        parent::__construct(self::BASE_URI);

        $this->sessionHandler = $sessionHandler;
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
     * Creates a playlist on the user's account.
     *
     * @param string $name
     * @param bool   $public
     * @param null   $userId
     *
     * @throws NoActiveSessionException
     * @throws ClientException
     *
     * @return \stdClass
     */
    public function createUserPlaylist($name, $public = true, $userId = null)
    {
        $this->assertSession();
        if (null === $userId) {
            $userId = $this->getCurrentUserProfile()->id;
        }

        $options = array_merge($this->getDefaultOptions(), [
            'json' => [
                'name' => $name,
                'public' => $public,
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
