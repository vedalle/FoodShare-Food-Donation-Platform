<?php

session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "ngo") {
    die("Access denied.");
}

if (!isset($_GET["id"])) {
    die("Donation ID is missing.");
}

$donation_id = intval($_GET["id"]);
$ngo_id = intval($_SESSION["user_id"]);

$sql = "UPDATE donations
        SET status = 'Collected'
        WHERE id = $donation_id
        AND accepted_by = $ngo_id
        AND status = 'Accepted'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database error: " . mysqli_error($conn));
}

$success = false;

if (mysqli_affected_rows($conn) > 0) {
    $success = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FoodShare - Donation Status</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .result-container {
            min-height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .result-card {
            background: white;
            width: 100%;
            max-width: 550px;
            text-align: center;
            padding: 50px 35px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.10);
        }

        .success-icon {
            font-size: 70px;
            margin-bottom: 15px;
        }

        .error-icon {
            font-size: 70px;
            margin-bottom: 15px;
        }

        .result-card h1 {
            color: #1b5e20;
            margin-bottom: 15px;
            font-size: 30px;
        }

        .result-card h2 {
            color: #c62828;
            margin-bottom: 15px;
            font-size: 28px;
        }

        .result-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .back-button {
            display: inline-block;
            background: #2e7d32;
            color: white;
            text-decoration: none;
            padding: 13px 24px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .back-button:hover {
            background: #1b5e20;
        }

        .find-button {
            display: inline-block;
            background: #f1f8f2;
            color: #2e7d32;
            text-decoration: none;
            padding: 13px 24px;
            border-radius: 8px;
            font-weight: bold;
            margin-left: 8px;
        }

        .find-button:hover {
            background: #e0f2e1;
        }

        @media (max-width: 600px) {

            .result-card {
                padding: 40px 20px;
            }

            .back-button,
            .find-button {
                display: block;
                margin: 10px 0;
            }

        }

    </style>

</head>

<body>



<div class="result-container">

    <div class="result-card">

        <?php if ($success) { ?>

            <div class="success-icon">
                ✅
            </div>

            <h1>
                Food Marked as Collected!
            </h1>

            <p>
                The donation has been successfully marked as
                <strong>Collected</strong>.
                Thank you for helping reduce food waste and
                supporting people in need. ❤️
            </p>

            <a
                href="my_accepted.php"
                class="back-button"
            >
                📦 My Accepted Donations
            </a>


        <?php } else { ?>

            <div class="error-icon">
                ❌
            </div>

            <h2>
                Could Not Mark Donation
            </h2>

            <p>
                This donation may already have been collected,
                or it may not belong to your NGO account.
            </p>

            <a
                href="my_accepted.php"
                class="back-button"
            >
                ← Go Back
            </a>

            <a
                href="donations.php"
                class="find-button"
            >
                🔎 Find Food
            </a>

        <?php } ?>

    </div>

</div>


</body>

</html>