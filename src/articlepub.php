<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Référentiel article</title>
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
      </style>
   <body>
      <h1 align="center">Chosir les articles de la publicité : </h1>
        <h3 style="color: red; font-weight: bold;">
      <?php
         require('db.php');
                    $queryselectcible = "SELECT * FROM `cibleRoutage` ORDER BY id_cibleRoutage DESC LIMIT 1";
                        
                        
                    $resultat = $con->query($queryselectcible);
                    $cibles = $resultat->fetch_assoc();
                    //si on clique sur un des bouton ajouter on ajoute l'article en mettant a jours les articles de la route
                if($_POST['ajouter']){

                      $articletoadd = $_POST['keyajout'];
                       //echo substr_count($cibles[id_articles], ';');
                        //On vérifie que on a pas déjà ajouter cette articles  aux articles de la route
                    if(strpos($cibles[id_articles],$articletoadd)!==false){ 
                          echo "Cet article est déjà au sein de la publicité !!!";  
                
                        }else{
                            //si on a jouter moins de 5 articles on met a jour la route avec le nouvel article a ajouter
                            if(substr_count($cibles[id_articles], ';')<5){
                            $query = "UPDATE `cibleRoutage` SET `id_articles`='".$cibles[id_articles].$articletoadd .";' ORDER BY id_cibleRoutage DESC LIMIT 1";
                        //echo $query;
                        $res = mysqli_query($con,$query) or die(mysql_error());
                            }else{//si on déjà 5 articles dans la pub on ne peut plus en ajouter 
                                echo "Vous avez déjà ajouté 5 articles à votre publicité";
                            }
                        }
                         
                        
                          }
         //si on clique sur le bouton Valider la route
         if($_POST['create']){
             //on vérifie que on a au moins ajouter 1 articles aux articles dans la route
             if($cibles[id_articles] != ""){
                echo "<script type='text/javascript'>window.top.location='pub.php';</script>";
            }else{
                //si on a pas d'article dans la route on affiche
                echo "Veuillez ajouter au moins 1 article à la publicité !!!";
            }

         }
                  
        $resultat = $con->query($queryselectcible);
        $cibles = $resultat->fetch_assoc();
    //Tableau qui contient les numéros des articles que on a choisi d'ajouter
    $numarticle = array();

    $tmp;
    for ($i = 0; $i <strlen($cibles[id_articles]); $i++) {
        if($cibles[id_articles][$i]==";"){
            array_push($numarticle, $tmp);
            $tmp="";
        }else{
            $tmp = $tmp.$cibles[id_articles][$i];
        }
        

      }   
    //Tableau qui contient les noms des articles que on a choisi d'ajouter
      $designations = array();
      for($i = 0; $i <sizeof($numarticle); $i++){
        $sqlarticle = "SELECT * FROM `article`WHERE numerounique='".$numarticle[$i]."'";
        $resultatarticle = $con->query($sqlarticle);
        $designation = $resultatarticle->fetch_assoc();
        array_push($designations, $designation[designation]); 
          
          
         
      }
    ?></h3>
         <h3 style="color: green; font-weight: bold;">
         
         <?php 
         //on affiche les articles déjà choisi
             echo "Les articles dans votre publicité sont : "."<br>";
            for($i = 0; $i <sizeof($designations); $i++){
                echo " - ".$designations[$i]."<br>";
            }
         ?></h3>
      <div align="center">
         <form class="form" method="post" name="artcile" action="" >
            <input  class="pure-button pure-button-create" type="submit" value="Valider la route" name="create" class="article-button"/>
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
                  //requete sql permettant d'alimenter le tableau des articles
                  $sql = "SELECT * FROM `article` ORDER BY designation";
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
                        <input type="hidden" value="<?php echo $row["numerounique"] ?>" name="keyajout" required/>
                        <input class="pure-button pure-button-update" type="submit" value="Ajouter" name="ajouter"/>
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

