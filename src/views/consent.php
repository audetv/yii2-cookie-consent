<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $widget \audetv\cookieconsent\CookieConsentWidget */

$isCustomText = ($widget->text !== null);

if ($isCustomText) {
    // Пользователь передал свой текст
    $messageText = $widget->getMessageText();
} else {
    // Стандартный текст со ссылками
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
    
    $messageText = $widget->getMessageText() . ' ' . $privacyLink . ' и ' . $termsLink . '.';
}
?>

<div id="cookie-consent-widget" 
     class="cookie-consent cookie-consent-<?= $widget->position ?> cookie-theme-<?= $widget->theme ?>"
     style="--cookie-max-width: <?= $widget->maxWidth ?>px;">
    <div class="cookie-container">
        <div class="cookie-text">
            <?= $messageText ?>
        </div>
        <button id="cookie-consent-btn" class="cookie-btn">
            <?= Html::encode($widget->getButtonText()) ?>
        </button>
    </div>
</div>