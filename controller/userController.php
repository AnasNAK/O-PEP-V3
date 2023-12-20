<?php 
require_once "../model/Client.php";
require_once "../model/Admin.php";




class User{

    public $clientModel;
    public $adminModel;
    
public function __construct()
{

    $this->clientModel = new Client();
    $this->adminModel = new Admin();
    
}

public function getEmail($email) {
    return $this->clientModel->checkemail($email);
}

}



?>