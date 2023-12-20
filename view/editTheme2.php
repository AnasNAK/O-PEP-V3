<?php
include 'session.php';

// Check user session and retrieve the role
$userRole = checkUserSession($mysqli);

// Redirect based on user role
if ($userRole === 'blocked') {
    header("Location: block-page.php");
    exit();
}


$themeId = $_GET['IdTheme'];

$queryTags = "SELECT * FROM tag WHERE Themeid = ?";
$stmtTags = $mysqli->prepare($queryTags);
$stmtTags->bind_param('i', $themeId);
$stmtTags->execute();
$tagsForTheme = $stmtTags->get_result()->fetch_all(MYSQLI_ASSOC);

$query3 = "SELECT theme.IdTheme , theme.ThemeName, theme.ThemeDesc, theme.ThemImg ,tag.Themeid,Tag.tagSt, GROUP_CONCAT(tag.TagName) AS TagNames
FROM theme
LEFT JOIN tag ON theme.IdTheme = tag.Themeid";
$result3 = $mysqli->query($query3);
$tagtheme = $result3->fetch_all(MYSQLI_ASSOC);

$queryTags2 = "SELECT * FROM tag WHERE Themeid = ?";
$stmtTags2 = $mysqli->prepare($queryTags2);
$stmtTags2->bind_param('i', $themeId);
$stmtTags2->execute();
$tagsForTheme2 = $stmtTags2->get_result()->fetch_all(MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['IdTheme'])) {
    $themeId = $_GET['IdTheme'];

    $query = "SELECT * FROM `theme` WHERE IdTheme = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $themeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $theme = $result->fetch_assoc();

    // Fetch categories data from the database
    // $queryCategories = "SELECT * FROM tag";
    // $resultCategories = $mysqli->query($queryCategories); 
    // $categories = $resultCategories->fetch_all(MYSQLI_ASSOC);

    // Check if a plant with the specified ID exists
    if ($themeId) {
        $themeId = $_GET['IdTheme'];
        // $imagePath = $tagtheme['ThemImg'];
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateTheme'])) {

    if (isset($_POST['tagstatusoff']) && is_array($_POST['tagstatusoff'])) {

        foreach ($_POST['tagstatusoff'] as $tagId) {
            $updatestatus = "UPDATE tag SET TagSt = 1 WHERE idTag = ?";

            $Upstmt = $mysqli->prepare($updatestatus);
            $Upstmt->bind_param('i', $tagId);
            $Upstmt->execute();
        }
    }
    // if (!isset($_POST['tagstatusoff']) && is_array($_POST['tagstatusoff'])) {

    //     if (isset($_POST['tagstatus']) && is_array($_POST['tagstatus'])) {
    //         foreach ($_POST['tagstatus'] as $tagId) {
    //             $updatestatus = "UPDATE tag SET TagSt = 0 WHERE idTag = ?";

    //             $Upstmt = $mysqli->prepare($updatestatus);
    //             $Upstmt->bind_param('i', $tagId);
    //             $Upstmt->execute();
    //         }
    //     }
    // }

    $themeId = $_GET['IdTheme'];

    $updatedName = $_POST['ThemeName'];
    $uploadedImage = $_FILES['image'];

    // Image upload handling
    $uploadDir = 'uploads/';

    // Check if a new image was uploaded
    if (!empty($uploadedImage['name'])) {
        $imageName = $uploadedImage['name'];
        $imageTempName = $uploadedImage['tmp_name'];

        // Generate a unique name for the uploaded image to avoid conflicts
        $imagePath = $uploadDir . uniqid() . '_' . $imageName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($imageTempName, $imagePath)) {
            // Update plant details with the new image path
            $updateQuery = "UPDATE theme SET `ThemeName` = ?, `ThemImg` = ? WHERE IdTheme = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            $updateStmt->bind_param('ssi', $updatedName, $imagePath, $themeId);

            if ($updateStmt->execute()) {
                // Redirect or display success message
                header("Location: dashboardtheme.php");
                exit();
            } else {
                echo "Error updating theme.";
            }
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        // No new image uploaded, update other plant details without changing the image
        $updateQuery = "UPDATE theme SET `ThemeName` = ? WHERE IdTheme = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param('si', $updatedName, $themeId);

        if ($updateStmt->execute()) {
            // Redirect or display success message
            header("Location: dashboardtheme.php");
            exit();
        } else {
            echo "Error updating theme.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateTag'])) {
    if (isset($_POST['statusRemove']) && is_array($_POST['statusRemove'])) {

        foreach ($_POST['statusRemove'] as $tagId) {
            $updatestatus = "UPDATE tag SET TagSt = 0 WHERE idTag = ?";

            $Upstmt = $mysqli->prepare($updatestatus);
            $Upstmt->bind_param('i', $tagId);
            $Upstmt->execute();
        }
    }
    $themeId = $_GET['IdTheme'];

    $updatedName = $_POST['ThemeName'];
    $uploadedImage = $_FILES['image'];

    // Image upload handling
    $uploadDir = 'uploads/';

    // Check if a new image was uploaded
    if (!empty($uploadedImage['name'])) {
        $imageName = $uploadedImage['name'];
        $imageTempName = $uploadedImage['tmp_name'];

        // Generate a unique name for the uploaded image to avoid conflicts
        $imagePath = $uploadDir . uniqid() . '_' . $imageName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($imageTempName, $imagePath)) {
            // Update plant details with the new image path
            $updateQuery = "UPDATE theme SET `ThemeName` = ?, `ThemImg` = ? WHERE IdTheme = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            $updateStmt->bind_param('ssi', $updatedName, $imagePath, $themeId);

            if ($updateStmt->execute()) {
                // Redirect or display success message
                header("Location: dashboardtheme.php");
                exit();
            } else {
                echo "Error updating theme.";
            }
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        // No new image uploaded, update other plant details without changing the image
        $updateQuery = "UPDATE theme SET `ThemeName` = ? WHERE IdTheme = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param('si', $updatedName, $themeId);

        if ($updateStmt->execute()) {
            // Redirect or display success message
            header("Location: dashboardtheme.php");
            exit();
        } else {
            echo "Error updating theme.";
        }
    }
}
//trying to duplicate but reverse the condition

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateTheme'])) {

//     if (isset($_POST['tagstatus']) && is_array($_POST['tagstatus'])) {
//         foreach ($_POST['tagstatus'] as $tagId) {
//             $updatestatus1 = "UPDATE tag SET TagSt = 0 WHERE idTag = ?";

//             $Upstmt1 = $mysqli->prepare($updatestatus1);
//             $Upstmt1->bind_param('i', $tagId);
//             $Upstmt1->execute();
//         }

//         if ($Upstmt1->execute()) {
//             echo "Tag status was updated successfully.";
//         } else {
//             echo "Error updating tag status.";
//         }
//     }
//     $themeId = $_GET['IdTheme'];

//     $updatedName1 = $_POST['ThemeName'];
//     $uploadedImage1 = $_FILES['image'];

//     // Image upload handling
//     $uploadDir1 = 'uploads/';

//     // Check if a new image was uploaded
//     if (!empty($uploadedImage1['name'])) {
//         $imageName1 = $uploadedImage1['name'];
//         $imageTempName1 = $uploadedImage1['tmp_name'];

//         // Generate a unique name for the uploaded image to avoid conflicts
//         $imagePath1 = $uploadDir1 . uniqid() . '_' . $imageName1;

//         // Move the uploaded file to the specified directory
//         if (move_uploaded_file($imageTempName1, $imagePath1)) {
//             // Update plant details with the new image path
//             $updateQuery = "UPDATE theme SET `ThemeName` = ?, `ThemImg` = ? WHERE IdTheme = ?";
//             $updateStmt1 = $mysqli->prepare($updateQuery);
//             $updateStmt1->bind_param('ssi', $updatedName1, $imagePath1, $themeId1);

//             if ($updateStmt1->execute()) {
//                 // Redirect or display success message
//                 header("Location: dashboardtheme.php");
//                 exit();
//             } else {
//                 echo "Error updating theme.";
//             }
//         } else {
//             echo "Failed to upload the image.";
//         }
//     } else {
//         // No new image uploaded, update other plant details without changing the image
//         $updateQuery = "UPDATE theme SET `ThemeName` = ? WHERE IdTheme = ?";
//         $updateStmt1 = $mysqli->prepare($updateQuery);
//         $updateStmt1->bind_param('si', $updatedName1, $themeId1);

//         if ($updateStmt1->execute()) {
//             // Redirect or display success message
//             header("Location: dashboardtheme.php");
//             exit();
//         } else {
//             echo "Error updating theme.";
//         }
//     }
// }



// $selectedTagsQuery = "SELECT TagName FROM tag WHERE Themeid = ? AND TagSt = 1";
// $stmtSelectedTags = $mysqli->prepare($selectedTagsQuery);
// $stmtSelectedTags->bind_param('i', $themeId);
// $stmtSelectedTags->execute();
// $selectedTagsResult = $stmtSelectedTags->get_result();
// $selectedTags = $selectedTagsResult->fetch_all(MYSQLI_ASSOC);
?>


</head>

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/png" href="../public/img/logo-1.png" />
    <link rel="stylesheet" href="./public/css/style.css">
</head>

<body class="bg-purple-700 font-[sitika] text-black">
    <section class="max-w-4xl p-6 mx-auto bg-purple-400 rounded-md shadow-md my-7">
        <h1 class="text-4xl font-bold capitalize">Edit Theme</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                <div>
                    <label class="font-bold" for="name">Theme Name</label>
                    <input type="text" name="ThemeName" value="<?php
                                                                echo $theme['ThemeName'];
                                                                ?>">
                    <span class="font-bold text-orange-400"></span>
                </div>



                <div>
                    <label class="block font-bold">
                        Theme Image
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-white border-dashed rounded-md">
                        <div class="space-y-1 text-center">

                            <img src="<?php echo isset($imagePath) ? $imagePath : ''; ?>" alt="Current Image" class="h-24 w-24 mx-auto rounded-md">
                            <div class="flex text-sm">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium hover:text-blue-300">
                                    <span class="">Upload a file</span>
                                    <input id="file-upload" name="image" type="file" value="" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs">PNG, JPG</p>
                        </div>
                    </div>
                    <span class="font-bold text-orange-400"></span>
                </div>



            </div>
            <?php

            foreach ($tagsForTheme as $tag) :
                if ($tag['TagSt'] == 1) :
            ?><ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">

                                <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                    <input checked id="bordered-checkbox-2<?php echo $tag['idTag']; ?>" type="checkbox" value="<?php echo $tag['idTag']; ?>" name=" tagstatus[]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="bordered-checkbox-2<?php echo $tag['idTag']; ?>" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo $tag['TagName']; ?></label>
                                </div>
                            </div>
                        </li>
                    </ul>


                <?php
                else :
                ?>
                    <ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                    <input id="bordered-checkbox-1<?php echo $tag['idTag']; ?>" type="checkbox" value="<?php echo $tag['idTag']; ?>" name="tagstatusoff[]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="bordered-checkbox-1<?php echo $tag['idTag']; ?>" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo $tag['TagName']; ?></label>
                                </div>
                            </div>
                        </li>
                    </ul>


            <?php
                endif;
            endforeach;

            ?>


            <div class="flex justify-between mt-6">
                <div class="flex gap-6">
                    <button type="submit" name="updateTheme" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Save</button>
                    <a href="dashboard.php">
                        <button type="button" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Cancel</button>
                    </a>
                </div>
            </div>
        </form>
        <form method="post" action="">

            <?php

            foreach ($tagsForTheme as $tag2) :
                if ($tag2['TagSt'] == 1) :
            ?>
                    <ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                    <input id="bordered-checkbox-1<?php echo $tag2['idTag']; ?>" type="checkbox" value="<?php echo $tag2['idTag']; ?>" name="statusRemove[]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="bordered-checkbox-1<?php echo $tag2['idTag']; ?>" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo $tag2['TagName']; ?></label>
                                </div>
                            </div>
                        </li>
                    </ul>
            <?php
                endif;
            endforeach;

            ?>

            <div class="flex justify-between mt-6">
                <div class="flex gap-6">
                    <button type="submit" name="updateTag" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Save</button>
                    <a href="dashboard.php">
                        <button type="button" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Cancel</button>
                    </a>
                </div>
            </div>
        </form>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>

</html>