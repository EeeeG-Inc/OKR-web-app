# Laracel OKR App

- PHP
    - 7.3
- Laravel
    - 8.75.0

## 環境構築

```sh
# 初期テーブルデータ作成
 php artisan migrate:fresh --seed
```

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
