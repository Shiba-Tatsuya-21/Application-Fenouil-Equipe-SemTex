
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Gestions des référentiels</title>
      <link rel="stylesheet" href="style.css"/>
      <script src="script.js"></script> 
   </head>
   <style>
      body{
      margin: 0;
      padding: 0;
      background: url(images/gestionreferentiel.jpg) no-repeat;
      background-size: cover;
      font-family: sans-serif;
      color: white;
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
      }
   </style>
   <body>
      <div id="mySidenav" class="sidenav">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <a href="pub.php"> Administration du référentiel</a>
         <a href="referentielindividu.php"> Création de cible de routage</a>
         <a href="anomalie.php"> Gestion des anomalies</a>
         <a href="commande.php"> Saisie des commandes</a>
         <a href="logout.php">Déconnexion</a>
      </div>
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;Menu</span>
      <h1 align="center">Bienvenue sur la page de l'administration des référentiels </h1>
   </body>
</html>

