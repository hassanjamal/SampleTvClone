// <?php

class PageController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /page
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /page/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /page
	 *
	 * @return Response
	 */
	public function send($slug)
	{
		Mail::send(array('text' => 'emails.plain'), array( 'msg'=>Input::get('message') ), function($message)
		{
		    $message->from(Input::get('email'), Input::get('name') );

		    $message->to($this->options->email)->subject('Contact Request on DeliShows');
		});

		return Redirect::back()->with('message', 'Thanks for contacting us. We will get back to you shortly.');
	}

	/**
	 * Display the specified resource.
	 * GET /page/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$page = Page::whereSlug($slug)->first();
		return View::make('page')->with('page', $page);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /page/{id}/edit
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
	 * PUT /page/{id}
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
	 * DELETE /page/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
