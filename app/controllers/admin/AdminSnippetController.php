<?php

class AdminSnippetController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$snippets = Snippet::paginate(10);
		// return $snippets;
		return View::make('admin.snippets')
			->with('snippets', $snippets);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function search()
	{
		$snippets = Snippet::where( 'title', 'LIKE', '%'.Input::get('search').'%')->paginate(10);

		return View::make('admin.snippets')
			->with('snippets', $snippets );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if( Config::get('app.demo') )
			return Redirect::route('admin-snippets')->with('message', 'Snippet cannot be deleted in demo mode!');

		Snippet::find( $id )->delete();

		return Redirect::route('admin-snippets')->with('message', 'Snippet has been deleted!');
	}

}