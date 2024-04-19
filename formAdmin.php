<?php
    function connectMaBasi() {
        $basi = mysqli_connect('localhost', 'root', '', 'mini-projet');
        return $basi;
    }

    $lien = connectMaBasi();

    if(isset($_POST['supprimer'])) {
        $Reference = $_POST['ref']; // Référence du produit à supprimer
        $sql = "DELETE FROM Produit WHERE Reference = '$Reference'";
        mysqli_query($lien , $sql) or die ('Erreur SQL !'.$sql.'<br>'.mysqli_error($lien));
    }

    if(isset($_POST['supprimer1'])) {
        $ID = $_POST['client_id']; 
        $sql = "DELETE FROM Client WHERE ID = '$ID'";
        mysqli_query($lien , $sql) or die ('Erreur SQL !'.$sql.'<br>'.mysqli_error($lien));
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Client</title>
    <script src="https://kit.fontawesome.com/4c1dca636d.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        fieldset {
            background-color: #fff;
            border: 1px solid black;
            padding: 20px;
            margin-bottom: 20px;
        }
        legend {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 98%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid gray;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: coral;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: rgb(252, 90, 31);
        }
        
        .btn {
            background-color: transparent;
            border: none;
            font-size: 24px;
            cursor: pointer;
            margin-left: 97%;
        }
        table {
            width: 45%;
            border-collapse: collapse;
            margin: auto;
        }

        table, th, td {
            border: 1px solid #ddd;
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

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        .action-buttons button, .ajouter {
            padding: 5px 10px;
            background-color: coral;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 5px;
            margin-bottom: 5px; /* Ajout de marge entre les boutons */
        }

        .ajouter {
            display: inline-block;
            padding: 15px 20px;
            background-color: coral;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            border-radius: 8px;
            margin-right: 20px;
            transition: background-color 0.3s ease;
            border: 2px solid rgb(252, 90, 31);
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer; /* Ajout pour montrer que c'est cliquable */
            margin-left: 42%;
            margin-bottom: 10px;
        }

        a {
        color: inherit;
        text-decoration: none;
        }

        .action-buttons button:hover {
            background-color: rgb(252, 90, 31);
        }

        .product-image {
            width: 150px; /* Largeur souhaitée */
            height: auto; /* Hauteur automatique pour maintenir les proportions */
            display: block;
            margin: 0 auto;
        }

        h3 {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- logout  -->
    <form action="formAdmin.php" method="POST">
        <button name="logout" class="btn btn-outline my-2 my-sm-0" type="submit"><i class="fa-solid fa-sign-out"></i></button>
    </form>

    <?php
        if(isset($_POST['logout'])) {
            setcookie("login", $login, time() - 0, "/");
            header('Location: index.html');
            exit();
        }
    ?>

    <!-- Client  -->
    <fieldset>
        <legend><h3><b>Ajouter Client : </b></h3></legend>
        <form action="formAdmin.php" method="POST">
            <label>ID:</label><br>
            <input type="text" name="ID"><br>
            
            <label>Username :</label><br>
            <input type="text" name="Nom"><br>
            
            <label>Password :</label><br>
            <input type="text" name="Pass"><br>
            
            <input type="submit" name="insert" value="Insérer">
            <input type="submit" name="update" value="Mettre à jour">
            <input type="submit" name="admin" value="Set Admin">
        </form>
    </fieldset><br>
    
    <?php
        $lien = connectMaBasi();
    
        if(isset($_POST['insert'])) {
            try {
            $ID = $_POST['ID'];
            $Nom = $_POST['Nom'];
            $Pass = $_POST['Pass'];

    
            $sql = "INSERT INTO Client (ID, username, password)
                    VALUES ('$ID', '$Nom', '$Pass')";
            
            mysqli_query($lien , $sql) or die ('Erreur SQL !'.$sql.'<br>'.mysqli_error($lien));
            echo "Client inséré avec succès.";
            }
            catch(mysqli_sql_exception) {echo "An Error Occured !";}
    
        } elseif(isset($_POST['delete'])) {
            $ID = $_POST['ID']; // ID du client à supprimer
            $sql1 = "DELETE FROM Panier WHERE Numclt = '$ID'";
            mysqli_query($lien , $sql1) or die ('Erreur SQL !'.$sql1.'<br>'.mysqli_error($lien));
            $sql = "DELETE FROM Client WHERE ID = '$ID'";
            mysqli_query($lien , $sql) or die ('Erreur SQL !'.$sql.'<br>'.mysqli_error($lien));
            echo "Client supprimé avec succès.";
    
        } elseif(isset($_POST['update'])) {
            $ID = $_POST['ID']; // ID du client à mettre à jour
            $Nom = $_POST['Nom'];
            $Pass = $_POST['Pass'];
            
            $sql = "UPDATE Client SET username = '$Nom', password = '$Pass' WHERE ID = '$ID'";
            mysqli_query($lien , $sql) or die ('Erreur SQL !'.$sql.'<br>'.mysqli_error($lien));
            echo "Client mis à jour avec succès.";

        } elseif(isset($_POST['admin'])) {
            $id = $_POST['ID'];
        
            $sql = "SELECT username, password FROM Client WHERE id = '$id'";
            $result = mysqli_query($lien, $sql);
        
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $username = $row['username'];
                $password = $row['password'];
        
                $insertSql = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";
                mysqli_query($lien, $insertSql) or die ('Erreur SQL !'.$insertSql.'<br>'.mysqli_error($lien));
        
                echo "Client ajouté en tant qu'administrateur avec succès.";
            } else {
                echo "Aucun client trouvé avec ce nom d'utilisateur.";
            }
        }
    ?>

    <!-- Liste Clients -->
    <table>
        <tr>
            <th>Identifiant</th>
            <th>Nom d'utilisateur</th>
            <th>Mot de passe</th>
            <th>Action</th>
        </tr>
        <?php
            $lien = connectMaBasi();
            $sql_clients = "SELECT id, username, password FROM client";
            $result_clients = mysqli_query($lien, $sql_clients);

            if (mysqli_num_rows($result_clients) > 0) {
                // Affichage des données sous forme de tableau HTML
                while($row_client = mysqli_fetch_assoc($result_clients)) {
                    echo "<form action='formAdmin.php' method='post'>";
                    echo "<tr>";
                    echo "<td>" . $row_client["id"] . "</td>";
                    echo "<td>" . $row_client["username"] . "</td>";
                    echo "<td>" . $row_client["password"] . "</td>";
                    echo "<td class='action-buttons'>";
                    echo "<input type='hidden' name='client_id' value='" . $row_client["id"] . "'>";
                    echo "<div><button type='submit' class='delete' name='supprimer1'>Supprimer</button></div>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</form>";
                }
            } else {
                echo "<tr><td colspan='4'>Pas de Clients</td></tr>";
            }
        ?>
    </table>
    
    <!-- Produit  -->
    <fieldset>
        <legend><b><h3>Ajouter Produit : </h3></b></legend>
        <form action="formAdmin.php" method="POST" enctype="multipart/form-data">
            <label>Images :</label><br>
            <input type="file" name="Images" accept=".png, .jpg, .jpeg"><br><br>

            <label>Reference :</label><br>
            <input type="text" name="Reference"><br>

            <label>Nom :</label><br>
            <input type="text" name="Nom"><br>
            
            <label>Prix :</label><br>
            <input type="text" name="Prix"><br>
            
            <label>Categorie :</label><br>
            <input type="text" name="Categorie"><br>
            
            <input type="submit" name="insert1" value="Insérer">
            <input type="submit" name="update1" value="Mettre à jour">
        </form>
    </fieldset><br>

    <?php
        $lien = connectMaBasi();

        if(isset($_POST['insert1'])) {
            try {
                $Images = $_FILES['Images']['name']; // Nom du fichier téléchargé
                $tempImages = $_FILES['Images']['tmp_name']; // Emplacement temporaire du fichier téléchargé
                $Reference = $_POST['Reference'];
                $Nom = $_POST['Nom'];
                $Prix = $_POST['Prix'];
                $Categorie = $_POST['Categorie'];
        
                // Déplacer le fichier téléchargé vers le répertoire cible
                move_uploaded_file($tempImages, 'assets/imgs/' . $Images);

                $sql = "INSERT INTO Produit (Images, Reference, Nom, Prix, Categorie)
                        VALUES ('$Images', '$Reference', '$Nom', '$Prix', '$Categorie')";
                
                mysqli_query($lien , $sql) or die ('Erreur SQL !'.$sql.'<br>'.mysqli_error($lien));
                echo "Produit inséré avec succès.";
            } catch(mysqli_sql_exception $e) {
                echo "Une erreur est survenue : " . $e->getMessage();
            }

        } elseif(isset($_POST['update1'])) {
            $Images = $_FILES['Images']['name']; // Nom du fichier téléchargé
            $tempImages = $_FILES['Images']['tmp_name']; // Emplacement temporaire du fichier téléchargé
            $Reference = $_POST['Reference']; // Référence du produit à mettre à jour
            $Nom=$_POST['Nom'];
            $Prix = $_POST['Prix'];
            $Categorie = $_POST['Categorie'];

            // Déplacer le fichier téléchargé vers le répertoire cible
            move_uploaded_file($tempImages, 'assets/imgs/' . $Images);
            
            $sql = "UPDATE Produit SET Images = '$Images', Prix = '$Prix', Nom = '$Nom', Categorie = '$Categorie' WHERE Reference = '$Reference'";
            mysqli_query($lien , $sql) or die ('Erreur SQL !'.$sql.'<br>'.mysqli_error($lien));
            echo "Produit mis à jour avec succès.";
        }
        
        mysqli_close($lien);
    ?>

    <!-- Liste Produits  -->
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
            $sql_panier = "SELECT images, reference, nom, prix, categorie FROM produit";
            $result_panier = mysqli_query($lien, $sql_panier);

            if (mysqli_num_rows($result_panier) > 0) {
                // Affichage des données sous forme de tableau HTML
                while($row_panier = mysqli_fetch_assoc($result_panier)) {
                    echo "<form action='formAdmin.php' method='post'>";
                    echo "<tr>";
                    echo "<td><img src='assets/imgs/".$row_panier["images"]."' class='product-image'></td>";
                    echo "<td>" . $row_panier["reference"] . "</td>";
                    echo "<td>" . $row_panier["nom"] . "</td>";
                    echo "<td>" . $row_panier["prix"] . "</td>";
                    echo "<td>" . $row_panier["categorie"] . "</td>";
                    echo "<td class='action-buttons'>";
                    echo "<input type='hidden' name='ref' value='" . $row_panier["reference"] . "'>";
                    echo "<div><button type='submit' class='delete' name='supprimer'>Supprimer</button></div>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</form>";
                }
            } else {
                echo "<tr><td colspan='4'>Pas de Produits</td></tr>";
            }

        ?>
    </table>

</body>
</html>
