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
    while ($details = $res->fetch_assoc()) {
        $roomno = $details['roomno'];
        if ($details['foodoption'] == 0) {
            $foodstatus = "Without Food";
        } else {
            $foodstatus = "With Food";
        }
        $feespm = 2000;
        $date = $details['starting_date'];
        $duration = $details['duration'];
        // $gender = $details['gender'];
        $gname = $details['guardian_name'];
        $grel = $details['guardian_relation'];
        $gcontact = $details['guardian_contact'];
        $address = $details['address'];
        $status = $details['status'];

    }
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
            <?php echo $firstname; ?> &#62; Room Details
        </span>
        <p></p>
    </div>
    <div class="room-details">
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table id="zcb" class="table table-bordered  dataTable" cellspacing="5">
                        <tbody>

                            <tr>
                                <td colspan="4">
                                    <h4 style="text-decoration: 1px solid underline;">Room Realted Info</h4>
                                </td>
                                <!-- <td><a style="text-decoration: 1px dashed grey underline; font-weight: bold; color: grey;"
                                        href="javascript:void(0);" onclick="popUpWindow('');"
                                        title="View Full Details">Print Data</a></td> -->
                            </tr>
                            <tr>
                                <td colspan="1"><b>Reg no. :
                                        <?php echo $roll; ?>
                                    </b>
                                </td>
                                <td><b>Status :</b></td>
                                <td style="text-decoration: 1px double grey underline; font-weight: bold;">
                                    <!-- <i><b> -->
                                    <?php echo $status; ?>
                                    <!-- </b></i> -->
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
                                <td><b>Food Status:</b></td>
                                <td>
                                    <?php echo $foodstatus; ?>
                                </td>
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
                                    <h4 style="text-decoration: 1px solid underline;">Personal Info Info</h4>
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