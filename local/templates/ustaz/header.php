<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

$asset = Asset::getInstance();

global $USER;

//Магия для мультиязычности в пхп и Js
//php: echo GetMessage('HELLO_WORLD');
//js: BX.message('HELLO_WORLD');
Loc::loadMessages(__FILE__);
$messages = Loc::loadLanguageFile(__FILE__);

//Ссылки на страницу в разных версиях
switch (SITE_ID){
	case 'ru':
            $ruUrl =  $APPLICATION->GetCurPage();
            $tmpStr = explode('/',  $APPLICATION->GetCurPage());
            array_shift($tmpStr);
            array_shift($tmpStr);
            $kzUrl = '/' . implode('/', $tmpStr);
            break;
        case 'kz':
            $ruUrl =  '/ru' . $APPLICATION->GetCurPage();
            $kzUrl = $APPLICATION->GetCurPage();
            break;
        default:
            /**
             * Неизвестный язык
             */
            throw new Exception('Неизвестный язык в шаблоне ' . $lang);
            break;
}

//Logout
if ($_GET['logout'] === 'yes') {
    $USER->Logout();
}

//Обработка второго шага регистрации. Будет время, надо будет вынести в компонент. 
//http://du-dev.loc/?confirm=yes&confirm_user_id=12&confirm_code=FB1wQM3s
$request = \Bitrix\Main\Context::getCurrent()->getRequest();

if($request->get("confirm") == 'yes') {
	$userId = (int) $request->get("confirm_user_id");
	$showConfirmModal = false;//Показать модалку с вводом данных?
	$showErrorConfirmModal = false;// Показать модалку с ошибкой при подтверждении. Текст ошибки в $confirmErrorMsg
	if ($userId > 0){
		$rsUser = CUser::GetByID($userId);
		$arUser = $rsUser->Fetch();
		if ($arUser['CONFIRM_CODE'] == $request->get("confirm_code")){
			//Код подтверждения верный, можно показывать модалку на редактирование данных
			$showConfirmModal = true;
		} else {
			//Код подтверждения не верный
			$showErrorConfirmModal = true;
			$confirmErrorMsg = "Код подтверждения не верный.";
		}
	} else {
		$showErrorConfirmModal = true;
		$confirmErrorMsg = "Ошибка в ссылке.";
	}
}

//$asset->addCss(SITE_TEMPLATE_PATH . '/css/font-awesome.css');
//$asset->addJs(SITE_TEMPLATE_PATH . '/js/common.js');

//Скрипты и прочая статика
$asset->addJs(STATIC_PATH . "js/lazyimage.js");
$asset->addJs(STATIC_PATH . "js/lazyanimation.js");
$asset->addJs(STATIC_PATH . "js/vendor.js");
$asset->addJs(STATIC_PATH . "js/main.js");
$asset->addJs(STATIC_PATH . "js/common.js");
$asset->addJs(STATIC_PATH . "js/jquery.fancybox.min.js");
$asset->addJs(SITE_TEMPLATE_PATH . '/custom.js');//Потом вынести в общий файл скриптов

$asset->addCss(STATIC_PATH .  'css/main.css?v1.1');
$asset->addCss(STATIC_PATH .  'css/jquery.fancybox.min.css');
$asset->addCss(SITE_TEMPLATE_PATH.'/css/style.css');

