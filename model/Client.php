<?php

require_once __DIR__ . "./Database.php";


class Client extends Database {
    
    private $db;

    private $user_id;
    private $first_name;
    private $last_name;
    private $user_email;
    private $user_password;
    private $user_role;

   
    public function __construct()
    {
       
        $this->db = Database::getInstance()->getConnection(); 

        if ($this->db) {
     
        } else {
            echo "Unable to connect";
        }
    }

   

    public function checkemail($email){
    $query = "SELECT * FROM user WHERE email = :email";
    try {
        $stmt =  $this->db->prepare($query);
        $stmt->bindParam('email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user){
          var_dump($user);
        }else{
            echo"user is not available";
        }
       
    } catch (PDOException $e) {
        echo "error in : ".$e->getMessage();
       
    }


}


}



?>