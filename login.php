<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $checkUser = $bdd->prepare('SELECT id, mot_de_passe FROM users WHERE email = ?');
    $checkUser->execute([$email]);

    if ($checkUser->rowCount() > 0) {
        $user = $checkUser->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location:espace_user.php'); // Rediriger vers la page principale après la connexion
            exit();
        } else {
            echo 'Mot de passe incorrect';
        }
    } else {
        echo 'Email non trouvé';
    }
}
?>



      


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<style>
a {
    text-decoration: none;
    color: #fff; 
}

div {
    color: white;
}

.navbar-nav li:not(:last-child) {
    margin-right: 30px;
}
</style>
<div class="video-background">
    <video autoplay muted loop id="bg-video">
      <source src="images/back.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
<body>
    
<form method="POST">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Connexion</h2>
           
            <div class="form-group">
                <label for="Email"><b>Email</b></label>
                <input type="email" class="form-control" name="email" required>
            </div>
         
            <label for="MotDePasse" class="form-label"><b>Mot de passe</b></label>
          <input type="password" class="form-control" id="password" name="password" required>
          <div id="passwordHelpBlock" class="form-text">
            <button type="submit" class="btn btn-success" name="valider">Connectez-vous</button>
            <br>
            <a href="inscription_user.php">Inscrivez_vous</a>
            <br>
            <a href="mode_de_passe_user.php">Mode passe oubliee</a>
           
        </div>
    </div>
</div>
</form>

</body>
</html>

