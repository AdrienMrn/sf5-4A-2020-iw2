## Installation avec docker

- docker-compose build --no-cache
- docker-compose up -d 

Pour Windows : 
```
$ cd docker/nginx/
$ find . -name "*.sh" | xargs dos2unix
```

## Debug docker 

- docker-compose ps
- docker-compose logs -f [CONTAINER(php|node|nginx|db)]

## Commandes utiles

#####Maker
```
docker-compose exec php bin/console make:controller
docker-compose exec php bin/console make:entity
docker-compose exec php bin/console make:form
docker-compose exec php bin/console make:crud
```
#####Mise à jour de votre BDD
```
docker-compose exec php bin/console doctrine:schema:update --dump-sql
docker-compose exec php bin/console doctrine:schema:update --force
```
##Creation d'auth
```
docker-compose exec php bin/console make:user
// changer au sein de l'entity user les règles de votre table
@ORM\Table(name="user_account", schema="PROJECT_NAME")

docker-compose exec php bin/console make:auth
docker-compose exec php bin/console security:encode-password
```