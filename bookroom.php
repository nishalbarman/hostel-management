<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'student')) {
    header("location: ./login.php");
    exit;
}
include './includes/db/config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Hostel Management</title>
    <link rel="stylesheet" href="./includes/css/bookroom.css" />
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container">

    </div>
</body>

</html>