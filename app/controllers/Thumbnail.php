<?php

class Thumbnail extends \Controller
{

    // cache time in seconds
    protected $cache_life = 604800;
    protected $url;
    protected $imagePath;
    protected $pslManager;
    protected $parser;
    protected $remoteURL;

    /**
     *
     */
    public function __construct()
    {
        $this->imagePath = Config::get('tvdb.imagePath');
        $this->pslManager = new Pdp\PublicSuffixListManager();
        $this->parser = new Pdp\Parser($this->pslManager->getList());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    protected function get_dir_path()
    {
        $files_per_dir = 400;

        if ($this->id <= $files_per_dir) $dir = 0;
        else $dir = ($this->id - ($this->id % $files_per_dir)) / $files_per_dir;

        $path = storage_path() . '/images/' . $this->type . '/' . $dir . '/';
        if (!File::isDirectory($path)) File::makeDirectory($path, 0777, true, true);

        return $path;
    }

    protected function get_full_path()
    {
        $path = $this->get_dir_path();
        $full_path = $path . $this->id . '.jpg';

        return $full_path;
    }

    protected function exists()
    {
        // $this->id = $id;

        $full_path = $this->get_full_path();

        if (File::exists($full_path)) return $full_path;

        return false;
    }


    /**
     * Display the specified resource.
     *
     * @param $type
     * @param  int $id
     * @param  string $image
     * @return Response
     */
    public function get($type, $id, $image)
    {
        $this->id = $id;
        $this->image = $image;
        $this->type = $type;
        $full_path = $this->get_full_path();

        // $image = Image::make( $this->image );
        // $image->save( $full_path );

        $image = file_get_contents($this->image);
        file_put_contents($full_path, $image);

        return true;
    }


    /**
     * Display the specified resource.
     *
     * @param $type
     * @param $showId
     * @param null $episodeId
     * @internal param int $id
     * @internal param string $image
     * @return Response
     */
    public function show($type, $showId, $episodeId = null)
    {
        $full_path = storage_path() . '/images/default.jpg';
        if ($type == "show") {
            $this->remoteURL = Show::where('id',$showId)->pluck('poster');
            $this->id = $showId;
        }
        if ($type == "episode") {
            $this->remoteURL = Episode::where('id',$episodeId)->pluck('thumbnail');
            $this->id = $episodeId;
        }

//        $urlObj = $this->parser->parseUrl($this->remoteURL);
        $filePath = $this->imagePath ."/". $this->remoteURL;
        unset($this->remoteURL);

//        unset($urlObj);
        if (file_exists($filePath)) {
            header('Content-type: image/jpeg');
            return readfile($filePath);
        }
        else
        {
            header('Content-type: image/jpeg');
            return readfile($full_path);
        }
    }

    public function showsThumbnail($type, $showId)
    {
        $defaultImage = storage_path() . '/images/default.jpg';
        if ($type == "poster") {
            $this->remoteURL = Show::where('id',$showId)->pluck('poster');
        }
        if ($type == "fanArt") {
            $this->remoteURL = Show::where('id',$showId)->pluck('fanArt');
        }
        if ($type == "banner") {
            $this->remoteURL = Show::where('id',$showId)->pluck('banner');
        }

        $filePath = $this->imagePath ."/". $this->remoteURL;
        unset($this->remoteURL);

        if (file_exists($filePath)) {
            header('Content-type: image/jpeg');
            return readfile($filePath);
        }
        else
        {
            header('Content-type: image/jpeg');
            return readfile($defaultImage);
        }
    }


}
