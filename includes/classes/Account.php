<?php

class Account{
    private $con;
    public $errorArray = array();
    function __construct($con)
    {
        $this->con = $con;
    }
    public function login($un,$pw){
        $pw = hash("sha512",$pw);
        $query = $this->con->prepare("SELECT `username`,  `password` FROM `users` WHERE password=:pw AND  username=:un");
        $query->bindParam(":pw",$pw);
        $query->bindParam(":un",$un);
        $query->execute();
        if($query->rowCount() ==1){
            return true;
        }else{
            array_push($this->errorArray,Constants::$loginError);
            return false;
        }
    }
    public function register($fn,$ln,$un,$em,$em2,$pw,$pw2){
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUserName($un);
        $this->validateEmail($em,$em2);

        //Insert
        if(empty($this->errorArray)){
            $this->insertUserDetails($fn,$ln,$un,$em,$pw);
        }else{
            return false;
        }
    }
    //Inserting data into data base
    public function insertUserDetails($fn,$ln,$un,$em,$pw){
        $pw=hash("sha512",$pw);
        $profilePic = "assets/images/profilePictures/default.png";
        $query = $this->con->prepare("INSERT INTO `users`(`firstName`, `lastName`, `username`, `email`, `password`,`profile`) VALUES (:fn,:ln,:un,:em,:pw,:pic)");
        $query->bindParam(":fn",$fn);
        $query->bindParam(":ln",$ln);
        $query->bindParam(":un",$un);
        $query->bindParam(":em",$em);
        $query->bindParam(":pw",$pw);
        $query->bindParam(":pic",$profilePic);
        return $query->execute();
         
         
    }

    //Validating First name
    private function  validateFirstName($fn){
        if(strlen($fn)> 25 || strlen($fn)<2){
            array_push($this->errorArray,Constants::$firstnameCharacters);
        }
    }
    //Validating Last name
    private function  validateLastName($ln){
        if(strlen($ln)> 25 || strlen($ln)<2){
            array_push($this->errorArray,Constants::$lastnameCharacters);
        }
    }
    //Validating User name
    private function  validateUserName($un){
        if(strlen($un)> 25 || strlen($un)<5){
            array_push($this->errorArray,Constants::$UsernameCharacters );
            return;
        }
        $query = $this->con->prepare("SELECT username FROM users WHERE username=:un");
        $query->bindParam(":un",$un);
        $query->execute();
        if($query->rowCount() !=0){
            array_push($this->errorArray,Constants::$usernameTaken );
        }
    }
    //Validating Email
    private function  validateEmail($em,$em2){
        if($em != $em2){
            array_push($this->errorArray,Constants::$emsilsDoNotMatch );
            return;
        }
        if(!filter_var($em,FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray,Constants::$emailInvailid );
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:em");
        $query->bindParam(":em",$em);
        $query->execute();
        if($query->rowCount() !=0){
            array_push($this->errorArray,Constants::$emailTaken);
        }
    }
    //Validating Password
    private function  validatePassword($pw,$pw2){
        if($pw != $pw2){
            array_push($this->errorArray,Constants::$PasswordDoNotMatch );
            return;
        }
        if(preg_match("/[^A-Za-z0-9]/",$pw)){
            array_push($this->errorArray,Constants::$PasswordNotAlphaNum);
            return;
        }
        if(strlen($pw)> 25 || strlen($pw)<5){
            array_push($this->errorArray,Constants::$passwordCharacter );
            return;
        }
    }
    //Displaying the errors
    public function getError($error){
        if(in_array($error,$this->errorArray)){
            return "<span class='errorMessage'>$error</span>";
        }
    }
}

?>