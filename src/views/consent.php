<?php
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $widget \audetv\cookieconsent\CookieConsentWidget */

$privacyLink = Html::a(
    \Yii::t('app', 'privacy_policy_link'),
    $widget->getPrivacyUrl(),
    ['target' => '_blank', 'rel' => 'noopener noreferrer']
);

$termsLink = Html::a(
    \Yii::t('app', 'terms_link'),
    $widget->getTermsUrl(),
    ['target' => '_blank', 'rel' => 'noopener noreferrer']
);

$text = $widget->text ?? \Yii::t('app', 'cookie_consent_text', [
    'privacyLink' => $privacyLink,
    'termsLink' => $termsLink,
]);
?>

<div id="cookie-consent-widget" 
     class="cookie-consent cookie-consent-<?= $widget->position ?> cookie-theme-<?= $widget->theme ?>"
     style="display: flex;">
    <div class="cookie-text">
        <?= $text ?>
    </div>
    <button id="cookie-consent-btn" class="cookie-btn">
        <?= $widget->buttonText ?? \Yii::t('app', 'button_ok') ?>
    </button>
</div>