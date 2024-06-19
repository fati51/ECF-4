<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "gamestore";

try {
    
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $sql = "SELECT * FROM jeux_video";
    $stmt = $pdo->query($sql);

    
    if ($stmt->rowCount() > 0) {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les jeux </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            height: 400px; 
        }

        .card-body {
            padding: 20px; 
        }

        .card-margin {
            margin-bottom: 20px; 
        }
        .coeur-rouge {
             color: red;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #747e88;">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src="./Images/logo jeuxvideo.png" alt="GameSoft Logo" width="60"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="description.html">Qui nous sommes</a>
                     </li>
                     
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Bienvenue chez GameSoft</h1>
        <p>Studio de jeu vidéo français spécialisé dans les RPG</p>
       


        <div class="container">
            <div class="row" id="searchResults"> 
                <?php
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $titre = $row['libelle'];
                    $cheminImage = $row['galerie_images'];
                    $pegi = $row['pegi'];
                    $genre = $row['genre'];
                    $prix = $row['prix'];
                    $quantite = $row['quantite'];
                    $image = $row['image'];
                    
                ?>
                <div class="col-md-6 card-margin">
                    <div class="card">
                        <img src="<?php echo $cheminImage; ?>" class="card-img-top" alt="<?php echo $titre; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $titre; ?></h5>
                           
                            <p class="card-text">Type : <?php echo $pegi ; ?></p>
                            <p class="card-text">Type : <?php echo $quantite ; ?></p>
                            <p class="card-text">Type : <?php echo $genre ; ?></p>
                            <p class="card-text">Type : <?php echo $prix ; ?></p>
                            <p class="card-text">Type : <?php echo $cheminImage ; ?></p>
                            
                            <a href="details.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">En savoir plus</a>
                            <button class="btn btn-primary btn-favoris" data-jeu-id="<?php echo $id; ?>"><i class="fas fa-heart"></i> Ajouter aux favoris</button>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            
            $("#searchForm").submit(function(event) {
                event.preventDefault(); 

                
                var query = $("#searchInput").val();
                var criteria = $("#searchCriteria").val();

              
                $("#searchResults").load("barre_recherche.php?query=" + query + "&critere=" + criteria);
            });
        });
    </script>
</body>
</html>
<?php
    } else {
        echo "Aucun jeu en cours trouvé.";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



