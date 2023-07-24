# Composer prerequirements
FROM composer:latest as composerbuild

RUN mkdir /workdir && chown nobody:nobody /workdir
USER nobody
WORKDIR /workdir
COPY --chown=nobody composer.json /workdir
COPY --chown=nobody composer.lock /workdir
RUN composer install --ignore-platform-reqs --no-scripts

# npm prerequirements
FROM node:latest as npmbuild

RUN mkdir /workdir && chown node:node /workdir
USER node
WORKDIR /workdir
COPY --chown=node . /workdir
RUN npm install --no-audit && npm run build

# Build pull-journal-central

FROM php:8.2.6-fpm-alpine
LABEL maintainer="Apfelwurm<Alexander@volzit.de>"

ENV PHP_Timezone="Europe/Berlin"
ENV TZ="Europe/Berlin"

#versioning
ARG BUILDNUMBER
ENV BUILDNUMBER=$BUILDNUMBER
ARG BUILDID
ENV BUILDID=$BUILDID
ARG SOURCE_COMMIT
ENV SOURCE_COMMIT=$SOURCE_COMMIT
ARG BUILDNODE
ENV BUILDNODE=$BUILDNODE

COPY docker/fpm-pool.conf /etc/php8/php-fpm.d/www.conf
COPY --chown=nobody docker/php.ini /etc/php8/conf.d/99-pull-journal-central.ini
COPY docker/start-container /usr/local/bin/start-container
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/wait-for.sh /usr/local/bin/wait-for.sh
COPY docker/start-supervisord /usr/local/bin/start-supervisord

RUN chmod +x /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/wait-for.sh
RUN chmod +x /usr/local/bin/start-supervisord

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions bcmath pdo_mysql

RUN apk --no-cache add nginx supervisor curl tzdata dcron bash

RUN rm /etc/nginx/http.d/default.conf
COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Set working directory
WORKDIR /var/www/html

RUN chown -R nobody.nobody /var/www/html && \
  chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/log/nginx

USER nobody
WORKDIR /var/www/html
COPY --chown=nobody . /var/www/html/
RUN rm -rf /var/www/html/docker* && rm -rf /var/www/html/docs* 
COPY --from=composerbuild --chown=nobody /workdir/vendor /var/www/html/vendor
COPY --from=npmbuild --chown=nobody /workdir/node_modules /var/www/html/node_modules
COPY --from=npmbuild --chown=nobody /workdir/public/css /var/www/html/public/css
COPY --from=npmbuild --chown=nobody /workdir/public/js /var/www/html/public/js
COPY --from=npmbuild --chown=nobody /workdir/public/mix-manifest.json /var/www/html/public/mix-manifest.json


EXPOSE ${NGINX_PORT}

ENTRYPOINT ["start-container"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=20s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
