<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: choose.php');
    exit();
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
    <title>Log In — Community Watch</title>
</head>

<body><script src="loader.js"></script>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0,0,0,0.35);">
        <div class="container">
            <a class="navbar-brand fst-italic fw-bold" href="index.html">COMMUNITY WATCH</a>
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
                <i class="bi bi-shield-check"></i>
                <span>COMMUNITY WATCH</span>
            </div>
            <h2 class="login-title">Welcome back</h2>
            <p class="login-sub">Sign in to your account to continue</p>

            <?php if (isset($_GET['reason']) && $_GET['reason'] === 'timeout'): ?>
            <div style="background:rgba(220,53,69,0.15); border:1px solid rgba(220,53,69,0.4); color:#ff6b6b; border-radius:8px; padding:0.65rem 1rem; font-size:0.85rem; margin-bottom:1.25rem;">
                <i class="bi bi-clock me-1"></i> You were logged out after 10 minutes of inactivity.
            </div>
            <?php endif; ?>

            <form id="login-form" action="login_register.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="you@example.com" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn-submit" name="login">
                    Sign In <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

            <p class="login-footer">
                Don't have an account? <a href="signup.html">Sign up free</a>
            </p>
        </div>
    </main>

    <script src="vendor/js/bootstrap.bundle.min.js"></script>
</body>

</html>
