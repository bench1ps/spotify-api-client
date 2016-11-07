<?php

namespace Bench1ps\Spotify;

class TrackSpecification
{
    /** @var array List of supported attributes */
    private $attributes = [
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

    /** @var array The bag of attributes that define the specification */
    private $bag = [];

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function add($attribute, $value)
    {
        if (!in_array($attribute, $this->attributes)) {
            throw new \Exception("$attribute is not a valid attribute");
        }

        $this->bag[$attribute] = $value;

        return $this;
    }

    /**
     * @param string $attribute
     *
     * @return mixed|null
     * @throws \Exception
     */
    public function get($attribute)
    {
        if (!in_array($attribute, $this->attributes)) {
            throw new \Exception("$attribute is not a valid attribute");
        }

        return isset($this->bag[$attribute]) ? $this->bag[$attribute] : null;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->bag;
    }
}