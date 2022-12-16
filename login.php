<?php

$err = '';

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location:home.php");
    exit;
}

include 'includes/db/config.php';

if (isset($_POST['login'])) {

    $roll = $_POST['roll'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM `students` where roll = '$roll'";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $hash_pass = $row['password'];
        }

        if (isset($hash_pass)) {
            if (password_verify($pass, $hash_pass)) {

                session_destroy();

                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION['role'] = 'student';
                $_SESSION['roll'] = $roll;

                $sql = "SELECT * FROM `students` where roll = '$roll'";
                $res = $conn->query($sql);
                if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        $_SESSION['firstname'] = $row['firstname'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['phone'] = $row['phone'];
                        $_SESSION['roll'] = $row['roll'];
                    }
                }

                echo "<script>alert('You have Logged');
                    window.location='./dashboard.php'</script>";
                exit;

            } else {
                $err = "Invalid password.";
            }
        } else {
            $err = "Invalid Roll No.";
        }
    } else {
        $err = "Invalid Roll No.";
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
    <div class="login">
        <h1>Login</h1>
        <div class="err">

            <span id="error-text"
                style="display: block; font-size: 15px; text-align: center; color: red; font-weight: bold; padding-left: 15px; padding-right: 15px;">

            </span>

        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <input type="text" name="roll" placeholder="Roll No" id="username" required>

            <input type="password" name="password" placeholder="Password" id="password" required>
            <div class="form-link">
                <span>Don't have an account? <a href="./signup.php" class="signup-link">Signup</a></span>
            </div>
            <input type="submit" name="login" value="Login">
        </form>
    </div>




</body>

</html>