<?php
session_start();
include 'db.php';


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['make_sale'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if ($product && $product['stock'] >= $quantity) {
        $total_price = $product['price'] * $quantity;

        
        $stmt = $pdo->prepare("INSERT INTO sales (product_id, quantity, total_price) VALUES (?, ?, ?)");
        $stmt->execute([$product_id, $quantity, $total_price]);

       
        $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$quantity, $product_id]);

        echo "<p class='text-green-500'>Sale completed successfully!</p>";
    } else {
        echo "<p class='text-red-500'>Not enough stock available.</p>";
    }
}


$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Sales</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6">Make a Sale</h1>

        <form method="POST" class="space-y-4">
            <div>
                <label for="product" class="block text-sm font-medium text-gray-700">Select Product</label>
                <select name="product_id" id="product" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select Product</option>
                    <?php foreach ($products as $product) : ?>
                        <option value="<?= $product['id'] ?>">
                            <?= htmlspecialchars($product['name']) ?> - $<?= htmlspecialchars($product['price']) ?> (Stock: <?= htmlspecialchars($product['stock']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" placeholder="Enter quantity" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" min="1">
            </div>

            <div>
                <button type="submit" name="make_sale" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">Complete Sale</button>
            </div>
        </form>

        <div class="mt-6">
            <a href="index.php" class="text-indigo-600 hover:text-indigo-700">Back to Product Management</a>
            <br>
            <a href="report.php" class="text-indigo-600 hover:text-indigo-700">View Sales Report</a>
            <br>
            <a href="logout.php" class="text-red-600 hover:text-red-700">Logout</a>
        </div>
    </div>
</body>
</html>
