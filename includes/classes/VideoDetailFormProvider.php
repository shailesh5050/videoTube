<?php 
class VideoDetailFormProvider{
        public $con;
    function __construct($con)
    {
        $this->con=$con;
    }
    public function createUploadForm(){
        $fileInput = $this->createFileInput();
        $fileTitle = $this->createTitleInput();
        $fileDescription = $this->createDescriptionInput();
        $createPrivacyInput=$this->createPrivacyInput();
        $createCategotiesInput=$this->createCategotiesInput();
        $createUploadButton=$this->createUploadButton();
       return  '<form action="processing.php" method="POST" enctype="multipart/form-data">
                '.$fileInput.'
                '.$fileTitle.'
                '.$fileDescription.'
                '.$createPrivacyInput.'
                '.$createCategotiesInput.'
                '.$createUploadButton.'
       
       </form>';
       
    }

    //File Input

    private function createFileInput(){
        return '<div class="form-group">
        <label>Upload Video</label>
        <input type="file" class="form-control-file" name="videoFile">
        </div> ';
    }
    //Title Input
    private function createTitleInput(){
        return '<div class="form-group">
        
        <input type="text" class="form-control" placeholder="Video Titlel" name="titleInput">
        </div> ';
    }
      //Description Input
    private function createDescriptionInput(){
        return '<div class="form-group">
        
        <textarea type="text" class="form-control" placeholder="Video Description" name="descriptionInput" row="3"></textarea>
        </div> ';
    }
      //Privacy Input
    private function createPrivacyInput(){
        return '<div class="form-group">
        
        <label for="exampleFormControlSelect2">Privacy</label>
        <select class="form-control"  name="privacyInput">
        <option value="0">Private</option>
        <option value="1">Public</option>
        
        </select>
        </div> ';
    }

    //Taking Categories
    private function createCategotiesInput(){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();
         $hmtl='<div class="form-group">
        
        <label for="exampleFormControlSelect2">Categories</label>
        <select class="form-control"  name="categoryInput">';
        
        while($row=$query->fetch(PDO::FETCH_ASSOC)){
            $hmtl.= '<option value='.$row['id'].'>'.$row['name'].'</option> ';
        }
        
        '.</select>
        </div> ';

        return $hmtl;
        
    }

    //Create Upload Button
    private function createUploadButton(){
        return '<input type="submit" class="btn btn-primary my-3" name="uploadButton" value="Upload">';
    }
    
}

?>