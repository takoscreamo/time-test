## このリポジトリについて
テストが書きづらいプロダクトコード、書きやすいプロダクトコードを比較、検証するために作成した。  
* プロダクトコード：src/app/Http/Controllers/GetNowController.php
* テストコード：src/tests/Feature/GetNowTest.php

## 前提事項
* Docker Desktop がインストールされていること
* ローカル環境にPHPやComposerをインストールする必要はありません（Dockerコンテナ内で実行されます）

## 環境設定、ローカル立ち上げ
```
$ docker compose up -d --build  
$ docker compose exec php composer install  
```
#### http://localhost:8080/ でブラウザにアクセス

## FeatureTest実行
```
$ docker compose exec php ./vendor/bin/phpunit --testsuite=Feature --testdox  
```
* NGケースが1件、OKケースが2件実行される