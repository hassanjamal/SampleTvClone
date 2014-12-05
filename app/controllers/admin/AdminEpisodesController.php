<?php

class AdminEpisodesController extends \AdminBaseController {

	/**
	 * Display a listing of the resource.
	 * GET /adminepisodes
	 *
	 * @return Response
	 */
	public function index()
	{
		$episodes = Episode::paginate( $this->perPage );

		return View::make('admin.episodes')->with('episodes', $episodes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function search()
	{
		$episodes = Episode::where( 'title', 'LIKE', '%'.Input::get('search').'%')->paginate( $this->perPage );

		return View::make('admin.episodes')->with('episodes', $episodes );
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /adminepisodes/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /adminepisodes
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /adminepisodes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /adminepisodes/{id}/edit
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
	 * PUT /adminepisodes/{id}
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
	 * DELETE /adminepisodes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Episode::find($id)->delete();

		return Redirect::route('adminEpisodes')->with('message', "Episode has been deleted.");
	}

}