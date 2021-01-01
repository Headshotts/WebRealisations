<?php
    //Page de déconnexion de la session en cours.
    session_start();

    session_unset();
    
    session_destroy();
    
    header('Location:index.php');
?>