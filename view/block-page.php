
<?php
include 'session.php';

// Check user session and retrieve the role
$userRole = checkUserSession($mysqli);

// Redirect based on user role
if ($userRole !== 'blocked') {
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
    <div class="bg-indigo-900 relative overflow-hidden h-screen">
            <img
            src="https://external-preview.redd.it/4MddL-315mp40uH18BgGL2-5b6NIPHcDMBSWuN11ynM.jpg?width=960&crop=smart&auto=webp&s=b98d54a43b3dac555df398588a2c791e0f3076d9"
            class="absolute h-full w-full object-cover" />
            <div class="inset-0 bg-black opacity-25 absolute">
                </div>
            <div class="container mx-auto px-6 md:px-12 relative z-10 flex items-center  xl:py-40">
                    <div class="w-full font-mono flex flex-col items-center relative z-10">
                            <h1 class="font-extrabold text-5xl  text-white leading-tight animate-bounce ">
                      You are all alone here 
                              </h1>
                            <p class="font-extrabold text-4xl my-30 text-white animate-bounce">
                                    Blocked By Super Admin !
                                </p>
                        </div>
                </div>
    </div>

</body>

</html>