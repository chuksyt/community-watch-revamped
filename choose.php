<?php require('session_guard.php'); ?>
<!DOCTYPE html>
<html lang="en" style="background:#111">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="vendor/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="choosecss.css">
    <title>Dashboard — Community Watch</title>
</head>

<body><script src="loader.js"></script>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0,0,0,0.45);">
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

    <div class="dashboard">
        <div class="dash-header">
            <span class="dash-eyebrow">What would you like to do?</span>
            <h1 class="dash-title">Choose an Action</h1>
        </div>
        <div class="dash-cards">
            <a href="search.php" class="action-card">
                <div class="card-icon"><i class="bi bi-person-exclamation"></i></div>
                <div class="card-title">Report Missing</div>
                <div class="card-desc">Submit a report for someone who has gone missing</div>
                <div class="card-cta">Get started <i class="bi bi-arrow-right"></i></div>
            </a>
            <a href="sighting.php" class="action-card">
                <div class="card-icon"><i class="bi bi-eye"></i></div>
                <div class="card-title">Report a Sighting</div>
                <div class="card-desc">Share information about someone you may have seen</div>
                <div class="card-cta">Get started <i class="bi bi-arrow-right"></i></div>
            </a>
            <a href="my_reports.php" class="action-card">
                <div class="card-icon"><i class="bi bi-search-heart"></i></div>
                <div class="card-title">Active Reports</div>
                <div class="card-desc">Browse all missing persons currently reported on the platform</div>
                <div class="card-cta">View all <i class="bi bi-arrow-right"></i></div>
            </a>
        </div>
    </div>

    <!-- Inactivity warning toast -->
    <div id="inactivity-warn" style="display:none; position:fixed; bottom:1.5rem; right:1.5rem; z-index:9999;
         background:rgba(15,15,30,0.92); color:#fff; border:1px solid rgba(255,255,255,0.15);
         border-radius:14px; padding:1.25rem 1.5rem; box-shadow:0 8px 32px rgba(0,0,0,0.5);
         max-width:300px; gap:1rem; align-items:center; backdrop-filter:blur(10px);">
        <div style="flex:1;">
            <div style="font-weight:700; margin-bottom:0.2rem;"><i class="bi bi-clock me-1"></i> Still there?</div>
            <div style="font-size:0.82rem; color:#aaa;">You'll be logged out in 1 minute due to inactivity.</div>
        </div>
        <button onclick="keepAlive()" style="background:#0d6efd; border:none; color:#fff;
                padding:0.5rem 1rem; border-radius:8px; font-weight:700; cursor:pointer; white-space:nowrap;">
            Stay logged in
        </button>
    </div>

    <script src="vendor/js/bootstrap.bundle.min.js"></script>
    <script>
        const TIMEOUT = 10 * 60 * 1000;
        const WARN_AT = 9 * 60 * 1000;
        let lastActivity = Date.now();
        let warned = false;

        function keepAlive() {
            lastActivity = Date.now();
            warned = false;
            document.getElementById('inactivity-warn').style.display = 'none';
        }

        ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'].forEach(function(e) {
            document.addEventListener(e, keepAlive, { passive: true });
        });

        setInterval(function() {
            const idle = Date.now() - lastActivity;
            if (idle >= TIMEOUT) {
                window.location.href = 'logout.php?reason=timeout';
            } else if (idle >= WARN_AT && !warned) {
                warned = true;
                document.getElementById('inactivity-warn').style.display = 'flex';
            }
        }, 10000);
    </script>
</body>

</html>
