# Docker environment with Laravel12, Amazon Linux 2023 and MinIO

Skelton of docker environment with Laravel12, Amazon Linux 2023 and MinIO

## Verified platform

- Ubuntu 24.04.2 LTS (WSL2)

## Requirement

- [Docker](https://www.docker.com/) installed
- [PHP](https://www.php.net/) 8.2 or later installed
- [Comnposer](https://getcomposer.org/) v2 installed
- [mkcert](https://github.com/FiloSottile/mkcert) installed

## Containers to be built

- al2023: [Amazon Linux 2023](https://hub.docker.com/layers/library/amazonlinux/2023.7.20250331.0/images/sha256-d2b7c9c18d23a992c5364d51f3ec62f4e5d47b6d0b6dfc35078104d414fe48ba) ([nginx](https://nginx.org/) / [PHP 8.4.5](https://www.php.net/ChangeLog-8.php#8.4.5) / [Laravel 12](https://laravel.com/docs/12.x))
- mysql: [MySQL Server 8.4.4](https://hub.docker.com/layers/library/mysql/8.4.4/images/sha256-d895a591bdc9fbd228dc75f4859791160f321b839bad18bba44811834143b0c4)
- mailpit: [axllent/mailpit:v1.24.0](https://hub.docker.com/layers/axllent/mailpit/v1.24.0/images/sha256-15cb8c9cc529859e9f1dd82833a170181bd5650db0a447a05f07b306899a9b2e)
- minio: [minio/minio:RELEASE.2025-03-12T18-04-18Z](https://hub.docker.com/layers/minio/minio/RELEASE.2025-03-12T18-04-18Z/images/sha256-85f3e4cd1ca92a2711553ab79f222bcd8b75aa2c77a1a0b0ccf80d38e8ab2fe5)

## Project file structure

<pre>
[Project top]
　├─ bin/                [Commands]
　├─ docker/             [Fixtures for docker]
　│　　├─ mailpit/data  [Mailpit data]
　│　　├─ minio/data    [MinIO data]
　│　　└─ mysql/data    [MySQL data]
　├─ dump/               [For mysqldump]
　├─ html/               [Laravel 12 project]
　├─ include/            [Shell scripts for commands]
　├─ laravel/            [Prepared files for Laravel]
　├─ tests/              [Initial environment tests]
　└─ docker-compose.yml  [Docker settings]
</pre>

## Building Containers

Run the command below to build and start containers.

```bash
bin/buildup
```

This command performs:
- checking essential commands
- clearing mysql data directory
- clearing minio data directory
- clearing html directory
- creating a new Laravel 12 project into html directory
- copying .env.local to .env
- layouting Laravel files for environment testing.
- creating TLS certs for MinIO
- building containers
- running initial settings
    - database migration (MySQL)
    - setting permissions
    - enabling and booting services
- running environment tests
    - Laravel test (`bin/artisan test`)
    - SMTP test (`bin/artisan mail:send`)
    - Queue test (`bin/artisan mail:queue`)
    - Storage upload test (`bin/artisan minio:put`)
    - Storage reading test (`bin/artisan minio:get`)

## URLs

- Web: [https://localhost/](https://localhost/)
- Mailpit: [http://localhost:8025/](http://localhost:8025/)
- MinIO: [https://localhost:9001/](https://localhost:9001/)
    - Username: `minio`
    - Password: `minio123`

    [https://minio:9001/](https://minio:9001/)

    is also available after adding a line below into `hosts` file on your host OS.
    - linux/mac: `/etc/hosts`
    - windows: `C:\Windows\System32\drivers\etc\hosts`
    ```
    127.0.0.1       minio
    ```
## Commands

- `bin/al-root`: connects to root shell on `al2023` container.
- `bin/al-user`: connects to user shell on `al2023` container.
- `bin/artisan`: runs artisan command on `al2023` container.
- `bin/buildup`: builds and starts containers.
- `bin/change-permissions`: chnages file[folder] permissions under `/var/www/html` on `al2023` container.
- `bin/colorize-test` : tests colorizable functions.
- `bin/create-project`: creates Laravel 12 project in `html/` on your host.
- `bin/commands` : lists commands, or show details of commands.
- `bin/export-data`: exports MySQL data from `mysql` container.
- `bin/import-data`: imports MySQL data into `mysql` container.
- `bin/initial-settings`: performs initial settings on `al2023` container.
- `bin/mailpit-root`: connects to root shell on `mailpiit` container.
- `bin/minio-cleanup`: clears whole MinIO data.
- `bin/minio-root`: connects to root shell on `minio` container.
- `bin/mysql-cleanup`: clears whole MySQL data.
- `bin/mysql-root`: connects to root shell on `mysql` container.
- `bin/mysql-sql`: runs sql on `mysql` container.
- `bin/startup`: starts containers.

To see more details, run the command:

```bash
bin/commands
```

## LICENSE

[MIT](LICENSE)
