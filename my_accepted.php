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

$ngo_id = intval($_SESSION["user_id"]);

$sql = "SELECT donations.*, users.name AS donor_name
        FROM donations
        JOIN users
        ON donations.donor_id = users.id
        WHERE donations.accepted_by = $ngo_id
        ORDER BY donations.id DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Accepted Donations - FoodShare</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .page-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .page-header h1 {
            font-size: 34px;
            color: #1b5e20;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #666;
        }

        .donations-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .donation-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid #eeeeee;
            transition: 0.3s;
        }

        .donation-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .food-image {
            width: 100%;
            height: 230px;
            object-fit: cover;
            display: block;
        }

        .no-image {
            height: 230px;
            background: #f1f8f2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #777;
        }

        .no-image-icon {
            font-size: 55px;
            margin-bottom: 8px;
        }

        .donation-content {
            padding: 22px;
        }

        .donation-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .donation-top h2 {
            margin: 0;
            color: #222;
            font-size: 22px;
        }

        .status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        .status-accepted {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-collected {
            background: #dcfce7;
            color: #166534;
        }

        .status-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .donation-info {
            margin: 10px 0;
            color: #555;
            line-height: 1.6;
        }

        .donation-info strong {
            color: #333;
        }

        .description {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 10px;
            margin-top: 15px;
            color: #555;
        }

        .donation-id {
            margin-top: 15px;
            font-size: 13px;
            color: #888;
        }

        .collect-button {
            width: 100%;
            border: none;
            background: #2e7d32;
            color: white;
            padding: 13px;
            margin-top: 18px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .collect-button:hover {
            background: #1b5e20;
        }

        .collected-message {
            margin-top: 18px;
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }

        .completed-message {
            margin-top: 18px;
            background: #f1f8f2;
            color: #2e7d32;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }

        .empty-state {
            background: white;
            padding: 60px 20px;
            text-align: center;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .empty-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }

        .empty-state h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #777;
        }

        @media (max-width: 800px) {

            .donations-grid {
                grid-template-columns: 1fr;
            }

            .donation-top {
                align-items: flex-start;
                flex-direction: column;
            }

        }

    </style>

</head>

<body>


<div class="container">

    <div class="page-header">

        <h1>📦 My Accepted Donations</h1>

        <p>
            Manage the food donations accepted by your NGO.
        </p>

    </div>


    <?php if (mysqli_num_rows($result) > 0) { ?>

        <div class="donations-grid">

            <?php while ($donation = mysqli_fetch_assoc($result)) { ?>

                <div class="donation-card">

                    <!-- FOOD IMAGE -->

                    <?php if (
                        !empty($donation["food_image"]) &&
                        file_exists(
                            "uploads/" . $donation["food_image"]
                        )
                    ) { ?>

                        <img
                            class="food-image"
                            src="uploads/<?php
                                echo htmlspecialchars(
                                    $donation["food_image"]
                                );
                            ?>"
                            alt="Food donation"
                        >

                    <?php } else { ?>

                        <div class="no-image">

                            <div class="no-image-icon">
                                🍱
                            </div>

                            <span>No image available</span>

                        </div>

                    <?php } ?>


                    <div class="donation-content">

                        <div class="donation-top">

                            <h2>
                                <?php
                                echo htmlspecialchars(
                                    $donation["food_name"]
                                );
                                ?>
                            </h2>


                            <?php

                            $status_class = "status-accepted";

                            if ($donation["status"] == "Collected") {
                                $status_class = "status-collected";
                            }

                            elseif ($donation["status"] == "Completed") {
                                $status_class = "status-completed";
                            }

                            ?>

                            <span class="status <?php echo $status_class; ?>">

                                <?php

                                if ($donation["status"] == "Accepted") {
                                    echo "🔵 Accepted";
                                }

                                elseif ($donation["status"] == "Collected") {
                                    echo "🟢 Collected";
                                }

                                elseif ($donation["status"] == "Completed") {
                                    echo "✅ Completed";
                                }

                                ?>

                            </span>

                        </div>


                        <div class="donation-info">

                            <strong>👤 Donor:</strong>

                            <?php
                            echo htmlspecialchars(
                                $donation["donor_name"]
                            );
                            ?>

                        </div>


                        <div class="donation-info">

                            <strong>🍱 Quantity:</strong>

                            <?php
                            echo htmlspecialchars(
                                $donation["quantity"]
                            );
                            ?>

                        </div>


                        <div class="donation-info">

                            <strong>⏰ Expiry:</strong>

                            <?php
                            echo htmlspecialchars(
                                $donation["expiry_time"]
                            );
                            ?>

                        </div>


                        <div class="donation-info">

                            <strong>📍 Pickup Address:</strong><br>

                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $donation["pickup_address"]
                                )
                            );
                            ?>

                        </div>


                        <div class="description">

                            <strong>📝 Description:</strong><br>

                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $donation["description"]
                                )
                            );
                            ?>

                        </div>


                        <div class="donation-id">

                            Donation ID:
                            #<?php echo $donation["id"]; ?>

                        </div>


                        <?php if ($donation["status"] == "Accepted") { ?>

                            <a
                                href="collect_donation.php?id=<?php echo $donation["id"]; ?>"
                            >

                                <button class="collect-button">

                                    ✅ Mark as Collected

                                </button>

                            </a>

                        <?php } ?>


                        <?php if ($donation["status"] == "Collected") { ?>

                            <div class="collected-message">

                                🟢 Food has been collected successfully!

                            </div>

                        <?php } ?>


                        <?php if ($donation["status"] == "Completed") { ?>

                            <div class="completed-message">

                                ✅ Donation completed successfully!

                            </div>

                        <?php } ?>

                    </div>

                </div>

            <?php } ?>

        </div>


    <?php } else { ?>


        <div class="empty-state">

            <div class="empty-icon">
                📦
            </div>

            <h2>No Accepted Donations</h2>

            <p>
                You haven't accepted any food donations yet.
                Find available food and help someone in need!
            </p>

        </div>


    <?php } ?>

</div>

</body>

</html>