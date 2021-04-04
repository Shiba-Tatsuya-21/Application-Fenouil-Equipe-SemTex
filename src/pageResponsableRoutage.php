<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Responsable envoi des publicités</title>
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
         <a href="logout.php">Déconnexion</a>
      </div>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;Menu</span>
      <h1 align="center">Bienvenue sur la page de l'envoi des publicités :</h1>
      
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
                <h3 style="color: red; font-weight: bold;">
               <?php 
                  require('db.php');
                    //si on clique sur un des boutons Envoyer
                   if($_POST['envoie']){
                        //On vérifie que la la route a été valider par le directeur de la stratégie
                         if($_POST['validation'] == 1){
                             //on met a jour la colonne envoyer de la base en mettant vrai
                         $sqlupdate = "UPDATE `cibleRoutage` SET `envoyer`= 1 WHERE  id_cibleRoutage= ".$_POST['idcible'];
                         //echo $sqlupdate;
                         
                         $resultupdate = $con->query($sqlupdate);
                         if(!$resultupdate)  {
                             echo "Erreur dans la mise à jour de l'envoi de la route !!!";  
                         }
                         
                         //On récupère toutes les données de la route que on a choisi d'envoyer 
                        $titre = $_POST['titre'];
                        $titre = mysqli_real_escape_string($con, $titre);
                        $description =  $_POST['description'];
                        $description = mysqli_real_escape_string($con, $description);
                        $articles =  $_POST['nomarticles'];//echo $articles;
                        $articles = mysqli_real_escape_string($con, $articles);
                        
                        $cibles =  $_POST['id_individus'];//echo $cibles;
                        $cibles = mysqli_real_escape_string($con, $cibles);
                        $catalogue= $_POST['catalogue'];
                        
                       
                        $numindividu = array();

                            $tmp;
                            for ($i = 0; $i <strlen($cibles); $i++) {
                                if($cibles[$i]==";"){
                                    array_push($numindividu, $tmp);
                                    $tmp="";
                                }else{
                                    $tmp = $tmp.$cibles[$i];
                                }
                                
                        
                              }   
                            
                              $id = array();    
                              $nom = array();
                              $prenom = array();
                              $adresse = array();
                              $mail = array();
                              for($i = 0; $i <sizeof($numindividu); $i++){
                                $sqlindividu = "SELECT * FROM `individu`WHERE id_individu='".$numindividu[$i]."'";
                                $resultatindividu = $con->query($sqlindividu);
                                $rowindividu = $resultatindividu->fetch_assoc();
                                array_push($id, $rowindividu[id_individu]); 
                                array_push($nom, $rowindividu[nom]); 
                                array_push($prenom, $rowindividu[prénom]); 
                                array_push($adresse, $rowindividu[adresse].$rowindividu[ville].$rowindividu[code-postal]); 
                                array_push($mail, $rowindividu[mail]); 
                                  
                                 
                              }
                        
                        
                        $dataindividu = "";
                       /*     
                        for($i = 0; $i <sizeof($numindividu); $i++){
                            $dataindividu = $dataindividu."Id : " .$id[$i]." Nom : " .$nom[$i]." Prénom : " .$prenom[$i]." Adresse : " .$adresse[$i]." Mail : " .$mail[$i]. " / ";
                         }
                        */
                        
                        //On génére le fichier XML qui contient le titre, désignation, noms des articles et les Id noms prénom adresse mail des individus de la publicité 
                        $doc = new DOMDocument('1.0', 'UTF-8');
                        $doc->formatOutput = true;
                        
                        $root = $doc->createElement('Pub');
                        $root = $doc->appendChild($root);
                     
                        $ele1 = $doc->createElement('Titre');
                        $ele1->nodeValue=$titre;
                        $root->appendChild($ele1);
              
                        $ele2 = $doc->createElement('Désignation');
                        $ele2->nodeValue=$description;
                        $root->appendChild($ele2);
                        
                        $ele3 = $doc->createElement('Articles');
                        $ele3->nodeValue=$articles;
                        $root->appendChild($ele3);

                        
                        $ele4 = $doc->createElement('Individus');
                        //$ele4->nodeValue=$dataindividu;
                        $root->appendChild($ele4);
                        
                        for($i = 0; $i <sizeof($numindividu); $i++){
                            $unindividu = $doc->createElement('Id');
                            $unindividu->nodeValue=$id[$i];
                            $ele4->appendChild($unindividu);
                            $unnom = $doc->createElement('Nom');
                            $unnom->nodeValue=$nom[$i];
                            $unindividu->appendChild($unnom);
                            $unprenom = $doc->createElement('Prénom');
                            $unprenom->nodeValue=$prenom[$i];
                            $unindividu->appendChild($unprenom);
                            $uneadresse = $doc->createElement('Adresse');
                            $uneadresse->nodeValue=$adresse[$i];
                            $unindividu->appendChild($uneadresse);
                            $unmail = $doc->createElement('Mail');
                            $unmail->nodeValue=$mail[$i];
                            $unindividu->appendChild($unmail);
                         }
                        
                        
                        
                        $ele5 = $doc->createElement('Catalogue');
                        $ele5->nodeValue=$catalogue;
                        $root->appendChild($ele5);
                        
                        $doc->save('pub.xml');
                                                 
                         
                         echo "Le fichier XML à été généré avec succès";
                         
                         
                         }else{
                             echo "Vous ne pouvez pas générer et envoyer la publicité tant que  la route n'a pas été validée par le directeur de la stratégie !!!";
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
                  
                            //Tableau des numéros d'articles
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
                            //Tableau des noms d'articles
                              $designations = array();
                              for($i = 0; $i <sizeof($numarticle); $i++){
                                $sqlarticle = "SELECT * FROM `article`WHERE numerounique='".$numarticle[$i]."'";
                                $resultatarticle = $con->query($sqlarticle);
                                $designation = $resultatarticle->fetch_assoc();
                                array_push($designations, $designation[designation]); 
                                  
                                  
                                 
                              }
                         
                   ?> </h3>
               <tr>
                  <form class="form" method="post" id="deleteupdate" name="deleteupdate" action="">
                     <td align='center'><?php echo $row["id_cibleRoutage"] ?> </td>
                     <td align='center'><?php echo $row["titre"] ?> </td>
<td align='left'><?php echo $row["description"] ?> </td>
<td align='left'><?php 
            //on affiche les noms des articles  
            $nomarticles = "";
             for($i = 0; $i <sizeof($designations); $i++){
                $nomarticles= $nomarticles.$designations[$i]." / ";
            }
            echo $nomarticles;
         ?> </td>
<td align='center'><?php echo $row["catalogue"] ?> </td>
<td align='center'><?php if($row["valider"]== 0){echo "Non";}else{echo "Oui";}?> </td>
          <td align='center'><?php if($row["envoyer"]== 0){echo "Non";}else{echo "Oui";}?> </td>
          
          <td align='center'>
                        <input type="hidden" value="<?php echo $row["id_cibleRoutage"]; ?>" name="idcible" />
                        <input type="hidden" value="<?php echo $row["titre"]; ?>" name="titre" />
                        <input type="hidden" value="<?php echo $row["description"]; ?>" name="description" />
                         <input type="hidden" value="<?php echo $row["id_individus"];?>" name="id_individus" />
                        <input type="hidden" value="<?php echo  $nomarticles;?>" name="nomarticles" />
                        <input type="hidden" value="<?php echo $row["catalogue"]; ?>" name="catalogue" />
                        
                        <input type="hidden" value="<?php echo $row["valider"] ?>" name="validation" />
                        <?php
                           //si la colonne Envoyer est a 0 = non  on peut cliquer sur le bouton pour Envoyer la publicité
                           if($row["envoyer"]==0) {
                           ?>
                        <input class="pure-button pure-button-update" type="submit" value="Envoyer" name="envoie"/>
                        <?php 
                           }
                           //si la colonne Envoyer est a 1 = oui  on ne peutpas  cliquer sur le bouton pour Envoyer la publicité
                           if($row["envoyer"]==1) {
                           ?>
                        <input class="pure-button pure-button-update" type="submit" value="Envoyer" name="envoie"
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