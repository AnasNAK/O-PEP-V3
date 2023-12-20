<?php
include "../model/config.php";
if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $query = "SELECT * FROM article WHERE ArticleName LIKE '{$input}%'";
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $img = $row['ArticleImg'];
            $name = $row['ArticleName'];
            $desc = $row['ArticleDes'];
            $img = $row['ArticleImg'];
?>
            <div id="ok" class="max-w-sm py-20   ">
                <div class=" relative shadow-lg hover:shadow-xl transition duration-500 rounded-lg bg-purple-100">
                    <img class="rounded-t-lg w-2/4 h-[200px]" src="assets/images/<?php echo $row['ArticleImg']; ?>" />
                    <div class="py-6 p-3 w-[100%] rounded-lg bg-purple-200">
                        <h1 class="text-gray-700 font-bold text-2xl mb-3 hover:text-gray-900 hover:cursor-pointer">
                            <?php echo $row['ArticleName']; ?>
                        </h1>
                        <p class="text-gray-700 tracking-wide">
                            <?php
                            echo $row['ArticleDes'];
                            ?>
                        </p>
                        <form class="pt-5 flex flex-col justify-center gap-2 mr-3" action="" method="POST">
                            <button type="submit" class="px-4 py-3 leading-5 transform rounded-md focus:outline-none font-bold bg-white transition hover:bg-purple-900 hover:text-white">
                                Delete
                            </button>
                            <div>

                                <button type="submit" class="px-4 py-3 leading-5 transform rounded-md focus:outline-none font-bold bg-white transition hover:bg-purple-900 hover:text-white">
                                    See&nbsp;More
                                </button>
                                <button type="submit" class="px-4 py-3 leading-5 transform rounded-md focus:outline-none font-bold bg-white transition hover:bg-purple-900 hover:text-white">
                                    Edit&nbsp;Article
                                </button>
                            </div>
                        </form>
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
<?php
        }
    } else {
    }
}
?>