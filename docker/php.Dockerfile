FROM php:8.2-cli-alpine3.17
RUN apk add --no-cache tini composer
ENTRYPOINT ["/sbin/tini", "--"]
WORKDIR /app
