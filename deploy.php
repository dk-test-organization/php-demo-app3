<?php
/**
 * GitHub Webhook для автоматического деплоя через Git Pull
 */

// Секретный токен для безопасности (измените на свой)
define('WEBHOOK_SECRET', 'your_secret_token_here');

// Путь к репозиторию на сервере
define('REPO_PATH', '/home/c/co89321/public_html/test/github_cc_autodeploy');

// Лог файл
define('LOG_FILE', REPO_PATH . '/deploy.log');

// Функция для логирования
function writeLog($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message" . PHP_EOL;
    file_put_contents(LOG_FILE, $logMessage, FILE_APPEND);
}

// Получаем данные от GitHub
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// Проверяем подпись (если установлен секрет)
if (WEBHOOK_SECRET !== 'your_secret_token_here') {
    $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, WEBHOOK_SECRET);
    if (!hash_equals($expectedSignature, $signature)) {
        writeLog('ERROR: Invalid signature');
        http_response_code(403);
        die('Invalid signature');
    }
}

// Парсим данные
$data = json_decode($payload, true);

// Проверяем, что это push event
if (isset($_SERVER['HTTP_X_GITHUB_EVENT']) && $_SERVER['HTTP_X_GITHUB_EVENT'] === 'push') {
    $branch = str_replace('refs/heads/', '', $data['ref'] ?? '');

    writeLog("Received push event for branch: $branch");

    // Выполняем git pull только для master ветки
    if ($branch === 'master' || $branch === 'main') {
        writeLog("Starting deployment...");

        // Переходим в директорию репозитория и выполняем git pull
        $commands = [
            "cd " . escapeshellarg(REPO_PATH),
            "git fetch origin 2>&1",
            "git reset --hard origin/$branch 2>&1",
            "git clean -fd 2>&1"
        ];

        $output = [];
        $return_var = 0;

        foreach ($commands as $cmd) {
            exec($cmd, $output, $return_var);
            writeLog("Command: $cmd");
            writeLog("Output: " . implode("\n", $output));

            if ($return_var !== 0) {
                writeLog("ERROR: Command failed with code $return_var");
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Deployment failed']);
                exit;
            }
        }

        writeLog("Deployment completed successfully");
        echo json_encode(['status' => 'success', 'message' => 'Deployment completed']);
    } else {
        writeLog("Ignoring push to branch: $branch");
        echo json_encode(['status' => 'ignored', 'message' => "Branch $branch ignored"]);
    }
} else {
    writeLog("Not a push event, ignoring");
    echo json_encode(['status' => 'ignored', 'message' => 'Not a push event']);
}
