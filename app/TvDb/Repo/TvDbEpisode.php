<?php

namespace TvDb\Repo;


class TvDbEpisode
{

    public $id          = 0;
    public $number      = 0;
    public $season      = 0;
    public $directors   = array();
    public $guestStars  = array();
    public $writers     = array();
    public $name        = '';
    public $imdbId      = '';
    public $language    = TvDbClient::DEFAULT_LANGUAGE;
    public $overview    = '';
    public $rating      = '';
    public $ratingCount = 0;
    public $seasonId    = 0;
    public $serieId     = 0;
    public $thumbnail   = '';
    public $firstAired;
    public $lastUpdated;



    public function __construct($data)
    {
        $this->id          = (int)$data->id;
        $this->number      = (int)$data->EpisodeNumber;
        $this->season      = (int)$data->SeasonNumber;
        $this->directors   = (array)TvDbClient::removeEmptyIndexes(explode('|', (string)$data->Director));
        $this->name        = (string)$data->EpisodeName;
        $this->firstAired  = (string)$data->FirstAired !== '' ? new \DateTime((string)$data->FirstAired) : null;
        $this->guestStars  = TvDbClient::removeEmptyIndexes(explode('|', (string)$data->GuestStars));
        $this->imdbId      = (string)$data->IMDB_ID;
        $this->language    = (string) $data->Language;
        $this->overview    = (string)$data->Overview;
        $this->rating      = (string)$data->Rating;
        $this->ratingCount = (int)$data->RatingCount;
        $this->lastUpdated = \DateTime::createFromFormat('U', (int)$data->lastupdated);
        $this->writers     = (array)TvDbClient::removeEmptyIndexes(explode('|', (string)$data->Writer));
        $this->thumbnail   = (string)$data->filename;
        $this->seasonId    = (int)$data->seasonid;
        $this->serieId     = (int)$data->seriesid;
    }
}
