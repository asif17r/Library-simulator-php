<!DOCTYPE html>
<html>
<head>
    <title>Book Library</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Book Library</h1>

    <h2>Search Books</h2>
    <form method="get" class="search-form">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>">
        <button type="submit">Search</button>
        <a href="create_book.php" class="create-book-button" style="text-decoration: none;">Create Book</a>
    </form>

    <h2>Book List</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Available</th>
            <th>Pages</th>
            <th>ISBN</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        $books = [];

        if (file_exists('books.json')) {
            $books = json_decode(file_get_contents('books.json'), true);
        }

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

        if (isset($_POST['delete'])) {
            $deleteIndex = $_POST['delete'];

            if (isset($searchResults[$deleteIndex])) {
                unset($searchResults[$deleteIndex]);

                // Reindex the array
                $searchResults = array_values($searchResults);

                // Save the updated list of books
                file_put_contents('books.json', json_encode($searchResults, JSON_PRETTY_PRINT));
            }
        }

        foreach ($searchResults as $index => $book) {
            echo '<tr>';
            echo '<td>' . $book['title'] . '</td>';
            echo '<td>' . $book['author'] . '</td>';
            echo '<td>' . ($book['available'] ? 'Yes' : 'No') . '</td>';
            echo '<td>' . $book['pages'] . '</td>';
            echo '<td>' . $book['isbn'] . '</td>';
            echo '<td>
                    <form method="get" action="edit_book.php">
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
</body>
</html>
