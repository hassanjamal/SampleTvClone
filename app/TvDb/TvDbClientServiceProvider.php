<?php

namespace TvDb;

use Illuminate\Support\ServiceProvider;

class TvDbClientServiceProvider extends ServiceProvider {


    public function register()
    {
        $this->app->bind('Tvdb\Repo\TvDbClientInterface','Tvdb\Repo\TvDbClient');
    }
}
 
