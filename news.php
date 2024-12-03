<?php
// JSON file to store the news
$news_file = 'news.json';

// Load existing news
if (file_exists($news_file)) {
    $news_data = json_decode(file_get_contents($news_file), true);
} else {
    $news_data = [];
}

// Get news by ID if provided
$current_news = null;
if (isset($_GET['id'])) {
    foreach ($news_data as $news) {
        if ($news['id'] === $_GET['id']) {
            $current_news = $news;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="stylesheet" href="news.css">
</head>
<body>
    <div class="container">
        <h1>Latest News</h1>

        <?php if ($current_news): ?>
            <div class="news-item">
                <h2><?= htmlspecialchars($current_news['title']) ?></h2>
                <?php if ($current_news['image']): ?>
                    <img src="<?= htmlspecialchars($current_news['image']) ?>" alt="News Image">
                <?php endif; ?>
                <p><?= nl2br(htmlspecialchars($current_news['content'])) ?></p>
                <small>Qo'yilgan sana: <?= htmlspecialchars($current_news['timestamp']) ?></small>
                <style>
                    small{
                        color: green;
                    }
                </style>
            </div>
            <a href="news.php"><button class="salom">Back to News List</button></a>
            <style>
                .salom{
                    width: 300px;
                    height: 35px;
                    border-radius: 15px;
                    cursor:pointer;
                    background-color: white;
                    border-width: 1px;
                    color: blue;
                }
                .salom:hover{
                    background-color:blue;
                    transition 1s;
                    color: white;
                    box-shadow: black 10px 10px 100px;
                }
            </style>
        <?php else: ?>
            <?php if (!empty($news_data)): ?>
                <ul class="news-list">
                    <?php foreach ($news_data as $news): ?>
                        <li>
                            <a href="?id=<?= htmlspecialchars($news['id']) ?>">
                                <?= htmlspecialchars(mb_strimwidth($news['title'], 0, 30, '...')) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No news available.</p>
            <?php endif; ?>
        <?php endif; ?>
        <br><br><a href="index.php"><button class="ozi">bosh sahifaga qaytish</button></a>
    </div>
</body>
</html>
