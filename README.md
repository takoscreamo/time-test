## このリポジトリについて
テストが書きづらいプロダクトコード、書きやすいプロダクトコードを比較、検証するために作成した。  
* プロダクトコード：src/app/Http/Controllers/GetNowController.php
* テストコード：src/tests/Feature/GetNowTest.php

## 環境設定、ローカル立ち上げ
```
$ cd src  
$ composer install  
$ docker compose up -d --build  
```
#### http://localhost:8080/ でブラウザにアクセス

## FeatureTest実行
```
$ docker compose exec php ./vendor/bin/phpunit --testsuite=Feature --testdox  
```
* NGケースが1件、OKケースが2件実行される
