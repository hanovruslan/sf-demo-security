run from ./docker dir

```
docker-compose up -d --build --force-recreate --remove-orphans
```

```
docker-compose down && docker rmi $(docker images|grep -i docker_|awk '{print $3}')
```

```
docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}} {{.Name}}' $(docker ps -aq)|sed 's/\///g'
```

```
docker run -ti --rm -v /vagrant/symfony:/app -u www-data composer/composer:1.0 require doctrine/doctrine-migrations-bundle "^1.1.1"
```

```
docker exec -ti docker_back_1 bin/console d:m:m -n -vvv
```

```
docker exec -ti docker_back_1 bin/console d:f:l -n --purge-with-truncate --multiple-transactions
```


```
docker exec -ti docker_db_1 mysql app -uapp -papp -e "SELECT * FROM user";
```