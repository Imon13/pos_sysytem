<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="container mx-auto mt-10">
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Dashboard</h1>
                <p class="text-gray-700">Welcome, <span class="font-semibold"><?= htmlspecialchars($_SESSION['username']) ?></span>!</p>
            </div>
            <div class="px-6 py-4">
                <ul class="space-y-3">
                    <li>
                        <a href="index.php" class="block text-center text-blue-600 hover:bg-blue-50 hover:text-blue-700 py-2 rounded-md transition">Manage Products</a>
                    </li>
                    <li>
                        <a href="sales.php" class="block text-center text-blue-600 hover:bg-blue-50 hover:text-blue-700 py-2 rounded-md transition">Make a Sale</a>
                    </li>
                    <li>
                        <a href="report.php" class="block text-center text-blue-600 hover:bg-blue-50 hover:text-blue-700 py-2 rounded-md transition">View Sales Report</a>
                    </li>
                </ul>
            </div>
            <div class="px-6 py-4 text-center">
                <a href="logout.php" class="block text-center bg-red-500 text-white py-2 rounded-md hover:bg-red-600 transition">Logout</a>
            </div>
        </div>
    </div>

</body>
</html>
