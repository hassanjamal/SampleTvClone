<?php

// Remove debugbar in searchNow

use Intervention\Image\ImageManagerStatic as Image;
use TvDb\Repo\TvDbClientInterface;

class AdminShowsController extends \AdminBaseController
{

    protected $tvDbClient;
    protected $tvDbImage;

    /**
     * @param TvDbClientInterface $client
     */
    public function __construct(TvDbClientInterface $client)
    {
        $this->tvDbClient = $client;
        $this->tvDbImage  = new TvDbImage();
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     * GET /adminshows
     *
     * @return Response
     */
    public function index()
    {
        $title = "Show Management";
        $shows = Show::orderBy('id', 'DESC')->paginate($this->perPage);

        return View::make('admin.shows.index', compact('title', 'shows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function search()
    {
        $title = "Show Management";
        $shows = Show::where('name', 'LIKE', '%' . Input::get('search') . '%')->paginate($this->perPage);

        return View::make('admin.shows.index', compact('title', 'shows'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /adminshows/create
     *
     * @return Response
     */
    public function create()
    {
        $weekDays = [
            ' '         => 'Not Known',
            'Monday'    => 'Monday',
            'Tuesday'   => 'Tuesday',
            'Wednesday' => 'Wednesday',
            'Thursday'  => 'Thursday',
            'Friday'    => 'Friday',
            'Saturday'  => 'Saturday',
            'Sunday'    => 'Sunday',
        ];
        $genres   = Genre::lists('name', 'name');
        $title    = "Search and Add Show Manually";

        return View::make('admin.shows.create', compact('title', 'weekDays', 'genres'));
    }

    /**
     * Store show manually
     * @return mixed
     */
    public function store()
    {
        $show = new Show([
            'name'          => Input::get('name'),
            'link'          => Input::get('link'),
            'firstAired'    => new \DateTime((string)Input::get('firstAired')),
            'imdbId'        => Input::get('imdbId'),
            'airtime'       => \Carbon\Carbon::create(1980, 01, 01, (int)Input::get('hours'), (int)Input::get('minutes'), 0),
            'airday'        => Input::get('airday'),
            'contentRating' => Input::get('contentRating'),
            'network'       => Input::get('network'),
            'status'        => Input::get('status'),
            'runtime'       => Input::get('runtime'),
            'overview'      => Input::get('overview'),
        ]);
        if ($show->save()) {
            if (Input::file('poster')) {
                $fileName = "/banners/posters/poster" . time() . ".jpg";
                $filePath = storage_path() . $fileName;
                Image::make(Input::file('poster'))->resize(689, 1000)->save($filePath);
                $show->poster = $fileName;
            }
            if (Input::file('fanArt')) {
                $fileName = "/banners/fanart/original/fanArt" . time() . ".jpg";
                $filePath = storage_path() . $fileName;
                Image::make(Input::file('fanArt'))->resize(1280, 720)->save($filePath);
                $show->fanArt = $fileName;
            }
            if (Input::file('banner')) {
                $fileName = "/banners/graphical/banner_" . time() . ".jpg";
                $filePath = storage_path() . $fileName;
                Image::make(Input::file('banner'))->resize(758, 140)->save($filePath);
                $show->banner = $fileName;
            }
        }

        if ($show->save() && $this->tvDbClient->synOrSaveGenre(Input::get('genres'), $show)) {
            return Redirect::route('admin.shows.edit', $show->id)->withSuccess('Show ' . $show->name . ' has been updated successfully');
        } else {
            return Redirect::back()->withError('Oops!! Something is not right');
        }
    }

    /**
     * Create from TVDB api
     * @return mixed
     */
    public function createFromTvDb()
    {
        $title = "Add Show from TvDb";

        return View::make('admin.shows.createTvDb', compact('title'));
    }

    /**
     * Returns list of shows from TVDB api
     * @return Response
     */
    public function searchTvdb()
    {
        $data = $this->tvDbClient->getAllSeriesByName(Input::get('search'));
        // TODO
        \Debugbar::disable();

        return json_encode($data);
    }


    /**
     * Store show fetched form API
     * POST /adminshows
     *
     * @param $showId
     * @return Response
     */
    public function storeTvdb($showId)
    {
        $showDetails = $this->tvDbClient->getSeriesById($showId);
        // check whether show exists in database
        $show = Show::where('show_id', '=', $showId)
            ->where('API_Used', 'TvDb')
            ->first();
        if (isset($show->id))
            return Redirect::back()->withError('This show already exists in our database.');

        // create new show
        $newSeries = $this->tvDbClient->saveSeries($showDetails);
        // get all episodes of newly created show
        $allEpisodes = $this->tvDbClient->getAllEpisodesBySeriesId($showId);

        $synSessions = $this->tvDbClient->saveOrSynEpisodesAndSession($allEpisodes, $newSeries);

        // store show image
        $this->tvDbImage->fetchStoreShowImage($newSeries->id);
        // TODO
        \Debugbar::disable();

        return Redirect::back()->withSuccess('Your show has been added!');
    }

    /**
     * Display the specified resource.
     * GET /adminshows/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /adminshows/{id}/edit
     *
     * @param $shows
     * @internal param int $id
     * @return Response
     */
    public function edit($shows)
    {
        $weekDays = [
            ' '         => 'Not Known',
            'Monday'    => 'Monday',
            'Tuesday'   => 'Tuesday',
            'Wednesday' => 'Wednesday',
            'Thursday'  => 'Thursday',
            'Friday'    => 'Friday',
            'Saturday'  => 'Saturday',
            'Sunday'    => 'Sunday',
        ];

        $show       = Show::with('genre')->find($shows->id);
        $session    = Show::find($shows->id)->sessions()->lists('number', 'id');
        $genres     = Genre::lists('name', 'id');
        $title      = $show->name;
        $airtime    = \Carbon\Carbon::parse($show->airtime);
        $showGenres = array();
        foreach ($show->genre as $genre) {
            $showGenres[] = $genre->name;
        }

        return View::make('admin.shows.edit', compact('title', 'shows', 'show', 'session', 'genres', 'showGenres', 'airtime', 'weekDays'));

    }

    /**
     * Update the specified resource in storage.
     * PUT /adminshows/{id}
     *
     * @param $shows
     * @internal param int $id
     * @return Response
     */
    public function update($shows)
    {
        if ($shows) {
            $shows->name          = Input::get('name');
            $shows->link          = Input::get('link');
            $shows->firstAired    = new \DateTime((string)Input::get('firstAired'));
            $shows->imdbId        = Input::get('imdbId');
            $shows->airtime       = \Carbon\Carbon::create(1980, 01, 01, (int)Input::get('hours'), (int)Input::get('minutes'), 0);
            $shows->airday        = Input::get('airday');
            $shows->contentRating = Input::get('contentRating');
            $shows->network       = Input::get('network');
            $shows->status        = Input::get('status');
            $shows->runtime       = Input::get('runtime');
            $shows->overview      = Input::get('overview');

            if (Input::file('poster')) {
                $fileName = "/banners/posters/poster" . time() . ".jpg";
                $filePath = storage_path() . $fileName;
                Image::make(Input::file('poster'))->resize(689, 1000)->save($filePath);
                $shows->poster = $fileName;
            }
            if (Input::file('fanArt')) {
                $fileName = "/banners/fanart/original/fanArt" . time() . ".jpg";
                $filePath = storage_path() . $fileName;
                Image::make(Input::file('fanArt'))->resize(1280, 720)->save($filePath);
                $shows->fanArt = $fileName;
            }
            if (Input::file('banner')) {
                $fileName = "/banners/graphical/banner_" . time() . ".jpg";
                $filePath = storage_path() . $fileName;
                Image::make(Input::file('banner'))->resize(758, 140)->save($filePath);
                $shows->banner = $fileName;
            }

        }

        if ($shows->save() && $this->tvDbClient->synOrSaveGenre(Input::get('genres'), $shows)) {
            return Redirect::route('admin.shows.edit', $shows->id)
                ->withSuccess('Show ' . $shows->name . ' has been updated successfully');
        } else {
            return Redirect::back()->withError('Oops!! Something is not right');
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /adminshows/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Show::find($id)->delete();
        return Redirect::route('admin.shows.index')->with('message', "Show has been deleted.");
    }


    public function getShowImage($id)
    {
        $this->tvDbImage->fetchStoreShowImage($id);

        return Redirect::back();
    }

    public function getShowEpisodesImage($id)
    {
        $this->tvDbImage->fetchStoreAllEpisodeImage($id);

        return Redirect::back();
    }

    public function searchSession()
    {
        $title = "Search show to get all sessions";
        $mode  = 'search';

        return View::make('admin.shows.searchSession', compact('title', 'mode'));
    }

    /**
     * [getAjaxShow description]
     * @return [type] [description]
     */
    public function getAjaxShow()
    {
        $term   = Input::get('term');
        $shows  = Show::where('name', 'LIKE', '%' . $term . '%')->get([
            DB::raw('id as value'),
            DB::raw('name as label')
        ]);
        $result = [];

        foreach ($shows as $show) {
            if (strpos(Str::lower($show), Str::lower($term)) !== false) {
                $result[] = [
                    'id'    => $show->value,
                    'value' => $show->label,
                    'label' => $show->label
                ];
            }
        }

        return Response::json($result);
    }

    public function postSearchSession()
    {
        if(Input::get('to_show_id')) {
            $show = Show::with(array('sessions' => function ($q) {
                $q->orderBy('id', 'DESC');
                $q->with(array('episodes' => function ($q) {
                    $q->orderBy('session_id', 'ASC');
                    $q->with('links');
                }));
            }))->find(Input::get('to_show_id'));

            $title = "All Session of " . $show->name;
            $mode  = 'result';

            return View::make('admin.shows.searchSession', compact('title', 'mode', 'show'));
        }
        else {
            return Redirect::back()->withError('Oops !! You need to search and select a Show first');
        }
    }
}
