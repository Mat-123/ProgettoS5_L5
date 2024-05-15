<?php
session_start();

require_once './classes/user.php';
require_once './classes/Database.php';


if (isset($_SESSION['user'])) {

    header("Location: admin_panel.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);


    $user = new User($username, $password);


    $_SESSION['user'] = $user;


    header("Location: admin_panel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Login</h2>
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
                                <input type="submit" class="btn btn-primary" value="Login">
                            </div>
                        </form>
                        <p>Non hai un account? <a href="registrati.php">Registrati</a></p>
                    </div>
                </div>
            </div>
        </div>
        <?php

        include __DIR__ . '/includes/end.php';
