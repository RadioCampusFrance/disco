# Disco, deuxième du nom

L'application qui gère la discothèque de [Campus Grenoble](https://campusgrenoble.org)!

Elle est faite pour faciliter la programmation musicale collaborative.
L'appli garde une trace des milliers de disques sur les étagères de la radio,
mais aussi des sélections de morceaux et leur évaluation.
On peut ensuite les transmettre aux labels, au réseau Campus France ou au public.

Disco permet de:

 * répertorier les Albums/EPs/Compilations/Singles
 * les retrouver par artiste, par label, par style(s), par langue(s), par support
 * distinguer quelles pistes sont en Français, dans l'automate de diffusion, ou recommandées aux animateurs
 * publier [l'Airplay](https://campusgrenoble.org/airplay/) du moment
 * imprimer des paquets d'étiquettes (pour conserver les supports physiques)
 * faire un retour d'écoute et de sélection par e-mail au(x) label(s)

Dans Disco on distingue trois rôles. Le principal est celui de Programmateur, il
permet notamment de renseigner de nouveaux disques/artistes/labels, de les noter/commenter et
d'éditer un airplay. Le second rôle permet la consultation, et le troisième la gestion des accès.


## Installation

Disco est basée sur le framework [Symfony](https://symfony.com/), et requiert PHP 5.5 et MySQL.

Créer les tables dans la base de données et importer les données de base :
tout est dans le script docs/sql/base_vide.sql

Ensuite rendez-vous à http://monserver/disco/install pour créer le premier utilisateur.

Adaptez l'e-mail envoyé aux labels : app/Resources/views/mails/retour-label.txt.twig .

## Licence

Disco est distribuée sous licence MIT (voir License.md).
