<?php


class TvDbImage {

    protected $imagePath;
    protected $pslManager;
    protected $parser;

    /**
     *
     */
    public function __construct()
    {
        $this->imagePath = Config::get('tvdb.imagePath');
        $this->pslManager = new Pdp\PublicSuffixListManager();
        $this->parser     = new Pdp\Parser($this->pslManager->getList());
    }

    /**
     * @param $showId
     */
    public function fetchStoreShowImage($showId)
    {
        $bannerUrls = Show::where('id',$showId)->lists('Apibanner');
        $fanArturls = Show::where('id',$showId)->lists('ApifanArt');
        $posterUrls = Show::where('id',$showId)->lists('Apiposter');
        $this->fetchAndStoreImage($bannerUrls, $this->imagePath);
        $this->fetchAndStoreImage($fanArturls, $this->imagePath);
        $this->fetchAndStoreImage($posterUrls, $this->imagePath);

    }

    /**
     * @param $episodeId
     */
    public function fetchStoreEpisodeImage($episodeId)
    {
        $screenShotUrls = Episode::where('id', $episodeId)->lists('Apithumbnail');
        $this->fetchAndStoreImage($screenShotUrls, $this->imagePath);
    }

    /**
     * @param $showId
     */
    public function fetchStoreAllEpisodeImage($showId)
    {
        $screenShotUrls = Episode::where('show_id', $showId)->lists('Apithumbnail');
        $this->fetchAndStoreImage($screenShotUrls, $this->imagePath);
    }
    /**
     * @param $urls
     * @param $path
     */
    private function fetchAndStoreImage($urls, $path)
    {
        foreach($urls as $url) {
            $directoryName = '';

            $imageType     = $this->checkImageTypeFromUrl($url);
            if($imageType  == null){
                continue;
            }

            $urlObj        = $this->parser->parseUrl($url);
            $urlSegments   = explode('/', ltrim($urlObj->path, '/'));
            $fileName      = array_pop($urlSegments);
            foreach ($urlSegments as $segment) {
               $directoryName = $directoryName."/".$segment;
            }
            $directoryName = $path.$directoryName;

            //create the directory if not present
            if(!file_exists($directoryName))
                mkdir($directoryName, 0777, true);
            // imagePath
            $imagePath = $directoryName."/".$fileName;
            // check file if exists then delete
            if(file_exists($imagePath)) {
                unlink ($imagePath);
            }

            //first check if the image can be fetched
            $img_info = @getimagesize($url);
            //is it a valid image?
            if(false == $img_info || !isset($img_info[2]) || !($img_info[2] == IMAGETYPE_JPEG || $img_info[2] == IMAGETYPE_PNG || $img_info[2] == IMAGETYPE_JPEG2000 || $img_info[2] == IMAGETYPE_GIF)) {
               continue;
            }

            //now try to create the image
            if($imageType == 'jpg') {
                $createImage = @imagecreatefromjpeg($url);
            } else if($imageType == 'png') {
                $createImage = @imagecreatefrompng($url);
                @imagealphablending($createImage, false);
                @imagesavealpha($createImage, true);
            } else if($imageType == 'gif') {
                $createImage = @imagecreatefromgif($url);
            } else {
                // can not create image from given url
                continue;
            }

            // save the file on local server
            if($imageType == 'jpg') {
                imagejpeg($createImage, $imagePath, 100);
            } else if($imageType == 'png') {
                imagepng($createImage, $imagePath, 0);
            } else if($imageType == 'gif') {
                imagegif($createImage, $imagePath);
            }
        }
    }

    /**
     * @param $imageUrl
     * @return string
     */
    private function checkImageTypeFromUrl($imageUrl)
    {
        if(preg_match('/https?:\/\/.*\.png$/i', $imageUrl)) {
            $imageType = 'png';
        }
        else if(preg_match('/https?:\/\/.*\.(jpg|jpeg)$/i', $imageUrl)) {
            $imageType = 'jpg';
        }
        else if(preg_match('/https?:\/\/.*\.gif$/i', $imageUrl)) {
            $imageType = 'gif';
        }
        else {
            $imageType = null;
        }
        return $imageType;
    }

} 