<?php


session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../site/login.php");
    return;
}
require_once 'validate_viewer.php';
?>

<?php

require_once "../../classes/database.php";

$db = new Database;
$pdo = $db->getConnection();

if (isset($_POST['add-file'])) {
    $filename = $_FILES['assets']['name'];
    $type = pathinfo($_FILES['assets']['name'], PATHINFO_EXTENSION);
    $fullFileName = time() . $filename;
    if (move_uploaded_file($_FILES['assets']['tmp_name'], "../../assets/newsassets/" . $fullFileName)) {
        $sql = "INSERT INTO `assets`(`filename`, `filetype`) VALUES (?,?)";
        $stm = $pdo->prepare($sql);
        $stm->execute([
            $fullFileName,
            $type
        ]);
        header("Location: assets.php");
    }
}

$sql = "SELECT * FROM `assets` ORDER BY id DESC";
$statement = $pdo->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
function getLink()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    $url .= $_SERVER['HTTP_HOST'];
    return $url;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">
    <link href="../../css/body_configuration.css" rel="stylesheet">
    <link href="../../css/navbar.css" rel="stylesheet">
    <link href="../../css/category.css" rel="stylesheet">
</head>

<body>
    <?php require_once 'navbar.php'; ?>


    <div class="margin-side">
        <br>
        <div class="add-category-btn">
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Upload
            </button>
        </div>
        <table class="table table-striped" id="myTable" border="1">
            <thead>
                <tr>
                    <th scope="col">Filename</th>
                    <th scope="col">Filetype</th>
                    <th scope="col">
                        <center>
                            Actions
                        </center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $item) { ?>
                    <tr valign="middle">
                        <td width="600"><?php echo $item['filename'] ?></td>
                        <td><?php echo $item['filetype'] ?></td>
                        <td>
                            <center>
                                <a href="<?php echo getLink().'/3rdyear/newswebsite/assets/newsassets/'.$item['filename'] ?>" class="copylink btn btn-danger">Copy link</a>&nbsp;<a href="../../assets/newsassets/<?php echo $item['filename'] ?>" target="_target" class="btn btn-success">Preview</a>
                            </center>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add assets</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">File:</label>
                            <input type="file" name="assets" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add-file" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "order": [],
            });
            $(".copylink").click(function(event) {
                event.preventDefault();
                navigator.clipboard.writeText($(this).attr("href"));
            });
        });
    </script>
</body>

</html>