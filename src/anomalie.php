<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Anomalie Fenouil</title>
      <script src="script.js"></script> 
      <link rel="stylesheet" href="style.css"/>
      <style>
         body{
         margin: 0;
         padding: 0;
         background: url(images/tableau.png) no-repeat;
         background-size: cover;
         font-family: sans-serif;
         color: black;
         }
         .div{
         width: 700px;
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
      </style>
   </head>
   <body>
      <div id="mySidenav" class="sidenav">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <a href="logout.php">Déconnexion</a>
      </div>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;Menu</span>
      <form class="form" method="post" name="" action="">
         <h1 class="Anomalie-title">Recherche des Anomalies : </h1>
         <label>Identifiant du client : </label>
         <input type="text"  class="id-input"  name="idclient"  maxlength="10"  onkeypress="validate_integer(event)" />
         <label>Numéro de commande : </label>
         <input type="text"  class="id-input"  name="idcommande"  maxlength="10"  onkeypress="validate_integer(event)" />
         <label>Date de l'anomalie : </label>
         <input type="date" class="individu-input" name="dateanomalie"  />
         <input class="pure-button pure-button-create" type="submit" value="Rechercher" name="rechercher" class="article-button"/>
      </form>
      <div class="tableFixHead"  style="height:800px" >
         <table border="3">
            <thead>
               <th>Numéro client</th>
               <th>Numéro commande</th>
               <th>Date anomalie</th>
               <th>Anomalie 1</th>
               <th>Anomalie 2</th>
               <th>Statut</th>
               <th>Résolue</th>
               <th>Action</th>
            </thead>
            <tbody>
               <?php 
                  require('db.php');
                  
                   //requete sql permettant d'alimenter le tableau de toutes les anomalies
                   $sql = "SELECT * FROM `anomalie`";
                   //variable permettant de savoir s'il faut mettre where dans la sql
                   $putwhere=false;
                   $idclient = $_POST['idclient'];
                   $idcommande = $_POST['idcommande'];
                   $dateano = $_POST['dateanomalie'];
                   //date de aujourd'hui utile pour calculer le temps écoulé depuis la génération des anomalies
                   $now = new DateTime();
                   $datenow = $now->format('Y-m-d');
                   
                   //si on a cliquer sur le bouton bleu courrier
                   if($_POST['envoie']){
                       //on met que cette anomalie a été traité
                         $sqlupdate = "UPDATE `anomalie` SET `statut`= 1 WHERE  id_anomalie= ".$_POST['id_anomalie'];
                         //echo $sqlupdate;
                         
                         $resultupdate = $con->query($sqlupdate);
                         if(!$resultupdate)  {
                             echo "Erreur dans la mise a jour du statut !!!";  
                         }
                         //on récupère les informations du client en question
                       $sqlclient = "Select * from individu WHERE id_individu=".$_POST['idindividu']; 
                       //on récupère les informations de l'anomalie en question
                       $sqldeanoclient = "Select * from anomalie WHERE id_anomalie=".$_POST['id_anomalie']; 
                       
                       
                       $resultclient = $con->query($sqlclient);
                       $resultdeanoclient = $con->query($sqldeanoclient);
                       
                       $rowclient = $resultclient->fetch_assoc();
                       $rowdeanoclient = $resultdeanoclient->fetch_assoc();
                       
                       //s'il n'y a pas de 2ème anomalie lié a la même commande
                       if($rowdeanoclient[description2]==""){
                           $anomalie2="Pas de seconde anomalie";
                       }
                       //s'il y a une deuxième anomalie lié a la même commande
                       if($rowdeanoclient[description2]!=""){
                           $anomalie2=$rowdeanoclient[description2];
                       }
                       //variable des informations qui aliemente le fichier d'anomalie
                       $content = "Identifiant individu : ". $rowclient[id_individu]."\nNom : ". $rowclient[nom]."\nPrénom : ". $rowclient[prénom]."\nCode postal : ". $rowclient[code_postal]."\nVille : ". $rowclient[ville]."\nAdresse : ". $rowclient[adresse]."\nMail : ". $rowclient[mail]."\nAnomalie 1 : ". $rowdeanoclient[description]."\nAnomalie 2 : ". $anomalie2."\nDate anomalie : ". $rowdeanoclient[dateAnomalie];
                       
                       //variable pour l'affichage en web pour les testeurs
                       $contentforweb = "<br>     Contenu du fichier de l'anomalie :<br>Identifiant individu : ". $rowclient[id_individu]."<br>Nom : ". $rowclient[nom]."<br>Prénom : ". $rowclient[prénom]."<br>Code postal : ". $rowclient[code_postal]."<br>Ville : ". $rowclient[ville]."<br>Adresse : ". $rowclient[adresse]."<br>Mail : ". $rowclient[mail]."<br>Anomalie 1 : ". $rowdeanoclient[description]."<br>Anomalie 2 : ". $anomalie2."<br>Date anomalie : ". $rowdeanoclient[dateAnomalie]."<br>";
                       
                       echo $contentforweb;
                       
                       //création du fichier anomalie.txt s'il existe pas sinon on écrase son contenu avec la variable $content
                       file_put_contents('anomalie.txt', $content);
                  
                       //echo $sqlclient;
                       //echo $sqldeanoclient;
                  
                   }
                     //si un des input : Identifiant du client ou Numéro de commande ou Date de l'anomalie  est renseigner par l'utilisateur préparer la sql comme cela   
                   if($idclient!="" || $idcommande!="" || $dateano!=""){
                     
                     if($_POST['idclient']!="" ){
                         if($putwhere== false){
                            $sql = $sql. " WHERE "; 
                            $putwhere = true;
                         }
                          $sql = $sql. " id_client = $idclient AND";
                         
                     }  
                     if($_POST['idcommande']!="" ){
                         if($putwhere== false){
                            $sql = $sql. " WHERE "; 
                            $putwhere = true;
                         }
                          $sql = $sql. " id_commande = $idcommande AND";
                         
                     } 
                     
                      if($_POST['dateanomalie']!="" ){
                         if($putwhere== false){
                            $sql = $sql. " WHERE "; 
                            $putwhere = true;
                         }
                          $sql = $sql. " dateAnomalie = '$dateano' AND";
                         
                     }  
                     //on enlève les 3 dernier caractères qui est le "AND"
                     $sql = substr($sql ,0,strlen($sql)-3); 
                   }
                   
                   //echo $sql;
                  
                  
                  //if($_POST['rechercher']){
                   //echo $sql;
                   $result = $con->query($sql);
                  //}
                   
                   //s'il y a des anomalies qui correspondent a la requete $sql
                   if ($result->num_rows > 0) {
                     //pour chaque ligne faire 
                     while($row = $result->fetch_assoc()) {
                  
                  
                         
                         
                   ?> 
               <tr>
                  <form class="form" method="post" id="deleteupdate" name="deleteupdate" action="">
                     <td align='center'><?php echo $row["id_client"] ?> </td>
                     <td align='center'> <?php echo $row["id_commande"] ?></td>
                     <td align='center'><?php   $dateAno = date("d-m-Y", strtotime($row["dateAnomalie"]));  
                        echo $dateAno;  ?> </td>
                     <td align='center'><?php echo $row["description"] ?> </td>
                     <td align='center'><?php echo $row["description2"] ?> </td>
                     <td align='center'><?php if($row["statut"]==0){echo "Non traité";}if($row["statut"]==1){echo "Traité";} ?> </td>
                     <td align='center'><?php if($row["résolue"]==0){ echo "Non";}if($row["résolue"]==1){ echo "Oui";} ?> </td>
                     <td align='center'>
                        <input type="hidden" value="<?php echo $row["id_client"] ?>" name="idindividu" />
                        <input type="hidden" value="<?php echo $row["id_anomalie"] ?>" name="id_anomalie" />
                        <?php
                           //si le statut est a 0 = non traité on peut cliquer sur le bouton pour alimenter le fichier des anomalie
                           if($row["statut"]==0) {
                           ?>
                        <input class="pure-button pure-button-update" type="submit" value="Courrier" name="envoie"/>
                        <?php 
                           }
                           //si le statut est a 1 = traité on ne peut pas  cliquer sur le bouton pour alimenter le fichier des anomalie
                           if($row["statut"]==1) {
                           ?>
                        <input class="pure-button pure-button-update" type="submit" value="Courrier" name="envoie"
                           disabled/>
                        <?php
                           #rajouter disabled juste au dessus dans le input pour ne peut pas  cliquer sur le bouton pour alimenter le fichier des anomalie
                           }
                           
                           ?>
                     </td>
                  </form>
               </tr>
               <?php  
                  $datetime1 = new DateTime($datenow);
                  $datetime2 = new DateTime($row["dateAnomalie"]);
                  $difference = $datetime1->diff($datetime2);
                  //si cela fait 1 jour ou plus que les anomalie on été générer remplacer 1 par 30
                  if($difference->d>=30 && $row["résolue"]==0){
                      //echo "<br>Le client numéro : ".$row["id_client"]." est devenu client interdit car cela fait 30 jours qu'il n'a pas réglè son anomalie !!!<br>";
                      //faire passer les clients comme : Client interdit
                      $sqlupdate = "UPDATE `individu` SET `statut`= 'Client interdit' WHERE  id_individu=".$row["id_client"];
                          
                          //echo $sqlupdate;
                          
                          $resultupdate = $con->query($sqlupdate);
                          if(!$resultupdate)  {
                              echo "Erreur dans la mise à jour du statut du client en un Client interdit !!!";  
                          }
                  }
                          
                      }
                    } //else {
                    //echo "Votre base de données est vide !!!";
                   // }
                    //$con->close();
                    
                    
                    ?>  
            </tbody>
         </table>
      </div>
   </body>
</html>

