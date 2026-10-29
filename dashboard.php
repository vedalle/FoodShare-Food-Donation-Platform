<?php

session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$role = $_SESSION["role"];


/* =========================================
   DONOR STATISTICS
========================================= */

if ($role == "donor") {

    $total_sql = "SELECT COUNT(*) AS total
                  FROM donations
                  WHERE donor_id = $user_id";

    $available_sql = "SELECT COUNT(*) AS total
                      FROM donations
                      WHERE donor_id = $user_id
                      AND status = 'Available'";

    $accepted_sql = "SELECT COUNT(*) AS total
                     FROM donations
                     WHERE donor_id = $user_id
                     AND status = 'Accepted'";

    $collected_sql = "SELECT COUNT(*) AS total
                      FROM donations
                      WHERE donor_id = $user_id
                      AND status = 'Collected'";


    $total_result = mysqli_query($conn, $total_sql);
    $available_result = mysqli_query($conn, $available_sql);
    $accepted_result = mysqli_query($conn, $accepted_sql);
    $collected_result = mysqli_query($conn, $collected_sql);


    $total_donations = mysqli_fetch_assoc($total_result)["total"];
    $available_donations = mysqli_fetch_assoc($available_result)["total"];
    $accepted_donations = mysqli_fetch_assoc($accepted_result)["total"];
    $collected_donations = mysqli_fetch_assoc($collected_result)["total"];

}



/* =========================================
   NGO STATISTICS
========================================= */

