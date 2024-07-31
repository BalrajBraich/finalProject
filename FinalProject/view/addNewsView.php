<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News</title>
</head>
<body>
    <h1>Add News</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="saveNews">
        <label for="news-title">Title:</label>
        <input type="text" id="news-title" name="title">
        <label for="news-content">Content:</label>
        <textarea id="news-content" name="content"></textarea>
        <button type="submit">Save</button>
    </form>
</body>
</html>
