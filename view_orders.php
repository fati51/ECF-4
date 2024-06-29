<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Modifiez la requête pour inclure les informations sur les utilisateurs
$query = "SELECT id, user_id, date_commande AS date, nom, prenom 
          FROM commandes 
          WHERE statut = 'en_attente'";
$stmt = $bdd->prepare($query);

if ($stmt->execute()) {
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $errorInfo = $stmt->errorInfo();
    die('Erreur de requête SQL : ' . $errorInfo[2]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes en attente</title>
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
              <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                  <ul class="navbar-nav ml-auto">
                      <li class="nav-item">
                          <a class="nav_link nav-link" href="logout_employeur.php">Déconnexion</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav_link nav-link" href="espace_employer.php">Retour</a>
              </div>
          </div>
      </nav>
<div class="container">
    <h1>Commandes en attente</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID Commande</th>
                <th>ID Utilisateur</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($commandes)): ?>
                <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?= htmlspecialchars($commande['id']); ?></td>
                    <td><?= htmlspecialchars($commande['user_id']); ?></td>
                    <td><?= htmlspecialchars($commande['nom']); ?></td>
                    <td><?= htmlspecialchars($commande['prenom']); ?></td>
                    <td><?= htmlspecialchars($commande['date']); ?></td>
                    <td>
                        <form method="POST" action="update_order_status.php">
                            <input type="hidden" name="commande_id" value="<?= $commande['id']; ?>">
                            <button type="submit" class="btn btn-warning">LIVRÉ</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Aucune commande en attente.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>




