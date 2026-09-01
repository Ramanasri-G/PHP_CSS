<?php

$fileName = "article.txt";

try {

    // Check whether the file exists
    if (!file_exists($fileName)) {
        throw new Exception("Article file does not exist.");
    }

    // Check whether the file is readable
    if (!is_readable($fileName)) {
        throw new Exception("Article file cannot be read.");
    }

    // Read the complete file
    $articleContent = file_get_contents($fileName);

    if ($articleContent === false) {
        throw new Exception("Unable to read the article file.");
    }

    // Read file lines
    $lines = file($fileName, FILE_IGNORE_NEW_LINES);

    if ($lines === false) {
        throw new Exception("Unable to process article lines.");
    }

    // Count number of lines
    $lineCount = count($lines);

    // Secure output
    $safeContent = htmlspecialchars(
        $articleContent,
        ENT_QUOTES,
        "UTF-8"
    );

} catch (Exception $error) {

    $errorMessage = $error->getMessage();

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Article Details</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <div class="card">

        <?php if (isset($errorMessage)): ?>

            <div class="error">
                <h2>⚠ Error</h2>
                <p><?php echo htmlspecialchars($errorMessage); ?></p>
            </div>

        <?php else: ?>

            <div class="article-header">

                <h1>📄 Article Details</h1>

                <span class="line-count">
                    Total Lines: <?php echo $lineCount; ?>
                </span>

            </div>

            <div class="success">
                ✓ Article file read successfully.
            </div>

            <div class="article-content">
                <?php echo $safeContent; ?>
            </div>

        <?php endif; ?>

        <a href="index.html" class="back-button">
            ← Back to Home
        </a>

    </div>

</div>

</body>
</html>