<?php require('session_guard.php'); ?>
<!DOCTYPE html>
<html lang="en" style="background:#111">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="vendor/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="searchcss.css">
    <title>Report Missing Person — Community Watch</title>
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

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="form-card">

                    <div class="form-card-header">
                        <i class="bi bi-person-exclamation"></i>
                        <div>
                            <div class="form-card-title">Report a Missing Person</div>
                            <div class="form-card-sub">Fill in the details below. All fields are required.</div>
                        </div>
                    </div>

                    <form action="Complaint.php" method="post" enctype="multipart/form-data">

                        <div class="field-group-label">Personal Information</div>
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="fullname"
                                    placeholder="Missing person's full name" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">NIN</label>
                                <input type="text" class="form-control" name="nin"
                                    placeholder="National ID Number" required>
                            </div>
                        </div>

                        <div class="field-group-label">Last Known Location</div>
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address"
                                    placeholder="Last known address" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Postal Code</label>
                                <input type="text" class="form-control" name="pin_code" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Date Last Seen</label>
                                <input type="date" class="form-control" name="missing_date" required>
                            </div>
                        </div>

                        <div class="field-group-label">Photo &amp; Description</div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">
                                    Photo <span class="text-muted fw-light">(PNG or JPEG, max 2MB)</span>
                                </label>
                                <input type="file" class="form-control" name="profile_pic" accept="image/png,image/jpeg" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="gendesc" rows="4"
                                    placeholder="Physical appearance, clothing, circumstances of disappearance..."></textarea>
                            </div>
                            <div class="col-12 mt-1">
                                <button type="submit" class="btn-submit" name="upload">
                                    Submit Report <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>

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
