<?php

// Set the default timezone
date_default_timezone_set("Asia/Kolkata");

$report = "";
$selectedFormat = "";

// Current date and time
$currentDateTime = date("Y-m-d H:i:s");

// Generate customized report
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $selectedFormat = $_POST["format"] ?? "";

    if ($selectedFormat == "full") {

        $report = date("l, F d, Y - h:i:s A");

    } elseif ($selectedFormat == "date") {

        $report = date("d-m-Y");

    } elseif ($selectedFormat == "time") {

        $report = date("h:i:s A");

    } elseif ($selectedFormat == "short") {

        $report = date("d/m/Y h:i A");

    } elseif ($selectedFormat == "long") {

        $report = date("l, d F Y, h:i A");

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Date and Time Report Generator</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <!-- Header -->

    <div class="header">

        <div class="icon">🕐</div>

        <h1>Date & Time Report</h1>

        <p>
            Generate customized date and time reports
        </p>

    </div>


    <!-- Current Date and Time -->

    <div class="current-section">

        <p class="section-title">
            CURRENT DATE & TIME
        </p>

        <div class="current-time">
            <?php echo date("h:i:s A"); ?>
        </div>

        <div class="current-date">
            <?php echo date("l, F d, Y"); ?>
        </div>

    </div>


    <!-- Multiple Formats -->

    <div class="formats">

        <h2>Available Date & Time Formats</h2>

        <div class="format-grid">

            <div class="format-card">

                <span>📅</span>

                <h3>Standard Date</h3>

                <p>
                    <?php echo date("d-m-Y"); ?>
                </p>

            </div>


            <div class="format-card">

                <span>⏰</span>

                <h3>24-Hour Time</h3>

                <p>
                    <?php echo date("H:i:s"); ?>
                </p>

            </div>


            <div class="format-card">

                <span>📆</span>

                <h3>Long Date</h3>

                <p>
                    <?php echo date("l, F d, Y"); ?>
                </p>

            </div>


            <div class="format-card">

                <span>🕒</span>

                <h3>12-Hour Time</h3>

                <p>
                    <?php echo date("h:i:s A"); ?>
                </p>

            </div>

        </div>

    </div>


    <!-- Report Generator -->

    <div class="report-section">

        <h2>Generate Customized Report</h2>

        <p class="subtitle">
            Select a format to generate your report
        </p>


        <form method="POST" action="">

            <label for="format">
                Select Date & Time Format
            </label>

            <select
                name="format"
                id="format"
                required
            >

                <option value="">
                    -- Select Format --
                </option>

                <option value="full"
                    <?php
                    if ($selectedFormat == "full")
                        echo "selected";
                    ?>>
                    Full Date & Time
                </option>

                <option value="date"
                    <?php
                    if ($selectedFormat == "date")
                        echo "selected";
                    ?>>
                    Date Only
                </option>

                <option value="time"
                    <?php
                    if ($selectedFormat == "time")
                        echo "selected";
                    ?>>
                    Time Only
                </option>

                <option value="short"
                    <?php
                    if ($selectedFormat == "short")
                        echo "selected";
                    ?>>
                    Short Date & Time
                </option>

                <option value="long"
                    <?php
                    if ($selectedFormat == "long")
                        echo "selected";
                    ?>>
                    Long Date & Time
                </option>

            </select>


            <button type="submit">
                Generate Report
            </button>

        </form>


        <?php if ($report != "") { ?>

            <div class="result">

                <div class="result-icon">
                    ✨
                </div>

                <div>

                    <span>
                        GENERATED REPORT
                    </span>

                    <h3>
                        <?php echo htmlspecialchars($report); ?>
                    </h3>

                </div>

            </div>

        <?php } ?>

    </div>


    <!-- Information -->

    <div class="info">

        <div class="info-card">

            <div class="info-icon">
                📅
            </div>

            <div>
                <h3>Date Functions</h3>

                <p>
                    Uses PHP date() function to display
                    different date formats.
                </p>
            </div>

        </div>


        <div class="info-card">

            <div class="info-icon">
                🌍
            </div>

            <div>
                <h3>Time Zone</h3>

                <p>
                    The application uses
                    Asia/Kolkata time zone.
                </p>
            </div>

        </div>


        <div class="info-card">

            <div class="info-icon">
                📊
            </div>

            <div>
                <h3>Customized Reports</h3>

                <p>
                    Users can select different formats
                    for generating reports.
                </p>
            </div>

        </div>

    </div>


    <!-- Footer -->

    <div class="footer">

        Date and Time Report Generator

        <br>

        <span>
            PHP • Date Functions • Time Functions
        </span>

    </div>

</div>

</body>
</html>
