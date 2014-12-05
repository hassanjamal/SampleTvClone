<?php

class AdminPagesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /adminpage
	 *
	 * @return Response
	 */
	public function index()
	{
		$pages = Page::paginate( $this->perPage );

		return View::make('admin.pages.index')->with('pages', $pages);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /adminpage/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.pages.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /adminpage
	 *
	 * @return Response
	 */
	public function store()
	{
		Page::create(
			array(
				'title'   => Input::get('title'),
				'slug'    => Str::slug( Input::get('title') ),
				'content' => Input::get('content'),
			)
		);
		return Redirect::route('adminPages')->with('message', 'New page has been saved.');
	}

	/**
	 * Display the specified resource.
	 * GET /adminpage/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function search()
	{
		$pages = Page::where( 'title', 'LIKE', '%'.Input::get('search').'%')->paginate( $this->perPage );

		return View::make('admin.pages.index')->with('pages', $pages );
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /adminpage/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$page = Page::find($id);
		return View::make('admin.pages.edit')->with('page', $page);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /adminpage/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		Page::whereId($id)->update(
			array(
				'title'   => Input::get('title'),
				'slug'    => Str::slug( Input::get('title') ),
				'content' => Input::get('content'),
			)
		);
		return Redirect::route('adminPages')->with('message', 'Page has been updated.');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /adminpage/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Page::whereId($id)->delete();
		return Redirect::route('adminPages')->with('message', 'Page has been deleted.');
	}

}
