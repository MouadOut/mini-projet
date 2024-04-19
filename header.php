<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppie</title>
    <style>
        table {
            width: 50%;
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

        .delete{
            padding: 5px 10px;
            background-color: coral;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 5px;
            white-space: nowrap;
        }

        .delete:hover {
            background-color: rgb(252, 90, 31);
        }

        img {
            margin-left: 45%;
        }

        .product-image {
            margin-left: 0;
            width: 150px; /* Largeur souhaitée */
            height: auto; /* Hauteur automatique pour maintenir les proportions */
        }

        span {
            margin-left: 25%;
            font-size: large;
            font-weight: 500;
        }
        div {
            margin-bottom: 15px;
        }

        .filtrer {
            margin-left: 30%;
        }
        .filtrer-container {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            width: 47%;
            margin-left: 25%;
        }

        .filtrer {
            display: flex;
            align-items: center;
        }

        .filtrer label {
            margin-right: 10px;
            font-weight: bold;
        }

        .filtrer select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .filtrer input[type="submit"] {
            padding: 8px 20px;
            background-color: coral;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filtrer input[type="submit"]:hover {
            background-color: rgb(252, 90, 31);
        }
    </style>
</head>
<body>
    <?php
        function connectMaBasi() {
            $basi = mysqli_connect('localhost', 'root', '', 'mini-projet');
            return $basi;
        }

        if(isset($_POST['connect'])){
        
            if(isset($_COOKIE['login'])) {
                header('Location: index.html');
                exit();
            }
            else {  
                header('Location: connexion.php');
                exit();
            }
        }

        if(isset($_POST['panier'])){
            if (isset($_COOKIE['login'])) {
                header('Location: panier.php');
                exit();
            } else {
                header('Location: connexion.php');
                exit();
            }
        }

        if(isset($_POST['logout'])) {
            setcookie("login", $login, time() - 0, "/");
            header('Location: index.html');
            exit();
        }

        if(isset($_POST['rechercher-btn'])) {
            $searchQuery = $_POST['rechercher'];
            if(empty($searchQuery)) {
                header('Location: index.html');
                exit();
            }
            else {
                echo "<a href='index.html'><img src='assets/imgs/logo.svg'></a><br><br>";
                $lien = connectMaBasi();

                $sql = "SELECT images, reference, nom, prix, categorie FROM produit WHERE nom LIKE '%$searchQuery%' OR categorie LIKE '%$searchQuery%'";
                $result = $lien->query($sql);
            
                if ($result->num_rows > 0) {
                    echo "<div>";

                    echo "<div class='filtrer-container'>";
                    echo "<form class='filtrer' action='trier.php' method='post'>";
                    echo "<input type='hidden' name='searchQuery' value='$searchQuery'>";
                    echo " <label for='sorting'>Filtrer Par:</label>";
                    echo "<select name='sorting' id='sorting'>";
                    echo "<option value='prix_asc'>Prix croissant</option>";
                    echo "<option value='prix_desc'>Prix décroissant</option>";
                    echo "</select>";
                    echo "<input type='submit' value='Trier'>";
                    echo "</form>";
                    echo "</div>";
                    
                    echo "<span class='header-text'>Résultats de votre Recherche :</span>";
                    echo "</div>";
                    echo "<table>";
                    echo "<tr><th>Images</th><th>Référence</th><th>Nom</th><th>Prix</th><th>Catégorie</th><th>Action</th></tr>";
                    while($row = mysqli_fetch_assoc($result)) {

                        echo "<tr>";
                        echo "<td><img src='assets/imgs/".$row["images"]."' class='product-image'></td>";
                        echo "<form action='addtocart2.php' method='post'>";
                        echo "<td>" . $row["reference"] . "</td>";
                        echo "<td>" . $row["nom"] . "</td>";
                        echo "<td>" . $row["prix"] . "</td>";
                        echo "<td>" . $row["categorie"] . "</td>";
                        echo "<td>";
                        echo "<input type='hidden' name='add_to_cart' value='". $row["reference"] ."'>";
                        echo "<button type='submit' class='delete'>Add to Cart</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";

                    }
                    echo "</table>";
                } else {
                    header('Location: index.html');
                    exit();
                }
            }
        }
    ?>



</body>
</html>