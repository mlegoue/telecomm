<h1>Télécomm</h1>

<h2>Présentation</h2>

<p>Actuellement la communication dans l’école se fait à travers la pose d’affiches, l’utilisation de listes de diffusion et les réseaux sociaux. Il convient donc d’avoir un mode de communication plus rapide et réactif afin de dynamiser le campus. Ce projet s’inscrit dans le cadre de modernisation des locaux auquel l’école tend (tout comme le nouvel amphithéâtre, le Labus… ). </p>

<p>Nous souhaiterions proposer aux centraliens et au personnel de l’école une plateforme sur laquelle le partage d’information serait beaucoup plus efficace. Il s’agirait d’installer des écrans d’information dans l’enceinte de l’école, sur lesquels nous pourrions aisément partager des événements ou des informations importantes.</p>

<h2>Objectif du projet</h2>

<p>L’objectif de ce mini projet est de réaliser une application toute simple permettant d’une part d’ajouter des événements et d’autre part d’afficher ces événements sous une forme attrayante (vue télé). 
   
   Pour ce qui est des événements, on reprend les informations de base d’un événement à savoir : titre, lieu, date et heure de début, date et heure de fin, organisateur. On va également en plus mettre une description un peu plus longue ainsi qu’une affiche que la personne qui met en ligne l’événement pourra upload. (Dans un second temps uniquement) 
   
   Pour ce qui est des écrans de télé, on va supposer qu’il y en aura plusieurs, et que certaines TV pourront afficher du contenu différent. (exemple : afficher + des évents asso au niveau du couloir des assos que au niveau du plot 2). 
   
   L’affichage des événements ne reprendra que les évents dont la date de fin n’est pas encore passée par rapport à la date actuelle. 

Les User n’ont pas de champs particuliers si ce n’est nom/prénom (à rapatrier depuis MyCA quand l’option de login via MyCA sera implémenté).

Les Display (une instance display = un écran) correspondent aux écrans individuels et permettent le contrôle individuels de ceux-ci. Le champ token correspond à une chaîne de caractère générée aléatoirement qui sera l’url sur laquelle devra se rendre la raspi pour afficher cet écran.
Par exemple, si le token contient “abcdef” l’url sera quelque chose du genre : https://telecomm.ginfo.ec-m.fr/display/abcdef. C’est en quelque sorte le “password” pour afficher le contenu de cet écran. Le active définit quand à lui si l’écran est activé ou non, parce que pourquoi pas. 

Pour finir les events ont les champs pour les propriétés énumérés précédemment (name, description, location, start, end, poster) et quelques champs techniques (addedBy pour l’auteur, online si l’évent est validé ou pas, allDisplays si l’évent et sur tous les écrans et displays la liste d’écrans) 
Le champ displays est vide si allDisplays est vrai. Il sert uniquement à affiner la liste d’écrans où cet event apparaît si il n’est pas affiché partout. 

</p>

