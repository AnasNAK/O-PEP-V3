<?php
    include '../model/config.php';
    $result = $mysqli->query("SELECT * FROM theme");
    $themes = $result->fetch_all(MYSQLI_ASSOC);
    // echo'<pre>';
    // var_dump($themes);die();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        for ($i = 0; $i < count($_POST['theme']); $i++) {
            $theme = $_POST['theme'][$i];
            $nameTag = $_POST['nameTag'][$i];
            $query = "INSERT INTO `tag`(`TagName`, `Themeid`) VALUES ('$nameTag',$theme)";
            $stmt = $mysqli->prepare($query);
                $stmt->execute();
                $stmt->close();
               
                // header("Location: ../view/Singup2.php");
           
        }
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

<body class="bg-purple-400 ">
    <main>
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased  ">



            <!-- navbar -->
            <div class="fixed w-full flex items-center  bg-purple-300 justify-between h-14 text-black z-10 gap-9 ">
                <div class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 h-14 bg-purple-300">
                    <span class="hidden md:block">ANAS NAKHLI</span>
                </div>
                <div class="flex items-center justify-around h-14 bg-purple-300  ">
                    <ul class="flex justify-between">
                        <li>
                            <div class="block w-px h-6 mx-3 bg-gray-400 dark:bg-gray-700"></div>
                        </li>
                        <li>
                            <a href="../controller/logout.php" class="flex items-center mr-4 hover:text-blue-100">
                                <span class="inline-flex mr-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </span>
                                Logout
                            </a>
                        </li>


                    </ul>
                </div>
            </div>

            <!-- tag form  -->
            <section class="p-4 flex flex-col justify-center min-h-screen max-w-md mx-auto">
                <div class="p-6 bg-sky-100 rounded">
                    <div class="flex items-center justify-center font-black m-3 mb-12">
                        <h1 class="tracking-wide text-3xl text-gray-900">Add tag</h1>
                    </div>
                    <form action="./dash_tag.php" method="POST" class="flex flex-col justify-center">
                        <div id="addTagDiv" class="flex flex-col gap-3"></div> <!--div-->
                        <button type="button" class="mb-4 mt-5 px-4 py-1.5 rounded-md shadow-lg bg-gradient-to-r from-pink-600 to-red-600 font-medium text-gray-100 block transition duration-300" onclick="removeAll()">Remove All Forms</button>

                        <button class="mb-4 px-4 py-1.5 rounded-md shadow-lg bg-gradient-to-r from-pink-600 to-red-600 font-medium text-gray-100 block transition duration-300" id="newTag" type="button">Add New Form Tag</button>
                        <input type="submit" class="px-4 py-1.5 rounded-md shadow-lg bg-gradient-to-r from-pink-600 to-red-600 font-medium text-gray-100 block transition duration-300" value="Save Tags">
                    </form>
                </div>
            </section>

            <!-- slider  -->
            <div class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-purple-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
                <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
                    <ul class="flex flex-col py-4 space-y-1">
                        <li class="px-5 hidden md:block">
                            <div class="flex flex-row items-center h-8">
                                <div class="text-sm font-light tracking-wide text-white uppercase">Main</div>
                            </div>
                        </li>
                        <li>
                            <a href="dashboard.php" class="relative flex flex-row items-center h-11 focus:outline-none transition hover:bg-purple-300 hover:text-[#000000] text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-white pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg class="w-5 h-5 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">plantes</span>
                            </a>
                            <a href="dash_article.php" class="relative flex flex-row items-center h-11 focus:outline-none transition hover:bg-purple-300 hover:text-[#000000] text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-white pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                        <path d="M168 80c-13.3 0-24 10.7-24 24V408c0 8.4-1.4 16.5-4.1 24H440c13.3 0 24-10.7 24-24V104c0-13.3-10.7-24-24-24H168zM72 480c-39.8 0-72-32.2-72-72V112C0 98.7 10.7 88 24 88s24 10.7 24 24V408c0 13.3 10.7 24 24 24s24-10.7 24-24V104c0-39.8 32.2-72 72-72H440c39.8 0 72 32.2 72 72V408c0 39.8-32.2 72-72 72H72zM176 136c0-13.3 10.7-24 24-24h96c13.3 0 24 10.7 24 24v80c0 13.3-10.7 24-24 24H200c-13.3 0-24-10.7-24-24V136zm200-24h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Articles</span>
                            </a>
                            <a href="dash_tag.php" class="relative flex flex-row items-center h-11 focus:outline-none transition hover:bg-purple-300 hover:text-[#000000] text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-white pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                        <path d="M168 80c-13.3 0-24 10.7-24 24V408c0 8.4-1.4 16.5-4.1 24H440c13.3 0 24-10.7 24-24V104c0-13.3-10.7-24-24-24H168zM72 480c-39.8 0-72-32.2-72-72V112C0 98.7 10.7 88 24 88s24 10.7 24 24V408c0 13.3 10.7 24 24 24s24-10.7 24-24V104c0-39.8 32.2-72 72-72H440c39.8 0 72 32.2 72 72V408c0 39.8-32.2 72-72 72H72zM176 136c0-13.3 10.7-24 24-24h96c13.3 0 24 10.7 24 24v80c0 13.3-10.7 24-24 24H200c-13.3 0-24-10.7-24-24V136zm200-24h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Tags</span>
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
        </div>
    <script>
        const addTagDiv=document.getElementById('addTagDiv') //parent div
        const newTag=document.getElementById('newTag') // btn to add new form to parent div
        var form = `
        <div  id="tagFormContainer">

            <div class="tag-form bg-red-200 p-3 relative">
               <button type="button" class="delete-button w-[20px] absolute  right-[5px] top-[15px]" onclick="removeTagForm(this)"><img src="../view/assets/images/remove.png"></button>
                <label class="text-sm font-medium">Name Tag</label>
                <input class="mb-3 px-2 py-1.5 mb-3 mt-1 block w-full px-2 py-1.5 border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:invalid:border-red-500 focus:invalid:ring-red-500" type="text" name="nameTag[]" placeholder="Tag" required>

                <label class="text-sm font-medium">Theme</label>
                <select name="theme[]" required class="mb-3 px-2 py-1.5 mb-3 mt-1 block w-full px-2 py-1.5 border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:invalid:border-red-500 focus:invalid:ring-red-500">
                    <option value="">Select Theme</option>
                    <?php foreach ($themes as $theme) {?>
                        <option value="<?=$theme["IdTheme"]?>"><?=$theme["ThemeName"]?></option>
                    <?php } ?>
                </select>

                
            </div>
    </div>`
            
      
        newTag.addEventListener('click',()=>{
            var formDiv = document.createElement('div');
            formDiv.innerHTML = form;

            addTagDiv.append(formDiv);
        })
        function removeTagForm(button) {
            var tagForm = button.closest('.tag-form');
            tagForm.remove();
        }

        function removeAll() {
        var container = document.getElementById('addTagDiv');

        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }
    }


    </script>
</body>

</html>


</main>


</body>

</html>