<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "gamestore";
try {
    
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        
        $sql = "SELECT * FROM jeux_video WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $libelle = $row['libelle'];
            $quantite = $row['quantite'];
            $pegi= $row['pegi'];
            $description = $row['description'];
            $genre = $row['genre'];
            $prix = $row['prix'];
            $image = $row['image']
            


            ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Détails du live</title>
                
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            </head>
            <body>
            <div class="container">
                <h1>Détails du live</h1>
                <div class="card">
                    
                    <div class="card-body">
                        
                      <p class="card-text"> image: <?php echo $image; ?></p>
                        <p class="card-text"> Libelle: <?php echo $libelle; ?></p>
                        <p class="card-text">pegi : <?php echo $pegi; ?></p>
                        <p class="card-text"> quantite: <?php echo $quantite; ?></p>
                        <p class="card-text"> prix: <?php echo $prix; ?></p>
                        <p class="card-text"> description: <?php echo $description; ?></p>
                        <p class="card-text"> genre: <?php echo $genre; ?></p>

                        
                       
                       
                        <a href="index.php" class="btn btn-danger">Retour</a>
                    </div>
                </div>
            </div>

            </body>
            </html>
            <?php
        } else {
            echo "Live non trouvé.";
        }
    } else {
        echo "Live non trouve .";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>