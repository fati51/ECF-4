<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
    <title>Espace administrateur</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #c3e6cb;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="./images/logo.jpg" alt="Logo" width="60"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav_link nav-link" href="logout_admin.php">Déconnexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav_link nav-link" href="creer_jeux.php">Ajouter un jeu</a>
                </li>
                <li class="nav-item">
                    <a class="nav_link nav-link" href="admin_update_stock.php">Gestion de stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav_link nav-link" href="tous_lesjeux.php">Liste des jeux</a>
                </li>
                <li class="nav-item">
                    <a class="nav_link nav-link" href="creation_compte_employer.php">Création compte</a>
                </li>
            </ul>
        </div>
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
<div>
<h1 class="text-center">Espace administrateur </h1>

<p class="text-center">Bienvenue, administrateur !</p>
    </div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
