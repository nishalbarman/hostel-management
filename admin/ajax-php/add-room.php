<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] !== 'admin') {
    header("location: logout.php");
    exit;
}

include '../../includes/db/config.php';

$err = "";

if (isset($_POST['roomno']) && isset($_POST['seatno'])) {
    $roomno = $_POST['roomno'];
    $seatno = $_POST['seatno'];

    $query = "INSERT INTO `rooms` (`roomno`, `seats`) VALUES($roomno, $seatno)";
    if ($conn->query($query)) {
        print_r(json_encode(array("msg" => "Room Added")));
        exit;
    } else {
        print_r(json_encode(array("msg" => "Room Addition Failed")));
        exit;
    }
}