<?php

session_start();
include "config.php";


/* =========================================
   LOGIN CHECK
========================================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


/* =========================================
   NGO CHECK
========================================= */

if ($_SESSION["role"] != "ngo") {

    die("Access denied.");

}


/* =========================================
   GET AVAILABLE DONATIONS
========================================= */

$sql = "SELECT donations.*, users.name AS donor_name
        FROM donations
        JOIN users
        ON donations.donor_id = users.id
        WHERE donations.status = 'Available'
        ORDER BY donations.id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Find Food - FoodShare</title>

    <link
        rel="stylesheet"
        href="css/style.css"
    >


    <style>

        /* =========================================
           PAGE
        ========================================= */

        .donations-wrapper {

            max-width: 1150px;

            margin: 45px auto;

        }


        .page-header {

            text-align: center;

            margin-bottom: 35px;

        }


        .page-icon {

            font-size: 52px;

            margin-bottom: 10px;

        }


        .page-header h1 {

            margin-bottom: 8px;

        }


        .page-header p {

            max-width: 650px;

            margin: auto;

        }


        /* =========================================
           DONATION GRID
        ========================================= */

        .donation-grid {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 25px;

        }


        /* =========================================
           DONATION CARD
        ========================================= */

        .food-card {

            background: white;

            border-radius: 20px;

            overflow: hidden;

            border: 1px solid #e3ebe6;

            box-shadow:
                0 8px 28px
                rgba(30, 70, 50, 0.07);

            transition: 0.3s ease;

        }


        .food-card:hover {

            transform: translateY(-5px);

            box-shadow:
                0 15px 38px
                rgba(30, 70, 50, 0.12);

        }


        /* =========================================
           FOOD IMAGE
        ========================================= */

        .food-image {

            width: 100%;

            height: 230px;

            object-fit: cover;

            display: block;

            background: #eef4f0;

        }


        .no-image {

            width: 100%;

            height: 230px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-direction: column;

            background:
                linear-gradient(
                    135deg,
                    #eef8f1,
                    #f8fbf9
                );

            color: #7a8780;

            font-size: 15px;

        }


        .no-image-icon {

            font-size: 48px;

            margin-bottom: 8px;

        }


        /* =========================================
           CARD CONTENT
        ========================================= */

        .food-content {

            padding: 25px;

        }


        .food-top {

            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            gap: 15px;

            margin-bottom: 15px;

        }


        .food-title {

            color: #173d2a;

            font-size: 22px;

            margin: 0;

        }


        .available-badge {

            background: #fff3cd;

            color: #856404;

            padding: 6px 11px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 700;

            white-space: nowrap;

        }


        /* =========================================
           FOOD INFO
        ========================================= */

        .food-info {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 12px;

            margin-bottom: 18px;

        }


        .info-box {

            background: #f7faf8;

            padding: 12px;

            border-radius: 10px;

            border: 1px solid #e7eee9;

        }


        .info-label {

            display: block;

            font-size: 12px;

            color: #7a8780;

            margin-bottom: 3px;

        }


        .info-value {

            color: #34423a;

            font-size: 14px;

            font-weight: 600;

        }


        /* =========================================
           DESCRIPTION
        ========================================= */

        .description {

            margin-bottom: 18px;

            padding-bottom: 18px;

            border-bottom: 1px solid #e8eee9;

        }


        .description strong {

            color: #34423a;

            display: block;

            margin-bottom: 5px;

        }


        .description p {

            margin: 0;

            font-size: 14px;

        }


        /* =========================================
           ADDRESS
        ========================================= */

        .pickup-address {

            margin-bottom: 20px;

        }


        .pickup-address strong {

            display: block;

            color: #34423a;

            margin-bottom: 5px;

        }


        .pickup-address p {

            margin: 0;

            font-size: 14px;

        }


        /* =========================================
           BUTTON
        ========================================= */

        .accept-button {

            width: 100%;

            padding: 13px;

            font-size: 15px;

        }


        /* =========================================
           EMPTY STATE
        ========================================= */

        .empty-state {

            background: white;

            padding: 60px 25px;

            border-radius: 20px;

            text-align: center;

            border: 1px solid #e3ebe6;

            box-shadow:
                0 8px 28px
                rgba(30, 70, 50, 0.06);

        }


        .empty-icon {

            font-size: 60px;

            margin-bottom: 15px;

        }


        .empty-state h2 {

            margin-bottom: 8px;

        }


        .empty-state p {

            max-width: 500px;

            margin: auto;

        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 850px) {

            .donation-grid {

                grid-template-columns: 1fr;

            }

        }


        @media (max-width: 600px) {

            .donations-wrapper {

                width: 92%;

                margin: 30px auto;

            }


            .food-top {

                flex-direction: column;

            }


            .food-info {

                grid-template-columns: 1fr;

            }


            .food-image,
            .no-image {

                height: 210px;

            }

        }

    </style>

