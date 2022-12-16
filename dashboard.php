<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'student')) {
    header("location: ./login.php");
    exit;
}
if (isset($_SESSION['firstname'])) {
    $firstname = $_SESSION['firstname'];
} else {
    $firstname = "Hostel Management";
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
    <link rel="stylesheet" href="./includes/css/dashboard.css" />
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Dashboard
        </span>
        <div class="cards-">
            <div class="card">
                <div class="backgr">
                    <label>My Profile</label>
                </div>
                <div class="bottom">
                    <a href="./profile.php">Full Detail &DDotrahd;</a>
                </div>
            </div>

            <div class="card2">
                <div class="backgr">
                    <label>My Room</label>
                </div>
                <div class="bottom">
                    <a href="./bookroom.php">Full Detail &DDotrahd;</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>