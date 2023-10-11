<?php
session_start();

if (isset($_GET['edit'])) {
    $editIndex = $_GET['edit']; // Get the book index from the URL parameter

    $books = [];

    if (file_exists('books.json')) {
        $books = json_decode(file_get_contents('books.json'), true);
    }

    $bookToEdit = $books[$editIndex];
} else {
    echo "No book selected for editing.";
    exit();
}

if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['available']) && isset($_POST['pages']) && isset($_POST['isbn'])) {
    
    $books[$editIndex] = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'available' => $_POST['available'] === 'true', 
        'pages' => $_POST['pages'],
        'isbn' => $_POST['isbn']
    ];

    file_put_contents('books.json', json_encode($books, JSON_PRETTY_PRINT));

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1 id="edit-book-title">Edit Book</h1>
    <form method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" required value="<?php echo $bookToEdit['title']; ?>"> <br>
        <label for="author">Author:</label>
        <input type="text" name="author" required value="<?php echo $bookToEdit['author']; ?>"> <br>
        <label for="available">Available:</label>
        <div class="radio-container">
            <label>
                <input type="radio" name="available" value="true" <?php echo ($bookToEdit['available'] ? 'checked' : ''); ?>>
                <span class="radio-label">Yes</span>
            </label>
            <label>
                <input type="radio" name="available" value="false" <?php echo (!$bookToEdit['available'] ? 'checked' : ''); ?>>
                <span class="radio-label">No</span>
            </label>
        </div> <br>
        <label for="pages">Pages:</label>
        <input type="number" name="pages" required value="<?php echo $bookToEdit['pages']; ?>"> <br>
        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" required value="<?php echo $bookToEdit['isbn']; ?>"> <br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
