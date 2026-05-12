# Yii2 Cookie Consent Widget

Виджет для отображения уведомления об использовании cookie-файлов на сайте.  
После нажатия кнопки согласия устанавливается cookie, и виджет больше не показывается.

## 📋 Требования

- PHP 7.1 – 8.3
- Yii2 ~2.0

## 🚀 Установка

### Через Composer (рекомендуется)

Добавьте репозиторий в `composer.json` вашего проекта:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/audetv/yii2-cookie-consent"
    }
]
```

Затем выполните:

```bash
composer require audetv/yii2-cookie-consent:dev-main
```

### Прямым копированием

Скопируйте папку `src/` в `@app/components/cookieconsent/` и добавьте в `config/web.php`:

```php
Yii::setAlias('@audetv/cookieconsent', '@app/components/cookieconsent');
```

## ⚡ Быстрое подключение

В основном layout (`views/layouts/main.php`) перед закрывающим тегом `</body>`:

```php
use audetv\cookieconsent\CookieConsentWidget;

echo CookieConsentWidget::widget();
```

## 🎛️ Параметры виджета

| Параметр | Тип | По умолчанию | Описание |
|----------|-----|--------------|----------|
| `theme` | string | `'light'` | Тема: `light` или `dark` |
| `position` | string | `'bottom'` | Позиция: `bottom` или `top` |
| `maxWidth` | int | `1320` | Максимальная ширина (пиксели) |
| `cookieName` | string | `'cookie_consent_accepted'` | Имя cookie для согласия |
| `cookieExpireDays` | int | `365` | Срок жизни cookie (дни) |
| `registerCss` | bool | `true` | Подключать встроенные стили |
| `parseMarkdown` | bool | `true` | Парсить Markdown-ссылки в кастомном тексте |
| `language` | string | `null` | Принудительный язык (если не указан — из приложения) |

## 📝 Настройка текста и кнопки

### Режим 1: Стандартный текст (из переводов)

Виджет автоматически использует переводы из `src/messages/`:

```php
echo CookieConsentWidget::widget();
// Результат: "На сайте используются cookie-файлы... Политике конфиденциальности и Пользовательском соглашении."
```

### Режим 2: Свой текст (строка) без ссылок

```php
echo CookieConsentWidget::widget([
    'text' => 'Мы используем cookie для улучшения работы сайта.',
    'buttonText' => 'Понятно',
]);
```

### Режим 3: Свой текст с Markdown-ссылками

```php
echo CookieConsentWidget::widget([
    'text' => 'Мы используем cookie. Подробнее в [Политике конфиденциальности](/privacy) и [Пользовательском соглашении](/terms).',
]);
```

Ссылки открываются в новой вкладке.

### Режим 4: Markdown-ссылки с подсказками (tooltips)

```php
echo CookieConsentWidget::widget([
    'text' => 'Читайте [правила](/rules "Правила сайта") и [документацию](/docs "Техническая документация").',
]);
```

### Режим 5: Мультиязычный текст (массив)

```php
echo CookieConsentWidget::widget([
    'text' => [
        'ru' => 'Мы используем cookie-файлы для анализа трафика.',
        'en' => 'We use cookies to analyze traffic.',
    ],
    'buttonText' => [
        'ru' => 'OK',
        'en' => 'OK',
    ],
]);
```

Язык определяется автоматически из `Yii::$app->language`.

### Режим 6: Смешанный (русский — кастомный, английский — стандартный)

```php
echo CookieConsentWidget::widget([
    'text' => [
        'ru' => 'Только для русского свой текст с [моей ссылкой](/my-link).',
    ],
    // Для английского используется стандартный текст из переводов
]);
```

### Режим 7: Отключение парсинга Markdown

```php
echo CookieConsentWidget::widget([
    'text' => 'Текст с [обычными] скобками, которые не должны быть ссылкой',
    'parseMarkdown' => false,
]);
```

## 🔗 Настройка ссылок на документы

### Для стандартного режима (без кастомного текста)

```php
echo CookieConsentWidget::widget([
    'privacyPolicyUrl' => '/privacy',
    'termsUrl' => '/terms',
]);
```

### Мультиязычные ссылки

```php
echo CookieConsentWidget::widget([
    'privacyPolicyUrl' => [
        'ru' => '/privacy-policy',
        'en' => '/en/privacy-policy',
    ],
    'termsUrl' => [
        'ru' => '/terms-of-use',
        'en' => '/en/terms-of-use',
    ],
]);
```

### Приоритет получения ссылок

1. Параметр виджета (`privacyPolicyUrl` / `termsUrl`)
2. Параметр приложения (`Yii::$app->params['privacyUrl']` / `Yii::$app->params['termsUrl']`)
3. Значение по умолчанию (`/privacy-policy` / `/terms-of-use`)

## 🎨 Кастомизация стилей

### Через CSS-классы

- `.cookie-consent` — основной контейнер
- `.cookie-container` — внутренний контейнер (ограничение ширины)
- `.cookie-theme-light` / `.cookie-theme-dark` — темы
- `.cookie-text` — блок с текстом
- `.cookie-btn` — кнопка

Пример в вашем `web/css/site.css`:

```css
.cookie-consent {
    background-color: #f8f9fa;
}

