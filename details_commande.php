<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die('Vous devez être connecté pour voir les détails de votre commande.');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Identifiant de commande non spécifié.');
}

$commande_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Vérifier que la commande appartient bien à l'utilisateur connecté
$commande = $bdd->prepare('SELECT * FROM commandes WHERE id = ? AND user_id = ?');
$commande->execute([$commande_id, $user_id]);

if ($commande->rowCount() == 0) {
    die('Commande non trouvée.');
}

$commande = $commande->fetch(PDO::FETCH_ASSOC);

// Récupérer les détails de la commande
$details = $bdd->prepare('SELECT cd.*, jv.libelle FROM commande_details cd JOIN jeux_video jv ON cd.jeu_id = jv.id WHERE cd.commande_id = ?');
$details->execute([$commande_id]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Commande</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
          <a class="nav-link" href="login.php">Deconnexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="row">
        <div class="col-md-12">
            <div class="video-background">
                <video autoplay muted loop id="bg-video" class="w-100">
                    <source src="images/back.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div> 
    <div class="container">
        <h1 style="color : white" >Détails de la Commande</h1>
        <h2>Commande passée le <?php echo $commande['date_commande']; ?></h2>
        <table class="table table-striped" style="color : white">
            <thead>
                <tr>
                    <th>Jeu</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detail = $details->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $detail['libelle']; ?></td>
                        <td><?php echo $detail['quantite']; ?></td>
                        <td><?php echo $detail['prix']; ?> €</td>
                        <td><?php echo $detail['quantite'] * $detail['prix']; ?> €</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h3>Total: <?php echo $commande['total']; ?> €</h3>
        <a href="historique_commandes.php" class="btn btn-primary">Retour à l'historique</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
