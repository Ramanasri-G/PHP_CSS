<?php

session_start();

// Get form values
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$eventId = $_POST["event"] ?? "";

// Event information
$events = [

    "EVT001" => [
        "name" => "Web Development Workshop",
        "date" => "2026-09-10",
        "time" => "10:00 AM",
        "venue" => "Computer Lab"
    ],

    "EVT002" => [
        "name" => "PHP Programming Seminar",
        "date" => "2026-09-15",
        "time" => "02:00 PM",
        "venue" => "Seminar Hall"
    ],

    "EVT003" => [
        "name" => "Project Presentation",
        "date" => "2026-09-20",
        "time" => "11:00 AM",
        "venue" => "Auditorium"
    ]

];


// Validate input
if ($name == "" || $email == "" || $eventId == "") {

    $_SESSION["message"] =
        "Please fill in all required fields.";

    header("Location: index.php");
    exit();
}


// Check selected event
if (!isset($events[$eventId])) {

    $_SESSION["message"] =
        "Invalid event selected.";

    header("Location: index.php");
    exit();
}


$selectedEvent = $events[$eventId];


// Store registration in session
$_SESSION["registrations"][] = [

    "name" => $name,

    "email" => $email,

    "event" => $selectedEvent["name"],

    "date" => date(
        "d-m-Y",
        strtotime($selectedEvent["date"])
    ),

    "time" => $selectedEvent["time"],

    "registered_at" => date(
        "d-m-Y h:i A"
    )

];


// Create registration file
$folder = "events/";

if (!is_dir($folder)) {

    mkdir($folder, 0777, true);

}


$fileName =
    $folder .
    $eventId .
    "_registrations.txt";


$registrationData =
    "EVENT REGISTRATION\n";

$registrationData .=
    "============================\n";

$registrationData .=
    "Participant : " . $name . "\n";

$registrationData .=
    "Email       : " . $email . "\n";

$registrationData .=
    "Event       : " .
    $selectedEvent["name"] . "\n";

$registrationData .=
    "Date        : " .
    date(
        "d-m-Y",
        strtotime($selectedEvent["date"])
    ) . "\n";

$registrationData .=
    "Time        : " .
    $selectedEvent["time"] . "\n";

$registrationData .=
    "Venue       : " .
    $selectedEvent["venue"] . "\n";

$registrationData .=
    "Registered  : " .
    date("d-m-Y h:i A") . "\n";

$registrationData .=
    "============================\n\n";


// Save registration
file_put_contents(
    $fileName,
    $registrationData,
    FILE_APPEND
);


// Success message
$_SESSION["message"] =
    "Registration completed successfully!";


header("Location: index.php");

exit();

?>

