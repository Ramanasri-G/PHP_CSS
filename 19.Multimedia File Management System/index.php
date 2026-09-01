<?php
$folder = "media/";
$message = "";

if (!is_dir($folder)) {
    mkdir($folder);
}

if (isset($_POST['upload'])) {
    $file = $_FILES['file'];
    $category = $_POST['category'];

    $path = $folder . $category . "/";
    
    if (!is_dir($path)) {
        mkdir($path);
    }

    move_uploaded_file($file['tmp_name'], $path . $file['name']);
    $message = "File uploaded successfully!";
}

$search = "";
if (isset($_GET['search'])) {
    $search = strtolower($_GET['search']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Multimedia File Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Multimedia File Management System</h1>
    <p class="subtitle">Manage Images and Videos</p>

    <form method="post" enctype="multipart/form-data">
        <label>Select Multimedia File</label>
        <input type="file" name="file" required>

        <label>Category</label>
        <select name="category">
            <option value="images">Images</option>
            <option value="videos">Videos</option>
        </select>

        <button type="submit" name="upload">Upload File</button>
    </form>

    <p class="message"><?php echo $message; ?></p>

    <hr>

    <h2>Search Multimedia Files</h2>

    <form method="get">
        <input type="text" name="search"
               placeholder="Enter file name"
               value="<?php echo $search; ?>">
        <button type="submit">Search</button>
    </form>

    <div class="files">
        <?php
        foreach (["images", "videos"] as $category) {

            $path = $folder . $category;

            if (is_dir($path)) {
                $files = scandir($path);

                foreach ($files as $file) {

                    if ($file != "." && $file != ".." &&
                        ($search == "" ||
                        strpos(strtolower($file), $search) !== false)) {

                        echo "<p>📁 $category / $file</p>";
                    }
                }
            }
        }
        ?>
    </div>

</div>

</body>
</html>