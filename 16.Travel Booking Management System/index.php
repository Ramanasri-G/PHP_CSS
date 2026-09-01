<?php
session_start();

if (isset($_POST['book'])) {
    $name = $_POST['name'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];

    $_SESSION['name'] = $name;
    $_SESSION['destination'] = $destination;
    $_SESSION['date'] = $date;

    $data = "$name | $destination | $date\n";
    file_put_contents("bookings.txt", $data, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Travel Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Travel Booking System</h2>

    <form method="post">
        <label>Customer Name</label>
        <input type="text" name="name" required>

        <label>Destination</label>
        <select name="destination">
            <option>Chennai</option>
            <option>Bangalore</option>
            <option>Coimbatore</option>
            <option>Madurai</option>
        </select>

        <label>Travel Date</label>
        <input type="date" name="date" required>

        <input type="submit" name="book" value="Book Now">
    </form>

    <?php if (isset($_POST['book'])) { ?>
        <div class="confirmation">
            <h3>Booking Confirmed!</h3>
            <p>Customer: <?php echo $_SESSION['name']; ?></p>
            <p>Destination: <?php echo $_SESSION['destination']; ?></p>
            <p>Travel Date: <?php echo $_SESSION['date']; ?></p>
        </div>
    <?php } ?>
</div>

</body>
</html>