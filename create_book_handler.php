<?php
if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['available']) && isset($_POST['pages']) && isset($_POST['isbn'])) {
    $books = [];

    if (file_exists('books.json')) {
        $books = json_decode(file_get_contents('books.json'), true);
    }

    $newBook = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'available' => $_POST['available'] === 'true',
        'pages' => $_POST['pages'],
        'isbn' => $_POST['isbn']
    ];

    $books[] = $newBook;

    file_put_contents('books.json', json_encode($books, JSON_PRETTY_PRINT));

    header('Location: index.php');
    exit();
} else {
    echo "Error: Missing book information.";
}
?>
