<?php
session_start();


include __DIR__ . '/includes/logout.php';


if (!isset($_SESSION['user'])) {

    header("Location: index.php");
    exit;
}

require_once './classes/Database.php';

function getArticleById($id)
{
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT * FROM articles WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    return $article;
}

$id = $_GET['id'] ?? null;


if (!$id) {
    header("Location: admin_panel.php");
    exit;
}

$article = getArticleById($id);

if (!$article) {
    header("Location: admin_panel.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati del form
    $titolo = $_POST["titolo"];
    $autore = $_POST["autore"];
    $contenuto = $_POST["contenuto"];

    require_once './classes/Database.php';

    function updateArticle($id, $titolo, $autore, $contenuto)
    {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "UPDATE articles SET titolo = :titolo, autore = :autore, contenuto = :contenuto WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titolo', $titolo);
        $stmt->bindParam(':autore', $autore);
        $stmt->bindParam(':contenuto', $contenuto);

        return $stmt->execute();
    }

    $success = updateArticle($id, $titolo, $autore, $contenuto);

    if ($success) {
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "Si è verificato un errore durante l'aggiornamento dell'articolo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Articolo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include __DIR__ . '/includes/nav.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4">Modifica Articolo</h2>
        <form method="post">
            <div class="form-group">
                <label for="titolo">Titolo</label>
                <input type="text" class="form-control" id="titolo" name="titolo" value="<?php echo $article['titolo']; ?>">
            </div>
            <div class="form-group">
                <label for="autore">Autore</label>
                <input type="text" class="form-control" id="autore" name="autore" value="<?php echo $article['autore']; ?>">
            </div>
            <div class="form-group">
                <label for="contenuto">Contenuto</label>
                <textarea class="form-control" id="contenuto" name="contenuto" rows="5"><?php echo $article['contenuto']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Salva Modifiche</button>
        </form>
        <?php

        include __DIR__ . '/includes/end.php';
