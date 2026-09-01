<?php

session_start();

// Create events folder if it does not exist
$folder = "events/";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

// Initialize registration session
if (!isset($_SESSION["registrations"])) {
    $_SESSION["registrations"] = [];
}

// Current date
$today = date("Y-m-d");

// Sample events
$events = [
    [
        "id" => "EVT001",
        "name" => "Web Development Workshop",
        "date" => "2026-09-10",
        "time" => "10:00 AM",
        "venue" => "Computer Lab"
    ],
    [
        "id" => "EVT002",
        "name" => "PHP Programming Seminar",
        "date" => "2026-09-15",
        "time" => "02:00 PM",
        "venue" => "Seminar Hall"
    ],
    [
        "id" => "EVT003",
        "name" => "Project Presentation",
        "date" => "2026-09-20",
        "time" => "11:00 AM",
        "venue" => "Auditorium"
    ]
];

// Save events to files
foreach ($events as $event) {

    $file = $folder . $event["id"] . ".txt";

    $data = "EVENT INFORMATION\n";
    $data .= "============================\n";
    $data .= "Event ID : " . $event["id"] . "\n";
    $data .= "Event    : " . $event["name"] . "\n";
    $data .= "Date     : " . $event["date"] . "\n";
    $data .= "Time     : " . $event["time"] . "\n";
    $data .= "Venue    : " . $event["venue"] . "\n";

    file_put_contents($file, $data);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Event Registration System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <!-- Header -->

    <div class="header">

        <div class="event-icon">🎫</div>

        <h1>Event Registration</h1>

        <p>
            Event Scheduling & Registration System
        </p>

    </div>


    <!-- Current Date -->

    <div class="date-banner">

        <span>📅 Today's Date</span>

        <strong>
            <?php echo date("l, d F Y"); ?>
        </strong>

    </div>


    <!-- Registration Message -->

    <?php if (isset($_SESSION["message"])) { ?>

        <div class="success">

            ✓ <?php echo htmlspecialchars($_SESSION["message"]); ?>

        </div>

        <?php unset($_SESSION["message"]); ?>

    <?php } ?>


    <!-- Registration Form -->

    <div class="registration-section">

        <h2>Register for an Event</h2>

        <p class="subtitle">
            Enter your details and select an upcoming event
        </p>

        <form action="register.php" method="POST">

            <div class="form-row">

                <div class="form-group">

                    <label for="name">
                        Participant Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your name"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>

            </div>


            <div class="form-group">

                <label for="event">
                    Select Event
                </label>

                <select id="event" name="event" required>

                    <option value="">
                        -- Select an Event --
                    </option>

                    <?php foreach ($events as $event) { ?>

                        <option value="<?php
                            echo htmlspecialchars($event["id"]);
                        ?>">

                            <?php
                            echo htmlspecialchars($event["name"]);
                            ?>
                            -
                            <?php
                            echo date(
                                "d M Y",
                                strtotime($event["date"])
                            );
                            ?>

                        </option>

                    <?php } ?>

                </select>

            </div>


            <button type="submit">
                🎟 Register Now
            </button>

        </form>

    </div>


    <!-- Event Schedule -->

    <div class="schedule-section">

        <div class="section-heading">

            <div>

                <h2>Upcoming Events</h2>

                <p>
                    Manage and view scheduled events
                </p>

            </div>

            <span class="calendar">
                📆
            </span>

        </div>


        <div class="event-grid">

            <?php foreach ($events as $event) { ?>

                <?php

                $eventDate = new DateTime($event["date"]);
                $todayDate = new DateTime($today);

                $interval = $todayDate->diff($eventDate);

                if ($eventDate >= $todayDate) {
                    $daysLeft = $interval->days;
                } else {
                    $daysLeft = 0;
                }

                ?>

                <div class="event-card">

                    <div class="event-top">

                        <span class="event-id">
                            <?php echo $event["id"]; ?>
                        </span>

                        <span class="upcoming">
                            Upcoming
                        </span>

                    </div>


                    <h3>
                        <?php echo htmlspecialchars($event["name"]); ?>
                    </h3>


                    <div class="event-detail">

                        <p>
                            📅
                            <?php
                            echo date(
                                "l, d F Y",
                                strtotime($event["date"])
                            );
                            ?>
                        </p>

                        <p>
                            🕐
                            <?php echo $event["time"]; ?>
                        </p>

                        <p>
                            📍
                            <?php echo htmlspecialchars($event["venue"]); ?>
                        </p>

                    </div>


                    <div class="days-left">

                        <?php

                        if ($daysLeft == 0 &&
                            $event["date"] == $today) {

                            echo "Event is Today!";

                        } elseif ($daysLeft > 0) {

                            echo $daysLeft . " day(s) remaining";

                        } else {

                            echo "Event completed";

                        }

                        ?>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>


    <!-- Registered Sessions -->

    <div class="registration-list">

        <h2>Your Registration Session</h2>

        <?php if (count($_SESSION["registrations"]) > 0) { ?>

            <?php foreach ($_SESSION["registrations"] as $registration) { ?>

                <div class="registered">

                    <span>✓</span>

                    <div>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $registration["name"]
                            );
                            ?>
                        </strong>

                        <p>
                            Registered for
                            <b>
                                <?php
                                echo htmlspecialchars(
                                    $registration["event"]
                                );
                                ?>
                            </b>

                            on
                            <?php
                            echo htmlspecialchars(
                                $registration["date"]
                            );
                            ?>
                        </p>

                    </div>

                </div>

            <?php } ?>

        <?php } else { ?>

            <div class="no-registration">

                🎫

                <p>
                    No registrations in the current session.
                </p>

            </div>

        <?php } ?>

    </div>


    <!-- Footer -->

    <div class="footer">

        Event Registration and Scheduling System

        <br>

        <span>
            PHP • Sessions • File Handling • Date Functions
        </span>

    </div>

</div>

</body>
</html>
