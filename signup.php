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
    <link rel="stylesheet" href="signupcss.css">
    <title>Sign Up — Community Watch</title>
</head>

<body><script src="loader.js"></script>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0,0,0,0.4);">
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
        <div class="signup-card">
            <h2 class="signup-title">Create Account</h2>
            <p class="signup-sub">Join Community Watch to report missing persons and sightings.</p>

            <form action="login_register.php" method="post">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="fullname" id="fulln"
                            placeholder="First and last name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIN</label>
                        <input type="text" class="form-control" name="nin" id="aadhaar"
                            placeholder="National ID Number" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile Number</label>
                        <input type="tel" class="form-control" name="phone" id="mobno"
                            placeholder="+234..." required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="add"
                            placeholder="Street address" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" name="postal_code" id="pin"
                            placeholder="Postal code" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="usern"
                            placeholder="Choose a username" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email"
                            placeholder="you@example.com" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="passw"
                            placeholder="At least 8 characters" required>
                    </div>
                    <div class="col-12 mt-1">
                        <button type="submit" class="btn-submit" name="register"
                            onclick="return redirect()">
                            Create Account <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </form>

            <p class="signup-footer">
                Already have an account? <a href="login.php">Log in</a>
            </p>
        </div>
    </main>

    <script src="vendor/js/bootstrap.bundle.min.js"></script>
    <script src="signupjs.js"></script>
</body>

</html>
