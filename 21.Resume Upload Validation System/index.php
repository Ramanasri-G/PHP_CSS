<?php
$message = "";

if (isset($_POST['upload'])) {

    $file = $_FILES['resume'];
    $name = $file['name'];
    $size = $file['size'];
    $tmp = $file['tmp_name'];

    $allowed = ["pdf", "doc", "docx"];
    $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if ($file['error'] != 0) {
        $message = "Error: Please select a valid file.";
    }
    elseif (!in_array($extension, $allowed)) {
        $message = "Error: Only PDF, DOC and DOCX files are allowed.";
    }
    elseif ($size > 2 * 1024 * 1024) {
        $message = "Error: File size must be below 2 MB.";
    }
    else {
        if (!is_dir("resumes")) {
            mkdir("resumes");
        }

        move_uploaded_file($tmp, "resumes/" . basename($name));
        $message = "Resume uploaded successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resume Upload Validation</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Resume Upload</h1>
    <p class="subtitle">Job Applicant Resume Submission</p>

    <form method="post" enctype="multipart/form-data">

        <label>Select Resume</label>

        <input type="file" name="resume" required>

        <p class="note">
            Allowed formats: PDF, DOC, DOCX | Maximum size: 2 MB
        </p>

        <button type="submit" name="upload">
            Upload Resume
        </button>

    </form>

    <?php if ($message != "") { ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
    <?php } ?>

</div>

</body>
</html>