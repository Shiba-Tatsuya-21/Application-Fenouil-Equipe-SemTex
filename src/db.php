<?php
    // Enter your host name, database username, password, and database name.
    // If you have not set database password on localhost then set empty.
    $con = mysqli_connect('host name','database username','password','database name');
    // Check connection
    if (mysqli_connect_errno()){
        echo "Erreur de connexion à la base de données : " . mysqli_connect_error();
    }
?>
