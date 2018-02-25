#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U vuelos -d vuelos < $BASE_DIR/vuelos.sql
fi
psql -h localhost -U vuelos -d vuelos_test < $BASE_DIR/vuelos.sql
