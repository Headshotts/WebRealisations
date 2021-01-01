document.addEventListener('DOMContentLoaded', principale);
function principale(){
    console.log("Programme lancé !");
    let symboles = document.querySelectorAll('.symbole');
    let nbSymboles = symboles.length;
    let PremierSymbole = document.querySelector('.symbole1');
    let DeuxiemeSymbole = document.querySelector('.symbole2');
    let TroisiemeSymbole = document.querySelector('.symbole3');
    let intro = document.querySelector('.contact_intro');
    
    for(n=0; n<nbSymboles; n++){
        console.log("La boucle for fonctionne " + n + " fois.");
        symboles.item(n).addEventListener('click', visible);
        symboles.item(n).addEventListener('click', grossir);
        /*symboles.item(n).addEventListener('mouseout', invisible);*/
    }
    
function visible(){
   this.classList.add('cible'); /* L'élément dont l'utilisateur survole le curseur obtient le mot-clé cible*/
   console.log("Evenement détecté !") /* Lorsque la souris passe sur le symbole, on a une information dans la console*/
   intro.classList.remove('visible');
   intro.classList.add('invisible');
   console.log(intro.classList);
   for(k=0; k<nbSymboles; k++){  /* On recherche l'élément qui contient le mot clé cible */
       /*console.log("Je lance la boucle for de la fonction visible !");*/
       console.log(symboles.item(k).classList);     
       if (symboles[k].classList.contains('cible')){
           console.log("J'ai trouvé l'élément cible, c'est l'élément " + k + " !");
           if(k == 0){ /* Si c'est le premier symbole qui contient le mot clé cible, c'est donc l'élément survolé par le curseur...*/
              symboles.item(k).classList.remove('cible'); /* On a plus besoin du mot clé cible puisqu'on souhaite le réinitialiser à la futur demande de l'utilisateur*/
              PremierSymbole.classList.add('visible'); /*C'est donc la div correspondant au symbole1 qui sera visible pour l'utilisateur.*/
              DeuxiemeSymbole.classList.remove('visible');
              TroisiemeSymbole.classList.remove('visible');
              console.log("CLASSE PREMIER SYMBOLE " + PremierSymbole.classList);
              console.log("CLASSE DEUXIEME SYMBOLE " + DeuxiemeSymbole.classList);
              console.log("CLASSE TROISIEME SYMBOLE " + TroisiemeSymbole.classList);
              document.querySelector('h3').textContent = "Où sommes-nous ?";
              
           }
           if(k == 1){
              symboles.item(k).classList.remove('cible');
              PremierSymbole.classList.remove('visible');
              DeuxiemeSymbole.classList.add('visible');
              TroisiemeSymbole.classList.remove('visible');
              console.log("CLASSE PREMIER SYMBOLE " + PremierSymbole.classList);
              console.log("CLASSE DEUXIEME SYMBOLE " + DeuxiemeSymbole.classList);
              console.log("CLASSE TROISIEME SYMBOLE " + TroisiemeSymbole.classList);
              document.querySelector('h3').textContent = "Contact professionel";
              
           }
           if(k == 2){
              symboles.item(k).classList.remove('cible');
              PremierSymbole.classList.remove('visible');
              DeuxiemeSymbole.classList.remove('visible');
              TroisiemeSymbole.classList.add('visible');
              console.log("CLASSE PREMIER SYMBOLE " + PremierSymbole.classList);
              console.log("CLASSE DEUXIEME SYMBOLE " + DeuxiemeSymbole.classList);
              console.log("CLASSE TROISIEME SYMBOLE " + TroisiemeSymbole.classList);
              document.querySelector('h3').textContent = "S'inscrire à Music Learning";
              
           }
           
       }
   }
}
function grossir(){
        
        let PremierePhrase = document.querySelector('.texte1');
        let DeuxiemePhrase = document.querySelector('.texte2');
        let TroisiemePhrase = document.querySelector('.texte3');
        this.classList.add('cible_grossir');
        
        for(l = 0; l<nbSymboles; l++){
            if (symboles[l].classList.contains('cible_grossir')){
                if(l == 0){
                    symboles.item(l).classList.remove('cible_grossir');
                    PremierePhrase.classList.add('gros');
                    DeuxiemePhrase.classList.remove('gros');
                    TroisiemePhrase.classList.remove('gros');
                }
                
                if(l == 1){
                    symboles.item(l).classList.remove('cible_grossir');
                    PremierePhrase.classList.remove('gros');
                    DeuxiemePhrase.classList.add('gros');
                    TroisiemePhrase.classList.remove('gros');
                }
                
                if (l == 2){
                    symboles.item(l).classList.remove('cible_grossir');
                    PremierePhrase.classList.remove('gros');
                    DeuxiemePhrase.classList.remove('gros');
                    TroisiemePhrase.classList.add('gros');
                }
                }
                }
                }   



}


    
    
    
    

