<?php
session_start();

$file = "student_activities.txt";

// Initialize session
if (!isset($_SESSION['activities'])) {
    $_SESSION['activities'] = [];
}

$message = "";

// Add activity
if (isset($_POST['add_activity'])) {

    $name = trim($_POST['student_name']);
    $activity = trim($_POST['activity']);
    $date = $_POST['activity_date'];

    if ($name != "" && $activity != "" && $date != "") {

        // Store activity in session
        $_SESSION['activities'][] = [
            "name" => $name,
            "activity" => $activity,
            "date" => $date
        ];

        // Store activity in text file
        $record = $name . "|" . $activity . "|" . $date . PHP_EOL;
        file_put_contents($file, $record, FILE_APPEND);

        $message = "Student activity added successfully!";
    } else {
        $message = "Please fill all fields.";
    }
}

// Load records from file
$fileRecords = [];

if (file_exists($file)) {

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        $data = explode("|", $line);

        if (count($data) == 3) {
            $fileRecords[] = [
                "name" => $data[0],
                "activity" => $data[1],
                "date" => $data[2]
            ];
        }
    }
}

// Generate student summary
$summary = [];

foreach ($fileRecords as $record) {

    $name = $record["name"];

    if (!isset($summary[$name])) {
        $summary[$name] = 0;
    }

    $summary[$name]++;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Activity Report</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>

    <h1>🎓 Student Activity Report System</h1>

    <p>Manage and monitor student activities</p>

</header>


<div class="container">

    <?php if ($message != ""): ?>

        <div class="message">
            <?php echo $message; ?>
        </div>

    <?php endif; ?>


    <!-- Activity Form -->

    <section class="form-box">

        <h2>Add Student Activity</h2>

        <form method="post">

            <label>Student Name</label>

            <input
                type="text"
                name="student_name"
                placeholder="Enter student name"
                required
            >


            <label>Activity</label>

            <input
                type="text"
                name="activity"
                placeholder="Example: Sports, Seminar, Workshop"
                required
            >


            <label>Activity Date</label>

            <input
                type="date"
                name="activity_date"
                required
            >


            <button type="submit" name="add_activity">
                Add Activity
            </button>

        </form>

    </section>


    <!-- Activity Records -->

    <section class="records">

        <h2>📋 Student Activity Records</h2>

        <?php if (count($fileRecords) > 0): ?>

            <table>

                <tr>
                    <th>S.No</th>
                    <th>Student Name</th>
                    <th>Activity</th>
                    <th>Date</th>
                    <th>Formatted Date</th>
                </tr>


                <?php
                $count = 1;

                foreach ($fileRecords as $record):
                ?>

                    <tr>

                        <td>
                            <?php echo $count++; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($record["name"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($record["activity"]); ?>
                        </td>

                        <td>
                            <?php echo $record["date"]; ?>
                        </td>

                        <td>

                            <?php
                            echo date(
                                "d-m-Y",
                                strtotime($record["date"])
                            );
                            ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

        <?php else: ?>

            <p class="empty">
                No activity records found.
            </p>

        <?php endif; ?>

    </section>


    <!-- Student Summary -->

    <section class="summary">

        <h2>📊 Activity Summary</h2>

        <?php if (count($summary) > 0): ?>

            <div class="summary-container">

                <?php foreach ($summary as $student => $total): ?>

                    <div class="summary-card">

                        <h3>
                            <?php echo htmlspecialchars($student); ?>
                        </h3>

                        <p class="number">
                            <?php echo $total; ?>
                        </p>

                        <p>
                            Activities Completed
                        </p>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <p class="empty">
                No student summary available.
            </p>

        <?php endif; ?>

    </section>


    <!-- Session Information -->

    <section class="session-box">

        <h2>🔐 Session Activity Tracking</h2>

        <p>
            Activities recorded in this session:
            <strong>
                <?php echo count($_SESSION['activities']); ?>
            </strong>
        </p>

        <p>
            Current Date:
            <strong>
                <?php echo date("d-m-Y"); ?>
            </strong>
        </p>

        <p>
            Current Time:
            <strong>
                <?php echo date("h:i:s A"); ?>
            </strong>
        </p>

    </section>

</div>


<footer>

    <p>Student Activity Report System</p>
    <p>PHP | File Operations | Sessions | Date Functions</p>

</footer>

</body>

</html>