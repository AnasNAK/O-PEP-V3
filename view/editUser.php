<?php
include 'session.php';

// Check user session and retrieve the role
$userRole = checkUserSession($mysqli);

// Redirect based on user role
if ($userRole === 'blocked') {
    header("Location: block-page.php");
    exit();
}
if ($userRole !== 'superAdmin') {
    header("Location: SingIn.php");
}

// Fetch the list of available roles
$query = "SELECT Idrole, rolename FROM role";
$resultRoles = $mysqli->query($query);
$roles = $resultRoles->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['role']) && isset($_GET['IdUser'])) {
        $newRoleId = $_POST['role'];
        $userId = $_GET['IdUser'];

        // Update the user's role in the database
        $updateQuery = "UPDATE user SET RoleId = ? WHERE IdUser = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param('ii', $newRoleId, $userId);
        $updateStmt->execute();

        // Redirect back to the dashboard or users list
        header("Location: dashboard-s.php");
        exit();
    }
}

// Fetch the user's current role based on IdUser from the URL
if (isset($_GET['IdUser'])) {
    $userId = $_GET['IdUser'];
    $query = "SELECT RoleId FROM user WHERE IdUser = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Store the current role ID for pre-selecting the dropdown option
    $Idrole = $user['RoleId'];
}
?>

<!-- HTML form structure -->
<!DOCTYPE html>
<html lang="en">

<head>
  
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a4fc922de4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/png" href="../public/img/logo-1.png" />
    <link rel="stylesheet" href="./public/css/style.css">
</head>

<body class="bg-purple-700 font-[sitika] text-black">
    <section class="max-w-4xl p-6 mx-auto bg-purple-400 rounded-md shadow-md my-7">
        <h1 class="text-4xl font-bold capitalize">Edit role</h1>
        <form method="POST" class="flex flex-col gap-5">
            <div class="grid grid-cols-1 gap-1 mt-4 sm:grid-cols-2">
                <div>
                    <select name="role" class="w-full p-2 rounded-md bg-white text-black">
                        <option value="">Select role</option>
                        <?php foreach ($roles as $role) : ?>
                            <option value="<?php echo $role['Idrole']; ?>" <?php echo ($role['Idrole'] == $Idrole) ? 'selected' : ''; ?>>
                                <?php echo $role['rolename']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="flex gap-6">
                <button type="submit" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">
                    Save
                </button>
                <a href="dashboard-s.php">
                    <button type="button" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">
                        Cancel
                    </button>
                </a>
            </div>
        </form>
    </section>
</body>

</html>
