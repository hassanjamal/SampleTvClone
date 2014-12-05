<?php

// TODO
// Special instead of season in show id 39210

// use Jyggen\Curl\Curl;

class API extends Controller {

    protected $api_base_url = "http://services.tvrage.com/feeds/";

    protected $defaultClass = 1;
    protected $defaultGenre = 1;

    public function get_content($url)
    {
        $content = @file_get_contents($this->api_base_url . $url);

        if (empty($content)) dd("error");
        // $data = Curl::get( $this->api_base_url . $url );

        // return $this->convert_to_array( $data[0]->getContent() );
        return $this->convert_to_array($content);
    }

    /**
     * @param $xml
     * @return mixed
     */
    public function convert_to_array($xml)
    {
        return Formatter::make($xml, 'xml')->to_array();

        // if ( empty(Formatter::$errors) ) {
        //     //show the results
        //     print_r($result);
        // } else {
        //     // Show the errors
        //     print_r(Formatter::$errors);
        //     return;
        // }
    }

    /**
     *
     */
    public function getAll()
    {
        // $api_url = "show_list.php";

        // $data = $this->get_content($api_url);

        // $counter = 0;
        // foreach ($data['show'] as $show)
        for ($i=1818; $i <= 44489; $i++)
        {

            try {
                Log::info("=== Show Id: ==== " . $i);
                // $counter ++;
                $this->getShow($i);

                echo "=== Show Id: ==== " . $i . "<br>";


            } catch (Exception $e) {

                Log::error("=== Error Show Id: ==== " . $i);
            }


        }
    }

    public function searchShow($search)
    {
        $api_url = "search.php?show=" . urlencode( $search );

        $content = $this->get_content($api_url);

        return $content;
    }

    public function getUpdates($time)
    {
//        dd($noOfShows);
        $api_url = "last_updates.php?hours=" . $time;

        $content = $this->get_content($api_url);

        return $content;

//         dd($content);


    }


    public function getShow($sid)
    {
        $api_url = "full_show_info.php?sid=" . $sid;

        $data = $this->get_content($api_url);

        return $this->save_show($data);

    }



    public function save_show($data)
    {

        $class = $this->storeClass($data['classification']);

        $show  = $this->storeShow($data, $class);

        $this->storeGenres($data, $show);

        $this->storeAkas($data, $show->id);

        $sessions = $this->storeSessions($data['totalseasons'], $show->id);

        $this->storeEpisodes($data, $sessions, $show->id);

        return $show;
    }

    public function update_show($id, $data)
    {

        $class = $this->storeClass($data['classification']);

        $show  = $this->updateShow($data, $class);

        $this->storeGenres($data, $show);

        // $this->storeAkas($data, $show->id);

        $sessions = $this->storeSessions($data['totalseasons'], $show->id);

        $this->storeEpisodes($data, $sessions, $show->id);

        return $show;
    }


    protected function storeShow($data, $class)
    {
        $con = $this->formatShowData($data, $class);

        $show = Show::create($con);

        if ( $con['image'] != "N/A")
        {
            $thumbnail = new Thumbnail;
            $thumbnail->get('show', $show->id, $con['image']);
        }

        return $show;
    }

    public function updateShow($show, $id, $data)
    {

        $con = $this->formatShowData($data);

        $show->update($con);

        // if (isset($data['image']))
        // {
        //     $thumbnail = new Thumbnail;
        //     $thumbnail->get('show', $show->id, $data['image']);
        // }

        return $show;
    }

    public function formatShowData($data, $class = null)
    {
        $show = [];
        $show['show_id'] = $data['showid'];
        $show['seasons'] = $data['totalseasons'];
        $show['name']    = $data['name'];
        $show['link']    = $data['showlink'];

        $show['start_date']   = (!empty($data['started']))  ? $data['started'] : "N/A";
        $show['end_date']     = (!empty($data['ended']) )   ? $data['ended']   : "N/A";
        $show['image']        = (isset($data['image']) )    ? $data['image']   : "N/A";

        $show['origin'] = $data['origin_country'];
        $show['status'] = $data['status'];
        if(!is_null($class))
        {
            $show['class']  = $class->id;
        }

        $show['runtime'] = (isset($data['runtime'])) ? $data['runtime'] : "0";
        $show['network'] = (isset($data['network'])) ? $data['network'] : "N/A";
        $show['airtime'] = (isset($data['airtime'])) ? $data['airtime'] : "N/A";
        $show['airday']  = (isset($data['airday']))  ? $data['airday']  : "N/A";

        return $show;
    }


