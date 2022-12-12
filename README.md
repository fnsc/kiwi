## Stack
- [PHP 8.1](https://www.php.net);
- [Symfony](https://symfony.com/);
- [PHPUnit](https://phpunit.de/);
- [Docker](https://docker.com);

## Running the Application Locally
Steps:
1. ```shell
   git clone git@github.com:fnsc/kiwi.git
   ```
1. ```shell
   docker-compose build --no-cache web
   ```
1. ```shell
   docker-compose run web composer install
   ```
1. ```shell
   docker-compose up web -d
   ```
1. ```shell
   docker-compose web symfony console doctrine:migrations:migrate
   ```
1. ```shell
   docker-compose web symfony console doctrine:fixtures:load
   ```
1. ```shell
   docker-compose run node yarn install
   ```
1. ```shell
   docker-compose run node yarn dev
   ```

Finally access [http://localhost:7171](http://localhost:7171).