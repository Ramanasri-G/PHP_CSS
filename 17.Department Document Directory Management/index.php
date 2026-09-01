<?php
$message = "";

if (isset($_POST['create'])) {
    $folder = $_POST['folder'];

    if (!is_dir($folder)) {
        mkdir($folder);
        $message = "Folder created successfully!";
    } else {
        $message = "Folder already exists!";
    }
}

if (isset($_POST['rename'])) {
    $old = $_POST['old'];
    $new = $_POST['new'];

    if (is_dir($old)) {
        rename($old, $new);
        $message = "Folder renamed successfully!";
    } else {
        $message = "Folder not found!";
    }
}

if (isset($_POST['delete'])) {
    $folder = $_POST['delete_folder'];

    if (is_dir($folder)) {
        rmdir($folder);
        $message = "Folder deleted successfully!";
    } else {
        $message = "Folder not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Department Directory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Department Document Directory</h2>

    <form method="post">
        <h3>Create Folder</h3>
        <input type="text" name="folder" placeholder="Folder name" required>
        <button name="create">Create</button>
    </form>

    <form method="post">
        <h3>Rename Folder</h3>
        <input type="text" name="old" placeholder="Old folder name" required>
        <input type="text" name="new" placeholder="New folder name" required>
        <button name="rename">Rename</button>
    </form>

    <form method="post">
        <h3>Delete Folder</h3>
        <input type="text" name="delete_folder" placeholder="Folder name" required>
        <button name="delete">Delete</button>
    </form>

    <p class="message"><?php echo $message; ?></p>
</div>

</body>
</html>