<?php

return [
    'appDir' => APP_DIR,    // Папка с рабочими файлами
    'webDir' => WEB_DIR,    // Папка доступная из web
    'database' => require(__DIR__ . '/db.php'),
    'globalEncoding' => 'UTF-8',
    'debug' => true,
];
