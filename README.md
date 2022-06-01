# Symfony Scaffold


## Installation
 1. Install `docker` and `docker-compose` https://docs.docker.com/compose/install/
 2. Clone this repository
 3. In the project directory build and start containers
     ```
     docker-compose up -d --build
     ```
    
 4. Add the following in your hostfile `/etc/hosts`
    ```
    127.0.0.1 scaffold.local
    ```
 5. Install dependencies
    ```
    docker exec -it --user application scaffold_app composer install
    ```
 6. Verify that the application works http://scaffold.local

## Helpful Commands
### SSH into app container
```
docker exec -it --user application scaffold_app bash
```
### Flush Redis Cache
```
docker exec scaffold_redis redis-cli FLUSHALL
```
### Consume messages (Running Worked)
```
docker exec -it scaffold_app php bin/console messenger:consume async
```
