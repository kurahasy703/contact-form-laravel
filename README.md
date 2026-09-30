お問い合わせ管理システム (Contact Form Management System)
Laravel で構築された、ユーザー向けお問い合わせフォームおよび管理者向け管理ダッシュボード・RESTful API を備えた Web アプリケーションです。

プロジェクト概要
本システムは、ユーザーからのお問い合わせ受付（入力・確認・完了）から、管理者によるお問い合わせデータの検索・抽出・タグ付け・CSV出力・API連携までを統合的に提供するシステムです。

主な機能
一般ユーザー向け（SSR / Blade）
お問い合わせ入力フォーム（リアルタイムバリデーション・エラーメッセージ日本語化）
確認画面（入力値の保持・マルチステップ状態管理）
完了画面（二重送信防止 PRG パターン適用）
管理者向け（SSR / Dashboard）
Laravel Fortify による堅牢なログイン認証
お問い合わせ一覧・絞り込み検索（キーワード・性別・カテゴリー・日付）
お問い合わせ詳細表示（モーダル表示）・削除機能
タグ管理機能（CRUD・多対多のリレーション紐付け）
CSV エクスポート機能（検索条件連動・ストリーム配信・Excel文字化け防止 UTF-8 BOM対応）
外部連携用 RESTful API
JSON Resource によるレスポンスカプセル化（GET /api/contacts, POST /api/contacts, GET /api/contacts/{id}）
標準 HTTP ステータスコード（200, 201, 422, 404）によるエラー・成功レスポンス制御
品質保証・自動テスト
PHPUnit / SQLite インメモリデータベース（:memory:）による高速 Feature テスト
Laravel Pint による PSR-12 準拠のコード自動整形
🛠️ 技術スタック
分野	技術・ツール
バックエンド	PHP 8.2 / Laravel 10.x (または 11.x)
フロントエンド	HTML5 / Tailwind CSS / Alpine.js / Vite
データベース	MySQL 8.0 (開発環境) / SQLite :memory: (テスト環境)
認証	Laravel Fortify (Headless Authentication)
開発環境	Docker / Laravel Sail / phpMyAdmin
品質管理	PHPUnit (Feature / Unit Test) / Laravel Pint
データベース設計 (ER図)
erDiagram
    users {
        bigint id PK
        string name
        string email
        string password
        timestamp created_at
        timestamp updated_at
    }
    categories {
        bigint id PK
        string content
    }
    contacts {
        bigint id PK
        bigint category_id FK
        string first_name
        string last_name
        tinyint gender
        string email
        string tel
        string address
        string building
        string detail
        timestamp created_at
        timestamp updated_at
    }
    tags {
        bigint id PK
        string name
        timestamp created_at
        timestamp updated_at
    }
    contact_tag {
        bigint id PK
        bigint contact_id FK
        bigint tag_id FK
        timestamp created_at
        timestamp updated_at
    }

    categories ||--o{ contacts : "1対多"
    contacts ||--o{ contact_tag : "1対多"
    tags ||--o{ contact_tag : "1対多"
開発環境の構築手順
1. リポジトリのクローンと環境変数の設定
git clone https://github.com/YOUR_USERNAME/contact-form-laravel.git
cd contact-form-laravel

cp .env.example .env
2. Docker (Laravel Sail) の起動
./vendor/bin/sail up -d
3. パッケージのインストールとアプリケーションキーの生成
./vendor/bin/sail composer install
./vendor/bin/sail npm install
./vendor/bin/sail artisan key:generate
4. データベースマイグレーションと初期シーディング
./vendor/bin/sail artisan migrate:fresh --seed
初期テスト用管理者アカウント

Email: test@example.com
Password: password
5. フロントエンドアセットのビルド
./vendor/bin/sail npm run dev
Web画面: http://localhost
管理者ログイン: http://localhost/login
phpMyAdmin: http://localhost:8080

テストの実行とコード整形
自動テストの実行
./vendor/bin/sail test
コードスタイルの自動整形
./vendor/bin/sail pint

Git ブランチ運用ルール (GitHub Flow)
本プロジェクトでは GitHub Flow に沿って機能ごとにブランチを作成・マージしています。

main: 常に動作可能な安定版ブランチ
feature/*: 機能ごとの開発ブランチ
ブランチ構成
feature/01-docker-setup : 開発環境構築 (Laravel Sail, phpMyAdmin)
feature/02-database-migration : マイグレーション・ER図定義
feature/04-authentication : Fortify 認証機能導入・日本語化
feature/06-form-validation : FormRequest・バリデーション日本語化
feature/08-admin-crud : 管理画面一覧・検索・詳細・削除・タグ管理
feature/10-csv-export : CSV エクスポート機能（Stream Download / BOM）
feature/11-rest-api : RESTful API 構築 (JsonResource)
feature/12-automated-test : 自動テスト (PHPUnit) ＆ Laravel Pint 整形
