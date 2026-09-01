<?php
session_start();

// Sample products
$products = [
    1 => ["name" => "Laptop", "price" => 55000],
    2 => ["name" => "Smartphone", "price" => 25000],
    3 => ["name" => "Headphones", "price" => 2000],
    4 => ["name" => "Smart Watch", "price" => 3500]
];

// Initialize cart and browsing history
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

// Login
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);

    if ($username != "") {
        $_SESSION['username'] = $username;

        // Store username in cookie for 7 days
        setcookie("username", $username, time() + (7 * 24 * 60 * 60));

        $message = "Login successful!";
    } else {
        $message = "Please enter your username.";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();

    setcookie("username", "", time() - 3600);

    header("Location: index.php");
    exit();
}

// Add product to cart
if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];

    if (isset($products[$id])) {
        $_SESSION['cart'][] = $id;

        // Add product to browsing history
        if (!in_array($id, $_SESSION['history'])) {
            $_SESSION['history'][] = $id;
        }
    }
}

// View product
if (isset($_GET['view'])) {
    $id = (int)$_GET['view'];

    if (isset($products[$id])) {
        if (!in_array($id, $_SESSION['history'])) {
            $_SESSION['history'][] = $id;
        }
    }
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $index = (int)$_GET['remove'];

    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shopping User Management</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h1>🛒 Online Shopping</h1>

    <?php if (isset($_SESSION['username'])): ?>
        <div class="user-area">
            Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
            <a href="?logout=1" class="logout">Logout</a>
        </div>
    <?php else: ?>
        <div class="login-area">
            <form method="post">
                <input type="text" name="username" placeholder="Enter username">
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    <?php endif; ?>
</header>

<?php if (isset($message)): ?>
    <div class="message">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<main>

    <section class="products">
        <h2>Products</h2>

        <div class="product-container">

            <?php foreach ($products as $id => $product): ?>

                <div class="product-card">
                    <h3><?php echo $product['name']; ?></h3>

                    <p class="price">
                        ₹<?php echo number_format($product['price']); ?>
                    </p>

                    <a href="?view=<?php echo $id; ?>" class="view-btn">
                        View Product
                    </a>

                    <a href="?add=<?php echo $id; ?>" class="cart-btn">
                        Add to Cart
                    </a>
                </div>

            <?php endforeach; ?>

        </div>
    </section>

    <section class="side-panel">

        <!-- Shopping Cart -->
        <div class="box">
            <h2>🛍️ Shopping Cart</h2>

            <?php if (empty($_SESSION['cart'])): ?>

                <p>Your cart is empty.</p>

            <?php else: ?>

                <?php
                $total = 0;

                foreach ($_SESSION['cart'] as $index => $id):
                    $total += $products[$id]['price'];
                ?>

                    <div class="cart-item">
                        <span>
                            <?php echo $products[$id]['name']; ?>
                        </span>

                        <span>
                            ₹<?php echo number_format($products[$id]['price']); ?>
                        </span>

                        <a href="?remove=<?php echo $index; ?>">Remove</a>
                    </div>

                <?php endforeach; ?>

                <h3 class="total">
                    Total: ₹<?php echo number_format($total); ?>
                </h3>

            <?php endif; ?>
        </div>


        <!-- Browsing History -->
        <div class="box">
            <h2>🕘 Browsing History</h2>

            <?php if (empty($_SESSION['history'])): ?>

                <p>No browsing history.</p>

            <?php else: ?>

                <ul class="history">

                    <?php foreach ($_SESSION['history'] as $id): ?>

                        <li>
                            <?php echo $products[$id]['name']; ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            <?php endif; ?>

        </div>


        <!-- Cookie Information -->
        <div class="box cookie-box">
            <h2>🍪 Cookie Status</h2>

            <?php if (isset($_COOKIE['username'])): ?>

                <p>
                    Saved username:
                    <strong>
                        <?php echo htmlspecialchars($_COOKIE['username']); ?>
                    </strong>
                </p>

            <?php else: ?>

                <p>No username cookie found.</p>

            <?php endif; ?>

        </div>

    </section>

</main>

<footer>
    <p>Online Shopping User Management System</p>
    <p>PHP | Cookies | Sessions</p>
</footer>

</body>
</html>