if ($role == "ngo") {

    $available_sql = "SELECT COUNT(*) AS total
                      FROM donations
                      WHERE status = 'Available'";

    $accepted_sql = "SELECT COUNT(*) AS total
                     FROM donations
                     WHERE accepted_by = $user_id
                     AND status = 'Accepted'";

    $collected_sql = "SELECT COUNT(*) AS total
                      FROM donations
                      WHERE accepted_by = $user_id
                      AND status = 'Collected'";


    $available_result = mysqli_query($conn, $available_sql);
    $accepted_result = mysqli_query($conn, $accepted_sql);
    $collected_result = mysqli_query($conn, $collected_sql);


    $available_food = mysqli_fetch_assoc($available_result)["total"];
    $accepted_food = mysqli_fetch_assoc($accepted_result)["total"];
    $collected_food = mysqli_fetch_assoc($collected_result)["total"];

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard - FoodShare</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .dashboard-wrapper {
            max-width: 1100px;
            margin: 40px auto;
        }


        /* =========================================
           WELCOME BANNER
        ========================================= */

        .welcome-banner {

            background:
                radial-gradient(
                    circle at top right,
                    rgba(255,255,255,0.15),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #16834b,
                    #0d6338
                );

            color: white;

            padding: 40px;

            border-radius: 22px;

            margin-bottom: 30px;

            box-shadow:
                0 12px 35px
                rgba(22, 131, 75, 0.20);

        }


        .welcome-banner h1 {

            color: white;

            font-size: 34px;

            margin-bottom: 8px;

        }


        .welcome-banner p {

            color: #e5f5eb;

            margin-bottom: 0;

        }


        .role-badge {

            display: inline-block;

            margin-top: 18px;

            padding: 7px 14px;

            background: rgba(255,255,255,0.15);

            border: 1px solid rgba(255,255,255,0.25);

            border-radius: 30px;

            font-size: 13px;

            font-weight: 600;

        }



        /* =========================================
           STATISTICS
        ========================================= */

        .stats-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

            margin-bottom: 35px;

        }


        .stat-card {

            background: white;

            padding: 25px;

            border-radius: 18px;

            border: 1px solid #e3ebe6;

            box-shadow:
                0 7px 25px
                rgba(30, 70, 50, 0.06);

            transition: 0.3s ease;

        }


        .stat-card:hover {

            transform: translateY(-4px);

            box-shadow:
                0 13px 35px
                rgba(30, 70, 50, 0.11);

        }


        .stat-icon {

            font-size: 32px;

            margin-bottom: 10px;

        }


        .stat-number {

            font-size: 32px;

            font-weight: 700;

            color: #173d2a;

            margin-bottom: 3px;

        }


        .stat-label {

            color: #65736b;

            font-size: 14px;

        }



        /* =========================================
           SECTION TITLE
        ========================================= */

        .dashboard-title {

            text-align: center;

            margin: 35px 0 25px;

        }


        .dashboard-title h2 {

            margin-bottom: 5px;

        }


        .dashboard-title p {

            margin: 0;

        }



        /* =========================================
           ACTION CARDS
        ========================================= */

        .action-grid {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 22px;

        }


        .action-card {

            background: white;

            padding: 30px;

            border-radius: 18px;

            border: 1px solid #e3ebe6;

            box-shadow:
                0 7px 25px
                rgba(30, 70, 50, 0.06);

            transition: 0.3s ease;

        }


        .action-card:hover {

            transform: translateY(-4px);

            box-shadow:
                0 13px 35px
                rgba(30, 70, 50, 0.11);

        }


        .action-icon {

            font-size: 42px;

            margin-bottom: 12px;

        }


        .action-card h3 {

            color: #173d2a;

            font-size: 22px;

            margin-bottom: 8px;

        }


        .action-card p {

            margin-bottom: 20px;

        }


        .action-card a {

            text-decoration: none;

        }


        .secondary-action {

            background: white;

            color: #16834b;

            border: 1px solid #16834b;

            box-shadow: none;

        }


        .secondary-action:hover {

            background: #eaf7ef;

            color: #10683b;

            box-shadow: none;

        }



        /* =========================================
           HOW IT WORKS
        ========================================= */

        .how-section {

            margin-top: 35px;

            background: white;

            padding: 35px;

            border-radius: 20px;

            border: 1px solid #e3ebe6;

            box-shadow:
                0 7px 25px
                rgba(30, 70, 50, 0.06);

        }


        .how-section h2 {

            text-align: center;

            margin-bottom: 30px;

        }


        .steps-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;

        }


        .dashboard-step {

            text-align: center;

            padding: 20px 10px;

        }


        .dashboard-step .icon {

            font-size: 38px;

            margin-bottom: 10px;

        }


        .dashboard-step h3 {

            font-size: 17px;

            color: #173d2a;

            margin-bottom: 5px;

        }


        .dashboard-step p {

            font-size: 14px;

        }



        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 900px) {

            .stats-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

        }


        @media (max-width: 850px) {

            .action-grid {

                grid-template-columns: 1fr;

            }

            .steps-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

        }


        @media (max-width: 600px) {

            .welcome-banner {

                padding: 30px 25px;

            }


            .welcome-banner h1 {

                font-size: 28px;

            }


            .stats-grid {

                grid-template-columns: 1fr;

            }


            .steps-grid {

                grid-template-columns: 1fr;

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


        <?php if ($role == "donor") { ?>

            <a href="add_donation.php">
                Donate Food
            </a>

            <a href="my_donations.php">
                My Donations
            </a>

        <?php } ?>


        <?php if ($role == "ngo") { ?>

            <a href="donations.php">
                Find Food
            </a>

            <a href="my_accepted.php">
                My Accepted
            </a>

        <?php } ?>


        <a href="logout.php">
            Logout
        </a>

    </div>

</div>



<!-- =========================================
     MAIN DASHBOARD
========================================= -->

<div class="dashboard-wrapper">


    <!-- WELCOME -->

    <div class="welcome-banner">

        <h1>

            Welcome back,
            <?php echo htmlspecialchars($_SESSION["name"]); ?>! 👋

        </h1>


        <p>
            Thank you for being part of the FoodShare community.
        </p>


        <span class="role-badge">

            <?php

            if ($role == "donor") {

                echo "🍱 FOOD DONOR";

            } else {

                echo "🤝 NGO PARTNER";

            }

            ?>

        </span>

    </div>



    <!-- =========================================
         DONOR STATISTICS
    ========================================= -->

    <?php if ($role == "donor") { ?>


        <div class="stats-grid">


            <div class="stat-card">

                <div class="stat-icon">
                    🍱
                </div>

                <div class="stat-number">
                    <?php echo $total_donations; ?>
                </div>

                <div class="stat-label">
                    Total Donations
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    🟡
                </div>

                <div class="stat-number">
                    <?php echo $available_donations; ?>
                </div>

                <div class="stat-label">
                    Available
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    🔵
                </div>

                <div class="stat-number">
                    <?php echo $accepted_donations; ?>
                </div>

                <div class="stat-label">
                    Accepted
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    🟢
                </div>

                <div class="stat-number">
                    <?php echo $collected_donations; ?>
                </div>

                <div class="stat-label">
                    Collected
                </div>

            </div>


        </div>


    <?php } ?>



    <!-- =========================================
         NGO STATISTICS
    ========================================= -->

    <?php if ($role == "ngo") { ?>


        <div class="stats-grid">


            <div class="stat-card">

                <div class="stat-icon">
                    🍱
                </div>

                <div class="stat-number">
                    <?php echo $available_food; ?>
                </div>

                <div class="stat-label">
                    Available Food
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    🔎
                </div>

                <div class="stat-number">
                    <?php echo $accepted_food; ?>
                </div>

                <div class="stat-label">
                    My Accepted
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    🟢
                </div>

                <div class="stat-number">
                    <?php echo $collected_food; ?>
                </div>

                <div class="stat-label">
                    Collected
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    ❤️
                </div>

                <div class="stat-number">
                    <?php echo $accepted_food + $collected_food; ?>
                </div>

                <div class="stat-label">
                    Total Helped
                </div>

            </div>


        </div>


    <?php } ?>



    <!-- =========================================
         DONOR ACTIONS
    ========================================= -->

    <?php if ($role == "donor") { ?>


        <div class="dashboard-title">

            <h2>🍱 Donor Dashboard</h2>

            <p>
                Have extra food? Turn it into something meaningful.
            </p>

        </div>


        <div class="action-grid">


            <div class="action-card">

                <div class="action-icon">
                    🍱
                </div>

                <h3>Donate Food</h3>

                <p>
                    Add details about your surplus food
                    so an NGO can collect it.
                </p>

                <a href="add_donation.php">

                    <button>
                        Donate Food
                    </button>

                </a>

            </div>


            <div class="action-card">

                <div class="action-icon">
                    📋
                </div>

                <h3>My Donations</h3>

                <p>
                    Track your food donations and
                    see their current status.
                </p>

                <a href="my_donations.php">

                    <button class="secondary-action">
                        View Donations
                    </button>

                </a>

            </div>


        </div>


    <?php } ?>



    <!-- =========================================
         NGO ACTIONS
    ========================================= -->

    <?php if ($role == "ngo") { ?>


        <div class="dashboard-title">

            <h2>🤝 NGO Dashboard</h2>

            <p>
                Find available food and help distribute it
                to people who need it.
            </p>

        </div>


        <div class="action-grid">


            <div class="action-card">

                <div class="action-icon">
                    🔎
                </div>

                <h3>Find Food</h3>

                <p>
                    Browse available food donations
                    from generous donors.
                </p>

                <a href="donations.php">

                    <button>
                        Find Food
                    </button>

                </a>

            </div>


            <div class="action-card">

                <div class="action-icon">
                    📦
                </div>

                <h3>My Accepted Donations</h3>

                <p>
                    Track accepted donations and
                    mark them as collected.
                </p>

                <a href="my_accepted.php">

                    <button class="secondary-action">
                        View Accepted
                    </button>

                </a>

            </div>


        </div>


    <?php } ?>



    <!-- =========================================
         HOW IT WORKS
    ========================================= -->

    <div class="how-section">

        <h2>🌱 How FoodShare Works</h2>


        <div class="steps-grid">


            <div class="dashboard-step">

                <div class="icon">
                    🍱
                </div>

                <h3>Donate</h3>

                <p>
                    Donors share surplus food.
                </p>

            </div>


            <div class="dashboard-step">

                <div class="icon">
                    🔎
                </div>

                <h3>Find</h3>

                <p>
                    NGOs discover available food.
                </p>

            </div>


            <div class="dashboard-step">

                <div class="icon">
                    🤝
                </div>

                <h3>Accept</h3>

                <p>
                    NGOs accept suitable donations.
                </p>

            </div>


            <div class="dashboard-step">

                <div class="icon">
                    ❤️
                </div>

                <h3>Help</h3>

                <p>
                    Food reaches people in need.
                </p>

            </div>


        </div>

    </div>


</div>



<!-- FOOTER -->

<footer>

    <p>
        © 2026 FoodShare | Food Donation Platform
    </p>

    <p>
        Reducing food waste. Supporting communities. ❤️
    </p>

</footer>


</body>

</html>