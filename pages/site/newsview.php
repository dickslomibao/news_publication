<?php
session_start();
require_once "../../classes/database.php";
require_once "../../classes/news_getter.php";
require_once "../../classes/comment_class.php";
$db = new Database;
$newslist = new Newslist;
$comment = new Comment;
$pdo = $db->getConnection();
$newsid = $_GET['id'];
$sql = "SELECT news.id, news.title as newstitle, news.category as catid, news.description, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_published, news.image FROM `news`,categories,personal_information where personal_information.id = news.author_id AND categories.id = news.category and news.id = ?";
$statement = $pdo->prepare($sql);
$statement->execute([
    $newsid
]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['comment'])) {
    $id = "cuid" . uniqid() . time();
    $newsid = $_POST['newsid'];
    $content = $_POST['content'];
    try {
        date_default_timezone_set('Asia/Manila');
        $comment = new Comment;
        $comment->initialize([
            $id,
            $_SESSION['id'],
            $newsid,
            $content,
            date("Y-m-d H:i:s")
        ]);
        $comment->insert();
        header("Location: " . getLink() . "&#$id");
    } catch (\Throwable $th) {
        //throw $th;
    }
}
//insert views
if (isset($_GET['active']) && $_GET['active']) {;
    $sql = 'INSERT INTO `views`(`newsid`) VALUES (?)';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        $newsid
    ]);
} else {
    header("Location: ../../");
}

$newListCategory = $newslist->getNewsOfCategory($result[0]['catid'], $newsid);

function getLink()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    $url .= $_SERVER['HTTP_HOST'];

    $url .= $_SERVER['REQUEST_URI'];
    return $url;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $result[0]['newstitle']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap');
    </style>
    <link href="../../css/body_configuration.css" rel="stylesheet">
    <link href="../../css/navbar.css" rel="stylesheet">
    <link href="../../css/news_view.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">
    <meta property="og:url" content="<?php echo urlencode(getLink()); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $result[0]['newstitle'] ?>" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="<?php echo $result[0]['image'] == "" ? "http://3.112.250.6/newswebsite/assets/newsassets/logo.jpg" : $result[0]['image'] ?>" />
</head>

<body>
    <?php require_once "nav.php" ?>
    <br>
    <div class="margin-side">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div>
                        <a href="" class="category"><?php echo $result[0]['category'] ?></a>
                    </div>
                    <h1 class="news-title"><?php echo $result[0]['newstitle'] ?></h1>
                    <h5 class="news-author">By <?php echo ($result[0]['fullname']) . ' | ' . date_format(new DateTime($result[0]['date_published']), "l - F d, Y h:i A"); ?> </h5>
                    <div id="fb-root"></div>
                    <script>
                        (function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>

                    <!-- Your share button code -->
                    <div class="fb-share-button" data-href="<?php echo urlencode(getLink()); ?>" data-layout="button_count">
                    </div>
                    <br>
                    <br>
                    <hr>
                    <br>

                </div>
                <div class="col-md-8" id="contents">
                    <?php echo rtrim($result[0]['description']); ?>
                    <hr style="margin: 40px 0 20px 0;">
                </div>
                <div class="col-md-4">
                    <h5 class="header-title">Related News</h5>
                    <div class="row">
                        <?php foreach ($newListCategory as $item) { ?>
                            <div class="col-md-12">
                                <div class="container-related-news">
                                    <h6 class="related-news-title">
                                        <a href="newsview.php?active=true&id=<?php echo $item['id']; ?>&title=<?php echo $item['newstitle']; ?>"><?php echo $item['newstitle']; ?></a>
                                    </h6>
                                    <p><?php echo date_format(new DateTime($item['date_published']), "F d, Y h:i A"); ?> </p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="container-fluid">
            <h5 class="c-title">Comments:</h5>
            <div class="row">
                <div class="col-md-8">

                    <?php $commentResult = $comment->display($_GET['id'], isset($_GET['limit']) ? $_GET['limit'] : 5);
                    if (count($commentResult) > 0) { ?>
                        <?php foreach ($commentResult as $data) { ?>
                            <div class="comment-content" id="<?php echo $data['id']; ?>">
                                <h6><?php echo $data['firstname'] . " " . $data['lastname']; ?></h6>
                                <p class="course"><?php echo $data['course']; ?></p>
                                <p><?php echo $data['content']; ?></p>
                                <p class="date"><?php echo $data['date']; ?></p>
                                <?php if (isset($_SESSION['id']) && $_SESSION['id'] === $data['owner_id'] && $_SESSION['role'] !== '5') { ?>
                                    <div class="dropdown">
                                        <p class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </p>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="editcomment.php?id=<?php echo $data['id'] . "&link=" . urlencode(getLink()); ?>">Edit</a></li>
                                            <li><a class="dropdown-item" href="deletecomment.php?id=<?php echo $data['id'] . "&link=" . urlencode(getLink()); ?>">Delete</a></li>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p class="nocomments">No comments...</p>
                    <?php } ?>
                    <div class="comment-form" id="comment">
                        <h5>Leave a comment</h5>
                        <?php if (isset($_SESSION['username'])) {
                            if ($_SESSION['role'] === '5') {
                                echo "<p>Restricted users are not allowed to leave a comment.</p>";
                            } else { ?>
                                <form action="" method="POST">
                                    <input class="form-control" name="newsid" type="hidden" value="<?php echo $_GET['id'] ?>">
                                    <textarea class="form-control" style="padding:15px;" name="content" placeholder="Enter your comment..." cols="200" rows="5"></textarea>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input class="btn btn-success" name="comment" type="submit" value="Post Comment">
                                        </div>
                                    </div>
                                </form>
                        <?php }
                        } else {
                            echo '<a href="login.php?redirect=' . urlencode(getLink()) . '"class="nocomments">Login to post a comment.</a>';
                        } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php require_once 'footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $("iframe").attr("width", "100%");
            $("video").attr("width", "100%");
            $("video").attr("height", "auto");
        });
    </script>
</body>

</html>