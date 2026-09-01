<?php

$file = "attendance.txt";


// VIEW ALL RECORDS
if (isset($_GET["action"]) && $_GET["action"] == "view") {

    showRecords();

    exit();
}


// PROCESS FORM
if ($_SERVER["REQUEST_METHOD"] != "POST") {

    header("Location: index.html");

    exit();
}


try {

    $employeeId =
        trim($_POST["employee_id"] ?? "");

    $employeeName =
        trim($_POST["employee_name"] ?? "");

    $department =
        trim($_POST["department"] ?? "");

    $attendanceDate =
        trim($_POST["attendance_date"] ?? "");

    $status =
        trim($_POST["status"] ?? "");


    // Validate Employee ID
    if ($employeeId == "") {
        throw new Exception(
            "Employee ID is required."
        );
    }


    // Validate Employee Name
    if ($employeeName == "") {
        throw new Exception(
            "Employee name is required."
        );
    }


    // Validate Department
    $validDepartments = [
        "HR",
        "IT",
        "Finance",
        "Marketing"
    ];

    if (!in_array(
        $department,
        $validDepartments
    )) {

        throw new Exception(
            "Invalid department."
        );
    }


    // Validate Date
    if ($attendanceDate == "") {

        throw new Exception(
            "Attendance date is required."
        );
    }


    // Validate Status
    $validStatus = [
        "Present",
        "Absent",
        "Leave"
    ];

    if (!in_array(
        $status,
        $validStatus
    )) {

        throw new Exception(
            "Invalid attendance status."
        );
    }


    // Create record
    $record =
        $employeeId . "|" .
        $employeeName . "|" .
        $department . "|" .
        $attendanceDate . "|" .
        $status .
        PHP_EOL;


    // Store record in text file
    $result = file_put_contents(
        $file,
        $record,
        FILE_APPEND | LOCK_EX
    );


    if ($result === false) {

        throw new Exception(
            "Unable to save attendance record."
        );
    }


    $message =
        "Attendance record saved successfully.";

} catch (Exception $e) {

    $message =
        $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Attendance Result</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

<div class="result-card">

    <h1>Attendance Result</h1>


    <?php if (isset($result) && $result !== false): ?>

        <div class="success">

            ✅
            <?php
            echo htmlspecialchars($message);
            ?>

        </div>


        <div class="details">

            <p>
                <b>Employee ID:</b>
                <?php
                echo htmlspecialchars($employeeId);
                ?>
            </p>

            <p>
                <b>Employee Name:</b>
                <?php
                echo htmlspecialchars($employeeName);
                ?>
            </p>

            <p>
                <b>Department:</b>
                <?php
                echo htmlspecialchars($department);
                ?>
            </p>

            <p>
                <b>Attendance Date:</b>
                <?php
                echo htmlspecialchars($attendanceDate);
                ?>
            </p>

            <p>
                <b>Status:</b>
                <?php
                echo htmlspecialchars($status);
                ?>
            </p>

        </div>


    <?php else: ?>

        <div class="error">

            ❌
            <?php
            echo htmlspecialchars($message);
            ?>

        </div>

    <?php endif; ?>


    <a
        href="index.html"
        class="back-button"
    >
        ← Back to Attendance
    </a>


    <a
        href="process.php?action=view"
        class="back-button"
    >
        View All Records
    </a>

</div>

</div>

</body>
</html>


<?php

// FUNCTION TO DISPLAY STORED RECORDS

function showRecords()
{
    global $file;

    ?>

    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <title>Attendance Records</title>

        <link
            rel="stylesheet"
            href="style.css"
        >

    </head>

    <body>

    <div class="container">

    <div class="result-card">

        <h1>
            Employee Attendance Records
        </h1>


        <?php

        if (!file_exists($file)) {

            echo "
            <div class='error'>
                No attendance records found.
            </div>
            ";

        } else {

            $records = file(
                $file,
                FILE_IGNORE_NEW_LINES
            );


            if (count($records) == 0) {

                echo "
                <div class='error'>
                    No attendance records available.
                </div>
                ";

            } else {

                ?>

                <div class="success">

                    Total Records:
                    <b>
                        <?php echo count($records); ?>
                    </b>

                </div>


                <div class="table-container">

                <table>

                    <tr>

                        <th>Employee ID</th>

                        <th>Name</th>

                        <th>Department</th>

                        <th>Date</th>

                        <th>Status</th>

                    </tr>


                    <?php

                    foreach ($records as $record) {

                        $data =
                            explode("|", $record);


                        if (count($data) >= 5) {

                            $statusClass =
                                strtolower(
                                    $data[4]
                                );

                            ?>

                            <tr>

                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $data[0]
                                    );
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $data[1]
                                    );
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $data[2]
                                    );
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $data[3]
                                    );
                                    ?>
                                </td>

                                <td class="<?php
                                    echo $statusClass;
                                ?>">

                                    <?php
                                    echo htmlspecialchars(
                                        $data[4]
                                    );
                                    ?>

                                </td>

                            </tr>

                            <?php
                        }
                    }

                    ?>

                </table>

                </div>

                <?php
            }
        }

        ?>


        <a
            href="index.html"
            class="back-button"
        >
            ← Back to Attendance
        </a>

    </div>

    </div>

    </body>

    </html>

    <?php
}

?>