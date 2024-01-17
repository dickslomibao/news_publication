<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../site/login.php");
    return;
}
require_once 'validate_viewer.php';
?>

<?php
require_once "../../classes/category_class.php";
require_once "../../classes/news_class.php";
require_once "../../classes/writers_list_getter.php";
require_once "../../classes/news_getter.php";
$category = new Category;
$categoryList = $category->getCategoryList();
date_default_timezone_set('Asia/Manila');


if (isset($_GET['newsid'])) {
    $savenews = new Newslist;
    $unpublished = $savenews->getSingleOnlySaveNews($_GET['newsid']);
}
if (isset($_POST['add'])) {
    $news = new News;
    $writers = new Writers;
    $author = $writers->getSingleWriterInfo($_SESSION['username']);
    $news->setId(uniqid() . time());
    $news->setAuthor($author[0]['owner_id']);
    $news->setTitle($_POST['title']);
    $news->setCategory($_POST['category']);
    $news->setContent($_POST['content']);
    $news->setBreaking($_POST['breaking']);
    $news->seFeatured($_POST['featured']);
    $news->setImage($_POST['image']);
    if ($_POST['add'] === 'add') {
        $news->setStatus(1);
        $news->setDate(date("Y-m-d H:i:s"));
    } else
        $news->setStatus(0);

    $news->insert();
    echo '200';
    exit();
}

if (isset($_POST['update'])) {
    $news = new News;
    if ($_POST['update'] == 'save') {
        $news->setId($_POST['id']);
        $news->setTitle($_POST['title']);
        $news->setCategory($_POST['category']);
        $news->setContent($_POST['content']);
        $news->setImage($_POST['image']);
        $news->updateSaveNews();
        echo '200';
    } else {
        $news->setId($_POST['id']);
        $news->setTitle($_POST['title']);
        $news->setCategory($_POST['category']);
        $news->setContent($_POST['content']);
        $news->setBreaking($_POST['breaking']);
        $news->seFeatured($_POST['featured']);
        $news->setImage($_POST['image']);
        $news->setStatus(1);
        $news->setDate(date("Y-m-d H:i:s"));
        $news->updateSaveNewsAndPublished();
        echo '200';
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a news</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="../../js/richtexteditor/rte_theme_default.css" />
    <!-- <link href="../../css/body_configuration.css" rel="stylesheet"> -->
    <link href="../../css/navbar.css" rel="stylesheet">
    <link href="../../css/index.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        body{
            font-family: 'Roboto', sans-serif;

        }
        .label-input {
            margin: 10px 0 10px 0;
        }

        .margin-side {
            max-width: 1100px;
            margin: auto;
        }

        body .config ul,p{
            margin: 0;
            padding: 0;
          
        }

        .title-page {
            text-align: center;
            margin: 30px 0 30px 0;
        }

        .btn {
            width: 100%;
        }

        .note-dropdown-menu {
            overflow: auto;
            height: 200px;
        }

        iframe {
            width: 100%;
        }

        .note-group-select-from-files {
            display: none;
        }
        .note-modal-footer{
            height:60px;
            padding: 10px;
        }
        .note-modal-header{
            background-color: #002366 !important;
            opacity: 1 !important;
            
        }
        .note-modal-header h4{
            color: white;
        }
        .note-modal-footer input{
           background-color: #002366 !important;
           opacity: 1 !important;
           padding: 10px 0 !important;
        }
        .btn-success{
            background-color: #002366
        }
    </style>
</head>

<body>
    <?php require_once 'navbar.php'; ?>

    <div class="margin-side">
       
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <h4 class="title-page">Create a news</h4>
                    <br>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo  isset($unpublished) ? '<input type="hidden" class="form-control" value="' . $unpublished[0]['id'] . '" id="newsid">' : ""; ?>

                                    <label class="label-input" for="">Title:</label>
                                    <input required type="text" class="form-control" value="<?php echo isset($unpublished) ?  $unpublished[0]['title'] : ""; ?>" id="title">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-input" for="">Category:</label>
                                    <select class="form-control" id="category">
                                        <?php foreach ($categoryList as $value) { ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label-input" for="">Thumbnail as link:</label>
                                    <input required type="link" class="form-control" value="<?php echo isset($unpublished) ?  $unpublished[0]['image'] : ""; ?>" id="image">
                                </div>
                            </div>
                        </div>
                        <label class="label-input" for="" class="texteditor-label">Content:</label>
                        <div id="summernote">
                        </div>
                        <br>
                        <div class="row justify-content-end">
                            <div class="col-md-2">
                                <button class="btn btn-success" id="save">Save</button>
                            </div>
                            <!-- <?php if (!isset($_GET['update'])) { ?>
                                <div class="col-md-2">
                                    <button class="btn btn-success" id="openmodal">Publish</button>
                                </div>
                            <?php } ?> -->
                        </div>
                    </div>
                </div>
            </div>
       
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Other news details:</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="breaking">
                        <label class="form-check-label" for="flexCheckDefault">
                            Set as breaking news
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="featured">
                        <label class="form-check-label" for="flexCheckDefault">
                            Set as featured news
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="add" name="add-category" class="btn btn-primary">Publish</button>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php'?>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $("iframe").width("100%");
            $("#category").val(`<?php echo isset($unpublished) ?  $unpublished[0]['category'] : "29"; ?>`);
        });
        const fontList = [];
        for (let index = 0; index <= 149; index++) {
            fontList[index] = (index + 1).toString();
        }
        $('#summernote').summernote({
            blockquoteBreakingLevel: 2,
            disableDragAndDrop: true,
            placeholder: 'Type news content here...',
            tabsize: 2,
            height: 500,
            fontSizes: fontList,
            toolbar: [
                ['style', ['style']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['height', ['height']]
            ]
        });
        $('#summernote').summernote('code', $.parseHTML(`<?php echo isset($unpublished) ?  $unpublished[0]['description'] : ''; ?>`));
    </script>
    <script src="../../js/createnews.js"></script>
</body>

</html>