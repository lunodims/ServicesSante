<?php
if ($insert == 'Valider') {
    try {
        $connexionDB = new PDO('mysql:host=localhost;dbname=services', 'root', '');

        // Commencer la transaction
        $connexionDB->beginTransaction();

        // Insérer l'utilisateur
        $insertUser = $connexionDB->prepare("INSERT INTO users(username, password, typeUser) VALUES (?,?,?)");
        $insertUser->execute(array($username, $password, $userType));

        // Récupérer l'ID de l'utilisateur inséré
        $idUtilisateur = $connexionDB->lastInsertId();

        // Insérer le médecin avec l'ID de l'utilisateur correspondant
        $insertMedecin = $connexionDB->prepare("INSERT INTO medecin(nom_m, prenom_m, adresse_m, grade_m, specialite_m, numTel_m, idUser)
                                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertMedecin->execute(array($nom, $prenom, $adresse, $grade, $specialite, $numTel, $idUtilisateur));

        // Valider la transaction
        $connexionDB->commit();
        echo "insertion reussi";
        //header("location:listeMedecin.php");
    } catch (PDOException $e) {
        // En cas d'erreur, annuler la transaction et afficher l'erreur
        $connexionDB->rollBack();
        die("Erreur: " . $e->getMessage());
    }
}
 // Modifier medecin
else {
    try {
        $connexionDB = new PDO('mysql:host=localhost;dbname=services', 'root', '');

        $idMEDECIN = $_POST['id'];


        $query = "UPDATE medecin SET nom_m=?, prenom_m=?, adresse_m=? , grade_m=?, specialite_m=?, numTel_m=? WHERE idMEDECIN=?";

        $query = $connexionDB->prepare($query);

        $query->execute(array($nom, $prenom,  $adresse, $grade, $specialite, $numTel, $idMEDECIN));

        header("location:listeMedecin.php");
    } catch
    (PDOException $e) {
        die("Erreur: " . $e->getMessage());
    }
}
