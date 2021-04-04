<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Direction</title>
      <link rel="stylesheet" href="style.css"/>
      <script src="script.js"></script> 
   </head>
   <style>
      body{
      margin: 0;
      padding: 0;
      background: url(images/tableau.png) no-repeat;
      background-size: cover;
      font-family: sans-serif;
      color: black;
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
      }
   </style>
   <body>
      <div id="mySidenav" class="sidenav">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <a href="gestionreferentiel.php"> Administration du référentiel</a>
         <a href="pub.php"> Création de cible de routage</a>
         <a href="anomalie.php"> Gestion des anomalies</a>
         <a href="infoclientcommande.php"> Saisie des commandes</a>
         <a href="logout.php">Déconnexion</a>
      </div>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;Menu</span>
      <h1 align="center">Bienvenue sur la page du directeur de la stratégie : </h1>
      
<div class="tableFixHead"  style="height:600px" >
         <table border="3">
            <thead>
               <th>Numéro</th>
               <th>Titre</th>
               <th>Description</th>
               <th>Articles</th>
               <th>Catalogue</th>
               <th>Validation</th>
               <th>Envoyé</th>
               <th>Action</th>
            </thead>
            <tbody>
               <?php 
                  require('db.php');
                  
                  //s'il on clique sur un des boutons valider
                   if($_POST['envoie']){
                       //on met que cette route comme ayant été validé par le directeur de la stratégie
                         $sqlupdate = "UPDATE `cibleRoutage` SET `valider`= 1 WHERE  id_cibleRoutage= ".$_POST['idcible'];
                         //echo $sqlupdate;
                         
                         $resultupdate = $con->query($sqlupdate);
                         if(!$resultupdate)  {
                             echo "Erreur dans la mise à jour de la validation de la route !!!";  
                         }
                         
                   }
                  
                  
                  
                   //requete sql permettant d'alimenter le tableau de toutes les cibles de routage
                   $sql = "SELECT * FROM `cibleRoutage`";
                   //echo $sql;

                   $result = $con->query($sql);
                   //s'il y a des cibles de routage qui correspondent a la requete $sql
                   if ($result->num_rows > 0) {
                     //pour chaque ligne faire 
                     while($row = $result->fetch_assoc()) {
                  
                            //Tableau des numéros des articles
                            $numarticle = array();

                            $tmp;
                            for ($i = 0; $i <strlen($row["id_articles"]); $i++) {
                                if($row["id_articles"][$i]==";"){
                                    array_push($numarticle, $tmp);
                                    $tmp="";
                                }else{
                                    $tmp = $tmp.$row["id_articles"][$i];
                                }
                                
                        
                              }   
                            //Tableau des noms des articles
                              $designations = array();
                              for($i = 0; $i <sizeof($numarticle); $i++){
                                $sqlarticle = "SELECT * FROM `article`WHERE numerounique='".$numarticle[$i]."'";
                                $resultatarticle = $con->query($sqlarticle);
                                $designation = $resultatarticle->fetch_assoc();
                                array_push($designations, $designation[designation]); 
                                  
                                  
                                 
                              } 
                         
                   ?> 
               <tr>
                  <form class="form" method="post" id="deleteupdate" name="deleteupdate" action="">
                     <td align='center'><?php echo $row["id_cibleRoutage"] ?> </td>
                     <td align='center'><?php echo $row["titre"] ?> </td>
<td align='left'><?php echo $row["description"] ?> </td>
<td align='left'><?php 
             for($i = 0; $i <sizeof($designations); $i++){
                echo $designations[$i]." / ";
            }
         ?> </td>
<td align='center'><?php echo $row["catalogue"] ?> </td>
<td align='center'><?php if($row["valider"]== 0){echo "Non";}else{echo "Oui";}?> </td>
          <td align='center'><?php if($row["envoyer"]== 0){echo "Non";}else{echo "Oui";}?> </td>
          
          <td align='center'>
                        <input type="hidden" value="<?php echo $row["id_cibleRoutage"] ?>" name="idcible" />
                        
                        <?php
                           //si la validation est a 0 = non on peut cliquer sur le bouton valider 
                           if($row["valider"]==0) {
                           ?>
                        <input class="pure-button pure-button-update" type="submit" value="Valider" name="envoie"/>
                        <?php 
                           }
                           //si la validation est a 1 = oui on ne peut pas  cliquer sur le bouton valider car la route a déjà été valider
                           if($row["valider"]==1) {
                           ?>
                        <input class="pure-button pure-button-update" type="submit" value="Valider" name="envoie"
                           disabled/>
                        <?php
                           }
                           ?>
                     </td>
                  </form>
               </tr>
               <?php  
                      }
                    } else {
                    echo "Votre base de données des routes est vide !!!";
                    }
                    $con->close();
                    
                    
                    ?>  
            </tbody>
         </table>
      </div>
      
   </body>
</html>