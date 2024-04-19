<?php
    function connectMaBasi() {
        $basi = mysqli_connect('localhost', 'root', '', 'mini-projet');
        return $basi;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <style>
        table {
            width: 45%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            margin: auto;
        }

        td {
            padding: 8px;
            text-align: left;
        }

        th {
            padding: 8px;
            background-color: #f2f2f2;
            text-align: center;
        }

        .delete, .poursuivre{
            padding: 5px 10px;
            background-color: coral;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }

        .poursuivre:hover , .delete:hover {
            background-color: rgb(252, 90, 31);
        }

        .poursuivre {
            margin-left: 46%;
        }

        img {
            margin-left: 45%;
        }

        .product-image {
            margin-left: 0;
            width: 150px; /* Largeur souhaitée */
            height: auto; /* Hauteur automatique pour maintenir les proportions */
        }
        h3 {
            margin-left: 27.5%;
        }
    </style>
</head>
<body>    
    <a href="index.html"><img src="assets/imgs/logo.svg"></a><br><br>
    <h3>Panier : </h3>
    <table>
        <tr>
            <th>Images</th>
            <th>Référence</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Catégorie</th>
            <th>Action</th>
        </tr>
        <?php
            $lien = connectMaBasi();

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



        $sql_panier = "SELECT images,reference, nom, prix, categorie FROM panier WHERE Numclt='$id_utilisateur_cookie'";
        $result_panier = mysqli_query($lien, $sql_panier);

        if (mysqli_num_rows($result_panier) > 0) {
            // Affichage des données sous forme de tableau HTML
            while($row_panier = mysqli_fetch_assoc($result_panier)) {
                echo "<form action='panier.php' method='post'>";
                echo "<tr>";
                echo "<td><img src='assets/imgs/".$row_panier["images"]."' class='product-image'></td>";
                echo "<td>" . $row_panier["reference"] . "</td>";
                echo "<td>" . $row_panier["nom"] . "</td>";
                echo "<td>" . $row_panier["prix"] . "</td>";
                echo "<td>" . $row_panier["categorie"] . "</td>";
                echo "<td>";
                echo "<input type='hidden' name='reference' value='" . $row_panier["reference"] . "'>";
                echo "<button type='submit' class='delete' name='delete'>Delete</button>";
                echo "</td>";
                echo "</tr>";
                echo "</form>";
            }
        } else {
            echo "<tr><td colspan='4'>Le panier est vide.</td></tr>";
        }

        if(isset($_POST['delete'])) {
            $reference = $_POST['reference'];
        
            // Requête SQL pour supprimer le produit du panier
            $sql = "DELETE FROM panier WHERE reference='$reference'";
        
            if ($lien->query($sql) === TRUE) {
                header('Location:panier.php');
                exit();
            } else {
                echo "Erreur : " . $sql . "<br>" . $lien->error;
            }
        }

        if(isset($_POST['poursuivre'])) {
            header('Location: index.html#featured');
            exit();
        }

        ?>
    </table><br>

    <form action="panier.php" method="post">
        <button name="poursuivre" type="submit" class="poursuivre">Poursuivre les Achats</button>
    </form>
</body>
</html>