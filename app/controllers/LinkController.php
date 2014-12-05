<?php

class LinkController extends \BaseController {


    /**
     * Add a link to episode
     * GET /add-link/{episodeId}
     *
     * @param  int  $episodeId
     * @return Response
     */
    public function create( $episodeId )
    {
        $episode = Episode::with('show')->find( $episodeId );
        return View::make('shows.addLink')
                    ->with('episode', $episode);
    }


    /**
     * Add a link to episode
     * GET /add-link/{episodeId}
     *
     * @param  int  $episodeId
     * @return Response
     */
    public function store( $episodeId )
    {
        $episodeLink = EpisodeLink::whereLink(Input::get('link'))->first();

        if( !isset($episodeLink->id) )
        {
            $domain = get_domain( Input::get('link') );
            $linkDomains = explode(":", $this->options->linkDomains);

            if( array_search(strtolower($domain),array_map('strtolower',$linkDomains)) !== false )
            {
                $episodeLink = new EpisodeLink;
                $episodeLink->episode_id = $episodeId;
                $episodeLink->user_id = Sentry::getUser()->id;
                $episodeLink->domain = $domain;
                $episodeLink->link = Input::get('link');
                $episodeLink->save();
                $msg = trans('episode.link.added');

                $episode = Episode::with('show')->find( $episodeId );


                return Redirect::route('episode', array($episode->show->id, Str::slug($episode->show->name), $episodeId, Str::slug($episode->name) ))
                    ->with('message', $msg);
            }
            $msg = trans('episode.link.notAllowed');

            return Redirect::back()->with('message', $msg);
        }
        else
        {
            $msg = trans('episode.link.exist');

            return Redirect::back()->with('message', $msg);
        }

    }


    /**
     * Add a link to episode
     * GET /add-link/{episodeId}
     *
     * @param  int  $episodeId
     * @return Response
     */
    public function request( $episodeId )
    {
        EpisodeLinkRequest::firstOrCreate(array(
            'episode_id'    => $episodeId,
            'user_id'       =>  Sentry::getUser()->id
        ));

        $episode = Episode::find( $episodeId );

        return Redirect::back()->with('message', trans('episode.link.requested') );
    }

    public function vote( $id, $vote )
    {
        $ip = Request::getClientIp();
        $vote = ($vote == 'up') ? 1 : 0;

        $votes  = EpisodeLinkVote::whereIp($ip)->whereEpisodeLinkId($id)->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)')->get();

        if( count($votes) == 0 )
        {
            $link = new EpisodeLinkVote;
            $link->episode_link_id = $id;
            $link->user_id = Sentry::getUser()->id;
            $link->vote = $vote;
            $link->ip = $ip;
            $link->save();

            if( $vote == 0)
            {
                $count = EpisodeLinkVote::whereVote(0)->whereEpisodeLinkId($id)->count();

                if($count == 20)
                {
                    EpisodeLink::find($id)->update(array( 'approved'=>0 ) );
                }
            }

            return Redirect::back()->with('message', trans('episode.link.vote'));
        }
        return Redirect::back()->with('message', trans('episode.link.voted'));
    }


}
