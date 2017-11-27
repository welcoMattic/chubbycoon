FROM chubbycoon_basephp

# Extra
RUN apk --update add nginx php7-fpm runit && \
    rm -rf /var/cache/apk/*

# Service
COPY nginx/run /etc/service/nginx/run
COPY php-fpm/run /etc/service/php-fpm/run

# Configuration
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY php-fpm/fpm.conf /etc/php7/php-fpm.conf

RUN chown -R chubbycoon:chubbycoon /var/lib/nginx

EXPOSE 80

# Default command
CMD ["runsvdir", "-P", "/etc/service"]
