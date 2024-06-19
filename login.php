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
            header('Location: tous_lesjeux.php'); // Rediriger vers la page principale après la connexion
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
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
         
            <div class="form-group">
                <label for="MotDePasse"><b>Mot de passe</b></label>
                <input type="password" class="form-control" name="password"  >
            </div>
            <button type="submit" class="btn btn-success" name="valider">Connectez-vous</button>
            <br>
            
            <a href="mode_de_passe_user.php">Mode passe oubliee</a>
        </div>
    </div>
</div>
</form>

</body>
</html>

