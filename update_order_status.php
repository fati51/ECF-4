<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Vérifiez si l'utilisateur est connecté et est un employeur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employeur') {
    die('Vous devez être connecté en tant qu\'employeur pour accéder à cette page.');
}

if (isset($_POST['commande_id']) && !empty($_POST['commande_id'])) {
    $commande_id = $_POST['commande_id'];

    $updateQuery = "UPDATE commandes SET statut = 'livré' WHERE id = ?";
    $stmt = $bdd->prepare($updateQuery);

    if ($stmt->execute([$commande_id])) {
        echo "Le statut de la commande a été mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour du statut de la commande.";
    }
} else {
    echo "Identifiant de commande non spécifié.";
}

header("Location: view_orders.php");
exit;
?>
