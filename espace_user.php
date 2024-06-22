<?php 
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die('Veuillez vous connecter pour accéder à cette page.');
}

// Préparer et exécuter la requête pour récupérer les informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$query = $bdd->prepare('SELECT nom, prenom FROM users WHERE id = ?');
$query->execute([$user_id]);
$infoUser = $query->fetch();

if (!$infoUser) {
    die('Utilisateur non trouvé.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Mon espace</title>
    <style>
        .content-wrapper {
            margin-top: 50px;
        }
        .list-group-wrapper {
            margin-bottom: 30px;
        }
        .promo-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #c3e6cb;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="./images/logo.jpg" alt="Logo" width="60"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tous_lesjeux.php">Tous les jeux</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Espace personnel</a>
        </li>
      </ul>
    </div>
  </div>
</nav> 

<div class="container content-wrapper">
    <h2 class="text-center">Bonjour <?= htmlspecialchars($infoUser['nom']) . " " . htmlspecialchars($infoUser['prenom']); ?></h2>
    <div class="row justify-content-center">
        <div class="col-md-4 list-group-wrapper">
            <div class="list-group text-center">
                <a href="historique_commandes.php" class="list-group-item list-group-item-action">Historique des commandes</a>
                <a href="panier.php" class="list-group-item list-group-item-action">Panier</a>
                <a href="modifier_profil.php" class="list-group-item list-group-item-action">Modifier le profil</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="video-background">
                <video autoplay muted loop id="bg-video" class="w-100">
                    <source src="images/back.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <h2 class="text-white text-center mt-3">Retrouvez nos jeux en promotion directement en magasin</h2>
            <div id="promo-container" class="promo-container row justify-content-center">
                <!-- Promo games will be dynamically loaded here -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>
</body>
</html>


