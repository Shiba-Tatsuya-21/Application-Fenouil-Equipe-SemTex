<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Publicité Fenouil</title>
    <script src="script.js"></script> 
      <link rel="stylesheet" href="style.css"/>
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
      

<body>
      <div id="mySidenav" class="sidenav">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <a href="logout.php">Déconnexion</a>
      </div>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;Menu</span>
    
    
<h1  align="center">Bienvenue sur la page des publicités</h1>

<div align="center">
         <form class="form" method="post" name="route" action="" >
            <input  class="pure-button pure-button-create" type="submit" value="Créer une nouvelle route" name="create" class="article-button"/><br><br>
            </form>
</div>
 <h3 style="color: red; font-weight: bold;">
<?php
require('db.php');
//si on clique sur le bouton créer un nouvelle routes on la créer et on redirige vers la page pour alimenter les individus cibles de la route
         if(isset($_POST['create'])){
              $query = "INSERT INTO `cibleRoutage`() VALUES ()";
             $result = mysqli_query($con,$query) or die(mysql_error());
             
           echo "<script type='text/javascript'>window.top.location='createroutage.php';</script>";
         }
         //si on clique sur un des boutons supprimer 
         if($_POST['supprimer']){
                       //on supprime la route seulement si elle n'a pas été valider par le directeur de la stratégie
                         if($_POST['validation'] == 0){
                         $sqlupdate = "DELETE FROM `cibleRoutage` WHERE  id_cibleRoutage= ".$_POST['idcible'];
                         //echo $sqlupdate;
                         
                         $resultupdate = $con->query($sqlupdate);
                         if(!$resultupdate)  {
                             echo "Erreur dans la mise à jour de la validation de la route !!!";  
                         }
                         }else{
                             echo "Vous ne pouvez pas supprimer une route ayant été validée par le directeur de la stratégie !!!";
                         }
                         
                   }
         
         
         
         
         ?></h3>
      

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
                  
                  
                   //requete sql permettant d'alimenter le tableau de toutes les cibles de routagz
                   $sql = "SELECT * FROM `cibleRoutage`";
                   //echo $sql;

                   $result = $con->query($sql);
                   //s'il y a des cibles de routage qui correspondent a la requete $sql
                   if ($result->num_rows > 0) {
                     //pour chaque ligne faire 
                     while($row = $result->fetch_assoc()) {
                  
                            //tableau contenant les numéro des articles de la route
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
                            //tableau contenant les noms des articles correspondant aux numéro des articles de la route
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
            //on affiche les noms des articles de la ligne
             for($i = 0; $i <sizeof($designations); $i++){
                echo $designations[$i]." / ";
            }
         ?> </td>
<td align='center'><?php echo $row["catalogue"] ?> </td>
<td align='center'><?php if($row["valider"]== 0){echo "Non";}else{echo "Oui";}?> </td>
          <td align='center'><?php if($row["envoyer"]== 0){echo "Non";}else{echo "Oui";}?> </td>             <td align='center'>
                        <input type="hidden" value="<?php echo $row["id_cibleRoutage"] ?>" name="idcible" />
                        <input type="hidden" value="<?php echo $row["valider"] ?>" name="validation" />
                        <input class="pure-button pure-button-delete" type="submit" value="Supprimer" name="supprimer"/>
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
