<?php
// Reports.php

session_start();

// Check if the user is logged in and authorized
if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'p') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

// Import database connection
include("../connection.php");

// Fetch user details
$userrow = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];

// Fetch report data for the logged-in patient
$reportQuery = "SELECT report_id, report_title, report_date, doctor_name FROM reports WHERE patient_id='$userid' ORDER BY report_date DESC";
$reportResult = $database->query($reportQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>My Reports</title>
</head>
<body>
    <div class="container">
        <div class="dash-body" style="margin-top: 15px;">
            <h1>My Reports</h1>
            <table border="1" style="width: 100%; margin-top: 20px; text-align: left;">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Report Title</th>
                        <th>Report Date</th>
                        <th>Doctor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($reportResult->num_rows > 0) {
                        while ($row = $reportResult->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['report_id'] . "</td>
                                    <td>" . $row['report_title'] . "</td>
                                    <td>" . $row['report_date'] . "</td>
                                    <td>" . $row['doctor_name'] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No reports found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
