<?php
$books = [];

// Load books from JSON file
if (file_exists('books.json')) {
    $books = json_decode(file_get_contents('books.json'), true);
}

// Handle book save or update
if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['available']) && isset($_POST['pages']) && isset($_POST['isbn'])) {
    if (isset($_POST['edit-index'])) {
        // Edit an existing book
        $editIndex = $_POST['edit-index'];
        if (isset($books[$editIndex])) {
            $books[$editIndex] = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'available' => $_POST['available'] === 'true', // Convert to boolean
                'pages' => $_POST['pages'],
                'isbn' => $_POST['isbn']
            ];
        }
    } else {
        // Add a new book
        $newBook = [
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'available' => $_POST['available'] === 'true', // Convert to boolean
            'pages' => $_POST['pages'],
            'isbn' => $_POST['isbn']
        ];
        $books[] = $newBook;
    }

    // Save updated books to JSON file
    file_put_contents('books.json', json_encode($books, JSON_PRETTY_PRINT));
}

// Handle book deletion
if (isset($_POST['delete'])) {
    $indexToDelete = $_POST['delete'];
    if (isset($books[$indexToDelete])) {
        unset($books[$indexToDelete]);
        // Save updated books to JSON file
        file_put_contents('books.json', json_encode(array_values($books), JSON_PRETTY_PRINT));
    }
}

// Handle edit
if (isset($_GET['edit'])) {
    $editIndex = $_GET['edit'];
    if (isset($books[$editIndex])) {
        $bookToEdit = $books[$editIndex];
    }
} else {
    $bookToEdit = null;
}

// Handle search
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $searchResults = [];
    foreach ($books as $index => $book) {
        if (stripos($book['title'], $searchQuery) !== false || stripos($book['author'], $searchQuery) !== false) {
            $searchResults[] = $book;
        }
    }
} else {
    $searchResults = $books;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Library</title>
    <link rel="stylesheet" href="your-stylesheet.css"> <!-- Add your CSS stylesheet here -->
</head>
<body>
    <h1>Book Library</h1>

    <h2>Search Books</h2>
    <form method="get">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>">
        <button type="submit">Search</button>
    </form>

    <h2>Book List</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Available</th>
            <th>Pages</th>
            <th>ISBN</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($searchResults as $index => $book) {
            echo '<tr>';
            echo '<td>' . $book['title'] . '</td>';
            echo '<td>' . $book['author'] . '</td>';
            echo '<td>' . ($book['available'] ? 'Yes' : 'No') . '</td>';
            echo '<td>' . $book['pages'] . '</td>';
            echo '<td>' . $book['isbn'] . '</td>';
            echo '<td>
                    <form method="get">
                        <input type="hidden" name="edit" value="' . $index . '">
                        <button type="submit">Edit</button>
                    </form>
                    </td>';
            echo '<td>
                    <form method="post">
                        <input type="hidden" name="delete" value="' . $index . '">
                        <button type="submit">Delete</button>
                    </form>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>
    
    <h2>Add/Edit a Book</h2>
    <form method="post">
        <?php
        if ($bookToEdit !== null) {
            echo '<input type="hidden" name="edit-index" value="' . $editIndex . '">';
        }
        ?>
        <label for="title">Title:</label>
        <input type="text" name="title" required value="<?php echo $bookToEdit['title'] ?? ''; ?>">
        <label for="author">Author:</label>
        <input type="text" name="author" required value="<?php echo $bookToEdit['author'] ?? ''; ?>">
        <label for="available">Available:</label>
        <input type="radio" name="available" value="true" <?php echo ($bookToEdit['available'] ?? true) ? 'checked' : ''; ?>> Yes
        <input type="radio" name="available" value="false" <?php echo ($bookToEdit['available'] ?? false) ? '' : 'checked'; ?>> No
        <label for="pages">Pages:</label>
        <input type="number" name="pages" required value="<?php echo $bookToEdit['pages'] ?? ''; ?>">
        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" required value="<?php echo $bookToEdit['isbn'] ?? ''; ?>">
        <button type="submit"><?php echo $bookToEdit !== null ? 'Update' : 'Save'; ?></button>
    </form>
    
</body>
</html>
