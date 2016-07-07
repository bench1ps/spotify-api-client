<?php

namespace Bench1ps\Spotify;

use Bench1ps\Spotify\Exception\SessionException;
use Bench1ps\Spotify\Exception\SpotifyClientException;
use Bench1ps\Spotify\Session\SessionHandler;
use GuzzleHttp\Client;

class SpotifyClient
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

    /**
     * Available terms for calls returning top artists and tracks.
     */
    const TERM_SHORT = 'short_term';
    const TERM_MEDIUM = 'medium_term';
    const TERM_LONG = 'long_term';

    /**
     * @var SessionHandler
     */
    private $sessionHandler;

    /**
     * @var Client|Client
     */
    private $httpClient;

    /**
     * @param SessionHandler $sessionHandler
     */
    public function __construct(SessionHandler $sessionHandler)
    {
        $this->sessionHandler = $sessionHandler;
        $this->httpClient = new Client([
            'base_uri' => self::BASE_URI,
        ]);
    }

    /**
     * Returns the current user's profile information.
     *
     * @return \stdClass
     *
     * @throws SessionException
     */
    public function getCurrentUserProfile()
    {
        $this->assertSession();
        $options = [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->sessionHandler->getCurrentSession()->getAccessToken())
            ]
        ];

        $response = $this->request('GET', self::ENDPOINT_ME, $options);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Returns the current user's top artists.
     *
     * @param int    $limit
     * @param int    $offset
     * @param string $timeRange
     *
     * @return \stdClass
     *
     * @throws SessionException
     */
    public function getCurrentUserTopArtists($limit = 20, $offset = 0, $timeRange = self::TERM_MEDIUM)
    {
        $this->assertSession();
        $options = [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->sessionHandler->getCurrentSession()->getAccessToken())
            ],
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
                'time_range' => $timeRange
            ]
        ];

        $response = $this->request('GET', self::ENDPOINT_ME_TOP_ARTISTS, $options);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Returns the current user's top tracks.
     *
     * @param int    $limit
     * @param int    $offset
     * @param string $timeRange
     *
     * @return \stdClass
     *
     * @throws SessionException
     */
    public function getCurrentUserTopTracks($limit = 20, $offset = 0, $timeRange = self::TERM_MEDIUM)
    {
        $this->assertSession();
        $options = [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->sessionHandler->getCurrentSession()->getAccessToken())
            ],
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
                'time_range' => $timeRange
            ]
        ];

        $response = $this->request('GET', self::ENDPOINT_ME_TOP_TRACKS, $options);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Returns a list of recommendations based on seeds and track specification.
     *
     * @param int                     $limit
     * @param string|null             $market
     * @param TrackSpecification|null $specification
     * @param array                   $seedArtists
     * @param array                   $seedGenres
     * @param array                   $seedTracks
     *
     * @return \stdClass
     *
     * @throws SessionException
     */
    public function getRecommendations($limit = 20, $market = null, TrackSpecification $specification = null, array $seedArtists = [], array $seedGenres = [], array $seedTracks = [])
    {
        $this->assertSession();
        $options = [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->sessionHandler->getCurrentSession()->getAccessToken())
            ],
            'query' => [
                'limit' => $limit
            ]
        ];

        if (null !== $market) {
            $options['query']['market'] = $market;
        }

        if (null !== $specification) {
            foreach ($specification->getBag() as $attribute => $value) {
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

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Creates a playlist on the user's account.
     *
     * @param string $name
     * @param bool   $public
     * @param null   $userId
     *
     * @throws SessionException
     */
    public function createUserPlaylist($name, $public = true, $userId = null)
    {
        $this->assertSession();
        if (null === $userId) {
            $userId = $this->getCurrentUserProfile()->id;
        }

        $options = [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->sessionHandler->getCurrentSession()->getAccessToken()),
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'name' => $name,
                'public' => $public
            ])
        ];

        $this->request('POST', str_replace('{user_id}', $userId, self::ENDPOINT_PLAYLIST_CREATE), $options);
    }

    /**
     * Adds a collection of tracks to an existing user's playlist.
     *
     * @param string $playlistId The playlist identifier to add tracks in.
     * @param array  $trackIds   An array of Spotify URIs representing tracks:
     *                           [
     *                              "spotify:track:foobar",
     *                              "spotify:track:barbaz",
     *                              ...
     *                           ]
     * @param int    $userId     The identifier of the user owning the playlist.
     *
     * @throws SessionException
     */
    public function addTracksToUserPlaylist($playlistId, array $trackIds, $userId = null)
    {
        $this->assertSession();
        if (null === $userId) {
            $userId = $this->getCurrentUserProfile()->id;
        }

        $options = [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->sessionHandler->getCurrentSession()->getAccessToken()),
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'uris' => $trackIds
            ])
        ];

        $path = str_replace('{user_id}', $userId, self::ENDPOINT_PLAYLIST_ADD_TRACKS);
        $path = str_replace('{playlist_id}', $playlistId, $path);

        $this->request('POST', $path, $options);
    }

    /**
     * @throws SessionException
     */
    private function assertSession()
    {
        if (!$this->sessionHandler->isHandlingSession()) {
            throw new SessionException("An active session is required.");
        }
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $options
     *
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws SpotifyClientException
     */
    private function request($method, $path, array $options = [])
    {
        try {
            return $this->httpClient->request($method, $path, $options);
        } catch (\Exception $e) {
            throw new SpotifyClientException($e);
        }
    }
}