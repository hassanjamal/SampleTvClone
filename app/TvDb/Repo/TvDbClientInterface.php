<?php

namespace TvDb\Repo;

use TvDb\Http\HttpClient;

interface TvDbClientInterface
{
    /**
     * [setHttpClient description]
     * @param HttpClient $client [description]
     */
    public function setHttpClient(HttpClient $client);

    /**
     * [getLanguage description]
     * @param  [type] $abbreviation [description]
     * @throws \Exception
     * @return [type]               [description]
     */
    public function getLanguage($abbreviation);

    /**
     * [setDefaultLanguage description]
     * @param [type] $language [description]
     */
    public function setDefaultLanguage($language);

    /**
     * [getDefaultLanguage description]
     * @return string [type] [description]
     */
    public function getDefaultLanguage();

    /**
     * [getServerTime description]
     * @return string [type] [description]
     */
    public function getServerTime();

    /**
     * [getSeries description]
     * @param $seriesName
     * @param null $language
     * @internal param $ [type] $seriesName [description]
     * @internal param $ [type] $language   [description]
     * @return array [type]             [description]
     */
    public function getAllSeriesByName($seriesName, $language = null);

    /**
     * [getSerie description]
     * @param $seriesId
     * @param null $language
     * @internal param $ [type] $serieId  [description]
     * @internal param $ [type] $language [description]
     * @return \TvDb\Repo\TvDbSeries [type]           [description]
     */
    public function getSeriesById($seriesId, $language = null);

    public function saveSeries(TvDbSeries $seriesData);

    public function saveOrSynEpisodesAndSession($allEpisodes, $series);


    /**
     * [getSerieByRemoteId description]
     * @param  array $remoteId [description]
     * @param null $language
     * @internal param $ [type] $language [description]
     * @return \TvDb\Repo\TvDbSeries [type]           [description]
     */
    public function getSeriesByRemoteId(array $remoteId, $language = null);

    /**
     * [getBanners description]
     * @param  [type] $serieId [description]
     * @return array [type]          [description]
     */
    public function getBannersBySeriesId($serieId);

    /**
     * [getActors description]
     * @param  [type] $serieId [description]
     * @return array [type]          [description]
     */
    public function getActorsBySeriesId($serieId);

    /**
     * [getSerieEpisodes description]
     * @param $serieId
     * @param null $language
     * @param string $format
     * @throws \ErrorException
     * @internal param $ [type] $serieId  [description]
     * @internal param $ [type] $language [description]
     * @internal param $ [type] $format   [description]
     * @return array [type]           [description]
     */
    public function getAllEpisodesBySeriesId($serieId, $language = null, $format = self::FORMAT_XML);

    /**
     * [getEpisode description]
     * @param $serieId
     * @param $season
     * @param $episode
     * @param null $language
     * @internal param $ [type] $serieId  [description]
     * @internal param $ [type] $season   [description]
     * @internal param $ [type] $episode  [description]
     * @internal param $ [type] $language [description]
     * @return \TvDb\Repo\TvDbEpisode [type]           [description]
     */
    public function getEpisodeBySeriesIdSessionId($serieId, $season, $episode, $language = null);

    /**
     * [getEpisodeById description]
     * @param $episodeId
     * @param null $language
     * @internal param $ [type] $episodeId [description]
     * @internal param $ [type] $language  [description]
     * @return \TvDb\Repo\TvDbEpisode [type]            [description]
     */
    public function getEpisodeById($episodeId, $language = null);

    /**
     * [getUpdates description]
     * @param  [type] $previousTime [description]
     * @return array [type]               [description]
     */
    public function getUpdates($previousTime);

    /**
     * [getMirror description]
     * @param  [type] $typeMask [description]
     * @return [type]           [description]
     */
    public function getMirror($typeMask = self::MIRROR_TYPE_XML);

    /**
     * [removeEmptyIndexes description]
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
    public static function removeEmptyIndexes($array);
}