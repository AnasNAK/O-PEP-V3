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
    private $count;
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

    public function countAdmins() {
        $countAdminsQuery = "SELECT COUNT(*) AS adminCount FROM user WHERE roleId = 2";
        $countAdminsStmt = $this->db->query($countAdminsQuery);
        $this->count = $countAdminsStmt->fetch(PDO::FETCH_ASSOC)['adminCount'];
        
        return $this->count;
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

    public function getUserIdFromEmail($userEmail)
    {
        $query = "SELECT IdUser FROM user WHERE Email = ?";
        $statement = $this->db->prepare($query);
        $statement->bindParam(1, $userEmail);
        
        if ($statement->execute()) {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['IdUser'];
            }
        }
        return null;
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


    public function addCategory() {
        $query = "INSERT INTO categorie (CategorieName) VALUES (?)";
        $stmt = $this->db->prepare($query);
    
        if ($stmt) {
            $stmt->execute([$this->getCategorieName()]);
            
            header("Location: ./dashboard.php");
            exit();
        } else {
            $this->errorMsg = "Error preparing statement: " . implode(" ", $this->db->errorInfo());
            // Handle the error as needed
        }
    }
    


    public function getCategoryById($categoryId) {
        $query = "SELECT * FROM categorie WHERE IdCategorie = ?";
        $stmt = $this->db->prepare($query);
    
        if ($stmt) {
            $stmt->execute([$categoryId]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($category) {
               
                $this->setCategorieId($category['IdCategorie']);
                $this->setCategorieName($category['CategorieName']);
                return true; 
            } else {
                return false; 
            }
        } else {
            return false; 
        }
    }
    
    public function updateCategory() {
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
        $deleteQuery = "DELETE FROM categorie WHERE IdCategorie = ?";
        $deleteStmt = $this->db->prepare($deleteQuery);
        if ($deleteStmt) {
            $deleteStmt->bindParam(1, $this->getCategorieId(), PDO::PARAM_INT);

            if ($deleteStmt->execute()) {
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error deleting category.";
            }
        } else {
            echo "Delete statement preparation failed.";
        }
    }





    public function getCategories() {
        $query = "SELECT * FROM categorie";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $categoriesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
    
        foreach ($categoriesData as $row) {
            $category = new Categorie();
            $category->setCategorieId($row['IdCategorie']);
            $category->setCategorieName($row['CategorieName']);
    
            $categories[] = $category;
        }
    
        return $categories;
    }
    
}

class Plant {

    private $db;

    private $plantName;
    private $plantId;
    private $plantIMG;
    private $plantPrice;
    private $categoryID;
    private $categoryName;
    private $count;

    public function __construct(){
        $this->db = Database::getInstance()->getConnection();
        }

        public function setPlantName($plantName) {
            $this->plantName = $plantName;
        }
    
        public function getPlantName() {
            return $this->plantName;
        }

        public function setPlantId($plantId) {
            $this->plantId = $plantId;
        }
    
        public function getPlantId() {
            return $this->plantId;
        }
    
        public function setPlantIMG($plantIMG) {
            $this->plantIMG = $plantIMG;
        }
    
        public function getPlantIMG() {
            return $this->plantIMG;
        }
    
        public function setPlantPrice($plantPrice) {
            $this->plantPrice = $plantPrice;
        }
    
        public function getPlantPrice() {
            return $this->plantPrice;
        }
    
        public function setCategoryID($categoryID) {
            $this->categoryID = $categoryID;
        }
    
        public function getCategoryID() {
            return $this->categoryID;
        }
        public function setCategoryName($categoryName) {
            $this->categoryName = $categoryName;
        }
    
        public function getCategoryName() {
            return $this->categoryName;
        }




        
    public function countPlants() {
        $countPlantsQuery = "SELECT COUNT(*) AS plantCount FROM plant";
        $countPlantsStmt = $this->db->query($countPlantsQuery);
        $this->count = $countPlantsStmt->fetch(PDO::FETCH_ASSOC)['plantCount'];
        
        return $this->count;
    }


    public function getAllPlants() {
        $query = "SELECT * FROM Plant";
        $stmt = $this->db->query($query);
        $plantsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $plants = [];
        foreach ($plantsData as $plantData) {
            $plant = new Plant();
            $plant->setPlantId($plantData['IdPlant']);
            $plant->setPlantName($plantData['Name']);
            $plant->setPlantIMG($plantData['image']);
            $plant->setPlantPrice($plantData['price']);
            $plant->setCategoryID($plantData['CategorieId']);
    
            $plants[] = $plant;
        }
    
        return $plants;
    }
    

    public function deletePlant() {
        $plantIdToDelete = $this->getPlantId();

        $deleteQuery = "DELETE FROM Plant WHERE IdPlant = ?";
        $deleteStmt = $this->db->prepare($deleteQuery);

        if ($deleteStmt) {
            $deleteStmt->bindParam(1, $plantIdToDelete, PDO::PARAM_INT);

            if ($deleteStmt->execute()) {
                return true; 
            } else {
                return false;
            }
        } else {
            return false; 
        }
    }

    public function addPlant() {
        // Handle image upload
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); 
        }
        $imageName = $this->getPlantIMG()['name']; 
        $imageTempName = $this->getPlantIMG()['tmp_name']; 
        
        // Check if a file was uploaded
        if (!empty($imageName)) {
            $imagePath = $uploadDir . uniqid() . '_' . $imageName;
    
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($imageTempName, $imagePath)) {
                $insertQuery = "INSERT INTO Plant (Name, price, CategorieId, image) VALUES (?, ?, ?, ?)";
                $insertStmt = $this->db->prepare($insertQuery);
                $insertStmt->bindParam(1, $this->getPlantName()); 
                $insertStmt->bindParam(2, $this->getPlantPrice()); 
                $insertStmt->bindParam(3, $this->getCategoryID()); 
                $insertStmt->bindParam(4, $imagePath);
    
                if ($insertStmt->execute()) {
                    // Redirect or display success message
                    header("Location: dashboard.php");
                    exit();
                }
            }
        }
    }

    public function getPlantDetailsForEditing($plantId) {
        $query = "SELECT * FROM `plant` WHERE IdPlant = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $plantId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $plant = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($plant) {
                $this->setPlantId($plant['IdPlant']);
                $this->setPlantName($plant['Name']);
                $this->setPlantPrice($plant['price']);
                $this->setCategoryID($plant['CategorieId']);
                $this->setPlantIMG($plant['image']);

                return true;
            }
        }

        return false;
    }

    public function updatePlant() {
    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

   
    $plantId = $this->getPlantId();
    $updatedName = $this->getPlantName();
    $updatedPrice = $this->getPlantPrice();
    $updatedCategoryId = $this->getCategoryID();
    $uploadedImage = $this->getPlantIMG();

    if (!empty($uploadedImage['name'])) {
        $imageName = $uploadedImage['name'];
        $imageTempName = $uploadedImage['tmp_name'];
        $imagePath = $uploadDir . uniqid() . '_' . $imageName;

        if (move_uploaded_file($imageTempName, $imagePath)) {
            $updateQuery = "UPDATE plant SET `Name` = ?, price = ?, CategorieId = ?, `image` = ? WHERE IdPlant = ?";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindParam(1, $updatedName);
            $updateStmt->bindParam(2, $updatedPrice);
            $updateStmt->bindParam(3, $updatedCategoryId);
            $updateStmt->bindParam(4, $imagePath);
            $updateStmt->bindParam(5, $plantId);

            if ($updateStmt->execute()) {
                return true; 
            } else {
                return false; 
            }
        } else {
            return false; 
        }
    } else {
        $updateQuery = "UPDATE plant SET `Name` = ?, price = ?, CategorieId = ? WHERE IdPlant = ?";
        $updateStmt = $this->db->prepare($updateQuery);
        $updateStmt->bindParam(1, $updatedName);
        $updateStmt->bindParam(2, $updatedPrice);
        $updateStmt->bindParam(3, $updatedCategoryId);
        $updateStmt->bindParam(4, $plantId);

        if ($updateStmt->execute()) {
            return true; 
        } else {
            return false;
        }
    }
}
public function fetchPlantsByCategory($selectedCategory) {
    $plants = [];

    $query = "SELECT * FROM plant";

    if ($selectedCategory !== 'all') {
        $query .= " WHERE CategorieId = ?";
    }

    $stmt = $this->db->prepare($query);

    if ($selectedCategory !== 'all') {
        $stmt->bindParam(1, $selectedCategory, PDO::PARAM_INT);
    }

    $stmt->execute();
    $plantsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($plantsData as $plantData) {
        $plant = new Plant();
        $plant->setPlantId($plantData['IdPlant']);
        $plant->setPlantName($plantData['Name']);
        $plant->setPlantIMG($plantData['image']);
        $plant->setPlantPrice($plantData['price']);
        $plant->setCategoryID($plantData['CategorieId']);

        $plants[] = $plant;
    }

    return $plants;
}

