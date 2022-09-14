function getMessages(){
    // Je créé une requête AJAX pour me connecter au serveur
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("GET", "connect.php");
    // Je traite les données en JSON et les affichent au format HTML 
    requeteAjax.onload = function(){
        const resultat = JSON.parse(requeteAjax.responseText);
        const html = resultat.map(function(message){
        return `
            <section class="member-list">
                <div class="member-item"><img src="person-outline.svg" alt=""/> ${message.nom}</div>
            </section>
        `
        }).join('');
        const messages = document.querySelector('.member-list');
        messages.innerHTML = html;
    }
    // J'envoie la requête
    requeteAjax.send();
}

// Je créé une fonction pour envoyer le nom sur le formulaire
function postMessage(event){
    event.preventDefault();
    const nom = document.querySelector('#name');
    let error = document.querySelector(".error");
    let member = document.querySelector(".member-item");
    // Je vérifie si le champ n'est pas vide
    if(nom.value !== ''){
        const data = new FormData();
        data.append('nom', nom.value);
        // Je configure une requête AJAX en POST et j'envoie les données
        const requeteAjax = new XMLHttpRequest();
        requeteAjax.open('POST', 'connect.php?task=write');
        requeteAjax.onload = function(){
            nom.value = '';
            nom.focus();
            getMessages();
        }
        requeteAjax.send(data);
        error.style.display = 'none';
    }else{
        error.style.display = 'block';
    }
    
}
document.querySelector('form').addEventListener('submit', postMessage);


getMessages();

