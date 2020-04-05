// Je construit mon sélecteur bzQuery
var bzQuery = function (selector) {
    this.selector = selector || null;
    this.element = null;
};

//Init du sélecteur
bzQuery.prototype.init = function () {
    let cleanSelector = this.selector.substring(1); // Je stocke mon sélécteur $$$('selecteur') sans le premier charatere pour plus tard ;)
    switch (this.selector[0]) { //On check le premier caractère du sélecteur avec switch
        case '<':// $$$('<selecteur>')
            //Si le selecteur commence par '<' c'est qu'on veut créer un élément
            var matches = this.selector.match(/<([\w-]*)>/); // Boolean (true/false)
            if (matches === null || matches === undefined) { //Si le selecteur ne contient pas '<' et '>' il n'est pas valide.
                throw 'Selecteur invalide';
                return false; //On stoppe le script
            }
            let nodeName = matches[0].replace('<', '').replace('>', ''); //On  supprime les "<>"
            this.element = document.createElement(nodeName); //On crée et on récupère l'element dans la foulée
            break;
        case '.': // $$$('.selecteur')
            //Si le selecteur commence par '.' c'est une classe que l'on veux sélectionner (donc plusieurs élément)
            this.element = document.getElementsByClassName(cleanSelector);
            break;
        case '#': // $$$('#selecteur')
            //Si le sélecteur commence par '#' c'est une classe que l'on veux sélectionner (donc plusieurs élément)
            this.element = document.getElementById(cleanSelector);
            break;
        default:
            //Sinon on le sélectionne la balise html avec le querySelector
            this.element = document.querySelector(this.selector);
    }
};

// On créer un callback, c'est à dire que l'on défini une réaction à une action
// Exemple -> $$$('selecteur').on('click', 'function(){}');
bzQuery.prototype.on = function (event, callback) {
    var evt = this.eventHandler.bindEvent(event, callback, this.element);
};

// On désactive un callback
// Exemple -> $$$('selecteur').off('click');
bzQuery.prototype.off = function (event) {
    var evt = this.eventHandler.unbindEvent(event, this.element);
};

// On défini ou on récupère la valeur de l'element selectionné
// Définir la valeur -> $$$('selecteur').val('click');
// Obtenir la valeur $$$('selecteur').val();
bzQuery.prototype.val = function (newVal) {
    return (newVal !== undefined ? this.element.value = newVal : this.element.value);
};

// On ajoute la valeur 'html' à la FIN (append) de l'element
// Exemple -> $$$('selecteur').append('Ce text va apparaitre à la fin de l'element');
bzQuery.prototype.append = function (html) {
    this.element.innerHTML = this.element.innerHTML + html;
};

// On ajoute la valeur 'html' au DEBUT (prepend) de l'element
// Exemple -> $$$('selecteur').prepend('Ce text va apparaitre de DEBUT de l'element');
bzQuery.prototype.prepend = function (html) {
    this.element.innerHTML = html + this.element.innerHTML;
};

// On défini (remplace) ou on récupère le HTML de l'element selectionné
// Exemple -> $$$('selecteur').html('<p>Ce paragraphe va remplacer le contenu de l'element sélectionné</p>');
// Exemple -> $$$('selecteur').html(); Je récupère le HTML de l'élément
bzQuery.prototype.html = function (html) {
    if (html === undefined) { // Si html est vide
        return this.element.innerHTML; // Retourne le HTML
    }
    this.element.innerHTML = html; // Sinon défini le HTML
};

// Exemple de fonction
// Je veux qu'a chaque fois qu'on appel la fonction .bzez() :
// Remplacer cet élément par une phrase
// Faire un log dans la console
bzQuery.prototype.bzez = function (msg) {
    $$$('body')('Sam BZEZ dit:\r\n'+ msg);
    console.log(msg + ' à bien remplacé l\'élément')
};

// Dans cette fonction je veux un log dans la console de l'element selectionné
bzQuery.prototype.log = function () {
    console.log(this.element)
};

//Ecouteurs de click, focus, etc etc
bzQuery.prototype.eventHandler = {
    events: [],
    bindEvent: function (event, callback, targetElement) {
        this.unbindEvent(event, targetElement);
        targetElement.addEventListener(event, callback, false);
        this.events.push({
            type: event,
            event: callback,
            target: targetElement
        });
    },
    findEvent: function (event) {
        return this.events.filter(function (evt) {
            return (evt.type === event);
        }, event)[0];
    },
    unbindEvent: function (event, targetElement) {
        var foundEvent = this.findEvent(event);
        if (foundEvent !== undefined) {
            targetElement.removeEventListener(event, foundEvent.event, false);
        }
        this.events = this.events.filter(function (evt) {
            return (evt.type !== event);
        }, event);
    }
};

// Ah oui, comme tout bon framework on veut rempalcer le getElementBy... par $$$()
// Je défini donc '$$$' comme sélecteur d'élément DOM
$$$ = function (selector) {
    var el = new bzQuery(selector); // el = instance de notre framework bzQuery
    el.init(); //Je lance l'init de mon mini framework à chauqe fois que j'utilise $$$
    return el; // Je retourne l'element selectionné, la boucle est bouclée !
};
$$$('#ok').log();