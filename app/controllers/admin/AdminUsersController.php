<?php

class AdminUsersController extends \AdminBaseController {

	/**
	 * Display a listing of the resource.
	 * GET /adminusers
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::paginate( $this->perPage );

		return View::make('admin.users')->with('users', $users);
	}

	/**
	 * User the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function search()
	{
		$users = User::where( 'first_name', 'LIKE', '%'.Input::get('search').'%')->orWhere( 'last_name', 'LIKE', '%'.Input::get('search').'%')->paginate( $this->perPage );

		return View::make('admin.users')->with('users', $users );
	}

	/**
	 * User the form for creating a new resource.
	 * GET /adminusers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /adminusers
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /adminusers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * User the form for editing the specified resource.
	 * GET /adminusers/{id}/edit
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
	 * PUT /adminusers/{id}
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
	 * DELETE /adminusers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::find($id)->delete();

		return Redirect::route('adminUsers')->with('message', "User has been deleted.");
	}

}
