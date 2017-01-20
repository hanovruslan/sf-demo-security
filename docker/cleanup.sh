#!/usr/bin/env bash

EXITED=$(docker ps -q -f status=exited)
DANGLING=$(docker images -q -f "dangling=true")
VOLUMES=$(docker volume ls -qf dangling=true)

if [ "$1" != "--force" ]; then
    echo "==> Would stop containers:"
    echo $EXITED
    echo "==> And images:"
    echo $DANGLING
    echo "==> clean volumes:"
    echo "$VOLUMES"
else
    if [ -n "$EXITED" ]; then
        docker rm $EXITED
    else
        echo "No containers to remove."
    fi
    if [ -n "$DANGLING" ]; then
        docker rmi $DANGLING
    else
        echo "No images to remove."
    fi
    if [ -n "$VOLUMES" ]; then
        echo $VOLUMES|xargs -r docker volume rm
    else
        echo "No images to remove."
    fi
fi
