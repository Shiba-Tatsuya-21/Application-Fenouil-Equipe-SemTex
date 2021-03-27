<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Référentiel client</title>
      <link rel="stylesheet" href="style.css"/>
      <script src="script.js"></script> 
   </head>
   <style>
      .sidenav {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #111;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 60px;
      }
      .sidenav a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 25px;
      color: #818181;
      display: block;
      transition: 0.3s;
      }
      .sidenav a:hover {
      color: #f1f1f1;
      }
      .sidenav .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
      }
      @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
      .sidenav a {font-size: 18px;}
      }
   </style>
      <style>
          body{

      margin: 0;
      padding: 0;
      background: url(images/tableau.png) no-repeat;
      background-size: cover;
      font-family: sans-serif;
      color: black;
      }
      </style>
   
   <body>
      <div id="mySidenav" class="sidenav">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <a href="referentielarticle.php">Référentiel Article</a>
         <a href="referentielindividu.php">Référentiel Client</a>
         <a href="logout.php">Déconnexion</a>
      </div>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;Menu</span>
      <h1 align="center">Bienvenue sur la page des clients :</h1>
       <h3 style="color: red; font-weight: bold;">
      <?php
         require('db.php');
         //Si on clique sur le bouton de créer un nouveau client
          if(isset($_POST['create'])){
              echo "<script type='text/javascript'>window.top.location='createindividu.php';</script>";
          }
         
         //si on clique sur un des boutons supprimer 
         if(isset($_POST['clientdelete'])){
              $id = $_POST['keyclientdelete'];//on récupère l'id de la ligne que on veut supprimer du champ cacher
              $sqlcom = "SELECT * FROM `commande` WHERE id_client=$id"; 
              $resultcom = $con->query($sqlcom);
              if ($resultcom->num_rows > 0) { echo "Cet individu a passé au moins une commande. Suppression impossible !";}
            
            if($resultcom->num_rows == 0){
                //echo "on a supprimer";
                 $query = "DELETE FROM `individu` WHERE id_individu='$id'";
             $result = mysqli_query($con,$query) or die(mysql_error());
             //if($result){
             //     echo "Suppression réussie!";  
             //}
         
             if(!$result)  {
               echo "Suppression échouée";  
             }
            }
             
            
             
         }
         ?></h3>
      <div align="center">
         <form class="form" method="post" name="individu" action="" >
            <input class="pure-button pure-button-create" type="submit" value="Créer Nouveau Client" name="create" class="article-button"/>
         </form>
      </div>
      </br>
      <div class="tableFixHead" style="height:600px" >
         <table border="3" >
            <thead>
               <th>Identifiant</th>
               <th>Nom</th>
               <th>Prénom</th>
               <th>Date de naissance</th>
               <th>Socio-professionnelle</th>
               <th>Adresse</th>
               <th>Code postal</th>
               <th>Ville</th>
               <th>Téléphone</th>
               <th>Mail</th>
               <th>Statut</th>
               <th>Action</th>
            </thead>
            <?php 
               $sql2 = "SELECT * FROM `individu`";
               $result2 = $con->query($sql2);
               
               if ($result2->num_rows > 0) {
                 // output data of each row
                 while($rows = $result2->fetch_assoc()) {
                     
               ?> 
            <tr>
               <form class="form" method="post" name="deleteupdate" action="">
                  <td align='center'><?php echo $rows["id_individu"] ?> </td>
                  <td align='center'><?php echo $rows["nom"] ?> </td>
                  <td align='center'> <?php echo $rows["prénom"] ?></td>
                  <td align='center'> <?php  
                   $newDate = date("d-m-Y", strtotime($rows["date_de_naissance"]));  
    echo $newDate;  
                  
                  
                  ?></td>
                  <td align='center'> <?php echo $rows["socio-professionnelle"] ?></td>
                  <td align='center'> <?php echo $rows["adresse"] ?></td>
                  <td align='center'> <?php echo $rows["code_postal"] ?></td>
                  <td align='center'> <?php echo $rows["ville"] ?></td>
                  <td align='center'> <?php echo $rows["téléphone"] ?></td>
                  <td align='center'> <?php echo $rows["mail"] ?></td>
                  <td align='center'> <?php echo $rows["statut"] ?></td>
                  <td align='center'>
                     <a class="pure-button pure-button-update" href="editindividu.php?edit=<?php echo $rows["id_individu"] ?>">MODIFIER</a>
                     <input type="hidden" value="<?php echo $rows["id_individu"] ?>" name="keyclientdelete" required/>
                     <input class="pure-button pure-button-delete" type="submit" value="SUPPRIMER" name="clientdelete"/>
                  </td>
               </form>
            </tr>
            <?php  
               }
               } //else {
               //echo "Votre base de données est vide !!!";
               //}
               //$con->close();
               
               
               ?>  
         </table>
      </div>
   </body>
</html>

