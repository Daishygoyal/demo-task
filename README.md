Requirements

1. PHP 8.2
2. MySql
3. Composer 2
4. symfony cli
5. Node 16

Steps to install backend

1. Clone repo
2. Go to project Directory
3. Run command "composer install"
4. In .env change database credentials with your system credentials
5. Run command "php bin/console doctrine:database:create"
6. Run command "php bin/console doctrine:migrations:migrate"
7. To import all Fruits run command "php bin/console fruits:fetch"
    Admin Email will be sent to "fruits-admin-test@yopmail.com"
8. To run server run command "symfony server:start"
    It will start server on "http://localhost:8000"


Steps to install backend


1. In a new terminal run command "npm install"
2. run command "npm run dev-server"
    you can access frontend at "http://localhost:8000"