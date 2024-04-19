<?php
    if (isset($_COOKIE['login'])) {
        header('Location: commande.php');
        exit();
    } else {
        header('Location: connexion.php');
        exit();
    }
?>