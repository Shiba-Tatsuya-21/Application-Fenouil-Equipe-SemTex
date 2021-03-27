<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Modification d'article</title>
      <link rel="stylesheet" href="style.css"/>
      <script src="script.js"></script> 
      
      <style>  
      
       form{
    width: 650px;
    height: 250px;
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
   <button class="pure-button pure-button-update"  onclick="location.href = 'referentielarticle.php';" >Retour</button>
   <body height=100% width=100%>
      <?php
         require('db.php');
         //quand on arrive sur la page on récupère depuis l URL avec GET l'id de l'article a mettre a jour
         if(isset($_GET['edit'])){
             $id = $_GET['edit'];
             $sql = "SELECT * FROM `article` WHERE numerounique='$id'";
             $result = $con->query($sql);
             $row = $row = $result->fetch_assoc();
             //on se sert de $row pour récupérer les informations de l'article en question
             
             //si on clique sur le bouton modifier alors on update la l'article 
             if(isset($_POST['update'])){
              $newdesignation = $_POST['newdesignation'];
              $newdesignation = mysqli_real_escape_string($con, $newdesignation);
              $newprix = $_POST['newprix'];
         
              $sql = "UPDATE `article` SET designation='$newdesignation', prix=$newprix WHERE numerounique=$id";
              //echo $sql;
              $result = $con->query($sql);
              if($result === TRUE){
                  //echo "Successful Update!";  
                  echo "<script type='text/javascript'>window.top.location='referentielarticle.php';</script>";
             }
         
             else  {
               echo "Erreur dans la mise à jour de l'article !!:";  
             }
              
             
         }
         }
         //https://www.w3schools.com/php/php_mysql_select.asp
         //https://www.w3schools.com/
         
         ?>
      <form class="form" method="post" name="artcile" action="">
         <h1 class="article-title">Modifier article</h1>
         <label>Numéro unique de l'article : </label>
         <label name="num"> <?php echo $row[numerounique]; ?></label>
         <div></br>
            <label>Nom de l'article : </label>
            <input type="text" class="article-input" name="newdesignation" value="<?php echo $row[designation]; ?>" placeholder="désignation"  maxlength="50" size="55"  autofocus="true"/>
            </br></br>
            <label>Prix de l'article : </label>
            <input type="text" maxlength="7" class="article-input" value="<?php echo $row[prix]; ?>" name="newprix" placeholder="prix de vente" onkeypress="validate_decimal(event)" pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,2}))?)" step=".01" />
         </div>
         </br>
         <input type="submit" value="Modifier" name="update" class="pure-button pure-button-create"/>
      </form>
   </body>
</html>

