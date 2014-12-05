<?php

class embedVideo
{
    protected $pslManager;
    protected $parser;
    protected $width;
    protected $height;
    protected $altWidth;
    protected $altHeight;

    /**
     *
     */
    public function __construct()
    {
        $this->pslManager = new Pdp\PublicSuffixListManager();
        $this->parser     = new Pdp\Parser($this->pslManager->getList());
        $this->width      = 640;
        $this->height     = 360;
        $this->altWidth   = 900;
        $this->altHeight  = 596;
    }

    /**
     * @param $url
     * @param null $alternateSize
     * @return string
     */
    public function getVideoFrame($url, $alternateSize = null)
    {
        $urlObj = $this->parser->parseUrl($url);
        $domain = $urlObj->host->registerableDomain;

        // dd($domain);


        switch ($domain) {
            case 'vidto.me':
                $frameSrc = $this->getVidtoMe($url, $alternateSize);
                break;

            case 'allmyvideos.net':
                $frameSrc = $this->getAllMyVideos($url, $alternateSize);
                break;

            case '4shared.com':
                $frameSrc = $this->get4shared($url, $alternateSize);
                break;

            case 'youtube.com':
                $frameSrc = $this->getYouTube($url, $alternateSize);
                break;

            case 'vodlocker.com':
                $frameSrc = $this->getVidLocker($url, $alternateSize);
                break;

            case 'vidbull.com':
                $frameSrc = $this->getVidBull($url, $alternateSize);
                break;

            case 'gorillavid.in':
                $frameSrc = $this->getGorillaVid($url, $alternateSize);
                break;

            case 'vidspot.net':
                $frameSrc = $this->getVidSpot($url, $alternateSize);
                break;

            case 'vshare.eu':
                $frameSrc = $this->getVshare($url, $alternateSize);
                break;

            case 'firedrive.com':
                $frameSrc = $this->getFireDrive($url, $alternateSize);
                break;

            case 'videoweed.es':
                $frameSrc = $this->getVideoWeed($url, $alternateSize);
                break;

            case 'played.to':
                $frameSrc = $this->getPlayed($url, $alternateSize);
                break;

            case 'thevideo.me':
                $frameSrc = $this->getTheVideo($url, $alternateSize);
                break;

            case 'vidzi.tv':
                $frameSrc = $this->getVidzi($url, $alternateSize);
                break;

            case 'mightyupload.com':
                $frameSrc = $this->getMightyUpload($url, $alternateSize);
                break;

            case 'mrfile.me':
                $frameSrc = $this->getMrFile($url, $alternateSize);
                break;

            case 'cloudyvideos.com':
                $frameSrc = $this->getCloudyVideos($url, $alternateSize);
                break;

            case 'nowvideo.sx':
                $frameSrc = $this->getNowVideo($url, $alternateSize);
                break;

            case 'novamov.com':
                $frameSrc = $this->getNovaMov($url, $alternateSize);
                break;

            case 'vidbux.com':
                $frameSrc = $this->getVidBux($url, $alternateSize);
                break;



            default:
                $frameSrc = "false";
                break;
        }

        return $frameSrc;
    }


    /**
     * @param $url
     * @param null $alternateSize
     * @return string
     */
    private function getVidtoMe($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.html$/', '', $url->path);
        $code = ltrim($code, '/');


        if (is_null($alternateSize)) {
            $src =  "<iframe width=" . $this->width . " height=" . $this->height .
                    " src=\"http://vidto.me/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" frameborder=0 allowfullscreen='true' ></iframe>";
        } else {
            $src =  "<iframe width=" . $this->altWidth . " height=" . $this->altHeight .
                    " src=\"http://vidto.me/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" frameborder=0 allowfullscreen='true' ></iframe>";
        }

        return $src;
    }

