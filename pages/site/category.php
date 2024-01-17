<?php
require_once '../../classes/news_getter.php';
$newslist = new Newslist;
session_start();


if (!isset($_GET['id']) || !isset($_GET['title'])) {
    header("Location: ../../");
    return;
}

if ($_GET['id'] == "" || $_GET['title'] == "") {
    header("Location: ../../");
    return;
}


$searchResult = $newslist->getNewsOfCategory($_GET['id'],0);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_GET['title']; ?></title>
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
        .search{
            text-align: center;
            padding-top: 50px;
            height: 250px;
        }
    </style>
</head>

<body>
    <?php require_once "nav.php";?>
    <div class="margin-side" style="margin-top: 0;">
        <div class="container-fluid">
            <div class="row">
                <h4 class="latest-header-title" style="margin: 40px 0;">
                    <?php echo  $_GET['title'] .": " .count($searchResult);?>
                </h4>
                <div class="col-md-12" id="contents">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                
                                <?php
                                    if(count($searchResult) == 0){
                                        echo "<h5 class='search'>No Result.</h5>";
                                    }
                                foreach ($searchResult as $search) {
                                ?>
                                    <div class="col-md-4">
                                        <a href="newsview.php?active=true&id=<?php echo $search['id']; ?>&title=<?php echo $search['newstitle']; ?>" class="cc">
                                            <div class="latest-news-item">
                                                <img class="img-fluid thumbnail" src="<?php echo $search['image'] != "" ? $search['image'] : "../../assets/newsassets/logo.jpg"; ?>" alt="" srcset="">
                                                <div class="latest-news-details">
                                                    <h6 class="latest-news-title"><?php echo $search['newstitle']; ?></h6>
                                                    <p class="latest-news-author">By <?php echo $search['fullname']; ?> <span style="margin: 0 10px;">|</span><i class="fa-regular fa-eye">&nbsp;</i><?php echo $newslist->getViewsOfSingleNews($search['id']); ?></p>
                                                    <hr>
                                                    <p class="latest-news-date">Date posted: <?php echo date_format(new DateTime($search['date_published']), "F d, Y h:i A"); ?></p>
                                                    <p class="category-latest"><?php echo $search['category']; ?></p>
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
    <?php require_once 'footer.php' ?>
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