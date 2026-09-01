<?php
session_start();

$message = "";

// Login
if (isset($_POST['login'])) {

    $user = $_POST['username'];

    $_SESSION['user'] = $user;
    setcookie("last_user", $user, time() + 3600);

    $time = date("Y-m-d H:i:s");

    file_put_contents(
        "login_log.txt",
        "$user logged in - $time\n",
        FILE_APPEND
    );

    $message = "Welcome, $user!";
}

// File access
if (isset($_GET['file']) && isset($_SESSION['user'])) {

    $user = $_SESSION['user'];
    $file = basename($_GET['file']);
    $time = date("Y-m-d H:i:s");

    file_put_contents(
        "access_log.txt",
        "$user accessed $file - $time\n",
        FILE_APPEND
    );

    $message = "File accessed successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Activity Log System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="header">
    <h1>USER ACTIVITY</h1>
    <p>Login & File Access Monitoring</p>
</div>

<div class="container">

<?php if (!isset($_SESSION['user'])) { ?>

    <h2>Login</h2>

    <form method="post">
        <input type="text" name="username"
               placeholder="Enter username" required>

        <button name="login">Login</button>
    </form>

<?php } else { ?>

    <h2>Welcome, <?php echo $_SESSION['user']; ?></h2>

    <p class="message"><?php echo $message; ?></p>

    <h3>Available Files</h3>

    <div class="files">
        <a href="?file=Report.pdf">📄 Report.pdf</a>
        <a href="?file=Notes.txt">📝 Notes.txt</a>
        <a href="?file=Project.docx">📁 Project.docx</a>
    </div>

    <h3>Activity Report</h3>

    <div class="logs">

        <b>Login History</b>
        <pre><?php
        if (file_exists("login_log.txt"))
            echo file_get_contents("login_log.txt");
        ?></pre>

        <b>File Access History</b>
        <pre><?php
        if (file_exists("access_log.txt"))
            echo file_get_contents("access_log.txt");
        ?></pre>

    </div>

<?php } ?>

</div>

</body>
</html>