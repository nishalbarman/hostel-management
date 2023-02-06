<?php

include './includes/db/config.php';

$roll = $_GET['roll'];

$sql = "SELECT * FROM `applied_rooms` WHERE roll_no=$roll";
$res = mysqli_query($conn, $sql);
$array = mysqli_fetch_all($res, MYSQLI_ASSOC);

print_r(json_encode($array));
exit();

?>