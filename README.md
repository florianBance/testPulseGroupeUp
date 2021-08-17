# Test 

## start project

PHP 7.3 require 
```
macos : brew install shivammathur/php/php@7.3
```

Installer Symfony CLI
```
macos : curl -sS https://get.symfony.com/cli/installer | bash
windows : https://get.symfony.com/cli/setup.exe
linux : wget https://get.symfony.com/cli/installer -O - | bash
```

Démarrer le serveur
```
symfony serve
```

url d'acces
```
http://127.0.0.1:8000 
```
 
 ## Installation
 Installer les dépendances
 ```
 composer install
 composer update
 ```
Créer la base de donnée
la chaine de connexion a la BDD ce trouve dans le fichier .env.local
 ```
 DATABASE_URL="mysql://root:@127.0.0.1:3306/testTechFb?serverVersion=10.4.10-MariaDB"
 ```
 ```
 php bin/console doctrine:database:create
 ```
Mettre à jour le fichier de migration de la base de donnée
 ```
 php bin/console make:migration
 ```
Valider et mettre à jour Base de donnée
 ```
 php bin/console doctrine:migrations:migrate
 ```
Charger fixtures par raport au fichier brut csv
 ```
 php bin/console doctrine:fixtures:load
 ```
