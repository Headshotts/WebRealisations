document.addEventListener('DOMContentLoaded', calculPrix);
function principale(){
    //Fonction qui sert à écrire : Il reste X caractères et si il y'a plus de 300 caractères :
    // - Soit on écrit un message en rouge en disant "Vous avez trop de caractères ! Veuillez arrêter !
    // - Soit on fait un substr par "" pour supprimer les caractères ajoutés après 300 caractères et forcer le fait que l'on ne puisse pas dépasser la limite.
    // Pour cela, on compte le nombre de caractères dans le textarea. On part de 300 caractères et on fait 300 - nbCaractèresCourants, on regarde avec un if
    // si la soustraction n'est pas négative, auquel cas on applique une des deux possibilités ci-dessus.


}

function calculPrix(){
    console.log("Ca fonctionne");
    let billet = document.querySelectorAll(".billet");
    let nbBillets = billet.length;
    for(i = 0; i < nbBillets; i++){
        billet.item(i).addEventListener('change', compteurTicket);
        billet.item(i).addEventListener('change', prix_a_payer);
        //billet.item(i).addEventListener('change', verification_nb_billets);
        billet.item(i).addEventListener('change', nb_places_max);
        billet.item(i).addEventListener('keyup', compteurTicket);
        billet.item(i).addEventListener('keyup', prix_a_payer);
        billet.item(i).addEventListener('keyup', verification_nb_billets);
        billet.item(i).addEventListener('keyup', nb_places_max);
    }

    function compteurTicket(){
        console.log("Je rentre dans la fonction");
        let nb_tickets = document.getElementById("nb_tickets");
        let str_nb_tickets = document.getElementById("str_nb_tickets");
        let economic_value = document.getElementById("economic").value;
        let premium_value = document.getElementById("premium").value;
        let business_value = document.getElementById("business").value;
        nb_tickets.value = (parseFloat(economic_value) + parseFloat(premium_value) + parseFloat(business_value));
        str_nb_tickets.textContent = "Il y'a "+ nb_tickets.value + " tickets à payer.";
    }

    function prix_a_payer(){
        let prix_a_payer = document.getElementById("prix_a_payer");

        let prix_destination = document.getElementById("prix_voyage").value;

        let economic_value = document.getElementById("economic").value;
        let premium_value = document.getElementById("premium").value;
        let business_value = document.getElementById("business").value;

        let economic_price = economic_value*prix_destination;
        let premium_price = premium_value*prix_destination*1.5;
        let business_price = business_value*prix_destination*1.8;
        let paiement = (parseFloat(economic_price) + parseFloat(premium_price) + parseFloat(business_price));
        let paiement_format = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(paiement);
        prix_a_payer.textContent = "Prix à payer : " + paiement_format;

        let prix_formulaire = document.querySelector(".prix_a_payer");
        prix_formulaire.value = paiement;
    }

    let handicap = document.getElementById('handicap_reserv').addEventListener('click', verification_nb_billets);
    document.getElementById('handicap_reserv').addEventListener('keyup', verification_nb_billets);

    function verification_nb_billets(){
        console.log("Verification_nb_billets");
        let handicaps_reserv = document.getElementById('handicap_reserv');
        let nb_tickets = document.getElementById('nb_tickets');
        console.log("Handicap : " + handicaps_reserv.value);
        console.log("Tickets : " + nb_tickets.value);
        if(parseInt(handicaps_reserv.value) > parseInt(nb_tickets.value)){
            console.log("Je change la valeur de handicap");
            handicaps_reserv.value = nb_tickets.value;
            alert("Nombre de places handicapés à réserver supérieur à celui des places que vous souhaitez réserver.");
        }
    }

    function nb_places_max(){
        console.log("Je vérifie le nombre de places voulus");
        let nb_tickets = document.getElementById('nb_tickets');
        let nb_tickets_max = document.getElementById('nb_tickets_max');
        let economic_value = document.getElementById("economic").value;
        let premium_value = document.getElementById("premium").value;
        let business_value = document.getElementById("business").value;
        if(parseInt(nb_tickets.value) > parseInt(nb_tickets_max.value)){
            console.log("Trop de places prises.");
            alert("La réservation est pleine. Veuillez modifier le nombre de tickets à acheter.");
            economic_value = 0;
            premium_value = 0;
            business_value = 0;
        }
    }
}




