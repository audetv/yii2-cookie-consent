<?php

namespace audetv\cookieconsent;

use audetv\cookieconsent\assets\CookieConsentAsset;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\i18n\PhpMessageSource;


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
    public $maxWidth = 1320; // Максимальная ширина в пикселях

    public function init()
    {
        parent::init();
        $this->setupI18n();
    }

    protected function setupI18n()
    {
        $category = 'app';

        // Переопределяем настройки для категории 'app' ТОЛЬКО для нашего виджета
        // Используем свой basePath, но не трогаем остальные приложения
        Yii::$app->i18n->translations[$category] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'en-US',
            'basePath' => '@audetv/cookieconsent/messages',
            'forceTranslation' => true, // Принудительно переводим
        ];
    }

    protected function t($message, $params = [])
    {
        return Yii::t('app', $message, $params);
    }

    public function run()
    {
        if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] === '1') {
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

        $js = <<<JS
(function() {
    var btn = document.getElementById('cookie-consent-btn');
    if (btn) {
        btn.addEventListener('click', function() {
            var date = new Date();
            var days = {$this->cookieExpireDays};
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = "{$this->cookieName}=1; expires=" + date.toUTCString() + "; path=/; SameSite=Lax";
            
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

        return Url::toRoute('site/privacy');
    }

    public function getTermsUrl()
    {
        if ($this->termsUrl !== null) {
            return $this->termsUrl;
        }

        if (isset(Yii::$app->params['termsUrl'])) {
            return Yii::$app->params['termsUrl'];
        }

        return Url::toRoute('site/terms');
    }

    public function getPrivacyLinkText()
    {
        return $this->t('privacy_policy_link');
    }

    public function getTermsLinkText()
    {
        return $this->t('terms_link');
    }

    public function getButtonTextTranslated()
    {
        if ($this->buttonText !== null) {
            return $this->buttonText;
        }
        return $this->t('button_ok');
    }

    public function getMessageText()
    {
        if ($this->text !== null) {
            return $this->text;
        }
        return $this->t('cookie_consent_text');
    }
}
