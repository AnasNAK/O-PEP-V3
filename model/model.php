<?php
session_start();
require_once "../config/Config.php" ;


class Database {
    private static $instance;
    private $connection;

    private function __construct() {
        // Your database connection logic here
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle connection error
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}

class Session {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function checkUserSession() {
       

        if (isset($_SESSION['user_email'])) {
            $user_email = $_SESSION['user_email'];

            $query = "SELECT RoleId FROM user WHERE Email = ?";
            $stmt = $this->db->prepare($query);

            if ($stmt) {
                $stmt->execute([$user_email]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $role_id = $result['RoleId'];

                    if ($role_id == 2) {
                        // Admin user
                        return 'admin';
                    } elseif ($role_id == 1) {
                        // Client user
                        return 'client';
                    } elseif ($role_id == 3) {
                        // Super Admin user
                        return 'superAdmin';
                    } elseif ($role_id == 4) {
                        // User is blocked by Super Admin
                        return 'blocked';
                    }
                } else {
                    // Handle the case where no rows are returned
                    return "No user found with the specified email.";
                }
            } else {
                // Handle the case where the prepare statement fails
                return "Error preparing statement: " . $this->db->errorInfo()[2];
            }
        }

        // If session is not set or user doesn't match any role, return false
        return false;
    }
}

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('location: ./SingIn.php');
    }

    public function authentification($email, $password) {
        $query = "SELECT IdUser, RoleId, `Password` FROM User WHERE Email = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $storedPassword = $user['Password'];

                if (password_verify($password, $storedPassword)) {
                    $_SESSION['user_email'] = $email;
                    $this->redirectUser($user['RoleId']);
                } else {
                    return "Entered password does not match. Please try again.";
                }
            } else {
                return "Invalid credentials. Please try again.";
            }
        } else {
            return "Error preparing statement: " . $this->db->errorInfo()[2];
        }
    }

    private function redirectUser($roleId) {
        switch ($roleId) {
            case 1:
                header("Location: ../view/index.php");
                break;
            case 2:
                header("Location: ../view/dashboard.php");
                break;
            case 3:
                header("Location: ../view/dashboard-s.php");
                break;
            case 4:
                header("Location: ../view/block-page.php");
                break;
            default:
                header("Location: ../view/SingIn.php");
                break;
        }
        exit(); 
    }


    public function registerUser($firstName, $lastName, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user (`FirstName`, `LastName`, `Email`, `Password`) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
            $stmt = null; 

            $_SESSION['user_email'] = $email;
            header("Location: ../view/Singup2.php");
            exit();
        } else {
            // Handle the case where the prepare statement fails
            echo "Error preparing statement: " . implode(" ", $this->db->errorInfo());
        }
    }


    public function updateUserRole($selectedRole, $userEmail) {
        $query = "UPDATE user SET roleId = ? WHERE email = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->execute([$selectedRole, $userEmail]);

            if ($selectedRole == 1) {
                header("Location: ../view/index.php");
                exit();
            } elseif ($selectedRole == 2) {
                header("Location: ../view/dashboard.php");
                exit();
            }
        } else {
          
            echo "Error preparing statement: " . implode(" ", $this->db->errorInfo());
        }
    }
}


class Categorie {

    private $db ;

    private $categorie_name;
    private $categorie_id;
    private $count; 
    public $errorMsg ;

    public function __construct(){
    $this->db = Database::getInstance()->getConnection();
    }


    public function setCategorieId($categorieid){
        $this->categorie_id = $categorieid;
    }

    public function getCategorieId(){
        return $this->categorie_id;
    }

    public function setCategorieName($categorieName){

        $this->categorie_name = $categorieName;

    }


    public function getCategorieName(){
        return $this->categorie_name;
    }


    public function addCategory($categoryName) {
        $query = "INSERT INTO categorie (CategorieName) VALUES (?)";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->execute([$categoryName]);

        
            header("Location: ./dashboard.php");
            exit();
        } else {
           
            $this->errorMsg = "Error preparing statement: " . implode(" ", $this->db->errorInfo());
           
        }
    }


    public function getCategoryById($categoryId) {
        $query = "SELECT * FROM categorie WHERE IdCategorie = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->execute([$categoryId]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($category) {
                $this->categorie_id = $category['IdCategorie'];
                return $this->categorie_id;
            } else {
                return false; 
            }
        } else {
            return false; 
        }
    }


    public function updateCategory($categoryId, $updatedCategoryName) {
        $query = "UPDATE `categorie` SET CategorieName = ? WHERE IdCategorie = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->execute([$this->getCategorieName(), $this->getCategorieId()]);
            return true; 
        } else {
            return false;
        }
    }



    public function deleteCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCategory'])) {
            if (isset($_POST['categoryId'])) {
                $categoryIdToDelete = $_POST['categoryId'];

                $deleteQuery = "DELETE FROM categorie WHERE IdCategorie = ?";
                $deleteStmt = $this->db->prepare($deleteQuery);

                if ($deleteStmt) {
                    $deleteStmt->execute([$categoryIdToDelete]);

                    // After successful deletion, redirect or perform other actions
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "Error deleting category.";
                }
            }
        }
    }

}



?>