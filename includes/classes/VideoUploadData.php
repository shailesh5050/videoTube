<?php 
class VideoUploadData{
    public $videoArrayData,$title,$description,$privacy,$category,$uploadedBy;
    public function __construct($videoArrayData,$title,$description,$privacy,$category,$uploadedBy)
    {
        $this->videoArrayData=$videoArrayData;
        $this->title=$title;
        $this->description=$description;
        $this->privacy=$privacy;
        $this->category=$category;
        $this->uploadedBy=$uploadedBy;
    }
}
?>