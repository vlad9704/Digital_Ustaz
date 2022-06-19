<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$ajaxId = 'system.auth.changepasswd';
$isAjax = $request->isAjaxRequest() && $request->get('ajax_id') == $ajaxId;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<?if ($isAjax) $APPLICATION->RestartBuffer();?><div>
		<div class="modal__container modal--loginNew modal-loginNew__style modal-w510 modal-bg__shadow" id="modalConfirmPasswordChange">
			<?if (!empty($arParams['~AUTH_RESULT']) && $arParams['~AUTH_RESULT']['TYPE'] == 'OK') {?>
			<!-- Смена пароля завершена -->
			<div class="modal-content__block">
				<div class="modal__content">
					<div class="modal__title"><?=Loc::getMessage('FORGOT_PASSWORD_STEP2_MODAL_OK');?></div>
					<div class="modal__text">
						<p><?=Loc::getMessage('FORGOT_PASSWORD_STEP2_MODAL_TEXT');?></p>
					</div>
					<div class="modal__form--content">
						<div class="modal__form--row modal-form-row-action modal-form-row--registration">
                            <a class="btn btn-blue btn-modal-form js-btn-submit" href='/#modalLogin'><?=Loc::getMessage('FORGOT_PASSWORD_STEP2_MODAL_BUTTON');?></button></a>
						</div>
					</div>
				</div>
			</div>
			<?} else {?>
			<div class="modal-content__block">
				<div class="modal__content">
					<div class="modal__title"><?=Loc::getMessage('FORGOT_PASSWORD_STEP2_MODAL_1_TITLE');?></div>
					<form class="modal__form" action="<?=$arResult["AUTH_URL"]?>" method="post" id="modalPasswordChange" name="modalPasswordChange">
						<div class="modal__form--content">
						<?if ($arResult["BACKURL"] <> ''): ?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<? endif ?>
							<input type="hidden" name="AUTH_FORM" value="Y" />
						        <input type="hidden" name="TYPE" value="CHANGE_PWD" />
						        <input type="hidden" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" class="bx-auth-input" />
						        <input type="hidden" name="USER_CHECKWORD"  value="<?=$arResult["USER_CHECKWORD"]?>" class="bx-auth-input" autocomplete="off" />
						        <input type="hidden" name="cp_token" id="cp_token" />
						        <input type="hidden" name="cp_action" id="cp_action" />
						        <input type="hidden" name="ajax_id" value="<?=$ajaxId?>" />
				                	<div class="modal__form--row js-confirm-form-errors">
	                                    			<?
						            if (!empty($arParams['~AUTH_RESULT']) && $arParams['~AUTH_RESULT']['TYPE'] == 'ERROR') {
						                echo $arParams['~AUTH_RESULT']['MESSAGE'];
						            }
						            ?>
						        </div>
							<div class="modal__form--row">
								<input class="form-input" type="password" value="<?=$arResult["USER_PASSWORD"]?>" name="USER_PASSWORD" placeholder="<?=Loc::getMessage('FORGOT_PASSWORD_STEP2_MODAL_1_PASS1');?>" maxlength="255" required>
							</div>
							<div class="modal__form--row">
								<input class="form-input" type="password" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" name="USER_CONFIRM_PASSWORD"" placeholder="<?=Loc::getMessage('FORGOT_PASSWORD_STEP2_MODAL_1_PASS2');?>" maxlength="255" required>
							</div>
							<div class="modal__form--row modal-form-row-action modal-form-row--registration">
								<button class="btn btn-blue btn-modal-form js-btn-submit" type="submit" name="change_pwd" value="<?=Loc::getMessage('FORGOT_PASSWORD_STEP2_MODAL_1_BUTTON');?>"><?=Loc::getMessage('FORGOT_PASSWORD_STEP2_MODAL_1_BUTTON');?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
        <script>
            $(document).ready(function() {
		    $.fancybox.open({
			src: '#modalConfirmPasswordChange', 
			type: 'inline'
			});
            })
        </script>
        <?}?>
    </div>

</div><?if ($isAjax) die(); ?>
