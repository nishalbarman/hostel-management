<?php

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['role'] === 'student')) {
    header("location: ./login.php");
    exit;
}
include './includes/db/config.php';
$firstname = $_SESSION['firstname'];
$rollno = $_SESSION['roll'];

?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Room Statement</title>
<link rel="stylesheet" href="./includes/css/bookroom.css" />
<style>
    .roomtbl th {
        text-align: center;
    }
</style>
</head>
<body onload="populateLoan(<?php echo $rollno; ?>)">
    <?php include 'header.html'; ?>

    <div class="container">
        <span>
            <?php echo $firstname; ?> &#62; Book Room
        </span>
        <p></p>
        <table class="roomtbl">
            <tr>
                <!-- <td style=" text-align: left;">
                            <label for="memberId"><b>Member ID:</b></label>
                            <input type="text" placeholder="Enter Member id" pattern="[0-9]*" name="memberId" value=""
                                maxlength="20" onchange="populateLoan(this)">
                        </td>
                        <td></td> -->
                <td id="selectionContaner" style="text-align: left; display: none;">
                    <!-- <label for="paymentId"><b>Select Loan:</b></label> -->
                    <div id="cont">

                    </div>
                </td>
            </tr>
        </table>

        <div id="repayListTable">

        </div>
    </div>


    <script>
        function selectionFunction(target) {
            let value = target.value;
            console.log(target.value);
            fetch("get_repay_table.php?table=" + value).then(res => res.json()).then(data => {
                console.log(data);
                const tableContainer = document.getElementById('repayListTable');

                let table = document.createElement('table');
                table.setAttribute("class", "roomtbl");
                // table.setAttribute("border", '1');
                // table.setAttribute("style",
                //     'margin-top: 10px;border: 1px solid black;text-align: center;'
                // );
                let array = ["ID", "Months", "Roll No", "Amount", "Room No", "Status"]

                let headerRow = document.createElement('tr');
                headerRow.setAttribute("bgcolor",
                    "#33CCFF");
                for (let j = 0; j < array.length; j++) {
                    let cell = document.createElement('th');
                    cell.innerHTML = array[j];
                    headerRow.appendChild(cell);
                }

                table.appendChild(headerRow);

                for (let i = 0; i < data.length; i++) {
                    let row = document.createElement('tr');
                    for (let key in data[i]) {
                        let cell = document.createElement('td');
                        cell.innerHTML = data[i][key];
                        row.appendChild(cell);
                        row.setAttribute("style", "border: 1px solid #86bc25; text-align: center;");
                    }
                    table.appendChild(row);
                }

                tableContainer.appendChild(table);

            });

        }

        function populateLoan(target) {
            let value = target;
            fetch("get_rooms.php?roll=" + value).then(res => res.json()).then(data => {
                console.log(data);
                const container = document.getElementById('cont');
                container.innerHTML = "";
                const select = document.createElement('select');
                select.setAttribute("name", "loanType");
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

    </center>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>
    <script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
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