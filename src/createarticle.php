

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Création d'article</title>
      <link rel="stylesheet" href="style.css"/>
      <script src="script.js"></script> 
      <style>  
      
      form{
    width: 650px;
    height: 200px;
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
   <button class="pure-button pure-button-update"  onclick="location.href = 'referentielarticle.php';">Retour</button>
   <body height=100% width=100%>
      <?php
         require('db.php');
         
         //si on clique sur le bouton ajouter 
         if(isset($_POST['ajout'])){
             $designation = $_POST['designation'];  
             $designation = mysqli_real_escape_string($con, $designation);
             $prix = $_POST['prix'];  
             $prix = mysqli_real_escape_string($con, $prix);
             
             // on insert dans la table article la désignation et le prix du nouvelle article
             $query = "INSERT INTO `article`(`designation`,`prix`) VALUES('$designation','$prix')";
             $result = mysqli_query($con,$query) or die(mysql_error());
             
             //si l'insertion réussi on redirige vers la page qui liste les articles
             if($result){
                //echo "Insertion réussie";  
                echo "<script type='text/javascript'>window.top.location='referentielarticle.php';</script>";
         
             }else{
               echo "Insertion échouée";  
             }
         
         }
         ?>
      <form class="form" method="post" name="artcile" action="">
         <h1 class="article-title">Création d'un article</h1>
         <label>Nom de l'article : </label>
         <input type="text" class="article-input" name="designation" placeholder="désignation" autofocus="true" maxlength="50" size="55" required/></br></br>
         <label>Prix de l'article : </label>
         <input type="text"  class="article-input" maxlength="7" name="prix" placeholder="prix de vente" onkeypress="validate_decimal(event)" pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,2}))?)" step=".01" required/>
         <input class="pure-button pure-button-create" type="submit" value="AJOUTER" name="ajout" class="article-button"/>
      </form>
   </body>
</html>

