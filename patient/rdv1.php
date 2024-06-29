<div>
    <link href="../css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="../home.css"/>
    <link rel='stylesheet prefetch' href='http://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css'>


    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <?php
    include 'home1.php';
    $email = $_GET['email'];

    ?>
<!-- ici on affiche le tableau -->
<div align="center">
<h2>Prise de rendez-vous</h2>
</div>
<br/>
<div class="table-responsive" id="table_medecin">

    
        <caption class="sr-only">Formulaire de prise de rendez-vous</caption>

    <?php if ($success_message != ""): ?>
        <div style="color: green;"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if ($error_message != ""): ?>
        <div style="color: red;"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Email du patient: <input type="email" name="email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>" required><br>
        Date du rendez-vous: <input type="date" name="date_rdv" required><br>
        Heure du rendez-vous: <input type="time" name="heure_rdv" required><br>
        Description du rendez-vous: <textarea name="description_rdv" ></textarea><br> <!-- Nouveau champ pour la description -->
        <!-- Afficher le nom et le prénom du médecin sélectionné -->
        Médecin sélectionné: <?php echo $medecin_prenom . " " . $medecin_nom; ?><br>
        <!-- Ajouter un champ caché pour l'identifiant du médecin -->
        <input type="hidden" name="medecin_id" value="<?php echo $medecin_id; ?>">
        <input type="submit" value="Prendre rendez-vous">
    </form>
        <tbody>
        <!--ici on recupere les donnee du tab de la bdd -->
        <?php
// Connexion à la base de données (à adapter selon votre configuration)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "services";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Traitement du formulaire de rendez-vous
$success_message = "";
$error_message = "";

// Récupérer l'identifiant du médecin depuis l'URL
$medecin_id = isset($_GET['medecin_id']) ? $_GET['medecin_id'] : '';

if (!empty($medecin_id)) {
    $sql_medecin_info = "SELECT nom_m, prenom_m FROM medecin WHERE idMedecin = $medecin_id";
    $result_medecin_info = $conn->query($sql_medecin_info);
    if ($result_medecin_info->num_rows > 0) {
        $row = $result_medecin_info->fetch_assoc();
        $medecin_nom = $row['nom_m'];
        $medecin_prenom = $row['prenom_m'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_patient = $_POST['email'];
    $date_rdv = $_POST['date_rdv'];
    $heure_rdv = $_POST['heure_rdv'];
    $description_rdv = $_POST['description_rdv']; // Nouveau champ pour la description
    $medecin_id = $_POST['medecin_id'];

    // Vérifier que l'heure du rendez-vous est entre 8h et 20h
    $heure_limite_inf = strtotime('08:00:00');
    $heure_limite_sup = strtotime('20:00:00');
    $heure_rdv_timestamp = strtotime($heure_rdv);
    
    if ($heure_rdv_timestamp < $heure_limite_inf || $heure_rdv_timestamp > $heure_limite_sup) {
        $error_message = "Les rendez-vous ne sont possibles qu'entre 8h et 20h.";
    } else {
        // Vérifier la disponibilité du médecin à l'heure spécifiée
        $sql_disponibilite = "SELECT idRendezvous FROM rendezvous WHERE idMedecin = $medecin_id AND date_rdv = '$date_rdv' AND heure_rdv = '$heure_rdv'";
        $result_disponibilite = $conn->query($sql_disponibilite);
        if ($result_disponibilite->num_rows > 0) {
            $error_message = "Le médecin n'est pas disponible à cette heure. Veuillez choisir une autre heure.";
        } else {
            // Insérer le rendez-vous dans la base de données
            $sql = "INSERT INTO rendezvous (idPatient, idMedecin, date_rdv, heure_rdv, description_rdv) VALUES ((SELECT idPatient FROM patient WHERE email_p = '$email_patient'), $medecin_id, '$date_rdv', '$heure_rdv', '$description_rdv')";

            if ($conn->query($sql) === TRUE) {
                $success_message = "Rendez-vous pris avec succès !";
            } else {
                $error_message = "Erreur : " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>

        <tbody>
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






