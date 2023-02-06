<?php include 'header.html';
include '../config/db.php';

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$sql = "SELECT * FROM foodcategory";
$res = $conn->query($sql);
$category = $res->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $image = time() . '_' . $_FILES['myfile']['name'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $stocks = $_POST['stocks'];
    $amount = $_POST['amount'];
    $cat = $_POST['category'];

    $destination = '../food-images/' . $image;
    $file = $_FILES['myfile']['tmp_name'];

    $extension = pathinfo($image, PATHINFO_EXTENSION);

    if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
        echo "You file extension must be .png, .jpg or .jpeg";
    } else {
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO `fooditems` (`title`, `subtitle`, `stocks`, `amount`, `reviews`, `total-feedbacks`, `image`, `category`) VALUES ('$title', '$subtitle', '$stocks', '$amount', '0', '0', '$image', '$cat');";

            $sql2 = "SELECT * FROM foodcategory WHERE catname = '$cat'";

            $res = $conn->query($sql2);

            while ($row = $res->fetch_assoc()) {
                $items = $row['items'];
            }

            $items = $items + 1;

            $sql2 = "UPDATE `foodcategory` SET `items`='$items'";
            $res = $conn->query($sql2);

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Food Added.');</script>";
            }
        } else {
            echo "<script>alert('Failed to add.');</script>";
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
            </b>Add Food Items</h1>
        <div class="login">
            <form action="" method="post" enctype="multipart/form-data">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="Title">

                <label for="subtitle">Subtitle</label><br>
                <textarea type="number" id="subtitle" name="subtitle" placeholder="Maximum 104 chars"
                    maxlength="104"></textarea>

                <label>Choose Image</label>
                <input class="file_up" type="file" name="myfile"> <br>

                <label for="category">Category</label>
                <select id="category" name="category">
                    <?php foreach ($category as $item): ?>
                        <option value="<?php echo $item['catname']; ?>">
                            <?php echo $item['catname']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="stocks">Stocks</label>
                <input type="number" id="stocks" name="stocks" placeholder="Stocks">

                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" placeholder="Price of Food">

                <input type="submit" name="submit" value="Submit" />
            </form>
        </div>
        <br>
    </div>
</body>

</html>