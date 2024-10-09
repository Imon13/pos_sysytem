<?php
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $userExists = $stmt->fetchColumn();

    if ($userExists) {
        $message = "Username is already taken.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        
        if ($stmt->execute([$username, $hashed_password])) {
            $message = "Registration successful! <a href='login.php' class='text-indigo-600'>Login here</a>";
        } else {
            $message = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold mb-6 text-center">Register</h1>
        <?php if ($message): ?>
            <p class="text-center mb-4 text-red-500"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <input type="text" name="username" class="w-full px-4 py-2 border rounded-lg" placeholder="Username" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg" placeholder="Password" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Register</button>
        </form>
        <p class="text-center mt-4">Already have an account? <a href="login.php" class="text-indigo-600 hover:text-indigo-700">Login here</a></p>
    </div>
</body>
</html>
