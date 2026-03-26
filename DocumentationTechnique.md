# mediatekformation

Projet réalisé à partir du dépôt d’origine mediatekformation.  
Le dépôt d’origine présente l’application de base

## Fonctionnalités ajoutées
Dans ce projet, j’ai surtout travaillé sur la partie back office et sur les tests

Ajouts principaux :
- gestion des formations
- gestion des playlists
- gestion des catégories
- authentification pour accéder à l’administration
- contrôle de la date des formations
- blocage de la suppression d’une playlist si elle contient des formations
- blocage de la suppression d’une catégorie si elle est utilisée

## Lancer le projet en local


1. Installer les dépendances avec Composer
2. Importer la base de données
3. Lancer le projet avec :
dans un terminal : 
php -S 127.0.0.1:8000 -t public