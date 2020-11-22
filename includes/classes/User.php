<?php 
class User{
    private $con,$sqlData;
    function __construct($con,$username)
    {
        $this->con=$con;
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un");
        $query->bindParam(":un",$username);
        $query->execute();
        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getUsername(){
        return $this->sqlData['username'];
    }
    public function getFirstName(){
        return $this->sqlData['firstName'];
    }
    public function getLastName(){
        return $this->sqlData['lastName'];
    }
    public function getName(){
        return $this->sqlData['firstName']." ". $this->sqlData['lastName'];
    }
    public function getEmail(){
        return $this->sqlData['email'];
    }
    public function getSignUpDate(){
        return $this->sqlData['signUpDate'];
    }
}

?>