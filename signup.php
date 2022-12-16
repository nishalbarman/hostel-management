<?php

$err = '';

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location:home.php");
    exit;
}

include 'includes/db/config.php';

if (isset($_POST['signup'])) {


    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $roll = $_POST['roll'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "select roll from students where roll = '$roll' OR email = '$email' OR phone = '$phone'";

    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        $err = "User already exist.";
    } else {
        $sql = "INSERT INTO `students` (`firstname`,`lastname`,`phone`,`email`,`roll`, `password`) VALUES('$fname','$lname','$phone','$email','$roll','$pass')";

        if ($conn->query($sql)) {
            echo "<script>alert('You have Registered');
            window.location='./login.php'</script>";
            exit;
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/css/login.css" />
    <title>Login</title>
    <script>
        function showErr() {
            let error = "<?php echo $err; ?>";
            if (error !== '') {
                const erText = document.getElementById("error-text");
                erText.innerHTML = error;
                erText.style.display = "block";
            }
        }
    </script>
</head>

<body onload="showErr()">
    <div class="login" id="SignForm">
        <h1>Sign Up</h1>
        <div class="err">

            <span id="error-text"
                style="display: none; font-size: 15px; text-align: center; color: red; font-weight: bold; padding-left: 15px; padding-right: 15px;"></span>

        </div>
        <form action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <input type="text" name="firstname" placeholder="First Name" id="firstname" required>

            <input type="text" name="lastname" placeholder="Last Name" id="lastname" required>

            <input type="text" name="roll" placeholder="Roll No" id="username" required>

            <input type="text" name="phone" placeholder="Phone No" id="phone" required>

            <input type="text" name="email" placeholder="Email" id="email" required>

            <input type="password" name="password" placeholder="Password" id="password" required>
            <div class="form-link">
                <span>Already have an account? <a href="./login.php" class="link signup-link">Login</a></span>
            </div>
            <input type="submit" name="signup" value="Sign Up">

        </form>
    </div>

    <div class="login" id="otpForm" style="display: none">
        <h1>Authenticate OTP</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="number" name="otpnumber" placeholder="######" id="otp" required>
            <div class="form-link">
                <span>Already have an account? <a href="./login.php" class="link signup-link">Login</a></span>
            </div>
            <input type="submit" value="Send OTP">

        </form>
    </div>




</body>

</html>