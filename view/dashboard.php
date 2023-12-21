<?php

require_once "../model/model.php";

$session = new Session(); 
$plant = new Plant();
$categorie = new Categorie();
$user = new User();


$userRole = $session->checkUserSession();

// Redirect based on user role
if ($userRole === 'blocked') {
    header("Location: ./block-page.php");
    exit();
}
if ($userRole !== 'admin') {
    header("Location: ./SingIn.php");
    exit();
}

$plantCount = $plant->countPlants();
$adminCount = $user->countAdmins();

$plants = $plant->getAllPlants();
$categories = $categorie->getCategories();



if(isset($_POST['deletePlant'])) {
    $plant->setPlantId($_POST['IdPlant']);
    $plant->deletePlant();
}

                                
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCategory']) && isset($_POST['categoryId'])) {
    $categorie->setCategorieId($_POST['categoryId']);
    $categorie->deleteCategory();
}

if (isset($_POST['logout'])) {

    $user->logout();
}


?>


<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a4fc922de4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>

    </title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/png" href="" />
    <link rel="stylesheet" href="./public/css/style.css">
</head>

<body class="bg-purple-400 font-[sitika]">

    <div x-data="setup()" :class="{ 'dark': isDark }">
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased  ">

            <div class="fixed w-full flex items-center  bg-purple-300 justify-between h-14 text-black z-10 gap-9 ">
                <div class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 h-14 bg-purple-300">
                    <!-- <img class="w-7 h-7 md:w-10 md:h-10 mr-2 rounded-md overflow-hidden" src="" /> -->
                    <span class="hidden md:block">ANAS NAKHLI</span>
                </div>
                <div class="flex items-center justify-around h-14 bg-purple-300  ">
                    <ul class="flex justify-between">
                        <li>
                            <div class="block w-px h-6 mx-3 bg-gray-400 dark:bg-gray-700"></div>
                        </li>
                        <li>
                            <form action="" method="POST">
                                <button type="submit" name="logout" class="flex items-center mr-4 hover:text-blue-100">
                                    <span class="inline-flex mr-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                    </span>
                                    Logout
                                </button>
                            </form>

                        </li>


                    </ul>
                </div>
            </div>

            <div
                class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-purple-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
                <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
                    <ul class="flex flex-col py-4 space-y-1">
                        <li class="px-5 hidden md:block">
                            <div class="flex flex-row items-center h-8">
                                <div class="text-sm font-light tracking-wide text-white uppercase">Main</div>
                            </div>
                        </li>
                        <li>
                            <a href="dashboard.php"
                                class="relative flex flex-row items-center h-11 focus:outline-none transition hover:bg-purple-300 hover:text-[#000000] text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-white pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg class="w-5 h-5 " fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">plantes</span>
                            </a>
                            <!-- <a href="dash_article.php"
                                class="relative flex flex-row items-center h-11 focus:outline-none transition hover:bg-purple-300 hover:text-[#000000] text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-white pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M168 80c-13.3 0-24 10.7-24 24V408c0 8.4-1.4 16.5-4.1 24H440c13.3 0 24-10.7 24-24V104c0-13.3-10.7-24-24-24H168zM72 480c-39.8 0-72-32.2-72-72V112C0 98.7 10.7 88 24 88s24 10.7 24 24V408c0 13.3 10.7 24 24 24s24-10.7 24-24V104c0-39.8 32.2-72 72-72H440c39.8 0 72 32.2 72 72V408c0 39.8-32.2 72-72 72H72zM176 136c0-13.3 10.7-24 24-24h96c13.3 0 24 10.7 24 24v80c0 13.3-10.7 24-24 24H200c-13.3 0-24-10.7-24-24V136zm200-24h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Articles</span>
                            </a>



                            <a href="dashboardtheme.php"
                                class="relative flex flex-row items-center h-11 focus:outline-none transition hover:bg-purple-300 hover:text-[#000000] text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-white pr-6">

                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M168 80c-13.3 0-24 10.7-24 24V408c0 8.4-1.4 16.5-4.1 24H440c13.3 0 24-10.7 24-24V104c0-13.3-10.7-24-24-24H168zM72 480c-39.8 0-72-32.2-72-72V112C0 98.7 10.7 88 24 88s24 10.7 24 24V408c0 13.3 10.7 24 24 24s24-10.7 24-24V104c0-39.8 32.2-72 72-72H440c39.8 0 72 32.2 72 72V408c0 39.8-32.2 72-72 72H72zM176 136c0-13.3 10.7-24 24-24h96c13.3 0 24 10.7 24 24v80c0 13.3-10.7 24-24 24H200c-13.3 0-24-10.7-24-24V136zm200-24h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
                                    </svg>
                                </span>



                                <span class="ml-2 text-sm tracking-wide truncate">Themes</span>

                            </a>
                            <a href="dash_tag.php"
                                class="relative flex flex-row items-center h-11 focus:outline-none transition hover:bg-purple-300 hover:text-[#000000] text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-white pr-6">

                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M168 80c-13.3 0-24 10.7-24 24V408c0 8.4-1.4 16.5-4.1 24H440c13.3 0 24-10.7 24-24V104c0-13.3-10.7-24-24-24H168zM72 480c-39.8 0-72-32.2-72-72V112C0 98.7 10.7 88 24 88s24 10.7 24 24V408c0 13.3 10.7 24 24 24s24-10.7 24-24V104c0-39.8 32.2-72 72-72H440c39.8 0 72 32.2 72 72V408c0 39.8-32.2 72-72 72H72zM176 136c0-13.3 10.7-24 24-24h96c13.3 0 24 10.7 24 24v80c0 13.3-10.7 24-24 24H200c-13.3 0-24-10.7-24-24V136zm200-24h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
                                    </svg>
                                </span>

                                <span class="ml-2 text-sm tracking-wide truncate">Tags</span>



                            </a> -->
                        </li>

                    </ul>

                </div>
            </div>
            <!-- ./Sidebar -->

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64">

                <div class="grid grid-cols-1  sm:grid-cols-2 gap-9 lg:grid-cols-2 p-4 lg:gap-32 ">
                    <div
                        class="bg-purple-900 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-purple-300 text-white">
                        <div
                            class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="stroke-current text-black transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl"><?php echo $adminCount; ?></p>
                            <p>Admins</p>
                        </div>
                    </div>
                    <div
                        class="bg-purple-900 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-purple-300 text-white font-medium group">
                        <div
                            class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="stroke-current text-black transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl"><?php echo $plantCount; ?></p>
                            <p>Plantes</p>
                        </div>
                    </div>

                </div>
                <div class="col-span-12 mt-5 max-h-64 overflow-y-auto">
                    <div class="grid gap-2 grid-cols-1 lg:grid-cols-1">
                        <div class="bg-white p-4 shadow-lg rounded-lg ">
                            <div class="flex justify-between ">
                                <h1 class="font-bold text-base">Plantes</h1>
                                <a href="addPlante.php" class="transition duration-300 hover:scale-150">
                                    <i class="bi bi-plus-circle "></i>
                                </a>
                            </div>
                            <div class="mt-4">
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto">
                                        <div class="py-2 align-middle inline-block min-w-full">
                                            <div
                                                class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg bg-white">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                <div class="flex cursor-pointer">
                                                                    <span class="mr-2">Plante img</span>
                                                                </div>
                                                            </th>
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                <div class="flex cursor-pointer">
                                                                    <span class="mr-2">Plante NAME</span>
                                                                </div>
                                                            </th>
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                <div class="flex cursor-pointer">
                                                                    <span class="mr-2">Price</span>
                                                                </div>
                                                            </th>
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                <div class="flex cursor-pointer">
                                                                    <span class="mr-2">ACTION</span>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        <?php foreach ($plants as $plant) : ?>
                                                        <tr>
                                                            <td class="w-9">
                                                                <img src="<?php echo  $plant->getPlantIMG() ?>"
                                                                    alt="Plant Image">
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                <p><?php echo  $plant->getPlantName()  ?></p>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                <div class="flex text-[#685942]">
                                                                    <p><?php echo $plant->getPlantPrice() ?>
                                                                        DH</p>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                <div class="flex space-x-4">
                                                                    <a href="editPlante.php?IdPlant=<?php echo $plant->getPlantId() ?>"
                                                                        class="text-blue-500 hover:text-blue-600">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="w-5 h-5 mr-1" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                        </svg>
                                                                        <p>Edit</p>
                                                                    </a>
                                                                    <form action="" method="POST">
                                                                        <input type="hidden" name="IdPlant"
                                                                            value="<?php echo $plant->getPlantId() ?>">
                                                                        <button type="submit" name="deletePlant"
                                                                            class="text-red-500 hover:text-red-600">

                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="w-5 h-5 mr-1 ml-3" fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                            </svg>
                                                                            <p>Delete</p>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-full ml-14 mt-14 mb-10 md:ml-64">


                <div class="col-span-12 mt-5 max-h-64 overflow-y-auto">
                    <div class="grid gap-2 grid-cols-1 lg:grid-cols-1">
                        <div class="bg-white p-4 shadow-lg rounded-lg ">
                            <div class="flex justify-between position-fixed  ">
                                <h1 class="font-bold text-base">Categorie</h1>
                                <a href="addCategorie.php" class="transition duration-300 hover:scale-150">
                                    <i class="bi bi-plus-circle "></i>
                                </a>
                            </div>
                            <div class="mt-4">
                                <div class="flex flex-col">
                                    <div class="my-2 overflow-x-auto">
                                        <div class="py-2 align-middle inline-block min-w-full">
                                            <div
                                                class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg bg-white">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead>
                                                        <tr>

                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                <div class="flex cursor-pointer">
                                                                    <span class="mr-2">Categorie NAME</span>
                                                                </div>
                                                            </th>
                                                            <th
                                                                class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                                <div class="flex cursor-pointer">
                                                                    <span class="mr-2">ACTION</span>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        <?php foreach ($categories as $category) : ?>
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                <p><?php echo $category->getCategorieName(); ?>
                                                                </p>
                                                            </td>

                                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                                <div class="flex space-x-4">
                                                                    <a href="editCategorie.php?IdCategorie=<?php echo $category->getCategorieId() ?>"
                                                                        class="text-blue-500 hover:text-blue-600">

                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="w-5 h-5 mr-1" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                        </svg>
                                                                        <p>Edit</p>
                                                                    </a>

                                                                    <form action="" method="POST">
                                                                        <input type="hidden" name="categoryId"
                                                                            value="<?php echo $category->getCategorieId() ?>">
                                                                        <button type="submit" name="deleteCategory"
                                                                            class="text-red-500 hover:text-red-600">

                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="w-5 h-5 mr-1 ml-3" fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                            </svg>
                                                                            <p>Delete</p>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    </div>
    </div>

</body>

</html>