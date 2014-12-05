<?php



class AdminBaseController extends Controller{

	protected $perPage = 20;

	protected $options;

////    protected $tvDbUrl;
//
//    protected $apiKey;

    protected $tvDbClient;

    /**
     */
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

	}

}