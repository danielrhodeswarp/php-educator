FROM php:5.6.30-cli
COPY ./snippets /usr/src/myapp
WORKDIR /usr/src/myapp
#RUN docker-php-ext-install -j$(nproc) mbstring
CMD [ "php", "./run_all_snippets.php" ]
