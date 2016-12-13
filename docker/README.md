run from ./docker dir

build containers

```
docker-compose up -d --build --force-recreate --remove-orphans
```

destroy containers

```
docker-compose down && docker rmi $(docker images|grep -i docker_|awk '{print $3}')
```

get app ips

```
docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}} {{.Name}}' $(docker ps -aq)|sed 's/\///g'
```

add dep into app

```
docker run -ti --rm -v /vagrant/symfony:/app composer/composer:1.0 require doctrine/doctrine-migrations-bundle "^1.1.1"
```

migrate db

```
docker exec -ti docker_back_1 bin/console d:m:m -n -vvv
```

fill db with test data

```
docker exec -ti docker_back_1 bin/console d:f:l -n --purge-with-truncate --multiple-transactions
```

clear cache

```
docker exec -ti docker_back_1 bin/console c:c -vvv [-e prod]
```
