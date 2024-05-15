<?php
session_start();

include __DIR__ . '/includes/logout.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

require_once './classes/Database.php';

function insertArticle($titolo, $autore, $contenuto)
{
    $db = new Database();
    $conn = $db->getConnection();
    $query = "INSERT INTO articles (titolo, autore, contenuto) VALUES (:titolo, :autore, :contenuto)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':titolo', $titolo);
    $stmt->bindParam(':autore', $autore);
    $stmt->bindParam(':contenuto', $contenuto);

    return $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titolo = $_POST["titolo"];
    $autore = $_POST["autore"];
    $contenuto = $_POST["contenuto"];

    $success = insertArticle($titolo, $autore, $contenuto);

    if ($success) {
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "Si è verificato un errore durante l'inserimento dell'articolo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include __DIR__ . '/includes/nav.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4">Inserisci un Nuovo Articolo</h2>
        <form method="post">
            <div class="form-group">
                <label for="titolo">Titolo</label>
                <input type="text" class="form-control" id="titolo" name="titolo">
            </div>
            <div class="form-group">
                <label for="autore">Autore</label>
                <input type="text" class="form-control" id="autore" name="autore">
            </div>
            <div class="form-group">
                <label for="contenuto">Contenuto</label>
                <textarea class="form-control" id="contenuto" name="contenuto" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Inserisci</button>
        </form>
        <?php

        include __DIR__ . '/includes/end.php';
