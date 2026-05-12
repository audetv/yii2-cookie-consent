<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $widget \audetv\cookieconsent\CookieConsentWidget */

$privacyLink = Html::a(
    $widget->getPrivacyLinkText(),
    $widget->getPrivacyUrl(),
    ['target' => '_blank', 'rel' => 'noopener noreferrer']
);

$termsLink = Html::a(
    $widget->getTermsLinkText(),
    $widget->getTermsUrl(),
    ['target' => '_blank', 'rel' => 'noopener noreferrer']
);
?>

<div id="cookie-consent-widget" 
     class="cookie-consent cookie-consent-<?= $widget->position ?> cookie-theme-<?= $widget->theme ?>"
     style="--cookie-max-width: <?= $widget->maxWidth ?>px;">
    <div class="cookie-container">
        <div class="cookie-text">
            <?= $widget->getMessageText() ?> <?= $privacyLink ?> и <?= $termsLink ?>.
        </div>
        <button id="cookie-consent-btn" class="cookie-btn">
            <?= $widget->getButtonTextTranslated() ?>
        </button>
    </div>
</div>