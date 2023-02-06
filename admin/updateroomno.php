<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'admin')) {
    header("location: ./login.php");
    exit;
}
include '../includes/db/config.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid Entry.');
    window.location ='./dashboard.php';</script>";
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM `rooms` WHERE `id`=$id";
$res = $conn->query($sql);

while ($row = $res->fetch_assoc()) {
    $roomno = $row['roomno'];
    $seats = $row['seats'];
    $id = $row['id'];
}

$firstname = $_SESSION['firstname'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room | Admin Hostel Management</title>
    <link rel="stylesheet" href="../includes/css/bookroom.css" />
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Update Details
        </span>
        <p></p>
        <ul class="form-style">
            <h2 style="text-decoration: 1px dotted;">Update Details</h2>
            <p></p>
            <h2>Room Info</h2>
            <li><label>Room No <span class=" required">*</span></label><input id="roomno" type="text" name="roomno"
                    class="field-divided" placeholder="First" value="<?php echo $roomno; ?>"
                    onchange="updateMe(this)" />
                <input id="lastname" type="text" name="seats" class="field-divided" placeholder="Last"
                    value="<?php echo $seats; ?>" onchange="updateMe(this)" />
                <input id="idRoom" value="<?php echo $id; ?>" hidden />
            </li>

        </ul>

    </div>
    <script>
    function updateMe(obj) {
        if (obj.getAttribute('id') === 'roomno') {
            let roomid = document.getElementById("idRoom").value;
            let query = "UPDATE `rooms` SET `roomno`='" + obj.value + "'WHERE `id`=" + roomid;
            let formdata = new FormData();
            formdata.append("query", query);
            let postData = {
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'lastname') {
            let roomid = document.getElementById("idRoom").value;
            let query = "UPDATE `rooms` SET `seats`='" + obj.value + "'WHERE `id`=" + roomid;
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        }

    }
    </script>
</body>

</html>