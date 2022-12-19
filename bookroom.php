<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'student')) {
    header("location: ./login.php");
    exit;
}
include './includes/db/config.php';

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$phone = $_SESSION['phone'];
$email = $_SESSION['email'];
$roll = $_SESSION['roll'];
$booked = $_SESSION['booked'];

if (isset($booked)) {
    if ($booked == 1) {
        echo "<script>alert('Room Already Booked.');
        window.location = './roomdetails.php';</script>";
        exit;
    }
}


$sql = "SELECT * FROM rooms";
$res = $conn->query($sql);
$rooms = $res->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['rsubmit'])) {
    $roomno = $_POST['roomno'];
    $foodoption = $_POST['food_op'];
    $date = $_POST['date'];
    $duration = $_POST['duration'];
    $gname = $_POST['gname'];
    $grel = $_POST['grelation'];
    $gcontact = $_POST['gcontact'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];

    $sql = "select * from rooms";
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) {
        $roomseats = $row['seats'];
    }

    if ($roomseats > 0) {
        $sql = "INSERT INTO `bookings`(`roll`, `firstname`, `lastname`, `phone`, `email`, `roomno`, `foodoption`, `starting_date`, `duration`, `guardian_name`, `guardian_contact`, `guardian_relation`, `city`, `state`, `pincode`, `status`, `paid`, `address`) VALUES ('$roll', '$firstname', '$lastname', '$phone', '$email', '$roomno', '$foodoption', '$date', '$duration', '$gname', '$gcontact', '$grel', '$city', '$state', '$pincode', 'Under Review', 0, '$address')";

        $sql2 = "UPDATE `students` SET `booked`='1'";

        $roomseats = $roomseats - 1;
        $sql3 = "UPDATE `rooms` SET `seats`='$roomseats'";

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room | Hostel Management</title>
    <link rel="stylesheet" href="./includes/css/bookroom.css" />
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

                    <li>
                        <label>Food Options <span class="required">*</span></label>
                        <div class="filed-radio">
                            <input type="radio" name="food_op" class="field-divided" value="0" /><span>Without
                                Food</span>
                            <input type="radio" name="food_op" class="field-divided" value="1" /><span>With Food (Extra
                                Rs.
                                1000 / Month)</span>
                        </div>

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
                    <li><label>Full Name <span class="required">*</span></label><input type="text" name="field1"
                            class="field-divided" placeholder="First" value="<?php echo $firstname; ?>" disabled />
                        <input type="text" name="field2" class="field-divided" placeholder="Last"
                            value="<?php echo $lastname; ?>" disabled />
                    </li>
                    <li>
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" class="field-long" value="<?php echo $email; ?>" disabled />
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
            fetch("check.php?room=" + roomno).then(res => res.json()).then(data => {
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