<?php
// File to store news data
$news_file = 'news.json';
$media_dir = 'media/';

// Ensure the media directory exists
if (!is_dir($media_dir)) {
    mkdir($media_dir, 0755, true);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $timestamp = date('Y-m-d H:i:s');
    $image_path = '';

    // Handle file upload
    if (!empty($_FILES['image']['name'])) {
        $file_name = basename($_FILES['image']['name']);
        $target_file = $media_dir . $file_name;

        // Move uploaded file to the media directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "File upload failed.";
        }
    }

    // Load existing news
    $news_data = file_exists($news_file) ? json_decode(file_get_contents($news_file), true) : [];

    // Add new news item
    $news_data[] = [
        'id' => uniqid(),
        'title' => $title,
        'content' => $content,
        'image' => $image_path,
        'timestamp' => $timestamp
    ];

    // Save updated news to the JSON file
    file_put_contents($news_file, json_encode($news_data));

    // Redirect to the news page
    header('Location: news.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News</title>
    <link rel="stylesheet" href="news.css">
</head>
<body>
    <div class="container">
        <h1>Add News</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>
            
            <label for="content">Content:</label>
            <textarea name="content" id="content" rows="5" required></textarea>
            
            <label for="image">Image:</label>
            <input type="file" name="image" id="image">
            
            <button type="submit">Add News</button>
        </form>
    </div>
</body>
</html>
