<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>
<body>
    <h1>News</h1>
    <?php if (!empty($news)) : ?>
        <?php foreach ($news as $newsItem) : ?>
            <div class="news-item">
                <h2><?php echo htmlspecialchars($newsItem['title']); ?></h2>
                <p><?php echo htmlspecialchars($newsItem['content']); ?></p>
                <?php if (!empty($newsItem['image'])) : ?>
                    <img src="<?php echo htmlspecialchars($newsItem['image']); ?>" alt="News Image">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No news available.</p>
    <?php endif; ?>
</body>
</html>
