FROM mysql:8.0

#copy sql to run a default db on first crete (optinal)
COPY ./init-db.sql /tmp

# run command
CMD [ "mysqld", "--init-file=/tmp/init-db.sql" ]