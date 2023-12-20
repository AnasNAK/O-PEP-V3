<?php
include '../model/model.php';


class Sessiona {
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

?>