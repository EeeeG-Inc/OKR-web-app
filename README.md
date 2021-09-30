<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# OKR アプリ
- PHP
    - 7.3
- Laravel
    - 8.0
    	- Tailwind
    	- Jetstream
- MySQL
	- 5.7.35
- Web サーバ
    - Apache 2.4.48

## 環境構築
​
- ローカル開発環境: Docker

- 本番環境: 未定
	- Terraform
		- EC2
		- RDS
		- S3
​
## 下記仕様要望
​
- Login
    - ログイン画面
    - メールアドレス変更
    - パスワード変更
- Dashboard
	- index
		- 会社・事業部・全従業員を一覧表示。NAME の横に「西暦」のセレクトボックス、「検索」ボタンをつける
	- show
		- 選択した NAME と西暦に紐づく OKR 一覧を表示: 年度 / Q1 / Q2 / Q3 / Q4 すべての OKR を表示
- OKR
	- index
		- ログインユーザ OKR 一覧表示
        - 権限がある場合は会社・事業部の OKR 一覧表示
	- create / store
		- ログインユーザ OKR 新規作成
        - 権限がある場合は会社・事業部の OKR 新規作成
		- Slack 通知すること
	- show
		- ログインユーザ OKR 詳細画面
        - 権限がある場合は会社・事業部の OKR 詳細画面
	- edit / update
		- ログインユーザ OKR / スコア更新
        - 権限がある場合は会社・事業部の OKR / スコア更新
		- スコア更新は該当四半期以降のみ入力可能とする
		- Slack 通知すること
	- delete
		- 基本的になし
		- 実装するとしても論理削除にすること
​
- ユーザIDカラムと西暦カラムと四半期カラムは複合ユニークにすること
- Admin アカウント
    - ユーザアカウントの論理削除
    - 四半期のタイムスタンプ設定
    - 会社 OKR 設定可能
    - 事業部 OKR 設定可能
    - 個人 OKR 設定可能
    - ユーザに会社 OKR / 事業部 OKR の編集権限を付与できる
​
権限は Gate の機能を使うこと
Unit テストを実装すること
main ブランチにマージする前 rebase で develop のコミットを整理すること
​
## ライブラリ
​
下記ライブラリを composer インストール・利用すること
​
- aws/aws-sdk-php-laravel
- barryvdh/laravel-debugbar
- barryvdh/laravel-ide-helper
- bensampo/laravel-enum
- guzzlehttp/guzzle
- laravelcollective/html
- livewire/livewire
​
## Git 運用
​
- Git-Flow

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
