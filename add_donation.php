<?php

session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "donor") {
    die("Access denied.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $food_name = $_POST["food_name"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];
    $pickup_address = $_POST["pickup_address"];
    $expiry_time = $_POST["expiry_time"];

    $donor_id = $_SESSION["user_id"];

    /* =========================================
       IMAGE UPLOAD
    ========================================= */

    $food_image = "";

    if (isset($_FILES["food_image"]) &&
        $_FILES["food_image"]["error"] == 0) {

        $file_name = $_FILES["food_image"]["name"];
        $file_tmp = $_FILES["food_image"]["tmp_name"];
        $file_size = $_FILES["food_image"]["size"];

        $file_extension =
            strtolower(
                pathinfo($file_name, PATHINFO_EXTENSION)
            );

        $allowed_extensions = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];


        if (!in_array($file_extension, $allowed_extensions)) {

            $message =
                "❌ Only JPG, JPEG, PNG and WEBP images are allowed.";

        }

        elseif ($file_size > 5 * 1024 * 1024) {

            $message =
                "❌ Image must be smaller than 5 MB.";

        }

        else {

            $new_file_name =
                uniqid("food_", true)
                . "."
                . $file_extension;

            $upload_path =
                "uploads/" . $new_file_name;


            if (is_uploaded_file($file_tmp)) {

                if (move_uploaded_file($file_tmp, $upload_path)) {

                    $food_image = $new_file_name;

            } else {

                $message = "❌ Could not move the uploaded image.";

            }

        } else {

            $message = "❌ PHP did not receive the uploaded image.";

        }

        }

    }


    /* =========================================
       SAVE DONATION
    ========================================= */

    if ($message == "") {

        $sql = "INSERT INTO donations
                (
                    donor_id,
                    food_name,
                    quantity,
                    description,
                    pickup_address,
                    expiry_time,
                    status,
                    food_image
                )
                VALUES
                (
                    '$donor_id',
                    '$food_name',
                    '$quantity',
                    '$description',
                    '$pickup_address',
                    '$expiry_time',
                    'Available',
                    '$food_image'
                )";


        if (mysqli_query($conn, $sql)) {

            $message =
                "✅ Food donation added successfully!";

        } else {

            $message =
                "❌ Something went wrong: "
                . mysqli_error($conn);

        }

    }

}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Donate Food - FoodShare</title>

    <link
        rel="stylesheet"
        href="css/style.css"
    >


    <style>

        .donate-wrapper {

            max-width: 750px;

            margin: 50px auto;

        }


        .donate-header {

            text-align: center;

            margin-bottom: 30px;

        }


        .donate-icon {

            font-size: 55px;

            margin-bottom: 10px;

        }


        .donate-header h1 {

            margin-bottom: 8px;

        }


        .donate-header p {

            max-width: 600px;

            margin: auto;

        }


        .donation-form {

            background: white;

            padding: 35px;

            border-radius: 20px;

            border: 1px solid #e3ebe6;

            box-shadow:
                0 10px 35px
                rgba(30, 70, 50, 0.08);

        }


        .form-group {

            margin-bottom: 20px;

        }


        .form-group label {

            margin-top: 0;

        }


        .form-note {

            font-size: 13px;

            color: #7a8780;

            margin-top: -3px;

            margin-bottom: 10px;

        }


        .submit-area {

            margin-top: 25px;

        }


        .message {

            padding: 15px 18px;

            border-radius: 10px;

            margin-bottom: 25px;

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


        .image-upload-box {

            border: 2px dashed #cddbd2;

            border-radius: 14px;

            padding: 25px;

            text-align: center;

            background: #f8fbf9;

            transition: 0.25s;

        }


        .image-upload-box:hover {

            border-color: #16834b;

            background: #f0f9f3;

        }


        .upload-icon {

            font-size: 40px;

            margin-bottom: 8px;

        }


        .image-upload-box input {

            margin-top: 12px;

            margin-bottom: 0;

            background: white;

        }


        .back-link {

            display: inline-block;

            margin-top: 20px;

            font-weight: 600;

        }


        @media (max-width: 768px) {

            .donate-wrapper {

                width: 92%;

                margin: 30px auto;

            }


            .donation-form {

                padding: 25px;

            }

        }

    </style>

</head>


<body>


<!-- NAVIGATION -->

<div class="navbar">

    <h2>🍱 FoodShare</h2>

    <div>

        <a href="dashboard.php">
            Home
        </a>

        <a href="add_donation.php">
            Donate Food
        </a>

        <a href="my_donations.php">
            My Donations
        </a>

        <a href="logout.php">
            Logout
        </a>

    </div>

</div>



<!-- MAIN CONTENT -->

<div class="donate-wrapper">


    <div class="donate-header">

        <div class="donate-icon">
            🍱
        </div>

        <h1>
            Donate Food
        </h1>

        <p>
            Share your surplus food with an NGO
            and help reduce food waste.
        </p>

    </div>



    <?php if ($message != "") { ?>

        <div class="message
            <?php

            if (
                strpos(
                    $message,
                    "successfully"
                ) !== false
            ) {

                echo "success-message";

            } else {

                echo "error-message";

            }

            ?>
        ">

            <?php echo $message; ?>

        </div>

    <?php } ?>



    <div class="donation-form">


        <form
            method="POST"
            enctype="multipart/form-data"
        >


            <!-- FOOD NAME -->

            <div class="form-group">

                <label>
                    Food Name
                </label>

                <input
                    type="text"
                    name="food_name"
                    placeholder="Example: Vegetable Biryani"
                    required
                >

            </div>



            <!-- QUANTITY -->

            <div class="form-group">

                <label>
                    Quantity
                </label>

                <input
                    type="text"
                    name="quantity"
                    placeholder="Example: 10 meals / 5 kg"
                    required
                >

            </div>



            <!-- FOOD IMAGE -->

            <div class="form-group">

                <label>
                    Food Image
                </label>

                <p class="form-note">
                    Upload a clear photo of the food.
                    Maximum size: 5 MB.
                </p>


                <div class="image-upload-box">

                    <div class="upload-icon">
                        📷
                    </div>

                    <strong>
                        Choose Food Photo
                    </strong>

                    <input
                        type="file"
                        name="food_image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                </div>

            </div>



            <!-- DESCRIPTION -->

            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    placeholder="Describe the food, preparation time, packaging, etc."
                    required
                ></textarea>

            </div>



            <!-- PICKUP ADDRESS -->

            <div class="form-group">

                <label>
                    Pickup Address
                </label>

                <textarea
                    name="pickup_address"
                    placeholder="Enter the complete address where the NGO can collect the food"
                    required
                ></textarea>

            </div>



            <!-- EXPIRY -->

            <div class="form-group">

                <label>
                    Food Expiry / Best Before
                </label>

                <p class="form-note">
                    Enter the date and time until which
                    the food is safe to collect.
                </p>

                <input
                    type="datetime-local"
                    name="expiry_time"
                    required
                >

            </div>



            <!-- SUBMIT -->

            <div class="submit-area">

                <button type="submit">

                    🍱 Donate Food

                </button>

            </div>


        </form>


        <a
            class="back-link"
            href="dashboard.php"
        >
            ← Back to Dashboard
        </a>


    </div>


</div>



<!-- FOOTER -->

<footer>

    <p>
        © 2026 FoodShare | Food Donation Platform
    </p>

    <p>
        Every donation can make a difference ❤️
    </p>

</footer>


</body>

</html>