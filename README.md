## このリポジトリについて
テストが書きづらいプロダクトコード、書きやすいプロダクトコードを比較、検証するために作成した。  
* プロダクトコード：[src/app/Http/Controllers/GetNowController.php](src/app/Http/Controllers/GetNowController.php)
* テストコード：[src/tests/Unit/GetNowTest.php](src/tests/Unit/GetNowTest.php)

## 環境設定、ローカル立ち上げ
* Docker Desktop がインストールされていること
* ローカル環境にPHPやComposerをインストールする必要はありません（Dockerコンテナ内で実行されます）

```bash
docker compose up -d --build
docker compose exec php composer install
```

## テスト実行

### 全テスト実行
```bash
docker compose exec php php artisan test
```

## テスト結果
* **3つのテストケース**が実行される
* 1つの失敗テスト（DIなしの場合）
* 2つの成功テスト（DIあり、Carbon使用）
