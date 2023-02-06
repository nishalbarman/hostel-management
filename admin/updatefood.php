<?php include 'header.html';
include '../config/db.php';

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$idd = $_GET['id'];

$sql = "select * from fooditems where id = '$idd'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $old_image = $row['image'];
    $title = $row['title'];
    $subtitle = $row['subtitle'];
    $stocks = $row['stocks'];
    $amount = $row['amount'];
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];

    if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['name'] !== '') {
        $image = time() . '_' . $_FILES['myfile']['name'];
        $file = $_FILES['myfile']['tmp_name'];
        $destination = '../food-images/' . $image;
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $move = 1;
    } else {
        $move = 0;
    }
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $stocks = $_POST['stocks'];
    $amount = $_POST['amount'];

    if ($move === 1) {
        if (!in_array($extension, ['png', 'jpg', 'jpeg', 'webp'])) {
            echo "You file extension must be .png, .jpg, .webp or .jpeg";
        } else {
            if (move_uploaded_file($file, $destination)) {
                if (!$old_image) {
                    unlink("../food-images/" . $old_image);
                }
                $sql = "UPDATE `fooditems` SET `title`='$title',`subtitle`='$subtitle',`stocks`='$stocks',`amount`='$amount',`image`='$image' WHERE id = '$id'";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Food Updated.');</script>";
                } else {
                    echo "<script>alert('Failed to update.');</script>";
                }
            } else {
                echo "<script>alert('Failed to update.');</script>";
            }
        }
    } else {
        $sql = "UPDATE `fooditems` SET `title`='$title',`subtitle`='$subtitle',`stocks`='$stocks',`amount`='$amount' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Food Updated.');</script>";
        } else {
            echo "<script>alert('Failed to update.');</script>";
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="adminstyles/addfood.css">
    <title>Add Food Items</title>
</head>

<body>
    <div class="content" id="main">
        <h1 class="my-5"><b>
            </b>Update Food</h1>
        <div class="login">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?php echo $idd; ?>">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="Title" value="<?php echo $title; ?>">

                <label for="subtitle">Subtitle</label><br>
                <textarea type="number" id="subtitle" name="subtitle"
                    placeholder="Subtitle"><?php echo $subtitle; ?></textarea>

                <label>Choose Image (Optional)</label>
                <input class="file_up" type="file" name="myfile"> <br>

                <label for="stocks">Stocks</label>
                <input type="number" id="stocks" name="stocks" placeholder="Stocks" value="<?php echo $stocks; ?>">

                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" placeholder="Price of Food"
                    value="<?php echo $amount; ?>">

                <input type="submit" name="submit" value="Submit" />
            </form>
        </div>
        <br>
    </div>
</body>

</html>