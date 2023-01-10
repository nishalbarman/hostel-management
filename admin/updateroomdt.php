<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'admin')) {
    header("location: ./login.php");
    exit;
}
include '../includes/db/config.php';

if (!isset($_GET['roll'])) {
    echo "<script>alert('Invalid Entry.');
    window.location ='./dashboard.php';</script>";
    exit;
}

$roll = $_GET['roll'];

$sql = "SELECT * FROM `bookings` WHERE `id`='$roll'";
$res = $conn->query($sql);

while ($row = $res->fetch_assoc()) {
    $roomno = $row['roomno'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $phone = $row['phone'];
    $guardianname = $row['guardian_name'];
    $grel = $row['guardian_relation'];
    $gcontact = $row['guardian_contact'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $pincode = $row['pincode'];
    $status = $row['status'];
    $paid = $row['paid'];
    $active = $row['active'];
    $starting_date = $row['starting_date'];
    $duration = $row['duration'];
    $email = $row['email'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room | Admin Hostel Management</title>
    <link rel="stylesheet" href="../includes/css/bookroom.css" />
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Update Details
        </span>
        <p></p>
        <!-- <form action="" method="post" enctype="application/x-www-form-urlencoded"> -->
        <ul class="form-style">
            <h2 style="text-decoration: 1px dotted;">Update Details</h2>
            <p></p>
            <!-- <li>
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
                </li> -->

            <li>
                <label>Starting Date</label>
                <input type="date" name="date" class="field-long" value="<?php echo $starting_date; ?>"
                    onchange="updateMe(this)" id="starting-date" />
            </li>


            <li>
                <label>Duration (In Months)</label>
                <select name="duration" class="field-select" onchange="updateMe(this)" id="duration">
                    <option value="<?php echo $duration; ?>">
                        <?php echo $duration; ?>
                    </option>
                    <?php for ($i = 1; $i <= 12; $i++):
                        ?>

                    <option value="<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </option>

                    <?php endfor; ?>

                </select>
            </li>

            <h2>Personal Info</h2>
            <li><label>Full Name <span class=" required">*</span></label><input id="firstname" type="text" name="field1"
                    class="field-divided" placeholder="First" value="<?php echo $firstname; ?>"
                    onchange="updateMe(this)" />
                <input id="lastname" type="text" name="field2" class="field-divided" placeholder="Last"
                    value="<?php echo $lastname; ?>" onchange="updateMe(this)" />
            </li>
            <li>
                <label>Email</label>
                <input type="email" name="email" class="field-long" value="<?php echo $email; ?>" disabled />
            </li>

            <li>
                <label>Guardian Name</label>
                <input type="text" name="gname" class="field-long" value="<?php echo $guardianname; ?>"
                    onchange="updateMe(this)" id="gname" />
            </li>

            <li>
                <label>Guardian Relation</label>
                <input type="text" name="grelation" class="field-long" value="<?php echo $grel; ?>"
                    onchange="updateMe(this)" id="grelation" />
            </li>

            <li>
                <label>Guardian Contact</label>
                <input type="text" name="gcontact" class="field-long" value="<?php echo $gcontact; ?>"
                    onchange="updateMe(this)" id="gcontact" />
            </li>



            <h2>Correspondense Address </h2>
            <li>
                <label>Address</label>
                <textarea name="address" id="address" class="field-long field-textarea" value="<?php echo $address; ?>"
                    onchange="updateMe(this)"><?php echo $address; ?></textarea>
            </li>

            <li>
                <label>City</label>
                <input type="text" name="city" class="field-long" value="<?php echo $city; ?>" onchange="updateMe(this)"
                    id="city" />
            </li>

            <li>
                <label>State</label>
                <input type="text" name="state" class="field-long" value="<?php echo $state; ?>"
                    onchange="updateMe(this)" id="state" />
            </li>

            <li>
                <label>Pin Code</label>
                <input type="number" name="pincode" class="field-long" value="<?php echo $pincode; ?>"
                    onchange="updateMe(this)" id="pincode" />
            </li>

            <!-- <li>
                    <input id="sbtn" type="submit" value="Submit" name="rsubmit" />
                </li> -->
        </ul>
        <!-- </form> -->

    </div>
    <script>
    function updateMe(obj) {

        if (obj.getAttribute('id') === 'starting-date') {
            let query = "UPDATE `bookings` SET `starting_date`='" + obj.value + "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);
            formdata.append("date", obj.value);
            formdata.append("duration", document.getElementById('duration').value);
            formdata.append("endate", "true");

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
                // console.log(data);
            })

        } else if (obj.getAttribute('id') === 'duration') {
            let query = "UPDATE `bookings` SET `duration`='" + obj.options[obj.selectedIndex].text +
                "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);
            formdata.append("date", document.getElementById('starting-date').value);
            formdata.append("duration", obj.value);
            formdata.append("endate", "true");

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'firstname') {
            let query = "UPDATE `bookings` SET `firstname`='" + obj.value + "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'lastname') {
            let query = "UPDATE `bookings` SET `lastname`='" + obj.value + "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'gname') {
            let query = "UPDATE `bookings` SET `guardian_name`='" + obj.value + "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'grelation') {
            let query = "UPDATE `bookings` SET `guardian_relation`='" + obj.value +
                "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'gcontact') {
            let query = "UPDATE `bookings` SET `guardian_contact`='" + obj.value +
                "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'address') {
            let query = "UPDATE `bookings` SET `address`='" + obj.value + "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'city') {
            let query = "UPDATE `bookings` SET `city`='" + obj.value + "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'state') {
            let query = "UPDATE `bookings` SET `state`='" + obj.value + "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        } else if (obj.getAttribute('id') === 'pincode') {
            let query = "UPDATE `bookings` SET `pincode`='" + obj.value + "'WHERE `id`='<?php echo $roll; ?>'";
            let formdata = new FormData();
            formdata.append("query", query);

            let postData = {
                // headers: {
                //     "content-Type": "multipart/form-data",
                // },
                method: "post",
                body: formdata,
            }

            fetch("./ajax-php/sql-query.php", postData).then(res => res.json()).then(data => {
                alert(data.msg);
            })

        }

    }
    </script>
</body>

</html>