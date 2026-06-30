<?php
session_start();
require('connection.php');

// Login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $stmt = mysqli_prepare($con, "SELECT * FROM `registered_users` WHERE `email` = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($_POST['password'], $row['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $row['username'];
            header("location: choose.php");
            exit();
        } else {
            echo "<script>alert('Incorrect Password'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Email not registered'); window.location.href='login.php';</script>";
    }
}

// Sign Up
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];

    $stmt = mysqli_prepare($con, "SELECT * FROM `registered_users` WHERE `username` = ? OR `email` = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] == $username) {
            echo "<script>alert('Username already taken'); window.location.href='signup.html';</script>";
        } else {
            echo "<script>alert('Email already registered'); window.location.href='signup.html';</script>";
        }
    } else {
        $hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $fullname    = $_POST['fullname'];
        $nin         = $_POST['nin'];
        $phone       = $_POST['phone'];
        $address     = $_POST['address'];
        $postal_code = $_POST['postal_code'];

        $stmt = mysqli_prepare($con,
            "INSERT INTO `registered_users`(`full_name`,`username`,`email`,`password`,`Aadhar`,`Phone`,`address`,`pin_code`)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "ssssssss", $fullname, $username, $email, $hashed, $nin, $phone, $address, $postal_code);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Registration Successful'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed, please try again'); window.location.href='signup.html';</script>";
        }
    }
}
?>
