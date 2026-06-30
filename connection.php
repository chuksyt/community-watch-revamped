<?php
$con = mysqli_connect("localhost", "root", "", "missing_person_database");

if (mysqli_connect_error()) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>