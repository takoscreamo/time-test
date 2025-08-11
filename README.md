## このリポジトリについて
テストが書きづらいプロダクトコード、書きやすいプロダクトコードを比較、検証するために作成した。  
* プロダクトコード：[src/app/Http/Controllers/GetNowController.php](src/app/Http/Controllers/GetNowController.php)
* テストコード：[src/tests/Unit/GetNowTest.php](src/tests/Unit/GetNowTest.php)

## 実装の特徴

### 3つのアプローチ
1. **DIなし（テストが書きづらい）**: 内部でクラスをインスタンス化
2. **DIあり（テストが書きやすい）**: 依存性注入を使用
3. **Carbon使用（テストが書きやすい）**: ライブラリのテスト時間固定機能を使用

### 改善された実装
- 型宣言の追加（PHP 7.4+）
- メソッド名の英語化
- PHPDocコメントの追加
- Unitテストによる軽量なテスト構成

## 環境設定、ローカル立ち上げ
* Docker Desktop がインストールされていること
* ローカル環境にPHPやComposerをインストールする必要はありません（Dockerコンテナ内で実行されます）

```bash
docker compose up -d --build
docker compose exec php composer install
```

#### http://localhost:8080/ でブラウザにアクセス

## テスト実行

### 全テスト実行
```bash
docker compose exec php php artisan test
```

### Unitテストのみ実行
```bash
docker compose exec php php artisan test tests/Unit/GetNowTest.php --verbose
```

### PHPUnit直接実行（Unitテスト）
```bash
docker compose exec php ./vendor/bin/phpunit --testsuite=Unit --testdox
```

## テスト結果
* **3つのテストケース**が実行される
* 1つの失敗テスト（DIなしの場合）
* 2つの成功テスト（DIあり、Carbon使用）

## 学習ポイント
- DIパターンによるテストの書きやすさ
- モックオブジェクトの使用方法
- Carbonライブラリのテスト時間制御
- Unitテストによる軽量なテスト構成
- テストの独立性とクリーンアップの重要性

## テストの種類について

### Unitテスト（推奨）
- **目的**: コントローラーのロジックのみをテスト
- **特徴**: 軽量で高速、外部依存を排除
- **適している**: 単体のクラスやメソッドのテスト

### Featureテスト
- **目的**: フレームワーク全体の統合テスト
- **特徴**: データベース、セッション、ミドルウェアも含む
- **適している**: エンドツーエンドの動作確認
