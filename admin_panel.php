<?php
session_start();



include __DIR__ . '/includes/logout.php';


if (!isset($_SESSION['user'])) {

    header("Location: index.php");
    exit;
}

require_once './classes/Database.php';


function getArticles()
{
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT * FROM articles";
    $stmt = $conn->query($query);

    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $articles;
}

$articles = getArticles();
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
        <h2 class="mb-4">Lista degli Articoli</h2>
        <?php if (empty($articles)) : ?>
            <p>Non ci sono articoli disponibili.</p>
        <?php else : ?>
            <ul class="list-group">
                <?php foreach ($articles as $article) : ?>
                    <li class="list-group-item">
                        <h5 class="mb-1"><?php echo $article['titolo']; ?></h5>
                        <small>Autore: <?php echo $article['autore']; ?></small>
                        <p class="mb-1"><?php echo $article['contenuto']; ?></p>
                        <div>
                            <a href="edit.php?id=<?php echo $article['id']; ?>" class="btn btn-primary me-2">Modifica</a>
                            <a href="elimina.php?id=<?php echo $article['id']; ?>" class="btn btn-danger">Elimina</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php

        include __DIR__ . '/includes/end.php';
