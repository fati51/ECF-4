<?php
session_start();

// Détruire la session et rediriger vers la page de connexion
session_destroy();
header('Location: login_employer.php');
exit;
?>