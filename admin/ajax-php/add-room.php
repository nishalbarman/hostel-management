<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'admin')) {
    header("location: ./login.php");
    exit;
}
include '../includes/db/config.php';

$firstname = $_SESSION['firstname'];

$sql = "SELECT * FROM rooms";
$res = $conn->query($sql);
$rooms = $res->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['rsubmit'])) {
    $roomno = $_POST['roomno'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $duration = $_POST['duration'];
    $gname = $_POST['gname'];
    $grel = $_POST['grelation'];
    $gcontact = $_POST['gcontact'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $phone = $_POST['phone'];
    $roll = $_POST['roll'];
    $end_date = date('Y-m-d', strtotime($date . ' + 3 months'));

    $sql = "select * from rooms";
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) {
        $roomseats = $row['seats'];
    }

    if ($roomseats > 0) {
        $sql = "INSERT INTO `bookings`(`roll`, `firstname`, `lastname`, `phone`, `email`, `roomno`,  `starting_date`, `end_date`, `duration`, `guardian_name`, `guardian_contact`, `guardian_relation`, `city`, `state`, `pincode`, `status`, `paid`, `address`, `active`) VALUES ('$roll', '$firstname', '$lastname', '$phone', '$email', '$roomno',  '$date', '$end_date', '$duration', '$gname', '$gcontact', '$grel', '$city', '$state', '$pincode', 'Under Review', 0, '$address', 1)";

        $sql2 = "UPDATE `students` SET `booked`='1' where `roll` = '$roll'";

        $roomseats = $roomseats - 1;
        $sql3 = "UPDATE `rooms` SET `seats`='$roomseats'  where `roomno` = '$roomno'";

        if ($conn->query($sql) && $conn->query($sql2) && $conn->query($sql3)) {
            $_SESSION['booked'] = 1;
            echo "<script>alert('Room Booked and is under review.');
                        window.location = './roomdetails.php';
            </script>";
        }
    } else {
        echo "<script>alert('No seats available for the selected no.');</script>";
    }

}

?>