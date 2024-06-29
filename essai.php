<!-- formulaire-->
<div id="add_data_Modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">&times;</button>
                <h4 class="modal-title">Ajouter un médecin</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="insert_form" action="ajouterMedecin.php">

                    <label for="nom">Nom</label>
                    <input type="text" name="nom_m" id="nom" class="form-control" />
                    <br/>

                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom_m" id="prenom" class="form-control" />
                    <br/>

                    <label for="adresse">Adresse</label>
                    <textarea name="adresse_m" id="adresse" class="form-control"></textarea>
                    <br/>

                    <label for="grade">Grade</label>
                    <input type="text" name="grade_m" id="grade" class="form-control" />
                    <br/>

                    <label for="specialite">Spécialité</label>
                    <select name="specialite_m" id="specialite" class="form-control">
                        <option value="Cardiologue">Cardiologue</option>
                        <option value="Interniste">Interniste</option>
                        <option value="Hémathologue">Hémathologue</option>
                        <option value="Généraliste">Généraliste</option>
                    </select>
                    <br/>

                    <label for="numTel">Téléphone</label>
                    <input type="text" name="numTel_m" id="numTel" class="form-control" />
                    <br/>
                    <label for="user">Nom d'utilisateur</label>
                    <input type="text" name="user" id="user" class="form-control"/>
                    <br/>

                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control"/>
                    <br/>
                    <input type="hidden" name="id" id="id" />
                    <input type="submit" name="insert" id="insert" value="Valider" class="btn btn-primary" />

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Annuler">Annuler</button>

            </div>
        </div>
    </div>
</div>

<!-- Traitement du Formulaire-->
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
?>