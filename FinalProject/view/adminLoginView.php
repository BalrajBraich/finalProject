<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="adminLogin">
        <label for="admin-username">Username:</label>
        <input type="text" id="admin-username" name="username">
        <label for="admin-password">Password:</label>
        <input type="password" id="admin-password" name="password">
        <button type="submit">Login</button>
    </form>
</body>
</html>
