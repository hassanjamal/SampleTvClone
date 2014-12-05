<?php

class AdminLinksController extends \AdminBaseController
{

    /**
     * Display a listing of the resource.
     * GET /adminepisodes
     *
     * @param $show
     * @param $session
     * @param $episode
     * @return Response
     */
    public function index($show, $session, $episode)
    {
        $title = "Link Details";
        $links = EpisodeLink::with('episode.show')->approved()->paginate($this->perPage);

        return View::make('admin.links.index', compact('title', 'show', 'session', 'episode', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function search()
    {
        $links = EpisodeLink::where('link', 'LIKE', '%' . Input::get('search') . '%')->approved()->paginate($this->perPage);

        return View::make('admin.links')->with('links', $links);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function unapproved()
    {
        $links = EpisodeLink::where('approved', '=', 0)->paginate($this->perPage);

        return View::make('admin.links')->with('links', $links);
    }


    /**
     * Show the form for creating a new resource.
     * GET /adminepisodes/create
     *
     * @param $show
     * @param $session
     * @param $episode
     * @return Response
     */
    public function create($show, $session, $episode)
    {
        $title = "Add Links";

        return View::make('admin.links.create', compact('title', 'show', 'session', 'episode'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /adminepisodes
     *
     * @return Response
     */
    public function store($show, $session, $episode)
    {
        $episodeLink = EpisodeLink::whereLink(Input::get('link'))->first();

        if (!isset($episodeLink->id)) {
            $domain      = get_domain(Input::get('link'));
            $linkDomains = explode(":", $this->options->linkDomains);

            if (array_search(strtolower($domain), array_map('strtolower', $linkDomains)) !== false) {
                $episodeLink             = new EpisodeLink;
                $episodeLink->episode_id = $episode->id;
                $episodeLink->user_id    = Sentry::getUser()->id;
                $episodeLink->domain     = $domain;
                $episodeLink->link       = Input::get('link');

                if ($episodeLink->save()) {
                    return Redirect::back()->withSuccess('Link added successfully');
                } else {
                    return Redirect::back()->withError('Oops !! Something is not right');
                }
            }

            return Redirect::back()->withError('Oops !! Entered Domain is not allowed');
        } else {
            return Redirect::back()->withError('Oops !! Link already exists ');
        }
    }

    /**
     * Display the specified resource.
     * GET /adminepisodes/{id}
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
     * GET /adminepisodes/{id}/edit
     *
     * @param $show
     * @param $session
     * @param $episode
     * @param $link
     * @return Response
     */
    public function edit($show, $session, $episode, $link)
    {
        $title = "Edit Link";

        return View::make('admin.links.edit', compact('title', 'show', 'session', 'episode', 'link'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /adminepisodes/{id}
     *
     * @param $show
     * @param $session
     * @param $episode
     * @param $link
     * @return Response
     */
    public function update($show, $session, $episode, $link)
    {
        if ($link) {
            $episodeLink = EpisodeLink::whereLink(Input::get('link'))->first();
            if (!isset($episodeLink->id)) {
                $domain      = get_domain(Input::get('link'));
                $linkDomains = explode(":", $this->options->linkDomains);

                if (array_search(strtolower($domain), array_map('strtolower', $linkDomains)) !== false) {
                    $link->domain = $domain;
                    $link->link   = Input::get('link');

                    if ($link->save()) {
                        return Redirect::back()->withSuccess('Link added successfully');
                    } else {
                        return Redirect::back()->withError('Oops !! Something is not right');
                    }
                }

                return Redirect::back()->withError('Oops !! Entered Domain is not allowed');
            } else {
                return Redirect::back()->withError('Oops !! Link already exists ');
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     * DELETE /adminepisodes/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function approve($id)
    {
        EpisodeLink::whereId($id)->update(array('approved' => 1));
        EpisodeLinkVote::whereEpisodeLinkId($id)->delete();

        return Redirect::route('adminLinks')->with('message', "Link has been Approved.");
    }


    /**
     * Remove the specified resource from storage.
     * DELETE /adminepisodes/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        EpisodeLink::find($id)->delete();

        return Redirect::route('adminLinks')->with('message', "Link has been deleted.");
    }

}