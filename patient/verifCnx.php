<?php
// Connexion à la base de données
$servername = "localhost"; // Remplacez localhost par le nom de votre serveur MySQL
$username = "root"; // Remplacez username par votre nom d'utilisateur MySQL
$password = ""; // Remplacez password par votre mot de passe MySQL
$dbname = "services"; // Remplacez mydatabase par le nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $motdepasse = $_POST['motdepasse'];
    $typeUser = "patient"; // Vous pouvez modifier le type d'utilisateur selon vos besoins

    // Requête SQL pour insérer l'utilisateur dans la table "users"
    $sql = "INSERT INTO users (username, password, typeUser) VALUES ('$username', '$motdepasse', '$typeUser')";

    if ($conn->query($sql) === TRUE) {
        // Récupérer l'ID de l'utilisateur inséré
        $idUser = $conn->insert_id;

        // Requête SQL pour insérer les informations supplémentaires dans la table des utilisateurs
        $sqlInfo = "INSERT INTO patient (idUser, prenom_p, nom_p, email_p, password_p) VALUES ('$idUser', '$prenom', '$nom', '$email', '$motdepasse')";

        if ($conn->query($sqlInfo) === TRUE) {
            echo "Inscription réussie.";
            header("location:login/index.html");
        } else {
            echo "Erreur: " . $sqlInfo . "<br>" . $conn->error;
        }
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    // Requête SQL pour vérifier les informations de connexion
    $sql = "SELECT * FROM patient WHERE email_p='$email' AND password_p='$motdepasse'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Connexion réussie, rediriger vers la page listeMedecin.php avec l'email en paramètre
        header("location:homePatient.php?email=$email");
        exit; // Assure que le script s'arrête ici pour éviter toute exécution supplémentaire
    } else {
        echo "Identifiants invalides.";
    }
}


$conn->close();
?>
