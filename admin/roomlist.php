<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'admin')) {
    header("location: ./login.php");
    exit;
}
include '../includes/db/config.php';

if (isset($_SESSION['firstname']) && isset($_SESSION['email'])) {
    $firstname = $_SESSION['firstname'];
    $email = $_SESSION['email'];
    $lastname = $_SESSION['lastname'];
    $phone = $_SESSION['phone'];

} else {
    $firstname = "Hostel Management";
    $email = "guest@hostel.online";
}

$sql = "select * from rooms";
$res = $conn->query($sql);
$details = $res->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Hostel Management</title>
    <link rel="stylesheet" href="../includes/css/bookroom.css" />
    <link rel="stylesheet" href="../includes/css/dropdown.css" />
    <style>
        .button-add {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Room details
        </span>
        <p></p>
        <div class="button-add">
            <button id="add-room"
                style="background-color: green; color: white; font-size: 16px; padding: 10px 20px; border: none; cursor: pointer; right: 0;">Add
                Room</button>
        </div>
        <table class="roomtbl">
            <thead>
                <th style="text-align:center;">ID</th>
                <th style="text-align:center;">Room No</th>
                <th style="text-align:center;">Seats</th>
                <th style="text-align:center;">Action</th>
            </thead>
            <tbody>
                <?php foreach ($details as $room):
                    ?>
                    <tr>
                        <td style="text-align:center;">
                            <?php echo $room['id']; ?>
                        </td>
                        <td style="text-align:center;">
                            <?php echo $room['roomno']; ?>
                        </td>
                        <td style="text-align:center;">
                            <?php echo $room['seats']; ?>
                        </td>
                        <td style="text-align:center;">
                            <div class="dropdown">
                                <button class="dropbtn">Update</button>
                                <div class="dropdown-content">
                                    <a href="#" onclick="updateDetails(<?php echo $room['id']; ?>)">Update Details</a>
                                    <a href="#" onclick="deleteEntry(<?php echo $room['id']; ?>)">Delete Entry</a>
                                </div>
                            </div>

                        </td>


                    </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

        <?php include('./pops/add-rooms.php'); ?>
    </div>
    <script>
        const addRoom = document.getElementById('add-room');

        addRoom.addEventListener('click', () => {
            popup.classList.add('show');
        });

        function showPop(url) {
            document.getElementById('popup-body').innerHTML = "<iframe style='width: 100%; height:100%;'  src='" + url +
                "' frameborder='0'></iframe>";
            popup.classList.add('show');
        }

        function deleteEntry(id) {
            let query = "DELETE FROM `rooms` WHERE `id`=" + id;
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

        function updateDetails(roll) {
            window.location = "./updateroomno.php?id=" + roll;
        }
    </script>
</body>

</html>