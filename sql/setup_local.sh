#!/bin/sh

SCRIPTS_DIR=/home/djp/prog/metristart/sql
DB=metristart
DB_OWNER=metristart_owner
DB_PASS=bob
SQL_COMMAND="mysql -u $DB_OWNER -p$DB_PASS $DB"

if [ $PWD != $SCRIPTS_DIR ]; then
  echo "Please cd to $SCRIPTS_DIR"
  exit 1
fi

for f in teardown setup testdata; do
  $SQL_COMMAND < $f.sql
done

