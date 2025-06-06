# https://hub.docker.com/layers/library/mysql/9.3.0/images/sha256-167ae6517bc1c3d0d9fb447a6fe7fce1a8d783894568433fdff6937dd076a3e1
FROM mysql:9.3.0

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
COPY ./db-access.cnf /root/db-access.cnf

EXPOSE 3306
