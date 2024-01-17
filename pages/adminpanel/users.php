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
require_once "../../classes/user_personal_info.php";

$user = new PersonalInformation();

$userlist = $user->getUsersAccountOnly();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Writers</title>
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
    <link href="../../css/view_writers.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">

</head>

<body>
    <?php require_once 'navbar.php'; ?>

    <br>
    <div class="margin-side">
        <table class="table table-striped" id="myTable" border="1">
            <thead>
                <tr>
                    <th scope="col">Full name</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Course</th>
                    <th scope="col">Username</th>
                    <th scope="col">
                        <center>
                            Actions
                        </center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userlist as $item) { ?>
                    <tr valign="middle">
                        <td><?php echo $item['firstname'] . " " . $item['lastname'] ?></td>
                        <td><?php echo $item['sex'] ?></td>
                        <td><?php echo $item['course'] ?></td>
                        <td><?php echo $item['username'] ?></td>
                        <td>
                            <center>
                                <?php if ($item['role'] === '5') { ?>
                                    <a href="restricter.php?user=true&restrict=false&id=<?php echo $item['id'] ?>" class="btn btn-danger">Unrestrict</a>
                                <?php } else { ?>
                                    <a href="restricter.php?user=true&restrict=true&id=<?php echo $item['id'] ?>" class="btn btn-danger">Restrict</a>
                                <?php } ?>

                            </center>
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