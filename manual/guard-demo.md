# Guard demo #

Based on [How to Create a Custom Authentication System with Guard](http://symfony.com/doc/current/security/guard_authentication.html)

## How to start ## 

create containers

`docker-compose up -d --build --force-recreate --remove-orphans`

put sf-demo-security.prod (and sf-demo-security.dev) into VM /etc/hosts

you can get container's ips from

```
docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}} {{.Name}}' $(docker ps -aq)|sed 's/\///g'
```

or you can set up  some king of service discovery consul etc.

see other [docker snippets](../docker/README.md)

## How it works ##
