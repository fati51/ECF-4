<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "gamestore";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sqlCheckUser = "SELECT * FROM utilisateurs WHERE pseudo = :pseudo";
    $stmtCheckUser = $conn->prepare($sqlCheckUser);
    $stmtCheckUser->execute(['pseudo' => $pseudo]);
    $existingUser = $stmtCheckUser->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo "Ce pseudo est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sqlInsertUser = "INSERT INTO utilisateurs (pseudo, mail, mot_de_passe, role) VALUES (?, ?, ?, ?)";
        $stmtInsertUser = $conn->prepare($sqlInsertUser);
        $stmtInsertUser->execute([$pseudo, $mail, $hashedPassword, $role]);

        header('Location: login_employer.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Créer un compte utilisateur</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
            color: #fff;
        }

        div {
            color: white;
        }

        .navbar-nav li {
            text-align: left;
        }

        .navbar-nav li:not(:last-child) {
            margin-right: 30px;
        }

        h1 {
            color: white;
        }

        .form-group {
            max-width: 400px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #747e88;">
    <div class="container-fluid">
        <a class="navbar-brand" href="espace_admin.php"><img src="./images/logo.jpg" alt="Logo" width="60"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ml-auto">
               
                <li class="nav-item">
                    <a href="espace_admin.php">Page d'acceuil admin </a>
              
            </ul>
        </div>
    </div>
</nav>
<h1 class="text-center mb-4">Créer un compte utilisateur</h1>
<form action="" method="POST">
    <div class="form-group">
        <label>Pseudo :</label>
        <input type="text" class="form-control" name="pseudo" required>
    </div>
    <div class="form-group">
        <label>Email :</label>
        <input type="email" class="form-control" name="mail" required>
    </div>
    <div class="form-group">
        <label>Mot de passe :</label>
        <input type="password" class="form-control" name="password" >
    </div>
    <div class="form-group">
        <label>Rôle :</label>
        <select class="form-control" name="role">
            <option value="producteur">employeur</option>
            <option value="community_manager">Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Créer le compte</button>
</form>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>