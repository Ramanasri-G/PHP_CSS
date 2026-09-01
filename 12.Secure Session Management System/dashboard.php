<?php

session_start();

// Check whether user is logged in
if (!isset($_SESSION["username"])) {

    header("Location: index.php");
    exit();
}

$username = $_SESSION["username"];
$loginTime = $_SESSION["login_time"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Secure Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="dashboard">

    <div class="dashboard-header">

        <div>

            <span class="dashboard-label">
                SECURE DASHBOARD
            </span>

            <h1>
                Welcome, <?php echo htmlspecialchars($username); ?> 👋
            </h1>

            <p>
                You have successfully logged in.
            </p>

        </div>

        <a href="logout.php" class="logout">
            Logout
        </a>

    </div>


    <div class="content">

        <div class="card-container">

            <div class="card">

                <div class="card-icon">
                    🔐
                </div>

                <h3>Session Authentication</h3>

                <p>
                    Your login information is stored
                    securely in a PHP session on the server.
                </p>

                <span class="active">
                    ● Active
                </span>

            </div>


            <div class="card">

                <div class="card-icon">
                    🍪
                </div>

                <h3>Cookie Authentication</h3>

                <p>
                    The Remember Me option uses a cookie
                    to remember the user.
                </p>

                <span class="active">
                    ● Available
                </span>

            </div>


            <div class="card">

                <div class="card-icon">
                    🕐
                </div>

                <h3>Login Time</h3>

                <p>
                    Current session started at:
                </p>

                <strong>
                    <?php echo htmlspecialchars($loginTime); ?>
                </strong>

            </div>

        </div>


        <div class="comparison">

            <h2>Sessions vs Cookies</h2>

            <table>

                <tr>
                    <th>Feature</th>
                    <th>Session</th>
                    <th>Cookie</th>
                </tr>

                <tr>
                    <td>Stored In</td>
                    <td>Server</td>
                    <td>Browser</td>
                </tr>

                <tr>
                    <td>Lifetime</td>
                    <td>Temporary</td>
                    <td>Can be persistent</td>
                </tr>

                <tr>
                    <td>Purpose</td>
                    <td>Authentication</td>
                    <td>Remember User</td>
                </tr>

                <tr>
                    <td>Security</td>
                    <td>More Secure</td>
                    <td>Needs Protection</td>
                </tr>

            </table>

        </div>

    </div>


    <div class="footer">
        Secure Session Management System
        <br>
        PHP • Sessions • Cookies
    </div>

</div>

</body>
</html>
