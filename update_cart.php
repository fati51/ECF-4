<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    die('Vous devez être connecté pour accéder à votre panier.');
}

$user_id = $_SESSION['user_id'];

// Ajouter un jeu au panier
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $jeu_id = $_GET['id'];

    $checkCart = $bdd->prepare('SELECT * FROM panier WHERE user_id = ? AND jeu_id = ?');
    $checkCart->execute([$user_id, $jeu_id]);

    if ($checkCart->rowCount() > 0) {
        $updateCart = $bdd->prepare('UPDATE panier SET quantite = quantite + 1 WHERE user_id = ? AND jeu_id = ?');
        $updateCart->execute([$user_id, $jeu_id]);
    } else {
        $addCart = $bdd->prepare('INSERT INTO panier (user_id, jeu_id, quantite) VALUES (?, ?, 1)');
        $addCart->execute([$user_id, $jeu_id]);
    }
}

// Supprimer un jeu du panier
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $jeu_id = $_GET['id'];

    $deleteCart = $bdd->prepare('DELETE FROM panier WHERE user_id = ? AND jeu_id = ?');
    $deleteCart->execute([$user_id, $jeu_id]);
}

// Mettre à jour les quantités
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantite'] as $jeu_id => $quantite) {
        $quantite = intval($quantite);

        if ($quantite > 0) {
            $updateCart = $bdd->prepare('UPDATE panier SET quantite = ? WHERE user_id = ? AND jeu_id = ?');
            $updateCart->execute([$quantite, $user_id, $jeu_id]);
        } else {
            $deleteCart = $bdd->prepare('DELETE FROM panier WHERE user_id = ? AND jeu_id = ?');
            $deleteCart->execute([$user_id, $jeu_id]);
        }
    }
}

// Valider la commande
if (isset($_POST['valider_commande'])) {
    $total = 0;

    // Calculer le total
    $cartItems = $bdd->prepare('SELECT panier.*, jeux_video.prix FROM panier JOIN jeux_video ON panier.jeu_id = jeux_video.id WHERE panier.user_id = ?');
    $cartItems->execute([$user_id]);

    while ($item = $cartItems->fetch(PDO::FETCH_ASSOC)) {
        $total += $item['prix'] * $item['quantite'];
    }

    // Insérer la commande
    $insertCommande = $bdd->prepare('INSERT INTO commandes (user_id, total) VALUES (?, ?)');
    $insertCommande->execute([$user_id, $total]);

    $commande_id = $bdd->lastInsertId();

    // Insérer les détails de la commande
    $cartItems->execute([$user_id]); // Re-execute to fetch items again
    while ($item = $cartItems->fetch(PDO::FETCH_ASSOC)) {
        $insertDetail = $bdd->prepare('INSERT INTO commande_details (commande_id, jeu_id, quantite, prix) VALUES (?, ?, ?, ?)');
        $insertDetail->execute([$commande_id, $item['jeu_id'], $item['quantite'], $item['prix']]);
    }

    // Vider le panier
    $emptyCart = $bdd->prepare('DELETE FROM panier WHERE user_id = ?');
    $emptyCart->execute([$user_id]);

    $msg =  'Commande validée avec succès !';
}

// Afficher le panier
$panier = $bdd->prepare('SELECT panier.*, jeux_video.libelle, jeux_video.prix FROM panier JOIN jeux_video ON panier.jeu_id = jeux_video.id WHERE panier.user_id = ?');
$panier->execute([$user_id]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
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
    <h1 style="color : white" >Mon Panier</h1>
    <form method="POST" action="update_cart.php">
        <table class="table" style="color : white">
            <thead>
                <tr>
                    <th>Jeu</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($meg)){}
                $total = 0;
                while ($item = $panier->fetch(PDO::FETCH_ASSOC)) {
                    $itemTotal = $item['prix'] * $item['quantite'];
                    $total += $itemTotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['libelle']) ?></td>
                        <td><input type="number" name="quantite[<?= $item['jeu_id'] ?>]" value="<?= $item['quantite'] ?>" min="1" class="form-control"></td>
                        <td><?= number_format($item['prix'], 2) ?> €</td>
                        <td><?= number_format($itemTotal, 2) ?> €</td>
                        <td><a href="update_cart.php?action=delete&id=<?= $item['jeu_id'] ?>" class="btn btn-danger">Supprimer</a></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong><?= number_format($total, 2) ?> €</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" name="update_cart" class="btn btn-primary">Mettre à jour le panier</button>
        <button type="submit" name="valider_commande" class="btn btn-success">Valider la commande</button>
    </form><br><br>
    <a href="tous_lesjeux.php" class="btn btn-secondary">Continuer vos achats</a>
</div>
</body>
</html>

