<div class="page-content">
    <h2>Добро пожаловать в наше приложение!</h2>

    <div class="info-box">
        <h3>🚀 Демо-приложение с автоматическим деплоем на Timeweb</h3>
        <p>Это PHP приложение демонстрирует современный CI/CD процесс с использованием GitHub Actions и FTP деплоя.</p>
        <p><strong>Статус:</strong> Автодеплой настроен и работает! ✅</p>
    </div>

    <div class="features">
        <h3>Реализованные возможности:</h3>
        <ul>
            <li>✅ Версионирование через Git</li>
            <li>✅ Хранение кода на GitHub</li>
            <li>✅ Автоматический деплой через GitHub Actions</li>
            <li>✅ FTP синхронизация с сервером Timeweb</li>
            <li>✅ Безопасное хранение секретов</li>
            <li>✅ Простая и расширяемая структура</li>
            <li>✅ Быстрый деплой (~15-20 секунд)</li>
        </ul>
    </div>

    <div class="next-steps">
        <h3>Как работает автодеплой:</h3>
        <ol>
            <li>Внесите изменения в код локально</li>
            <li>Закоммитьте: <code>git commit -am "Описание изменений"</code></li>
            <li>Отправьте на GitHub: <code>git push origin master</code></li>
            <li>GitHub Actions автоматически запустит деплой</li>
            <li>Через 15-20 секунд изменения появятся на сервере!</li>
        </ol>
    </div>

    <div class="info-box" style="margin-top: 20px; background-color: #e8f5e9;">
        <h3>📊 Текущая версия</h3>
        <p>Последнее обновление: <?php echo date('d.m.Y H:i'); ?></p>
        <p>PHP версия: <?php echo phpversion(); ?></p>
    </div>
</div>
