# Инструкция по настройке автоматического деплоя

## Шаг 1: Настройка Git репозитория на сервере

Подключитесь к серверу по SSH и выполните:

```bash
cd /home/c/co89321/public_html/test/github_cc_autodeploy
git init
git remote add origin https://github.com/dk-test-organization/php-demo-app3.git
git fetch origin
git checkout -b master origin/master
```

## Шаг 2: Настройка прав доступа

Убедитесь, что веб-сервер имеет права на выполнение git команд:

```bash
chmod -R 755 /home/c/co89321/public_html/test/github_cc_autodeploy
```

## Шаг 3: Настройка GitHub Webhook

1. Перейдите в настройки репозитория: https://github.com/dk-test-organization/php-demo-app3/settings/hooks
2. Нажмите "Add webhook"
3. Заполните поля:
   - **Payload URL**: `https://ваш-домен.ru/deploy.php` (замените на реальный URL)
   - **Content type**: `application/json`
   - **Secret**: укажите секретный токен (и обновите его в deploy.php в константе WEBHOOK_SECRET)
   - **Events**: выберите "Just the push event"
4. Нажмите "Add webhook"

## Шаг 4: Проверка работы

После настройки webhook, каждый push в ветку master будет автоматически деплоиться на сервер.

Логи деплоя можно посмотреть в файле:
```
/home/c/co89321/public_html/test/github_cc_autodeploy/deploy.log
```

## Важно

- Убедитесь, что на сервере установлен Git
- Веб-сервер должен иметь права на выполнение git команд
- Для безопасности обязательно измените WEBHOOK_SECRET в deploy.php
