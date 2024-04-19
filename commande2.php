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
    <title>Passer Commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 10px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            height: 280px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="submit"] {
            background-color: coral;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: rgb(252, 90, 31);
        }
        img {
            margin-top: 10px;
            margin-left: 45%;
        }
        hr {
            margin: 15px auto;
            width: 8%;
            background-color: coral;
            height: 1px;
        }
        h4 span {
            font-size: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <a href="index.html"><img src="assets/imgs/logo.svg"></a><br>
    <div class="container">
        <h2>Passer Commande</h2>
        <hr>
        <?php
            // Calcul de la somme des prix des produits commandés
            $lien = connectMaBasi();
            $sql_total = "SELECT SUM(prix) AS total FROM panier";
            $result_total = mysqli_query($lien, $sql_total);
            $row_total = mysqli_fetch_assoc($result_total);
            $total = $row_total['total'];

            // Affichage de la somme des prix
            // echo "<h5>Total : $total MAD</h5>";
        ?>
        <h4>La somme de vos achats est : <span><?php echo $total; ?></span> MAD</h4>

        <form action="commande2.php" method="post">
            <h4>Choisissez le mode de paiement :</h4>
            <div class="form-group">
                <input name="payer" type="submit" value="Payer par carte">
                <input name="payer" type="submit" value="Payer à la Livraison">
                <input name="acceuil" type="submit" value="Retour à l'accueil">
            </div>
        </form>
        <?php
        if(isset($_POST['payer'])) {
            $lien = connectMaBasi();
            
            // Récupérer la valeur du type de paiement
            $type_paiement = $_POST['payer'];

            // Insertion des données dans la table commande
            $sql_insert_commande = "INSERT INTO commande (Prix_Total, Type_Paiement) VALUES ($total, '$type_paiement')";
            mysqli_query($lien , $sql_insert_commande) or die ('Erreur SQL !'.$sql_insert_commande.'<br>'.mysqli_error($lien));
            
            // Suppression des éléments du panier après la commande
            $sql_delete_panier = "DELETE FROM panier";
            mysqli_query($lien , $sql_delete_panier) or die ('Erreur SQL !'.$sql_delete_panier.'<br>'.mysqli_error($lien));
            
            echo "<h5>Votre commande a été finalisée avec succès. Nous vous remercions pour votre achat.</h5>";
        }
        ?>


    </div>

</body>
</html>
