<?php

namespace TvDb\Repo;

use Config;
use Show;
use Genre;
use Actor;
use Aka;
use ShowSession;
use Episode;
use EpisodeDirectors;
use TvDb\Exceptions\CurlException;
use TvDb\Exceptions\XmlException;
use TvDb\Http\CurlClient;
use TvDb\Http\HttpClient;


class TvDbClient implements TvDbClientInterface
{
    const POST = 'post';
    const GET = 'get';
    const MIRROR_TYPE_XML = 1;
    const MIRROR_TYPE_BANNER = 2;
    const MIRROR_TYPE_ZIP = 4;
    const DEFAULT_LANGUAGE = 'en';
    const FORMAT_XML = 'xml';
    const FORMAT_ZIP = 'zip';

    protected $baseUrl = '';
    protected $apiKey = '';
    protected $mirrors = array();
    protected $languages = array();
    protected $defaultLanguage = 'en';

    protected $httpClient;
    protected $tvDbSeries;

    /**
     * [__construct description]
     * @internal param $baseUrl
     * @internal param $apiKey
     * @internal param $ [type] $baseUrl [description]
     * @internal param $ [type] $apiKey  [description]
     */
    public function __construct()
    {
        $this->baseUrl    = Config::get('tvdb.url');
        $this->apiKey     = Config::get('tvdb.key');
        $this->httpClient = new CurlClient();
    }

    /**
     * [setHttpClient description]
     * @param HttpClient $client [description]
     */
    public function setHttpClient(HttpClient $client)
    {
        $this->httpClient = $client;
    }

    /**
     * [getLanguage description]
     * @param  [type] $abbreviation [description]
     * @throws \Exception
     * @return [type]               [description]
     */
    public function getLanguage($abbreviation)
    {
        if (empty($this->languages)) {
            $this->getLanguages();
        }
        if (!isset($this->languages[$abbreviation])) {
            throw new \Exception('This language is not available');
        }

        return $this->languages[$abbreviation];
    }

    /**
     * [setDefaultLanguage description]
     * @param [type] $language [description]
     */
    public function setDefaultLanguage($language)
    {
        $this->defaultLanguage = $language;
    }

    /**
     * [getDefaultLanguage description]
     * @return string [type] [description]
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * [getServerTime description]
     * @return string [type] [description]
     */
    public function getServerTime()
    {
        return (string)$this->fetchXml('Updates.php?type=none')->Time;
    }

    /**
     * [getSeries description]
     * @param $seriesName
     * @param null $language
     * @internal param $ [type] $seriesName [description]
     * @internal param $ [type] $language   [description]
     * @return array [type]             [description]
     */
    public function getAllSeriesByName($seriesName, $language = null)
    {
        $language = $language ?: $this->defaultLanguage;

        $data   = $this->fetchXml('GetSeries.php?seriesname=' . urlencode($seriesName) . '&language=' . $language);
        $series = array();
        foreach ($data->Series as $individualSeries) {
            $series[] = new TvDbSeries($individualSeries);
        }

        return $series;
    }

    /**
     * [getSerie description]
     * @param $seriesId
     * @param null $language
     * @internal param $ [type] $serieId  [description]
     * @internal param $ [type] $language [description]
     * @return \TvDb\Repo\TvDbSeries [type]           [description]
     */
    public function getSeriesById($seriesId, $language = null)
    {
        $language = $language ?: $this->defaultLanguage;
        $data     = $this->fetchXml('series/' . $seriesId . '/' . $language . '.xml');

        return new TvDbSeries($data->Series);
    }

    /**
     * @param TvDbSeries $seriesData
     * @return mixed
     */
    public function saveSeries(TvDbSeries $seriesData)
    {
        $newSeries = Show::create([
            'show_id'        => $seriesData->id,
            'language'       => $seriesData->language,
            'name'           => $seriesData->name,
            'banner'         => "/banners/" . $seriesData->banner,
            'Apibanner'      => "http://thetvdb.com/banners/" . $seriesData->banner,
            'overview'       => $seriesData->overview,
            'firstAired'     => $seriesData->firstAired,
            'imdbId'         => $seriesData->imdbId,
            'added'          => $seriesData->added,
            'addedBy'        => $seriesData->addedBy,
            'lastUpdated'    => $seriesData->lastUpdated,
            'airtime'        => $seriesData->airsTime,
            'airday'         => $seriesData->airsDayOfWeek,
            'contentRating'  => $seriesData->contentRating,
            'network'        => $seriesData->network,
            'ApiRating'      => $seriesData->rating,
            'ApiRatingCount' => $seriesData->ratingCount,
            'runtime'        => $seriesData->runtime,
            'status'         => $seriesData->status,
            'fanArt'         => "/banners/" . $seriesData->fanArt,
            'ApifanArt'      => "http://thetvdb.com/banners/" . $seriesData->fanArt,
            'poster'         => "/banners/" . $seriesData->poster,
            'Apiposter'      => "http://thetvdb.com/banners/" . $seriesData->poster,
            'zap2ItId'       => $seriesData->zap2ItId,
            'link'           => "http://thetvdb.com/?tab=series&id=" . $seriesData->id,
            'API_Used'       => Config::get('tvdb.apihost'),
        ]);

        $storeGenre = $this->synOrSaveGenre($seriesData->genres, $newSeries);
        $this->synOrSaveActors($seriesData->id, $newSeries);
        $this->synOrStoreAkas($seriesData->aliasNames, $newSeries);

        return $newSeries;

    }

