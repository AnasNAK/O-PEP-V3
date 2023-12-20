<?php 
include '../model/config.php';

session_start();

$email = $_SESSION['user_email'];
$query = "select * from User where email = '$email'";
$stmt = mysqli_query($mysqli,$query);
$result = mysqli_fetch_assoc($stmt);

$idsession = $result['IdUser'];


if($_SERVER['REQUEST_METHOD'] == 'POST')
$idArticle = $_POST['id_article'];

$query = "SELECT a.* FROM `article` AS a  WHERE a.idArticle = $idArticle  ";

$stmt = mysqli_query($mysqli, $query);
$result1 = mysqli_fetch_assoc($stmt);

$userArticle = $result1['UserId'];
// var_dump($result1);


$query2 = "select FirstName from user where idUser = '$userArticle'";
$stmt2 = mysqli_query($mysqli, $query2);
$res = mysqli_fetch_assoc($stmt2);
$nameUser = $res['FirstName'];



$queryCount = "select count(commentId) as countcmnt from comment_art c where c.ArticleId = '$idArticle'
GROUP by (commentId)";
$stmt = mysqli_query($mysqli, $queryCount);
$count = mysqli_fetch_assoc($stmt);


?>




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

    <header class="header sticky top-0 bg-white z-10 shadow-md flex items-center justify-between px-8 py-02">

        <h1 class="w-3/12">
            <a href="./">
                <img class="w-[20%]" src="../view//assets//images//Logo.png" alt="">
            </a>
        </h1>


        <nav class="nav font-semibold text-lg">
            <ul class="flex items-center">
                <li
                    class="p-4 border-b-2 border-purple-700  border-opacity-0 hover:border-opacity-100 hover:text-purple-700  duration-200 cursor-pointer active">
                    <a href="index.php">Home</a>
                </li>
                <li
                    class="p-4 border-b-2 border-purple-700  border-opacity-0 hover:border-opacity-100 hover:text-purple-700  duration-200 cursor-pointer">
                    <a href="Plants.php">Plants</a>
                </li>

                <li
                    class="p-4 border-b-2 border-purple-700  border-opacity-0 hover:border-opacity-100 hover:text-purple-700  duration-200 cursor-pointer">
                    <a href="Cart.php">Cart</a>
                </li>
                <li
                    class="p-4 border-b-2 border-purple-700  border-opacity-0 hover:border-opacity-100 hover:text-purple-700  duration-200 cursor-pointer">
                    <a href="blog.php">Blog</a>
                </li>

            </ul>
        </nav>
    </header>


    <!-- Articles -->

    <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-whiteantialiased">
        <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
            <article
                class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                            <img class="mr-4 w-16 h-16 rounded-full" src="image/user (1).png" alt="Jese Leos">
                            <div>
                                <h2 href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-black">
                                    <?php echo $nameUser ?></h2>
                            </div>
                        </div>
                    </address>
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-black lg:mb-6 lg:text-4xl">
                        <?php echo $result1['ArticleName'] ?></h1>
                </header>

                <div>
                    <img src="<?php echo $result1['ArticleImg'] ?>" class="bg-cover w-full h-[30%]">
                    <p class="mt-5 text-xl"> <span class="font-bold text-2xl">Description:</span>
                        <?php echo $result1['ArticleDes'] ?>
                    </p>
                </div>

                <!-- commands  -->
                <section class="not-format">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 mt-10 ">Discussion ( <?php if(!empty($count)){
                        echo $count['countcmnt'] ;
                            }else{
                                echo '0';
                            }; ?> )</h2>
                    </div>


                    <article class="p-6 mb-6 text-base bg-gray-200 rounded-lg relative">
                        <footer class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <p
                                    class="inline-flex items-center mr-3 font-semibold text-sm text-gray-900 dark:text-black">
                                    <img class="mr-2 w-6 h-6 rounded-full" src="image/user (1).png"
                                        alt="Michael Gough">Michael Gough</p>
                            </div>
                            <!-- Dropdown menu -->
                        </footer>
                        <p>Very straight-to-point article. Really worth time reading. Thank you! But tools are just the
                            instruments for the UX designers. The knowledge of the design tools is as important as the
                            creation of the design strategy.</p>
                        <div class="flex items-center mt-4 space-x-4 relative">
                            <!-- Like and Dislike buttons with simple JavaScript -->
                            <button onclick="like()"
                                class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-500 focus:outline-none">
                                <img src="image/like.png" alt="" class="w-5 h-5">
                            </button>
                            <button onclick="dislike()"
                                class="text-sm text-gray-700 dark:text-gray-300 hover:text-red-500 focus:outline-none">
                                <img src="image/dislike.png" alt="" class="w-5 h-5">
                            </button>


                            <!-- Edit and Delete buttons -->
                            <div class="">
                                <button onclick="edit()"
                                    class="text-sm text-green-500 hover:text-green-700 focus:outline-none absolute   absolute right-[60px] ">
                                    Edit
                                </button>
                                <button onclick="deleteArticle()"
                                    class="text-sm text-red-500 hover:text-red-700 focus:outline-none absolute right-0">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </article>

                    <script>
                        function like() {
                            alert("Liked!");
                        }

                        function dislike() {
                            alert("Disliked!");
                        }

                        function edit() {
                            alert("Edit clicked!");
                        }

                        function deleteArticle() {
                            alert("Delete clicked!");
                        }
                    </script>



                    <form>

                        <div class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-200">
                            <div class="flex items-center">
                                <p
                                    class="inline-flex items-center mr-3 font-semibold text-sm text-gray-900 dark:text-black mr-6">
                                    <img class="mr-2 w-6 h-6 rounded-full" src="image/user (1).png"
                                        alt="Michael Gough"><?php echo $result['FirstName']  ?></p>
                            </div>
                            <form action=""> <textarea id="message" rows="4"
                                    class="block p-2.5 w-full text-sm text-black bg-gray-100 rounded-lg border border-gray-300"
                                    placeholder="Write your comment here..."></textarea>
                                <button type="submit"
                                    class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                                    <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path
                                            d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                                    </svg>
                                    <span class="sr-only">Send message</span>
                                </button>
                            </form>

                        </div>
                    </form>




                </section>
            </article>
        </div>
    </main>

    <!-- 
