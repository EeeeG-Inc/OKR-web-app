<?php

return [
    'admin' => [
        'proxy_login' => '「:name」として代理ログインしました',
        'update' => 'システム管理者の更新が完了しました',
    ],
    'company' => [
        'store' => '会社アカウントの登録が完了しました',
        'update' => '会社アカウントの更新が完了しました',
    ],
    'company_group' => [
        'update' => '種別変更が完了しました',
        'update_confirm' => ':nameが「親会社」となり、現在の親会社は「子会社」として変更されますがよろしいでしょうか？',
        'update_failed' => '親会社の変更に失敗しました',
        'update_success' => '親会社の変更に成功しました',
    ],
    'department' => [
        'store' => '部署アカウントの登録が完了しました',
        'update' => '部署アカウントの更新が完了しました',
    ],
    'manager' => [
        'store' => 'マネージャアカウントの登録が完了しました',
        'update' => 'マネージャアカウントの更新が完了しました',
    ],
    'member' => [
        'store' => '一般アカウントの登録が完了しました',
        'update' => '一般アカウントの更新が完了しました',
    ],
    'objective' => [
        'store' => 'OKR の登録が完了しました',
        'update' => 'OKR の更新が完了しました',
        'delete_confirm' => '「:objective」および「該当する成果指標」を削除してもよろしいでしょうか？',
        'delete_failed' => '「:objective」および「該当する成果指標」の削除に失敗しました',
        'delete_success' => '「:objective」および「該当する成果指標」の削除に成功しました',
    ],
    'user' => [
        'password' => '半角英数字と記号をそれぞれ 1 種類以上含めた 8 文字以上 32 文字以下のパスワードを設定してください'
    ],
    'quarter' => [
        'store' => '四半期区分の登録が完了しました',
        'update' => '四半期区分の更新が完了しました',
    ],
    'slack' => [
        'store' => 'Slack Webhook URL の登録が完了しました',
        'update' => 'Slack Webhook URL の更新が完了しました',
        'stop' => 'Slack 通知を停止しました',
        'restart' => 'Slack 通知を再開しました',
    ],
];
