<?php

namespace TvDb\Repo;

class TvDbSeries
{
    public $id;
    public $language;
    public $name;
    public $banner;
    public $overview;
    public $firstAired;
    public $imdbId;
    public $added;
    public $addedBy;
    public $lastUpdated;
    public $actors        = array();
    public $airsDayOfWeek = '';
    public $airsTime      = '';
    public $contentRating = '';
    public $genres        = array();
    public $network       = '';
    public $rating        = '';
    public $ratingCount   = 0;
    public $runtime       = 0;
    public $status        = '';
    public $fanArt        = '';
    public $poster        = '';
    public $zap2ItId      = '';
    public $aliasNames    = array();

    public function __construct($data)
    {
        $this->id            = (int)$data->id;
        $this->language      = (string)$data->Language;

        if(isset($data->language)) {
            $this->language  = (string)$data->language;
        }

        $this->name          = (string)$data->SeriesName;
        $this->banner        = (string)$data->banner;
        $this->overview      = (string)$data->Overview;
        $this->firstAired    = new \DateTime((string)$data->FirstAired);
        $this->imdbId        = (string)$data->IMDB_ID;
        $this->actors        = (array)TvDbClient::removeEmptyIndexes(explode('|', (string)$data->Actors));
        $this->airsDayOfWeek = (string)$data->Airs_DayOfWeek;
        $this->airsTime      = new \DateTime("1980-01-01 ".(string)$data->Airs_Time);
        $this->contentRating = (string)$data->ContentRating;
        $this->genres        = (array)TvDbClient::removeEmptyIndexes(explode('|', (string)$data->Genre));
        $this->network       = (string)$data->Network;
        $this->rating        = (string)$data->Rating;
        $this->ratingCount   = (string)$data->RatingCount;
        $this->runtime       = (int)$data->Runtime;
        $this->status        = (string)$data->Status;
        $this->added         = new \DateTime((string)$data->added);
        $this->addedBy       = (int)$data->addedBy;
        $this->fanArt        = (string)$data->fanart;
        $this->lastUpdated   = \DateTime::createFromFormat('U', (int)$data->lastupdated);
        $this->poster        = (string)$data->poster;
        $this->zap2ItId      = (string)$data->zap2it_id;

        if(isset($data->AliasNames)) {
            $this->aliasNames = (array)TvDbClient::removeEmptyIndexes(explode('|', (string)$data->AliasNames));
        }

    }
}
