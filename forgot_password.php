<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: choose.php');
    exit();
}
require('connection.php');

$step    = 1;
$error   = '';
$success = '';

// Step 1 → verify identity
if (isset($_POST['verify'])) {
    $email    = trim($_POST['email']);
    $username = trim($_POST['username']);

    $stmt = mysqli_prepare($con, "SELECT id FROM `registered_users` WHERE email = ? AND username = ?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        $_SESSION['reset_email']    = $email;
        $_SESSION['reset_username'] = $username;
        $step = 2;
    } else {
        $error = 'No account found matching that email and username combination.';
        $step  = 1;
    }
}

// Step 2 → set new password
if (isset($_POST['reset'])) {
    if (empty($_SESSION['reset_email']) || empty($_SESSION['reset_username'])) {
        $error = 'Session expired. Please start over.';
        $step  = 1;
    } else {
        $new_password  = $_POST['new_password'];
        $confirm       = $_POST['confirm_password'];

        if (strlen($new_password) < 8) {
            $error = 'Password must be at least 8 characters.';
            $step  = 2;
        } elseif ($new_password !== $confirm) {
            $error = 'Passwords do not match.';
            $step  = 2;
        } else {
            $hashed = password_hash($new_password, PASSWORD_BCRYPT);
            $stmt = mysqli_prepare($con,
                "UPDATE `registered_users` SET password = ? WHERE email = ? AND username = ?");
            mysqli_stmt_bind_param($stmt, "sss", $hashed,
                $_SESSION['reset_email'], $_SESSION['reset_username']);
            mysqli_stmt_execute($stmt);

            unset($_SESSION['reset_email'], $_SESSION['reset_username']);
            $success = 'Password updated successfully. You can now log in.';
            $step    = 0;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" style="background:#111">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="vendor/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="logincss.css">
    <title>Reset Password — Community Watch</title>
</head>

<body><script src="loader.js"></script>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0,0,0,0.35);">
        <div class="container">
            <a class="navbar-brand fst-italic fw-bold" href="index.php">COMMUNITY WATCH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="d-flex align-items-center justify-content-center" style="min-height: 88vh; padding: 2rem 1rem;">
        <div class="login-card">
            <div class="login-brand">
                <i class="bi bi-key"></i>
                <span>COMMUNITY WATCH</span>
            </div>
            <h2 class="login-title">Reset Password</h2>

            <?php if (!empty($error)): ?>
            <div style="background:rgba(220,53,69,0.15); border:1px solid rgba(220,53,69,0.4); color:#ff6b6b;
                        border-radius:8px; padding:0.65rem 1rem; font-size:0.85rem; margin-bottom:1.25rem;">
                <i class="bi bi-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <?php if ($step === 0): ?>
            <div style="background:rgba(25,135,84,0.15); border:1px solid rgba(25,135,84,0.4); color:#75d9a5;
                        border-radius:8px; padding:0.85rem 1rem; font-size:0.9rem; margin-bottom:1.5rem; text-align:center;">
                <i class="bi bi-check-circle me-1"></i> <?php echo htmlspecialchars($success); ?>
            </div>
            <a href="login.php" class="btn-submit" style="display:block; text-align:center; text-decoration:none;">
                Go to Log In <i class="bi bi-arrow-right ms-2"></i>
            </a>

            <?php elseif ($step === 1): ?>
            <p class="login-sub">Enter your email and username to verify your identity.</p>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" class="form-control" name="email" placeholder="you@example.com" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Username</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" class="form-control" name="username" placeholder="Your username" required>
                    </div>
                </div>
                <button type="submit" class="btn-submit" name="verify">
                    Verify Identity <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

            <?php elseif ($step === 2): ?>
            <p class="login-sub">Identity verified. Set your new password below.</p>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" class="form-control" name="new_password"
                            placeholder="At least 8 characters" required minlength="8">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm New Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" class="form-control" name="confirm_password"
                            placeholder="Repeat your new password" required minlength="8">
                    </div>
                </div>
                <button type="submit" class="btn-submit" name="reset">
                    Save New Password <i class="bi bi-check2 ms-2"></i>
                </button>
            </form>
            <?php endif; ?>

            <p class="login-footer" style="margin-top:1.25rem;">
                <a href="login.php">Back to Log In</a>
            </p>
        </div>
    </main>

    <script src="vendor/js/bootstrap.bundle.min.js"></script>
</body>

</html>
