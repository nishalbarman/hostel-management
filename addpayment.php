<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'student')) {
    header("location: ./login.php");
    exit;
}
include './includes/db/config.php';

function GetSQLValueString($value)
{
    return $value;
}


$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$email = $_SESSION['email'];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["submit"]))) {
    $paymentId = $_POST['paymentId'];
    $rollNo = ($_SESSION['roll']);
    $firstName = ($_POST['fName']);
    $lastName = ($_POST['lName']);
    $amount = ($_POST['amount']);
    $email = ($_POST['email']);
    $tableName = $_POST['loanType'];
    $insertSQL = sprintf(
        "INSERT INTO payment (payment_id, roll_no, fName, lName, amount, email, room_no) VALUES ($paymentId,$rollNo, '$firstName', '$lastName', $amount, '$email', '$tableName')",
    );

    $Result1 = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
    $pyId = $_POST['paymentId'];
    $sqlQuery = "UPDATE " . $tableName . " SET `status`='Paid' WHERE `id`=$pyId";
    $res = mysqli_query($conn, $sqlQuery);

    $insertGoTo = "addpayment.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    echo "<script>alert('Payment added successfully.'); window.location='" . $insertGoto . "'</script>";
    // header(sprintf("Location: %s", $insertGoTo));
}

$memberId = $_SESSION['roll'];
$sql = "SELECT * FROM payment WHERE `roll_no`=$memberId";
$res = mysqli_query($conn, $sql);
$payments_count = mysqli_num_rows($res);

?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Payment</title>
<link rel="stylesheet" href="./includes/css/bookroom.css" />

</head>
<body>
    <?php include 'header.html'; ?>




    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Add Payment
        </span>
        <form name="form" method="POST" class="form" action="<?php echo $editFormAction; ?>">
            <ul class="form-style">
                <h2 style="text-decoration: 1px solid underline;">Add Payment</h2>
                <li>
                    <label>Select RoomNo <span class="required">*</span></label>
                    <?php
                        $sql = "select `room_no`, `room_table_name` from `applied_rooms` where `roll_no`=$memberId";
                        $response = mysqli_query($conn, $sql);
                        $response = mysqli_fetch_all($response, MYSQLI_ASSOC);
                        ?>
                    <select class="field-long" id="loantypeSel" name="loanType" onchange="selectionFunction(this)">
                        <option>Choose</option>
                        <?php if (!empty($response)) {
                                foreach ($response as $sel): ?>
                        <option value="<?php echo $sel["room_table_name"]; ?>">
                            <?php echo $sel["room_no"]; ?>
                        </option>
                        <?php endforeach;
                            } ?>
                    </select>
                </li>
                <div id="paymentForm">
                    <li>
                        <label>Role No: <span class="required">*</span></label>
                        <input type="text" placeholder="Enter Member id" pattern="[0-9]*" name="memberId"
                            value="<?php echo $memberId; ?>" maxlength="20" disabled class="field-long" required />
                    </li>


                    <h2>Personal Info</h2>
                    <li><label>Full Name <span class=" required">*</span></label>
                        <input type="text" name="fName" class="field-divided" placeholder="First"
                            value="<?php echo $firstname; ?>" readonly />
                        <input type="text" name="lName" class="field-divided" placeholder="Last"
                            value="<?php echo $lastname; ?>" readonly />
                    </li>

                    <li>
                        <label>Amount: <span class="required">*</span></label>
                        <input id="amountField" class="field-long" type="number" placeholder="Enter amount"
                            name="amount" maxlength="20" step="any" min="0" value="" readonly required>
                    </li>

                    <li>
                        <label>Email address <span class="required">*</span></label>
                        <input type="text" name="email" class="field-long" value="<?php echo $email; ?>" required
                            readonly />
                    </li>

                    <li id="pymnt" style="display: none;">
                        <label>Payment Id: <span class="required">*</span></label>
                        <div id="pyidDiv">

                        </div>
                    </li>

                    <li>
                        <input id="sbtn" type="submit" value="Add Payment" name="submit" />
                    </li>
                </div>
            </ul>
        </form>
    </div>



    <script>
    function selectionFunction(target) {
        let value = target.value;
        console.log(target.value);
        fetch("getid.php?room=" + value).then(res => res.json()).then(data => {
            console.log(data);
            if (data.totalpaid === "true") {
                document.getElementById("paymentForm").innerHTML =
                    "<h2 style='text-align: center; color: red;'>No Payment Dues, kindly refresh.</h2>";
            }
            document.getElementById("pymnt").style.display = "";
            const container = document.getElementById('pyidDiv');

            const input = document.createElement("input");
            input.type = "text";
            input.value = data.result + 1;
            input.setAttribute("name", "paymentId");
            input.setAttribute("class", "field-long");
            input.setAttribute("readonly", "true");
            input.setAttribute("value", data.result + 1)
            container.appendChild(input);

            document.getElementById("amountField").value = data.amount;

        });

    }
    </script>

    <script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
    </script>


</body>
</html>