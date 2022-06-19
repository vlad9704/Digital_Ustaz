<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$ajaxId = 'system.auth.form.default';
$isAjax = $request->isAjaxRequest() && $request->get('ajax_id') == $ajaxId;
CJSCore::Init();
?>

<script>
    var hash = location.hash;
    if(hash) {
        $('[data-src="' + hash + '"][data-fancybox]').first().click()
    }
</script>

<?if ($isAjax) $APPLICATION->RestartBuffer();?>

<div>
    <?if ($USER->IsAuthorized() && $isAjax) {?>
        <div class="modal-title modal__title"><?=Loc::getMessage('AUTH_FORM_AUTH_OK');?></div>
    <?} else {?>
 	<div class="modal__container modal--loginNew modal-loginNew__style modal-w550 modal-bg__shadow" id="modalLogin">
	    <div class="modal-content__block">
		<div class="modal__content">
		    <div class="modal__title"><?=Loc::getMessage('AUTH_FORM_AUTH_ENTER_FORM_1');?></div>
		    <div class="modal__text">
		        <p><?=Loc::getMessage('AUTH_FORM_AUTH_ENTER_FORM_2');?></p>
		    </div>
		    <form class="modal__form js-auth-form" action="<?=$arResult["AUTH_URL"]?>" method="post" name="system_auth_form<?=$arResult["RND"]?>">
		    		<?foreach ($arResult["POST"] as $key => $value):?>
                                        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                               <?endforeach?>
                               <input type="hidden" name="AUTH_FORM" value="Y" />
                               <input type="hidden" name="TYPE" value="AUTH" />
                               <input type="hidden" name="AUTH_SHOW_ERRORS" value="Y" />
                               <input type="hidden" name="ajax_id" value="<?=$ajaxId?>" />
                               <input type="hidden" name="auth_token" id="auth_token">
                               <input type="hidden" name="auth_action" id="auth_action">
		        <div class="modal__form--content">
		            <div class="modal__form--row">
		                <input class="form-input" type="email" name="USER_LOGIN" placeholder="<?=Loc::getMessage('AUTH_FORM_ENTER_EMAIL');?>" autocomplete="off" required>
		                                                        <script>
                                            BX.ready(function() {
                                                var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
                                                if (loginCookie)
                                                {
                                                    var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
                                                    var loginInput = form.elements["USER_LOGIN"];
                                                    loginInput.value = loginCookie;
                                                }
                                            });
                                        </script>
		            </div>
		            <div class="modal__form--row">
		                <input class="form-input" type="password" name="USER_PASSWORD" placeholder="<?=Loc::getMessage('AUTH_FORM_ENTER_PASSWORD');?>" autocomplete="off" required>
		            </div>
		            <div class="modal__form--row js-auth-form-errors">
		                        <?
                                        if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
                                            echo $arResult['ERROR_MESSAGE']['MESSAGE'];
                                        ?>
		            </div>
		            <div class="modal__form--row">
		                <input class="form-checkbox" type="checkbox" name="USER_REMEMBER" value="Y" id="modalLoginNewAgreement">
		                <label class="form-label-checkbox" for="modalLoginNewAgreement"><?=Loc::getMessage('AUTH_REMEMBER_SHORT');?></label>
		            </div>
		            <div class="modal__form--row modal-form-row-action">
		                <button class="btn btn-blue btn-modal-form js-btn-submit" type="submit" name="Login" ><?=Loc::getMessage('AUTH_LOGIN_BUTTON');?></button><a class="restore-password-link btn-open-modal" href="#modalRestorePassword"><?=Loc::getMessage('AUTH_FORGOT_PASSWORD_2');?></a>
		            </div>
		        </div>
		    </form>
		    <div class="modal__content--bottom"><a class="btn-not-registered btn-open-modal" href="#modalRegistration"><span><?=Loc::getMessage('AUTH_REGISTER');?></span></a></div>
		</div>
	    </div>  
        </div>
    <?}?>  
</div> 
    
    
    
    
    
    
    

<?
//\ReCaptcha\ProjectReCaptcha::scripts('form', 'auth_');
?>

<?if ($isAjax) die();?>
