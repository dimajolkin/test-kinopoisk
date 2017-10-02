#!/bin/bash

if [[ $1 = "start" ]]
then
docker-compose up -d web
exit 1
fi

if [[ $1 = "stop" ]]
then
docker-compose stop web
exit 1
fi

if [[ $1 = "build" ]]
then
   docker-compose build && \
   docker-compose run web --user=${USER} sh -c \
     'composer install && composer phinx migrate && npm i && npm run build'
exit 1
fi

