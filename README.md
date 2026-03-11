# Flea Market Application

## 概要

本プロジェクトは、ユーザーが商品を出品・閲覧・購入できるフリマアプリケーションです。
Laravelを用いたWebアプリケーションとして開発しており、ユーザー認証、商品出品、商品一覧表示、商品購入などの基本的なフリマ機能を実装します。

主な機能は以下の通りです。

* ユーザー登録 / ログイン
* 商品一覧表示
* 商品詳細表示
* 商品出品
* 商品購入
* マイリスト表示

---

## 使用技術

| 分類      | 技術                      |
| ------- | ----------------------- |
| フレームワーク | Laravel                 |
| 言語      | PHP                     |
| フロントエンド | HTML / CSS / JavaScript |
| データベース  | MySQL                   |
| バージョン管理 | Git / GitHub            |
| 開発環境    | Docker（またはローカル環境）       |

---

## ER図

![ER図](./docs/er-diagram.png)

---
## 環境構築

### 1. リポジトリをクローン

```bash
git clone git@github.com:izumiyuki214/Flea-Market.git
cd Flea-Market
```

---

### 2. Composer依存関係インストール

```bash
composer install
```

---

### 3. 環境変数ファイル作成

```bash
cp .env.example .env
```

---

### 4. アプリケーションキー生成

```bash
php artisan key:generate
```

---

### 5. データベース設定

`.env` ファイルの以下を設定します。

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flea_market
DB_USERNAME=root
DB_PASSWORD=
```

---

### 6. マイグレーション実行

```bash
php artisan migrate
```

---

### 7. アプリケーション起動

```bash
php artisan serve
```

ブラウザで以下にアクセスします。

```
http://localhost:8000
```

---

## ディレクトリ構成（主要）

```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
```

---

## 今後の実装予定

* 商品検索機能
* お気に入り機能
* 画像アップロード機能
* 決済機能

---

## ライセンス

This project is licensed for educational purposes.
