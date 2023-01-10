<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
    $data = array("data" => "Auth Failed");
    print_r(json_encode($data));
    exit;
}

include './includes/db/config.php';

if (isset($_GET['room'])) {
    $roomno = $_GET['room'];
} else {
    $data = array("data" => "Invalid room no");
    print_r(json_encode($data));
    exit;
}

$sql = "select seats from rooms where roomno = '$roomno'";

$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
    $seats = $row['seats'];
}

$data = array("data" => $seats);
print_r(json_encode($data));

?>