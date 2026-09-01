<?php
$message = "";

if (isset($_POST['backup'])) {

    $student = $_POST['student'];
    $mark = $_POST['mark'];

    // Store student record
    $record = "Student: $student | Mark: $mark\n";
    file_put_contents("students.txt", $record, FILE_APPEND);

    // Create backup
    $time = date("Y-m-d_H-i-s");
    $backup = "backup_$time.txt";

    copy("students.txt", $backup);

    // Record backup information
    $info = "Backup: $backup | Time: " . date("Y-m-d H:i:s") . "\n";
    file_put_contents("backup_log.txt", $info, FILE_APPEND);

    $message = "Student record saved and backup created!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Records Backup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>Student Records Backup System</h2>

    <form method="post">
        <label>Student Name</label>
        <input type="text" name="student" required>

        <label>Mark</label>
        <input type="number" name="mark" required>

        <button type="submit" name="backup">Save & Backup</button>
    </form>

    <p class="message"><?php echo $message; ?></p>

</div>

</body>
</html>