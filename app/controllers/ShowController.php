<?php
// TODO
// Change related shows to other episodes of same seson in showEpisode

// Check for already rated in addRating
use TvDb\Repo\TvDbClient;

class ShowController extends \BaseController {

	protected $helper;
	public function __construct()
	{
		parent::__construct();
		$this->helper = new DelishowHelper();

	}
	/**
	 * Display latest added shows
	 * GET /
	 *
	 * @return Response
	 */
	public function index()
	{


		$links = EpisodeLink::with("episode.show")
								->approved()
								->thisMonth()
								->groupBy("episode_id")
								->orderBy('id','DESC')
								->paginate(30);

        /* $links = array_chunk( (array) $links, 30);
        $links = array_chunk( $links[0][0], 30); */

		return View::make('shows.shows')->with('links', $links);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function search()
	{
		$shows = Show::where( 'name', 'LIKE', '%'.Input::get('search').'%')->paginate( $this->perPage );

		return View::make('shows.search')
					->with('shows', $shows )
					->with('search', Input::get('search'));
	}


    /**
     * Display latest added shows for specific genre
     * GET /genre/{id}-{slug}
     *
     * @internal param int $id
     * @internal param string $slug
     * @return Response
     */
	public function indexShows()
	{
		$shows = Show::orderBy('name', 'ASC')->paginate( 28 );

		return View::make('shows.index')
					->with('shows', $shows);
	}


	/**
	 * Display latest added shows for specific genre
	 * GET /genre/{id}-{slug}
	 *
	 * @param  int  $id
	 * @param  string  $slug
	 * @return Response
	 */
	public function indexGenre( $id, $slug )
	{
		$genre = Genre::with('shows')->find($id);

		$shows = $genre->shows()->orderBy('id', 'DESC')->paginate( $this->perPage );

		return View::make('shows.genre')
					->with('genre', $genre)
					->with('shows', $shows);
	}


	/**
	 * Display latest added shows for specific year
	 * GET /year/{id}-{slug}
	 *
	 * @param  int  $year
	 * @return Response
	 */
	public function indexYear( $year )
	{
		$shows = Show::where( 'firstAired', 'LIKE', $year."%" )
					->orderBy('id', 'DESC')
					->paginate( $this->perPage );

		return View::make('shows.year')
					->with('year', $year)
					->with('shows', $shows);
	}


	/**
	 * Display link requests
	 * GET /requests
	 *
	 * @return Response
	 */
	public function indexRequests( )
	{
		$ids = EpisodeLinkRequest::groupBy('episode_id')->lists('episode_id');

		if (empty($ids)) $ids = [0];

		$links = EpisodeLink::whereIn('episode_id', $ids)->groupBy('episode_id')->lists('episode_id');

		if (empty($links)) $links  = [0];

		$linkRequests = EpisodeLinkRequest::with( 'episode.show')
							->select( array('episode_id', 'created_at',DB::raw('COUNT(*) as `count`')) )
							->whereNotIn('episode_id',$links)
							->groupBy('episode_id')
							->orderBy('count','DESC')
							->orderBy('created_at','ASC')
							->paginate(30);

		// return $linkRequests;
		return View::make('shows.requests')->with('linkRequests', $linkRequests);
	}


	/**
	 * Show the form for creating a new resource.
	 * GET /show/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /show
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display specific show details
	 * GET /show/{id}-{slug}
	 *
	 * @param  int  $id
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($id, $slug)
	{
		$show = Show::with( array('sessions'=> function($q)
		{
			$q->orderBy('id', 'DESC');
			$q->with( array('episodes'=> function($q)
			{
				$q->orderBy('session_id', 'ASC');
				$q->with('links');
			}));
		}, 'genre','rating') )->find($id);

		$showGenre = [];
		foreach($show->genre as $genre)
		{
			$showGenre[] = $genre->name;
		}
		$rating = $this->helper->calculateRating($show->rating);

		$shows = Show::whereHas('genre', function($query) use($showGenre) {
			$query->whereIn('name', $showGenre);
		})->where('id', '!=', $show->id )
		->limit($this->relatedPerPage)->get();

		$comments = Comment::with('user')->where('show_id' , $id)->orderBy('depth')->get();

		$commentsFormated = comments($comments);

		return View::make('shows.show')
						->with('shows', $shows)
						->with('show', $show)
						->with('rating', $rating)
						->with('comments' , $commentsFormated);
	}




	/**
	 * Show the form for editing the specified resource.
	 * GET /show/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /show/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /show/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	/**
	 * Add a show to watchlist
	 * GET /watchlist/add/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function addToWatchlistShow( $id )
	{
		WatchlistShow::firstOrCreate(array(
			'show_id'	=> $id,
			'user_id'	=>	Sentry::getUser()->id
		));
		return Redirect::back()->with('message', trans('show.watchlist.added') );
	}


	/**
	 * Delete a show from watchlist
	 * GET /watchlist/add/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyWatchlistShow( $id )
	{
		WatchlistShow::find( $id )->delete();
		return Redirect::back()->with('message', trans('show.watchlist.deleted') );
	}


	/**
	 * Add a show to watched list
	 * GET /watched/add/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function addToWatchedShow( $id )
	{
		WatchedShow::firstOrCreate(array(
			'show_id'	=> $id,
			'user_id'	=>	Sentry::getUser()->id
		));

		WatchlistShow::whereEpisodeId($id)->whereUserId($userId)->delete();

		return Redirect::back()->with('message', trans('show.watchedlist.added') );
	}

	/**
	 * Delete a show from watchlist
	 * GET /watchlist/add/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyWatchedShow( $id )
	{
		WatchedShow::find( $id )->delete();
		return Redirect::back()->with('message', trans('show.watchedlist.deleted') );
	}


	/**
	 * Add a show to favourite list
	 * GET /favorites/add/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function addToFavoriteShow( $id )
	{
		FavouriteShow::firstOrCreate(array(
			'show_id'	=> $id,
			'user_id'	=>	Sentry::getUser()->id
		));
		return Redirect::back()->with('message', trans('show.favourite.added') );
	}

	/**
	 * Delete a show from favourite list
	 * GET /favorites/delete/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyFavoriteShow( $id )
	{
		FavouriteShow::find($id)->delete();
		return Redirect::back()->with('message', trans('show.favourite.deleted') );
	}


	/**
	 * Add rating for a show
	 * GET /show/rating/{showId}-{rating}
	 *
	 * @param  int  $showId
	 * @param  int  $rating
	 * @return Response
	 */
	public function addShowRating( $showId, $rating )
	{
		$showRating = ShowRating::firstOrNew(array(
			'show_id'	=> $showId,
			'user_id'		=>	Sentry::getUser()->id
		));

		if( !isset($showRating->rating) )
		{
			$showRating->rating = $rating;
			$showRating->save();
			$msg = trans('master.rating.added');
		}
		else
		{
			$showRating->rating = $rating;
			$showRating->update();
			$msg = trans('master.rating.updated');
		}
		return Redirect::back()->with('message', $msg);
	}


	public function getShowAjax()
	{
		// dd(Input::get('showSearch'));
		$query = Input::get('showSearch');
		$shows = Show::where('name','LIKE', '%'.$query.'%')->get();
		return json_encode($shows);
	}
}
