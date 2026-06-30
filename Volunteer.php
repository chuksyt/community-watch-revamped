<?php
require('session_guard.php');
require('connection.php');

if (isset($_POST["upload"]) && !empty($_FILES)) {
    $img_tmp  = $_FILES["profile_pic"]["tmp_name"];
    $img_name = $_FILES["profile_pic"]["name"];
    $img_ext  = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
    $img_size = $_FILES['profile_pic']['size'] / (1024 * 1024);

    if (!in_array($img_ext, ['png', 'jpg', 'jpeg'])) {
        echo "<script>alert('Only PNG or JPEG images are allowed.'); history.back();</script>";
        exit();
    }
    if ($img_size > 2) {
        echo "<script>alert('Image must be under 2MB.'); history.back();</script>";
        exit();
    }

    $upload_dir = __DIR__ . '/uploads/volunteers/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $safe_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['fullname']);
    $timestamp = time();
    $img_dest  = $upload_dir . $safe_name . '_' . $timestamp . '.' . $img_ext;

    $fullname = $_POST['fullname'];
    $address  = $_POST['address'];
    $pin_code = $_POST['pin_code'];
    $city     = $_POST['city'];
    $gendesc  = $_POST['gendesc'];
    $username = $_POST['username'];

    $stmt = mysqli_prepare($con,
        "INSERT INTO `volunteer_details`(`full_name`,`address`,`pin_code`,`city`,`image`,`gen_desc`,`username`)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "sssssss", $fullname, $address, $pin_code, $city, $img_dest, $gendesc, $username);

    if (mysqli_stmt_execute($stmt)) {
        move_uploaded_file($img_tmp, $img_dest);
        echo "<script>window.location.href='thankyou.html';</script>";
    } else {
        echo "<script>alert('Submission failed, please try again.'); history.back();</script>";
    }
} else {
    echo "<script>alert('No file uploaded.'); history.back();</script>";
}
?>
