<?php

class AdminSessionController extends \AdminBaseController
{

    /**
     * Display a listing of the resource.
     * GET /adminsession
     *
     * @param $showModel
     * @return Response
     */
    public function index($showModel)
    {
        $show = Show::with(array('sessions' => function ($q) {
            $q->orderBy('id', 'DESC');
            $q->with(array('episodes' => function ($q) {
                $q->orderBy('session_id', 'ASC');
                $q->with('links');
            }));
        }))->find($showModel->id);

        $title = "All Session of " . $show->name;
        $mode  = 'result';

        return View::make('admin.sessions.index', compact('title', 'mode', 'show'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /adminsession/create
     *
     * @return Response
     */
    public function create($show)
    {
        $title = "Create new Session for " . $show->name;

        return View::make('admin.sessions.create', compact('title', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /adminsession
     *
     * @return Response
     */
    public function store($show)
    {
        $newSessionAdded = new ShowSession([
            'season_id' => Input::get('season_id'),
            'number'    => Input::get('number')
        ]);
        if ($newSession = $show->sessions()->save($newSessionAdded)) {
            return Redirect::back()->withSuccess('New Session with Season No ' . $newSession->number . ' created succesfully');
        } else {
            return Redirect::back()->withError('Oops!! Something is not right !!');

        }
    }

    /**
     * Display the specified resource.
     * GET /adminsession/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($show, $session)
    {

        $title    = "Session Details";
        $sessions = ShowSession::with(['episodes' => function ($q) {
            $q->orderBy('session_id', 'ASC');
            $q->with('links');
        }])->find($session->id);

        return View::make('admin.sessions.show', compact('title', 'show', 'session', 'sessions'));
    }

    /**
     * Show the form for editing the specified resource.
     * GET /adminsession/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($show, $session)
    {
        $title = "Edit Session ";

        return View::make('admin.sessions.edit', compact('title', 'show', 'session'));

    }

    /**
     * Update the specified resource in storage.
     * PUT /adminsession/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($show, $session)
    {
        $session->season_id = Input::get('season_id');
        $session->number    = Input::get('number');
        if ($session->save()) {
            return Redirect::route('admin.shows.sessions.index', $show->id)->withSuccess('Session has been updated');
        } else {
            return Redirect::back()->withError('Oops !! Something is not right');
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /adminsession/{id}
     * @param $session
     * @return
     */
    public function destroy($show, $session)
    {
        if ($session->delete()) {
            return Redirect::route('admin.shows.sessions.index', $show->id)->withSuccess('Session has been deleted');
        } else {
            return Redirect::back()->withError('Oops !! Something is not right');
        }
    }

}