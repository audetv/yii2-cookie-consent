<?php

namespace audetv\cookieconsent;

use yii\base\Widget;

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
    
    public function init()
    {
        parent::init();
        // Проверка cookie будет здесь
    }
    
    public function run()
    {
        return 'Cookie Consent Widget - in development';
    }
}