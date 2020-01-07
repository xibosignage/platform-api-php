FROM php:7.4-cli

COPY . /usr/src/myapp

WORKDIR /usr/src/myapp

ENV XIBO_PLATFORM_CLIENT_ID ""
ENV XIBO_PLATFORM_CLIENT_SECRET ""
ENV XIBO_PLATFORM_URL ""

CMD [ "php", "./vendor/bin/phpunit" ]