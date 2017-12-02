FROM chubbycoon_basephp

RUN apk --update add curl python py2-pip mariadb-client nodejs make g++ php7-phar git yarn && \
    rm -rf /var/cache/apk/*

RUN chown -R chubbycoon /usr/local /usr/bin /usr/lib

USER chubbycoon

# Install pep8
RUN pip install pep8

# Install composer
RUN curl https://getcomposer.org/composer.phar > /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

RUN composer global require "friendsofphp/php-cs-fixer:^2.4" "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --optimize-autoloader --classmap-authoritative \
&& composer clear-cache

# Add composer global binaries to $PATH
ENV PATH $PATH:/home/chubbycoon/.composer/vendor/bin/
ENV TERM xterm

WORKDIR /home/chubbycoon/app

CMD ["echo"]
