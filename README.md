# Projet Symfony - semaine 2
Réalisation d'une application symfony **4.4** durant une session de cours.

Etapes à suivre pour installer:

1) Cloner le repo Git
```sh
git clone https://github.com/Zoubir78/symfony-sem2.git
```

2) Installer les dépendances PHP
```sh
composer install
```

3) Installer les dépendances JS
```sh
yarn install
```

4) Compiler les ressources front (CSS, JS)
```sh
yarn encore dev
```

5) Créer si nécessaire la base de données
```sh
bin/console doctrine:database:create
```

6) Executer les migrations de BDD
```sh
bin/console doctrine:migrations:migrate
```
