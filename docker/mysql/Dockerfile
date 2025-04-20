# https://hub.docker.com/layers/library/mysql/8.4.4/images/sha256-d895a591bdc9fbd228dc75f4859791160f321b839bad18bba44811834143b0c4
FROM mysql:8.4.5

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
COPY ./db-access.cnf /root/db-access.cnf

EXPOSE 3306
