<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'admin')) {
    header("location: ./login.php");
    exit;
}
include '../includes/db/config.php';

$roll = $_GET['roll'];

$sql = "select * from bookings where roll = '$roll'";
$res = $conn->query($sql);
while ($details = $res->fetch_assoc()) {
    $firstname = $details['firstname'];
    $lastname = $details['lastname'];

    // $firstname = $fname . " " . $lname;

    $roomno = $details['roomno'];
    $feespm = 2000;
    $date = $details['starting_date'];
    $duration = $details['duration'];
    $phone = $details['phone'];
    $email = $details['email'];
    // $gender = $details['gender'];
    $gname = $details['guardian_name'];
    $grel = $details['guardian_relation'];
    $gcontact = $details['guardian_contact'];
    $address = $details['address'];
    $status = $details['status'];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Hostel Management</title>
    <link rel="stylesheet" href="../includes/css/bookroom.css" />
</head>

<body>
    <div class="room-details">
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table id="zcb" class="table table-bordered  dataTable" cellspacing="5">
                        <tbody>

                            <!-- <tr> -->
                            <!-- <td><a style="text-decoration: 1px dashed grey underline; font-weight: bold; color: grey;"
                                    href="javascript:void(0);" onclick="popUpWindow('');"
                                    title="View Full Details">Print Data</a></td> -->
                            <!-- </tr> -->
                            <tr>
                                <td colspan="1"><b>Reg no. :
                                        <?php echo $roll; ?>
                                    </b>
                                </td>
                                <td><b>Status :</b></td>
                                <td style="text-decoration: 2px dotted grey underline; font-weight: bold;">
                                    <?php echo $status; ?>
                                </td>

                            </tr>
                            <tr>
                                <td style="height: 15px;"><b></b></td>
                            </tr>

                            <tr>
                                <td><b>Room no :</b></td>
                                <td>
                                    <?php echo $roomno; ?>
                                </td>

                                <td><b>Fees PM :</b></td>
                                <td>
                                    <?php echo $feespm; ?>
                                </td>
                                <td><b>Duration:</b></td>
                                <td>
                                    <?php echo $duration . " Months"; ?>
                                </td>
                            </tr>

                            <tr>
                                <td><b>Stay From :</b></td>
                                <td>
                                    <?php echo $date; ?>
                                </td>
                                <td colspan="6"><b>Total Fee :
                                        <?php echo $feespm * $duration; ?>
                                    </b></td>
                            </tr>


                            <tr>
                                <td colspan="6">
                                    <h3 style="text-decoration: 1px solid underline;">Personal Info</h3>
                                </td>
                            </tr>

                            <tr>
                                <td><b>Roll No. :</b></td>
                                <td>
                                    <?php echo $roll; ?>
                                </td>
                                <td><b>Full Name :</b></td>
                                <td>
                                    <?php echo $firstname . ' ' . $lastname; ?>
                                </td>
                                <td><b>Email :</b></td>
                                <td>
                                    <?php echo $email; ?>
                                </td>
                            </tr>


                            <tr>
                                <td><b>Contact No. :</b></td>
                                <td>
                                    <?php echo $phone; ?>
                                </td>
                                <td><b>Gender :</b></td>
                                <td>
                                    <?php echo "Male"; ?>
                                </td>

                            </tr>


                            <tr>
                                <td><b>Guardian Name :</b></td>
                                <td>
                                    <?php echo $gname; ?>
                                </td>
                                <td><b>Guardian Relation :</b></td>
                                <td>
                                    <?php echo $grel; ?>
                                </td>
                                <td><b>Guardian Contact No. :</b></td>
                                <td colspan="6">
                                    <?php echo $gcontact; ?>
                                </td>
                            </tr>


                            <tr>
                                <td><b>Correspondense Address</b></td>
                                <td colspan="2">
                                    <?php echo $address; ?>
                                </td>
                                <td><b>Permanent Address</b></td>
                                <td colspan="2">
                                    <?php echo $address; ?>

                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    </div>

</body>

</html>