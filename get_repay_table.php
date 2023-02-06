<?php


include './includes/db/config.php';

$tablename = $_GET['table'];

$sql = "SELECT * FROM " . $tablename . ";";
$res = mysqli_query($conn, $sql);

$array = mysqli_fetch_all($res, MYSQLI_ASSOC);


print_r(json_encode($array));

exit;

?>