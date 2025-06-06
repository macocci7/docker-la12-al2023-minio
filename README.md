# Docker environment with Laravel12, Amazon Linux 2023 and MinIO

Skelton of docker environment with Laravel12, Amazon Linux 2023 and MinIO

## Verified platform

- Ubuntu 24.04.4 LTS (WSL2 on Windows11)

## Requirement

- [Docker](https://www.docker.com/) installed
- [PHP](https://www.php.net/) 8.2 or later installed
- [Comnposer](https://getcomposer.org/) v2 installed
- [mkcert](https://github.com/FiloSottile/mkcert) installed

## Containers to be built

- al2023: [Amazon Linux 2023](https://hub.docker.com/layers/library/amazonlinux/2023.7.20250512.0/images/sha256-52aa6628323e60216e3006169661ad958ba0b7f6cb8ff269a2b96eb4563e24a7) ([nginx](https://nginx.org/) / [PHP 8.4.8](https://www.php.net/ChangeLog-8.php#8.4.8) / [Laravel 12](https://laravel.com/docs/12.x))
- mysql: [MySQL Server 9.3.0](https://hub.docker.com/layers/library/mysql/9.3.0/images/sha256-167ae6517bc1c3d0d9fb447a6fe7fce1a8d783894568433fdff6937dd076a3e1)
- mailpit: [axllent/mailpit:v1.25.1](https://hub.docker.com/layers/axllent/mailpit/v1.25.1/images/sha256-1e87e790c5e0ada29ef682dbd185c59a270fbd31b088aa2fdeffa3cd795fe10c)
- minio: [minio/minio:RELEASE.2025-05-24T17-08-30Z](https://hub.docker.com/layers/minio/minio/RELEASE.2025-05-24T17-08-30Z/images/sha256-bca5c8a966b9adede74c531db519fa0ac9e4684b824fde9707ac558314590818)

## Project file structure

<pre>
[Project top]
　├─ bin/                [Commands]
　├─ docker/             [Fixtures for docker]
　│　　├─ mailpit/data  [Mailpit data]
　│　　├─ minio/data    [MinIO data]
　│　　├─ mysql/data    [MySQL data]
　│　　├─ laravel/      [Prepared files for Laravel]
　│　　└─ tests/        [Initial environment tests]
　├─ dump/               [For mysqldump]
　├─ html/               [Laravel 12 project]
　├─ include/            [Shell scripts for commands]
　└─ docker-compose.yml  [Docker settings]
</pre>

## Building Containers

Add a line below into `hosts` file on your host OS.

- linux/mac: `/etc/hosts`
- windows: `C:\Windows\System32\drivers\etc\hosts`

```
127.0.0.1       minio
```

Then, run the command below to build and start containers.

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

## Commands

- `bin/al-root`: connects to root shell on `al2023` container.
- `bin/al-user`: connects to user shell on `al2023` container.
- `bin/artisan`: runs artisan command on `al2023` container.
- `bin/buildup`: builds and starts containers.
- `bin/change-permissions`: chnages file[folder] permissions under `/var/www/html` on `al2023` container.
- `bin/colorize-test` : tests colorizable functions.
- `bin/commands` : lists commands, or show details of commands.
- `bin/html-cleanup`: removes all files and directories under `html/`.
- `bin/initial-settings`: performs initial settings on `al2023` container.
- `bin/laravel-new`: creates Laravel 12 project in `html/` on your host.
- `bin/mailpit-root`: connects to root shell on `mailpiit` container.
- `bin/minio-connect`: connects to mysql database `laravel`.
- `bin/minio-cleanup`: clears whole MinIO data.
- `bin/minio-root`: connects to root shell on `minio` container.
- `bin/mysql-cleanup`: clears whole MySQL data.
- `bin/mysql-export`: exports MySQL data from `mysql` container.
- `bin/mysql-import`: imports MySQL data into `mysql` container.
- `bin/mysql-root`: connects to root shell on `mysql` container.
- `bin/mysql-sql`: runs sql on `mysql` container.
- `bin/startup`: starts containers.
- `bin/stop`: stops containers.

To see more details, run the command:

```bash
bin/commands
```

## LICENSE

[MIT](LICENSE)
