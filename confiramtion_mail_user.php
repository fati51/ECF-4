<?php

session_start();

require 'PHPMailer/PHPMailerAutoload.php';

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Fonction pour envoyer un e-mail
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = 'dahoufatma@gmail.com'; // Remplacez par votre adresse email
    $mail->Password = 'bcvf kexf pwxz basf'; // Remplacez par votre mot de passe

    $mail->setFrom('dahoufatma@gmail.com', 'DAHOU');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    // Activer le débogage
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';

    if ($mail->send()) {
        return true;
    } else {
        echo 'Erreur lors de l\'envoi de l\'e-mail : ' . $mail->ErrorInfo;
        return false;
    }
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['postal_adress']) && !empty($_POST['password'])) {
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $postal_adress = htmlspecialchars($_POST['postal_adress']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if ($email) {
            // Vérifier si l'e-mail existe déjà dans la base de données
            $checkEmail = $bdd->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
            $checkEmail->execute([$email]);
            $emailExists = $checkEmail->fetchColumn();

            if ($emailExists == 0) {
                try {
                    $userInsert = $bdd->prepare('INSERT INTO users (nom, prenom, email, adresse_postale, mot_de_passe) VALUES (?, ?, ?, ?, ?)');
                    $userInsert->execute([$lastname, $firstname, $email, $postal_adress, $password]);

                    $subject = 'Votre compte a été créé avec succès';
                    $body = 'Bonjour ' . $firstname . ',<br><br>Votre compte a été créé avec succès.<br><br>Vous pouvez vous connecter en utilisant votre adresse e-mail : ' . $email . '<br><br><a href="http://localhost/ECF4/confirmation_mail_user.php">Cliquez ici pour confirmer votre adresse e-mail</a>';

                    if (sendEmail($email, $subject, $body)) {
                        echo 'Inscription réussie. Un e-mail avec les détails de connexion a été envoyé.';
                    } else {
                        echo 'Erreur lors de l\'envoi de l\'e-mail.';
                    }
                } catch (PDOException $e) {
                    echo 'Erreur lors de l\'enregistrement dans la base de données : ' . $e->getMessage();
                }
            } else {
                echo 'Cette adresse e-mail est déjà utilisée.';
            }
        } else {
            echo 'Adresse e-mail invalide.';
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
    <title>Inscription</title>
</head>
<body>
    <form method="POST" class="container">
        <p>Inscription</p>
        <div class="form-group">
            <label>Nom</label>
            <input type="text" class="form-control" name="lastname">
        </div>
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" class="form-control" name="firstname">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label>Adresse Postale</label>
            <input type="text" class="form-control" name="postal_adress">
        </div>
        <div class="form-group">
            <label for="MotDePasse"><b>Mot de passe</b></label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-success" name="valider">S'inscrire</button>
        <br>
    </form>
</body>
</html>



