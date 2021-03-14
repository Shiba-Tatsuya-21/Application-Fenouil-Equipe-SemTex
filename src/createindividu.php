

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Création client</title>
      <link rel="stylesheet" href="style.css"/>
      <script src="script.js"></script> 
   </head>
<form class="form" method="post" name="individu" action="" >
      <button class="pure-button pure-button-update"  name="retour">Retour</button>
</form>
   <style>
    
      
      .formulaire{
    width: 1100px;
    height: 400px;
    background: #292A2B ;
    /*opacity: 1;*/
    color: #fff;
    top: 45%;
    left: 45%;
    position: absolute;
    transform: translate(-30%,-50%);
    box-sizing: border-box;
    padding:10px 10px;
}

      body{
      margin: 0;
      padding: 0;
      background: url(images/client.jpg) no-repeat;
      background-size: cover;
      font-family: sans-serif;
  
      }
      </style>
   <body height=100% width=100%>
      <?php
         require('db.php');
         
         if(isset($_POST['retour'])) {
         
              if($_GET['commande']==1){
                    echo "<script type='text/javascript'>window.top.location='infoclientcommande.php';</script>";
                     
                 }else{
                    echo "<script type='text/javascript'>window.top.location='referentielindividu.php';</script>";
                  }
             
         }
         
         //si on clique sur le bouton ajouter 
         if(isset($_POST['ajout'])) {
            $nom = $_POST['nom'];  
            $nom = mysqli_real_escape_string($con, $nom);
            $prenom = $_POST['prénom'];
            $prenom = mysqli_real_escape_string($con, $prenom);
            $date = $_POST['date'];
            $socio = $_POST['socio'];
            $adresse = $_POST['adresse'];
            $adresse = mysqli_real_escape_string($con, $adresse);
            $postal = $_POST['postal'];
            $ville = $_POST['ville'];
            $ville = mysqli_real_escape_string($con, $ville);
            $telephone = $_POST['téléphone'];
            $mail = $_POST['mail'];
            $mail = mysqli_real_escape_string($con, $mail);
            //if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
              //  $mail = "";echo "mail invalide";
            //}
            $commerciale = $_POST['commerciale'];
            
            // on insert dans la table individu le nouveau client
            $query = "INSERT INTO `individu`(`nom`,`prénom`,`date_de_naissance`,`socio-professionnelle`,`adresse`,`code_postal`,`ville`,`téléphone`,`mail`,statut) VALUES('$nom','$prenom','$date','$socio','$adresse','$postal','$ville','$telephone','$mail','$commerciale')";
            
            $result = mysqli_query($con,$query) or die(mysql_error());
             //si l'insertion réussi 
             if($result){
                 //Si on viens de la page des commandes on t'y renvoie
                 if($_GET['commande']==1){
                    echo "<script type='text/javascript'>window.top.location='commande.php';</script>";
                     
                 }else{//on redirige vers la page qui liste les individu
                    echo "<script type='text/javascript'>window.top.location='referentielindividu.php';</script>";
                  }
               
             }else{
               echo "Insertion échouée";  
             }
            
            //echo "nom : " . $nom ." prénom : " . $prénom ." date : " . $date ." socio : " . $socio ." adresse : " . $adresse ." postal : " . $postal ." ville : " . $ville ." téléphone : " . $téléphone ." mail : " . $mail ." commerciale : " . $commerciale;
         }
         
            $sqlid = "SELECT id_individu FROM `individu` ORDER BY id_individu DESC LIMIT 1";
            $resultid = $con->query($sqlid);
            $row = $resultid->fetch_assoc()
            
         ?>
      <form class="formulaire" method="post" name="individu" action="" >
         <h1 class="individu-title" align="center">Création d'un client : </h1>
         <div >
            <label>Identifiant unique : </label>
            <input type="text" class="individu-input" value ="<?php echo $row[id_individu]+1;?>"name="id" readonly/>    
            <label>Nom : </label>
            <input type="text" class="individu-input" name="nom" required maxlength="30" size="35" />
            <label>Prénom : </label>
            <input type="text" class="individu-input" name="prénom"  maxlength="30" size="35" required/>
            </br></br>
            <label>Date de naissance : </label>
            <input type="date" class="individu-input" name="date" required/>
            <label>Catégorie socio-professionnelle: </label>
            <select name="socio" size="1">
               <?php 
                  //on récupère les catégorie socio professionnelle de la table val_pre_param
                     $sql = "SELECT valeur_texte FROM `val_pre_param` WHERE champs='csp'";
                     $result = $con->query($sql);
                     
                       // on aliment une liste de ses valeurs
                       while($option = $result->fetch_assoc()) {
                   ?>
               <option><?php echo $option[valeur_texte] ?>
                  <?php 
                     }
                     ?>
            </select>
         </div>
         </br>
         <div>
            <label>Adresse :</label>
            <textarea  rows="3" cols="30" maxlength="90"  name="adresse" rows=""  style="overflow:auto;resize:none"required></textarea>
            <label>Code postal : </label>
            <input type="text"  class="article-input" name="postal" maxlength="5" minlength="5" onkeypress="validate_integer(event)" required/>
            <label>Ville : </label>
            <input type="text" class="individu-input" name="ville"  maxlength="30" size="35" required/>
         </div>
         </br>
         <div>
            <label>Numéro de téléphone : </label>
            <input type="text" class="individu-input" name="téléphone"  maxlength="10" minlength="10" onkeypress="validate_integer(event)" required/>
            <label>Adresse mail (facultative) : </label>
            <input name="mail" class="individu-input" type="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"   size="60" maxlength="50">
             </br></br>
            <label>Caractéristique commerciale : </label>
            <select name="commerciale" size="1">
               <?php 
                  $sql = "SELECT valeur_texte FROM `val_pre_param` WHERE champs='statut'";
                  $result = $con->query($sql);
                  
                    // output data of each row
                    while($option = $result->fetch_assoc()) {
                      
                  ?>
               <option><?php echo $option[valeur_texte] ?>
                  <?php 
                     }
                     ?>
            </select>
         </div>
         </br>
         <input class="pure-button pure-button-create" type="submit" value="AJOUTER" name="ajout" class="article-button"/>
      </form>
   </body>
</html>

