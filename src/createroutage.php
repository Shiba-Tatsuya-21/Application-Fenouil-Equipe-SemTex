<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Création de cibles de routage </title>
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
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
    -moz-appearance:textfield; /* Firefox */
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
         <h1 class="Anomalie-title">Création de cibles de routage : </h1>
         <label>Catégorie socio-professionnelle : </label>
            <select name="socio" size="1">
               <?php 
                require('db.php');
                  
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
         
         <label>Age compris entre : </label>
         
         <input type="number"  name="agedépart" min="18" max="120" value="18" >
         <label>et : </label>
         <input type="number"  name="agefin" min="18" max="120" value="120" >
        <label>Département de résidence : </label>
        <input type="number"  name="département" min="1" max="99" value="<?php echo $_POST['département'];?>" >
          <label>Statut : </label>
            <select name="commerciale" size="1">
               <?php 
                  $sql = "SELECT valeur_texte FROM `val_pre_param` WHERE champs='statut' AND valeur_texte NOT LIKE('Client interdit')";
                  //on récupère les statut client et prospect
                  $result = $con->query($sql);
                  
                    // output data of each row
                    while($option = $result->fetch_assoc()) {
                      
                  ?>
               <option><?php echo $option[valeur_texte] ?>
                  <?php 
                     }
                     ?>
            </select>
         
        
         <input class="pure-button pure-button-create" type="submit" value="Rechercher et Ajouter aux cibles" name="rechercher" class="article-button"/>
                   <input  class="pure-button pure-button-create" type="submit" value="Créer la publicité" name="pub" class="article-button"/>
         
      </form>
      <div class="tableFixHead"  style="height:600px" >
         <table border="3">
            <thead>
                <th>Identifiant</th>
               <th>Nom</th>
               <th>Prénom</th>
               <th>Age</th>
               <th>Socio-professionnelle</th>
               <th>Adresse</th>
               <th>Code postal</th>
               <th>Ville</th>
               <th>Téléphone</th>
               <th>Mail</th>
               <th>Statut</th>

            </thead>
            <tbody>
               <?php 
                 $id_client_route ="";
                   //requete sql permettant d'alimenter le tableau de tout les clients auf les client interdit
                   $sql = "SELECT * FROM `individu` WHERE  statut NOT LIKE('Client interdit')";
                    $departement = $_POST['département'];
                    if($departement<10){
                        $departement = "0".$departement;
                    }
                    $datedépart = "-01-01";
                    $datefin = "-01-01";
                    
                    //si on a cliquer sur le bouton du nom de Rechercher et Ajouter aux cibles on contruit la requete SQL en fonctions des critères choisi
                    if($_POST['rechercher']){
                        $annéedépart = date('Y') - $_POST['agedépart'];
                        $datedépart = $annéedépart.$datedépart;
                        $annéefin = date('Y') - $_POST['agefin'];
                        $datefin = $annéefin.$datefin;
                        
                        
                        $sql = $sql." AND `socio-professionnelle` = '".$_POST['socio']."' AND code_postal LIKE '".$departement."%' AND statut='". $_POST['commerciale']."' AND date_de_naissance BETWEEN '$datefin' AND '$datedépart'"; 
                        
                        
                        //echo $sql;
                        
                    }
                   
                  // echo $sql;
                  
                  
                  //if($_POST['rechercher']){
                   //echo $sql;
                   //on récupère le résultat de la requete de la base de données
                   $result = $con->query($sql);
                  //}
                   
                   //s'il y a des individu qui correspondent aux critères on les affiches  
                   if ($result->num_rows > 0) {
                     //pour chaque ligne faire 
                     while($rows = $result->fetch_assoc()) {
                   ?> 
               <tr>
                 <form class="form" method="post" name="" action=""> 
                <td align='center'><?php echo $rows["id_individu"] ?> </td>
                  <td align='center'><?php echo $rows["nom"] ?> </td>
                  <td align='center'> <?php echo $rows["prénom"] ?></td>
                  <td align='center'> <?php  
                   $now = new DateTime();
                   $datenow = $now->format('Y-m-d');
                   $datetime1 = new DateTime($datenow);
                  $datetime2 = new DateTime($rows["date_de_naissance"]);
                  $difference = $datetime1->diff($datetime2);
                  //calcul de l'age ci dessus et affichage ci dessous
                  //echo $difference->y;  
                  
                  
                  ?></td>
                  <td align='center'> <?php echo $rows["socio-professionnelle"] ?></td>
                  <td align='center'> <?php echo $rows["adresse"] ?></td>
                  <td align='center'> <?php echo substr($rows["code_postal"],0,2) ?></td>
                  <td align='center'> <?php echo $rows["ville"] ?></td>
                  <td align='center'> <?php echo $rows["téléphone"] ?></td>
                  <td align='center'> <?php echo $rows["mail"] ?></td>
                  <td align='center'> <?php echo $rows["statut"] ?></td>

</form>
               </tr>
               <?php  
                    //de plus quand on recherche et affiche les individu en fonction des critères on ajoutes ces individu a notre route
                    if($_POST['rechercher']){
                                $queryselectcible = "SELECT * FROM `cibleRoutage` ORDER BY id_cibleRoutage DESC LIMIT 1";
                        
                        
                         $resultat = $con->query($queryselectcible);
                         $cibles = $resultat->fetch_assoc();
                      
                        //On vérifie que on a pas déjà ajouter ces individus aux cibles de routage
                        if(strpos($cibles[id_individus],$rows["id_individu"])!==false){ 
                          echo "Ses individus sont déjà au sein de nos cibles pour cette route !!!";  
                       // echo "pas dedans";
                        
                            
                        }else{
                            //on update les individus dans la routes avec les nouveaux individu à ajouter
                            $query = "UPDATE `cibleRoutage` SET `id_individus`='".$cibles[id_individus].$rows["id_individu"] .";' ORDER BY id_cibleRoutage DESC LIMIT 1";
                        //echo $query;
                        $res = mysqli_query($con,$query) or die(mysql_error());
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
    <h3 style="color: red; font-weight: bold;">
      <?php
        //si on clique sur le bouton du nom de Créer la publicité
        if($_POST['pub']){
             $queryselectcible = "SELECT * FROM `cibleRoutage` ORDER BY id_cibleRoutage DESC LIMIT 1";
                        
                        
                         $resultat = $con->query($queryselectcible);
                         $cibles = $resultat->fetch_assoc();
            //On vérifie que on a au moins ajouter 1 individu dans la route et on redirige vers la page de création de la publicitié
            if($cibles[id_individus] != ""){
             echo "<script type='text/javascript'>window.top.location='createpub.php';</script>";
            }else{
                //s'il n'y a pas d'invidus dans la route on affiche 
                echo "Veuillez ajouter au moins 1 cible à la route !!!";
            }
      }?>
      </h3>
   </body>
</html>

