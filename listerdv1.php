<div>
    <link href="../css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="../home.css"/>
    <link rel='stylesheet prefetch' href='http://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css'>


    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <?php
    include 'homeMedecin.php';
    $email = $_GET['email'];
    ?>
<!-- ici on affiche le tableau -->
<div align="center">
    <h2>Liste Des Rendez-vous</h2>
</div>
<br/>
<div class="table-responsive" id="table_medecin">

    <table id="autoGeneratedID" role="grid" class="table table-striped table-bordered">
        <caption class="sr-only">Liste des rendez-vous.</caption>
        <!-- le head du tableau-->
        <thead>
        <tr>
            <th id="prenom_p" role="gridcell" >Prénom patient</th>
            <th id="nom_p" role="gridcell" >Nom Patient</th>
            <th id="date_rdv" role="gridcell">Date rendez-vous</th>
            <th id="heure_rdv" role="gridcell">heure</th>
        


        </tr>
        </thead>
        <tbody>
        <!--ici on recupere les donnee du tab de la bdd -->
        <?php
// Vérifier si l'email du patient est passé en paramètre
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Connexion à la base de données (remplacez les valeurs par vos propres informations de connexion)
    $bdd = new PDO('mysql:host=localhost;dbname=services', 'root', '');

    // Récupérer l'identifiant du patient à partir de son email
    $sql_patient_id = "SELECT idMedecin FROM medecin WHERE email_m = :email";
    $stmt = $bdd->prepare($sql_patient_id);
    $stmt->execute(array(':email' => $email));
    $patient = $stmt->fetch();

    // Vérifier si un patient a été trouvé avec cet email
    if ($medecin) {
        $medecin_id = $patient['idMedecin'];

        // Sélectionner tous les rendez-vous associés à ce patient
        $sql_rendezvous = "SELECT rdv.*, patient.nom_p AS nom_patient, patient.prenom_p AS prenom_patient 
                   FROM rendezvous AS rdv 
                   INNER JOIN patient ON rdv.idPatient = patient.idPatient 
                   WHERE rdv.idMedecin = :medecin_id";
$stmt = $bdd->prepare($sql_rendezvous);
$stmt->execute(array(':patient_id' => $patient_id));
$rendezvous = $stmt->fetchAll();


        // Afficher la liste des rendez-vous
        foreach ($rendezvous as $rdv) {
            echo "<tr>";
            echo "<td id='prenom_p' role='gridcell'>" . $rdv['prenom_patient'] . "</td>";
            echo "<td id='nom_p' role='gridcell'>" . $rdv['nom_patient'] . "</td>";
            echo "<td id='date_rdv' role='gridcell'>" . $rdv['date_rdv'] . "</td>";
            echo "<td id='heure_rdv' role='gridcell'>" . $rdv['heure_rdv'] . "</td>";
            echo "</tr>";
        }
        
    } else {
        echo "Aucun patient trouvé avec cet email.";
    }
}
?>



            <tr>
                <td id="nom_m" role="gridcell"><?php echo $donne['prenom_p'];?></td>
                <td id="prenom_m" role="gridcell"><?php echo $donne['nom_p'];?></td>
                <td id="date_rdv" role="gridcell"><?php echo $donne['date_rdv'];?></td>
                <td id="heure_rdv" role="gridcell"><?php echo $donne['heure_rdv'];?></td>
               

                <td>

                    <!--<div class="btn-group">
                        <button type="button"
                                class="btn btn-primary btn-lm dropdown-toggle" data-toggle="dropdown">
                            Prendre rdv <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">

                            <li><input type="button" name="edit" value="Modifier" id="<?php echo $donne["idMEDECIN"];?>"
                                       class="btn btn-warning btn-md edit_data btn-block"/></li>


                            <li><input type="button" name="delete" value="Supprimer" id="<?php echo $donne["idMEDECIN"];?>"
                                       class="btn btn-danger btn-md delete_data btn-block"/></li>
                        </ul>
                    </div>-->


                </td>

            </tr>
            <?php
            $row_count ++ ;

        ?>

        <tbody>
    </table>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src='http://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js'></script>
<script src='http://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js'></script>

<!--ce script pour le fonctionnement des deux btn delete & edit il prend en parametre #idDuTABLEAU et fait appelle à modifier.php-->

<script>

        /* ici c'est le script de dataTable au lieu de faire appelle à index.js on l'a copié ici pour que ça fonctionne*/

        $(document).ready(function(){


            /* ici c'est le script de dataTable au lieu de faire appelle à index.js on l'a copié ici pour que ça fonctionne*/

            $('#autoGeneratedID').dataTable({
                "columnDefs": [
                    { "orderable": false, "targets": 0 }/*il y'avait 3 pour le double clique et modifier*/
                ]
            } );
            $('#autoGeneratedID td').attr('role', 'gridcell');
            $('#autoGeneratedID tr').attr('role', 'row');
            $('#autoGeneratedID th').attr('role', 'gridcell');
            $('#autoGeneratedID table').attr('role', 'grid');
            // $('#autoGeneratedID td:nth-of-type(-n+3)').attr('contenteditable', 'true');

        });

        //bouton ajouter

        $('#ajout').click(function () {
            $('#insert').val("Valider");
            $('#insert_form')[0].reset();
        });


        /******************** bouton modifier*********************/

        $(document).on('click', '.edit_data', function () {
            var id = $(this).attr("id");
            $.ajax({
                url: "affichModifierMedecin.php",
                method: "POST",
                data: {id: id},
                dataType: "json",
                success: function (data) {
                    //remplir les cases avec les anciens données
                    $('#nom').val(data.nom_m);
                    $('#prenom').val(data.prenom_m);
                    $('#adresse').val(data.adresse_m);
                    $('#grade').val(data.grade_m);
                    $('#specialite').val(data.specialite_m);
                    $('#numTel').val(data.numTel_m);


                    $('#id').val(data.idMEDECIN);

                    $('#insert').val("Modifier");
                    $('#add_data_Modal').modal('show');


                }

            });
        });


        /****Supprimer****/

        $(document).on('click','.delete_data', function(){

            var id=$(this).attr("id");
            if(confirm("êtes-vous sûr de supprimer ce medecin?")){

                $.ajax({
                    url:'suppMed.php',
                    type: 'POST',
                    data:{
                        ids:id
                    },
                    success: function(result){
                        if(result.trim() == "success")
                            window.location.reload();
                        else alert(result.trim());

                    }
                });



            }
        });


</script>







<!--pour afficher les btn delete et edit-->
<script src="js/jquery/jquery.tabledit.js"></script>
<!--
<script>
    $(document).ready(function(){
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#nom').val() == "")
            {
                alert("Name is required");
            }
            else if($('#prenom').val() == '')
            {
                alert("prenom is required");
            }
            else if($('#grade').val() == '')
            {
                alert("grade is required");
            }

            else
            {
                //faire appelle directement à ajouterMedecin.php
                $.ajax({
                    url:"ajouterMedecin.php",
                    method:"POST",
                    data:$('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#table_medecin').html(data);
                    }
                });
            }
        });
    });
</script>




-->






