<?php
$folder = "shipments/";

// Create shipment directory if it does not exist
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$message = "";
$records = [];

// Add shipment record
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $shipmentId = trim($_POST["shipment_id"]);
    $customer = trim($_POST["customer"]);
    $product = trim($_POST["product"]);
    $destination = trim($_POST["destination"]);
    $status = trim($_POST["status"]);

    // Create a separate file for each shipment
    $fileName = $folder . $shipmentId . ".txt";

    $data = "SHIPMENT RECORD\n";
    $data .= "==============================\n";
    $data .= "Shipment ID : " . $shipmentId . "\n";
    $data .= "Customer    : " . $customer . "\n";
    $data .= "Product     : " . $product . "\n";
    $data .= "Destination : " . $destination . "\n";
    $data .= "Status      : " . $status . "\n";
    $data .= "Date        : " . date("d-m-Y") . "\n";
    $data .= "Time        : " . date("h:i A") . "\n";
    $data .= "==============================\n";

    file_put_contents($fileName, $data);

    $message = "Shipment record saved successfully!";
}

// Retrieve shipment records using directory functions
$files = scandir($folder);

foreach ($files as $file) {

    if ($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) == "txt") {

        $content = file_get_contents($folder . $file);

        $records[] = [
            "file" => $file,
            "content" => $content
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shipment Records Management</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="main-container">

    <div class="header">
        <div class="icon">📦</div>

        <h1>Shipment Records</h1>

        <p>File Management System</p>
    </div>


    <?php if ($message != "") { ?>

        <div class="success">
            ✓ <?php echo $message; ?>
        </div>

    <?php } ?>


    <div class="form-container">

        <h2>Add Shipment</h2>

        <p class="subtitle">
            Enter the shipment details below
        </p>

        <form method="POST" action="">

            <div class="form-row">

                <div class="form-group">
                    <label>Shipment ID</label>

                    <input type="text"
                           name="shipment_id"
                           placeholder="Example: SHP001"
                           required>
                </div>


                <div class="form-group">
                    <label>Customer Name</label>

                    <input type="text"
                           name="customer"
                           placeholder="Enter customer name"
                           required>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group">
                    <label>Product Name</label>

                    <input type="text"
                           name="product"
                           placeholder="Enter product name"
                           required>
                </div>


                <div class="form-group">
                    <label>Destination</label>

                    <input type="text"
                           name="destination"
                           placeholder="Enter destination"
                           required>
                </div>

            </div>


            <div class="form-group">

                <label>Shipment Status</label>

                <select name="status" required>

                    <option value="">
                        Select shipment status
                    </option>

                    <option value="Processing">
                        Processing
                    </option>

                    <option value="Shipped">
                        Shipped
                    </option>

                    <option value="In Transit">
                        In Transit
                    </option>

                    <option value="Delivered">
                        Delivered
                    </option>

                </select>

            </div>


            <button type="submit">
                📦 Save Shipment Record
            </button>

        </form>

    </div>


    <div class="records-container">

        <div class="records-header">

            <div>
                <h2>Shipment Records</h2>

                <p>
                    Total Records:
                    <strong><?php echo count($records); ?></strong>
                </p>
            </div>

            <div class="folder-icon">
                📁
            </div>

        </div>


        <?php if (count($records) > 0) { ?>

            <div class="records-grid">

                <?php foreach ($records as $record) { ?>

                    <div class="record-card">

                        <div class="card-title">
                            📄
                            <?php echo htmlspecialchars($record["file"]); ?>
                        </div>

                        <pre><?php
                            echo htmlspecialchars($record["content"]);
                        ?></pre>

                    </div>

                <?php } ?>

            </div>

        <?php } else { ?>

            <div class="empty">

                <div class="empty-icon">📦</div>

                <h3>No Shipment Records</h3>

                <p>
                    Add your first shipment record using the form above.
                </p>

            </div>

        <?php } ?>

    </div>


    <div class="footer">

        <p>
            Shipment Records File Management System
        </p>

        <span>
            PHP • File Handling • Directory Management
        </span>

    </div>

</div>

</body>
</html>
