# blog personnel


### Installation du Projet


- 1 -
   Clonez ce dépot ou téléchargez directement l'archive.
- 2 -
   Modifiez si nécessaire les variables d'environnement (.env) et la config
   (par défaut server Apache 2.4.39, php 7.3.7, MySQL 8.0.16, smtp:1025 pour l'email)
- 3 -
   Depuis la racine du répertoire, lancez la commande "composer install" afin d'installer les dépendances nécessaires
- 4 -
  Assurez-vous de ne pas avoir de base de donnée portant le nom "blog" puis lancez ces commandes :
    "php bin/console doctrine:database:create"
    "php bin/console doctrine:migrations:migrate"
    "php bin/console doctrine:fixtures:load"
- 5 -
  Vous pouvez vous inscrire directement ou bien utiliser ces identifiants d'utilisateurs:
    - user%d%@email.com (%d% entre 0 et 19)
    - password

  Vous pouvez désormais vous connecter avec des droits administrateurs avec ces identifiants:
    - admin%d%@email.com (%d% entre 0 et 2)
    - admin
- 6 -
  Profitez des fonctionnalités et n'hésitez pas à me faire un retour si des améliorations sont possibles
  ou si des problèmes sont rencontrés!
