<?php

return [

    /*
     * Stores
     */
    'result_stores' => [
        Spatie\Health\ResultStores\EloquentHealthResultStore::class => [
            'connection' => env('HEALTH_DB_CONNECTION', env('DB_CONNECTION')),
            'model' => Spatie\Health\Models\HealthCheckResultHistoryItem::class,
            'keep_history_for_days' => 5,
        ],
    ],

    /*
     * Checks to run
     */
    'checks' => [
        // ✅ التحقق من قاعدة البيانات
        Spatie\Health\Checks\Checks\DatabaseCheck::new(),

        // ✅ التحقق من الكاش
        Spatie\Health\Checks\Checks\CacheCheck::new(),

        // ✅ التحقق من الطوابير (Queues)
        Spatie\Health\Checks\Checks\QueueCheck::new(),

        // ✅ التحقق من المساحة التخزينية
        Spatie\Health\Checks\Checks\UsedDiskSpaceCheck::new()
            ->warnWhenUsedSpaceIsAbovePercentage(70)
            ->failWhenUsedSpaceIsAbovePercentage(90),
    ],

    /*
     * باقي الإعدادات الافتراضية
     */
    'notifications' => [
        'enabled' => true,
        'notifications' => [
            Spatie\Health\Notifications\CheckFailedNotification::class => ['mail'],
        ],
        'notifiable' => Spatie\Health\Notifications\Notifiable::class,
        'throttle_notifications_for_minutes' => 60,
        'throttle_notifications_key' => 'health:latestNotificationSentAt:',
        'mail' => [
            'to' => 'your@example.com',
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'name' => env('MAIL_FROM_NAME', 'Example'),
            ],
        ],
    ],

    'theme' => 'light',
    'silence_health_queue_job' => true,
    'json_results_failure_status' => 200,
    'secret_token' => env('HEALTH_SECRET_TOKEN') ?? null,
];
