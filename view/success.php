<?php
include 'session.php';

// Check user session and retrieve the role
$userRole = checkUserSession($mysqli);

// Redirect based on user role
if ($userRole === 'blocked') {
    header("Location: block-page.php");
    exit();
}
if ($userRole !== 'client') {
    header("Location: SingIn.php");
}


?>



<body>


</body>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../view/assets/css/style.css">
    <!-- <link rel="stylesheet" href="https://cdn.tailgrids.com/tailgrids-fallback.css" /> -->
    <title>O'PEP</title>
</head>

<body>

    <div class="container m-auto px-6 py-40 bg-purple-100">
        <div
            class="flex flex-col md:flex-row items-center justify-between relative w-100 h-auto md:h-64 bg-purple-200 shadow-2xl rounded-lg p-8">
            <div class="w-8/12 text-2xl">
                <img alt="quote" class="float-left mr-1 w-[2rem]"
                    src="data:image/png;base64,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">
                <span class="flex">Your command has been added successfully!</span>
            </div>
            <a href="./">
                <div
                    class="relative shadow-md font-bold my-5 py-2 px-4 text-white cursor-pointer bg-purple-800 hover:bg-purple-500 duration-500 rounded text-lg text-center w-48">
                    <span
                        class="absolute h-3 w-3 right-0 top-0 animate-ping inline-flex rounded-full h-3 w-3 bg-white">
                    </span>
                    < go back 
                </div>
            </a>
        </div>
    </div>

</body>

</html>