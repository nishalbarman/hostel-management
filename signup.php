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
    <div class="login" id="signupForm">
        <h1>Sign Up</h1>
        <div class="err">

            <span id="error-text"
                style="display: none; font-size: 15px; text-align: center; color: red; font-weight: bold; padding-left: 15px; padding-right: 15px;"></span>

        </div>
        <form id="submitMe" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <input type="text" name="firstname" placeholder="First Name" id="firstname" required>

            <input type="text" name="lastname" placeholder="Last Name" id="lastname" required>

            <input type="text" name="roll" placeholder="Roll No" id="username" required>

            <input type="text" name="phone" placeholder="Phone No" id="phone" required>

            <input type="text" name="email" placeholder="Email" id="email" required>

            <input type="password" name="password" placeholder="Password" id="password" required>
            <div class="form-link">
                <span>Already have an account? <a href="./login.php" class="link signup-link">Login</a></span>
            </div>
            <input type="hidden" name="signup">
            <!-- <input type="submit" name="signup" value="Sign Up" onclick="submitForm()"> -->

        </form>
        <button class="button" onclick="submitForm()">Sign Up"</button>
        <!-- <input type="submit" name="signup" value="Sign Up"> -->
    </div>

    <div class="login" id="otpForm" style="display: none">
        <h1>Authenticate OTP</h1>
        <span id="otp-text"
            style="display: none; font-size: 15px; text-align: center; color: green; font-weight: bold; padding-left: 15px; padding-right: 15px;"></span>
        <form onsubmit="return false">
            <input type="number" name="otpnumber" placeholder="######" id="otp" required>
            <div class="form-link">
                <span>Already have an account? <a href="./login.php" class="link signup-link">Login</a></span>
            </div>
            <input type="submit" value="Send OTP" onclick="validateOtp()">

        </form>
    </div>

    <script>
        const mainForm = document.getElementById("signupForm");
        const submitMe = document.getElementById("submitMe");
        const otpText = document.getElementById("otp-text");
        const otpForm = document.getElementById("otpForm");
        let hd;
        function submitForm() {
            mainForm.style.display = "none";
            otpForm.style.display = "block";
            otpText.innerHTML = "Preparing, please wait..";
            otpText.style.display = 'block';
            let email = document.getElementById("email").value;
            // otp = Math.floor(Math.random() * (99999 - 10000 + 1)) + 10000
            // console.log(hd);
            fetch('./send.php?email=' + email).then(res => res.json()).then(data => {
                // console.log(data);
                if (data.status == 1) {
                    hd = data.kht;
                    console.log(hd);
                    otpText.innerHTML = "OTP has been sent on email";
                } else {
                    otpText.innerHTML = "Some error occured, click on Resend";
                }
            });
        }

        function validateOtp() {
            let inputOtp = document.getElementById("otp").value;
            if (inputOtp == hd) {
                submitMe.submit();
            } else {
                alert("Invalid OTP.");
            }
        }


    </script>


</body>

</html>