?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="description" content="Вдохновлять учеников, сближая технологии">
		<meta property="og:type" content="website">
		<meta property="og:url" content="">
		<meta property="og:locale" content="ru_RU">
		<meta property="og:title" content="Digital Ustaz Almaty">
		<meta property="og:description" content="Вдохновлять учеников, сближая технологии">
		<meta property="vk:image">
		<meta property="og:image" itemprop="image">
		<meta property="og:image:type" content="image/jpeg">
		<meta property="og:image:alt" content="Digital Ustaz Almaty">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:title" content="Digital Ustaz Almaty">
		<meta name="twitter:description" content="Вдохновлять учеников, сближая технологии">
		<meta name="twitter:image">
		<meta name="facebook-domain-verification" content="ljpdhffl06mnbsmwgnck6p6tcazkj0" />
		<title><?= $APPLICATION->ShowTitle() ?></title>
		<link rel="apple-touch-icon" href="<?= STATIC_PATH ?>images/touch/apple-icon-57x57.png" sizes="57x57">
		<link rel="apple-touch-icon" href="<?= STATIC_PATH ?>images/touch/apple-icon-60x60.png" sizes="60x60">
		<link rel="apple-touch-icon" href="<?= STATIC_PATH ?>images/touch/apple-icon-72x72.png" sizes="72x72">
		<link rel="apple-touch-icon" href="<?= STATIC_PATH ?>images/touch/apple-icon-76x76.png" sizes="76x76">
		<link rel="apple-touch-icon" href="<?= STATIC_PATH ?>images/touch/apple-icon-114x114.png" sizes="114x114">
		<link rel="apple-touch-icon" href="<?= STATIC_PATH ?>images/touch/apple-icon-120x120.png" sizes="120x120">
		<link rel="apple-touch-icon" href="<?= STATIC_PATH ?>images/touch/apple-icon-144x144.png" sizes="144x144">
		<link rel="apple-touch-icon" href="<?= STATIC_PATH ?>images/touch/apple-icon-152x152.png" sizes="152x152">
		<link rel="apple-touch-icon" href="<?= STATIC_PATH ?>images/touch/apple-icon-180x180.png" sizes="180x180">
		<link rel="icon" href="<?= SITE_TEMPLATE_PATH ?>/favicon.ico">
		<link rel="icon" href="<?= STATIC_PATH ?>images/touch/favicon-16x16.png" sizes="16x16">
		<link rel="icon" href="<?= STATIC_PATH ?>images/touch/favicon-32x32.png" sizes="32x32">
		<link rel="icon" href="<?= STATIC_PATH ?>images/touch/favicon-96x96.png" sizes="96x96">
		<link rel="icon" href="<?= STATIC_PATH ?>images/touch/android-icon-192x192.png" sizes="196x196">
		<link rel="manifest" href="<?= STATIC_PATH ?>images/touch/manifest.json">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,500&amp;display=swap" rel="stylesheet">
		<? $APPLICATION->ShowHead(); ?>
		<script>
		 BX.message(<?=CUtil::PhpToJSObject($messages)?>);
		</script>
	</head>
	<body>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(85544491, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/85544491" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
		<header>
            <? $isFrameAjax = \Bitrix\Main\Composite\Engine::getUseHTMLCache() && \Bitrix\Main\Composite\Engine::isAjaxRequest();
            if (isset($GLOBALS["USER"]) && is_object($USER) && $USER->IsAuthorized() && !isset($_REQUEST["bx_hit_hash"]) && !$isFrameAjax)
            { ?>
                <div id="panel" style="margin-top: -12px; padding-bottom: 20px">
                    <?php $APPLICATION->ShowPanel(); ?>
                </div>
            <? } ?>
			<div class="header__section">
				<div class="container">
					<div class="header-container">
						<div class="header-block__left">
							<div class="header-lang__mobile"><a class="header-lang__change lang-js" href="#"><span><?= SITE_ID?></span></a>
								<div class="dropdown-lang">
									<ul class="dropdown-lang__list">
										<li class="dropdown-lang__item <? if (SITE_ID == 'ru'): ?>is-active<? endif; ?>"><a href="<?=$ruUrl?>">RU</a></li>
										<li class="dropdown-lang__item <? if (SITE_ID == 'kz'): ?>is-active<? endif; ?>"><a href="<?=$kzUrl?>">KZ</a></li>
									</ul>
								</div>
							</div>
							<div class="logo"><a href="<? if (SITE_ID == 'ru'): ?>/ru/<? else: ?>/<? endif;?>"><img class="lazyload icon-svg icon-logo" loading="lazy" data-src="<?= STATIC_PATH ?>images/sprites/svg/icon-logo.svg" alt="edc"></a></div>
							<div class="header-touch"><a class="touch-nav touch-nav-js" href="#"><i></i><i></i><i></i></a></div>
						</div>
						<div class="header-block__center nav-block__mobile">
							<div class="header-nav__contaner">
								<? $APPLICATION->IncludeComponent(
									"bitrix:menu",
									"header",
									array(
									    "ALLOW_MULTI_SELECT" => "N",
									    "CHILD_MENU_TYPE" => "sub",
									    "DELAY" => "N",
									    "MAX_LEVEL" => "2",
									    "MENU_CACHE_GET_VARS" => array(""),
									    "MENU_CACHE_TIME" => "3600",
									    "MENU_CACHE_TYPE" => "N",
									    "MENU_CACHE_USE_GROUPS" => "Y",
									    "ROOT_MENU_TYPE" => "main",
									    "USE_EXT" => "N"
									)
								); ?>
								<div class="header-nav__block-bottom">
									<?if ($USER->IsAuthorized()) {?>
									<?
//Аватарка пользователя
$userInfo = CUser::GetByID($GLOBALS["USER"]->GetId())->Fetch();
if (isset($userInfo['PERSONAL_PHOTO']) && $userInfo['PERSONAL_PHOTO'] > 0){
	$file = CFile::ResizeImageGet($userInfo['PERSONAL_PHOTO'], ['width' =>148, 'height'=>148], BX_RESIZE_IMAGE_PROPORTIONAL, true);
	$userAvatar = $file['src'];
} else {
	$userAvatar = false;
}


									?>
									<div class="header-nav__block-auth"><a class="header-nav__block-auth-head" href="#"><span class="header-nav__block-auth-head--icon"><? if($userAvatar) {?><img class="img-responsive lazyload" data-lazy="<?=$userAvatar?>" srcset="<?=$userAvatar?> 1x, <?=$userAvatar?> 2x" alt="#"><? } else {?><img class="img-responsive" src="<?=STATIC_PATH?>images/sprites/svg/icon-user-default.svg" alt="#"><? } ?><!--img class="img-responsive lazyload" data-lazy="<?=STATIC_PATH?>images/icons/user1-m.png" srcset="<?=STATIC_PATH?>images/icons/user1-m.png 1x, <?=STATIC_PATH?>images/icons/user1-m@2x.png 2x" alt="#"--></span><span class="header-nav__block-auth-head--user"><span class="header-nav__block-auth-head-user__name"><?=$USER->GetFirstName();?></span><span class="header-nav__block-auth-head-user__fname"><?=mb_strtoupper(mb_substr($USER->GetLastName(),0, 1));?>.</span></span></a>
										<ul class="header-nav__block-auth--list">
											<!--li><a href="#"><?=GetMessage('HEADER_USER_MENU_PROFILE')?></a></li-->
											<li><a href="<? if (SITE_ID == 'ru') {echo '/ru';}?>/personal/profile/"><?=GetMessage('HEADER_USER_MENU_REQUEST')?></a></li>
											<li><a href="?logout=yes"><?=GetMessage('HEADER_USER_MENU_LOGOUT')?></a></li>
										</ul>
									</div>
									<? } else { ?>
									<div class="header-nav__block-bottom-auth--enter"><a class="btn btn-blue" href="javascript:;" data-src="#modalLogin" data-fancybox><?=GetMessage('HEADER_USER_MENU_ENTER_BUTTON')?></a></div>
									<? } ?>
								</div>
							</div>
						</div>
						<div class="header-block__right">
							<?if ($USER->IsAuthorized()) {?>
								<div class="header-block__action"><div class="header-block__auth"><a class="btn-blue header-block__auth--btn header-auth-js" href="#"><span class="header-block__auth--icon"><? if($userAvatar) {?><img class="img-responsive lazyload" data-lazy="<?=$userAvatar?>" srcset="<?=$userAvatar?> 1x, <?=$userAvatar?> 2x" alt="#"><? } else {?><img class="img-responsive" src="<?=STATIC_PATH?>images/sprites/svg/icon-user-default.svg" alt="#"><? } ?><!--img class="img-responsive lazyload" data-lazy="<?=STATIC_PATH?>images/icons/user1.png" srcset="<?=STATIC_PATH?>images/icons/user1.png 1x, <?=STATIC_PATH?>images/icons/user1@2x.png 2x" alt="#"--></span><span class="header-block__auth-user"><span class="header-block__auth-user--name"><?=$USER->GetFirstName();?></span><span class="header-block__auth-user--fname"><?=mb_strtoupper(mb_substr($USER->GetLastName(),0, 1));?>.</span></span></a>
									<div class="header-panel">
										<ul class="header-panel__list">
                                            <?php if (CSite::InGroup([5])){ ?>
                                                <li><a href="<? if (SITE_ID == 'ru') {echo '/ru';}?>/personal/expert/"><?= Loc::getMessage("WORK_RATE") ?></a></li>
                                            <?php } else { ?>
											    <!--li><a href="#"><?=GetMessage('HEADER_USER_MENU_PROFILE')?></a></li-->
											    <li><a href="<? if (SITE_ID == 'ru') {echo '/ru';}?>/personal/profile/"><?=GetMessage('HEADER_USER_MENU_REQUEST')?></a></li>
											    <li><a href="<? if (SITE_ID == 'ru') {echo '/ru';}?>/personal/intensive/"><?= Loc::getMessage("PROFILE_HEADER_MENU_LEARNING") ?></a></li>
											    <li><a href="<? if (SITE_ID == 'ru') {echo '/ru';}?>/personal/competition/"><?= Loc::getMessage("PROFILE_HEADER_MENU_PRIZE") ?></a></li>
                                            <?php } ?>
											<li><a href="<? if (SITE_ID == 'ru') {echo '/ru';}?>/?logout=yes"><?=GetMessage('HEADER_USER_MENU_LOGOUT')?></a></li>
										</ul>
									</div>
								</div></div>
							<? } else { ?>
								<div class="header-block__action"><a class="btn btn-blue" href="javascript:;" data-src="#modalLogin" data-fancybox><?=GetMessage('HEADER_USER_MENU_ENTER_BUTTON')?></a></div>
							<? } ?>
							<ul class="header-block__lang">
								<li class="<? if (SITE_ID == 'ru'): ?>is-active<? endif; ?>"><a href="<?=$ruUrl?>">RU</a></li>
								<li class="<? if (SITE_ID == 'kz'): ?>is-active<? endif; ?>"><a href="<?=$kzUrl?>">KZ</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</header>