    protected function storeClass($classification)
    {
        if (isset($classification))
        {
            $class = Classification::firstOrCreate(
                                                   array('name' => $classification)
                                                   );
        } else
        {
            $class = (object) array('id' => $this->defaultClass);
        }

        return $class;
    }


    public function storeGenres($data, $show)
    {
        $genres = array();
        if (isset($data['genres']['genre']) && is_array($data['genres']['genre']))
        {
            foreach ($data['genres']['genre'] as $key => $value)
            {
                $genre    = Genre::firstOrCreate( array('name' => $value) );
                $genres[] = $genre->id;
            }
        }
        elseif (isset($data['genres']['genre']))
        {
            $genre = Genre::firstOrCreate( array('name' => $data['genres']['genre']) );
        }
        else
        {
            $genres = array($this->defaultGenre);
        }
        $show->genre()->sync($genres);
    }


    protected function storeAkas($data, $id)
    {
        Aka::Create(array('show_id' => $id, 'name' => $data['name']));
        if (isset($data['akas']) && is_array($data['akas']))
        {
            if (is_array($data['akas']['aka']))
            {
                foreach ($data['akas']['aka'] as $key => $value)
                {
                    Aka::Create(array('show_id' => $id, 'name' => $value));
                }
            } else
            {
                Aka::Create(array('show_id' => $id, 'name' => $data['akas']['aka']));
            }
        }

        return;
    }


    public function storeSessions($total, $id)
    {
        $sessions = array();
        foreach (range(1, $total) as $key => $num)
        {
            $showSession = ShowSession::firstOrCreate(
                array(
                    'show_id' => $id,
                    'number'  => $num,
                )
            );

            $sessions[$num] = $showSession->id;
        }

        return $sessions;
    }


    // protected function updateSessions($total, $id)
    // {
    //     $sessions = ShowSession::where('show_id', '=', $id)->get();

    //     if (count($sessions) > $total)
    //     {
    //         $diff     = $total - count($sessions);
    //         $sessions = array();
    //         foreach (range($total + 1, $diff) as $key => $num)
    //         {
    //             $showSession = ShowSession::Create(array(
    //                                                'show_id' => $id,
    //                                                'number'  => $num,
    //                                                ));
    //         }

    //         $sessions = ShowSession::where('show_id', '=', $id)->get();
    //     }

    //     foreach ($sessions as $row)
    //     {
    //         $sessions[$row->number] = $row->id;
    //     }


    //     return $sessions;
    // }

    /**
     * @param $data
     * @param $sessions
     * @param $showId
     */
    public function storeEpisodes($data, $sessions, $showId)
    {
        $session    = 1;
        $episodeNum = 1;
        if (isset($data['Episodelist']))
        {
            if (count($data['Episodelist']['Season']) > 2 || ! isset($data['Episodelist']['Season']['episode']))
            {
                foreach ($data['Episodelist']['Season'] as $episodes)
                {
                    foreach ($episodes['episode'] as $row)
                    {
                        if (isset($row['epnum']))
                        {
                            $this->storeEpisode($row, $sessions, $session, $episodeNum, $showId);
                        } else
                        {
                            $this->storeEpisode($episodes['episode'], $sessions, $session, $episodeNum, $showId);
                        }
                        $episodeNum ++;
                    }
                    $episodeNum = 1;
                    $session ++;
                }
            } else
            {
                foreach ($data['Episodelist']['Season']['episode'] as $row)
                {
                    if (isset($row['epnum']))
                    {
                        $this->storeEpisode($row, $sessions, $session, $episodeNum, $showId);
                    } else
                    {
                        $this->storeEpisode($data['Episodelist']['Season']['episode'], $sessions, $session, $episodeNum, $showId);
                    }
                    $episodeNum ++;
                }

            }
        }
        return;

    }


    // /**
    //  * @param $data
    //  * @param $sessions
    //  */
    // protected function updateEpisodes($data, $sessions)
    // {
    //     $session    = 1;
    //     $episodeNum = 1;
    //     if (isset($data['Episodelist']))
    //     {
    //         if (count($data['Episodelist']['Season']) > 2 || ! isset($data['Episodelist']['Season']['episode']))
    //         {
    //             foreach ($data['Episodelist']['Season'] as $episodes)
    //             {

