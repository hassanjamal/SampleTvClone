<?php


Class Cron extends Controller{


    public function check()
    {
        $time = \Carbon\Carbon::now()->subDay()->timestamp;

        $api = new API;

        return $api->getUpdates($time);
    }
}