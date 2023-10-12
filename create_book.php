<!DOCTYPE html>
<html>
<head>
    <title>Create Book</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Create Book</h1>
    <form method="post" action="create_book_handler.php">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>
        <label for "author">Author:</label>
        <input type="text" name="author" required><br>
        <label for="available">Available:</label>
        <div class="radio-container">
            <label>
                <input type="radio" name="available" value="true" checked>
                <span class="radio-label">Yes</span>
            </label>
            <label>
                <input type="radio" name="available" value="false">
                <span class="radio-label">No</span>
            </label>
        </div><br>
        <label for="pages">Pages:</label>
        <input type="number" name="pages" required><br>
        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" required><br>
        <button type="submit">Create</button>
    </form>
</body>
</html>
