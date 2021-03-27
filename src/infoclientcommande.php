<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>CommandeFenouil</title>
      <script src="script.js"></script> 
      <link rel="stylesheet" href="style.css"/>
      <style>
    
      
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

      body{
      margin: 0;
      padding: 0;
      background: url(images/client.jpg) no-repeat;
      background-size: cover;
      font-family: sans-serif;
  
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
   </head>
   <body>
        <div id="mySidenav" class="sidenav">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <a href="logout.php">Déconnexion</a>
      </div>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;Menu</span>
       
       
      <div class="div">
         <form class="form" method="post" name="" >
            <h1 class="article-title">Identification du client :</h1>
            <h3 style="color: red; font-weight: bold;">
               <?php
                  require('db.php');
                  //$doinsert est une variable qui permet de savoir si on peut créer la commande s'il elle est = 1
                  $doinsert = 0;
                  $idclient;
                  
                  //si on clique sur le bouton rechercher et que le champ input identifiant est rempli
                  if($_POST['rechercher'] && $_POST['identifiant'] != ""){
                      $id= $_POST['identifiant'];
                      $idclient= $id;
                      //on vérifie dans la table individu s'il existe un individu avec cette identifiant
                      $sql = "SELECT * FROM `individu` WHERE id_individu=$id";
                      $result = $con->query($sql);
                      $row = $result->fetch_assoc();
                      $doinsert = 1; 
                       
                  
                  
                  }
                  //si on clique sur le bouton rechercher et que le champ input identifiant est vide
                  if($_POST['rechercher'] && $_POST['identifiant'] == ""){
                      echo "Veuillez indiquer un identifiant pour rechercher un client !!!";
                  }
                  
                  //si on clique sur le bouton créer un nouveau client
                   if(isset($_POST['create'])){
                       echo "<script type='text/javascript'>window.top.location='createindividu.php?commande=1';</script>";
                   }
                  
                  //si on a rechercher dans la table individu l'identifiant et que l'individu n'existe pas 
                  if ($row == "" && $doinsert==1) {
                  echo "Le client ayant cet indentifiant unique n'existe pas veuillez le créer!!!";
                  }
                  ?>
            </h3>
            <label>Identifiant unique du client : </label>
            <input type="text"  class="id-input"  name="identifiant" maxlength="10"  onkeypress="validate_integer(event)"   value="<?php echo  $_POST['identifiant']?>"/>
            <input class="pure-button pure-button-update" type="submit" value="RECHERCHER" name="rechercher" class="article-button"/>
            </br>      </br> 
            <label>Nom : </label>
            <input type="text" class="id-input" name="nom"  maxlength="30" size="35" value="<?php echo $row[nom]; ?>" readonly required/>
            <label>Prénom : </label>
            <input type="text" class="id-input" name="prénom"  maxlength="30" size="35" value="<?php echo $row[prénom]; ?>" readonly required/>
            </br></br>
            <input class="pure-button pure-button-create" type="submit" value="Créer Nouveau Client" name="create" class="article-button"/>
            <input type="hidden" name="statut" value="<?php echo $row[statut];?>" />

      <input class="pure-button pure-button-create" type="submit" value="Commander" name="commander" class="article-button"/>
      </br>   </br>
      
      <h1>Modifier commande :</h1>
      <label>Numéro commande : </label>
      <input type="text"   name="numcommande" maxlength="10"  onkeypress="validate_integer(event)"   />
     <input class="pure-button pure-button-create" type="submit" value="Modifier" name="modifcommander" class="article-button"/>
      </br>   </br>
      
      </form>
      <h3 style="color: red; font-weight: bold;">
         <?php 
         //si c'est un client interdit 
         if($_POST['commander'] && $_POST['nom'] != "" && $_POST['prénom'] != "" && $_POST['numcommande']== "" && $_POST[statut]=='Client interdit'){
             echo "Client Interdit !!!";
         }
         
         
            //si on a cliquer sur le bouton commander et que les champs nom et prénom ont été alimenter par la table individu grace au select de l'identifiant et que ce n'est pas un client interdit
            if($_POST['commander'] && $_POST['nom'] != "" && $_POST['prénom'] != "" && $_POST['numcommande']== "" && $_POST[statut]!='Client interdit'){
              $id= $_POST['identifiant'];
              //on récupère la date de la commande = date de actuel = aujourd'hui
               $now = new DateTime();
               $datecom = $now->format('Y-m-d');
              //on insert dans la table commande une nouvelle commande avec id du client et la date de la commande
               $query = "INSERT INTO `commande`(`id_client`,`DateCommande`) VALUES('$id','$datecom')";//echo $query;
               $result = mysqli_query($con,$query) or die(mysql_error());
            
                //si l'insertion réussi on redirige vers la page qui gère la commande
                if($result){
                //echo "Insertion réussie";  
                echo "<script type='text/javascript'>window.top.location='commande.php';</script>";
                
                }else{
                echo "Insertion échouée";  
                }
            }
            
            if($_POST['modifcommander']  && $_POST['numcommande'] != ""){
                $sqlidcmd = "SELECT * FROM `commande` WHERE id_commande=$_POST[numcommande]";//echo $sqlidcmd;
                $resultid = $con->query($sqlidcmd);
                $rowid = $resultid->fetch_assoc();
                if ($resultid->num_rows > 0) {
                    //echo "la commande existe";
                    echo "<script type='text/javascript'>window.top.location='editcommande.php?commande=$rowid[id_commande]';</script>";
                }
                if ($resultid->num_rows == 0) {
                    echo "la commande n'existe pas !!!";
                }
            }
             if($_POST['modifcommander']  && $_POST['numcommande'] == ""){
                     echo "Veuillez vérifier renseigner le champs Numéro de commande !!!";
             }
            
            
            //si on clique sur le bouiton commander sans avoir vérifier que l'identifiant du client existe
            if($_POST['commander'] && $doinsert==0 && $_POST['numcommande']== "" && $_POST['nom'] == "" && $_POST['prénom'] == "" ){
              
               echo "Veuillez vérifier que l'identifiant existe !!!";
              
            }
            ?>
      </h3>
      </div>
   </body>
</html>

