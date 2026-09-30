## 🚀 機能概要

### 1. ユーザー向け機能 (SSR)

- **お問い合わせ入力・確認・完了画面**: 入力チェックおよび確認画面を挟む送信フロー（PRGパターン対応）
- **バリデーション & エラー復元**: 入力エラー時に `old()` ヘルパーで入力値を保持し、日本語エラーメッセージを表示

### 2. 管理者向け機能 (SSR)

- **認証機能**: Laravel Fortify を用いたセキュアなログイン・ログアウト
- **ダッシュボード**: お問い合わせ一覧表示・詳細表示・削除
- **絞り込み検索**: キーワード、性別、カテゴリ、日付指定による複数条件検索
- **タグ管理**: お問い合わせへのタグ付与およびタグ自体のCRUD操作

### 3. 応用・品質保証機能

- **CSVエクスポート**: 大量データでもメモリを圧迫しないストリーム配信（`streamDownload`）と UTF-8 BOM（Excel文字化け防止）対応
- **RESTful API**: `JsonResource` を使用したレスポンス整形および標準 HTTP ステータスコードの返却
- **自動テスト**: SQLite インメモリ環境による Feature テストの実装
- **コード整形**: Laravel Pint（PSR-12準拠）によるコードルールの統一

---

## 🛠️ 技術スタック

- **PHP**: 8.2+
- **Framework**: Laravel 10.x / 11.x
- **Frontend**: Blade (SSR), Tailwind CSS, Vite, Alpine.js
- **Database**: MySQL 8.0 (開発環境) / SQLite `:memory:` (テスト環境)
- **Infrastructure**: Docker, Laravel Sail, phpMyAdmin
- **Authentication**: Laravel Fortify

---

## 📊 データベース設計 (ER図)

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email
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
    categories ||--o{ contacts : "has"
    contacts ||--o{ contact_tag : "has"
    tags ||--o{ contact_tag : "has"

💻 セットアップ手順
1. リポジトリのクローン
git clone git@github.com:kurahasy703/contact-form-laravel.git
cd contact-form-laravel
2. 環境変数の設定
cp .env.example .env
3. Docker (Sail) の起動とパッケージインストール
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
4. データベースのセットアップ
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
🧪 テスト・コード整形
# 自動テストの実行
./vendor/bin/sail test

# コード自動整形
./vendor/bin/sail pint
🔀 Git ブランチ運用ルール
main: 安定版コードの管理
feature/*: 機能開発用ブランチ（例: feature/10-csv-export）
```
