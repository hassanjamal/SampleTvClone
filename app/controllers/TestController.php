<?php

class TestController extends BaseController {

    public function test()
    {
        $content = file_get_contents("http://services.tvrage.com/feeds/full_show_info.php?sid=2930");

        return $content;
    }

}