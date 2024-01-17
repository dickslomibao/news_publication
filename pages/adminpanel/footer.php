<?php
require_once "../../classes/category_class.php";

$category = new Category;

$list = $category->getCategoryList();
?>
<header class="footer">
    <div class="margin-side">
        <h1>GA<span>ZSE</span>NT</h1>

        <div class="container-fluid content">
            <div class="row">
                <div class="col-md-4" style="display: grid; border-right:1px solid white">
                    <h5>Quick Links</h5>
                    <a href="../../">Home</a>
                    <a href="../site/news.php">News</a>
                    <a href="../site/featurednews.php">Featured News</a>
                    <a href="#top" class="backtotop">Back to top</a>
                </div>
                <div class="col-md-8">
                    <h5>Categories</h5>
                    <div class="row">
                        <div class="row">
                            <?php
                            $count = 0;
                            foreach ($list as $item) {
                                if ($count != 15) {
                                    echo '<div class="col-md-4"><a class="dropdown-item" href="../site/category.php?id=' . $item['id'] . '&title=' . $item['title'] . '">' . $item['title'] . '</a></div>';
                                    $count++;
                                } else
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>