<?php
require_once __DIR__ . '/../core/config.php'; 
global $pdo;
$controller = new BaseController();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Fan</title>
</head>
<body>
    <h1>Become a Fan</h1>
    
    <!-- Registration Form -->
    <h2>Register</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="register">
        <label for="register-username">Username:</label>
        <input type="text" id="register-username" name="register-username" required>
        <label for="register-password">Password:</label>
        <input type="password" id="register-password" name="register-password" required>
        <button type="submit">Register</button>
    </form>
    
    <!-- Login Form -->
    <h2>Login</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="login">
        <label for="login-username">Username:</label>
        <input type="text" id="login-username" name="login-username" required>
        <label for="login-password">Password:</label>
        <input type="password" id="login-password" name="login-password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
