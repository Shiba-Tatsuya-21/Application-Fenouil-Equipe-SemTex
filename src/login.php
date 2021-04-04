<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Connexion Fenouil</title>
      <link rel="stylesheet" href="stylelogin.css"/>
   </head>
   <body>
      <img src="images/logo.png" class="logo">
      <?php
         session_start();
         //on récupère la connexion a la base de données en ligne phpmyadmin
         require('db.php');
         
         
         // quand le formulaire est envoyer on vérifie et créer une session utilisateur.
         if (isset($_POST['username'])) {
             //on stocke la valeur de username
             $username = stripslashes($_REQUEST['username']);    // removes backslashes
             $username = mysqli_real_escape_string($con, $username);
             //on stocke la valeur de password
             $password = stripslashes($_REQUEST['password']);
             $password = mysqli_real_escape_string($con, $password);
             // vérifie dans la base que l'utilisateur et le mot de passe existe
             $query    = "SELECT * FROM `users` WHERE username='$username'
                          AND password='$password'";
             //on exécute la requête
             $result = mysqli_query($con, $query) or die(mysql_error());
             //on stocke dans $rows le nombre de résultat de la requete
             $rows = mysqli_num_rows($result); 
             //s'il y a un résultat = le compte avec le username et password est correct
             if ($rows == 1) {
                 //$_SESSION['username'] = $username;//il y a un bug ici
         
                 if ($username == "responsable"){
                 echo "<script type='text/javascript'>window.top.location='gestionreferentiel.php';</script>";
                 }else if($username == "assistant"){
                 echo "<script type='text/javascript'>window.top.location='infoclientcommande.php';</script>";
                 }else if($username == "gestionnaire"){
                 echo "<script type='text/javascript'>window.top.location='anomalie.php';</script>";
                 }else if($username == "prospection"){
                 echo "<script type='text/javascript'>window.top.location='pub.php';</script>";
                 }else if($username == "envois"){
                 echo "<script type='text/javascript'>window.top.location='pageResponsableRoutage.php';</script>";
                 }elseif ($username == "directeur") {
                 echo "<script type='text/javascript'>window.top.location='pageDirecteur.php';</script>";
	# code...
        }
         
         
             } else {//si mot de passe ou username incorrect 
                 echo "<div class='loginbox'>
                       <h3>Nom d'utilisateur ou Mot de passe incorrect !!!</h3><br/>
                       <p class='link'>Cliquer  <a href='login.php' style='color: red;font-size: large; font-weight: bold;'>ICI</a> pour réessayer.</p>
                       </div>";
             }
         } else {
         ?>
      <div class="loginbox">
         <img src="images/avatar5.png" class="avatar">
         <h1 class="login-title">Connexion Fenouil</h1>
         <form class="form" method="post" name="login">
            <input type="text" class="login-input" name="username" placeholder="Nom d'utilisateur" autofocus="true" required/>
            <input type="password" class="login-input" name="password" placeholder="Mot de passe" required/>
            <input type="submit" value="Connexion" name="submit" class="login-button"/>
            <!-- <p class="link">Vous n'avez pas de compte ?  <a href="registration.php">Inscrivez-vous maintenant</a></p> -->
         </form>
      </div>
      <?php
         }
         ?>
   </body>
</html>

