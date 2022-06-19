<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$ajaxId = 'system.auth.forgotpasswd.default';
$isAjax = $request->isAjaxRequest() && $request->get('ajax_id') == $ajaxId;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>

<? if ($isAjax) $APPLICATION->RestartBuffer(); ?>

<div>
    <? if (!empty($arParams['~AUTH_RESULT']) && $arParams['~AUTH_RESULT']['TYPE'] == 'OK' || $APPLICATION->arAuthResult['TYPE'] == 'OK') { ?>
        <div class="modal__container modal--thank-you modal-w700 modal-bg__shadow" id="modalThankYou2">
            <div class="modal-content__block">
                <div class="modal__content">
                    <div class="modal__title"><?= Loc::getMessage('FORGOT_PASSWORD_TITLE'); ?></div>
                    <div class="modal__text">
                        <p><?= Loc::getMessage('FORGOT_PASSWORD_SEND'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    <? } else { ?><? //print_r($APPLICATION->arAuthResult); ?>
        <div class="modal__container modal--loginNew modal-w530 modal-bg__shadow" id="modalRestorePassword">
            <div class="modal-content__block">
                <div class="modal__content">
                    <div class="modal__title"><?= Loc::getMessage('FORGOT_PASSWORD_TITLE'); ?></div>
                    <form class="modal__form js-forgotpasswd-form" method="post" name="bform" target="_top"
                          action="<?= $arResult["AUTH_URL"] ?>">
                        <input type="hidden" name="AUTH_FORM" value="Y">
                        <input type="hidden" name="TYPE" value="SEND_PWD">
                        <input type="hidden" name="ajax_id" value="<?= $ajaxId ?>">
                        <input type="hidden" name="fp_token" id="fp_token">
                        <input type="hidden" name="fp_action" id="fp_action">
                        <div class="modal__form--content">
                            <div class="modal__form--row">
                                <input class="form-input" type="email" name="USER_LOGIN"
                                       value="<?= $arResult["LAST_LOGIN"] ?>"
                                       placeholder="<?= Loc::getMessage('FORGOT_PASSWORD_ENTER_YOUR_EMAIL'); ?>"
                                       autocomplete="off" required>
                                <input type="hidden" name="USER_EMAIL" />
                            </div>
                            <div class="modal__form--row js-forgotpasswd-form-errors">
                                <?
                                if (!empty($arParams['~AUTH_RESULT']) && $arParams['~AUTH_RESULT']['TYPE'] == 'ERROR') {
                                    echo $arParams['~AUTH_RESULT']['MESSAGE'];
                                }

                                if (isset($APPLICATION->arAuthResult['TYPE']) && $APPLICATION->arAuthResult['TYPE'] == 'ERROR') {
                                    echo $APPLICATION->arAuthResult['MESSAGE'];
                                }

                                ?>
                            </div>
                            <div class="modal__form--row modal-form-row-action modal-form-row--restore">
                                <button class="btn btn-blue btn-modal-form js-btn-submit" type="submit"
                                        name="send_account_info"
                                        value="<?= GetMessage("AUTH_SEND") ?>"><?= Loc::getMessage('FORGOT_PASSWORD_RESTORE'); ?></button>
                                <a class="restore-password-link btn-open-modal"
                                   href="#modalLogin"><?= Loc::getMessage('FORGOT_PASSWORD_REMEMBER'); ?></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal__container modal--loginNew modal-w530 modal-bg__shadow" id="modalRegistration">
            <div class="modal-content__block">
                <div class="modal__content">
                    <div class="modal__title"><?= Loc::getMessage('REGISTER_TITLE'); ?></div>
                    <form class="modal__form js-register-form" method="post" name="b_register_form" target="_top"
                          action="<?= $arResult["AUTH_URL"] ?>">
                        <div class="modal__form--content">
                            <div class="modal__form--row">
                                <input class="form-input" type="email" name="email"
                                       value="<?= $arResult["LAST_LOGIN"] ?>"
                                       placeholder="<?= Loc::getMessage('REGISTER_ENTER_EMAIL'); ?>"
                                       autocomplete="off" required>
                                <input type="hidden" name="USER_EMAIL" />
                            </div>
                            <div class="modal__form--row">
                                <div class="form-control form-control__agreement">
                                    <input class="form-checkbox" type="checkbox" id="registerAgreement1" required>
                                    <label class="form-label-checkbox"
                                           for="registerAgreement1"><?= GetMessage('REGISTER_PRIVATE_POLICY') ?></label>
                                </div>
                            </div>
                            <div class="modal__form--row js-register-form-errors"></div>
                            <div class="modal__form--row modal-form-row-action modal-form-row--restore">
                                <button class="btn btn-blue btn-modal-form js-btn-submit" type="submit"
                                        name="send_account_info"><?= Loc::getMessage('REGISTER'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <? } ?>
</div>
<script type="text/javascript">
    document.bform.onsubmit = function () {
        document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;
    };
    document.bform.USER_LOGIN.focus();
</script>

<?
//\ReCaptcha\ProjectReCaptcha::scripts('form', 'fp_');
?>

<? if ($isAjax) die(); ?>
