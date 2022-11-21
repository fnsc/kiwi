You will need Docker and Docker Compose to use this. You can install Docker for Windows which includes Docker Compose or if you have a linux environment install it there.

Place these files in a directory and from that directory you can run the following commands to interact with the containers. 

To launch the two containers run:

    docker-compose up 

You can add the `-d` flag to put it in the background if you don't want to watch the output

To stop it run:

    docker-compose stop

To enter the php apache container to run symfony CLI commands:

    docker-compose exec php-apache-environment /bin/bash

Setup your git user: 

    git config --global user.email "you@example.com"
    git config --global user.name "Your Name"

Install Symfony: 

    symfony new . --webapp

Once it is installed you can reach the default symfony intro page at:

    http://localhost:7171/

To connect to the database you will need to use this url in the symfony `.env` file:

    DATABASE_URL="mysql://db-user:db-password@db:3306/symfony?serverVersion=8&charset=utf8mb4"

The code will be accessible from the `app` folder that will be created by the containers starting up.
