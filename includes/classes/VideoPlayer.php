<?php 
class VideoPlayer{
    private $video;
    public function __construct($video)
    {
        $this->video = $video;
    }
    public function create($autoPlay){
        if($autoPlay){
            $autoPlay = "autoplay";
        }else{
            $autoPlay = "";
        }
        $filePath = $this->video->getFilePath();
        return '<video id="player" class="videoPlayer player" playsinline controls data-poster="https://images.unsplash.com/photo-1506104489822-562ca25152fe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1498&q=80" >
        <source src="'.$filePath.'" type="video/mp4" />';
    }
}

?>