FROM php:8.0.12-cli-buster
COPY . /var/www/html
WORKDIR /var/www/html

LABEL maintainer="Dragomir Turcanu"

ARG WWWGROUP

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y curl zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python3 \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && apt-get update \
    && apt-get install -y mariadb-client \
    && apt-get install -y poppler-utils \
    && apt-get install -y tesseract-ocr \
    && apt-get install -y tesseract-ocr-nld \
    && apt-get install -y ocrmypdf \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*