public function fetchPlantsByName($plantName) {
    $plants = [];

    $query = "SELECT * FROM plant";

    if (!empty($plantName)) {
        $query .= " WHERE Name LIKE ?";
    }

    $stmt = $this->db->prepare($query);

    if (!empty($plantName)) {
        $plantNameParam = "%$plantName%";
        $stmt->bindParam(1, $plantNameParam, PDO::PARAM_STR);
    }

    $stmt->execute();
    $plantsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($plantsData as $plantData) {
        $plant = new Plant();
        $plant->setPlantId($plantData['IdPlant']);
        $plant->setPlantName($plantData['Name']);
        $plant->setPlantIMG($plantData['image']);
        $plant->setPlantPrice($plantData['price']);
        $plant->setCategoryID($plantData['CategorieId']);

        $plants[] = $plant;
    }

    return $plants;
}



}
    
class Cart {
private $db;

private $userID;

private $plantID;


public function set_userID ($userid) {
    $this->userID = $userid;
}
public function get_userID () {
    return $this->userID;
}

public function set_plantID ($plantID) {
    $this->plantID = $plantID;
}

public function get_plantID () {
    return $this->plantID;
}
    public function __construct(){
        $this->db = Database::getInstance()->getConnection();
    }

    public function addToCart() {

        $plantId = $this->get_plantID();
        $userId = $this->get_userID();

        $query = "INSERT INTO cart (PlantId, UserId) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        
        if ($stmt) {
            $stmt->bindParam(1, $plantId, PDO::PARAM_INT);
            $stmt->bindParam(2, $userId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
        }
        
        return false; 
    }

}

public function getCartCount($userId) {
    $countQuery = "SELECT COUNT(*) AS cartCount FROM cart WHERE UserId = ?";
    $countStatement = $this->db->prepare($countQuery);

    if ($countStatement) {
        $countStatement->bindParam(1, $userId, PDO::PARAM_INT);
        $countStatement->execute();
        $result = $countStatement->fetch(PDO::FETCH_ASSOC);
        
        return $result['cartCount'] ?? 0;
    }
    
    return 0; 
}

public function calculateTotalPrice($userId) {
    $query = "
        SELECT SUM(plant.price) AS total_price
        FROM cart
        JOIN plant ON cart.PlantId = plant.IdPlant
        WHERE cart.UserId = :userId";
    
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $totalPrice = $stmt->fetch(PDO::FETCH_ASSOC)['total_price'];

    return $totalPrice;
}


public function fetchCartItems($userId) {
    $query = "
        SELECT plant.IdPlant AS plant_id, plant.Name AS plant_name, plant.price AS plant_price, plant.image AS plant_image,cart.IdCart
        FROM cart
        JOIN plant ON cart.PlantId = plant.IdPlant
        WHERE cart.UserId = :userId";

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $cartItems;
}

public function deletePlantFromCart($plantId) {
    $deleteQuery = "DELETE FROM cart WHERE IdCart = :IdCart";
    $deleteStmt = $this->db->prepare($deleteQuery);
    $deleteStmt->bindParam(':IdCart', $plantId, PDO::PARAM_INT);

    if ($deleteStmt->execute()) {
        header("Location: ./cart.php");
        exit();
    } else {
        echo "Error deleting plant.";
    }
}

public function checkout($userId) {

    $insertCommandQuery = "INSERT INTO command (UserId, PlantId, Price) VALUES (?, ?, ?)";
    $insertCommandStmt = $this->db->prepare($insertCommandQuery);

    // Retrieve cart items again to get plant IDs and insert each item into the commands table
    $stmt = $this->db->prepare("SELECT c.PlantId as plantId, p.price as totalprice FROM cart as c 
    join plant as p on c.PlantId = p.IdPlant
    where c.UserId  = ?");
    $stmt->execute([$userId]);
    $plantIds = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($plantIds as $plantId) {
        $insertCommandStmt->execute([$userId, $plantId['plantId'], $plantId['totalprice']]);
    }

    // Delete cart items after successful checkout
    $deleteCartQuery = "DELETE FROM cart WHERE UserId = ?";
    $deleteCartStmt = $this->db->prepare($deleteCartQuery);
    $deleteCartStmt->execute([$userId]);

    // Redirect after successful checkout
    header("Location: success.php");
    exit();
}
}








?>