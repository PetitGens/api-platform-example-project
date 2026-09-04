ARG BASE_IMAGE
FROM ${BASE_IMAGE:-php:8.4-alpine}

ARG INSTALL_XDEBUG

# Script pour installer des extensions PHP
COPY ./docker-php-ext-install /usr/local/bin/docker-php-ext-install
COPY ./docker-php-ext-enable /usr/local/bin/docker-php-ext-enable

# Install required packages
# - libicu-dev is required for intl
# - autoconf is required for using pecl
# - gcc, linux-headers and make are required to install xdebug with pecl
# - musl-dev is required to build anything with gcc
RUN apk update && apk add \
  icu-dev \
  autoconf \
  gcc \
  musl-dev \
  linux-headers \
  make

# Installation des extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql intl

# Installation de paquets utiles
RUN apk update && apk add bash git

# Install XDEBUG
RUN if [ "$INSTALL_XDEBUG" ]; then pecl install xdebug; fi
RUN docker-php-ext-enable xdebug