.cookie-btn {
    background-color: #28a745;
}

.cookie-btn:hover {
    background-color: #218838;
}
```

### Отключение встроенных стилей

```php
echo CookieConsentWidget::widget([
    'registerCss' => false,
]);
```

## 🌍 Принудительный язык

```php
echo CookieConsentWidget::widget([
    'language' => 'en-US', // Всегда английский, независимо от языка приложения
]);
```

## 📦 Полный пример с настройками

```php
echo CookieConsentWidget::widget([
    'theme' => 'dark',
    'position' => 'bottom',
    'maxWidth' => 1140,
    'text' => [
        'ru' => 'Мы используем cookie. Подробнее в [политике](/privacy "Как мы используем данные") и [правилах](/terms "Условия использования").',
        'en' => 'We use cookies. Learn more in our [privacy policy](/privacy "How we use data") and [terms](/terms "Terms of use").',
    ],
    'buttonText' => [
        'ru' => 'Согласен',
        'en' => 'I agree',
    ],
    'cookieExpireDays' => 365,
]);
```

## 🧪 Тестирование

### Локальный тестовый сервер

```bash
cd tests/app
php -S localhost:8080 -t web
```

### Проверка работы

1. Откройте `http://localhost:8080`
2. Виджет должен появиться внизу страницы
3. Нажмите на кнопку — виджет исчезнет
4. Обновите страницу — виджет больше не показывается
5. Очистите cookie в инструментах разработчика — виджет снова появится

## 📂 Структура пакета

```
yii2-cookie-consent/
├── src/
│   ├── CookieConsentWidget.php      # Основной класс
│   ├── assets/
│   │   ├── CookieConsentAsset.php
│   │   └── css/
│   │       └── cookie-consent.css
│   ├── views/
│   │   └── consent.php
│   └── messages/                    # Переводы
│       ├── ru-RU/
│       │   └── app.php
│       └── en-US/
│           └── app.php
├── composer.json
└── README.md
```

## 🐛 Частые проблемы

### Виджет не исчезает после нажатия

- Проверьте, что cookie не заблокированы браузером
- Очистите кеш и cookie вручную
- Откройте консоль браузера (F12) на наличие ошибок JavaScript

### Текст на неправильном языке

- Проверьте `Yii::$app->language` в конфигурации
- Или передайте параметр `language` в виджет

### Конфликт переводов с приложением

Виджет переопределяет категорию `app` для своих переводов. Если в приложении уже используется эта категория, проверьте, что ваши переводы не затираются. При необходимости измените категорию в коде виджета.

## 📄 Лицензия

MIT — используйте как хотите.
