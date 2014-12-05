<?php

namespace TvDb\Repo;

class TvDbBanner
{

    public $id;
    public $path          = '';
    public $type          = '';
    public $type2         = '';
    public $colors        = array();
    public $language      = '';
    public $rating        = '';
    public $ratingCount   = 0;
    public $seriesName    = '';
    public $thumbnailPath = '';
    public $vignettePath  = '';
    public $season;

    public function __construct($data)
    {
        $this->id            = (int)$data->id;
        $this->path          = (string)$data->BannerPath;
        $this->type          = (string)$data->BannerType;
        $this->type2         = (string)$data->BannerType2;
        $this->colors        = (array)$data->Colors;
        $this->language      = (string)$data->Language;
        $this->rating        = (string)$data->Rating;
        $this->ratingCount   = (int)$data->RatingCount;
        $this->seriesName    = (string)$data->SeriesName;
        $this->thumbnailPath = (string)$data->ThumbnailPath;
        $this->vignettePath  = (string)$data->VignettePath;
        $this->season        = (int)$data->Season;
    }
}