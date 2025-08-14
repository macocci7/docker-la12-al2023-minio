# https://hub.docker.com/layers/library/mysql/9.4.0/images/sha256-aaae6655f7e4ffb05fb9820075721bfaaf737144ed95e9b9fe0e20583a7a3568
FROM mysql:9.4.0

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
COPY ./db-access.cnf /root/db-access.cnf

EXPOSE 3306
