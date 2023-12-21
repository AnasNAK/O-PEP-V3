<?php
require_once "../model/model.php";


$session = new Session(); 
$categorie = new Categorie();

$userRole = $session->checkUserSession();

if ($userRole === 'blocked') {
    header("Location: ./block-page.php");
    exit();
}
if ($userRole !== 'admin') {
    header("Location: ./SingIn.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['IdCategorie'])) {
    $categoryId = $_GET['IdCategorie'];

    $isFetched = $categorie->getCategoryById($categoryId);

    if (!$isFetched) {
    
        header("Location: ./dashboard.php");
        exit();
    }

    $categoryId = $categorie->getCategorieId();
    $categoryName = $categorie->getCategorieName();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $updatedCategoryName = $_POST['catname'];
    $categoryId = $_GET['IdCategorie'];

    $categorie->setCategorieName($updatedCategoryName);
    $categorie->setCategorieId($categoryId);


    $isUpdated = $categorie->updateCategory();

    if ($isUpdated) {
        echo "Category updated successfully";
        header("Location: ./dashboard.php");
        exit();
    } else {
        echo "Error updating category";
       
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
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
        <h1 class="text-4xl font-bold capitalize">Edit Category</h1>
        <form method="POST" class="flex flex-col gap-5">
            <div class="grid grid-cols-1 gap-1 mt-4 sm:grid-cols-2">
                <div>
                    <label class="font-bold" for="name">Category Name</label>
                    <input id="name" name="catname" value="<?php echo ($categoryName); ?>" type="text" class="block w-full px-4 py-2 mt-2 text-gray-400 bg-white border border-[#685942] rounded-md focus:border-[#685942] focus:outline-none focus:ring">
                    <span class="font-bold text-orange-400"></span>
                </div>
            </div>
            <div class="flex gap-6">
                <button type="submit" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">
                    Save
                </button>
                <a href="dashboard.php">
                    <button type="button" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">
                        Cancel
                    </button>
                </a>
            </div>
        </form>
    </section>
</body>

</html>