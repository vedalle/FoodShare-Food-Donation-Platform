<?php

include "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users
            (name, email, password, phone, role)
            VALUES
            ('$name', '$email', '$hashed_password', '$phone', '$role')";

    if (mysqli_query($conn, $sql)) {

        $message = "✅ Registration successful! You can now login.";

    } else {

        $message = "❌ Registration failed: " . mysqli_error($conn);

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Register - FoodShare</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        body {
            background:
                radial-gradient(
                    circle at top left,
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
            padding: 45px 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 40px;
            border-radius: 22px;
            border: 1px solid #e3ebe6;
            box-shadow: 0 15px 45px rgba(30, 70, 50, 0.10);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 28px;
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
            text-align: center;
            font-weight: 600;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            margin-top: 0;
        }

        .role-label {
            margin-bottom: 8px;
        }

        .role-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .role-option {
            position: relative;
        }

        .role-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .role-option label {
            display: block;
            padding: 15px;
            text-align: center;
            background: #f7faf8;
            border: 1px solid #d9e2dc;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.25s;
            color: #34423a;
            font-weight: 600;
        }

        .role-option label:hover {
            border-color: #16834b;
            background: #eefaf2;
        }

        .role-option input:checked + label {
            background: #eaf7ef;
            border-color: #16834b;
            color: #10683b;
            box-shadow: 0 0 0 2px rgba(22, 131, 75, 0.10);
        }

        .register-button {
            width: 100%;
            margin-top: 8px;
            padding: 13px;
            font-size: 16px;
        }

        .login-text {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e8eee9;
        }

        .login-text p {
            margin-bottom: 0;
        }

        .login-text a {
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

            .role-options {
                grid-template-columns: 1fr;
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



<!-- REGISTER -->

<div class="auth-wrapper">

    <div class="auth-card">


        <div class="auth-header">

            <div class="auth-icon">
                🌱
            </div>

            <h1>Create Account</h1>

            <p>
                Join FoodShare and make a difference.
            </p>

        </div>



        <?php if ($message != "") { ?>

            <div class="message
                <?php
                    if (strpos($message, "successful") !== false) {
                        echo "success-message";
                    } else {
                        echo "error-message";
                    }
                ?>
            ">

                <?php echo $message; ?>

            </div>

        <?php } ?>



        <form method="POST">


            <!-- NAME -->

            <div class="form-group">

                <label>Full Name</label>

                <input
                    type="text"
                    name="name"
                    placeholder="Enter your full name"
                    required
                >

            </div>



            <!-- EMAIL -->

            <div class="form-group">

                <label>Email Address</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >

            </div>



            <!-- PHONE -->

            <div class="form-group">

                <label>Phone Number</label>

                <input
                    type="tel"
                    name="phone"
                    placeholder="Enter your phone number"
                    required
                >

            </div>



            <!-- PASSWORD -->

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Create a password"
                    required
                >

            </div>



            <!-- ROLE -->

            <div class="form-group">

                <label class="role-label">
                    I want to join as:
                </label>


                <div class="role-options">


                    <div class="role-option">

                        <input
                            type="radio"
                            name="role"
                            value="donor"
                            id="donor"
                            required
                        >

                        <label for="donor">
                            🍱<br>
                            Food Donor
                        </label>

                    </div>


                    <div class="role-option">

                        <input
                            type="radio"
                            name="role"
                            value="ngo"
                            id="ngo"
                        >

                        <label for="ngo">
                            🤝<br>
                            NGO
                        </label>

                    </div>


                </div>

            </div>



            <!-- SUBMIT -->

            <button
                type="submit"
                class="register-button"
            >
                🌱 Create Account
            </button>


        </form>



        <div class="login-text">

            <p>
                Already have an account?
                <a href="login.php">Login here</a>
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
        Reducing food waste. Supporting communities. ❤️
    </p>

</footer>


</body>

</html>