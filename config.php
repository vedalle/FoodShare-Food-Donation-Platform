<?php

$conn = mysqli_connect("localhost", "root", "", "food_donation");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>