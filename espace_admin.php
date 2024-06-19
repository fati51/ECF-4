<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                    <a href="logout_admin.php">Déconnexion</a>
                </li>
                <li class="nav-item">
                    <a href="creer_jeux.php">Ajouter un jeu</a>
                </li>
                <li class="nav-item">
                    <a href="admin_update_stock.php">Gestion de stock</a>
                </li>
                <li class="nav-item">
                    <a href="tous_lesjeux.php">Liste des jeux</a>
                </li>
                <li class="nav-item">
                    <a href="creation_compte_employer.php">Création compte</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div>
<h1 class="text-center">Espace administrateur </h1>

<p class="text-center">Bienvenue, administrateur !</p>
    </div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
