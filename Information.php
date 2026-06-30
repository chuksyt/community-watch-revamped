<?php
require('session_guard.php');
require('connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="vendor/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/icons/bootstrap-icons.css" rel="stylesheet">
    <title>Match Found — Community Watch</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f6f8;
        }

        .result-card {
            max-width: 560px;
            margin: 0 auto;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            overflow: hidden;
        }

        .result-card .card-header {
            background-color: #0d6efd;
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 1.25rem 1.5rem;
        }

        .result-card .card-body {
            padding: 2rem 1.5rem;
        }

        .info-row {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            margin-bottom: 1rem;
            color: #333;
        }

        .info-row i {
            font-size: 1.1rem;
            color: #0d6efd;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .info-row .label {
            font-weight: 700;
            min-width: 80px;
        }
    </style>
</head>

<body><script src="loader.js"></script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fst-italic fw-bold" href="index.php">COMMUNITY WATCH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                    <li class="nav-item ms-2">
                        <a href="logout.php" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-box-arrow-right me-1"></i>Log Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 88vh;">
        <?php
        $uname = $_SESSION["UserName"] ?? '';

        if (empty($uname)) {
            echo '<div class="alert alert-danger">Session expired. <a href="index.php">Return to home</a>.</div>';
        } else {
            $stmt = mysqli_prepare($con, "SELECT * FROM `registered_users` WHERE username = ?");
            mysqli_stmt_bind_param($stmt, "s", $uname);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row    = mysqli_fetch_assoc($result);

            if ($row) {
        ?>
        <div class="result-card">
            <div class="card-header">
                <i class="bi bi-check-circle me-2"></i> Match Found — Volunteer Contact Details
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">A volunteer in our database has seen this person. Contact them directly
                    using the details below.</p>
                <div class="info-row">
                    <i class="bi bi-person-fill"></i>
                    <span class="label">Name:</span>
                    <span><?php echo htmlspecialchars($row['full_name']); ?></span>
                </div>
                <div class="info-row">
                    <i class="bi bi-telephone-fill"></i>
                    <span class="label">Phone:</span>
                    <span><?php echo htmlspecialchars($row['Phone']); ?></span>
                </div>
                <div class="info-row">
                    <i class="bi bi-envelope-fill"></i>
                    <span class="label">Email:</span>
                    <span><?php echo htmlspecialchars($row['email']); ?></span>
                </div>
                <div class="info-row">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span class="label">Address:</span>
                    <span><?php echo htmlspecialchars($row['address']); ?></span>
                </div>
                <div class="info-row">
                    <i class="bi bi-mailbox"></i>
                    <span class="label">Postal:</span>
                    <span><?php echo htmlspecialchars($row['pin_code']); ?></span>
                </div>
                <a href="index.php" class="btn btn-primary w-100 mt-3">Return to Home</a>
            </div>
        </div>
        <?php
            } else {
                echo '<div class="alert alert-warning">Volunteer record not found.</div>';
            }
        }
        ?>
    </div>

    <script src="vendor/js/bootstrap.bundle.min.js"></script>
</body>

</html>
