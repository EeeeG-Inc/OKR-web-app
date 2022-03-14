# Laracel OKR App

[Google](https://rework.withgoogle.com/jp/guides/set-goals-with-okrs/steps/grade-OKRs/) が提供しているスコアカードを Web アプリにしました

## Getting Started

- PHP
    - 7.3
- Laravel
    - 8.75.0
- https://github.com/EeeeG-Inc/OKR-server
  - 上記リポジトリを clone すると、下記を利用いただけます
    - Linode に Ubuntu 21.10 を構築する Terraform
    - Ubuntu 21.10 で Laracel OKR App を実行させるための Ansible

```sh
chmod 777 /storage/app/public/profiles

# 初期テーブルデータ作成
php artisan migrate:fresh --seed

# プロフィール画像にアクセスするためのシンボリックリンク作成
php artisan storage:link
```

- システム管理者アカウントが作成されます。パスワード・メールアドレス変更を行ってください
- 初回メールアドレス
  - `admin@example.com`
- 初回パスワード
  - `password`

## 開発

### テストデータ作成

```sh
php artisan command:test-data
```

### phpinsights

```sh
# 実行
php artisan insights
```

### larastan

`phpstan.neon` に静的解析の設定を記述する

```sh
# 実行
./vendor/bin/phpstan analyse
./vendor/bin/phpstan analyse --memory-limit=2G
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
