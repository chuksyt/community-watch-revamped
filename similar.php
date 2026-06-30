<?php
require('session_guard.php');
require('connection.php');

if (empty($_SESSION["path"]) || !file_exists($_SESSION["path"])) {
    header('Location: index.php');
    exit();
}

if (!extension_loaded('gd')) {
    echo "<script>alert('Image comparison unavailable (GD extension not enabled on server).'); window.location.href='Response.html';</script>";
    exit();
}

$flag        = false;
$matched_row = null;
$missing_name = $_SESSION["missing_name"] ?? '';

// Filter sightings by the reported person's name when available
if (!empty($missing_name)) {
    $stmt = mysqli_prepare($con, "SELECT * FROM `volunteer_details` WHERE `full_name` = ?");
    mysqli_stmt_bind_param($stmt, "s", $missing_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query($con, "SELECT * FROM `volunteer_details`");
}

while ($row_fetch = mysqli_fetch_assoc($result)) {
    if (empty($row_fetch['image']) || !file_exists($row_fetch['image'])) {
        continue;
    }
    $percent = round(compareImages($_SESSION["path"], $row_fetch['image']));
    if ($percent > 70) {
        $flag        = true;
        $matched_row = $row_fetch;
        break;
    }
}

if ($flag && $matched_row) {
    $_SESSION["Pincode"]  = $matched_row['pin_code'];
    $_SESSION["UserName"] = $matched_row['username'];

    // Notify the reporter by email (requires sendmail/SMTP configured in php.ini)
    $reporter_username = $_SESSION['username'] ?? '';
    if (!empty($reporter_username)) {
        $r_stmt = mysqli_prepare($con, "SELECT email, full_name FROM `registered_users` WHERE username = ?");
        mysqli_stmt_bind_param($r_stmt, "s", $reporter_username);
        mysqli_stmt_execute($r_stmt);
        $r_result  = mysqli_stmt_get_result($r_stmt);
        $reporter  = mysqli_fetch_assoc($r_result);
        if ($reporter && !empty($reporter['email'])) {
            $to      = $reporter['email'];
            $subject = "Community Watch: Match Found" . (!empty($missing_name) ? " for $missing_name" : '');
            $body    = "Hello " . $reporter['full_name'] . ",\n\n"
                     . "A volunteer in our database has reported seeing the missing person you filed"
                     . (!empty($missing_name) ? " ($missing_name)" : '') . ".\n\n"
                     . "Log in to Community Watch to view the volunteer's full contact details.\n\n"
                     . "— Community Watch";
            $headers = "From: noreply@communitywatch.local\r\nContent-Type: text/plain; charset=UTF-8";
            @mail($to, $subject, $body, $headers);
        }
    }

    echo "<script>window.location.href='Information.php';</script>";
} else {
    echo "<script>window.location.href='Response.html';</script>";
}

function createImageFromPath($path)
{
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if ($ext === 'png')               return @imagecreatefrompng($path);
    if (in_array($ext, ['jpg','jpeg'])) return @imagecreatefromjpeg($path);
    return false;
}

function compareImages($pathA, $pathB)
{
    $accuracy = 90;
    $bim = createImageFromPath($pathA);
    $im  = createImageFromPath($pathB);
    if (!$bim || !$im) {
        if ($bim) imagedestroy($bim);
        if ($im)  imagedestroy($im);
        return 0;
    }

    $bimX    = imagesx($bim);
    $bimY    = imagesy($bim);
    $imX     = imagesx($im);
    $imY     = imagesy($im);
    $pointsX = $accuracy * 5;
    $pointsY = $accuracy * 5;
    $sizeX   = max(1, (int)($bimX / $pointsX));
    $sizeY   = max(1, (int)($bimY / $pointsY));

    $y          = 0;
    $matchcount = 0;
    $num        = 0;

    for ($i = 0; $i <= $pointsY; $i++) {
        if ($y >= $bimY || $y >= $imY) break;
        $x = 0;
        for ($n = 0; $n <= $pointsX; $n++) {
            if ($x >= $bimX || $x >= $imX) break;
            $rgba    = imagecolorat($bim, $x, $y);
            $colorsa = imagecolorsforindex($bim, $rgba);
            $rgbb    = imagecolorat($im, $x, $y);
            $colorsb = imagecolorsforindex($im, $rgbb);
            if (
                colorComp($colorsa['red'],   $colorsb['red'])   &&
                colorComp($colorsa['green'], $colorsb['green']) &&
                colorComp($colorsa['blue'],  $colorsb['blue'])
            ) {
                $matchcount++;
            }
            $x += $sizeX;
            $num++;
        }
        $y += $sizeY;
    }

    imagedestroy($bim);
    imagedestroy($im);
    return $num > 0 ? $matchcount * (100 / $num) : 0;
}

function colorComp($color, $c)
{
    return $color >= $c - 25 && $color <= $c + 25;
}
?>
