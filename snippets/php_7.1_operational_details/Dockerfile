FROM php:7.1-cli
COPY ./snippets /usr/src/myapp
WORKDIR /usr/src/myapp
#RUN docker-php-ext-install -j$(nproc) mbstring
CMD [ "php", "./run_all_snippets.php" ]
