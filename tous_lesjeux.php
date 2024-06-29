<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

try{
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore','root','root');
}catch(Exception $e){ 
    die('Veuillez vérifier votre base de données');
}

$allJeux = $bdd->query('SELECT * FROM jeux_video ORDER BY id DESC ');

if(isset($_GET['search']) AND !empty($_GET['search'])){
    $search = $_GET['search'];

    $query = "SELECT * FROM jeux_video WHERE prix LIKE '%$search%' OR genre LIKE '%$search%' ORDER BY id DESC";
    $allJeux = $bdd->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Tous les jeux</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #c3e6cb;">
  <div class="container-fluid">
  <a class="navbar-brand" href="index.php"><img src="./images/logo.jpg" alt="Logo" width="60"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Fil d’actualité</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tous_lesjeux.php">Tous les jeux</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Connexion</a>
        </li>
      </ul> 
      <form class="d-flex" role="search" method="GET">
        <input class="form-control me-2" type="search" name="search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav> 
<br>
<div class="row">
        <div class="col-md-12">
            <div class="video-background">
                <video autoplay muted loop id="bg-video" class="w-100">
                    <source src="images/back.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div> 

<?php while($jeuInfo = $allJeux->fetch()) { ?>
<div class="container">
    <div class="row justify-content">
        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header"><?= $jeuInfo['libelle'] ?></h5>
                <div class="card-body">
                    <div class="mb-3">
                        <img src="<?= $jeuInfo['image'] ?>" alt="Image of <?= $jeuInfo['libelle'] ?>" class="img-fluid">
                    </div>
                    <div class="my-3">
                        <small>PEGI <?= $jeuInfo['pegi'] ?></small>
                    </div>
                    <div class="my-3">
                        <small>Prix <?= $jeuInfo['prix'] ?> €</small>
                    </div>
                    <a href="ajoute_jeu_panier.php?id=<?=$jeuInfo['id']?>" class="btn btn-secondary">Ajouter au panier</a>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<?php } ?>
</body>
</html>
