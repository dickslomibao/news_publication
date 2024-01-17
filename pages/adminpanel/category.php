<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../site/login.php");
    return;
}
if ($_SESSION['role'] !== '1') {
    header("Location: dashboard.php");
    return;
}
?>
<?php

require_once "../../classes/category_class.php";

$category = new Category;
if (isset($_POST['add-category'])) {
    $category->setTitle($_POST['title']);
    $category->setDesc($_POST['desc']);
    $category->insert();
    header("Location: category.php");
}

if(isset($_POST['update-category'])){
    $category->update(array(
        $_POST['title'],
        $_POST['desc'],
        $_POST['id']
    ));
    header("Location: category.php");
}
if (isset($_GET['delete'])) {
    $category->setId($_GET['delete']);
    $category->delete();
    header("Location: category.php");
}
$category_list = $category->getCategoryList();
if(isset($_GET['edit']) and isset($_GET['id'])) {
    $singleCategory = $category->getSingleCategory($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="../../css/body_configuration.css" rel="stylesheet">
    <link href="../../css/navbar.css" rel="stylesheet">
    <link href="../../css/category.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">

</head>

<body>
    <?php require_once 'navbar.php'; ?>
    <div class="margin-side">
        <br>
        <div class="add-category-btn">
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Category
            </button>
        </div>
        <table class="table table-striped" id="myTable" border="1">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Descriptions</th>
                    <th scope="col">
                        <center>
                            Actions
                        </center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($category_list as $item) { ?>
                    <tr valign="middle">
                        <td><?php echo $item['id'] ?></td>
                        <th><?php echo $item['title'] ?></td>
                        <td><?php echo $item['description'] ?></td>
                        <td>
                            <center>
                                <a href="category.php?edit=true&id=<?php echo $item['id'] ?>" class="btn btn-success">Edit</a> <a href="category.php?delete=<?php echo $item['id'] ?>" class="btn btn-danger">Delete</a>
                            </center>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <input type="hidden" value = "<?php echo (isset($singleCategory) and (!empty($singleCategory))) ? $singleCategory[0]['id']: '';?>" name="id" class="form-control" id="exampleFormControlInput1" placeholder="Title..." required>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Title:</label>
                            <input type="text" value = "<?php echo (isset($singleCategory) and (!empty($singleCategory))) ? $singleCategory[0]['title']: '';?>" name="title" class="form-control" id="exampleFormControlInput1" placeholder="Title..." required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2" class="form-label">Descriptions:</label>
                            <input type="text" value = "<?php echo (isset($singleCategory) and (!empty($singleCategory))) ? $singleCategory[0]['description']: '';?>" name="desc" class="form-control" id="exampleFormControlInput2" placeholder="Descriptions..." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update-category" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Title:</label>
                            <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="Title..." required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2" class="form-label">Descriptions:</label>
                            <input type="text" name="desc" class="form-control" id="exampleFormControlInput2" placeholder="Descriptions..." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add-category" class="btn btn-primary">Add</button>
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
            <?php if(isset($singleCategory) and (!empty($singleCategory))) {?>
                $('#myModal').modal('show');
            <?php }?>
            $('#myTable').DataTable({
                "order": [],
            });
        });
    </script>
</body>

</html>
<?php $category->closeConnection(); ?>