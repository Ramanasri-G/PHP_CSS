<?php

try {

    // Check whether the form is submitted
    if ($_SERVER["REQUEST_METHOD"] != "POST") {

        header("Location: index.html");
        exit();
    }


    // Get student details
    $studentName = trim($_POST["student_name"]);
    $registerNumber = trim($_POST["register_number"]);
    $department = $_POST["department"];


    // Validate student name
    if ($studentName == "") {
        throw new Exception("Student name is required.");
    }


    // Validate register number
    if ($registerNumber == "") {
        throw new Exception("Register number is required.");
    }


    // Allowed departments
    $departments = [
        "BCA",
        "BScCS",
        "BCom",
        "BA"
    ];


    if (!in_array($department, $departments)) {

        throw new Exception("Invalid department selected.");
    }


    // Check uploaded file
    if (!isset($_FILES["assignment"])) {

        throw new Exception("Please select an assignment file.");
    }


    $file = $_FILES["assignment"];


    // Check upload error
    if ($file["error"] != 0) {

        throw new Exception("Error while uploading the file.");
    }


    // Maximum file size = 5 MB
    $maximumSize = 5 * 1024 * 1024;


    if ($file["size"] > $maximumSize) {

        throw new Exception(
            "File size must not exceed 5 MB."
        );
    }


    // Get file extension
    $extension = strtolower(
        pathinfo($file["name"], PATHINFO_EXTENSION)
    );


    // Allowed file types
    $allowedTypes = [
        "pdf",
        "doc",
        "docx",
        "txt"
    ];


    // Validate file type
    if (!in_array($extension, $allowedTypes)) {

        throw new Exception(
            "Invalid file type. Only PDF, DOC, DOCX and TXT files are allowed."
        );
    }


    // Main upload directory
    $mainFolder = "uploads/";


    // Create uploads folder
    if (!is_dir($mainFolder)) {

        mkdir($mainFolder, 0777, true);
    }


    // Create department folder
    $departmentFolder = $mainFolder . $department . "/";


    if (!is_dir($departmentFolder)) {

        mkdir($departmentFolder, 0777, true);
    }


    // Create safe file name
    $safeRegisterNumber = preg_replace(
        "/[^A-Za-z0-9_-]/",
        "_",
        $registerNumber
    );


    $safeStudentName = preg_replace(
        "/[^A-Za-z0-9_-]/",
        "_",
        $studentName
    );


    // Generate new file name
    $newFileName =
        $safeRegisterNumber . "_" .
        $safeStudentName . "_" .
        time() . "." .
        $extension;


    // Final destination
    $destination =
        $departmentFolder . $newFileName;


    // Move uploaded file
    if (!move_uploaded_file(
        $file["tmp_name"],
        $destination
    )) {

        throw new Exception(
            "Unable to save the uploaded assignment."
        );
    }


    // File size in KB
    $fileSize = round(
        $file["size"] / 1024,
        2
    );


    $success = true;


} catch (Exception $e) {

    $success = false;

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

    <title>Upload Result</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

<div class="result">

    <h1>📋 Submission Result</h1>


    <?php if ($success): ?>

        <div class="success">

            <strong>
                ✅ Assignment uploaded successfully!
            </strong>

        </div>


        <div class="details">

            <p>
                <b>Student Name:</b>
                <?php
                echo htmlspecialchars($studentName);
                ?>
            </p>

            <p>
                <b>Register Number:</b>
                <?php
                echo htmlspecialchars($registerNumber);
                ?>
            </p>

            <p>
                <b>Department:</b>
                <?php
                echo htmlspecialchars($department);
                ?>
            </p>

            <p>
                <b>File Name:</b>
                <?php
                echo htmlspecialchars($file["name"]);
                ?>
            </p>

            <p>
                <b>File Type:</b>
                <?php
                echo strtoupper($extension);
                ?>
            </p>

            <p>
                <b>File Size:</b>
                <?php
                echo $fileSize;
                ?> KB
            </p>

            <p>
                <b>Stored In:</b>
                uploads/<?php
                echo htmlspecialchars($department);
                ?>/
            </p>

            <p>
                <b>Submission Date:</b>
                <?php
                echo date("d-m-Y h:i:s A");
                ?>
            </p>

        </div>


    <?php else: ?>

        <div class="error">

            <strong>❌ Upload Failed</strong>

            <p>
                <?php
                echo htmlspecialchars($errorMessage);
                ?>
            </p>

        </div>

    <?php endif; ?>


    <a href="index.html" class="back">
        ← Back to Submission
    </a>

</div>

</div>

</body>
</html>