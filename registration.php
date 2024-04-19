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
    <title>Registration Form</title>
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
    <form action="registration.php" method="post">
        <fieldset>
            <legend>Registration Form</legend>
            <label>Username :</label>
            <input type="text" id="login" name="login" required><br>
            <label>Password :</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" name="submit" value="Register">
        </fieldset>
    </form>

    <?php
        $lien = connectMaBasi();
        if(isset($_POST['submit'])) {
            $username = $_POST['login'];
            $password = $_POST['password'];
        
            // Requête SQL pour insérer un nouvel utilisateur dans la table client
            $sql = "INSERT INTO client (username, password) VALUES ('$username', '$password')";
        
            if ($lien->query($sql) === TRUE) {
                header("Location: connexion.php");
                exit();
            } else {
                echo "Erreur : " . $sql . "<br>" . $lien->error;
            }
        }
    ?>



</body>
</html>