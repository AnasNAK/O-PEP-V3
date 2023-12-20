<?php
session_start(); 

include '../model/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valid'])) {

    if (isset($_POST['role'])) {
        $selectedRole = $_POST['role']; 

        if (isset($_SESSION['user_email'])) {
            $userEmail = $_SESSION['user_email'];

            $query = "UPDATE user SET roleId = ? WHERE email = ?";
            $stmt = $mysqli->prepare($query);

            if ($stmt) {
                $stmt->bind_param('is', $selectedRole, $userEmail);
                $stmt->execute();
                $stmt->close();

                if ($selectedRole == 1) {
                    header("Location: ../view/index.php"); 
                    exit();
                } elseif ($selectedRole == 2) {
                    header("Location: ../view/dashboard.php"); 
                    exit();
                }
            } else {
                // Handle the case where the prepare statement fails
                echo "Error preparing statement: " . $mysqli->error;
            }
        } else {
            echo "User email not found in session."; 
        }
    } else {
        echo "Role not selected."; 
    }
}
?>
