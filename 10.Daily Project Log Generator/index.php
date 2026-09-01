<?php
$message = "";
$logContent = "";

// Create logs folder if it does not exist
$logFolder = "logs/";

if (!is_dir($logFolder)) {
    mkdir($logFolder, 0777, true);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $projectName = trim($_POST["project_name"]);
    $task = trim($_POST["task"]);
    $status = trim($_POST["status"]);
    $hours = trim($_POST["hours"]);

    // Get current date and time
    $date = date("Y-m-d");
    $time = date("h:i A");

    // Create daily log file
    $fileName = $logFolder . "project_log_" . $date . ".txt";

    // Prepare log information
    $logEntry = "----------------------------------------\n";
    $logEntry .= "DAILY PROJECT LOG\n";
    $logEntry .= "----------------------------------------\n";
    $logEntry .= "Date        : " . $date . "\n";
    $logEntry .= "Time        : " . $time . "\n";
    $logEntry .= "Project     : " . $projectName . "\n";
    $logEntry .= "Task        : " . $task . "\n";
    $logEntry .= "Status      : " . $status . "\n";
    $logEntry .= "Hours Worked: " . $hours . "\n";
    $logEntry .= "----------------------------------------\n\n";

    // Store information in the daily file
    file_put_contents($fileName, $logEntry, FILE_APPEND);

    $message = "Project log saved successfully!";
    
    // Read the updated file
    $logContent = file_get_contents($fileName);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Project Log Generator</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Daily Project Log</h1>
        <p>Record and manage your daily project activities</p>
    </div>

    <?php if ($message != ""): ?>
        <div class="success">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">

        <label>Project Name</label>
        <input type="text" name="project_name"
               placeholder="Enter project name" required>

        <label>Task Completed</label>
        <textarea name="task"
                  placeholder="Describe today's completed task"
                  required></textarea>

        <label>Project Status</label>
        <select name="status" required>
            <option value="">-- Select Status --</option>
            <option value="Completed">Completed</option>
            <option value="In Progress">In Progress</option>
            <option value="Pending">Pending</option>
        </select>

        <label>Hours Worked</label>
        <input type="number" name="hours"
               min="0" max="24" step="0.5"
               placeholder="Enter hours worked" required>

        <button type="submit">Save Daily Log</button>

    </form>

    <?php if ($logContent != ""): ?>

        <div class="log-section">
            <h2>Today's Project Log</h2>

            <pre><?php echo htmlspecialchars($logContent); ?></pre>
        </div>

    <?php endif; ?>

</div>

</body>
</html>

