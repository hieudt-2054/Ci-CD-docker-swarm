FROM reg01.dev.01cloud.com:5000/alpine:private

ENV \
  APP_DIR="/project" \
  APP_PORT="80"

# the "app" directory (relative to Dockerfile) containers your Laravel app...
##COPY app/ $APP_DIR
# or we can make the volume in compose to say use this directory 

RUN apk update && \
    apk add curl \
    php7 \
    php7-opcache \
    php7-openssl \
    php7-pdo \
    php7-json \
    php7-phar \
    php7-dom \
    php7-curl \
    php7-mbstring \
    php7-tokenizer \
    php7-xml \
    php7-xmlwriter \
    php7-session \
    php7-ctype \
    php7-mysqli \
    php7-pdo \
    php7-pdo_mysql\
    && rm -rf /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- \
  --install-dir=/usr/bin --filename=composer

##RUN cd $APP_DIR && composer install

RUN mkdir /apps
COPY ./project /apps
RUN cd /apps && composer install

WORKDIR /apps

RUN chmod -R 775 storage
RUN chmod -R 775 bootstrap

copy ./run.sh /tmp
ENTRYPOINT ["/tmp/run.sh"]

