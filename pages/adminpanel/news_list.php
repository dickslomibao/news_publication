<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../site/login.php");
    return;
}
require_once 'validate_viewer.php';
require_once '../../classes/news_getter.php';

if(isset($_GET['unpublished'])){
    require_once '../../classes/news_class.php';
    $newsclass = new News;
    $newsclass->setId($_GET['newsid']);
    $newsclass->unpublishedNews();
    header("Location: news_list.php");
}
if(isset($_GET['breaking'])){
    require_once '../../classes/news_class.php';
    $newsclass = new News;
    $newsclass->setBreakingNews($_GET['newsid']);
    header("Location: news_list.php");
}
$newslist = new Newslist;
$news = $newslist->getAllPublishedNews();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Published news</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="../../css/body_configuration.css" rel="stylesheet">
    <link href="../../css/navbar.css" rel="stylesheet">
    <link href="../../css/index.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">

    <style>
        #myTable_length {
            margin-bottom: 20px;
        }

        .btn-success {
            font-size: 14px;
            padding: 4px 10px;
        }
    </style>
</head>

<body>
<?php require_once 'navbar.php';?>

    <br>
    <div class="margin-side">
        <h5 style="margin-bottom:20px">Published news</h4>
            <table class="table table-striped" id="myTable" border="1">
                <thead>
                    <tr>
                        <th width="400" scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Author</th>
                        <th scope="col">Date published</th>
                        <th scope="col">
                            <center>
                                Actions
                            </center>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news as $item) { ?>
                        <tr valign="middle">
                            <th><?php echo $item['newstitle'] ?></td>
                            <td><?php echo $item['category'] ?></td>
                            <td><?php echo $item['fullname'] ?></td>
                            <td><?php echo $item['date_published'] ?></td>
                            <td>
                                <div class="d-flex" style="align-items: center;justify-content:space-evenly">
                                    <a target="_blank" href="../site/newsview.php?active=false&id=<?php echo $item['id']; ?>&title=<?php echo $item['newstitle']; ?>&author=<?php echo $item['fullname']; ?>" class="btn btn-success">View</a>
                                    <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-gear"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="news_list.php?unpublished=true&newsid=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want unpublish the news?')">Unpublished</a></li>
                                        <li><a class="dropdown-item" href="news_list.php?breaking=true&newsid=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want set this as breaking news?')">Set as breaking news</a></li>
                                        <li><a class="dropdown-item" href="create_news.php?update=true&newsid=<?php echo $item['id'] ?>">Update</a></li>
                                        <li><a class="dropdown-item" href="deletenews.php?newsid=<?php echo $item['id'];?>">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
    </div>
    <?php require_once 'footer.php'?>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "order": [],
            });
        });
    </script>
</body>

</html>