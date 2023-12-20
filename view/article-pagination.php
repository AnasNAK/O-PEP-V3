<?php
include '../model/config.php';

$record_page = 10;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$start_form = ($page - 1) * $record_page;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idTheme = $_POST['id_theme'];
}

$query = "SELECT COUNT(*) as total FROM article WHERE ThemeId = '$idTheme'";
$count_result = mysqli_query($mysqli, $query);
$row_count = mysqli_fetch_assoc($count_result);
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $record_page);

$output_articles = '';

$query_articles = "SELECT * FROM article WHERE ThemeId = '$idTheme' ORDER BY idArticle  LIMIT $start_form, $record_page";
$result = mysqli_query($mysqli, $query_articles);

if (!$result) {
    echo "Error executing query: " . mysqli_error($mysqli);
   
} else {
    while ($row = mysqli_fetch_array($result)) {
   
        $output_articles .= '
        <div class="max-w-sm py-20">
        <div class="relative shadow-lg hover:shadow-xl transition duration-500 rounded-lg bg-purple-100">
        <img class="rounded-t-lg w-2/4 h-[200px]" src="' . $row['ArticleImg'] . '" />
        <div class="py-6 p-3 w-[100%] rounded-lg bg-purple-200">
        
            <h1 class="text-gray-700 font-bold text-2xl mb-3 hover:text-gray-900 hover:cursor-pointer">' . $row['ArticleName'] . '</h1>
            <p class="text-gray-700 tracking-wide">' . $row['ArticleDes'] . '</p>
        <div class="flex flex-col gap-3">
            <form class="pt-5 flex flex-col justify-center  mr-3" action="../controller/crud_article.php" method="POST">
                <button type="submit" name="deleteArticle" class="px-4 py-3 leading-5 transform rounded-md focus:outline-none font-bold bg-white transition hover:bg-purple-900 hover:text-white">Delete</button>
            </form>
                <div class="flex justify-evenly ">
               
                     <form method="POST" action="./SpecART.php">
                                 <input hidden name="id_article" value="  '. $row['idArticle'] .' ">
                                 <button type="submit"
                                        class="px-4 py-3 leading-5 transform rounded-md focus:outline-none font-bold bg-white transition hover:bg-purple-900 hover:text-white">
                                        See&nbsp;More
                                    </button>
                                 </form>
                 <form method="POST" action="../controller/crud_article.php">
                      <input hidden name="id_article" value="  '. $row['idArticle'] .' ">
                    <button type="submit" class="px-4 py-3 leading-5 transform rounded-md focus:outline-none font-bold bg-white transition hover:bg-purple-900 hover:text-white">Edit&nbsp;Article</button>
                </form>
                </div>
           
             </div>
        </div>
        <div class="absolute top-2 right-2 py-2 px-4 bg-purple-200 rounded-lg">
            <div class="flex items-center mb-4">
                <div class="mr-2">
                    <i class="fas fa-thumbs-up text-blue-500 text-2xl cursor-pointer"></i>
                </div>
                <span class="text-sm">100</span>
            </div>
            <div class="flex items-center">
                <div class="mr-2">
                    <i class="fas fa-thumbs-down text-red-500 text-2xl cursor-pointer"></i>
                </div>
                <span class="text-sm">20</span>
            </div>
        </div>
    </div>
</div>
        </div>';
    }

    // Output the articles
    echo $output_articles;

    // Output the pagination links based on the retrieved articles for the specific theme
    if ($total_records > $record_page) {
        echo '<div id="article-pagination" class="text-center m-auto mb-3">';
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = ($i == $page) ? 'active' : '';
            echo "<span class='pagination_links $active_class' style='cursor:pointer;padding:6px;border:1px solid #ccc;' id='" . $i . "'> " . $i . "</span>";
        }
        echo '</div>';
    }
}
?>