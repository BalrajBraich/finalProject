<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Manage News</h2>

    <!-- Form to Add News -->
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="addNews">
        <button type="submit">Add News</button>
    </form>

    <!-- Form to View News -->
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="viewNews">
        <button type="submit">View News</button>
    </form>

</body>
</html>
