# dossoagri
Bienvenu sur le site du projet DOSSIAGRI

## Personnes concernées
DOSSO Agri est une initiative qui a pour but de mettre en relation :

* Les petits agriculteurs ;
* Les acheteur finaux ;
* Et les pouvoir publics et ONG qui travaillent dans l'agriculture.

## Objectifs de la plateforme DOSSOAGRI
Aujourd'hui, la plateforme permet de :
* Aider les agriculteurs à réguler leur production en fonction du climat et du marché
* Cartographier les zones agricoles exploitables du Niger avec les caractéristiques liées a la zone et proposer des types de culture propice a la zone
* Permettre aux éleveurs et agriculteurs de connaitre les points d'eau et mettre en place un système de réservation pour faciliter l’accès a la ressource.

## Architecture
Pour l'architecture, rien de mieux que les [micro services] Il faut faire plein de petites appli avec plein de langages et les faire communiquer par Web services. C'est fini les grosses appli avec 50us.

Du coup pour le premier pavé voici la vision (à mettre-à-jour) :
* Application SMS pour les fonctionnalités agriculteurs ;
* Application Web pour les internautes (négociation de prix des recoltes postés) ;
* Application autre pour le reste (par exemple le template WPF d'Alain )

## Développement
* Faire pointer Apache sur le repertoire /public
* Dans le fichier .htaccess qui se trouve dans le repertoire /public, 
    * utiliser la sytaxe suivante (dans le cas où le site est déployé dans le repertoire /dossoagri)
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes...
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ /dossoagri/index.php [L]
</IfModule>
```

    * utiliser la sytaxe suivante (dans le cas où le site est déployé dans le repertoire /)

```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes...
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## En savoir plus
* [Le Wiki](https://github.com/defus/dossoagri/wiki)
* Twitter
* ...
