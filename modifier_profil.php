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
    die('Vous devez être connecté pour modifier vos informations personnelles.');
}

$user_id = $_SESSION['user_id'];

// Récupérer les informations actuelles de l'utilisateur
$requser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
$requser->execute([$user_id]);
$userinfo = $requser->fetch(PDO::FETCH_ASSOC);

// Mettre à jour les informations de l'utilisateur si le formulaire est soumis
if (isset($_POST['update'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $adresse_postale = htmlspecialchars($_POST['adresse_postale']);
    
    // Mise à jour des informations dans la base de données
    $updateuser = $bdd->prepare('UPDATE users SET nom = ?, prenom = ?, email = ?, adresse_postale = ? WHERE id = ?');
    $updateuser->execute([$nom, $prenom, $email, $adresse_postale, $user_id]);

    echo 'Informations mises à jour avec succès.';
    
    // Rafraîchir les informations de l'utilisateur
    $requser->execute([$user_id]);
    $userinfo = $requser->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Mes Informations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Modifier Mes Informations</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $userinfo['nom']; ?>" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $userinfo['prenom']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $userinfo['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="adresse_postale">Adresse Postale</label>
                <input type="text" class="form-control" id="adresse_postale" name="adresse_postale" value="<?php echo $userinfo['adresse_postale']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
