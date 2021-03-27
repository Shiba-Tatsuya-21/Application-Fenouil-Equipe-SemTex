<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>CommandeFenouil</title>
      <script src="script.js"></script> 
      <link rel="stylesheet" href="style.css"/>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
         //scripte permettant de calculer automatique le montant en multipliant le prix unitaire de l'article par la quantité
         $(document).ready(function(){
           $("#qtte").change(function(){
               var res= document.getElementById("qtte").value * document.getElementById("prix").value;
               document.getElementById("montant").value  = res.toFixed(2);
               
           });
         });
      </script>
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
   </head>
   <body>
      <div>
         <?php   
            require('db.php');
            //si on clique sur le bouton rechercher pour récupérer la désignation et le prix de l'article en fonction de son identifian unique
             if(isset($_POST['rechercherarticle'])){
                     $idart= $_POST['identifiantarticle'];
                     $sqlart = "SELECT * FROM `article` WHERE numerounique=$idart";//echo $sqlart;
                     $resultart = $con->query($sqlart);
                     $rowart = $resultart->fetch_assoc();
                 
                 
                 
                 }
                 
            //si on clique sur un des boutons supprimer dans le tableau           
            if(isset($_POST['delete'])){
            $id = $_POST['keydelete'];//on récupère l'id de la ligne que on veut supprimer du champ cacher
            
            $query = "DELETE FROM `ligneCommande` WHERE id_ligne='$id'";
            $result = mysqli_query($con,$query) or die(mysql_error());
            
            /*if($result){
                echo "Suppression réussie!";  
            }*/
            
            if(!$result)  {
             echo "Suppression échouée";  
            }
            }
            
            ?>
         <form class="form" method="post" name="" action="">
            <h1 class="article-title">Modifier commande : </h1>
            <h3 style="color: red; font-weight: bold;"><?php   if($rowart=="" && isset($_POST['rechercherarticle'])){
               echo "Identifiant de l'article inconnu !!";
               }?> </h3>
            <label>Identifiant de l'article : </label>
            <input type="text"  class="id-input"  name="identifiantarticle"  maxlength="10"  onkeypress="validate_integer(event)" value="<?php echo  $_POST['identifiantarticle']?>" required/>
            <input class="pure-button pure-button-update" type="submit" value="RECHERCHER" name="rechercherarticle" class="article-button"/>
            <input type="text"  name="Désignation" placeholder="Désignation" value="<?php echo $rowart['designation'];?>"readonly/>
            <input type="text"  name="prixunitaire" placeholder="prix unitaire du produit" value="<?php echo $rowart['prix'];?>"readonly id="prix"/>
            <input type="number"  name="quantité" min="1" max="100" value="1" id="qtte">
            <input type="text"  placeholder="Montant"  nom="montant" id="montant"  value="<?php echo $rowart['prix'];?>" onkeypress="validate_decimal(event)" pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,2}))?)" step=".01"readonly/>
            <input class="pure-button pure-button-create" type="submit" value="Ajouter" name="ajout" class="article-button"/>
         </form>
         <?php
            //On récupère l'id de la commande qui a été créer juste a l'écran d'avant ui est donc la dernière ligne dans la table commande
            $sqlidcmd = "SELECT id_commande FROM `commande` ORDER BY id_commande DESC LIMIT 1";
                        $resultid = $con->query($sqlidcmd);
                          $rowid = $resultid->fetch_assoc();
               //si on clique sur le bouton ajouter et que les champs désignation et prixunitaire ne sont pas vide = id a été rechercher et trouver dans la table article
               if($_POST['ajout'] && $_POST['Désignation'] != "" && $_POST['prixunitaire'] != ""){
                       
                          
                          $numerounique = $_POST['identifiantarticle'];
                          $nomarticle = $_POST['Désignation'];
                          $nomarticle = mysqli_real_escape_string($con, $nomarticle);
                          $prixunitaire = $_POST['prixunitaire'];
                          $quantite = $_POST['quantité'];
                          $montant = $_POST['prixunitaire'] * $_POST['quantité'];
                          
                          $query = "INSERT INTO `ligneCommande`(`id_commande`, `numerounique`, `nomarticle`, `prixarticle`, `quantité`, `Montantligne`) VALUES ('$_GET[commande]','$numerounique', '$nomarticle','$prixunitaire', '$quantite','$montant' )";
                          //echo $query;
                          
                           $result = mysqli_query($con,$query) or die(mysql_error());
                   
                   //si l'insertion réussi on redirige vers la page qui liste les articles
                   if($result){
                      //echo "Insertion réussie";  
                      
               
                   }else{
                     echo "Insertion échouée";  
                   }
                   
                  
               }
               
               //on calcule la somme du prix de la commande 
                   $queryTotal = "Select SUM(Montantligne) AS TOTAL FROM ligneCommande WHERE id_commande = '$_GET[commande]'";
                          //echo $query;
                          
                   $resultTotal = mysqli_query($con,$queryTotal) or die(mysql_error());
                   
                   $rowTotal = $resultTotal->fetch_assoc();
                   
                   //on update le prix du montant de la commande   dans la table commande 
                    $sqlupdate = "UPDATE `commande` SET MontantCommande='$rowTotal[TOTAL]' WHERE id_commande=$_GET[commande]";
                       //echo $sqlupdate;
                 
             
            
              $result = $con->query($sqlupdate);
              if($result === TRUE){
                   //echo "Update réussi";
               }else{
                 // echo "Update rater!"; 
               }
                     
                   
                   
               ?>
         </br>
         <div class="tableFixHead"  style="height:600px" >
            <table border="3">
               <thead>
                  <th>Numéro de commande</th>
                  <th>Numéro d'article</th>
                  <th>Nom de l'article</th>
                  <th>Prix unitaire</th>
                  <th>Quantité</th>
                  <th>Montant</th>
                  <th>Action</th>
               </thead>
               <tbody>
                  <?php 
                     //requete sql permettant d'aliment le tableau des lignes de la commande 
                     $sql = "SELECT * FROM `ligneCommande` Where id_commande ='$_GET[commande]'";
                     //echo $sql;
                     $result = $con->query($sql);
                     
                     if ($result->num_rows > 0) {
                       // output data of each row
                       while($row = $result->fetch_assoc()) {
                           
                     ?> 
                  <tr>
                     <form class="form" method="post" id="deleteupdate" name="deleteupdate" action="">
                        <td align='center'><?php echo $row["id_commande"] ?> </td>
                        <td align='center'><?php echo $row["numerounique"] ?> </td>
                        <td align='center'><?php echo $row["nomarticle"] ?> </td>
                        <td align='center'> <?php echo $row["prixarticle"] ?></td>
                        <td align='center'><?php echo $row["quantité"] ?> </td>
                        <td align='center'><?php echo $row["Montantligne"] ?> </td>
                        <td align='center'>
                           <input type="hidden" value="<?php echo $row["id_ligne"] ?>" name="keydelete" required/>
                           <input class="pure-button pure-button-delete" type="submit" value="SUPPRIMER" name="delete"/>
                        </td>
                     </form>
                  </tr>
                  <?php  
                     }
                     } 
                     //$con->close();
                     
                     
                     ?>  
               </tbody>
            </table>
         </div>
         </br>
         <label>Montant Total de la commande : </label>
         <input type="text"  name="Total" placeholder="" value="<?php echo $rowTotal[TOTAL];?>"readonly/>
         <form class="form" method="post" action="">
            <input class="pure-button pure-button-create" type="submit" value="Payer" name="payer" class="article-button"/>
         </form>
         <h2 style="color: red; font-weight: bold;">
            <?php 
               //si on clique sur payer et que le total est différents de vide
               if($_POST['payer'] && $rowTotal[TOTAL]!=""){
                   echo "<script type='text/javascript'>window.top.location='editreglementcommande.php?commande=$_GET[commande]';</script>";
               }
               //si on clique sur payer et que on rien commander = tableau vide
               if($_POST['payer'] && $rowTotal[TOTAL]==""){
                       echo "Commande non valide";
                   }
               
               ?>
         </h2>
      </div>
   </body>
</html>