</head>


<body>


<!-- =========================================
     NAVIGATION
========================================= -->

<div class="navbar">

    <h2>🍱 FoodShare</h2>

    <div>

        <a href="dashboard.php">
            Home
        </a>

        <a href="donations.php">
            Find Food
        </a>

        <a href="my_accepted.php">
            My Accepted
        </a>

        <a href="logout.php">
            Logout
        </a>

    </div>

</div>



<!-- =========================================
     MAIN CONTENT
========================================= -->

<div class="donations-wrapper">


    <div class="page-header">

        <div class="page-icon">
            🔎
        </div>

        <h1>
            Available Food
        </h1>

        <p>
            Find surplus food donated by generous people
            and help get it to those who need it.
        </p>

    </div>



    <?php if (mysqli_num_rows($result) > 0) { ?>


        <div class="donation-grid">


            <?php while ($donation = mysqli_fetch_assoc($result)) { ?>


                <div class="food-card">


                    <!-- =================================
                         FOOD IMAGE
                    ================================= -->

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

                            <span>
                                No image available
                            </span>

                        </div>


                    <?php } ?>



                    <!-- =================================
                         CARD CONTENT
                    ================================= -->

                    <div class="food-content">


                        <div class="food-top">

                            <h2 class="food-title">

                                <?php

                                echo htmlspecialchars(
                                    $donation["food_name"]
                                );

                                ?>

                            </h2>


                            <span class="available-badge">
                                🟡 AVAILABLE
                            </span>

                        </div>



                        <!-- FOOD INFORMATION -->

                        <div class="food-info">


                            <div class="info-box">

                                <span class="info-label">
                                    Quantity
                                </span>

                                <span class="info-value">

                                    <?php

                                    echo htmlspecialchars(
                                        $donation["quantity"]
                                    );

                                    ?>

                                </span>

                            </div>


                            <div class="info-box">

                                <span class="info-label">
                                    Donated By
                                </span>

                                <span class="info-value">

                                    <?php

                                    echo htmlspecialchars(
                                        $donation["donor_name"]
                                    );

                                    ?>

                                </span>

                            </div>


                        </div>



                        <!-- DESCRIPTION -->

                        <div class="description">

                            <strong>
                                📝 Description
                            </strong>

                            <p>

                                <?php

                                echo nl2br(
                                    htmlspecialchars(
                                        $donation["description"]
                                    )
                                );

                                ?>

                            </p>

                        </div>



                        <!-- PICKUP ADDRESS -->

                        <div class="pickup-address">

                            <strong>
                                📍 Pickup Address
                            </strong>

                            <p>

                                <?php

                                echo nl2br(
                                    htmlspecialchars(
                                        $donation["pickup_address"]
                                    )
                                );

                                ?>

                            </p>

                        </div>



                        <!-- ACCEPT BUTTON -->

                        <a
                            href="accept_donation.php?id=<?php
                                echo $donation["id"];
                            ?>"
                        >

                            <button
                                class="accept-button"
                            >

                                🤝 Accept Donation

                            </button>

                        </a>


                    </div>


                </div>


            <?php } ?>


        </div>


    <?php } else { ?>


        <!-- EMPTY STATE -->

        <div class="empty-state">

            <div class="empty-icon">
                🍽️
            </div>

            <h2>
                No Food Available Right Now
            </h2>

            <p>
                There are currently no available food
                donations. Please check again later.
            </p>

        </div>


    <?php } ?>


</div>



<!-- =========================================
     FOOTER
========================================= -->

<footer>

    <p>
        © 2026 FoodShare | Food Donation Platform
    </p>

    <p>
        Connecting food donors and NGOs. ❤️
    </p>

</footer>


</body>

</html>