<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Veuillez vérifier votre base de données: ' . $e->getMessage());
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['libelle']) && !empty($_POST['description']) && !empty($_POST['pegi']) && !empty($_POST['genre']) && !empty($_POST['prix']) && !empty($_POST['quantite']) && !empty($_FILES['galerie_images']['name'])) {
        
        $libelle = htmlspecialchars($_POST['libelle']);
        $description = htmlspecialchars($_POST['description']);
        $pegi = htmlspecialchars($_POST['pegi']);
        $genre = htmlspecialchars($_POST['genre']);
        $prix = filter_var($_POST['prix'], FILTER_VALIDATE_FLOAT);
        $quantite = filter_var($_POST['quantite'], FILTER_VALIDATE_INT);
        
        if ($prix === false || $quantite === false) {
            die('Prix et Quantité doivent être numériques.');
        }
        
        // Handle file upload
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
        }
        $target_file = $target_dir . basename($_FILES["galerie_images"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["galerie_images"]["tmp_name"], $target_file)) {
                $image = $target_file;
                
                $addJeux = $bdd->prepare('INSERT INTO jeux_video (libelle, description, pegi, genre, prix, quantite, image) VALUES (?, ?, ?, ?, ?, ?, ?)');
                if ($addJeux->execute(array($libelle, $description, $pegi, $genre, $prix, $quantite, $image))) {
                    echo "Jeu ajouté avec succès!";
                } else {
                    echo "Erreur lors de l'ajout du jeu.";
                }
            } else {
                die('Erreur lors du téléchargement de l\'image.');
            }
        } else {
            die('Type de fichier non autorisé. Seuls les formats JPG, JPEG, PNG, et GIF sont autorisés.');
        }
    } else {
        echo 'Tous les champs sont obligatoires.';
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de jeu</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
<div class="container">
    <h1>Ajouter un jeu vidéo</h1>
    <form method="POST" enctype="multipart/form-data" class="form-group">
        <div class="form-group">
            <label>Libellé :</label>
            <input type="text" name="libelle" required class="form-control">
        </div>
        <div class="form-group">
            <label>Description :</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>PEGI :</label>
            <input type="text" name="pegi" required class="form-control">
        </div>
        <div class="form-group">
            <label>Genre :</label>
            <input type="text" name="genre" required class="form-control">
        </div>
        <div class="form-group">
            <label>Prix :</label>
            <input type="number" name="prix" required class="form-control">
        </div>
        <div class="form-group">
            <label>Quantité :</label>
            <input type="number" name="quantite" required class="form-control">
        </div>
        <div class="form-group">
            <label>Galerie d'images :</label>
            <input type="file" name="galerie_images" required class="form-control">
        </div>
        <button type="submit" name="valider" class="btn btn-primary">Ajouter</button>
    </form>
</div>
</body>
</html>

