

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Référentiel article</title>
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
         <a href="referentielarticle.php">Référentiel article</a>
         <a href="referentielindividu.php">Référentiel Client</a>
         <a href="logout.php">Déconnexion</a>
      </div>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;Menu</span>
      <h1 align="center">Bienvenue sur la page des articles : </h1>
        <h3 style="color: red; font-weight: bold;">
      <?php
         require('db.php');
         
         //si on clique sur un des boutons supprimer   
         if(isset($_POST['delete'])){
          $id = $_POST['keydelete'];//on récupère l'id de la ligne que on veut supprimer du champ cacher
           
              $sqlcom = "SELECT * FROM `ligneCommande` WHERE numerounique=$id"; 
              $resultcom = $con->query($sqlcom);
              if ($resultcom->num_rows > 0) { echo "Cet article est présent dans au moins une commande. Suppression impossible !";}
            
            if($resultcom->num_rows == 0){
                
                           $query = "DELETE FROM `article` WHERE numerounique='$id'";
           $result = mysqli_query($con,$query) or die(mysql_error());
           
           /*if($result){
                echo "Suppression réussie!";  
           }*/
         
           if(!$result)  {
             echo "Suppression échouée";  
           }
            }

         }
         
         //si on clique sur le bouton créer un nouvelle article
         if(isset($_POST['create'])){
           echo "<script type='text/javascript'>window.top.location='createarticle.php';</script>";
         }
         
         ?></h3>
      <div align="center">
         <form class="form" method="post" name="artcile" action="" >
            <input  class="pure-button pure-button-create" type="submit" value="Créer un nouvel article" name="create" class="article-button"/>
         </form>
      </div>
      </br>
      <div class="tableFixHead"  style="height:600px" >
         <table border="3">
            <thead>
               <th>Numéro</th>
               <th>Désignation</th>
               <th>Prix de vente</th>
               <th>Action</th>
            </thead>
            <tbody>
               <?php 
                  //requete sql permettant d'aliment le tableau des articles
                  $sql = "SELECT * FROM `article`";
                  $result = $con->query($sql);
                  
                  if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        
                  ?> 
               <tr>
                  <form class="form" method="post" id="deleteupdate" name="deleteupdate" action="">
                     <td align='center'><?php echo $row["numerounique"] ?> </td>
                     <td align='center'> <?php echo $row["designation"] ?></td>
                     <td align='center'><?php echo $row["prix"] ?> </td>
                     <td align='center'>
                        <a class="pure-button pure-button-update" href="editarticle.php?edit=<?php echo $row["numerounique"] ?>">MODIFIER</a>
                        <input type="hidden" value="<?php echo $row["numerounique"] ?>" name="keydelete" required/>
                        <input class="pure-button pure-button-delete" type="submit" value="SUPPRIMER" name="delete"/>
                     </td>
                  </form>
               </tr>
               <?php  
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

