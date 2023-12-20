<?php
include './session.php';

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

if (isset($_SESSION['user_email'])) {
    $userEmail = $_SESSION['user_email'];

    $query = "SELECT IdUser FROM user WHERE Email = ?";
    $statement = $mysqli->prepare($query);
    $statement->bind_param('s', $userEmail);
    $statement->execute();
    // Fetch the user ID
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['IdUser'];
    }
}


$query1 = "SELECT* FROM theme";
$result = $mysqli->query($query1);
$themes = $result->fetch_all(MYSQLI_ASSOC);
$query2 = "SELECT * FROM tag";
$result = $mysqli->query($query2);
$tags = $result->fetch_all(MYSQLI_ASSOC);
$query3 = "SELECT
theme.IdTheme,
theme.ThemeName,
theme.ThemeDesc,
theme.ThemImg,
GROUP_CONCAT(tag.TagName) AS TagNames
FROM
theme
LEFT JOIN
tag ON theme.IdTheme = tag.Themeid
GROUP BY
theme.IdTheme, theme.ThemeName, theme.ThemeDesc, theme.ThemImg;
";
$result3 = $mysqli->query($query3);
$tagtheme = $result3->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative">
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
                    <a href="">Blog</a>
                </li>

            </ul>
        </nav>


        <div class="w-3/12 flex justify-end gap-5">
            <a href="../controller/logout.php" class="flex items-center mr-4 hover:text-purple-700 duration-200">
                <span class="inline-flex mr-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </span>
                Logout
            </a>
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
    <section class="absolute w-full z-[-10]">
        <xml version="1.0" tandalone="no"><svg xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 666.6602897441694"
                preserveAspectRatio="xMaxYMax slice">
                <g transform="scale(1.7391606810553226)">
                    <rect x="0" y="0" width="574.9995" height="383.33299999999997" fill="#ffffff" />
                    <rect x="319.44416666666666" y="63.88883333333333" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <rect x="0" y="127.77766666666666" width="63.88883333333333" height="63.88883333333333"
                        fill="#ffffff" />
                    <path d="M 0 127.78 A 31.94 31.94 0 0 1  31.94 159.72 L 0 127.78 A 31.94 31.94 0 0 0 31.94 159.72"
                        fill="#d3bcdb" />
                    <path d="M 0 159.72 A 31.94 31.94 0 0 1  31.94 191.66 L 0 159.72 A 31.94 31.94 0 0 0 31.94 191.66"
                        fill="#bc98c7" />
                    <rect x="127.77766666666666" y="127.77766666666666" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 159.72 159.72 A 31.94 31.94 0 0 1  191.66 127.78 L 159.72 159.72 A 31.94 31.94 0 0 0 191.66 127.78"
                        fill="#e4e9e1" />
                    <path
                        d="M 191.67 127.78 A 63.89 63.89 0 0 1  255.56 191.67000000000002 L 191.67 127.78 A 63.89 63.89 0 0 0 255.56 191.67000000000002"
                        fill="#9cb091" />
                    <rect x="383.33299999999997" y="127.77766666666666" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 383.33 159.72 A 31.94 31.94 0 0 1  415.27 127.78 L 383.33 159.72 A 31.94 31.94 0 0 0 415.27 127.78"
                        fill="#f5eff6" />
                    <path
                        d="M 383.33 159.72 A 31.94 31.94 0 0 1  415.27 191.66 L 383.33 159.72 A 31.94 31.94 0 0 0 415.27 191.66"
                        fill="#e4e9e1" />
                    <rect x="447.22183333333334" y="127.77766666666666" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 479.17 127.78 A 31.94 31.94 0 0 1  511.11 159.72 L 479.17 127.78 A 31.94 31.94 0 0 0 511.11 159.72"
                        fill="#faf8fb" />
                    <rect x="0" y="191.66649999999998" width="63.88883333333333" height="63.88883333333333"
                        fill="#ffffff" />
                    <path
                        d="M 0 223.60999999999999 A 31.94 31.94 0 0 1  31.94 191.67 L 0 223.60999999999999 A 31.94 31.94 0 0 0 31.94 191.67"
                        fill="#a371b2" />
                    <path
                        d="M 31.94 191.67 A 31.94 31.94 0 0 1  63.88 223.60999999999999 L 31.94 191.67 A 31.94 31.94 0 0 0 63.88 223.60999999999999"
                        fill="#f4eef6" />
                    <path d="M 0 223.61 A 31.94 31.94 0 0 1  31.94 255.55 L 0 223.61 A 31.94 31.94 0 0 0 31.94 255.55"
                        fill="#6b895b" />
                    <rect x="63.88883333333333" y="191.66649999999998" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 63.89 223.61 A 31.94 31.94 0 0 1  95.83 255.55 L 63.89 223.61 A 31.94 31.94 0 0 0 95.83 255.55"
                        fill="#c9d4c4" />
                    <path
                        d="M 95.83 223.61 A 31.94 31.94 0 0 1  127.77 255.55 L 95.83 223.61 A 31.94 31.94 0 0 0 127.77 255.55"
                        fill="#a5b79b" />
                    <rect x="127.77766666666666" y="191.66649999999998" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 127.78 223.60999999999999 A 31.94 31.94 0 0 1  159.72 191.67 L 127.78 223.60999999999999 A 31.94 31.94 0 0 0 159.72 191.67"
                        fill="#a5b79b" />
                    <path
                        d="M 159.72 223.60999999999999 A 31.94 31.94 0 0 1  191.66 191.67 L 159.72 223.60999999999999 A 31.94 31.94 0 0 0 191.66 191.67"
                        fill="#eee5f1" />
                    <path
                        d="M 127.78 255.55 A 31.94 31.94 0 0 1  159.72 223.61 L 127.78 255.55 A 31.94 31.94 0 0 0 159.72 223.61"
                        fill="#d9c5df" />
                    <path
                        d="M 159.72 255.55 A 31.94 31.94 0 0 1  191.66 223.61 L 159.72 255.55 A 31.94 31.94 0 0 0 191.66 223.61"
                        fill="#b187be" />
                    <rect x="319.44416666666666" y="191.66649999999998" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 319.44 223.60999999999999 A 31.94 31.94 0 0 1  351.38 191.67 L 319.44 223.60999999999999 A 31.94 31.94 0 0 0 351.38 191.67"
                        fill="#9aae8f" />
                    <path
                        d="M 351.39 223.61 A 31.94 31.94 0 0 1  383.33 255.55 L 351.39 223.61 A 31.94 31.94 0 0 0 383.33 255.55"
                        fill="#9e6bae" />
                    <rect x="383.33299999999997" y="191.66649999999998" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 415.28 191.67 A 31.94 31.94 0 0 1  447.21999999999997 223.60999999999999 L 415.28 191.67 A 31.94 31.94 0 0 0 447.21999999999997 223.60999999999999"
                        fill="#b6c5ae" />
                    <rect x="0" y="255.55533333333332" width="63.88883333333333" height="63.88883333333333"
                        fill="#ffffff" />
                    <path d="M 0 255.56 A 31.94 31.94 0 0 1  31.94 287.5 L 0 255.56 A 31.94 31.94 0 0 0 31.94 287.5"
                        fill="#839c76" />
                    <path
                        d="M 31.94 287.5 A 31.94 31.94 0 0 1  63.88 255.56 L 31.94 287.5 A 31.94 31.94 0 0 0 63.88 255.56"
                        fill="#bdcab6" />
                    <path d="M 0 319.44 A 31.94 31.94 0 0 1  31.94 287.5 L 0 319.44 A 31.94 31.94 0 0 0 31.94 287.5"
                        fill="#dae1d6" />
                    <path
                        d="M 31.94 319.44 A 31.94 31.94 0 0 1  63.88 287.5 L 31.94 319.44 A 31.94 31.94 0 0 0 63.88 287.5"
                        fill="#bc98c7" />
                    <rect x="63.88883333333333" y="255.55533333333332" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 63.89 255.56 A 31.94 31.94 0 0 1  95.83 287.5 L 63.89 255.56 A 31.94 31.94 0 0 0 95.83 287.5"
                        fill="#efe7f2" />
                    <path
                        d="M 95.83 287.5 A 31.94 31.94 0 0 1  127.77 255.56 L 95.83 287.5 A 31.94 31.94 0 0 0 127.77 255.56"
                        fill="#779268" />
                    <path
                        d="M 63.89 319.44 A 31.94 31.94 0 0 1  95.83 287.5 L 63.89 319.44 A 31.94 31.94 0 0 0 95.83 287.5"
                        fill="#9d69ae" />
                    <path
                        d="M 95.83 287.5 A 31.94 31.94 0 0 1  127.77 319.44 L 95.83 287.5 A 31.94 31.94 0 0 0 127.77 319.44"
                        fill="#628251" />
                    <path
                        d="M 127.78 319.45 A 63.89 63.89 0 0 1  191.67000000000002 255.56 L 127.78 319.45 A 63.89 63.89 0 0 0 191.67000000000002 255.56"
                        fill="#f0f3ef" />
                    <rect x="191.66649999999998" y="255.55533333333332" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 223.61 255.56 A 31.94 31.94 0 0 1  255.55 287.5 L 223.61 255.56 A 31.94 31.94 0 0 0 255.55 287.5"
                        fill="#9963aa" />
                    <path
                        d="M 223.61 287.5 A 31.94 31.94 0 0 1  255.55 319.44 L 223.61 287.5 A 31.94 31.94 0 0 0 255.55 319.44"
                        fill="#9aaf8f" />
                    <rect x="255.55533333333332" y="255.55533333333332" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 255.56 287.5 A 31.94 31.94 0 0 1  287.5 255.56 L 255.56 287.5 A 31.94 31.94 0 0 0 287.5 255.56"
                        fill="#ba96c6" />
                    <path
                        d="M 287.5 255.56 A 31.94 31.94 0 0 1  319.44 287.5 L 287.5 255.56 A 31.94 31.94 0 0 0 319.44 287.5"
                        fill="#d1b9d9" />
                    <path
                        d="M 255.56 319.44 A 31.94 31.94 0 0 1  287.5 287.5 L 255.56 319.44 A 31.94 31.94 0 0 0 287.5 287.5"
                        fill="#d0dacb" />
                    <path
                        d="M 287.5 287.5 A 31.94 31.94 0 0 1  319.44 319.44 L 287.5 287.5 A 31.94 31.94 0 0 0 319.44 319.44"
                        fill="#b9c7b1" />
                    <rect x="319.44416666666666" y="255.55533333333332" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 319.44 255.56 A 31.94 31.94 0 0 1  351.38 287.5 L 319.44 255.56 A 31.94 31.94 0 0 0 351.38 287.5"
                        fill="#8fa683" />
                    <path
                        d="M 351.39 287.5 A 31.94 31.94 0 0 1  383.33 255.56 L 351.39 287.5 A 31.94 31.94 0 0 0 383.33 255.56"
                        fill="#8b4e9f" />
                    <path
                        d="M 351.39 319.44 A 31.94 31.94 0 0 1  383.33 287.5 L 351.39 319.44 A 31.94 31.94 0 0 0 383.33 287.5"
                        fill="#fbf9fc" />
                    <rect x="383.33299999999997" y="255.55533333333332" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 415.28 255.56 A 31.94 31.94 0 0 1  447.21999999999997 287.5 L 415.28 255.56 A 31.94 31.94 0 0 0 447.21999999999997 287.5"
                        fill="#d6c0dd" />
                    <path
                        d="M 383.33 287.5 A 31.94 31.94 0 0 1  415.27 319.44 L 383.33 287.5 A 31.94 31.94 0 0 0 415.27 319.44"
                        fill="#e5eae2" />
                    <path
                        d="M 415.28 319.44 A 31.94 31.94 0 0 1  447.21999999999997 287.5 L 415.28 319.44 A 31.94 31.94 0 0 0 447.21999999999997 287.5"
                        fill="#afbfa7" />
                    <rect x="511.11066666666665" y="255.55533333333332" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 543.06 287.5 A 31.94 31.94 0 0 1  575 255.56 L 543.06 287.5 A 31.94 31.94 0 0 0 575 255.56"
                        fill="#bccab5" />
                    <path
                        d="M 511.11 319.44 A 31.94 31.94 0 0 1  543.0500000000001 287.5 L 511.11 319.44 A 31.94 31.94 0 0 0 543.0500000000001 287.5"
                        fill="#ccd6c6" />
                    <path
                        d="M 543.06 319.44 A 31.94 31.94 0 0 1  575 287.5 L 543.06 319.44 A 31.94 31.94 0 0 0 575 287.5"
                        fill="#88489c" />
                    <rect x="0" y="319.44416666666666" width="63.88883333333333" height="63.88883333333333"
                        fill="#ffffff" />
                    <path d="M 0 319.44 A 31.94 31.94 0 0 1  31.94 351.38 L 0 319.44 A 31.94 31.94 0 0 0 31.94 351.38"
                        fill="#d4bedb" />
                    <path
                        d="M 31.94 319.44 A 31.94 31.94 0 0 1  63.88 351.38 L 31.94 319.44 A 31.94 31.94 0 0 0 63.88 351.38"
                        fill="#8a4b9d" />
                    <path d="M 0 351.39 A 31.94 31.94 0 0 1  31.94 383.33 L 0 351.39 A 31.94 31.94 0 0 0 31.94 383.33"
                        fill="#d1dacc" />
                    <path
                        d="M 31.94 351.39 A 31.94 31.94 0 0 1  63.88 383.33 L 31.94 351.39 A 31.94 31.94 0 0 0 63.88 383.33"
                        fill="#d8c3df" />
                    <path
                        d="M 63.89 319.44 A 63.89 63.89 0 0 1  127.78 383.33 L 63.89 319.44 A 63.89 63.89 0 0 0 127.78 383.33"
                        fill="#d6c0dd" />
                    <rect x="127.77766666666666" y="319.44416666666666" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 127.78 351.38 A 31.94 31.94 0 0 1  159.72 319.44 L 127.78 351.38 A 31.94 31.94 0 0 0 159.72 319.44"
                        fill="#f3ecf5" />
                    <path
                        d="M 159.72 319.44 A 31.94 31.94 0 0 1  191.66 351.38 L 159.72 319.44 A 31.94 31.94 0 0 0 191.66 351.38"
                        fill="#8da480" />
                    <path
                        d="M 127.78 351.39 A 31.94 31.94 0 0 1  159.72 383.33 L 127.78 351.39 A 31.94 31.94 0 0 0 159.72 383.33"
                        fill="#9fb395" />
                    <path
                        d="M 159.72 351.39 A 31.94 31.94 0 0 1  191.66 383.33 L 159.72 351.39 A 31.94 31.94 0 0 0 191.66 383.33"
                        fill="#f6f1f8" />
                    <rect x="191.66649999999998" y="319.44416666666666" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 191.67 319.44 A 31.94 31.94 0 0 1  223.60999999999999 351.38 L 191.67 319.44 A 31.94 31.94 0 0 0 223.60999999999999 351.38"
                        fill="#749065" />
                    <path
                        d="M 223.61 319.44 A 31.94 31.94 0 0 1  255.55 351.38 L 223.61 319.44 A 31.94 31.94 0 0 0 255.55 351.38"
                        fill="#945ca6" />
                    <path
                        d="M 191.67 383.33 A 31.94 31.94 0 0 1  223.60999999999999 351.39 L 191.67 383.33 A 31.94 31.94 0 0 0 223.60999999999999 351.39"
                        fill="#e8ede6" />
                    <path
                        d="M 223.61 351.39 A 31.94 31.94 0 0 1  255.55 383.33 L 223.61 351.39 A 31.94 31.94 0 0 0 255.55 383.33"
                        fill="#79946b" />
                    <path
                        d="M 255.56 383.33 A 63.89 63.89 0 0 1  319.45 319.44 L 255.56 383.33 A 63.89 63.89 0 0 0 319.45 319.44"
                        fill="#b288bf" />
                    <path
                        d="M 319.44 383.33 A 63.89 63.89 0 0 1  383.33 319.44 L 319.44 383.33 A 63.89 63.89 0 0 0 383.33 319.44"
                        fill="#8b4d9e" />
                    <rect x="383.33299999999997" y="319.44416666666666" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 383.33 351.38 A 31.94 31.94 0 0 1  415.27 319.44 L 383.33 351.38 A 31.94 31.94 0 0 0 415.27 319.44"
                        fill="#be9bc9" />
                    <path
                        d="M 415.28 319.44 A 31.94 31.94 0 0 1  447.21999999999997 351.38 L 415.28 319.44 A 31.94 31.94 0 0 0 447.21999999999997 351.38"
                        fill="#f1f4f0" />
                    <path
                        d="M 383.33 351.39 A 31.94 31.94 0 0 1  415.27 383.33 L 383.33 351.39 A 31.94 31.94 0 0 0 415.27 383.33"
                        fill="#d5bedc" />
                    <path
                        d="M 415.28 383.33 A 31.94 31.94 0 0 1  447.21999999999997 351.39 L 415.28 383.33 A 31.94 31.94 0 0 0 447.21999999999997 351.39"
                        fill="#fdfefd" />
                    <path
                        d="M 447.22 319.44 A 63.89 63.89 0 0 1  511.11 383.33 L 447.22 319.44 A 63.89 63.89 0 0 0 511.11 383.33"
                        fill="#b188be" />
                    <rect x="511.11066666666665" y="319.44416666666666" width="63.88883333333333"
                        height="63.88883333333333" fill="#ffffff" />
                    <path
                        d="M 511.11 319.44 A 31.94 31.94 0 0 1  543.0500000000001 351.38 L 511.11 319.44 A 31.94 31.94 0 0 0 543.0500000000001 351.38"
                        fill="#e0cfe5" />
                    <path
                        d="M 543.06 319.44 A 31.94 31.94 0 0 1  575 351.38 L 543.06 319.44 A 31.94 31.94 0 0 0 575 351.38"
                        fill="#edf0eb" />
                    <path
                        d="M 511.11 351.39 A 31.94 31.94 0 0 1  543.0500000000001 383.33 L 511.11 351.39 A 31.94 31.94 0 0 0 543.0500000000001 383.33"
                        fill="#c3a4cd" />
                    <path
                        d="M 543.06 383.33 A 31.94 31.94 0 0 1  575 351.39 L 543.06 383.33 A 31.94 31.94 0 0 0 575 351.39"
                        fill="#fefdfe" />
                </g>
            </svg>




    </section>

    <?php
    foreach ($tagtheme as $theme) :  ?>

    <div class="bg-purple-100 dark:bg-gray-800 overflow-hidden relative mb-5">

        <div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
            <button type="button"
                class="text-blue-700 hover:text-white border border-blue-600 bg-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:bg-gray-900 dark:focus:ring-blue-800">
                <?php
                    // Check if TagNames key is set in the array
                    // if (isset($theme['TagNames'])) {
                    // Display tags related to the current theme
                    $tagNames = explode(',', $theme['TagNames']);
                    foreach ($tagNames as $tagName) {
                        echo $tagName . ' ';
                    }
                    // }
                    ?></button>
        </div>

        <div class="text-start w-1/2 py-12 px-4 sm:px-6 lg:py-16 lg:px-8 z-20">

            <h2 class="text-3xl font-extrabold text-black dark:text-white sm:text-4xl">
                <span class="block">
                    <?php echo htmlspecialchars($theme['ThemeName']); ?>
                </span>

            </h2>

            <p class="text-xl mt-4 text-gray-400">
                <?php echo htmlspecialchars($theme['ThemeDesc']); ?>
            </p>




            <div class="lg:mt-0 lg:flex-shrink-0">
                <div class="mt-12 inline-flex rounded-md shadow">
                    <img src="./assets/images/<?php echo $theme['ThemImg']; ?>"
                        class="absolute top-0 right-0 hidden h-80 mt-40  max-w-1/2 lg:block " />
                    <form action="" method="GET">
                        <a href="article.php?IdTheme=<?php echo $theme['IdTheme']; ?>">
                            <button type="submit"
                                class="px-6 py-3 leading-5 transform rounded-md focus:outline-none font-bold bg-purple-300 transition hover:bg-purple-900 hover:text-white">
                                See More
                        </a></button>

                    </form>
                    <form action="" method="POST">
                         <a href="editTheme2.php?IdTheme=<?php echo $theme['IdTheme']; ?>"
                            class="text-blue-500 hover:text-blue-600">
                            <button type="submit"
                                class="px-6 py-3 leading-5 transform rounded-md focus:outline-none font-bold bg-purple-300 transition hover:bg-purple-900 hover:text-white">

                                Edit Theme </a> </button>
                            </form>





                </div>
            </div>
        </div>




    </div>
    <?php endforeach; ?>


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