# Lemon-technical-test

## Setup

Step by step :

- create your env.local file using the .env and setup your DATABASE_URL
- run 'composer install' to install all the dependencies
- run 'yarn install' to install webpack encore
- run 'php bin/console doctrine:database:create' to create the database. Or 'symfony console d:d:c' if you have the Symfony CLI installed : https://symfony.com/download#step-1-install-symfony-cli
- run 'php bin/console doctrine:migration:migrate' to execute the migration files, or 'symfony console d:m:m' with the CLI
- run 'php bin/console doctrine:fixtures:load' to load the fixtures of the User entity, or 'symfony console d:f:l' with the CLI
- launch the symfony server and webpack to start navigate

## Reminder

"
Le but est de réaliser un système qui recense les inscrits du site via leur géolocalisation.
On doit donc repérer le pays de l’internaute et si possible la région d’où il vient.
Une fois ce repérage effectué on va donner la possibilité à l’internaute de s’inscrire.
On lui demandera donc des informations basiques telles que :
Nom
Prénom
Date de naissance
E-mail
Sexe
Pays (le pays d'origine sera pré-sélectionné grâce à la géolocalisation)
Métier (Liste déroulante avec choix : cadre, employé de la fonction publique…)
Une fois ces informations remplies, l’internaute et l’administrateur du site devront recevoir un mail récapitulatif de ses informations qui fera preuve de la confirmation de réception.
Un back-office sera réalisé et devra être accessible de façon restreinte. Dans ce back-office on pourra accéder à toutes les informations des internautes inscrits groupés par pays.
L’administrateur pourra modifier les informations des internautes ainsi que supprimer ou ajouter des personnes si besoin.
L’application devra être ergonomique et responsive.
Méthodes de développement à utiliser : libre
Outils de développement à utiliser : libre"

## Project planning

I used github projects to plan to delimite the test in User Stories, then I made a repository with a main, dev and features branches with pull requests to organize my work.
Basicaly, I worked with a small Agile methodology.

## UI/UX design

I kept the UI very simple as the job offer seems mostly oriented backEnd. The administration of the application is not mobile responsive since administration interfaces are mainly used on desktop, however, I made it so you can still use it on tablet. I used the the main color of the lemon and the lemon itself from this website : https://www.lemon-interactive.fr/. To quickly make a responsive design I also used bootstrap wich I integrated directly into Symfony via the twig.yaml config file.

For the UX, the application is fully navigable with an access management for 2 roles : User and Admin. I made the choice to not make a navbar since the application is simple with few navigables pages and items.

If you need to see a thorough UX/UI design in my part, don't hesitate to tell me. I can take time starting this week-end to make a figma and make a new UI more advanced.

## Geolocation

The API I used for the geolocation feature is geoplugin : https://www.geoplugin.com/. I consumed the API with the http client component of Symfony wich I configured in the framework.yaml to scope the geoplugin uri.
GeoPlugin is capable of giving the Region but I did not implement the feature because I did not test it enough.
The autocomplation of the register form is made by setting the country code of the new user before saving it's data in the database so he can still change the country.

## Mailing

I used Mailer wich I configured in mailer.yaml with the sender adress. Then I templated to mails, one for the admin, one for the new user with his/her informations wich are sent when a new user registers.
To test this feature I used a mailer DSN called mailtrap : https://mailtrap.io

## Administration

In the admin route you can CRUD (Create Read Update Delete) any user registered to the application.
