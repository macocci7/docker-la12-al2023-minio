ARG amazonlinux_version="2023.7.20250331.0"
ARG nginx_version="1.26.3"
ARG php_version="8.4.5"

FROM amazonlinux:${amazonlinux_version}

RUN dnf update \
    && dnf install \
    systemd \
    systemd-devel \
    tar \
    zip \
    unzip \
    sudo \
    yum \
    procps-ng \
    net-tools \
    which \
    vim \
    git \
    -y

# create user
RUN useradd "ec2-user" && echo "ec2-user ALL=NOPASSWD: ALL" >> /etc/sudoers

# install nginx
RUN dnf install -y nginx:${nginx_version}
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./nginx/php.conf /etc/nginx/default.d/php.conf
COPY ./nginx/php-fpm.conf /etc/nginx/conf.d/php-fpm.conf

# install php
RUN dnf install \
    autoconf \
    automake \
    bison \
    bzip2-devel \
    gcc \
    gcc-c++ \
    libtool \
    libcurl-devel \
    libjpeg-devel \
    libicu-devel \
    libpng-devel \
    libwebp-devel \
    libxml2-devel \
    make \
    oniguruma-devel \
    openssl-devel \
    readline-devel \
    sqlite-devel \
    -y

WORKDIR /root
RUN curl https://www.php.net/distributions/php-${php_version}.tar.gz -o php-${php_version}.tar.gz \
    && tar xvfz php-${php_version}.tar.gz \
    && cd php-${php_version} \
    && ./configure \
        --prefix=/usr/local/php \
        --with-bz2 \
        --with-curl=/usr \
        --with-fpm-group=nginx \
        --with-fpm-systemd \
        --with-fpm-user=nginx \
        --with-jpeg \
        --with-libdir=lib64 \
        --with-libxml \
        --with-mysqli=mysqlnd \
        --with-openssl \
        --with-pdo-mysql=mysqlnd \
        --with-pdo-sqlite \
        --with-readline \
        --with-webp \
        --with-zlib \
        --with-zlib-dir=/usr \
        --enable-mbstring \
        --enable-exif \
        --enable-gd \
        --enable-cgi \
        --enable-fpm \
        --enable-bcmath \
        --enable-phpdbg \
        --disable-debug \
    && make \
    && make install \
    && ln -s /usr/local/php/bin/php /usr/bin/php \
    && ln -s /usr/local/php/bin/phpize /usr/bin/phpize \
    && ln -s /usr/local/php/sbin/php-fpm /usr/sbin/php-fpm \
    && mv /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf \
    && mv /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf \
    && php -v \
    && php-fpm -v

# install composer
WORKDIR /root
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && mv composer.phar /usr/local/bin/composer \
    && composer --version

# install nodejs
WORKDIR /root
RUN curl -fsSL https://rpm.nodesource.com/setup_22.x -o nodesource_setup.sh \
    && bash nodesource_setup.sh \
    && dnf install nodejs -y \
    && node -v

# install for HTTPS@localhost
WORKDIR /root
RUN dnf install -y nss-tools \
    && curl -JLO "https://dl.filippo.io/mkcert/latest?for=linux/amd64" \
    && chmod +x mkcert-v*-linux-amd64 \
    && cp mkcert-v*-linux-amd64 /usr/local/bin/mkcert \
    && mkcert --version \
    && mkcert -install \
    && mkcert -cert-file /etc/nginx/conf.d/localhost.pem -key-file /etc/nginx/conf.d/localhost-key.pem localhost

# install mysql client
RUN dnf install -y mariadb105

# install Supervider via pip
RUN dnf install -y python3-pip \
    && pip3 install supervisor
COPY ./supervisord.conf /etc/supervisor/conf.d/
COPY ./systemd/supervisord.service /etc/systemd/system/

COPY ./php-fpm/php-fpm.conf /usr/local/php/etc/
COPY ./php-fpm/www.conf /usr/local/php/etc/php-fpm.d/

COPY ./systemd/systemd-networkd-wait-online.service /usr/lib/systemd/system/

RUN mkdir /root/bin
COPY ./bin/* /root/bin/

RUN chmod +x /root/bin/* \
    && /root/bin/initial-user-settings

WORKDIR /var/www/html

# starting process
CMD ["/sbin/init"]

EXPOSE 80
EXPOSE 443
