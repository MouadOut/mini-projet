<?php
    function connectMaBasi() {
        $basi = mysqli_connect('localhost', 'root', '', 'mini-projet');
        return $basi;
    }

    $lien=connectMaBasi();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_COOKIE['login'])) {
        $username_cookie_value = $_COOKIE['login'];
    
        $requete = "SELECT id FROM client WHERE username = '$username_cookie_value'";
        $resultat = $lien->query($requete);
    
        if ($resultat->num_rows > 0) {
            $ligne = $resultat->fetch_assoc();
            $id_utilisateur = $ligne['id'];
    
            $id_utilisateur_cookie = $id_utilisateur;
    
        }
    }
    else {
        header('Location: connexion.php');
        exit();
    }

    $ref = $_POST["add_to_cart"];
    
    $sql_produit = "SELECT Images, Reference, Nom, Prix, Categorie FROM produit WHERE Reference='$ref'";
    $result_produit = $lien->query($sql_produit);
    
    if ($result_produit->num_rows > 0) {
        $row = $result_produit->fetch_assoc();
        $images = $row['Images'];
        $reference = $row['Reference'];
        $nom = $row["Nom"];
        $prix = $row["Prix"];
        $categorie = $row["Categorie"];
        
        $sql_panier = "INSERT INTO panier (Images, Reference, Nom, Prix, Categorie, Numclt) VALUES ('$images', '$reference', '$nom', '$prix', '$categorie' , '$id_utilisateur_cookie')";
        
        if ($lien->query($sql_panier) === TRUE) {
            header("Location: panier.php");
            exit();
        } else {
            echo "Erreur: " . $sql_panier . "<br>" . $lien->error;
        }
    } else {
        echo "<script>alert('Produit out of stock');</script>";
    }
}

?>