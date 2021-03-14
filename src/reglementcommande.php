

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>CommandeFenouil</title>
      <script src="script.js"></script> 
      <link rel="stylesheet" href="style.css"/>
      <style>
         form{
         width: 850px;
         height: 350px;
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
         background: url(images/commande.png) no-repeat;
         background-size: cover;
         font-family: sans-serif;
         }
      </style>
      <script> 
         //fonction permettant en fonction de si on clique sur le radio bouton Chèque ou Carte bancaire de rendre impossible d'écrire dans le champs de l'autre. De plus elle vide les champs qui on été si on passe d'un radio bouton a un autre
            function videInfo() {
                if(document.getElementById('choixChèque').checked){
                    document.getElementById('Inputcartenum').readOnly= true; 
                    document.getElementById('Inputcartedate').readOnly= true; 
                    document.getElementById('Inputcarteano').disabled = true;
                    
                    document.getElementById('Inputcartenum').value= ""; 
                    document.getElementById('Inputcartedate').value= "";
                    document.getElementById('Inputcarteano').checked =false;
                    
                    
                    document.getElementById('Inputchequenum').readOnly= false;
                    document.getElementById('Inputchequenom').readOnly= false;
                    document.getElementById('Inputchequeano').disabled = false;
                    
                    document.getElementById('Inputchequenum').required=true;
                    document.getElementById('Inputchequenom').required=true;
                    
                }else if(document.getElementById('choixCarte').checked ){
                    document.getElementById('Inputchequenum').readOnly= true;
                    document.getElementById('Inputchequenom').readOnly= true;
                    document.getElementById('Inputchequeano').disabled = true;
                    
                    
                    document.getElementById('Inputchequenum').value= "";
                    document.getElementById('Inputchequenom').value= "";
                    document.getElementById('Inputchequeano').checked =false;
                    
                    
                     document.getElementById('Inputcartenum').readOnly= false; 
                    document.getElementById('Inputcartedate').readOnly= false; 
                    document.getElementById('Inputcarteano').disabled = false;
                    
                    
                     document.getElementById('Inputcartenum').required=true;
                    document.getElementById('Inputcartedate').required=true;
                }
                
            } 
            
            
      </script>  
   </head>
   <body>
      <?php 
         require('db.php');
         //on récupère toute les information de la commande en cours qui est la dernière dans la table  commande
         $sqlidcmd = "SELECT * FROM `commande` ORDER BY id_commande DESC LIMIT 1";
         $resultid = $con->query($sqlidcmd);
         $rowid = $resultid->fetch_assoc();
         $now = new DateTime();
         $datetoday = $now->format('Y-m-d');
          $datetoday;
         
         ?>
      <form class="form" method="post" name="" >
         <h1 class="article-title">Règlement </h1>
         <h2>Commande Numéro 
            <?php echo $rowid[id_commande];?> pour un montant commandé de  <?php echo $rowid[MontantCommande];?> €
         </h2>
         <input type="radio" onclick="videInfo()" id="choixChèque" name="radio" value="Chèque" checked/>Chèque
         <input type="text" class="reglement-input" name="numcheque"  onkeypress="validate_integer(event)" maxlength="12" size="20" placeholder="Numéro de chèque" id="Inputchequenum"  required/>
         <input type="text" class="reglement-input" name="nombanque"  maxlength="30" size="35" placeholder="Nom de la banque" id="Inputchequenom" required/>
         <input type="radio" name="anomalie" value="chequenonsigner" id="Inputchequeano" />Chèque non-signé
         </br></br>
         <input type="radio" name="radio"  id="choixCarte" onclick="videInfo()" value="Carte bancaire"/>Carte bancaire
         <input type="text" class="reglement-input" name="numcarte"  onkeypress="validate_integer(event)" maxlength="12" size="20" placeholder="Numéro de la carte" id="Inputcartenum" readonly/>
         <label>Date d'expiration de la carte</label>
         
         
         <input type="date" class="individu-input" name="dateexpiration"   min="<?php echo $datetoday?>" maxlength="15" size="20" id="Inputcartedate" readonly/>
         <input type="radio" name="anomalie" value="cbinvalide" id="Inputcarteano" disabled/>CB invalide
         </br></br>
         <label>Montant du règlement : </label>
         <input type="text" maxlength="7" class="article-input"  name="montant" onkeypress="validate_decimal(event)" pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,2}))?)" step=".01" required/>
         <input class="pure-button pure-button-create" type="submit" value="Règler commande" name="règler" class="article-button"/>
         <h2 style="color: red; font-weight: bold;">
            <?php 
               $numcheque = $_POST['numcheque'];
               $nombanque = $_POST['nombanque'];
               $nombanque = mysqli_real_escape_string($con, $nombanque);
               $numcarte = $_POST['numcarte'];
               $dateexpi = $_POST['dateexpiration'];
               
               $montantreglement = $_POST['montant'];
               
               
               
               $anomalie = false;
               
               
               //  si on a clqiuer sur le bouton régler
               if(isset($_POST['règler'])){
                 //en fonction de sur quel bouton radio Chèque non-signé ou CB invalide on prépare la requête pour insérer l'anomalie du moyen de paiement dans la table anomalie
                 switch($_POST['anomalie']) {
                   case "cbinvalide":
                        $sqlano = "INSERT INTO `anomalie`( `id_client`, `id_commande`, `description`, `résolue`) VALUES ($rowid[id_client],$rowid[id_commande],'Problème sur le moyen de paiement',0)";
                         $anomalie = true;
                        //echo $sqlano;
                       break;
                   case "chequenonsigner":
                       $sqlano = "INSERT INTO `anomalie`( `id_client`, `id_commande`, `description`, `résolue`) VALUES ($rowid[id_client],$rowid[id_commande],'Problème sur le moyen de paiement',0)";
                        $anomalie = true;
                        //echo $sqlano;
                       break;
                  
               }
                    //si on a sélectionner un des bouton radio Chèque non-signé ou CB invalide
                   if($_POST['anomalie']){
                       //si la reqête n'est pas vide
                        if($sqlano != ""){
                            //fait insertion anomalie paiement
                            $resultano = $con->query($sqlano);
                            
                        }
                        
                       
                   }
                   //si le montant régler est différent du montant de la commande insérer dans anomalie une erreur sur le montant'
                   if($montantreglement != $rowid[MontantCommande]){
                           $sqlano = "INSERT INTO `anomalie`( `id_client`, `id_commande`, `description`, `résolue`) VALUES ($rowid[id_client],$rowid[id_commande],'Erreur sur le montant',0)";
                            $resultano = $con->query($sqlano);
                             $anomalie = true;
                            
                        }
                        //s'il y a pas d'anomalie commande valider redirection accueil commande dans 5 secondes
                   if($anomalie == false){
                       $statut = "Valide";
                       echo "Commande validée. Retour à l'accueil dans 5 secondes!!";
                       echo "<script type='text/javascript'>   
                        function Redirect() 
                        {  
                            window.location='infoclientcommande.php'; 
                        } 
                        setTimeout('Redirect()', 5000);   
                    </script>";
                    //on récupère les données du client de la commande
                     $sqlidclient = "SELECT * FROM `individu` WHERE id_individu='$rowid[id_client]';";
                     $resultclient = $con->query($sqlidclient);
                     $rowclient = $resultclient->fetch_assoc();
                     
                     
                     //si il était un Prospect alors on le met client
                    if($rowclient[statut]==Prospect){
                        $sqlprospect = "UPDATE `individu` SET statut='Client' WHERE id_individu=$rowid[id_client]";
                         $result = $con->query($sqlprospect);
                        //echo "Francois est devenu Client";
                    }
                   }
                   //s'il y a une anomalie commande mise en attente redirection accueil commande dans 5 secondes
                   if($anomalie == true){
                        $statut = "En attente";
                        echo "Commande mise en attente car anomalie(s) détectée(s). Retour à l'accueil dans 5 secondes!!";
                        echo "<script type='text/javascript'>   
               function Redirect() 
               {  
               window.location='infoclientcommande.php'; 
               } 
               setTimeout('Redirect()', 5000);   
               </script>";
                   }
                   
                  //en fonction de sur quel bouton radio chèque ou carte bancaire on a choisi on prépare la requete d'update de la commande 
                   switch($_POST['radio']) {
                   case "Chèque":
                        $sql = "UPDATE `commande` SET statut='$statut', Chèque=1,NumChèque=$numcheque, NomBanque='$nombanque', MontantRèglement=$montantreglement  WHERE id_commande=$rowid[id_commande]";
                        //echo $sql;
                       break;
                   case "Carte bancaire":
                       $sql = "UPDATE `commande` SET statut='$statut',Carte=1,NumCarte=$numcarte, DateExpi='$dateexpi', MontantRèglement=$montantreglement  WHERE id_commande=$rowid[id_commande]";
                        //echo $sql;
                       break;
                  
               }
                   //on met a jours la commande avec le moyen de paiement utiliser et le montant régler
                $result = $con->query($sql);
               if($result === TRUE){
                    //echo "<script type='text/javascript'>window.top.location='lignescommande.php';</script>";
                }else{
                   //echo "Update rater!"; 
                }
                   
                   }
                 
               ?>
         </h2>
      </form>
   </body>
</html>

