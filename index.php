<?php
require_once 'classes/news_getter.php';
$newslist = new Newslist;
session_start();
$excempted = [];
$resultBNEWS = $newslist->getSingleBreakingNews();
$fourLatestNews = $newslist->getLatestPost($resultBNEWS[0]['id']);
$othernews = $newslist->getAllNews();
$featurednews = $newslist->getFeaturedNews($resultBNEWS[0]['id']);
array_push($excempted, $resultBNEWS[0]['id']);

$popularNews = $newslist->getPopularNews();

require_once "classes/category_class.php";

$category = new Category;

$list = $category->getCategoryList();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gazsent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="css/body_configuration.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/newsassets/logo.jpg" type="image/x-icon">
    <style>
        #others {
            overflow: auto;
        }

        #others::-webkit-scrollbar,
        #categoryDropdown::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body>
    <header>
        <div class="container-fluid top-nav">
            <div class="margin-side">
                <div class="top-navbar-content">
                    <p>Date Today: <?php date_default_timezone_set('Asia/Manila');
                                    echo  date("F d, Y"); ?></p>
                    <?php if (isset($_SESSION['username'])) { ?>
                        <p>Hi, <?php echo  $_SESSION['username']; ?></p>
                    <?php  } ?>
                </div>
            </div>
        </div>
        <div class="container-fluid logo-side-nav">
            <div class="margin-side">
                <div class="logo-content-side">
                    <div style="display: flex;">
                        <img src="assets/newsassets/logo.jpg" class="logo-img">
                        <h1 class="logo-text">GA<span style="color: #FFC000">ZSE</span>NT</h1>
                    </div>
                    <div>
                        <form action="pages/site/search.php" method="get">
                            <input required type="text" name="search" id="">
                            <button type="submit" value="">Search</button>
                        </form>
                    </div>
                    <?php if (isset($_SESSION['username'])) { ?>
                        <div>
                            <a href="pages/adminpanel/logout.php">Sign out</a>
                            <span>|</span>
                            <a href="pages/site/myaccount.php">My Account</a>
                        </div>
                    <?php } else { ?>
                        <div>
                            <a href="pages/site/login.php">Sign in</a>
                            <span>|</span>
                            <a href="pages/site/register1.0.php">Sign up</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="container-fluid navbar-main-container">
            <div class="margin-side">
                <div class="main-nav-bar">
                    <ul class="navlist-item">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== '2' && $_SESSION['role'] !== '5' ){?>
                        <li class="nav-item"><a href="pages/adminpanel/dashboard.php" class="nav-link">Dashboard</a></li>
                    <?php }?>
                        <li class="nav-item active"><a href="" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="pages/site/news.php" class="nav-link">News</a></li>
                        <li class="nav-item"><a href="pages/site/featurednews.php" class="nav-link">Featured News</a></li>
                        <li class="nav-item">
                            <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Category
                            </a>
                            <ul class="dropdown-menu" id="categoryDropdown" style="height: 200px;overflow:auto">
                                <?php
                                foreach ($list as $item) {
                                    echo '<li><a class="dropdown-item" href="pages/site/category.php?id=' . $item['id'] . '&title=' . $item['title'] . '">' . $item['title'] . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <header class="breaking-news" style="margin-top: 30px;">
        <div class="margin-side">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <a href="pages/site/newsview.php?active=true&id=<?php echo $resultBNEWS[0]['id']; ?>&title=<?php echo $resultBNEWS[0]['newstitle']; ?>" class="cc">
                            <div class="breaking-news-content">
                                <h6 class="header-title">Breaking News</h6>
                                <div class="breaking-news-info">
                                    <h4><?php echo $resultBNEWS[0]['newstitle']; ?></h4>
                                    <p style="font-size: 14px; margin-top:5px"><?php echo date_format(new DateTime($resultBNEWS[0]['date_published']), "l - F d, Y h:i A"); ?>
                                        <span style="margin: 0 10px;">|</span><i class="fa-regular fa-eye">&nbsp;</i>
                                        <?php echo $newslist->getViewsOfSingleNews($resultBNEWS[0]['id']); ?>
                                    </p>
                                </div>
                                <img class="img-breakingnews" src="<?php echo $resultBNEWS[0]['image']; ?>" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <h5 style="margin-bottom:15px">Featured News</h5>
                        <div class="container-fluid featured-news-container" style="overflow-x:hidden;overflow-y:auto;">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php foreach ($featurednews as $news) { ?>
                                        <div class="row featured-news-item">
                                            <div class="col-5">
                                                <a href="pages/site/newsview.php?active=true&id=<?php echo $news['id']; ?>&title=<?php echo $news['newstitle']; ?>" class="cc">
                                                    <img class="img-fluid side-img" src="<?php echo $news['image'] != "" ? $news['image'] : "assets/newsassets/logo.jpg"; ?>" alt="">
                                                </a>
                                            </div>
                                            <div class="col-7">
                                                <a href="pages/site/newsview.php?active=true&id=<?php echo $news['id']; ?>&title=<?php echo $news['newstitle']; ?>" class="cc">
                                                    <div>
                                                        <p class="category-othernews">
                                                            <?php echo strtoupper($news['category']); ?>
                                                        </p>
                                                    </div>
                                                    <h6 class="featured-news-title"><?php echo $news['newstitle']; ?></h6>
                                                    <p><i class="fa-regular fa-eye">&nbsp;</i><?php echo $newslist->getViewsOfSingleNews($news['id']); ?></p>
                                                    <p><?php echo date_format(new DateTime($news['date_published']), "F d, Y"); ?></p>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </header>
    <br>
    <div class="margin-side">
        <div class="container-fluid">
            <div class="row">
                <h4 class="latest-header-title">
                    Latest news
                </h4>
                <div class="col-md-8" id="contents">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <?php foreach ($fourLatestNews as $latestnews) {
                                    array_push($excempted, $latestnews['id']); ?>
                                    <div class="col-md-6">
                                        <a href="pages/site/newsview.php?active=true&id=<?php echo $latestnews['id']; ?>&title=<?php echo $latestnews['newstitle']; ?>" class="cc">
                                            <div class="latest-news-item">
                                                <img class="img-fluid thumbnail" src="<?php echo $latestnews['image'] != "" ? $latestnews['image'] : "assets/newsassets/logo.jpg"; ?>" alt="" srcset="">
                                                <div class="latest-news-details">
                                                    <h6 class="latest-news-title"><?php echo $latestnews['newstitle']; ?></h6>
                                                    <p class="latest-news-author">By <?php echo $latestnews['fullname']; ?> <span style="margin: 0 10px;">|</span><i class="fa-regular fa-eye">&nbsp;</i><?php echo $newslist->getViewsOfSingleNews($latestnews['id']); ?></p>
                                                    <hr>
                                                    <p class="latest-news-date">Date posted: <?php echo date_format(new DateTime($latestnews['date_published']), "F d, Y h:i A"); ?></p>
                                                    <p class="category-latest"><?php echo $latestnews['category']; ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 style="margin-bottom:15px">Other News</h5>
                    <div class="row" id="others"  style="height:780px">
                        <div class="col-md-12">
                            <?php
                            foreach ($othernews as $news) {
                                if (in_array($news['id'], $excempted)) {
                                    continue;
                                }
                            ?>
                                <div class="row featured-news-item">
                                    <div class="col-5">
                                        <img class="side-img" src="<?php echo $news['image'] != "" ? $news['image'] : "assets/newsassets/logo.jpg"; ?>" alt="<?php echo $news['newstitle']; ?>">
                                    </div>
                                    <div class="col-7">
                                        <a href="pages/site/newsview.php?active=true&id=<?php echo $news['id']; ?>&title=<?php echo $news['newstitle']; ?>" class="cc">
                                            <div>
                                                <p class="category-othernews">
                                                    <?php echo strtoupper($news['category']); ?>
                                                </p>
                                            </div>
                                            <h6 class="featured-news-title"><?php echo $news['newstitle']; ?></h6>
                                            <p><i class="fa-regular fa-eye">&nbsp;</i><?php echo $newslist->getViewsOfSingleNews($news['id']); ?></p>
                                            <p><?php echo date_format(new DateTime($latestnews['date_published']), "F d, Y"); ?></p>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <header class="latest-news">
        <div class="margin-side">
            <h4 class="popular-header-title">
                Popular news
            </h4>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <?php foreach ($popularNews as $popular) {
                                $item = $newslist->getSingleNewsInfo($popular['newsid']); ?>
                                <div class="col-md-4">
                                    <a href="pages/site/newsview.php?active=true&id=<?php echo $item[0]['id']; ?>&title=<?php echo $item[0]['newstitle']; ?>" class="cc">

                                        <div class="left-single-latest-news">
                                            <p class="category-latest"><?php echo $item[0]['category']; ?></p>
                                            <img class="img-fluid thumbnail" src="<?php echo $item[0]['image'] != "" ? $item[0]['image'] : "assets/newsassets/logo.jpg"; ?>" alt="<?php echo $item[0]['newstitle']; ?>" srcset="">
                                            <div class="latest-news-info">
                                                <h6 class="popular-news-title"><?php echo $item[0]['newstitle']; ?></h6>
                                                <p class="popular-date">
                                                    <?php echo date_format(new DateTime($item[0]['date_published']), "F d, Y"); ?> <span style="margin: 0 10px;">|</span><i class="fa-regular fa-eye">&nbsp;</i>
                                                    <?php echo $popular['total']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <header class="footer">
        <div class="margin-side">
            <h1>GA<span>ZSE</span>NT</h1>

            <div class="container-fluid content">
                <div class="row">
                    <div class="col-md-4" style="display: grid; border-right:1px solid white">
                        <h5>Quick Links</h5>
                        <a href="">Home</a>
                        <a href="pages/site/news.php">News</a>
                        <a href="pages/site/featurednews.php">Featured News</a>
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
                                        echo '<div class="col-md-4"><a class="dropdown-item" href="pages/site/category.php?id=' . $item['id'] . '&title=' . $item['title'] . '">' . $item['title'] . '</a></div>';
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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // $("#others").height($("#contents").height() - 230);
            $("iframe").attr("width", "100%");
            $("video").attr("width", "100%");
            $("video").attr("height", "auto");
        });
    </script>
</body>

</html>