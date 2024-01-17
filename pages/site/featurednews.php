<?php
require_once '../../classes/news_getter.php';
$newslist = new Newslist;
session_start();

$fourLatestNews = $newslist->getallForFeaturedNews();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured news</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="../../css/body_configuration.css" rel="stylesheet">
    <link href="../../css/navbar.css" rel="stylesheet">
    <link href="../../css/index.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">
    <style>
        #others {
            overflow: auto;

        }

        #others::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */

        }
    </style>
</head>

<body>
   <?php  require_once "nav.php"?>
    <div class="margin-side" style="margin-top: 0;">
        <div class="container-fluid">
            <div class="row">
                <h4 class="latest-header-title" style="margin: 40px 0;">
                    Featured news
                </h4>
                <div class="col-md-12" id="contents">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <?php foreach ($fourLatestNews as $latestnews) {
                                ?>
                                    <div class="col-md-4">
                                        <a href="pages/site/newsview.php?active=true&id=<?php echo $latestnews['id']; ?>&title=<?php echo $latestnews['newstitle']; ?>" class="cc">
                                            <div class="latest-news-item">
                                                <img class="img-fluid thumbnail" src="<?php echo $latestnews['image'] != "" ? $latestnews['image'] : "../../assets/newsassets/logo.jpg"; ?>" alt="" srcset="">
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

            </div>
        </div>
    </div>
    <?php  require_once 'footer.php'?>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#others").height($("#contents").height() - 100);
            $("iframe").attr("width", "100%");
            $("video").attr("width", "100%");
            $("video").attr("height", "auto");
        });
    </script>
</body>

</html>