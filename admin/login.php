<?php

$err = '';

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION['role'] === 1) {
        header("location: ./dashboard.php");
        exit;
    }
}

include '../includes/db/config.php';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM `admin` where email = '$email'";
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
                $_SESSION['role'] = 'admin';

                $sql = "SELECT * FROM `admin` where email = '$email'";
                $res = $conn->query($sql);
                if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        $_SESSION['firstname'] = $row['firstname'];
                        $_SESSION['lastname'] = $row['lastname'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['phone'] = $row['phone'];
                    }
                }

                echo "<script>alert('You have Logged');
                window.location='./dashboard.php';</script>";
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
    <link rel="stylesheet" href="../includes/css/login.css" />
    <link rel="stylesheet" href="../includes/css/captcha.css" />
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
        <h1 id="main-title">Admin Login</h1>
        <div class="err">

            <span id="error-text"
                style="display: block; font-size: 15px; text-align: center; color: red; font-weight: bold; padding-left: 15px; padding-right: 15px;">

            </span>

        </div>
        <div id="part1">
            <form id="form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <input type="email" name="email" placeholder="email@hms.com" id="username" edit-me>
                <input type="hidden" name="login" hidden>
                <input type="password" name="password" placeholder="Password" id="password" edit-me>
                <!-- <div class="form-link">
                    <span>Don't have an account? <a href="./signup.php" class="signup-link">Signup</a></span>
                </div> -->
            </form>
            <input id="loginBtn" class="buttonStyle" type="submit" name="login" value="Login">
        </div>
        <div id="part2" style="display: none;">
            <div class="captcha-container">
                <div class="captcha-question">What is <span class="captcha-number">
                        <?php $_SESSION['first'] = rand(1, 9);
                        echo $_SESSION['first']; ?>
                    </span> +
                    <span class="captcha-number">
                        <?php $_SESSION['second'] = rand(1, 9);
                        echo $_SESSION['second']; ?>
                    </span>?
                </div>
                <input type="number" class="captcha-input" id="captcha-value" edit-me-c>
            </div>
            <input id="captchaBtn" class="buttonStyle" type="submit" name="verify" value="Verify">
        </div>
    </div>

    <script>
        const loginBtn = document.getElementById('loginBtn');
        loginBtn.addEventListener('click', () => {
            document.querySelectorAll('[edit-me]').forEach(element => {

                if (element.value === "") {
                    alert("Roll No and Password both are Required Bro! Kya kar raha hain tu??");
                    return;
                } else {
                    document.getElementById('part1').style.display = "none";
                    document.getElementById('part2').style.display = "block";
                    document.getElementById('main-title').textContent = "Solve this Captcha";
                }
            });
        });

        captchaBtn.addEventListener('click', () => {
            document.querySelectorAll('[edit-me-c]').forEach(element => {

                if (element.value === "") {
                    alert("Robot hai kya tu, Captcha to daal BHAII!!");
                    return;
                } else {
                    let num1 = '<?php echo $_SESSION['first']; ?>';
                    let num2 = '<?php echo $_SESSION['second']; ?>';
                    let third = parseInt(num1) + parseInt(num2);
                    console.log(third);
                    console.log(element.value);
                    if (parseInt(element.value) === third) {
                        document.getElementById('form-data').submit();
                    } else {
                        alert("BHAII tu robot lagta hain, Captcha galat hai reee...");
                    }
                }
            });
        });
    </script>
</body>

</html>