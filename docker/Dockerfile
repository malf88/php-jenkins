FROM php:7.2-fpm
MAINTAINER Marco Aurélio <malf88@gmail.com>

WORKDIR /var/www

COPY ./ /var/www/
#COPY ./docker/cacert.pem /usr/lib/ssl/cacert.pem

ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
#ENV APACHE_DOCUMENT_ROOT /var/www/
#RUN sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys <PUBKEY>
ARG BUILD_APP_ENV
RUN cp /var/www/docker/local/php.ini /usr/local/etc/php/php.ini

RUN apt-get update && apt-get -y upgrade && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        nano \
        libxml2-dev \
        git \
        libzip-dev && \
    docker-php-ext-install \
        bcmath \
        calendar \
        sockets && \
    php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

#COPY ./docker/cron.sh /usr/local/bin/start

#RUN chmod u+x /usr/local/bin/start

COPY ./docker/www.conf /usr/local/etc/php-fpm.d/www.conf

#CMD ["/usr/local/bin/start"]

# By default start up apache in the foreground, override with /bin/bash for interative.
