<!DOCTYPE html>
<html>

<head>

    <title>FoodShare - Food Donation Platform</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .home-hero {
            min-height: 560px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 20px;

            background:
                radial-gradient(
                    circle at top right,
                    #d9f5e3,
                    transparent 40%
                ),
                linear-gradient(
                    135deg,
                    #eefaf2,
                    #ffffff
                );
        }

        .home-hero h1 {
            font-size: 58px;
            line-height: 1.1;
            color: #123d27;
            margin-bottom: 20px;
        }

        .home-hero h1 span {
            color: #16834b;
        }

        .home-hero p {
            max-width: 700px;
            margin: 0 auto 30px;
            font-size: 19px;
            color: #65736b;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .hero-buttons a {
            text-decoration: none;
        }

        .secondary-button {
            background: white;
            color: #16834b;
            border: 1px solid #16834b;
        }

        .secondary-button:hover {
            background: #eaf7ef;
            color: #10683b;
        }

        .section {
            padding: 70px 20px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 45px;
        }

        .section-title h2 {
            font-size: 34px;
            color: #173d2a;
        }

        .section-title p {
            max-width: 600px;
            margin: 10px auto;
        }

        .steps {
            max-width: 1050px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .step {
            text-align: center;
            background: white;
            padding: 35px 25px;
            border-radius: 18px;
            border: 1px solid #e5ece7;
            box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        }

        .step-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .step h3 {
            color: #173d2a;
            margin-bottom: 10px;
        }

        .impact {
            background: #123d27;
            color: white;
            text-align: center;
            padding: 70px 20px;
        }

        .impact h2 {
            color: white;
            font-size: 35px;
        }

        .impact p {
            color: #dceee3;
            max-width: 650px;
            margin: 15px auto 30px;
        }

        .brand {
            color: #16834b;
        }

        @media (max-width: 768px) {

            .home-hero h1 {
                font-size: 40px;
            }

            .home-hero p {
                font-size: 16px;
            }

            .steps {
                grid-template-columns: 1fr;
            }

            .section-title h2 {
                font-size: 28px;
            }

        }

    </style>

</head>


<body>


<!-- NAVIGATION -->

<div class="navbar">

    <h2>🍱 FoodShare</h2>

    <div>

        <a href="index.php">Home</a>

        <a href="#how-it-works">How It Works</a>

        <a href="login.php">Login</a>

        <a href="register.php">
            <button>Get Started</button>
        </a>

    </div>

</div>



<!-- HERO SECTION -->

<section class="home-hero">

    <div>

        <h1>
            Turn Extra Food Into
            <span>Hope.</span>
        </h1>

        <p>
            A simple platform connecting food donors with NGOs
            to reduce food waste and help people in need.
        </p>

        <div class="hero-buttons">

            <a href="register.php">
                <button>🍱 Donate Food</button>
            </a>

            <a href="register.php">
                <button class="secondary-button">
                    🤝 Join as NGO
                </button>
            </a>

        </div>

    </div>

</section>



<!-- HOW IT WORKS -->

<section class="section" id="how-it-works">

    <div class="section-title">

        <h2>How FoodShare Works</h2>

        <p>
            Helping extra food reach people who need it,
            through a simple three-step process.
        </p>

    </div>


    <div class="steps">


        <div class="step">

            <div class="step-icon">
                🍱
            </div>

            <h3>1. Donate</h3>

            <p>
                Donors add details about their available
                surplus food.
            </p>

        </div>


        <div class="step">

            <div class="step-icon">
                🤝
            </div>

            <h3>2. Accept</h3>

            <p>
                NGOs find available donations and
                accept the food they need.
            </p>

        </div>


        <div class="step">

            <div class="step-icon">
                🚚
            </div>

            <h3>3. Collect</h3>

            <p>
                NGOs collect the food and help
                deliver it to people in need.
            </p>

        </div>


    </div>

</section>



<!-- IMPACT SECTION -->

<section class="impact">

    <h2>Every Meal Can Make a Difference ❤️</h2>

    <p>
        Instead of letting surplus food go to waste,
        connect it with someone who needs it.
    </p>

    <a href="register.php">

        <button>
            Get Started
        </button>

    </a>

</section>



<!-- FOOTER -->

<footer>

    <p>
        © 2026 FoodShare | Food Donation Platform
    </p>

    <p>
        Reducing food waste. Supporting communities.
    </p>

</footer>


</body>

</html>