    /**
     * @param $genres
     * @param $series
     * @return bool
     */
    public function synOrSaveGenre($genres, $series)
    {
        $genreArray = [];
        foreach ($genres as $genre) {
            $newGenre     = Genre::firstOrCreate(['name' => $genre]);
            $genreArray[] = $newGenre->id;
        }
        if ($series->genre()->sync($genreArray)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param $seriesId
     * @param $series
     */
    private function synOrSaveActors($seriesId, $series)
    {
        $seriesActors       = $this->getActorsBySeriesId($seriesId);
        $allActorsForSeries = [];
        foreach ($seriesActors as $actor) {
            $allActorsForSeries[] = new Actor([
                'tvdb_actor_id' => $actor->id,
                'Apiimage'      => "http://thetvdb.com/banners/" . $actor->image,
                'image'         => "/banners/" . $actor->image,
                'name'          => $actor->name,
                'role'          => $actor->role,
                'sortOrder'     => $actor->sortOrder
            ]);
        }
        $series->actors()->saveMany($allActorsForSeries);
    }

    /**
     * @param $aliasName
     * @param $series
     */
    private function synOrStoreAkas($aliasName, $series)
    {
        $allAliasForSeries = [];
        foreach ($aliasName as $alias) {
            $allAliasForSeries[] = new Aka([
                'name' => $alias
            ]);
        }
        $series->akas()->saveMany($allAliasForSeries);
    }

    /**
     * @param $allEpisodes
     * @param $series
     */
    public function saveOrSynEpisodesAndSession($allEpisodes, $series)
    {
        $episodeWriters     = [];
        $episodeGuestStars  = [];
        $episodeDirectors   = [];
        $episodeFirstAired  = [];
        $episodeLastUpdated = [];

        foreach ($allEpisodes['episodes'] as $episode) {

            $episodeSession = new ShowSession([
                'season_id' => $episode->seasonId,
                'number'    => $episode->season
            ]);
            $checkSeasonId  = ShowSession::where('season_id', $episode->seasonId)->first();
            if ($checkSeasonId == null) {
                $newSession = $series->sessions()->save($episodeSession);
            }
            $code          = "S" . sprintf("%02s", $newSession->number) . "E" . sprintf("%02s", $episode->number);
            $createEpisode = new Episode([
                'session_id'     => $newSession->id,
                'number'         => $episode->number,
                'name'           => $episode->name,
                'imdbId'         => $episode->imdbId,
                'language'       => $episode->language,
                'overview'       => $episode->overview,
                'ApiRating'      => $episode->rating,
                'ApiRatingCount' => $episode->ratingCount,
                'ApiSeasonId'    => $episode->seasonId,
                'ApiSerieId'     => $episode->season,
                'thumbnail'      => "/banners/" . $episode->thumbnail,
                'Apithumbnail'   => "http://thetvdb.com/banners/" . $episode->thumbnail,
                'code'           => $code,
                'firstAired'     => $episode->firstAired,
                'lastUpdated'    => $episode->lastUpdated,
                'API_Used'       => Config::get('tvdb.apihost'),
            ]);

            $newEpisode = $series->episodes()->save($createEpisode);

            foreach ($episode->directors as $directors) {
                $episodeDirectors[] = new EpisodeDirectors([
                    'name' => $directors
                ]);
            }
            $newEpisode->episodeDirectors()->saveMany($episodeDirectors);
            unset($episodeDirectors);
            $episodeDirectors = [];

            foreach ($episode->guestStars as $guestStars) {
                $episodeGuestStars[] = new \EpisodeGuestStars([
                    'name' => $guestStars,
                ]);
            }
            $newEpisode->episodeGuestStars()->saveMany($episodeGuestStars);
            unset($episodeGuestStars);
            $episodeGuestStars = [];

            foreach ($episode->writers as $writers) {
                $episodeWriters[] = new \EpisodeWriters([
                    'name' => $writers,
                ]);
            }
            $newEpisode->episodeWriters()->saveMany($episodeWriters);
            unset($episodeWriters);
            $episodeWriters = [];

//            foreach ($episode->firstAired as $firstAired) {
//                $episodeFirstAired[] = new \EpisodeFirstAired([
//                    'date'          => $firstAired->date,
//                    'timezone_type' => $firstAired->timezone_type,
//                    'timezone'      => $firstAired->timezone,
//                ]);
//            }
//            $newEpisode->episodeFirstAired()->saveMany($episodeFirstAired);
//            unset($episodeFirstAired);
//            $episodeFirstAired = [];
//
//            foreach ($episode->lastUpdated as $lastUpdated) {
//                $episodeLastUpdated[] = new \EpisodeLastUpdated([
//                    'date'          => $lastUpdated->date,
//                    'timezone_type' => $lastUpdated->timezone_type,
//                    'timezone'      => $lastUpdated->timezone,
//                ]);
//            }
//            $newEpisode->episodeLastUpdated()->saveMany($episodeLastUpdated);
//            unset($episodeLastUpdated);
//            $episodeLastUpdated = [];

        }
//        $series->episodes()->saveMany($seriesAllEpisode);

    }

    /**
     * [getSerieByRemoteId description]
     * @param  array $remoteId [description]
     * @param null $language
     * @internal param $ [type] $language [description]
     * @return \TvDb\Repo\TvDbSeries [type]           [description]
     */
    public function getSeriesByRemoteId(array $remoteId, $language = null)
    {
        $language = $language ?: $this->defaultLanguage;
        $data     = $this->fetchXml('GetSeriesByRemoteID.php?' . http_build_query($remoteId) . '&language=' . $language);

        return new TvDbSeries($data->Series);
    }

    /**
     * [getBanners description]
     * @param  [type] $serieId [description]
     * @return array [type]          [description]
     */
    public function getBannersBySeriesId($serieId)
    {
        $data    = $this->fetchXml('series/' . $serieId . '/banners.xml');
        $banners = array();
        foreach ($data->Banner as $banner) {
            $banners[] = new TvDbBanner($banner);
        }

        return $banners;
    }

    /**
     * [getActors description]
     * @param  [type] $serieId [description]
     * @return array [type]          [description]
     */
    public function getActorsBySeriesId($serieId)
    {
        $data   = $this->fetchXml('series/' . $serieId . '/actors.xml');
        $actors = array();
        foreach ($data->Actor as $actor) {
            $actors [] = new TvDbActor($actor);
        }

        return $actors;
    }

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
    public function getAllEpisodesBySeriesId($serieId, $language = null, $format = self::FORMAT_XML)
    {
        $language = $language ?: $this->defaultLanguage;

        switch ($format) {
            case self::FORMAT_XML:
                $data = $this->fetchXml('series/' . $serieId . '/all/' . $language . '.' . $format);
                break;
            case self::FORMAT_ZIP:
            default:
                throw new \ErrorException('Unsupported format');
                break;
        }
        $serie    = new TvDbSeries($data->Series);
        $episodes = array();
        foreach ($data->Episode as $episode) {
            $episodes[(int)$episode->id] = new TvDbEpisode($episode);
        }

        return array('serie' => $serie, 'episodes' => $episodes);
    }

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
    public function getEpisodeBySeriesIdSessionId($serieId, $season, $episode, $language = null)
    {
        $language = $language ?: $this->defaultLanguage;
        $data     = $this->fetchXml('series/' . $serieId . '/default/' . $season . '/' . $episode . '/' . $language . '.xml');

        return new TvDbEpisode($data->Episode);
    }

    /**
     * [getEpisodeById description]
     * @param $episodeId
     * @param null $language
     * @internal param $ [type] $episodeId [description]
     * @internal param $ [type] $language  [description]
     * @return \TvDb\Repo\TvDbEpisode [type]            [description]
     */
    public function getEpisodeById($episodeId, $language = null)
    {
        $language = $language ?: $this->defaultLanguage;
        $data     = $this->fetchXml('episodes/' . $episodeId . '/' . $language . '.xml');

        return new TvDbEpisode($data->Episode);
    }

    /**
     * [getUpdates description]
     * @param  [type] $previousTime [description]
     * @return array [type]               [description]
     */
    public function getUpdates($previousTime)
    {
        $data = $this->fetchXml('Updates.php?type=all&time=' . $previousTime);

        $series = array();
        foreach ($data->Series as $serieId) {
            $series[] = (int)$serieId;
        }
        $episodes = array();
        foreach ($data->Episode as $episodeId) {
            $episodes[] = (int)$episodeId;
        }

        return array('series' => $series, 'episodes' => $episodes);
    }


    /**
     * [fetchXml description]
     * @param $function
     * @param  array $params [description]
     * @param string $method
     * @throws CurlException
     * @throws XmlException
     * @internal param $ [type] $function [description]
     * @internal param $ [type] $method   [description]
     * @return \SimpleXMLElement [type]           [description]
     */
    protected function fetchXml($function, $params = array(), $method = self::GET)
    {
        if (strpos($function, '.php') > 0) { // no need of api key for php calls
            $url = $this->getMirror(self::MIRROR_TYPE_XML) . '/api/' . $function;
        } else {
            $url = $this->getMirror(self::MIRROR_TYPE_XML) . '/api/' . $this->apiKey . '/' . $function;
        }

        $data      = $this->httpClient->fetch($url, $params, $method);
        $simpleXml = $this->getXml($data);

        return $simpleXml;
    }

    /**
     * [fetch description]
     * @param $url
     * @param  array $params [description]
     * @param string $method
     * @throws CurlException
     * @internal param $ [type] $url    [description]
     * @internal param $ [type] $method [description]
     * @return string [type]         [description]
     */
    protected function fetch($url, array $params = array(), $method = self::GET)
    {
        return $this->httpClient->fetch($url, $params, $method);
    }

    /**
     * [getXml description]
     * @param  [type] $data [description]
     * @throws XmlException
     * @return \SimpleXMLElement [type]       [description]
     */
    protected function getXml($data)
    {
        if (extension_loaded('libxml')) {
            libxml_use_internal_errors(true);
        }

        $simpleXml = simplexml_load_string($data);
        if (!$simpleXml) {
            if (extension_loaded('libxml')) {
                $xmlErrors = libxml_get_errors();
                $errors    = array();
                foreach ($xmlErrors as $error) {
                    $errors[] = sprintf('Error in file %s on line %d with message : %s', $error->file, $error->line, $error->message);
                }
                if (count($errors) > 0) {

                    throw new XmlException(implode("\n", $errors));
                }
            }
            throw new XmlException('Xml file cound not be loaded');
        }

        return $simpleXml;
    }

    /**
     * [getMirrors description]
     * @throws CurlException
     * @throws XmlException
     * @return void [type] [description]
     */
    protected function getMirrors()
    {
        $data    = $this->httpClient->fetch($this->baseUrl . '/api/' . $this->apiKey . '/mirrors.xml');
        $mirrors = $this->getXml($data);

        foreach ($mirrors->Mirror as $mirror) {
            $typeMask   = (int)$mirror->typemask;
            $mirrorPath = (string)$mirror->mirrorpath;

            if ($typeMask & self::MIRROR_TYPE_XML) {
                $this->mirrors[self::MIRROR_TYPE_XML][] = $mirrorPath;
            }
            if ($typeMask & self::MIRROR_TYPE_BANNER) {
                $this->mirrors[self::MIRROR_TYPE_BANNER][] = $mirrorPath;
            }
            if ($typeMask & self::MIRROR_TYPE_ZIP) {
                $this->mirrors[self::MIRROR_TYPE_ZIP][] = $mirrorPath;
            }
        }
    }

    /**
     * [getMirror description]
     * @param  [type] $typeMask [description]
     * @return [type]           [description]
     */
    public function getMirror($typeMask = self::MIRROR_TYPE_XML)
    {
        if (empty($this->mirrors)) {
            $this->getMirrors();
        }

        return $this->mirrors[$typeMask][array_rand($this->mirrors[$typeMask], 1)];

    }

    /**
     * [getLanguages description]
     * @return void [type] [description]
     */
    protected function getLanguages()
    {
        $languages = $this->fetchXml('languages.xml');

        foreach ($languages->Language as $language) {
            $this->languages[(string)$language->abbreviation] = array(
                'name'         => (string)$language->name,
                'abbreviation' => (string)$language->abbreviation,
                'id'           => (int)$language->id,
            );
        }
    }

    /**
     * [removeEmptyIndexes description]
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
    public static function removeEmptyIndexes($array)
    {

        $length = count($array);

        for ($i = $length - 1; $i >= 0; $i--) {
            if (trim($array[$i]) == '') {
                unset($array[$i]);
            }
        }

        sort($array);

        return $array;
    }
}