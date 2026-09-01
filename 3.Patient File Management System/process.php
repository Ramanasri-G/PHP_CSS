<?php

$folder = "patients/";

try {

    // Create patients folder if it does not exist
    if (!is_dir($folder)) {

        if (!mkdir($folder, 0777, true)) {
            throw new Exception("Unable to create patients directory.");
        }
    }

    // Check form submission
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: index.html");
        exit();
    }

    // Get form values
    $operation = $_POST["operation"] ?? "";
    $patientId = trim($_POST["patient_id"] ?? "");
    $patientName = trim($_POST["patient_name"] ?? "");
    $age = trim($_POST["age"] ?? "");
    $gender = trim($_POST["gender"] ?? "");
    $department = trim($_POST["department"] ?? "");
    $diagnosis = trim($_POST["diagnosis"] ?? "");


    // Validate Patient ID
    if ($patientId === "") {
        throw new Exception("Patient ID is required.");
    }

    // Allow only letters and numbers in Patient ID
    if (!preg_match("/^[A-Za-z0-9]+$/", $patientId)) {
        throw new Exception("Invalid Patient ID.");
    }


    // Department file mapping
    $departmentFiles = [
        "Cardiology" => "cardiology.txt",
        "Neurology" => "neurology.txt",
        "Orthopedics" => "orthopedics.txt",
        "General Medicine" => "general_medicine.txt"
    ];


    // Validate department
    if (!isset($departmentFiles[$department])) {
        throw new Exception("Invalid department selected.");
    }


    $file = $folder . $departmentFiles[$department];


    /*
     * ADD PATIENT
     */
    if ($operation === "add") {

        // Validate required patient details
        if ($patientName === "") {
            throw new Exception("Patient name is required.");
        }

        if ($age === "" || !is_numeric($age) || $age < 1 || $age > 120) {
            throw new Exception("Please enter a valid age.");
        }

        if ($gender === "") {
            throw new Exception("Please select gender.");
        }

        if ($diagnosis === "") {
            throw new Exception("Diagnosis is required.");
        }


        // Check duplicate patient ID
        $existingRecords = file($file, FILE_IGNORE_NEW_LINES);

        foreach ($existingRecords as $record) {

            $parts = explode("|", $record);

            if (isset($parts[0]) && $parts[0] === $patientId) {
                throw new Exception(
                    "Patient ID already exists in the selected department."
                );
            }
        }


        // Create patient record
        $record =
            $patientId . "|" .
            $patientName . "|" .
            $age . "|" .
            $gender . "|" .
            $department . "|" .
            $diagnosis . "|" .
            date("d-m-Y H:i:s") .
            PHP_EOL;


        // Store record in department file
        if (file_put_contents($file, $record, FILE_APPEND | LOCK_EX) === false) {
            throw new Exception("Unable to save patient record.");
        }


        $message = "Patient record added successfully.";

    }


    /*
     * SEARCH PATIENT
     */
    elseif ($operation === "search") {

        if (!file_exists($file)) {
            throw new Exception("No records found for this department.");
        }


        $records = file($file, FILE_IGNORE_NEW_LINES);

        $foundPatient = null;


        foreach ($records as $record) {

            $parts = explode("|", $record);

            if (count($parts) >= 7 && $parts[0] === $patientId) {

                $foundPatient = $parts;
                break;
            }
        }


        if ($foundPatient === null) {
            throw new Exception(
                "Patient record not found for ID: " . $patientId
            );
        }


        $message = "Patient record retrieved successfully.";

    }


    else {
        throw new Exception("Invalid operation.");
    }


} catch (Exception $e) {

    $errorMessage = $e->getMessage();
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

    <title>Patient Record</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <div class="result-card">

        <h1>🏥 Patient Record</h1>


        <?php if (isset($errorMessage)): ?>

            <div class="error">

                <strong>⚠ Error</strong>

                <p>
                    <?php
                    echo htmlspecialchars(
                        $errorMessage,
                        ENT_QUOTES,
                        "UTF-8"
                    );
                    ?>
                </p>

            </div>


        <?php else: ?>

            <div class="success">

                ✓
                <?php
                echo htmlspecialchars(
                    $message,
                    ENT_QUOTES,
                    "UTF-8"
                );
                ?>

            </div>


            <?php if ($operation === "add"): ?>

                <div class="patient-details">

                    <div class="detail">
                        <span>Patient ID</span>
                        <strong>
                            <?php echo htmlspecialchars($patientId); ?>
                        </strong>
                    </div>

                    <div class="detail">
                        <span>Patient Name</span>
                        <strong>
                            <?php echo htmlspecialchars($patientName); ?>
                        </strong>
                    </div>

                    <div class="detail">
                        <span>Department</span>
                        <strong>
                            <?php echo htmlspecialchars($department); ?>
                        </strong>
                    </div>

                    <div class="detail">
                        <span>Status</span>
                        <strong>Record Saved</strong>
                    </div>

                </div>


            <?php elseif ($operation === "search"): ?>

                <div class="patient-details">

                    <div class="detail">
                        <span>Patient ID</span>
                        <strong>
                            <?php echo htmlspecialchars($foundPatient[0]); ?>
                        </strong>
                    </div>

                    <div class="detail">
                        <span>Patient Name</span>
                        <strong>
                            <?php echo htmlspecialchars($foundPatient[1]); ?>
                        </strong>
                    </div>

                    <div class="detail">
                        <span>Age</span>
                        <strong>
                            <?php echo htmlspecialchars($foundPatient[2]); ?>
                        </strong>
                    </div>

                    <div class="detail">
                        <span>Gender</span>
                        <strong>
                            <?php echo htmlspecialchars($foundPatient[3]); ?>
                        </strong>
                    </div>

                    <div class="detail">
                        <span>Department</span>
                        <strong>
                            <?php echo htmlspecialchars($foundPatient[4]); ?>
                        </strong>
                    </div>

                    <div class="detail">
                        <span>Diagnosis</span>
                        <strong>
                            <?php echo htmlspecialchars($foundPatient[5]); ?>
                        </strong>
                    </div>

                    <div class="detail">
                        <span>Recorded On</span>
                        <strong>
                            <?php echo htmlspecialchars($foundPatient[6]); ?>
                        </strong>
                    </div>

                </div>

            <?php endif; ?>

        <?php endif; ?>


        <a href="index.html" class="back-button">
            ← Back to Patient Management
        </a>

    </div>

</div>

</body>
</html>