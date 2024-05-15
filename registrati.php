<?php


require_once './classes/User.php';
require_once './classes/Database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);


    $db = new Database();


    $query = "INSERT INTO users (username, password) VALUES (:username, :password)";


    $stmt = $db->getConnection()->prepare($query);
    $stmt->bindParam(':username', $username);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $hashed_password);


    if ($stmt->execute()) {

        header("Location: index.php");
        exit;
    } else {

        echo "Errore durante la registrazione. Si prega di riprovare.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Registrati</h2>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group my-3">
                                <input type="submit" class="btn btn-primary" value="Registrati">
                            </div>
                        </form>
                        <p>Hai già un account? <a href="index.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
        <?php

        include __DIR__ . '/includes/end.php';