Related articles -->
    <aside aria-label="Related articles" class="py-8 lg:py-24 bg-white">
        <div class="px-4 mx-auto max-w-screen-xl">
            <h2 class="mb-8 text-2xl font-bold text-black dark:text-black">Related articles</h2>
            <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4">
                <article class="max-w-xs">
                    <a href="#">
                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-1.png"
                            class="mb-5 rounded-lg" alt="Image 1">
                    </a>
                    <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                        <a href="#">Our first office</a>
                    </h2>
                    <p class="mb-4 text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many
                        changes! After months of preparation.</p>
                    <a href="#"
                        class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                        Read in 2 minutes
                    </a>
                </article>
                <article class="max-w-xs">
                    <a href="#">
                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-2.png"
                            class="mb-5 rounded-lg" alt="Image 2">
                    </a>
                    <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                        <a href="#">Enterprise design tips</a>
                    </h2>
                    <p class="mb-4  text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many
                        changes! After months of preparation.</p>
                    <a href="#"
                        class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                        Read in 12 minutes
                    </a>
                </article>
                <article class="max-w-xs">
                    <a href="#">
                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-3.png"
                            class="mb-5 rounded-lg" alt="Image 3">
                    </a>
                    <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                        <a href="#">We partnered with Google</a>
                    </h2>
                    <p class="mb-4  text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many
                        changes! After months of preparation.</p>
                    <a href="#"
                        class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                        Read in 8 minutes
                    </a>
                </article>
                <article class="max-w-xs">
                    <a href="#">
                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-4.png"
                            class="mb-5 rounded-lg" alt="Image 4">
                    </a>
                    <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                        <a href="#">Our first project with React</a>
                    </h2>
                    <p class="mb-4  text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many
                        changes! After months of preparation.</p>
                    <a href="#"
                        class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                        Read in 4 minutes
                    </a>
                </article>
            </div>
        </div>
    </aside>

    <footer class="bg-gray-100">
        <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8">
            <nav class="flex flex-wrap justify-center -mx-5 -my-2">
                <ul class="flex items-center">
                    <li
                        class="p-4 border-b-2 border-purple-700  border-opacity-0 hover:border-opacity-100 hover:text-purple-700  duration-200 cursor-pointer active">
                        <a href="index.php">Home</a>
                    </li>
                    <li
                        class="p-4 border-b-2 border-purple-700  border-opacity-0 hover:border-opacity-100 hover:text-purple-700  duration-200 cursor-pointer">
                        <a href="Plants.php">Plants</a>
                    </li>
                    <li
                        class="p-4 border-b-2 border-purple-700  border-opacity-0 hover:border-opacity-100 hover:text-purple-700  duration-200 cursor-pointer">
                        <a href="Cart.php">Cart</a>
                    </li>

                </ul>

            </nav>
            <div class="flex justify-center mt-8 space-x-6">
                <a href="#" class="text-gray-400 hover:text-purple-700">
                    <span class="sr-only">Facebook</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-purple-700">
                    <span class="sr-only">Instagram</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-purple-700">
                    <span class="sr-only">Twitter</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                        </path>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-purple-700">
                    <span class="sr-only">GitHub</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-purple-700">
                    <span class="sr-only">Dribbble</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
            <p class="mt-8 text-base leading-6 text-center text-gray-400">
                © 2023 ANAS_NAK . All rights reserved.
            </p>
        </div>
    </footer>