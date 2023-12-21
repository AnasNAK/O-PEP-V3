<?php

require_once "../model/model.php";

$session = new Session(); 
$user = new User();


$userRole = $session->checkUserSession();

// Redirect based on user role
if ($userRole === 'blocked') {
    header("Location: ./block-page.php");
    exit();
}
if ($userRole !== 'client') {
    header("Location: ./SingIn.php");
    exit();
}

if (isset($_POST['logout'])) {

    $user->logout();
}
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
                <!-- <li
                    class="p-4 border-b-2 border-purple-700  border-opacity-0 hover:border-opacity-100 hover:text-purple-700  duration-200 cursor-pointer">
                    <a href="blog.php">Blog</a>
                </li> -->

            </ul>
        </nav>


        <div class="w-3/12 flex justify-end gap-5">
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
            <a href="Cart.php">
                <svg class="h-8 p-1 hover:text-purple-700 duration-200" aria-hidden="true" focusable="false"
                    data-prefix="far" data-icon="shopping-cart" role="img" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 576 512" class="svg-inline--fa fa-shopping-cart fa-w-18 fa-7x">
                    <path fill="currentColor"
                        d="M551.991 64H144.28l-8.726-44.608C133.35 8.128 123.478 0 112 0H12C5.373 0 0 5.373 0 12v24c0 6.627 5.373 12 12 12h80.24l69.594 355.701C150.796 415.201 144 430.802 144 448c0 35.346 28.654 64 64 64s64-28.654 64-64a63.681 63.681 0 0 0-8.583-32h145.167a63.681 63.681 0 0 0-8.583 32c0 35.346 28.654 64 64 64 35.346 0 64-28.654 64-64 0-18.136-7.556-34.496-19.676-46.142l1.035-4.757c3.254-14.96-8.142-29.101-23.452-29.101H203.76l-9.39-48h312.405c11.29 0 21.054-7.869 23.452-18.902l45.216-208C578.695 78.139 567.299 64 551.991 64zM208 472c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm256 0c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm23.438-200H184.98l-31.31-160h368.548l-34.78 160z"
                        class=""></path>
                </svg>
            </a>



        </div>
    </header>
    <section>
        <div class="bg-[#1A0B2D] text-white pt-[8rem] ">
            <div class="container mx-auto flex flex-col md:flex-row justify-between">
                <div class="flex flex-col w-full lg:w-1/3 justify-center items-start p-8">
                    <h1 class="text-3xl md:text-5xl p-2 text-purple-300 tracking-loose">TechFest</h1>
                    <h2 class="text-3xl md:text-5xl leading-relaxed md:leading-snug mb-2">Space : The Timeless Infinity
                    </h2>
                    <p class="text-sm md:text-base text-gray-50 mb-4">Explore your favourite events and
                        register now to showcase your talent and win exciting prizes.</p>
                    <a href="Plants.php"
                        class="bg-transparent hover:bg-purple-300 text-purple-300 hover:text-black rounded shadow hover:shadow-lg py-2 px-4 border border-purple-300 hover:border-transparent duration-500">
                        Explore Now</a>
                </div>

                <div class="p-8 mt-12 mb-6 md:mb-0 md:mt-0 ml-0 md:ml-12 lg:w-2/3  justify-center">
                    <div class="h-[50%] w-4/4 flex justify-between gap-[4rem]">
                        <div>
                            <img class=" w-[80%] rounded rounded-full rotate-[150deg] inline-block mt-24 md:mt-11 p-8 md:p-0 w-25 "
                                src="../view/assets/images/My World of Colours.jfif">
                        </div>
                        <div>
                            <img class=" w-[100%] rounded rounded-full rotate-[150deg] inline-block mt-24 md:mt-0 p-8 md:p-0 w-25"
                                src="../view/assets/images/Découvrir les îles de Guadeloupe en catamaran.jfif">
                        </div>
                        <div>
                            <img class="w-[80%]  rounded rounded-full rotate-[150deg] inline-block mt-24 md:mt-11 p-8 md:p-0 w-25"
                                src="../view/assets/images/25e8355d-e4e6-4460-a1d9-b4d87ad22f69.jfif">
                        </div>
                    </div>

                </div>
            </div>
    </section>






    <section class="pt-20 lg:pt-[120px] pb-10 lg:pb-20">
        <div class="container">
            <div class="flex flex-wrap justify-center -mx-4">
                <div class="w-full px-4">
                    <div class="text-center mx-auto mb-[60px] lg:mb-20 max-w-[510px]">

                        <h2 class="
                  font-bold
                  text-3xl
                  sm:text-4xl
                  md:text-[40px]
                  text-dark
                  mb-4
                  ">
                            Our Recent News
                        </h2>
                        <p class="text-base text-body-color">
                            There are many variations of passages of Lorem Ipsum available
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/2 lg:w-1/3 px-4">
                    <div class="max-w-[370px] mx-auto mb-10">
                        <div class="rounded overflow-hidden mb-8">
                            <img src="../view/assets/images/4 Powerful Air Purifying Plants to Clean the Air in Your Home.jfif"
                                alt="image" class="w-[8rem] h-[11rem] m-auto" />
                        </div>
                        <div>
                            <span class="
                     bg-purple-700
                     rounded
                     inline-block
                     text-center
                     py-1
                     px-4
                     text-xs
                     leading-loose
                     font-semibold
                     text-white
                     mb-5
                     ">
                                Dec 22, 2023
                            </span>
                            <h3>
                                <a href="javascript:void(0)" class="
                        font-semibold
                        text-xl
                        sm:text-2xl
                        lg:text-xl
                        xl:text-2xl
                        mb-4
                        inline-block
                        text-dark
                        hover:text-primary
                        ">
                                    Meet AutoManage, the best AI management tools
                                </a>
                            </h3>
                            <p class="text-base text-body-color">
                                Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 px-4">
                    <div class="max-w-[370px] mx-auto mb-10">
                        <div class="rounded overflow-hidden mb-8">
                            <img src="../view/assets/images/5 Hard-to-Kill Houseplants for Apartments with Low Light.jfif"
                                alt="image" class="w-[8rem] h-[11rem] m-auto" />
                        </div>
                        <div>
                            <span class="
                    bg-purple-700
                     rounded
                     inline-block
                     text-center
                     py-1
                     px-4
                     text-xs
                     leading-loose
                     font-semibold
                     text-white
                     mb-5
                     ">
                                Mar 15, 2023
                            </span>
                            <h3>
                                <a href="javascript:void(0)" class="
                        font-semibold
                        text-xl
                        sm:text-2xl
                        lg:text-xl
                        xl:text-2xl
                        mb-4
                        inline-block
                        text-dark
                        hover:text-primary
                        ">
                                    How to earn more money as a wellness coach
                                </a>
                            </h3>
                            <p class="text-base text-body-color">
                                Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 px-4">
                    <div class="max-w-[370px] mx-auto mb-10">
                        <div class="rounded overflow-hidden mb-8">
                            <img src="../view/assets/images/Amber Plant Pot - Light Grey - 20 x 19cm.jfif" alt="image"
                                class="w-[8rem] h-[11rem] m-auto" />
                        </div>
                        <div>
                            <span class="
                    bg-purple-700
                     rounded
                     inline-block
                     text-center
                     py-1
                     px-4
                     text-xs
                     leading-loose
                     font-semibold
                     text-white
                     mb-5
                     ">
                                Jan 05, 2023
                            </span>
                            <h3>
                                <a href="javascript:void(0)" class="
                        font-semibold
                        text-xl
                        sm:text-2xl
                        lg:text-xl
                        xl:text-2xl
                        mb-4
                        inline-block
                        text-dark
                        hover:text-primary
                        ">
                                    The no-fuss guide to upselling and cross selling
                                </a>
                            </h3>
                            <p class="text-base text-body-color">
                                Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-white dark:bg-gray-800">
        <div class="relative px-4 py-6 overflow-hidden sm:px-6 sm:py-8 lg:p-12 xl:p-16">
            <h2 class="text-2xl font-semibold font-display text-black dark:text-white sm:text-3xl">
                We&#x27;ve got more coming...
            </h2>
            <p class="mt-2 max-w-xl text-base text-gray-400">
                Want to hear from us Sign up for our newsletter and we&#x27;ll email you
                every time we release a new batch.
            </p>
            <form>
                <div class="mt-6 sm:flex jusitfy-start">
                    <form
                        class="flex  justify-center w-3/4 max-w-sm space-y-3 md:flex-row md:w-full md:space-x-4 md:space-y-0">
                        <div class=" relative ">
                            <input type="text" id="&quot;form-subscribe-Subscribe"
                                class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Email" />
                        </div>
                        <button
                            class="flex-shrink-0 px-4 py-2 text-base font-semibold text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-purple-200"
                            type="submit">
                            Subscribe
                        </button>
                    </form>
                </div>
            </form>
            <div class="absolute inset-y-0 right-0 hidden lg:block lg:left-2/3 xl:left-1/2">
                <picture>

                    <img class="object-cover w-1/2 mx-auto maw-w-44"
                        src="../view/assets/images/9724f303-4b3f-4de4-87da-b6fd986724be.jfif" alt="shopping item" />
                </picture>
            </div>
        </div>
    </section>


    <footer class="bg-white">
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
</body>

</html>