<?php  
try{
    $bdd = new PDO('mysql:host=localhost;dbname=gamestore','root','root');
}catch(Exception $e){
    die('veuillez veriffe votre base de donne');
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
    <title>Page d'accueil</title>
</head>
<body>
<?php include 'header.php'; ?>
<br><br>
<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <p style="color:white ;">Gamestore est une entreprise spécialisée dans la vente de jeux vidéo. Ils ont 5 magasins en France à Nantes, Lille, Bordeaux, Paris ainsi que Toulouse.</p>
        </div>
    </div>

    <div class="video-background">
    <video autoplay muted loop id="bg-video">
      <source src="images/back.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
   
    <h2 style="color:white ;" >Retrouvez nous jeux en promotion directement en magazin</h2>
    <div id="promo-container" class="promo-container row">
       
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
