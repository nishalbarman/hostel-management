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
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
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

        $tableName = $_POST['roll'] . "_" . mt_rand(100000, 999999) . "_" . $roomno . "_repayment";
        $tableName = str_replace(" ", "_", $tableName);

        $sql = "INSERT INTO `bookings`(`roll`, `firstname`, `lastname`, `phone`, `email`, `roomno`,  `starting_date`, `end_date`, `duration`, `guardian_name`, `guardian_contact`, `guardian_relation`, `city`, `state`, `pincode`, `status`, `paid`, `address`, `active`) VALUES ('$roll', '$fname', '$lname', '$phone', '$email', '$roomno',  '$date', '$end_date', '$duration', '$gname', '$gcontact', '$grel', '$city', '$state', '$pincode', 'Under Review', 0, '$address', 1)";

        $sql2 = "UPDATE `students` SET `booked`='1' where `roll` = '$roll'";

        $roomseats = $roomseats - 1;
        $sql3 = "UPDATE `rooms` SET `seats`='$roomseats'  where `roomno` = '$roomno'";

        $createTable = "CREATE TABLE `" . $tableName . "` (
            `id` int(255) NOT NULL,
            `payment_id` int(255) NOT NULL,
            `roll` int(255) NOT NULL,
            `amount` float NOT NULL,
            `roomno` text NOT NULL,
            `status` text NOT NULL DEFAULT 'Unpaid'
          )";

        $rollNo = $_POST['roll'];
        $appliedRoom = "INSERT INTO `applied_rooms` (`roll_no`, `room_table_name`, `room_no`) VALUES($rollNo, '$tableName', '$roomno')";

        if ($conn->query($sql) && $conn->query($sql2) && $conn->query($sql3) && $conn->query($appliedRoom) && $conn->query($createTable)) {
            // $_SESSION['booked'] = 1;
            for ($index = 1; $index <= $duration; $index++) {
                $sqlQuery = "INSERT INTO `" . $tableName . "` (`id`, `payment_id`, `roll`, `amount`, `roomno`, `status`) VALUES($index, $index, $rollNo, 2000, '$roomno', 'Unpaid');";
                $result22 = mysqli_query($conn, $sqlQuery);
            }
            echo "<script>alert('Room Booked and is under review.');
                        window.location = './occrooms.php';
            </script>";
        }
    } else {
        echo "<script>alert('No seats available for the selected no.');</script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room | Hostel Management</title>
    <link rel="stylesheet" href="../includes/css/bookroom.css" />
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Book Room
        </span>
        <p></p>
        <form action="" method="post" enctype="application/x-www-form-urlencoded">
            <ul class="form-style">
                <h2style="text-decoration: 1px solid underline;">Room Info</h2style=>
                    <li>
                        <label>Room No. <span class="required">* <span id="noseat"></span></span></label>
                        <select id="sel" name="roomno" class="field-select">
                            <option value="">Select Room</option>
                            <?php
                            foreach ($rooms as $rno):
                                ?>

                            <option value="<?php echo $rno['roomno']; ?>">
                                <?php echo $rno['roomno']; ?>
                            </option>

                            <?php endforeach; ?>

                        </select>
                    </li>

                    <!-- <li>
                        <label>Food Options <span class=" required">*</span></label>
                                <div class="filed-radio">
                                    <input type="radio" name="food_op" class="field-divided" value="0" /><span>Without
                                        Food</span>
                                    <input type="radio" name="food_op" class="field-divided" value="1" /><span>With Food
                                        (Extra
                                        Rs.
                                        1000 / Month)</span>
                                </div>

                    </li> -->

                    <li>
                        <label>Roll No <span class="required">*</span></label>
                        <input type="number" name="roll" class="field-long" required />
                    </li>

                    <li>
                        <label>Date <span class="required">*</span></label>
                        <input type="date" name="date" class="field-long" required />
                    </li>


                    <li>
                        <label>Duration (In Months)<span class="required">*</span></label>
                        <select name="duration" class="field-select">
                            <option value="">Select Duration</option>
                            <?php for ($i = 1; $i <= 12; $i++):
                                ?>

                            <option value="<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </option>

                            <?php endfor; ?>

                        </select>
                    </li>

                    <h2>Personal Info</h2>
                    <li><label>Full Name <span class=" required">*</span></label><input type="text" name="firstname"
                            class="field-divided" placeholder="First" value="" />
                        <input type="text" name="lastname" class="field-divided" placeholder="Last" value="" />
                    </li>
                    <li>
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" class="field-long" value="" />
                    </li>

                    <li>
                        <label>Guardian Contact <span class="required">*</span></label>
                        <input type="text" name="phone" class="field-long" required />
                    </li>

                    <li>
                        <label>Guardian Name <span class="required">*</span></label>
                        <input type="text" name="gname" class="field-long" required />
                    </li>

                    <li>
                        <label>Guardian Relation <span class="required">*</span></label>
                        <input type="text" name="grelation" class="field-long" required />
                    </li>

                    <li>
                        <label>Guardian Contact <span class="required">*</span></label>
                        <input type="text" name="gcontact" class="field-long" required />
                    </li>



                    <h2>Correspondense Address </h2>
                    <li>
                        <label>Your Address <span class="required">*</span></label>
                        <textarea name="address" id="field5" class="field-long field-textarea" required></textarea>
                    </li>

                    <li>
                        <label>City <span class="required">*</span></label>
                        <input type="text" name="city" class="field-long" required />
                    </li>

                    <li>
                        <label>State <span class="required">*</span></label>
                        <input type="text" name="state" class="field-long" required />
                    </li>

                    <li>
                        <label>Pin Code <span class="required">*</span></label>
                        <input type="number" name="pincode" class="field-long" required />
                    </li>

                    <li>
                        <input id="sbtn" type="submit" value="Submit" name="rsubmit" />
                    </li>
            </ul>
        </form>

    </div>
    <script>
    const selection = document.getElementById("sel");
    const noseat = document.getElementById("noseat");

    selection.addEventListener('change', () => {
        let roomno = selection.value;
        console.log(roomno);
        fetch("../check.php?room=" + roomno).then(res => res.json()).then(data => {
            console.log(data);
            noseat.innerHTML = "Available seats " + data.data;
            noseat.style.display = "block";

            if (data.data <= 0) {
                document.getElementById("sbtn").setAttribute('disabled', 'true');
            }
        })
    });
    </script>
</body>

</html>