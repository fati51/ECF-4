<?php
session_start();

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die('Accès refusé : vous devez être un administrateur pour accéder à cette page.');
}

try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupérer tous les jeux vidéo pour les afficher dans un formulaire
$jeuxVideo = $bdd->query('SELECT id, libelle FROM jeux_video')->fetchAll(PDO::FETCH_ASSOC);

// Mettre à jour le stock si le formulaire est soumis
if (isset($_POST['update_stock'])) {
    $jeu_id = (int)$_POST['jeu_id'];
    $quantite_ajoutee = (int)$_POST['quantite_ajoutee'];

    // Récupérer la quantité actuelle
    $recupQuantite = $bdd->prepare('SELECT quantite FROM jeux_video WHERE id = ?');
    $recupQuantite->execute([$jeu_id]);
    $jeu = $recupQuantite->fetch(PDO::FETCH_ASSOC);

    if ($jeu) {
        $nouvelleQuantite = $jeu['quantite'] + $quantite_ajoutee;

        // Mettre à jour la quantité
        $updateQuantite = $bdd->prepare('UPDATE jeux_video SET quantite = ? WHERE id = ?');
        $updateQuantite->execute([$nouvelleQuantite, $jeu_id]);

        echo 'Stock mis à jour avec succès.';
    } else {
        echo 'Jeu non trouvé.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mettre à jour le stock</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       
        a {
            text-decoration: none;
            color: #fff; 
        }
        div {
            color: white;
        }
        
        
        .navbar-nav li:not(:last-child) {
            margin-right: 20px;
        }
    </style>
    <title>Espace administrateur</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #747e88;">
    <div class="container">
    <a class="navbar-brand" href="espace_admin.php"><img src="./images/logo.jpg" alt="Logo" width="60"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="espace_admin.php">Page d'acceuil admin</a>
               
            </ul>
        </div>
    </div>
</nav>
</head>
<body>
    <div class="container">
        <h1>Admin - Mettre à jour le stock</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="jeu_id">Jeu Vidéo</label>
                <select class="form-control" id="jeu_id" name="jeu_id" required>
                    <?php foreach ($jeuxVideo as $jeu) { ?>
                        <option value="<?php echo $jeu['id']; ?>"><?php echo $jeu['libelle']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantite_ajoutee">Quantité à ajouter</label>
                <input type="number" class="form-control" id="quantite_ajoutee" name="quantite_ajoutee" required>
            </div>
            <button type="submit" name="update_stock" class="btn btn-primary">Mettre à jour le stock</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
