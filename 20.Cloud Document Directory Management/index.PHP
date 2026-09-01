<?php
$folder = "documents/";
$message = "";

if (!is_dir($folder)) {
    mkdir($folder);
}

// Upload document
if (isset($_POST['upload'])) {
    $file = $_FILES['document'];

    if ($file['error'] == 0) {
        move_uploaded_file(
            $file['tmp_name'],
            $folder . basename($file['name'])
        );
        $message = "Document uploaded successfully!";
    }
}

// Delete document
if (isset($_GET['delete'])) {
    $file = $folder . basename($_GET['delete']);

    if (file_exists($file)) {
        unlink($file);
        $message = "Document deleted successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cloud Document Directory</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Cloud Document Directory</h1>
    <p class="subtitle">Secure Document Management System</p>

    <form method="post" enctype="multipart/form-data">

        <label>Upload Document</label>
        <input type="file" name="document" required>

        <button type="submit" name="upload">
            Upload Document
        </button>

    </form>

    <p class="message"><?php echo $message; ?></p>

    <hr>

    <h2>Stored Documents</h2>

    <div class="documents">

    <?php
    $files = scandir($folder);

    foreach ($files as $file) {

        if ($file != "." && $file != "..") {

            echo "<div class='file'>";
            echo "📄 <span>$file</span>";
            echo "<a href='$folder$file' target='_blank'>View</a>";
            echo "<a class='delete' href='?delete=" .
                 urlencode($file) .
                 "'>Delete</a>";
            echo "</div>";
        }
    }
    ?>

    </div>

</div>

</body>
</html>