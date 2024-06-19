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
    if (!empty($_POST['email'])) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if ($email) {
            // Vérifier si l'e-mail existe dans la base de données
            $checkEmail = $bdd->prepare('SELECT * FROM users WHERE email = ?');
            $checkEmail->execute([$email]);
            $user = $checkEmail->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                try {
                    // Générer un mot de passe temporaire
                    $temporaryPassword = bin2hex(random_bytes(4)); // Générer un mot de passe temporaire de 8 caractères
                    $hashedPassword = password_hash($temporaryPassword, PASSWORD_DEFAULT);

                    // Mettre à jour le mot de passe dans la base de données
                    $updatePassword = $bdd->prepare('UPDATE users SET mot_de_passe = ? WHERE email = ?');
                    $updatePassword->execute([$hashedPassword, $email]);

                    $subject = 'Réinitialisation de votre mot de passe';
                    $body = 'Bonjour ' . $user['prenom'] . ',<br><br>Votre mot de passe temporaire est : ' . $temporaryPassword . '<br><br>Veuillez le changer dès votre prochaine connexion.<br><br><a href="http://localhost/ECF4/login.php">Cliquez ici pour confirmer votre adresse e-mail</a>';

                    if (sendEmail($email, $subject, $body)) {
                        echo 'Réinitialisation réussie. Un e-mail avec le mot de passe temporaire a été envoyé.';
                    } else {
                        echo 'Erreur lors de l\'envoi de l\'e-mail.';
                    }
                } catch (PDOException $e) {
                    echo 'Erreur lors de la mise à jour du mot de passe : ' . $e->getMessage();
                }
            } else {
                echo 'Cette adresse e-mail n\'existe pas.';
            }
        } else {
            echo 'Adresse e-mail invalide.';
        }
    } else {
        echo 'Veuillez remplir le champ de l\'adresse e-mail.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
</head>
<body>
    <form method="POST" class="container">
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <button type="submit" class="btn btn-success" name="valider">Valider</button>
    </form>
</body>
</html>




