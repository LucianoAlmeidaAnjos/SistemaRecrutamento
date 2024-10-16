# Dockerfile para Laravel
FROM php:8.0-fpm

# Instala as extensões do PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto para o contêiner
COPY . .

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala as dependências do Laravel
RUN composer install

# Expondo a porta 9000
EXPOSE 9000

CMD ["php-fpm"]
