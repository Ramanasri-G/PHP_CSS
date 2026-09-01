<?php

$result = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $checkin = $_POST["checkin"] ?? "";
    $checkout = $_POST["checkout"] ?? "";

    if (empty($checkin) || empty($checkout)) {

        $error = "Please select both check-in and check-out dates.";

    } else {

        $checkInDate = new DateTime($checkin);
        $checkOutDate = new DateTime($checkout);

        if ($checkOutDate <= $checkInDate) {

            $error = "Check-out date must be after the check-in date.";

        } else {

            $difference = $checkInDate->diff($checkOutDate);

            $days = $difference->days;

            $result = "Your total stay is " . $days . " day(s) / night(s).";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Hotel Stay Duration Calculator</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <!-- Header -->

    <div class="header">

        <div class="hotel-icon">🏨</div>

        <h1>Hotel Stay Calculator</h1>

        <p>
            Calculate your total stay duration easily
        </p>

    </div>


    <!-- Form -->

    <div class="form-section">

        <h2>Guest Stay Details</h2>

        <p class="subtitle">
            Enter your check-in and check-out dates
        </p>


        <form method="POST" action="">

            <div class="date-container">

                <div class="input-group">

                    <label for="checkin">
                        Check-In Date
                    </label>

                    <input
                        type="date"
                        id="checkin"
                        name="checkin"
                        value="<?php echo htmlspecialchars($_POST['checkin'] ?? ''); ?>"
                        required
                    >

                </div>


                <div class="input-group">

                    <label for="checkout">
                        Check-Out Date
                    </label>

                    <input
                        type="date"
                        id="checkout"
                        name="checkout"
                        value="<?php echo htmlspecialchars($_POST['checkout'] ?? ''); ?>"
                        required
                    >

                </div>

            </div>


            <button type="submit">
                Calculate Stay Duration
            </button>

        </form>


        <!-- Error -->

        <?php if ($error != "") { ?>

            <div class="error">

                ⚠️ <?php echo $error; ?>

            </div>

        <?php } ?>


        <!-- Result -->

        <?php if ($result != "") { ?>

            <div class="result">

                <div class="result-icon">
                    🌟
                </div>

                <div>

                    <h3>Stay Duration</h3>

                    <p>
                        <?php echo $result; ?>
                    </p>

                </div>

            </div>

        <?php } ?>

    </div>


    <!-- Information Cards -->

    <div class="info-section">

        <div class="info-card">

            <span>📅</span>

            <div>
                <h3>Check-In</h3>

                <p>
                    The date when the guest arrives.
                </p>
            </div>

        </div>


        <div class="info-card">

            <span>🚪</span>

            <div>
                <h3>Check-Out</h3>

                <p>
                    The date when the guest leaves.
                </p>
            </div>

        </div>


        <div class="info-card">

            <span>🕐</span>

            <div>
                <h3>Duration</h3>

                <p>
                    Total number of nights between
                    the two dates.
                </p>
            </div>

        </div>

    </div>


    <!-- Footer -->

    <div class="footer">

        Hotel Stay Duration Calculator

        <br>

        <span>
            PHP • DateTime • Date Difference
        </span>

    </div>

</div>

</body>

</html>
