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

### Прямым копированием (если Composer не работает)

Скопируйте папку `src/` в `@app/components/cookieconsent/` и добавьте в `config/web.php`:

```php
Yii::setAlias('@audetv/cookieconsent', '@app/components/cookieconsent');
```

## ⚙️ Быстрое подключение

В основном layout (`views/layouts/main.php`) перед закрывающим тегом `</body>`:

```php
use audetv\cookieconsent\CookieConsentWidget;

echo CookieConsentWidget::widget();
```

После этого виджет появится внизу страницы со стандартными настройками.

## 🎨 Настройка

Все параметры можно передать прямо в `widget()`.

### Основные параметры

| Параметр | Тип | По умолчанию | Описание |
|----------|-----|--------------|----------|
| `theme` | string | `'light'` | Тема оформления: `light` или `dark` |
| `position` | string | `'bottom'` | Положение: `bottom` или `top` |
| `maxWidth` | int | `1320` | Максимальная ширина виджета (в пикселях) |
| `buttonText` | string | `'Хорошо'` | Текст на кнопке |
| `text` | string | `null` | Свой текст сообщения (если не нужен стандартный) |
| `privacyPolicyUrl` | string | `null` | Ссылка на Политику конфиденциальности |
| `termsUrl` | string | `null` | Ссылка на Пользовательское соглашение |
| `cookieName` | string | `'cookie_consent_accepted'` | Имя cookie для хранения согласия |
| `cookieExpireDays` | int | `365` | Срок жизни cookie (в днях) |
| `registerCss` | bool | `true` | Подключать встроенные стили (`false` — отключить) |

### Приоритет ссылок на документы

1. Параметр, переданный в виджет (`privacyPolicyUrl` / `termsUrl`)
2. Параметр приложения (`Yii::$app->params['privacyUrl']` / `Yii::$app->params['termsUrl']`)
3. Значение по умолчанию (`/privacy-policy` / `/terms-of-use`)

### Примеры настройки

#### Минимальная настройка (только ссылки)

```php
echo CookieConsentWidget::widget([
    'privacyPolicyUrl' => '/page/privacy',
    'termsUrl' => '/page/terms',
]);
```

#### Тёмная тема и свой текст кнопки

```php
echo CookieConsentWidget::widget([
    'theme' => 'dark',
    'buttonText' => 'Понятно',
]);
```

#### Полностью свой текст

```php
echo CookieConsentWidget::widget([
    'text' => 'Мы используем cookie для улучшения работы сайта. Нажимая "ОК", вы соглашаетесь с этим.',
    'buttonText' => 'ОК',
]);
```

#### Bootstrap 4/5 (ширина 1140px)

```php
echo CookieConsentWidget::widget([
    'maxWidth' => 1140,
]);
```

#### Отключение встроенных стилей (своя вёрстка)

```php
echo CookieConsentWidget::widget([
    'registerCss' => false,
]);
```

## 🌍 Локализация (i18n)

Виджет автоматически использует язык приложения (`Yii::$app->language`).  
Если язык равен `'ru-RU'` — текст будет на русском, если `'en-US'` — на английском.

Файлы переводов лежат в `src/messages/`.  
При желании вы можете переопределить их в своём приложении.

## 🎨 Стилизация

### Кастомизация через CSS

Если нужно изменить стили (но оставить встроенные), переопределите классы:

- `.cookie-consent` — основной контейнер
- `.cookie-container` — внутренний контейнер с ограничением ширины
- `.cookie-theme-light` / `.cookie-theme-dark` — темы
- `.cookie-text` — блок с текстом
- `.cookie-btn` — кнопка

Пример в вашем `web/css/site.css`:

```css
.cookie-consent {
    background-color: #f0f0f0;
}

.cookie-btn {
    background-color: #28a745;
}
```

### Полная своя вёрстка

Если нужно полностью переопределить HTML и CSS, отключите встроенные стили и напишите свои:

```php
echo CookieConsentWidget::widget([
    'registerCss' => false,
    'text' => 'Ваш HTML с <a href="/policy">ссылкой</a>',
]);
```

## 🧪 Тестирование

### Локальный тестовый сервер

```bash
cd tests/app
php -S localhost:8080 -t web
```

Откройте `http://localhost:8080` — вы увидите виджет.

### Проверка cookie

1. Откройте инструменты разработчика (F12) → вкладка **Application** → **Cookies**
2. Нажмите на кнопку виджета
3. Должна появиться cookie `cookie_consent_accepted` со значением `1`
4. Обновите страницу — виджет должен исчезнуть

## 📦 Структура пакета

```
yii2-cookie-consent/
├── src/
│   ├── CookieConsentWidget.php      # Основной класс виджета
│   ├── assets/
│   │   ├── CookieConsentAsset.php   # Asset bundle
│   │   └── css/
│   │       └── cookie-consent.css   # Стили по умолчанию
│   ├── views/
│   │   └── consent.php              # HTML-шаблон
│   └── messages/                    # Файлы переводов
│       ├── ru-RU/
│       │   └── app.php
│       └── en-US/
│           └── app.php
├── composer.json
└── README.md
```

## 🐛 Возможные проблемы

### Виджет не исчезает после нажатия

- Проверьте, что в браузере не отключены cookie
- Очистите кеш браузера и cookie вручную
- Проверьте консоль браузера на наличие ошибок JavaScript

### Текст не переводится

- Убедитесь, что в конфигурации приложения указан язык: `Yii::$app->language = 'ru-RU'`
- Проверьте, что файлы переводов есть в `src/messages/`

### Конфликт с другими переводами категории `app`

В виджете используется категория `app` с указанием своего `basePath`. Это безопасно для большинства проектов.  
Если возник конфликт, создайте свою категорию (например, `cookieconsent`) и измените код в `setupI18n()`.

## 📄 Лицензия

MIT — используйте как хотите.
