<?php
session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'admin')) {
    header("location: ./login.php");
    exit;
}
include '../includes/db/config.php';

if (isset($_POST['submit'])) {
    $image = time() . '_' . $_FILES['myfile']['name'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $stocks = $_POST['stocks'];
    $amount = $_POST['amount'];
    $destination = '../food-images/' . $image;
    $file = $_FILES['myfile']['tmp_name'];

    $extension = pathinfo($image, PATHINFO_EXTENSION);

    if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
        echo "You file extension must be .png, .jpg or .jpeg";
    } else {
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO `fooditems` (`title`, `subtitle`, `stocks`, `amount`, `reviews`, `total-feedbacks`, `image`, `category`) VALUES ('$title', '$subtitle', '$stocks', '$amount', '0', '0', '$image', 'none');";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Food Added.');</script>";
            }
        } else {
            echo "<script>alert('Failed to add.');</script>";
        }
    }
}

$firstname = $_SESSION['firstname'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="../includes/css/bookroom.css" />
    <title>Add Food Items</title>
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container" id="main">

        <span>
            <?php echo $firstname; ?> &#62; Add Food
        </span>
        <p></p>

        <div class="login">
            <form action="" method="post" enctype="multipart/form-data">
                <ul class="form-style">
                    <li>
                        <label for="title">Title</label>
                        <input class="field-long" type="text" id="title" name="title" placeholder="Title">
                    </li>
                    <li>
                        <label for="subtitle">Subtitle</label>
                        <textarea class="field-long" type="number" id="subtitle" name="subtitle"
                            placeholder="Maximum 104 chars" maxlength="104"></textarea>
                    </li>
                    <li>
                        <label>Choose Image</label>
                        <input class="field-long" class="file_up" type="file" name="myfile"> <br>
                    </li>

                    <li>
                        <label for="stocks">Stocks</label>
                        <input class="field-long" type="number" id="stocks" name="stocks" placeholder="Stocks">
                    </li>
                    <li>
                        <label for="amount">Amount</label>
                        <input class="field-long" type="number" id="amount" name="amount" placeholder="Price of Food">
                    </li>
                    <li>
                        <input class="field-long" type="submit" name="submit" value="Submit" />
                    </li>
                </ul>
            </form>
        </div>
        <br>
    </div>
</body>

</html>