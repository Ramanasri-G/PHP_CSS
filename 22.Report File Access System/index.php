<?php
$folder = "reports/";

if (!is_dir($folder)) {
    mkdir($folder);
}

$files = scandir($folder);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report File Access System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Report File Access System</h1>
    <p class="subtitle">Available Department Reports</p>

    <div class="reports">

        <?php
        foreach ($files as $file) {

            if ($file != "." && $file != "..") {

                echo "<div class='report'>";
                echo "<span>📄 $file</span>";
                echo "<a href='$folder" . urlencode($file) .
                     "' target='_blank'>View Report</a>";
                echo "</div>";
            }
        }
        ?>

        <?php if (count($files) <= 2) { ?>
            <p class="empty">No reports available.</p>
        <?php } ?>

    </div>

</div>

</body>
</html>