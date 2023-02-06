<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'admin')) {
    header("location: ./login.php");
    exit;
}
if (isset($_SESSION['firstname'])) {
    $firstname = $_SESSION['firstname'];
} else {
    $firstname = "Hostel Management";
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu | Hostel Management</title>
    <link rel="stylesheet" href="../includes/css/food-menu.css" />
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Dashboard
        </span>
        <div class="foodings">

            <?php
            include '../includes/db/config.php';

            $sql = "SELECT * FROM `fooditems`";
            $res = $conn->query($sql);

            $foods = $res->fetch_all(MYSQLI_ASSOC);
            foreach ($foods as $items): ?>

                <div class="food-card">
                    <img src="<?php echo '../food-images/' . $items['image']; ?>" alt="Food Item" class="food-card-image">
                    <div class="food-card-text">
                        <h2 class="food-card-title">
                            <?php echo $items['title']; ?>
                        </h2>
                        <p class="food-card-description">
                            <?php echo $items['subtitle']; ?>
                        </p>
                        <p class="food-card-price">
                            <?php echo "Rs. " . $items['amount'] . "/-"; ?>
                        </p>
                        <p class="food-card-text">
                            <a href="updatefood.php?id=<?php echo $items['id']; ?>">Update</a>
                        </p>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>