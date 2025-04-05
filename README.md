# Docker environment with Laravel12, Amazon Linux 2023 and MinIO

Skelton of docker environment with Laravel12, Amazon Linux 2023 and MinIO

## Requirement

- [Docker](https://www.docker.com/) installed

## Containers to be built

- al2023: [Amazon Linux 2023](https://hub.docker.com/layers/library/amazonlinux/2023.7.20250331.0/images/sha256-d2b7c9c18d23a992c5364d51f3ec62f4e5d47b6d0b6dfc35078104d414fe48ba) ([nginx 1.26.3](https://nginx.org/en/CHANGES-1.26) / [PHP 8.4.5](https://www.php.net/ChangeLog-8.php#8.4.5) / [Laravel 12](https://laravel.com/docs/12.x))
- mysql: [MySQL Server 8.4.4](https://hub.docker.com/layers/library/mysql/8.4.4/images/sha256-d895a591bdc9fbd228dc75f4859791160f321b839bad18bba44811834143b0c4)
- mailpit: [axllent/mailpit:v1.24.0](https://hub.docker.com/layers/axllent/mailpit/v1.24.0/images/sha256-15cb8c9cc529859e9f1dd82833a170181bd5650db0a447a05f07b306899a9b2e)
- minio: [minio/minio:RELEASE.2025-03-12T18-04-18Z](https://hub.docker.com/layers/minio/minio/RELEASE.2025-03-12T18-04-18Z/images/sha256-85f3e4cd1ca92a2711553ab79f222bcd8b75aa2c77a1a0b0ccf80d38e8ab2fe5)

## Building Containers

```bash
docker compose up -d
```
