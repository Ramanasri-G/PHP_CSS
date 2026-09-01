<?php

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit();
}

// Get form values
$customerName = trim($_POST["customer_name"] ?? "");
$preference = trim($_POST["preference"] ?? "");

// Validate customer name
if ($customerName === "") {
    die("Error: Customer name is required.");
}

// Validate preference
$validPreferences = ["Light", "Dark", "Blue"];

if (!in_array($preference, $validPreferences)) {
    die("Error: Please select a valid preference.");
}

// Read previous visit count from cookie
$visitCount = isset($_COOKIE["visit_count"])
    ? (int) $_COOKIE["visit_count"]
    : 0;

// Increase visit count
$visitCount++;

// Store customer information in cookies
setcookie(
    "customer_name",
    $customerName,
    time() + (30 * 24 * 60 * 60),
    "/",
    "",
    false,
    true
);

setcookie(
    "customer_preference",
    $preference,
    time() + (30 * 24 * 60 * 60),
    "/",
    "",
    false,
    true
);

setcookie(
    "visit_count",
    $visitCount,
    time() + (30 * 24 * 60 * 60),
    "/",
    "",
    false,
    true
);

// Store the current visit date and time
$visitDateTime = date("d-m-Y h:i:s A");

// Escape values before displaying
$safeName = htmlspecialchars($customerName, ENT_QUOTES, "UTF-8");
$safePreference = htmlspecialchars($preference, ENT_QUOTES, "UTF-8");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Information</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">
    <div class="card">

        <h1>Welcome, <?php echo $safeName; ?>! 🎉</h1>

        <p class="subtitle">
            Your visit information has been successfully saved.
        </p>

        <div class="result-box">

            <div class="result-item">
                <span>Customer Name</span>
                <strong><?php echo $safeName; ?></strong>
            </div>

            <div class="result-item">
                <span>Selected Preference</span>
                <strong><?php echo $safePreference; ?> Theme</strong>
            </div>

            <div class="result-item">
                <span>Total Visits</span>
                <strong><?php echo $visitCount; ?></strong>
            </div>

            <div class="result-item">
                <span>Current Visit</span>
                <strong><?php echo $visitDateTime; ?></strong>
            </div>

        </div>

        <?php if ($visitCount > 1): ?>

            <div class="success">
                👋 Welcome back, <?php echo $safeName; ?>!
                <br>
                This is your visit number <?php echo $visitCount; ?>.
            </div>

        <?php else: ?>

            <div class="success">
                🌟 Welcome to our website, <?php echo $safeName; ?>!
                <br>
                This is your first visit.
            </div>

        <?php endif; ?>

        <a href="index.html" class="back-button">
            Back to Home
        </a>

    </div>
</div>

</body>
</html>