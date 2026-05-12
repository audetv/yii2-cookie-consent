<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $widget \audetv\cookieconsent\CookieConsentWidget */
?>

<div id="cookie-consent-widget" 
     class="cookie-consent cookie-consent-<?= $widget->position ?> cookie-theme-<?= $widget->theme ?>"
     style="--cookie-max-width: <?= $widget->maxWidth ?>px;">
    <div class="cookie-container">
        <div class="cookie-text">
            <?= $widget->getDisplayText() ?>
        </div>
        <button id="cookie-consent-btn" class="cookie-btn">
            <?= Html::encode($widget->getButtonText()) ?>
        </button>
    </div>
</div>