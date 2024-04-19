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
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Pour aligner le formulaire et le logo verticalement */
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        legend {
            font-weight: bold;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: coral;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
        }

        input[type="submit"]:hover {
            background-color: rgb(252, 90, 31);
        }

    </style>
</head>
<body>
    <a href="index.html"><img src="assets/imgs/logo.svg"></a><br>
    <form action="connexion.php" method="post">
        <fieldset>
            <legend>Login Form</legend>
            <label for="login">Username :</label>
            <input type="text" id="login" name="login"><br>
            <label for="password">Password :</label>
            <input type="password" id="password" name="password" ><br><br>
            <input type="submit" name="submit1" value="Log in as Admin">
            <input type="submit" name="submit2" value="Log in as Client">
            <input type="submit" name="submit3" value="Create Account">
        </fieldset>
    </form>
    
    <?php
    $lien = connectMaBasi();

    if(isset($_POST['submit1'])) {
        $login = $_POST['login'];
        $pass = $_POST['password'];

        // Requête SQL pour vérifier les identifiants dans la base de données
        $sql = "SELECT * FROM Admin WHERE username = '$login' AND password = '$pass'";
        $result = $lien->query($sql);

        if ($result->num_rows > 0) {
            // Si les identifiants sont valides, rediriger vers formAdmin.php
            setcookie("login", $login, time() + (86400 * 30), "/");
            header("Location: formAdmin.php");
            exit();
        } else {
            // Si les identifiants sont invalides, rediriger vers connexion.php
            header("Location: connexion.php");
            exit();
        }
    }

    if(isset($_POST['submit2'])) {
        $login = $_POST['login'];
        $pass = $_POST['password'];

        // Requête SQL pour vérifier les identifiants dans la base de données
        $sql = "SELECT * FROM Client WHERE username = '$login' AND password = '$pass'";
        $result = $lien->query($sql);

        if ($result->num_rows > 0) {
            // Si les identifiants sont valides, rediriger vers formAdmin.php
            setcookie("login", $login, time() + (86400 * 30), "/");
            header("Location: index.html");
            exit();
        } else {
            // Si les identifiants sont invalides, rediriger vers connexion.php
            header("Location: connexion.php");
            exit();
        }
    }

    if(isset($_POST['submit3'])) {
        header("Location: registration.php");
        exit();
    }

    ?>
</body>
</html>
