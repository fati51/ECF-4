<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require 'PHPMailer/PHPMailerAutoload.php';


try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

  
    $mail->Username = 'dahoufatma@gmail.com'; 
    $mail->Password = 'bcvf kexf pwxz basf'; 

    $mail->setFrom('dahoufatma@gmail.com', 'DAHOU');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    
    $mail->SMTPDebug = 0; 
    $mail->Debugoutput = 'html';

    if ($mail->send()) {
        return true;
    } else {
        
        echo 'Erreur lors de l\'envoi de l\'email : ' . $mail->ErrorInfo;
        return false;
    }
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $adresse_postale = htmlspecialchars($_POST['adresse_postale']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

       
        $checkEmail = $bdd->prepare('SELECT email FROM users WHERE email = ?');
        $checkEmail->execute([$email]);

        if ($checkEmail->rowCount() > 0) {
            echo 'Cette adresse email est déjà utilisée. Veuillez en choisir une autre.';
        } else {
            $insertUser = $bdd->prepare('INSERT INTO users (nom, prenom, email, adresse_postale, mot_de_passe) VALUES (?, ?, ?, ?, ?)');
            $insertUser->execute([$nom, $prenom, $email, $adresse_postale, $password]);

            $subject = 'Bienvenue sur notre site';
            $loginUrl = 'http://localhost/ECF4/login.php';
            $body = 'Vous pouvez vous connecter à votre compte en utilisant ce lien : <a href="' . $loginUrl . '">Se connecter</a>';

            if (sendEmail($email, $subject, $body)) {
                echo 'Inscription réussie. Votre compte a été créé avec succès.';
            } else {
                echo 'Erreur lors de l\'envoi de l\'email.';
            }
        }
    } else {
        echo 'Veuillez remplir tous les champs du formulaire.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Inscription</title>
</head>
<body>
<?php include 'header.php'; ?>
<div class="video-background">
    <video autoplay muted loop id="bg-video">
      <source src="images/back.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
    <form method="POST" class="container" style="color:white ;" >
        <p>Création de compte</p>
        <div class="form-group">
            <label>Nom</label>
            <input type="text" class="form-control" name="nom">
        </div>
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" class="form-control" name="prenom">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label>Adresse postale</label>
            <input type="text" class="form-control" name="adresse_postale">
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" class="form-control" name="password">
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="valider">Inscription</button>
    </form>
</body>
</html>



