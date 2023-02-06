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

$sql = "select * from bookings";
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
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Room details
        </span>
        <p></p>
        <table class="roomtbl">
            <thead>
                <th style="text-align:center;">ID</th>
                <th style="text-align:center;">Role No</th>
                <th style="text-align:center;">Full Name</th>
                <th style="text-align:center;">Room No</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Duration</th>
                <th style="text-align:center;">Starting Date</th>
                <th style="text-align:center;">Ending Date</th>
                <th style="text-align:center;">Preview</th>
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
                        <?php echo $room['roll']; ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo $room['firstname'] . " " . $room['lastname']; ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo $room['roomno']; ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo $room['status']; ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo $room['duration']; ?><span> Months</span>
                    </td>
                    <td style="text-align:center;">
                        <?php echo $room['starting_date']; ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo $room['end_date']; ?>
                    </td>
                    <td style="text-align:center;">
                        <a style="text-decoration: none; color: green;" href='#'
                            onclick="showPop('./roomde.php?roll=<?php echo $room['roll']; ?>')">Show</a>
                    </td>
                    <td style="text-align:center;">
                        <div class="dropdown">
                            <button class="dropbtn">Update</button>
                            <div class="dropdown-content">
                                <a href="#" onclick="markApproved(<?php echo $room['roll']; ?>)">Mark Approved</a>
                                <a href="#" onclick="updateDetails(<?php echo $room['roll']; ?>)">Update Details</a>
                                <a href="#" onclick="deleteEntry(<?php echo $room['roll']; ?>)">Delete Entry</a>
                            </div>
                        </div>

                    </td>


                </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

        <?php include('popup.html'); ?>
    </div>
    <script>
    function showPop(url) {
        document.getElementById('popup-body').innerHTML = "<iframe style='width: 100%; height:100%;'  src='" + url +
            "' frameborder='0'></iframe>";
        popup.classList.add('show');
    }

    function markApproved(roll) {
        let query = "UPDATE `bookings` SET `status`='Approved' WHERE `roll`=" + roll + ";";
        let query2 = "UPDATE `students` SET `booked`=0 WHERE `roll`=" + roll + ";";
        let formdata = new FormData();
        let formdata1 = new FormData();
        formdata.append("query", query);
        formdata1.append("query", query2);

        let postData = {
            method: "post",
            body: formdata,
        }

        fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
            fetch("./ajax-php/sql-query.php", postData1).then(res => res.json()).then(data => {
                alert(data.msg);
            });
        });
    }

    function deleteEntry(roll) {
        let query = "DELETE FROM `bookings` WHERE `roll`=" + roll + ";";
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
        window.location = "./updateroomdt.php?roll=" + roll;
    }
    </script>
</body>

</html>