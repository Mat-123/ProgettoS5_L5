<?php
session_start();


include __DIR__ . '/includes/logout.php';


if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {

    require_once './classes/Database.php';

    $id = $_GET['id'];
    $db = new Database();
    $conn = $db->getConnection();


    $query = "DELETE FROM articles WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    // Esegui la query
    $stmt->execute();
}

header("Location: admin_panel.php");
exit;
