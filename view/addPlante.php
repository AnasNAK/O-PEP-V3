<?php
include 'session.php';

// Check user session and retrieve the role
$userRole = checkUserSession($mysqli);

// Redirect based on user role
if ($userRole === 'blocked') {
    header("Location: block-page.php");
    exit();
}
if ($userRole !== 'admin') {
    header("Location: SingIn.php");
}

// Fetch categories data from the database
$query = "SELECT * FROM categorie"; // Replace 'categories' with your table name
$result = $mysqli->query($query);
$categories = $result->fetch_all(MYSQLI_ASSOC);

// Handling form submission to add a plant
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $plantName = $_POST['name'];
    $plantPrice = $_POST['price'];
    $categoryId = $_POST['category']; // Assuming 'category' is your category select field

    // Handle image upload
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); 
    }
    $uploadedImage = $_FILES['image']; // Retrieve uploaded file information
    $imageName = $uploadedImage['name']; // Get the name of the uploaded file
    $imageTempName = $uploadedImage['tmp_name']; // Get the temporary file name

    // Check if a file was uploaded
    if (!empty($imageName)) {
        // Generate a unique name for the uploaded image to avoid conflicts
        $imagePath = $uploadDir . uniqid() . '_' . $imageName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($imageTempName, $imagePath)) {
            // File uploaded successfully, proceed to insert plant data into the database
            $insertQuery = "INSERT INTO Plant (Name, price, CategorieId, image) VALUES (?, ?, ?, ?)";
            $insertStmt = $mysqli->prepare($insertQuery);
            $insertStmt->bind_param('ssss', $plantName, $plantPrice, $categoryId, $imagePath);

            if ($insertStmt->execute()) {
                // Redirect or display success message
                header("Location: dashboard.php");
                exit();
            }
        }
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
        <h1 class="text-4xl font-bold capitalize ">Add Plant</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div id="formInp">
                <div class="form-group mb-6">
                    <input type="text" name="name"
                        class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        placeholder="Plant Name">
                </div>
                <div class="form-group mb-6 flex gap-4">
                    <div class="">
                        <input type="number" name="price"
                            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            placeholder="Plant Price">
                    </div>
                </div>
                <div class="form-group mb-6 w-full">
                    <select name="category" class="w-full p-2 rounded-md bg-white text-black">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['IdCategorie']; ?>">
                            <?php echo $category['CategorieName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-6 w-full">
                    <input type="file" name="image" class="block">
                </div>
                <hr class="border-2 my-4">
            </div>
            <div class="flex justify-between mt-6">
                <div class="flex gap-6">
                    <button type="submit"
                        class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Save</button>
                    <a href="dashboard.php">
                        <button type="button"
                            class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Cancel</button>
                    </a>
                </div>
            </div>
        </form>
    </section>
</body>

</html>