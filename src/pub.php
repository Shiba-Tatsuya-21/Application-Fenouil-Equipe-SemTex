<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Publicité Fenouil</title>
    <script src="script.js"></script> 
      <link rel="stylesheet" href="style.css"/>
</head>
<body>
<h1>Bienvenue sur la page des publicitées!!!</h1>
<?php
require('db.php');
//si on clique sur le bouton créer un nouvelle routes on la créer et on redirige vers la page pour alimenter les individus cibles de la route
         if(isset($_POST['create'])){
              $query = "INSERT INTO `cibleRoutage`() VALUES ()";
             $result = mysqli_query($con,$query) or die(mysql_error());
             
           echo "<script type='text/javascript'>window.top.location='createroutage.php';</script>";
         }
         
         ?></h3>
      <div align="center">
         <form class="form" method="post" name="route" action="" >
            <input  class="pure-button pure-button-create" type="submit" value="Créer une nouvelle route" name="create" class="article-button"/>
            </form>
</div>

<div class="tableFixHead"  style="height:600px" >
         <table border="3">
            <thead>
               <th>Numéro client ciblées</th>
               <th>Numéro des articles</th>
               <th>Catalogue</th>
               <th>Titre</th>
               <th>Description</th>
               <th>Qualité</th>
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
                  
                  
                         
                         
                   ?> 
               <tr>
                  <form class="form" method="post" id="deleteupdate" name="deleteupdate" action="">
                     <td align='center'><?php echo $row["id_individus"] ?> </td>

                       
                  </form>
               </tr>
               <?php  
                      }
                    } else {
                    echo "Votre base de données est vide !!!";
                    }
                    $con->close();
                    
                    
                    ?>  
            </tbody>
         </table>
      </div>
</body>
</html>