    private function getAllMyVideos($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.html$/', '', $url->path);
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://allmyvideos.net/embed-" . $code .
                    ".html\" frameborder=0 marginwidth=0 marginheight=0 scrolling=NO allowfullscreen='true'
                    width=" . $this->width . " height=" . $this->height ." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://allmyvideos.net/embed-" . $code .
                    ".html\" frameborder=0 marginwidth=0 marginheight=0 scrolling=NO allowfullscreen='true'
                    width=" . $this->altWidth . " height=" . $this->altHeight." ></iframe>";
        }

        return $src;
    }


    static function getShockShare()
    {
        $pslManager = new Pdp\PublicSuffixListManager();
        $parser = new Pdp\Parser($pslManager->getList());
        $host = 'http://www.sockshare.com/file/635733EE71654323';
        $url = $parser->parseUrl($host);
        $code = preg_replace('/.html$/', '', $url->path);
        $code = ltrim($code, '/');
        $src = "http://allmyvideos.net/embed-" . $code . ".html";
        return $code;
    }

    // http://www.4shared.com/vhttp://www.4shared.com/video/MnQ1m9psba/Step_up_Revolution_Movie_2012_.htmideo/MnQ1m9psba/Step_up_Revolution_Movie_2012_.htm
    // <iframe src="http://www.4shared.com/web/embed/file/NEqqtRAWce" frameborder="0" scrolling="no" width="470" height="320"></iframe>

    private function get4shared($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $pathArray = explode('/', $url);

        $code = ltrim($pathArray[4], ' ');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://www.4shared.com/web/embed/file/".$code."\"
                    frameborder=\"0\" scrolling=\"no\" width=\" ".$this->width."\"
                    height=\"".$this->height."\"></iframe>";
        } else {
            $src =  "<iframe src=\"http://www.4shared.com/web/embed/file/".$code."\"
                    frameborder=\"0\" scrolling=\"no\" width=\" ".$this->altWidth."\"
                    height=\"".$this->altHeight."\"></iframe>";
        }
        return $src;

    }

    private function getYouTube($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/^[^,]*=\s*/', '', $url->query);
        $code = trim($code, ' ');

        // dd($code);

        if (is_null($alternateSize)) {
            $src =  "<iframe width=\" ".$this->width."\" height=\"".$this->height."\"
                    src=\"//www.youtube.com/embed/".$code."\"
                    frameborder=\"0\" allowfullscreen ></iframe>";
        } else {
            $src =  "<iframe width=\" ".$this->width."\" height=\"".$this->height."\"
                    src=\"//www.youtube.com/embed/".$code."\"
                    frameborder=\"0\" allowfullscreen ></iframe>";
        }
        return $src;

    }

    //http://vodlocker.com/lbg1gronkpoe
    //<IFRAME SRC="http://vodlocker.com/embed-lbg1gronkpoe-640x360.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=640 HEIGHT=360></IFRAME>

    private function getVidLocker($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = $url->path;
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://vodlocker.com/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://vodlocker.com/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }

    // http://vidbull.com/lb2el3m0f4p9.html
    // <IFRAME SRC="http://vidbull.com/embed-lb2el3m0f4p9-720x405.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=720 HEIGHT=425></IFRAME>
    private function getVidBull($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.html$/', '', $url->path);
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://vidbull.com/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://vidbull.com/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }

    //http://gorillavid.in/pz68jipxzia6
    // <IFRAME SRC="http://gorillavid.in/embed-pz68jipxzia6-960x480.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=960 HEIGHT=480></IFRAME>
    private function getGorillaVid($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = $url->path;
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://gorillavid.in/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://gorillavid.in/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }

    // http://vidspot.net/097gpxbjk6nn
    // <IFRAME SRC="http://vidspot.net/embed-097gpxbjk6nn.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=720 HEIGHT=428></IFRAME>
    private function getVidSpot($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = $url->path;
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://vidspot.net/embed-" . $code . ".html\" 
                    FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://vidspot.net/embed-" . $code . ".html\" 
                    FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }

    //http://www.vidbux.com/ouofu5cn0al2
    //<IFRAME SRC="http://vidbux.to/embed-ouofu5cn0al2-width-653-height-362.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=653 HEIGHT=362></IFRAME>

    private function getVidBux($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = $url->path;
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://vidbux.com/embed-" . $code ."-width-" .$this->width."-height-".$this->height .".html\" 
                    FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://vidbux.com/embed-" . $code ."-width-" .$this->altWidth."-height-".$this->altHeight .".html\" 
                    FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        
        return $src;

    }

    // http://vshare.eu/b6caa6zum66f.htm
    // <iframe src="http://vshare.eu/embed-b6caa6zum66f-600x300.html" frameborder=0 marginwidth=0 marginheight=0 scrolling=no width=600 height=300></iframe>
    
    private function getVshare($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.htm$/', '', $url->path);
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://vshare.eu/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://vshare.eu/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }

    // http://www.firedrive.com/file/0430907B15372275
    // <iframe width='560' height='315' frameborder='0' allowfullscreen src='https://www.firedrive.com/embed/0430907B15372275'></iframe>
    private function getFireDrive($url, $alternateSize = null)
    {

        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $pathArray = explode('/', $url->path);

        $code = trim($pathArray[2], ' ');

        if (is_null($alternateSize)) {
            $src =  "<iframe frameborder='0' scrolling='no' width=' ".$this->width."'
                    height='".$this->height."'
                    src='http://www.firedrive.com/embed/".$code."'
                    ></iframe>";
        } else {
            $src =  "<iframe frameborder='0' scrolling='no' width=' ".$this->altWidth."'
                    height='".$this->altHeight."'
                    src='http://www.firedrive.com/embed/".$code."'
                    ></iframe>";
        }

        return $src;

    }

    // http://www.videoweed.es/file/8fa71fc1c1fa2
    // <iframe width="600" height="480" frameborder="0" src="http://embed.videoweed.es/embed.php?v=8fa71fc1c1fa2" scrolling="no"></iframe>
    
    private function getVideoWeed($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $pathArray = explode('/', $url->path);

        $code = trim($pathArray[2], ' ');

        if (is_null($alternateSize)) {
            $src =  "<iframe frameborder=\"0\"  width=\" ".$this->width."\"
                    height=\"".$this->height."\"
                    src=\"http://embed.videoweed.es/embed.php?v=".$code."\"
                    ></iframe>";
        } else {
            $src =  "<iframe frameborder=\"0\"  width=\" ".$this->altWidth."\"
                    height=\" ".$this->altHeight."\"
                    src=\"http://embed.videoweed.es/embed.php?v=".$code."\"
                    ></iframe>";
        }
        return $src;

    }

    //http://www.novamov.com/file/096262699352a
    //<iframe style='overflow: hidden; border: 0; width: 600px; height: 480px' src='http://embed.novamov.com/embed.php?v=096262699352a' scrolling='no'></iframe>
    
    private function getNovaMov($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $pathArray = explode('/', $url->path);

        $code = trim($pathArray[2], ' ');

        if (is_null($alternateSize)) {
            $src =  "<iframe style=' overflow: hidden ; border: 0;  width:".$this->width." ;
                    height:".$this->height." ';
                    src='http://embed.videoweed.es/embed.php?v=".$code." ' scrolling='no'
                    ></iframe>";
        } else {
            $src =  "<iframe style=' overflow: hidden ; border: 0;  width:".$this->altWidth." ;
                    height:".$this->altHeight." ';
                    src='http://embed.videoweed.es/embed.php?v=".$code." ' scrolling='no'
                    ></iframe>";
        }
        return $src;

    }

    //http://www.nowvideo.sx/file/5236e0090007a
    //<iframe width="600" height="480" frameborder="0" src="http://embed.nowvideo.sx/embed.php?v=5236e0090007a" scrolling="no"></iframe>
    //
    private function getNowVideo($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $pathArray = explode('/', $url->path);

        $code = trim($pathArray[2], ' ');

        if (is_null($alternateSize)) {
            $src =  "<iframe frameborder=\"0\"  width=\" ".$this->width."\"
                    height=\"".$this->height."\"
                    src=\"http://embed.nowvideo.sx/embed.php?v=".$code."\" scrolling=\"no\"
                    ></iframe>";
        } else {
            $src =  "<iframe frameborder=\"0\"  width=\" ".$this->altWidth."\"
                    height=\" ".$this->altHeight."\"
                    src=\"http://embed.nowvideo.sx/embed.php?v=".$code."\" scrolling=\"no\"
                    ></iframe>";
        }
        return $src;

    }

    //http://played.to/pt28a2l0x2r4.htm
    //<IFRAME SRC="http://played.to/embed-pt28a2l0x2r4-640x360.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=640 HEIGHT=360></IFRAME>
    //
    private function getPlayed($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.htm$/', '', $url->path);
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://played.to/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://played.to/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }
    //http://www.thevideo.me/ehvkgexgb3a5.htm
    //<iframe width="853" height="480" src="http://www.thevideo.me/embed-ehvkgexgb3a5-853x480.html" frameborder="0" allowfullscreen></iframe>;
    //
    private function getTheVideo($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.htm$/', '', $url->path);
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe width=\" ".$this->width. "\" height=\" ".$this->height."\" 
                    src=\"http://thevideo.me/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=\"0\" allowfullscreen ></iframe>";
        } else {
            $src =  "<iframe width=\" ".$this->altWidth. "\" height=\" ".$this->altHeight."\" 
                    src=\"http://thevideo.me/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=\"0\" allowfullscreen ></iframe>";
        }
        return $src;

    }
    //http://vidzi.tv/vx91skbmrikz.htm
    //<IFRAME SRC="http://vidzi.tv/embed-vx91skbmrikz-640x360.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=640 HEIGHT=360></IFRAME>
    //
    private function getVidzi($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.htm$/', '', $url->path);
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://vidzi.tv/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://vidzi.tv/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }
    //http://www.mightyupload.com/a5mmtmbt1w1q.htm
    //<IFRAME SRC="http://www.mightyupload.com/embed-a5mmtmbt1w1q-645x353.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=645 HEIGHT=373></IFRAME>
    //
    private function getMightyUpload($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.htm$/', '', $url->path);
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://mightyupload.com/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://mightyupload.com/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }
    //http://mrfile.me/7j1krl13g5k5.htm
    //<IFRAME SRC="http://mrfile.me/embed-7j1krl13g5k5-640x385.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=640 HEIGHT=405></IFRAME>
    //
    private function getMrFile($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.htm$/', '', $url->path);
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://mrfile.me/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://mrfile.me/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }
    //http://cloudyvideos.com/vx9l1sfkf54s.htm
    //<IFRAME SRC="http://cloudyvideos.com/embed-vx9l1sfkf54s-600x330.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH=600 HEIGHT=330></IFRAME>
    //
    private function getCloudyVideos($url, $alternateSize = null)
    {
        $host = $url;
        $url  = $this->parser->parseUrl($host);
        $code = preg_replace('/.htm$/', '', $url->path);
        $code = ltrim($code, '/');

        if (is_null($alternateSize)) {
            $src =  "<iframe src=\"http://cloudyvideos.com/embed-" . $code . "-" . $this->width .
                    "x" . $this->height . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->width." HEIGHT=".$this->height." ></iframe>";
        } else {
            $src =  "<iframe src=\"http://cloudyvideos.com/embed-" . $code . "-" . $this->altWidth .
                    "x" . $this->altHeight . ".html\" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO
                    WIDTH=".$this->altWidth." HEIGHT=".$this->altHeight." ></iframe>";
        }
        return $src;

    }

}
