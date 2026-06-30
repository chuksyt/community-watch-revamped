<?php
require('session_guard.php');
require('connection.php');

if (isset($_POST["upload"]) && !empty($_FILES)) {
    $img_tmp  = $_FILES["profile_pic"]["tmp_name"];
    $img_name = $_FILES["profile_pic"]["name"];
    $img_ext  = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
    $img_size = $_FILES['profile_pic']['size'] / (1024 * 1024);

    if ($img_ext !== 'png') {
        echo "<script>alert('Only PNG images are allowed.'); history.back();</script>";
        exit();
    }
    if ($img_size > 2) {
        echo "<script>alert('Image must be under 2MB.'); history.back();</script>";
        exit();
    }

    $upload_dir = __DIR__ . '/uploads/complaints/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $safe_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['fullname']);
    $timestamp = time();
    $img_dest  = $upload_dir . $safe_name . '_' . $timestamp . '.png';

    $_SESSION["path"] = $img_dest;

    $fullname     = $_POST['fullname'];
    $address      = $_POST['address'];
    $pin_code     = $_POST['pin_code'];
    $city         = $_POST['city'];
    $missing_date = $_POST['missing_date'];
    $nin          = $_POST['nin'];
    $gendesc      = $_POST['gendesc'];

    $stmt = mysqli_prepare($con,
        "INSERT INTO `user_complaint`(`full_name`,`address`,`pin_code`,`city`,`missing_date`,`Aadhar`,`image`,`gen_desc`)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "ssssssss", $fullname, $address, $pin_code, $city, $missing_date, $nin, $img_dest, $gendesc);

    if (mysqli_stmt_execute($stmt)) {
        move_uploaded_file($img_tmp, $img_dest);
        echo "<script>window.location.href='similar.php';</script>";
    } else {
        echo "<script>alert('Submission failed, please try again.'); history.back();</script>";
    }
} else {
    echo "<script>alert('No file uploaded.'); history.back();</script>";
}
?>
