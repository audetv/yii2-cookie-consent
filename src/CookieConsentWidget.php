<?php

namespace audetv\cookieconsent;

use Yii;
use yii\base\Widget;
use yii\i18n\PhpMessageSource;
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
    public $maxWidth = 1320;
    public $language;
    
    public function init()
    {
        parent::init();
        $this->setupI18n();
    }
    
    protected function setupI18n()
    {
        // Всегда переопределяем категорию 'app' для виджета
        Yii::$app->i18n->translations['app'] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'en-US',
            'basePath' => '@audetv/cookieconsent/messages',
            'forceTranslation' => true,
        ];
    }
    
    protected function t($message, $params = [])
    {
        $language = $this->language ?: Yii::$app->language;
        return Yii::t('app', $message, $params, $language);
    }
    
    /**
     * Получение локализованного значения параметра
     * @param string|array|null $param
     * @return string|null
     */
    protected function getLocalizedValue($param)
    {
        if ($param === null) {
            return null;
        }
        
        if (is_string($param)) {
            return $param;
        }
        
        if (is_array($param)) {
            $currentLanguage = $this->language ?: Yii::$app->language;
            
            if (isset($param[$currentLanguage])) {
                return $param[$currentLanguage];
            }
            
            $defaultLanguage = Yii::$app->language;
            if (isset($param[$defaultLanguage])) {
                return $param[$defaultLanguage];
            }
            
            return reset($param);
        }
        
        return null;
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
        $value = $this->getLocalizedValue($this->privacyPolicyUrl);
        
        if ($value !== null) {
            return $value;
        }
        
        if (isset(Yii::$app->params['privacyUrl'])) {
            $paramValue = $this->getLocalizedValue(Yii::$app->params['privacyUrl']);
            if ($paramValue !== null) {
                return $paramValue;
            }
            return Yii::$app->params['privacyUrl'];
        }
        
        return '/privacy-policy';
    }
    
    public function getTermsUrl()
    {
        $value = $this->getLocalizedValue($this->termsUrl);
        
        if ($value !== null) {
            return $value;
        }
        
        if (isset(Yii::$app->params['termsUrl'])) {
            $paramValue = $this->getLocalizedValue(Yii::$app->params['termsUrl']);
            if ($paramValue !== null) {
                return $paramValue;
            }
            return Yii::$app->params['termsUrl'];
        }
        
        return '/terms-of-use';
    }
    
    public function getPrivacyLinkText()
    {
        return $this->t('privacy_policy_link');
    }
    
    public function getTermsLinkText()
    {
        return $this->t('terms_link');
    }
    
    public function getButtonText()
    {
        $value = $this->getLocalizedValue($this->buttonText);
        
        if ($value !== null) {
            return $value;
        }
        
        return $this->t('button_ok');
    }
    
    public function getMessageText()
    {
        $value = $this->getLocalizedValue($this->text);
        
        if ($value !== null) {
            return $value;
        }
        
        return $this->t('cookie_consent_text');
    }
}