<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (isset($_SESSION['employer'])) {
    header('Location: login_employer.php');
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_username = htmlspecialchars($_POST["username"]);
    $form_password = $_POST["password"];

    // Validation côté serveur
    if (empty($form_username) || empty($form_password)) {
        $error = "Veuillez saisir votre nom d'utilisateur et votre mot de passe.";
    } else {
        // Utilisation de variables d'environnement pour les informations de connexion
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
            $user = $stmt->fetch();

            if ($user && password_verify($form_password, $user['mot_de_passe']) && $user['role'] === 'employer') {
                $_SESSION['employer'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['pseudo'];
                $_SESSION['email'] = $user['mail'];
                header('Location:view_orders.php');
                exit;
            } else {
                $error = "Identifiant ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            // Ne pas afficher de détails spécifiques sur l'erreur de connexion à la base de données
            $error = "Une erreur s'est produite lors de la connexion. Veuillez réessayer plus tard.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion producteur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
   
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #747e88;">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="./Images/logo jeuxvideo.png" alt="GameSoft Logo" width="100"></a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h1 class="text-center mb-4">Connexion producteur</h1>

    <?php if (!empty($error)) { ?>
        <p class="text-center text-danger"><?php echo $error; ?></p>
    <?php } ?>

    <form class="text-center mb-4" style="max-width: 400px; margin: 0 auto;" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group ">
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