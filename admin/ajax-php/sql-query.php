<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] !== 'admin') {
    header("location: logout.php");
    exit;
}

include '../../includes/db/config.php';

$err = "";

$query = $_POST['query'];

if (isset($_POST['endate']) && $_POST['endate'] === "true") {
    $duration = $_POST['duration'];
    $date = $_POST['date'];

    $ending_date = date('Y-m-d', strtotime($date . ' + ' . $duration . ' months'));

    $query1 = "UPDATE `bookings` SET `end_date`='$ending_date'";
    if ($conn->query($query1)) {

    } else {
        $err = "Error Updation";
    }
}

if ($conn->query($query)) {
    if ($err === '') {
        $data = array("success" => true, "msg" => "Record Updated.");
        print_r(json_encode($data));
        exit;
    } else {
        $data = array("success" => false, "msg" => "Record Updation Failed.");
        print_r(json_encode($data));
        exit;
    }
} else {
    $data = array("success" => false, "msg" => "Record Updation Failed.");
    print_r(json_encode($data));
    exit;
}



?>