    //                 foreach ($episodes['episode'] as $row)
    //                 {
    //                     if (isset($row['epnum']))
    //                     {
    //                         return $this->storeEpisode($row, $sessions, $session, $episodeNum);
    //                     }
    //                     else
    //                     {
    //                         return $this->storeEpisode($episodes['episode'], $sessions, $session, $episodeNum);
    //                     }
    //                     $episodeNum ++;
    //                 }
    //                 $episodeNum = 1;
    //                 $session ++;
    //             }
    //         } else
    //         {
    //             foreach ($data['Episodelist']['Season']['episode'] as $row)
    //             {
    //                 if (isset($row['epnum']))
    //                 {
    //                     return $this->storeEpisode($row, $sessions, $session, $episodeNum);
    //                 }
    //                 else
    //                 {
    //                     return $this->storeEpisode($data['Episodelist']['Season']['episode'], $sessions, $session, $episodeNum);
    //                 }
    //                 $episodeNum ++;
    //             }

    //         }
    //     }

    // }


    /**
     * @param $data
     * @param $sessions
     * @param $session
     * @param $episodeNum
     * @param $showId
     */
    public function storeEpisode($data, $sessions, $session, $episodeNum, $showId)
    {
        $code = "S" . sprintf("%02s", $session) . "E" . sprintf("%02s", $episodeNum);

        $episode['show_id']         = $showId;
        $episode['show_session_id'] = $sessions[$session];
        $episode['code']            = $code;

        $ep =  Episode::where( $episode )->first();

        $episode['number']          = (isset($data['epnum'])) ? $data['epnum'] : "N/A";

        if (empty($data['prodnum']) || is_array($data['prodnum'])) $episode['prod_num'] = "N/A";
        else $episode['prod_num'] = $data['prodnum'];

        $episode['air_date']   = (isset($data['airdate'])) ? $data['airdate'] : "N/A";

        if(isset($data['title']) && is_array($data['title']))
            $episode['title']      = (empty($data['title'][0])) ? $code : $data['title'][0];
        else
            $episode['title']      = (isset($data['title'])) ? $data['title'] : $code;

        $episode['screenshot'] = (isset($data['screencap'])) ? $data['screencap'] : "N/A";


        if( !isset($ep->id) )
        {
            $epi = Episode::create($episode);

            if (isset($data['screencap']))
            {
                $thumbnail = new Thumbnail;
                $thumbnail->get('episode', $epi->id, $data['screencap']);
            }

        }
        else
        {
            // $episode['number']          = (isset($data['epnum'])) ? $data['epnum'] : "N/A";

            // if (empty($data['prodnum']) || is_array($data['prodnum'])) $episode['prod_num'] = "N/A";
            // else $episode['prod_num'] = $data['prodnum'];

            // $episode['air_date']   = (isset($data['airdate'])) ? $data['airdate'] : "N/A";

            // if(isset($data['title']) && is_array($data['title']))
            //     $episode['title']      = (empty($data['title'][0])) ? $code : $data['title'][0];
            // else
            //     $episode['title']      = (isset($data['title'])) ? $data['title'] : $code;

            // $episode['screenshot'] = (isset($data['screencap'])) ? $data['screencap'] : "N/A";

            // try{
            Episode::find($ep->id)->update($episode);


            // }
            // catch (Exception $e) {

            //     var_dump($episode);
            //     dd($data);
            //     // Log::error("=== Error Show Id: ==== " . $i);
            // }
        }
            return $episode;
    }

    // /**
    //  * @param $data
    //  * @param $sessions
    //  * @param $session
    //  */
    // public function updateEpisode($data, $sessions, $session)
    // {
    //     $episode = Episode::whereNumber($data['epnum'])->first();

    //     if ( ! isset($episode->id))
    //     {

    //         $episode                  = new Episode;
    //         $episode->show_session_id = $sessions[$session];
    //         $episode->number          = (isset($data['epnum'])) ? $data['epnum'] : "N/A";

    //         if (empty($data['prodnum']) || is_array($data['prodnum'])) $episode->prod_num = "N/A";
    //         else $episode->prod_num = $data['prodnum'];

    //         $episode->air_date   = (isset($data['airdate'])) ? $data['airdate'] : "N/A";
    //         $episode->title      = $data['title'];
    //         $episode->screenshot = (isset($data['screencap'])) ? $data['screencap'] : "N/A";
    //         $episode->save();

    //         if (isset($data['screencap']))
    //         {
    //             $thumbnail = new Thumbnail;
    //             $thumbnail->get('episode', $episode->id, $data['screencap']);
    //         }
    //     }

    //     return;
    // }
}
