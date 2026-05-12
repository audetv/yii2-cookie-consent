<?php

namespace audetv\cookieconsent\assets;

use yii\web\AssetBundle;

class CookieConsentAsset extends AssetBundle
{
    public $sourcePath = '@audetv/cookieconsent/assets';
    
    public $css = [
        'css/cookie-consent.css',
    ];
    
    public $js = [];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
}