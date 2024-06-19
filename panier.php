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

$panier = $bdd->prepare('SELECT p.jeu_id, p.quantite, p.agence, p.date_de_retrait, j.libelle, j.prix FROM panier p JOIN jeux_video j ON p.jeu_id = j.id WHERE p.user_id = ?');
$panier->execute([$user_id]);
$jeux = $panier->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Votre panier</h1>
        <?php if (empty($jeux)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <form method="POST" action="update_cart.php">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Jeu</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Agence</th>
                            <th>Date de Retrait</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jeux as $jeu): ?>
                            <tr>
                                <td><?= htmlspecialchars($jeu['libelle']); ?></td>
                                <td><?= htmlspecialchars($jeu['prix']); ?>€</td>
                                <td>
                                    <input type="number" name="quantite[<?= $jeu['jeu_id']; ?>]" value="<?= htmlspecialchars($jeu['quantite']); ?>" min="1">
                                </td>
                                <td>
                                    <input type="text" name="agence[<?= $jeu['jeu_id']; ?>]" value="<?= htmlspecialchars($jeu['agence']); ?>">
                                </td>
                                <td>
                                    <input type="date" name="date_de_retrait[<?= $jeu['jeu_id']; ?>]" value="<?= htmlspecialchars($jeu['date_de_retrait']); ?>">
                                </td>
                                <td><?= htmlspecialchars($jeu['prix'] * $jeu['quantite']); ?>€</td>
                                <td>
                                    <button type="submit" name="delete" value="<?= $jeu['jeu_id']; ?>" class="btn btn-danger btn-sm">Supprimer</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" name="update" class="btn btn-primary">Mettre à jour le panier</button>
                
            </form>
        <?php endif; ?>
        <a href="tous_lesjeux.php" class="btn btn-secondary">Continuer vos achats</a>
       
    </div>
</body>
</html>

