<?php

    function limite_texte($zone, $max_caracteres = 300){  //300 caractères fait référence au textarea de gererBDD.php (Description).
        $textarea = strlen($zone);
        if($textarea > $max_caracteres){
            echo "Trop de caractères dans la partie" . $zone;
        }
    }
?>