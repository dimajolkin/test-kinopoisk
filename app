#!/bin/bash

LOCAL_UID=$(id -g $USER)

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
   docker-compose run --user=${LOCAL_UID} web sh -c \
     'composer install && ./vendor/bin/phinx migrate && npm i && npm run build'
exit 1
fi

