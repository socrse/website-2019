FROM wordpress:latest

ADD themes/alchem /var/www/html/wp-content/themes/alchem
ADD themes/soc-rse /var/www/html/wp-content/themes/soc-rse

RUN chown -R www-data:www-data /var/www/html/wp-content/