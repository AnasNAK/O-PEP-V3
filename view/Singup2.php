<?php

require_once '../model/model.php';
$user = new User();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valid'])) {
    if (isset($_POST['role']) && isset($_SESSION['user_email'])) {
        $selectedRole = $_POST['role'];
        $userEmail = $_SESSION['user_email'];

        $user->updateUserRole($selectedRole, $userEmail);
    } else {
        echo "Role not selected or user email not found in session.";
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>O-PEP</title>
</head>

<body>


    <div class="h-screen md:flex">
        <div
            class="relative overflow-hidden md:flex w-full bg-gradient-to-tr from-blue-800 to-purple-700 i justify-around items-center hidden">
            <div class="flex flex-col gap-4 justify-center ">
                <h1 class="text-white text-center font-bold text-4xl font-sans">O'PEP</h1>
                <p class="text-white text-xl mt-1 ">Choose Your Role On This Platform</p>
                <form action="" method="POST" class="flex flex-col items-center">
                    <select name="role" class="w-full p-2 rounded-md bg-white text-black">
                        <option value="1">Client</option>
                        <option value="2">Admin</option>
                    </select>
                    <input type="submit" value="valid" name="valid"
                        class="w-3/4 py-2 mt-3 rounded-md bg-[#E9D8FF] text-black  font-bold cursor-pointer hover:bg-[#BA84FF] hover:text-white transition duration-300">
                </form>
            </div>
            <div class="absolute -bottom-32 -left-40 w-80 h-80 border-4 rounded-full border-opacity-30 border-t-8">
            </div>
            <div class="absolute -bottom-40 -left-20 w-80 h-80 border-4 rounded-full border-opacity-30 border-t-8">
            </div>
            <div class="absolute -top-40 -right-0 w-80 h-80 border-4 rounded-full border-opacity-30 border-t-8"></div>
            <div class="absolute -top-20 -right-20 w-80 h-80 border-4 rounded-full border-opacity-30 border-t-8"></div>
        </div>

    </div>
</body>

</html>