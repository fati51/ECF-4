<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    die('Vous devez être connecté pour ajouter des jeux au panier.');
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $jeu_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Vérifier si le jeu est déjà dans le panier
    $checkPanier = $bdd->prepare('SELECT * FROM panier WHERE user_id = ? AND jeu_id = ?');
    $checkPanier->execute([$user_id, $jeu_id]);
    $panier = $checkPanier->fetch();

    if ($panier) {
        // Le jeu est déjà dans le panier, incrémenter la quantité
        $updatePanier = $bdd->prepare('UPDATE panier SET quantite = quantite + 1 WHERE user_id = ? AND jeu_id = ?');
        $updatePanier->execute([$user_id, $jeu_id]);
    } else {
        // Ajouter le jeu au panier
        $addToPanier = $bdd->prepare('INSERT INTO panier (user_id, jeu_id, quantite, agence, date_de_retrait) VALUES (?, ?, 1, "Default Agency", CURDATE())');
        $addToPanier->execute([$user_id, $jeu_id]);
    }

    header('Location: panier.php');
    exit();
} else {
    echo 'Identifiant de jeu non spécifié.';
}
?>




