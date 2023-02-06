<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'admin')) {
    header("location: ./login.php");
    exit;
}
include '../includes/db/config.php';

$firstname = $_SESSION['firstname'];

function GetSQLValueString($value)
{
    return $value;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["submit"]))) {
    $paymentId = $_POST['paymentId'];
    $rollNo = ($_POST['roll']);
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

?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Payment</title>
<link rel="stylesheet" href="../includes/css/bookroom.css" />
</head>
<body>
    <?php include "header.html"; ?>


    <div class="container">
        <!-- <h3 class="llTl">Add payment</h3> -->
        <form name="form" method="POST" class="form" action="<?php echo $editFormAction; ?>">
            <ul class="form-style">
                <h2 style="text-decoration: 1px solid underline;">Add Payment</h2>
                <li style=" text-align: left;">
                    <label for="memberId"><b>Rolle No:</b></label>
                    <input class="field-long" type="text" placeholder="Enter Roll" pattern="[0-9]*" name="roll" value=""
                        maxlength="20" onchange="populateLoan(this)">
                </li>
                <li></li>
                <li id="selectionContaner" style="text-align: left; display: none;">
                    <label for="paymentId"><b>Select Loan:</b></label>
                    <div id="cont">

                    </div>

                </li>
                <div id="paymentForm">
                    <h2>Personal Info</h2>
                    <li><label>Full Name <span class=" required">*</span></label>
                        <input type="text" name="fName" class="field-divided" placeholder="First" value="" />
                        <input type="text" name="lName" class="field-divided" placeholder="Last" value="" />
                    </li>

                    <li>
                        <label>Amount: <span class="required">*</span></label>
                        <input id="amountField" class="field-long" type="number" placeholder="Enter amount"
                            name="amount" maxlength="20" step="any" min="0" value="" readonly required>
                    </li>

                    <li>
                        <label>Email address <span class="required">*</span></label>
                        <input type="text" name="email" class="field-long" placeholder="Email Address Here" value=""
                            required />
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

    </div>

    </div>
    <script>
    function selectionFunction(target) {
        let value = target.value;
        console.log(target.value);
        fetch("../getid.php?room=" + value).then(res => res.json()).then(data => {
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
            input.setAttribute("name", "paymentId")
            input.setAttribute("class", "field-long")
            input.setAttribute("value", data.result + 1)
            container.appendChild(input);

            document.getElementById('amountField').value = data.amount;

        });

    }

    function populateLoan(target) {
        let value = target.value;
        fetch("../get_rooms.php?roll=" + value).then(res => res.json()).then(data => {
            const container = document.getElementById('cont');
            container.innerHTML = "";
            const select = document.createElement('select');
            select.setAttribute("name", "loanType");
            select.setAttribute("class", "field-long");
            select.setAttribute("onchange", "selectionFunction(this)");
            select.options[select.options.length] = new Option("--- Select Room ---", "");


            document.getElementById('selectionContaner').style.display = "";

            data.forEach(element => {
                console.log(element);
                select.options[select.options.length] = new Option(element.room_no, element
                    .room_table_name);

            });
            container.appendChild(select);
        })
    }
    </script>


    <!-- <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>
    <script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", func tion() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if(dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
    </script> -->


</body>
</html>