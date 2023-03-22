<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Script</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea><br><br>
        <label for="image">Featured Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $folderName = str_replace(' ', '-', $title);
        if (!file_exists($folderName)) {
            mkdir($folderName);
            move_uploaded_file($_FILES['image']['tmp_name'], $folderName . '/' . $_FILES['image']['name']);
            $featuredImage = $folderName . '/' . $_FILES['image']['name'];
            $htmlContent = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    <meta property="og:title" content="{$title}">
    <meta property="og:description" content="{$content}">
    <meta property="og:image" content="{$featuredImage}">
</head>
<body>
    <h1>{$title}</h1>
    <img src="{$featuredImage}" alt="Featured Image">
    <p>{$content}</p>
</body>
</html>
HTML;
            file_put_contents($folderName . '/index.html', $htmlContent);
            echo "Folder and index.html file created successfully!";
        } else {
            echo "The folder '{$folderName}' already exists. Please use a different title.";
        }
    }
    ?>
</body>
</html>
