#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE vuelos_test;"
    psql -U postgres -c "CREATE USER vuelos PASSWORD 'vuelos' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists vuelos
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists vuelos_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists vuelos
    sudo -u postgres psql -c "CREATE USER vuelos PASSWORD 'vuelos' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O vuelos vuelos
    sudo -u postgres createdb -O vuelos vuelos_test
    LINE="localhost:5432:*:vuelos:vuelos"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi
