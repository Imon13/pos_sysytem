<?php
session_start();
include 'db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("SELECT sales.id, products.name, sales.quantity, sales.total_price, sales.sale_date
                     FROM sales
                     JOIN products ON sales.product_id = products.id");
$sales = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Sales Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6">Sales Report</h1>

        <table class="min-w-full table-auto bg-white">
            <thead>
                <tr class="bg-indigo-600 text-white">
                    <th class="px-4 py-2">Sale ID</th>
                    <th class="px-4 py-2">Product Name</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Total Price</th>
                    <th class="px-4 py-2">Sale Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale) : ?>
                <tr class="bg-gray-100 border-b">
                    <td class="px-4 py-2"><?= htmlspecialchars($sale['id']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($sale['name']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($sale['quantity']) ?></td>
                    <td class="px-4 py-2">$<?= htmlspecialchars(number_format($sale['total_price'], 2)) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars(date("F j, Y", strtotime($sale['sale_date']))) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-6 space-y-2">
            <a href="index.php" class="block text-indigo-600 hover:text-indigo-700">Back to Product Management</a>
            <a href="sales.php" class="block text-indigo-600 hover:text-indigo-700">Make a Sale</a>
            <a href="logout.php" class="block text-red-600 hover:text-red-700">Logout</a>
        </div>
    </div>
</body>
</html>
