<?php
require('session_guard.php');
require('connection.php');

$result = mysqli_query($con, "SELECT * FROM `user_complaint` ORDER BY submitted_at DESC");
?>
<!DOCTYPE html>
<html lang="en" style="background:#111">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="vendor/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/icons/bootstrap-icons.css" rel="stylesheet">
    <title>Active Reports — Community Watch</title>
    <style>
        body { background: #111; color: #e0e0e0; font-family: sans-serif; }

        .page-header {
            background: linear-gradient(rgba(0,0,0,0.72), rgba(0,0,0,0.72)), url('choose.jpg') center/cover no-repeat;
            padding: 3.5rem 0 2.5rem;
            text-align: center;
        }
        .page-header h1 { color: #fff; font-weight: 800; font-size: 2rem; margin-bottom: 0.4rem; }
        .page-header p  { color: rgba(255,255,255,0.65); margin: 0; }

        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 2.5rem 0;
        }

        .report-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            overflow: hidden;
            transition: transform 0.2s, border-color 0.2s;
        }
        .report-card:hover { transform: translateY(-3px); border-color: rgba(13,110,253,0.5); }

        .report-photo {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: rgba(255,255,255,0.04);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .report-photo img { width: 100%; height: 200px; object-fit: cover; }
        .report-photo .no-photo { color: rgba(255,255,255,0.2); font-size: 3rem; }

        .report-body { padding: 1.25rem 1.25rem 1.5rem; }
        .report-name { font-weight: 700; font-size: 1.1rem; color: #fff; margin-bottom: 0.5rem; }

        .report-meta {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.55);
        }
        .report-meta i { color: #0d6efd; margin-right: 0.4rem; }

        .report-desc {
            margin-top: 0.85rem;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .badge-missing {
            display: inline-block;
            background: rgba(220,53,69,0.18);
            color: #ff6b6b;
            border: 1px solid rgba(220,53,69,0.35);
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.2rem 0.65rem;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }

        .empty-state {
            text-align: center;
            padding: 5rem 1rem;
            color: rgba(255,255,255,0.3);
        }
        .empty-state i { font-size: 3.5rem; display: block; margin-bottom: 1rem; }
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

    <div class="page-header">
        <h1><i class="bi bi-search-heart me-2"></i>Active Missing Persons</h1>
        <p>All reports currently on the platform — share these with your community.</p>
    </div>

    <div class="container">
        <?php
        $rows = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }
        if (empty($rows)):
        ?>
        <div class="empty-state">
            <i class="bi bi-clipboard-x"></i>
            No reports have been filed yet.
        </div>
        <?php else: ?>
        <div class="report-grid">
        <?php foreach ($rows as $r): ?>
            <div class="report-card">
                <div class="report-photo">
                    <?php if (!empty($r['image']) && file_exists($r['image'])): ?>
                        <img src="uploads/complaints/<?php echo htmlspecialchars(basename($r['image'])); ?>" alt="Photo">
                    <?php else: ?>
                        <div class="no-photo d-flex align-items-center justify-content-center" style="height:200px;width:100%;">
                            <i class="bi bi-person-bounding-box"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="report-body">
                    <div class="badge-missing">MISSING</div>
                    <div class="report-name"><?php echo htmlspecialchars($r['full_name']); ?></div>
                    <div class="report-meta">
                        <?php if (!empty($r['city'])): ?>
                        <span><i class="bi bi-geo-alt-fill"></i><?php echo htmlspecialchars($r['city']); ?><?php if (!empty($r['pin_code'])): ?>, <?php echo htmlspecialchars($r['pin_code']); ?><?php endif; ?></span>
                        <?php endif; ?>
                        <?php if (!empty($r['missing_date'])): ?>
                        <span><i class="bi bi-calendar-event"></i>Last seen: <?php echo htmlspecialchars(date('d M Y', strtotime($r['missing_date']))); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($r['submitted_at'])): ?>
                        <span><i class="bi bi-clock"></i>Reported: <?php echo htmlspecialchars(date('d M Y', strtotime($r['submitted_at']))); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($r['gen_desc'])): ?>
                    <div class="report-desc"><?php echo htmlspecialchars($r['gen_desc']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
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
            lastActivity = Date.now(); warned = false;
            document.getElementById('inactivity-warn').style.display = 'none';
        }
        ['mousemove','keydown','click','scroll','touchstart'].forEach(function(e) {
            document.addEventListener(e, keepAlive, { passive: true });
        });
        setInterval(function() {
            const idle = Date.now() - lastActivity;
            if (idle >= TIMEOUT) { window.location.href = 'logout.php?reason=timeout'; }
            else if (idle >= WARN_AT && !warned) { warned = true; document.getElementById('inactivity-warn').style.display = 'flex'; }
        }, 10000);
    </script>
</body>

</html>
