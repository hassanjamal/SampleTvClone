<?php
use Intervention\Image\ImageManagerStatic as Image;

class AdminEpisodeController extends \AdminBaseController
{
    protected $thumbnail;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->thumbnail = '';
    }

    /**
     * @param $show
     * @param $sessions
     * @return mixed
     */
    public function index($show, $sessions)
    {
        $episodes = ShowSession::find($sessions->id)->episodes()->paginate(15);

        return View::make('admin.episodes.index', compact('show', 'sessions', 'episodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $show
     * @param $session
     * @return Response
     */
    public function create($show, $session)
    {

        $title      = "New Episode";
        $allSeasons = ShowSession::where('show_id', $show->id)->lists('number', 'id');
        $episodeNum = Episode::where('show_id', $show->id)->where('session_id', $session->id)->max('number') + 1;
        $code       = "S" . sprintf("%02s", $session->number) . "E" . sprintf("%02s", $episodeNum);

        return View::make('admin.episodes.create', compact('title', 'show', 'session', 'episode', 'allSeasons', 'code', 'episodeNum'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $show
     * @param $session
     * @return Response
     */
    public function store($show, $session)
    {

        if (Input::file('thumbnail')) {
            $this->thumbnail = "/banners/episodes/manual/thumbnail" . time() . ".jpg";
            $filePath = storage.path().$this->thumbnail;
            Image::make(Input::file('thumbnail'))->resize(400, 225)->save($filePath);
        }

        $episode = new Episode([
            'session_id' => (int)Input::get('session_id'),
            'number'     => Input::get('number'),
            'name'       => Input::get('name'),
            'imdbId'     => Input::get('imdbId'),
            'language'   => Input::get('language'),
            'overview'   => Input::get('overview'),
            'code'       => Input::get('code'),
            'firstAired' => Input::get('firstAired'),
            'thumbnail'  => $this->thumbnail
        ]);

        if ($show->episodes()->save($episode)) {
            return Redirect::route('admin.shows.sessions.episodes.edit', [$show->id, $session->id, $episode->id])->withSuccess('Episode has been created');
        } else {
            return Redirect::route('admin.shows.sessions.episodes.edit', [$show->id, $session->id, $episode->id])->with('Oops !! Something is not right!');
        }
    }


    /**
     * Show the form for editing the specified resource.
     * GET ../episode/{id}/edit
     *
     * @param $show
     * @param $session
     * @param $episode
     * @internal param int $id
     * @return Response
     */
    public function edit($show, $session, $episode)
    {
        $title      = "Episode Details";
        $allSeasons = ShowSession::where('show_id', $show->id)->lists('number', 'id');

        return View::make('admin.episodes.edit', compact('title', 'show', 'session', 'episode', 'allSeasons'));
    }

    /**
     * Update the specified resource in storage.
     * PUT ../episode/{id}
     *
     * @param $show
     * @param $session
     * @param $episode
     * @internal param int $id
     * @return Response
     */
    public function update($show, $session, $episode)
    {
        if ($episode) {
            $episode->session_id = (int)Input::get('session_id');
            $episode->number     = Input::get('number');
            $episode->name       = Input::get('name');
            $episode->imdbId     = Input::get('imdbId');
            $episode->language   = Input::get('language');
            $episode->overview   = Input::get('overview');
            $episode->code       = Input::get('code');
            $episode->firstAired = Input::get('firstAired');

            if (Input::file('thumbnail')) {
                $fileName = "/banners/episodes/manual/thumbnail" . time() . ".jpg";
                $filePath = storage_path() . $fileName;
                Image::make(Input::file('thumbnail'))->resize(400, 225)->save($filePath);
                $episode->thumbnail = $fileName;
            }
        }
        if ($episode->save()) {
            return Redirect::route('admin.shows.sessions.episodes.edit', [$show->id, $session->id, $episode->id])->withSuccess('Episode has been updated');
        } else {
            return Redirect::route('admin.shows.sessions.episodes.edit', [$show->id, $session->id, $episode->id])->with('Oops !! Something is not right!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /adminepisode/{id}
     *
     * @param $show
     * @param $session
     * @param $episode
     * @return Response
     */
    public function destroy($show, $session, $episode)
    {
        if ($episode->delete()) {
            return Redirect::back()->withSuccess('Episode has been deleted');
        } else {
            return Redirect::back()->withError('Oops !! Something is not right');
        }
    }

}