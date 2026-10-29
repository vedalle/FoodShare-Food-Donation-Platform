<?php

session_start();
include "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["role"] = $user["role"];

            header("Location: dashboard.php");
            exit();

        } else {

            $message = "❌ Incorrect password.";

        }

    } else {

        $message = "❌ Account not found.";

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Login - FoodShare</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        body {
            background:
                radial-gradient(
                    circle at top right,
                    #dff5e7,
                    transparent 35%
                ),
                #f5f8f6;
        }

        .auth-wrapper {
            min-height: calc(100vh - 72px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 40px;
            border-radius: 22px;
            border: 1px solid #e3ebe6;
            box-shadow: 0 15px 45px rgba(30, 70, 50, 0.10);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-icon {
            font-size: 55px;
            margin-bottom: 10px;
        }

        .auth-header h1 {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .auth-header p {
            margin: 0;
        }

        .message {
            padding: 13px 15px;
            border-radius: 9px;
            margin-bottom: 20px;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            text-align: center;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            margin-top: 0;
        }

        .login-button {
            width: 100%;
            margin-top: 8px;
            padding: 13px;
            font-size: 16px;
        }

        .register-text {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e8eee9;
        }

        .register-text p {
            margin-bottom: 0;
        }

        .register-text a {
            font-weight: 700;
        }

        .home-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
        }

        @media (max-width: 600px) {

            .auth-card {
                padding: 30px 24px;
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

        <a href="login.php">Login</a>

        <a href="register.php">Register</a>

    </div>

</div>



<!-- LOGIN -->

<div class="auth-wrapper">

    <div class="auth-card">


        <div class="auth-header">

            <div class="auth-icon">
                🔐
            </div>

            <h1>Welcome Back</h1>

            <p>
                Login to your FoodShare account.
            </p>

        </div>



        <?php if ($message != "") { ?>

            <div class="message">

                <?php echo $message; ?>

            </div>

        <?php } ?>



        <form method="POST">


            <div class="form-group">

                <label>Email Address</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >

            </div>



            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

            </div>



            <button
                type="submit"
                class="login-button"
            >
                🔐 Login
            </button>


        </form>



        <div class="register-text">

            <p>
                Don't have an account?
                <a href="register.php">Create one</a>
            </p>

        </div>



        <a class="home-link" href="index.php">
            ← Back to FoodShare Home
        </a>


    </div>

</div>



<!-- FOOTER -->

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