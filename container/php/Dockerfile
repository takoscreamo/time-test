# ベースイメージの指定（PHP 8.2 + FPM）
FROM php:8.2-fpm

# 作成した設定ファイルをコンテナ内にコピー
COPY ./container/php/php.ini /usr/local/etc/php/php.ini

# パッケージのインストール
RUN apt-get update \
    && apt-get -y install git zip unzip vim libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Xdebugのインストール
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Composerのインストール（最新版）
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# コンテナ内で作業する際のカレントディレクトリの指定
WORKDIR /var/www/html