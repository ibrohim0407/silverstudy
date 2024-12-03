<?php
// JSON file to store the news
$news_file = 'news.json';

// Check if a news ID is provided
if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    // Load existing news
    if (file_exists($news_file)) {
        $news_data = json_decode(file_get_contents($news_file), true);

        // Filter out the news item to delete
        $news_data = array_filter($news_data, function ($news) use ($news_id) {
            return $news['id'] !== $news_id;
        });

        // Save the updated news data
        file_put_contents($news_file, json_encode(array_values($news_data)));
    }
}

// Redirect back to the news list
header('Location: news.php');
exit;
?>
