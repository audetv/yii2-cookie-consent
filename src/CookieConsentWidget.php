<?php

namespace audetv\cookieconsent;

use Yii;
use yii\base\Widget;
use audetv\cookieconsent\assets\CookieConsentAsset;

class CookieConsentWidget extends Widget
{
    public $text;
    public $buttonText;
    public $privacyPolicyUrl;
    public $termsUrl;
    public $cookieName = 'cookie_consent_accepted';
    public $cookieExpireDays = 365;
    public $theme = 'light';
    public $position = 'bottom';
    public $registerCss = true;

    private $shouldRender = true;

    public function init()
    {
        parent::init();
        self::registerTranslations();

        // Проверяем, есть ли уже cookie согласия
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has($this->cookieName)) {
            $this->shouldRender = false;
        }
    }

    public function run()
    {
        if (!$this->shouldRender) {
            return '';
        }

        $this->registerAssets();

        return $this->render('consent', [
            'widget' => $this,
        ]);
    }

    protected function registerAssets()
    {
        $view = $this->view;
        CookieConsentAsset::register($view);

        // Регистрируем JavaScript для обработки клика
        $js = <<<JS
(function() {
    var btn = document.getElementById('cookie-consent-btn');
    if (btn) {
        btn.addEventListener('click', function() {
            var date = new Date();
            var days = {$this->cookieExpireDays};
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = "{$this->cookieName}=1; expires=" + date.toUTCString() + "; path=/";
            
            var widget = document.getElementById('cookie-consent-widget');
            if (widget) {
                widget.style.display = 'none';
            }
        });
    }
})();
JS;
        $view->registerJs($js);
    }

    public function getPrivacyUrl()
    {
        if ($this->privacyPolicyUrl !== null) {
            return $this->privacyPolicyUrl;
        }

        if (isset(Yii::$app->params['privacyUrl'])) {
            return Yii::$app->params['privacyUrl'];
        }

        return '/privacy-policy';
    }

    public function getTermsUrl()
    {
        if ($this->termsUrl !== null) {
            return $this->termsUrl;
        }

        if (isset(Yii::$app->params['termsUrl'])) {
            return Yii::$app->params['termsUrl'];
        }

        return '/terms-of-use';
    }

    public static function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['app'])) {
            Yii::$app->i18n->translations['app'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@audetv/cookieconsent/messages',
            ];
        }
    }
}
