<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Vérifiez si l'utilisateur est déjà authentifié et est un employeur


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_username = htmlspecialchars($_POST["username"]);
    $form_password = $_POST["password"];

    if (empty($form_username) || empty($form_password)) {
        $error = "Veuillez saisir votre nom d'utilisateur et votre mot de passe.";
    } else {
        $servername = "localhost";
        $db_username = "root";
        $db_password = "root";
        $dbname = "gamestore";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare('SELECT id, pseudo, mail, mot_de_passe, role FROM utilisateurs WHERE pseudo = :username');
            $stmt->bindParam(':username', $form_username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user === false) {
                $error = "Aucun utilisateur trouvé avec ce nom d'utilisateur.";
            } else {
                if (password_verify($form_password, $user['mot_de_passe'])) {
                    if ($user['role'] === 'employeur' || $user['role'] === 'producteur') {
                        $_SESSION['employer'] = true;
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['pseudo'];
                        $_SESSION['email'] = $user['mail'];
                        $_SESSION['role'] = $user['role'];
                        header('Location:espace_employer.php');
                        exit;
                    } else {
                        $error = "Vous n'avez pas les droits nécessaires pour accéder à cette page.";
                    }
                } else {
                    $error = "Mot de passe incorrect.";
                }
            }
        } catch (PDOException $e) {
            $error = "Une erreur s'est produite lors de la connexion. Veuillez réessayer plus tard. " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion employeur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #747e88;">
    <div class="container-fluid">
    <a class="navbar-brand" href="espace_admin.php"><img src="./images/logo.jpg" alt="Logo" width="60"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
<div class="row">
        <div class="col-md-12">
            <div class="video-background">
                <video autoplay muted loop id="bg-video" class="w-100">
                    <source src="images/back.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div> 
<div class="container">
    <h1 class="text-center mb-4">Connexion employeur</h1>
    <?php if (!empty($error)) { ?>
        <p class="text-center text-danger"><?php echo $error; ?></p>
    <?php } ?>
    <form class="text-center mb-4" style="max-width: 400px; margin: 0 auto;" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




