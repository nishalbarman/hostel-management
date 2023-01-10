<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'admin')) {
    header("location: ./login.php");
    exit;
}
if (isset($_SESSION['firstname']) && isset($_SESSION['email'])) {
    $firstname = $_SESSION['firstname'];
    $email = $_SESSION['email'];
    $roll = $_SESSION['roll'];
} else {
    $firstname = "Hostel Management";
    $email = "guest@hostel.online";
}

include './includes/db/config.php';

if (isset($_POST['submit'])) {
    $form_fname = $_POST['fname'];
    $form_lname = $_POST['lname'];
    $form_phone = $_POST['phone'];
    // $form_email = $_POST['email'];
    // $form_roll = $_POST['roll'];
    $form_gender = $_POST['gender'];

    if ($form_gender === '--- Select ---') {
        echo "<script>alert('Please select gender');</script>";
    } else {
        $sql = "UPDATE students SET `firstname` = '$form_fname', `lastname` = '$form_lname', `phone` = '$form_phone', `gender` = '$form_gender' WHERE email = '$email'";
        if ($conn->query($sql)) {
            $_SESSION['firstname'] = $form_fname;
            echo "<script>alert('Profile Updated');</script></script>";

        }
    }

}

$sql = "select * from students where email = '$email'";
$res = $conn->query($sql);

while ($row = $res->fetch_assoc()) {
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $phone = $row['phone'];
    $roll = $row['roll'];
    $gender = $row['gender'];
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Hostel Management</title>
    <link rel="stylesheet" href="./includes/css/profile.css" />
</head>

<body>
    <?php include 'header.html'; ?>
    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Profile
        </span>
        <p></p>
        <form action="" method="post" enctype="application/x-www-form-urlencoded">
            <ul class="form-style">
                <li><label>Full Name <span class="required">*</span></label><input type="text" class="field-divided"
                        placeholder="First" value="<?php echo $firstname; ?>" name="fname" /> <input type="text"
                        name="lname" class="field-divided" placeholder="Last" value="<?php echo $lastname; ?>" /></li>
                <li>
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" class="field-long" placeholder="" value="<?php echo $email; ?>"
                        disabled />
                </li>
                <li>
                    <label>Phone <span class="required">*</span></label>
                    <input type="number" name="phone" class="field-long" placeholder="" value="<?php echo $phone; ?>" />
                </li>
                <li>
                    <label>Roll No <span class="required">*</span></label>
                    <input type="email" name="roll" class="field-long" placeholder="" value="<?php echo $roll; ?>"
                        disabled />
                </li>

                <li>
                    <label>Gender <span class="required">*</span></label>
                    <select name="gender" class="field-select">
                        <option value="<?php if ($gender === '') {
                            echo '--- Select ---';
                        } else {
                            echo $gender;
                        } ?>">
                            <?php if ($gender === '') {
                                echo '--- Select ---';
                            } else {
                                echo $gender . ' (Default)';
                            } ?>
                        </option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </li>
                <li>
                    <input type="submit" value="Submit" name="submit" />
                </li>
            </ul>
        </form>
    </div>
    </div>
</body>

</html>