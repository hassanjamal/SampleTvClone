<?php

class EpisodeController extends \BaseController {


    /**
     * Display specific episode details
     * GET /episode/{id}-{slug}
     *
     * @param  int $id
     * @param  string $slug
     * @return Response
     */
    public function show($showId, $showSlug, $id, $slug)
    {
        $episode = Episode::with(array('links' => function ($q)
        {
//            $q->approved();
            $q->orderBy('created_at','DESC');
            $q->with('votes');
        }, 'rating', 'show.genre'))->find($id);

        $show            = $episode->show;
        $nextEpisode     = Episode::whereId($episode->id + 1)->whereShowId($episode->show_id)->first();
        $previousEpisode = Episode::whereId($episode->id - 1)->whereShowId($episode->show_id)->first();


        // Fix the date format
        // preg_match("(\d{4})", $show->start_date,  $matches);
        // $show->started =  $matches[0];

        // Calculate rating for episode
        $rating = calculateRating($episode->rating);

        // Get comments
        $comments = Comment::with('user')->where('episode_id' , $id)->orderBy('depth')->get();

        $commentsFormated = comments( $comments);

        // TODO
        // $shows = Show::whereClass($show->class)->where('id', '!=', $show->id)->limit($this->relatedPerPage)->get();
        $showGenre = [];
        foreach($show->genre as $genre)
        {
            $showGenre[] = $genre->name;
        }
        $shows = Show::whereHas('genre', function($query) use($showGenre) {
            $query->whereIn('name', $showGenre);
        })->where('id', '!=', $show->id )
            ->limit($this->relatedPerPage)->get();

        return View::make('shows.episode')
             ->with('shows', $shows)
            ->with('episode', $episode)
            ->with('nextEpisode', $nextEpisode)
            ->with('previousEpisode', $previousEpisode)
            ->with('show', $show)
            ->with('rating', $rating)
            ->with('comments' , $commentsFormated);
    }


    public function updates()
    {
        // var_dump( EpisodeLink::approved()->thisMonth()->orderBy('id','DESC')->get() );
        $links = EpisodeLink::with("episode.show")->approved()->thisMonth()->groupBy("episode_id")->orderBy('id','DESC')->get();
        $links_by_week = [];
        foreach ($links as $link)
        {
            $start_date = new DateTime( $link->created_at);
            $week = $start_date->format('YW');
            $monday = 1;

            $day_offset = ($monday - $start_date->format('N'));

            $week_commencing = $start_date->modify("$day_offset days");

            if (!array_key_exists($week, $links_by_week))
            {

                $weekStart = $week_commencing->format('jS F Y');
                $weekTitle = $weekStart . " - " .date('jS F Y', strtotime("+7 day", strtotime($weekStart) ) );


                $links_by_week[$week] = (object) array(
                    'week'     => $weekStart,
                    'weekTitle'=> $weekTitle,
                    'links'    => array()
                );
            }

            $links_by_week[$week]->links[] = $link;
        }

        foreach ($links_by_week as $row)
        {
            $row->links = array_chunk( (array) $row->links, 50);
        }

        // return $links_by_week;

        return View::make('shows.updates')->with('linksByWeek',(object) $links_by_week);
    }

    /**
     * Add a episode to watchlist
     * GET /watchlist/add/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function addToWatchlist($id)
    {
        Watchlist::firstOrCreate(array(
            'episode_id' => $id,
            'user_id'    => Sentry::getUser()->id
        ));

        return Redirect::back()->with('message', trans('episode.watchlist.added'));
    }


    /**
     * Delete a episode from watchlist
     * GET /watchlist/add/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroyWatchlist($id)
    {
        Watchlist::find($id)->delete();

        return Redirect::back()->with('message', trans('episode.watchlist.deleted'));
    }


    /**
     * Add a episode to watched list
     * GET /watched/add/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function addToWatchedEpisode($id)
    {
        $userId = Sentry::getUser()->id;
        WatchedEpisode::firstOrCreate(array(
            'episode_id' => $id,
            'user_id'    => $userId
        ));

        Watchlist::whereEpisodeId($id)->whereUserId($userId)->delete();

        return Redirect::back()->with('message', trans('episode.watchedlist.added'));
    }

    /**
     * Delete a episode from watchlist
     * GET /watchlist/add/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroyWatched($id)
    {
        WatchedEpisode::find($id)->delete();

        return Redirect::back()->with('message', trans('episode.watchedlist.deleted'));
    }


    /**
     * Add a episode to favourite list
     * GET /favorites/add/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function addToFavorite($id)
    {
        Favourite::firstOrCreate(array(
            'episode_id' => $id,
            'user_id'    => Sentry::getUser()->id
        ));

        return Redirect::back()->with('message', trans('episode.favourite.added'));
    }

    /**
     * Delete a episode from favourite list
     * GET /favorites/delete/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroyFavorite($id)
    {
        Favourite::find($id)->delete();

        return Redirect::back()->with('message', trans('episode.favourite.deleted'));
    }


    /**
     * Add rating for an episode
     * GET /episode/rating/{episodeId}-{rating}
     *
     * @param  int $episodeId
     * @param  int $rating
     * @return Response
     */
    public function addEpisodeRating($episodeId, $rating)
    {
        $episodeRating = EpisodeRating::firstOrNew(array(
            'episode_id' => $episodeId,
            'user_id'    => Sentry::getUser()->id
        ));

        if ( ! isset($episodeRating->rating))
        {
            $episodeRating->rating = $rating;
            $episodeRating->save();
            $msg = trans('master.rating.added');
        } else
        {
            $episodeRating->rating = $rating;
            $episodeRating->update();
            $msg = trans('master.rating.updated');
        }

        return Redirect::back()->with('message', $msg);
    }

}
