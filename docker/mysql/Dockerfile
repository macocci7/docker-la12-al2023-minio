# https://hub.docker.com/layers/library/mysql/8.4.4/images/sha256-d895a591bdc9fbd228dc75f4859791160f321b839bad18bba44811834143b0c4
FROM mysql:8.4.4

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
COPY ./db-access.cnf /root/db-access.cnf
RUN mkdir /root/bin
COPY ./bin/import-data /root/bin/import-data
COPY ./bin/export-data /root/bin/export-data
RUN chmod +x /root/bin/*

EXPOSE 3306

# Run the command below after the container starts running.
# docker compose exec mysql /root/import-data
RUN echo "Building MySQL Server container has been completed."
RUN echo "Now you can import data with the command below."
RUN echo "docker compose exec mysql /root/import-data"
