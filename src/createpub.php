<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Création d'article</title>
      <link rel="stylesheet" href="style.css"/>
      <script src="script.js"></script> 
      <style>  
      
      form{
    width: 800px;
    height: 400px;
    background: #292A2B ;
    /*opacity: 1;*/
    color: #fff;
    top: 45%;
    left: 47%;
    position: absolute;
    transform: translate(-30%,-50%);
    box-sizing: border-box;
    padding: 10px 30px;
}

      body{
      margin: 0;
      padding: 0;
      background: url(images/rayon.png) no-repeat;
      background-size: cover;
      font-family: sans-serif;
  
      }</style>
   </head>
   <button class="pure-button pure-button-update"  onclick="location.href = 'createroutage.php';">Retour</button>
   <body height=100% width=100%>
      <?php
         require('db.php');
         
         //si on clique sur le bouton choisir article on met a jour la route en y ajoutant le titre, désignation et le catalogue choisi
         if(isset($_POST['ajout'])){
             $titre = $_POST['titre'];  
             $titre = mysqli_real_escape_string($con, $titre);
             $designation = $_POST['designation'];  
             $designation = mysqli_real_escape_string($con, $designation);
             $catalogue = $_POST['catalogue'];  
             //echo "Titre = ".$titre." désignation = ".$designation." catalogue = ".$catalogue;
             
             $queryselectcible = "SELECT * FROM `cibleRoutage` ORDER BY id_cibleRoutage DESC LIMIT 1";      
             $resultat = $con->query($queryselectcible);
             $lastroute = $resultat->fetch_assoc();

             
             
             
             $query = "UPDATE `cibleRoutage` SET `catalogue`='$catalogue',`titre`='$titre',`description`='$designation' WHERE id_cibleRoutage=$lastroute[id_cibleRoutage]";
             
             //echo $query;
             
             $result = mysqli_query($con,$query) or die(mysql_error());
             
             //si la mise à jour de la route a  réussi on redirige vers la page pour choisir les articles a ajouter à la publicité
             if($result){
                //echo "Update réussie";  
                echo "<script type='text/javascript'>window.top.location='articlepub.php';</script>";
         
             }else{
               echo "Mise à jour du titre, de la description et du catalogue de la route échouée";  
             }
         
         }
         ?>
      <form class="form" method="post" name="artcile" action="">
         <h1 class="article-title" align="center">Création de la publicité : </h1>
         <label>Titre :  </label>
         <input type="text" class="article-input"  autofocus="true" maxlength="50" size="55" name="titre" required/></br></br>
         <label>Désignation :</label>
        <textarea  rows="3" cols="30" maxlength="90"  name="designation" rows=""  style="overflow:auto;resize:none"required></textarea><br><br>
        <label>Catalogue :</label>
        <input type="radio"  name="catalogue" value="Papier standard"required/>Papier standard
        <input type="radio"  name="catalogue" value="Papier supérieur"required/>Papier supérieur
        <input type="radio"  name="catalogue" value="Papier économique"required/>Papier économique
        <input type="radio"  name="catalogue" value="Internet"required/>Internet
        <br><br>
         <input class="pure-button pure-button-create" type="submit" value="Choisir Article" name="ajout" class="article-button"/>
      </form>
   </body>
</html>

