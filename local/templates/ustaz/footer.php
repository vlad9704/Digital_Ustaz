<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<footer>
			<div class="container">
				<div class="footer-content">
					<div class="footer-content__head">
						<div class="footer-content__head-left">
							<div class="footer-logo"><a href="<? if (SITE_ID == 'ru'): ?>/ru/<? else: ?>/<? endif;?>"><img src="<?= STATIC_PATH ?>images/sprites/svg/icon-logo-footer.svg" alt="#"></a></div>
						</div>
						<div class="footer-content__head-center">
							<? $APPLICATION->IncludeFile(INCLUDE_PATH . "footer_contacts.php", array(), array("MODE" => "text")); ?>
						</div>
						<div class="footer-content__head-right">
							<? $APPLICATION->IncludeFile(INCLUDE_PATH . "footer_social.php", array(), array("MODE" => "text")); ?>
						</div>
					</div>
					<div class="footer-content__body">
						<div class="footer-content__left">
							<div class="footer-content__copy"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "footer_copyright.php", array(), array("MODE" => "text")); ?></div>
						</div>
						<div class="footer-content__center">
							<? $APPLICATION->IncludeComponent(
									"bitrix:menu",
									"footer",
									array(
									    "ALLOW_MULTI_SELECT" => "N",
									    "CHILD_MENU_TYPE" => "sub",
									    "DELAY" => "N",
									    "MAX_LEVEL" => "2",
									    "MENU_CACHE_GET_VARS" => array(""),
									    "MENU_CACHE_TIME" => "3600",
									    "MENU_CACHE_TYPE" => "N",
									    "MENU_CACHE_USE_GROUPS" => "Y",
									    "ROOT_MENU_TYPE" => "footer",
									    "USE_EXT" => "N"
									)
								); ?>
						</div>
						<div class="footer-content__right">
							<div class="footer-content__made">Made by <a href="#" target="_blank"><img src="<?= STATIC_PATH ?>images/sprites/svg/icon-thesis.svg" alt="#"> </a> <span>&amp;</span> <a href="https://chililab.pro/" target="_blank"><img src="<?= STATIC_PATH ?>images/sprites/svg/icon-chililab.svg" alt="#"> </a> </div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<?$APPLICATION->IncludeComponent(
		"bitrix:system.auth.form",
		"ustaz",
		Array(
		    "COMPOSITE_FRAME_MODE" => "A",
		    "COMPOSITE_FRAME_TYPE" => "AUTO",
		    "FORGOT_PASSWORD_URL" => "#modalRestorePassword",
		    "PROFILE_URL" => "",
		    "REGISTER_URL" => "#",
		    "SHOW_ERRORS" => $_REQUEST['AUTH_SHOW_ERRORS'] == 'Y' ? 'Y' : 'N'
		)
		);?>
		<?if (!$USER->IsAuthorized()) {?>
		<?$APPLICATION->IncludeComponent(
		    "bitrix:system.auth.forgotpasswd",
		    "ustaz",
		    Array(
			"AUTH_AUTH_URL" => "",
			"AUTH_REGISTER_URL" => "",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO"
		    )
		);?>
		<?}?>
		<? if ($showConfirmModal) { ?>
		<script>
		       $.fancybox.open({
				src: '#modalConfirmRegistration', 
				type: 'inline'
			});
		</script>
		<div class="modal__container modal--loginNew modal-loginNew__style modal-w510 modal-bg__shadow" id="modalConfirmRegistration">
			<div class="modal-content__block">
				<div class="modal__content">
					<div class="modal__title"><?=GetMessage('REGISTER_STEP2_COMPLITE_MODAL_TITLE')?></div>
					<form class="modal__form" action="#modalConfirmRegistration" method="post" id="modalConfirmRegistration" name="modalConfirmRegistration">
						<div class="modal__form--content">
							<input type="hidden" name="userid" value="<?= (int) $request->get("confirm_user_id")?>">
				                	<input type="hidden" name="code" value="<?=htmlspecialchars($request->get("confirm_code"));?>">
				                	<div class="modal__form--row js-confirm-form-errors"></div>
							<div class="modal__form--row">
								<input class="form-input" type="text" name="name" placeholder="<?=GetMessage('REGISTER_STEP2_ENTER_NAME')?>"  required>
							</div>
							<div class="modal__form--row">
								<input class="form-input" type="text" name="surname" placeholder="<?=GetMessage('REGISTER_STEP2_ENTER_SURNAME')?>" required>
							</div>
							<div class="modal__form--row">
								<input class="form-input" type="password" name="password" placeholder="<?=GetMessage('REGISTER_STEP2_ENTER_PASS1')?>" required>
							</div>
							<div class="modal__form--row">
								<input class="form-input" type="password" name="repassword" placeholder="<?=GetMessage('REGISTER_STEP2_ENTER_PASS2')?>" required>
							</div>
							<div class="modal__form--row modal-form-row-action modal-form-row--registration">
								<button class="btn btn-blue btn-modal-form js-btn-submit" type="submit" name="send_confirm_info"  value="<?=GetMessage('REGISTER_STEP2_CONFIRM_BUTTTON')?>"><?=GetMessage('REGISTER_STEP2_CONFIRM_BUTTTON')?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal__container modal--thank-you modal-w700 modal-bg__shadow" id="modalConfirmThankYou">
			<div class="modal-content__block">
				<div class="modal__content">
					<div class="modal__title"><?=GetMessage('REGISTER_STEP2_MODAL_REGISTER_COMPLITE')?></div>
					<div class="modal__text">
						<p><?=GetMessage('REGISTER_STEP2_MODAL_REGISTER_COMPLITE_TEXT')?></p>
					</div>
				</div>
			</div>
		</div>
		<? } ?>
		<? if ($showErrorConfirmModal) { ?>
		<script>
		       $.fancybox.open({
				src: '#modalConfirmError1', 
				type: 'inline'
			});
		</script>
		<div class="modal__container modal--thank-you modal-w700 modal-bg__shadow" id="modalConfirmError1">
			<div class="modal-content__block">
				<div class="modal__content">
					<div class="modal__title"><?=GetMessage('REGISTER_STEP2_MODAL_REGISTER_ERROR_TITLE')?></div>
					<div class="modal__text">
						<p><?=GetMessage('REGISTER_STEP2_MODAL_REGISTER_ERROR_TITLE')?></p>
					</div>
				</div>
			</div>
		</div>
		<? } ?>
		<div class="modal__container modal--thank-you modal-w700 modal-bg__shadow" id="modalThankYou2">
			<div class="modal-content__block">
				<div class="modal__content">
					<div class="modal__title"><?=GetMessage('REGISTER_STEP1_MODAL_REGISTER_COMPLITE_TITLE')?></div>
					<div class="modal__text">
						<p><?=GetMessage('REGISTER_STEP1_MODAL_REGISTER_COMPLITE_TEXT')?></p>
					</div>
				</div>
			</div>
		</div>
		<!-- Модалка Задать вопрос -->
		<div class="modal__container modal--loginNew modal-loginNew__style modal-w510 modal-bg__shadow" id="modalAskQuestion">
			<div class="modal-content__block">
				<div class="modal__content">
					<div class="modal__title"><?=GetMessage('ASK_QUESTION_TITLE')?></div>
					<form class="modal__form" action="#" method="post" id="formModalAskQuestion" name="formModalAskQuestion">
						<div class="modal__form--content">
							<div class="modal__form--row js-confirm-form-errors" style="display:none;"></div>
							<div class="modal__form--row">
								<input class="form-input" type="text" name="name" placeholder="<?=GetMessage('ASK_QUESTION_NAME')?>" required>
							</div>
							<div class="modal__form--row">
								<input class="form-input" type="email" name="email" placeholder="<?=GetMessage('ASK_QUESTION_EMAIL')?>" required>
							</div>
							<div class="modal__form--row">
								<textarea class="form-input" name="text" placeholder="<?=GetMessage('ASK_QUESTION_QUESTION')?>" required></textarea>
							</div>
							<div class="modal__form--row modal-form-row-action modal-form-row--registration">
								<button class="btn btn-blue btn-modal-form js-btn-submit" type="submit" name="send_question"  value="<?=GetMessage('ASK_QUESTION_SUBMIT_BUTTON')?>"><?=GetMessage('ASK_QUESTION_SUBMIT_BUTTON')?></button>
								<!-- button(type="submit").btn.btn-blue.btn-modal-form Отправить><a class="btn btn-blue btn-modal-form btn-open-modal" href="#modalThankYouAskQuestion"><?=GetMessage('ASK_QUESTION_SUBMIT_BUTTON')?></a-->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal__container modal--thank-you modal-w530 modal-bg__shadow" id="modalThankYouAskQuestion">
			<div class="modal-content__block">
				<div class="modal__content">
					<div class="modal__title"><?=GetMessage('ASK_QUESTION_THANKYOU_TITLE')?></div>
					<div class="modal__text mb-0">
						<p class="mb-0"><?=GetMessage('ASK_QUESTION_THANKYOU_TEXT')?></p>
					</div>
				</div>
			</div>
		</div>
		<a class="question-btn" data-fancybox="modalAskQuestion" data-src="#modalAskQuestion" href="javascript:;"></a>
		<? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/include_areas/counters.php", array(), array("MODE" => "text")); ?>
	</body>
<!-- # -->
<!--  ██████╗██╗  ██╗██╗██╗     ██╗   ██╗      █████╗ ██████╗   -->
<!-- ██╔════╝██║  ██║██║██║     ██║   ██║     ██╔══██╗██╔══██╗  -->
<!-- ██║     ███████║██║██║     ██║   ██║     ███████║██████╔╝  -->
<!-- ██║     ██╔══██║██║██║     ██║   ██║     ██╔══██║██╔══██╗  -->
<!-- ╚██████╗██║  ██║██║███████╗██║██╗███████╗██║  ██║██████╔╝  -->
<!--  ╚═════╝╚═╝  ╚═╝╚═╝╚══════╝╚═╝╚═╝╚══════╝╚═╝  ╚═╝╚═════╝   -->
<!-- # -->
<!-- Разработано в Chili.lab (http://chililab.pro). Chili.help - служба поддержки сайтов (http://chilihelp.ru). -->
<!-- # -->
</html>
