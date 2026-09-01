<?php

$file = "students.txt";
$message = "";

// Add new student record
if (isset($_POST['add_student'])) {

    $name = trim($_POST['name']);
    $rollno = trim($_POST['rollno']);
    $department = trim($_POST['department']);
    $mark = trim($_POST['mark']);

    if ($name != "" && $rollno != "" && $department != "" && $mark != "") {

        // Create student record
        $record = $rollno . "|" . $name . "|" . $department . "|" . $mark . PHP_EOL;

        // Append record to existing file
        file_put_contents($file, $record, FILE_APPEND);

        $message = "Student record added successfully!";

    } else {

        $message = "Please fill in all fields.";
    }
}

// Read existing student records
$students = [];

if (file_exists($file)) {

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        $data = explode("|", $line);

        if (count($data) == 4) {

            $students[] = [
                "rollno" => $data[0],
                "name" => $data[1],
                "department" => $data[2],
                "mark" => $data[3]
            ];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Records File Update System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header>

    <h1>🎓 Student Records File Update System</h1>

    <p>Maintain and update student records using PHP file operations</p>

</header>


<div class="container">

    <?php if ($message != ""): ?>

        <div class="message">

            <?php echo $message; ?>

        </div>

    <?php endif; ?>


    <!-- Student Form -->

    <section class="form-box">

        <h2>➕ Add New Student</h2>

        <form method="post">

            <label>Roll Number</label>

            <input
                type="text"
                name="rollno"
                placeholder="Enter roll number"
                required
            >


            <label>Student Name</label>

            <input
                type="text"
                name="name"
                placeholder="Enter student name"
                required
            >


            <label>Department</label>

            <input
                type="text"
                name="department"
                placeholder="Enter department"
                required
            >


            <label>Mark</label>

            <input
                type="number"
                name="mark"
                placeholder="Enter mark"
                min="0"
                max="100"
                required
            >


            <button type="submit" name="add_student">
                Add Student Record
            </button>

        </form>

    </section>


    <!-- Student Records -->

    <section class="records">

        <h2>📋 Updated Student Records</h2>

        <?php if (count($students) > 0): ?>

            <table>

                <tr>

                    <th>S.No</th>
                    <th>Roll Number</th>
                    <th>Student Name</th>
                    <th>Department</th>
                    <th>Mark</th>

                </tr>


                <?php

                $count = 1;

                foreach ($students as $student):

                ?>

                    <tr>

                        <td>
                            <?php echo $count++; ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars($student["rollno"]);
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars($student["name"]);
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars($student["department"]);
                            ?>
                        </td>

                        <td class="mark">

                            <?php
                            echo htmlspecialchars($student["mark"]);
                            ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

        <?php else: ?>

            <p class="empty">
                No student records found.
            </p>

        <?php endif; ?>

    </section>


    <!-- File Information -->

    <section class="file-info">

        <h2>📁 File Information</h2>

        <p>
            File Name:
            <strong>students.txt</strong>
        </p>

        <p>
            Total Student Records:
            <strong><?php echo count($students); ?></strong>
        </p>

        <p>
            File Status:
            <strong>
                <?php
                echo file_exists($file)
                    ? "File Available"
                    : "File Not Created";
                ?>
            </strong>
        </p>

    </section>

</div>


<footer>

    <p>Student Records File Update System</p>

    <p>PHP | File Handling | Append | Display Records</p>

</footer>

</body>

</html>