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

$query = "SELECT * FROM commandes WHERE statut = 'en_attente'";
$stmt = $bdd->prepare($query);
$stmt->execute();
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes en attente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Commandes en attente</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID Commande</th>
                <th>ID Utilisateur</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
            <tr>
                <td><?= htmlspecialchars($commande['id']); ?></td>
                <td><?= htmlspecialchars($commande['user_id']); ?></td>
                <td><?= htmlspecialchars($commande['date']); ?></td>
                <td>
                    <form method="POST" action="update_order_status.php">
                        <input type="hidden" name="commande_id" value="<?= $commande['id']; ?>">
                        <button type="submit" class="btn btn-success">Marquer comme livré</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
