<?php

class VideoProcessor
{
    private $con;
    private $ffmpegPath;
    private $sizeLimit = 40000000;
    private $allowedType = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");
    private $ffprobPath;

    public function __construct($con)
    {
        $this->con = $con;
        $this->ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe");
        $this->ffprobPath = realpath("ffmpeg/bin/ffprobe.exe");
    }
    public function upload($videoUploadData)
    {
        $targetDir = "uploads/videos/";
        $videoData = $videoUploadData->videoArrayData;

        $tempFilePath = $targetDir . uniqid() . basename($videoData["name"]);
        $tempFilePath = str_replace(" ", "_", $tempFilePath);

        $isValidData = $this->processData($videoData, $tempFilePath);
        if (!$isValidData) {
            return false;
        }
        if (move_uploaded_file($videoData["tmp_name"], $tempFilePath)) {
            echo "File is Uploaded Successfully";
            $finalFilePath = $targetDir . uniqid() . ".mp4";
            if (!$this->insertVideoData($videoUploadData, $finalFilePath)) {
                echo "insert query is failed";
                return false;
            }

            if (!$this->conertVideoToMp4($tempFilePath, $finalFilePath)) {
                echo "Upload failed\n";
                return false;
            }
            if (!$this->delete($tempFilePath)) {
                return false;
            }
            //crection plaese!
            if (!$this->generateThumbnails($finalFilePath)) {
                echo "Unable To generate Thumbnails";
                return false;
            }

            return true;
        }
    }
    private function processData($videoData, $filePath)
    {
        $videoType = pathinfo($filePath, PATHINFO_EXTENSION);
        //Validating For Size
        if (!$this->isValidSize($videoData)) {
            echo "File Is too Large . Can't be more Than " . $this->sizeLimit . " Bytes";
            return false;
        }
        //Validating For Type
        else if (!$this->isValidType($videoType)) {
            echo "Invalid File Type";
            return false;
        } else if ($this->hasError($videoData)) {
            echo "Your File Has Error " . $videoData['error'];
            return false;
        }
        return true;
    }
    //validate size
    private function isValidSize($data)
    {
        return $data["size"] <= $this->sizeLimit;
    }
    //validate type
    private function isValidType($type)
    {
        $lowercased = strtolower($type);
        return in_array($lowercased, $this->allowedType);
    }
    //checking errors
    private function hasError($data)
    {
        return $data["error"] != 0;
    }
    // insert data into table 
    private function insertVideoData($videoData, $filePath)
    {
        $query = $this->con->prepare("INSERT INTO `videos`(`uploadedby`, `title`, `description`, `privacy`, `filePath`, `category`) VALUES (:uploadedby,:title,:description,:privacy,:filePath,:category)");
        $query->bindParam(":title", $videoData->title);
        $query->bindParam(":uploadedby", $videoData->uploadedBy);
        $query->bindParam(":description", $videoData->description);
        $query->bindParam(":privacy", $videoData->privacy);
        $query->bindParam(":filePath", $filePath);
        $query->bindParam(":category", $videoData->category);
        return $query->execute();
    }

    //Conver video To Mp4
    public function conertVideoToMp4($tempFilePath, $finalFilePath)
    {
        $cmd = "$this->ffmpegPath -i $tempFilePath $finalFilePath 2>&1";
        $outputLog = array();
        //wrong code
        exec($cmd, $outputLog, $returnCode);
        if ($outputLog == 0) {
            foreach ($outputLog as $line) {
                echo $line . "<br>";
            }
            return false;
        }
        return true;
    }
    //Delete the video that is other than mp4
    private function delete($filePath)
    {
        if (!unlink($filePath)) {
            return false;
        }
        return true;
    }

    //Generating thumbnails
    public function generateThumbnails($filePath)
    {
        $thumbnailSize = "210x118";
        $numThumbails = 3;
        $pathToThumbnails = "uploads/videos/thumbnails";
        $duration = $this->getVideoDuration($filePath);
        
        $videoId = $this->con->lastInsertId();
        $this->updateDuration($duration, $videoId);
        for ($num = 1; $num <= $numThumbails; $num++) {
            $imageName = uniqid() . ".jpg";
            $interval = ($duration * 0.8) / $numThumbails * $num;
            $fullThumbnailsPath = "$pathToThumbnails/$videoId-$imageName";
            $cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailsPath 2>&1";
            $outputLog = array();
            //wrong code
            exec($cmd, $outputLog, $returnCode);
            if ($outputLog == 0) {
                foreach ($outputLog as $line) {
                    echo $line . "<br>";
                }
                return false;
            }
            $selected = $num == 1 ? 1 : 0;
            $query = $this->con->prepare("INSERT INTO `thumbnails`(`videoid`, `filePath`, `selected`) VALUES (:videoid,:filePath,:selected)");
            $query->bindParam(":videoid", $videoId);
            $query->bindParam(":filePath", $fullThumbnailsPath);
            $query->bindParam(":selected", $selected);
            
            $success = $query->execute();
            if (!$success) {
                echo "thumbnails is inserting successfully";
                return false;
            }
        }
        return true;
    }

    //get Duration of video
    private function getVideoDuration($filePath)
    {
        return (int)shell_exec("$this->ffprobPath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }

    //update duration
    private function updateDuration($duration, $videoId)
    {
        $duration = (int)$duration;

        $hours = floor($duration / 3600);
        $mins = floor(($duration - ($hours * 3600)) / 60);
        $sec = floor($duration % 60);

        //Formating the hours
        if ($hours < 1) {
            $hours = "";
        } else {
            $hours = $hours . ":";
        }
        //Formating the mins
        if ($mins < 10) {
            $mins = "0" . $mins . ":";
        } else {
            $mins = $mins . ":";
        }
        //Formating the sec
        if ($sec < 10) {
            $sec = "0" . $sec;
        } else {
            $mins = $mins;
        }
        $duration = $hours . $mins . $sec;
        $query = $this->con->prepare("UPDATE `videos` SET `duration`=:duration WHERE id=:videoId");
        $query->bindParam(":duration", $duration);
        $query->bindParam(":videoId", $videoId);

        $query->execute();
    }
}
?>