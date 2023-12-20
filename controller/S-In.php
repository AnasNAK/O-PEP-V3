<?php
include '../view/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists in the database and validate credentials
    $query = "SELECT IdUser, RoleId, `Password` FROM User WHERE Email = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $storedPassword = $user['Password'];

            // Verify the entered password against the stored hashed password
            if (password_verify($password, $storedPassword)) {
                session_start();
                $_SESSION['user_email'] = $email;

                // Redirect based on the user's role
                if ($user['RoleId'] === 1) {
                    header("Location: ../view/index.php");
                } elseif ($user['RoleId'] === 2) {
                    header("Location: ../view/dashboard.php");
                } elseif ($user['RoleId'] === 3) {
                    header("Location: ../view/dashboard-s.php");
                } elseif ($user['RoleId'] === 4) {
                    header("Location: ../view/block-page.php");
                } else {
                    header("Location: ../view/SingIn.php");
                }
            } else {
                echo "Entered password does not match. Please try again.";
            }
        } else {
            echo "Invalid credentials. Please try again.";
        }

        $stmt->close();
    } else {
        // Handle the case where the prepare statement fails
        echo "Error preparing statement: " . $mysqli->error;
    }
}
?>
