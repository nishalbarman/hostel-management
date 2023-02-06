<?php


include './includes/db/config.php';

$value = $_GET['room'];

$sql = "SELECT * FROM " . $value . ";";
$res = mysqli_query($conn, $sql);
$total_num = mysqli_num_rows($res);

$sql = "SELECT * FROM " . $value . " WHERE status='Paid'";
$res = mysqli_query($conn, $sql);
$num = mysqli_num_rows($res);

$sql = "SELECT `amount` FROM " . $value . " limit 1";
$res = mysqli_query($conn, $sql);
$amount = mysqli_fetch_assoc($res);
// $array = mysqli_fetch_all($res, MYSQLI_ASSOC);

if ($total_num === $num) {
    print_r(json_encode(array("totalpaid" => "true", "result" => $num, "amount" => $amount['amount'])));
    exit;
}

print_r(json_encode(array("result" => $num, "amount" => $amount['amount'])));
exit;

?>