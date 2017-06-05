FROM php:7.1-apache
ADD php/*.php /var/www/html/


# Installing AWS SDK
ADD php/aws-sdk-php/ /var/www/html/aws-sdk-php/
