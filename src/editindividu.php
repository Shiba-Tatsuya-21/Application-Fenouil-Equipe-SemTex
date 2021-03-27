<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Modification d'individu</title>
      <link rel="stylesheet" href="style.css"/>
      <script src="script.js"></script> 
   </head>
   <style>
    
      
      form{
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
   <button class="pure-button pure-button-update"  onclick="location.href = 'referentielindividu.php';"  >Retour</button>
   <body height=100% width=100%>
      <?php
         require('db.php');
         
         //quand on arrive sur la page on récupère depuis l URL avec GET l'id de l'individu a mettre a jour
         if(isset($_GET['edit'])){
             $id = $_GET['edit'];
             $sql = "SELECT * FROM `individu` WHERE id_individu='$id'";
             $result = $con->query($sql);
             $row = $result->fetch_assoc();
              //on se sert de $row pour récupérer les informations de l'individu en question
                  
                  //si on clique sur le bouton modifier alors on update la l'individu 
             if(isset($_POST['updateclient'])){
                 $newnom = $_POST['newnom'];  
                 $newnom = mysqli_real_escape_string($con, $newnom);
                 $newprenom = $_POST['newprénom'];  
                 $newprenom = mysqli_real_escape_string($con, $newprenom);
                 $newdate = $_POST['newdate'];
                 $newsocio = $_POST['newsocio'];
                 $newadresse = $_POST['newadresse'];
                 $newadresse = mysqli_real_escape_string($con, $newadresse);
                 $newpostal = $_POST['newpostal'];
                 $newville = $_POST['newville'];
                 $newville = mysqli_real_escape_string($con, $newville);
                 $newtelephone = $_POST['newtéléphone'];
                 $newmail = $_POST['newmail'];
                 $commerciale = $_POST['newcommerciale'];
         
              $sql = "UPDATE `individu` SET nom='$newnom', prénom='$newprenom', date_de_naissance='$newdate', `socio-professionnelle`='$newsocio', adresse='$newadresse', code_postal='$newpostal', ville='$newville', téléphone='$newtelephone', mail='$newmail', statut='$commerciale' WHERE id_individu=$id";
              //echo $sql;
              $result = $con->query($sql);
              if($result === TRUE){
                  //echo "Successful Update!";  
                  echo "<script type='text/javascript'>window.top.location='referentielindividu.php';</script>";
             }else  {
               echo "Erreur dans la mise à jour de l'individu !!:";  
             }
              
             
         }
         }
         //https://www.w3schools.com/php/php_mysql_select.asp
         //https://www.w3schools.com/
         
         ?>
      <form class="form" method="post" name="update" action="">
         <h1 class="individu-title">Modifier client : </h1>
         <label>Identifiant du client: </label>
         <label name="id"><?php echo $row[id_individu]; ?></label>
         <div>
            </br>
            <label>Nom : </label>
            <input type="text" class="individu-input" name="newnom" required maxlength="30" size="35" value="<?php echo $row[nom]; ?>"/>
            <label>Prénom : </label>
            <input type="text" class="individu-input" name="newprénom"  maxlength="30" size="35" value="<?php echo $row[prénom]; ?>" required/>
            <label>Date de naissance : </label>
            <input type="date" class="individu-input" name="newdate" value="<?php echo $row[date_de_naissance]; ?>" min="1900-01-01" max="2003-01-01" required/>
             </br>
              </br>
            <label>Catégorie socio-professionnelle: </label>
            <select name="newsocio" size="1">
               <?php 
               //on récupère les catégorie socio professionnelle de la table val_pre_param
                  $sql = "SELECT valeur_texte FROM `val_pre_param` WHERE champs='csp'";
                  $result = $con->query($sql);
                  
                    // on aliment une liste de ses valeurs
                    while($option = $result->fetch_assoc()) {
                      if($option[valeur_texte] == $row['socio-professionnelle']){
                  ?>
               <option selected><?php echo $option[valeur_texte] ?>
                  <?php 
                     }else{
                     ?>
               <option><?php echo $option[valeur_texte] ?>
                  <?php 
                     }
                     }
                     ?>
            </select>
         </div>
         </br>
         <div>
            <label>Adresse :</label>
            <textarea rows="3" cols="30" maxlength="90" name="newadresse" rows="" onkeydown="return limitLines(this, event)" required><?php echo $row[adresse]; ?> </textarea>
            <label>Code postal : </label>
            <input type="text"  class="article-input" name="newpostal" maxlength="5" minlength="5" onkeypress="validate_integer(event)" value="<?php echo $row[code_postal]; ?>"required/>
            <label>Ville : </label>
            <input type="text" class="individu-input" name="newville"  maxlength="30" size="35" value="<?php echo $row[ville]; ?>"required/>
         </div>
         </br>
         <div>
            <label>Numéro de téléphone : </label>
            <input type="text" class="individu-input" name="newtéléphone"  maxlength="10" minlength="10" onkeypress="validate_integer(event)" value="<?php echo $row[téléphone]; ?>" required/>
            <label>Adresse mail (facultative) : </label>
            <input name="newmail" lass="individu-input" type="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  size="60" maxlength="50"value="<?php echo $row[mail]; ?>">
            </br>
              </br>
            <label>Caractéristique commerciale : </label>
            <select name="newcommerciale" size="1" value="<?php echo $row[statut]; ?>">
               <?php 
                  $sql = "SELECT valeur_texte FROM `val_pre_param` WHERE champs='statut'";
                  $result = $con->query($sql);
                  
                    // output data of each row
                    while($option = $result->fetch_assoc()) {
                      if($option[valeur_texte] == $row[statut]){
                  ?>
               <option selected><?php echo $option[valeur_texte] ?>
                  <?php 
                     }else{
                     ?>
               <option><?php echo $option[valeur_texte] ?>
                  <?php 
                     }
                     }
                     ?>
            </select>
         </div>
         </br>
         <input type="submit" value="Modifier" name="updateclient" class="pure-button pure-button-create"/>
      </form>
      </form>
   </body>
</html>

