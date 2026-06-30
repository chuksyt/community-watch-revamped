<?php
require('session_guard.php');
require('connection.php');

if (empty($_SESSION["path"]) || !file_exists($_SESSION["path"])) {
    header('Location: index.html');
    exit();
}

if (!extension_loaded('gd')) {
    echo "<script>alert('Image comparison unavailable (GD extension not enabled on server).'); window.location.href='Response.html';</script>";
    exit();
}

$flag = false;
$matched_row = null;

$query  = "SELECT * FROM `volunteer_details`";
$result = mysqli_query($con, $query);

while ($row_fetch = mysqli_fetch_assoc($result)) {
    if (empty($row_fetch['image']) || !file_exists($row_fetch['image'])) {
        continue;
    }
    $percent = round(compareImages($_SESSION["path"], $row_fetch['image']));
    if ($percent > 98) {
        $flag        = true;
        $matched_row = $row_fetch;
        break;
    }
}

if ($flag && $matched_row) {
    $_SESSION["Pincode"]  = $matched_row['pin_code'];
    $_SESSION["UserName"] = $matched_row['username'];
    echo "<script>window.location.href='Information.php';</script>";
} else {
    echo "<script>window.location.href='Response.html';</script>";
}

function compareImages($pathA, $pathB)
{
    $accuracy = 90;
    $bim      = imagecreatefrompng($pathA);
    $bimX     = imagesx($bim);
    $bimY     = imagesy($bim);
    $im       = imagecreatefrompng($pathB);
    $imX      = imagesx($im);
    $imY      = imagesy($im);
    $pointsX  = $accuracy * 5;
    $pointsY  = $accuracy * 5;
    $sizeX    = max(1, (int)($bimX / $pointsX));
    $sizeY    = max(1, (int)($bimY / $pointsY));
    $y        = 0;
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
    return $matchcount * (100 / $num);
}

function colorComp($color, $c)
{
    return $color >= $c - 2 && $color <= $c + 2;
}
?>
