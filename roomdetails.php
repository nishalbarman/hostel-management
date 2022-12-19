<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'student')) {
    header("location: ./login.php");
    exit;
}
include './includes/db/config.php';

if (isset($_SESSION['firstname']) && isset($_SESSION['email'])) {
    $firstname = $_SESSION['firstname'];
    $email = $_SESSION['email'];
    $roll = $_SESSION['roll'];
    $lastname = $_SESSION['lastname'];
    $phone = $_SESSION['phone'];
    $booked = $_SESSION['booked'];

} else {
    $firstname = "Hostel Management";
    $email = "guest@hostel.online";
}

if ($booked == 1) {
    $sql = "select * from bookings where roll = '$roll'";
    $res = $conn->query($sql);
    $details = $res->fetch_all(MYSQLI_ASSOC);
} else {
    echo "<script>alert('No room has been booked yet. Book a room now.');
    window.location = './bookroom.php'</script>";
}


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
        <span>
            <?php echo $firstname; ?> &#62; Room details
        </span>
        <p></p>
        <table class="roomtbl">
            <thead>
                <th style="text-align:center;">Room No</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Duration</th>
                <th style="text-align:center;">Starting Date</th>
                <th style="text-align:center;">Open</th>
            </thead>
            <tbody>
                <?php foreach ($details as $room):
                ?>
                <tr>
                    <td style="text-align:center;width: 25%;">
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
                        <a href='./roomde.php?roll=<?php echo $roll; ?>'>Show</a>
                    </td>


                </tr>

                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</body>

</html>