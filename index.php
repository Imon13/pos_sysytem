<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}


$message = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    if ($price > 0 && $stock >= 0) {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $price, $stock])) {
            $message = "Product added successfully!";
        } else {
            $message = "Failed to add product.";
        }
    } else {
        $message = "Price and stock must be valid positive numbers.";
    }
}


if (isset($_GET['remove_id'])) {
    $id = intval($_GET['remove_id']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$id])) {
        $message = "Product removed successfully!";
    } else {
        $message = "Failed to remove product.";
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
    <title>POS System - Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
        <h1 class="text-2xl font-bold mb-6 text-center">Products</h1>

        
        <?php if ($message): ?>
            <p class="mb-4 text-center text-green-600"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" class="mb-6">
            <div class="mb-4">
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg" placeholder="Product Name" required>
            </div>
            <div class="mb-4">
                <input type="number" step="0.01" name="price" class="w-full px-4 py-2 border rounded-lg" placeholder="Price" required>
            </div>
            <div class="mb-4">
                <input type="number" name="stock" class="w-full px-4 py-2 border rounded-lg" placeholder="Stock Quantity" required>
            </div>
            <button type="submit" name="add_product" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Add Product</button>
        </form>

        <h2 class="text-xl font-bold mb-4">Product List</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border border-gray-300">ID</th>
                    <th class="p-2 border border-gray-300">Name</th>
                    <th class="p-2 border border-gray-300">Price</th>
                    <th class="p-2 border border-gray-300">Stock</th>
                    <th class="p-2 border border-gray-300">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="p-2 border border-gray-300"><?= htmlspecialchars($product['id']) ?></td>
                        <td class="p-2 border border-gray-300"><?= htmlspecialchars($product['name']) ?></td>
                        <td class="p-2 border border-gray-300"><?= htmlspecialchars($product['price']) ?></td>
                        <td class="p-2 border border-gray-300"><?= htmlspecialchars($product['stock']) ?></td>
                        <td class="p-2 border border-gray-300">
                            <a href="?remove_id=<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to remove this product?');" class="text-red-600 hover:text-red-800">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p class="mt-4"><a href="sales.php" class="text-indigo-600 hover:text-indigo-700">Go to Sales</a></p>
        <p><a href="report.php" class="text-indigo-600 hover:text-indigo-700">View Sales Report</a></p>
        <p><a href="logout.php" class="text-indigo-600 hover:text-indigo-700">Logout</a></p>
    </div>
</body>
</html>
