<div class="page-content">
    <main class="wrapper">
        <div class="tagline-container">
            <div class="container">
                <div class="tagline-content">
                    <div class="tagline-block__left">
                        <h1 class="tagline-title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/tag_line_title.php", array(), array("MODE" => "text")); ?></h1>
                                                <div class="tagline-text">
                            <? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/tag_line_text.php", array(), array("MODE" => "text")); ?>
                        </div>
						<div class="tagline-img__tablet">
                            <div class="tagline-block__right--img">
                                <picture>
                                    
									<source media="(max-width: 767px)" type="image/png" srcset="<?= INCLUDE_PATH ?>images/taglinemob-img.png"><img class="lazyload" data-src="<?= INCLUDE_PATH ?>images/simple.png" alt="#" loading="lazy">								    </picture>
                            </div>
                            <?php if (timerCountdown(new DateTime(MAIN_PAGE_COUNTDOWN, new \DateTimeZone('Asia/Almaty')), SITE_ID)) { ?>
                                <div class="tagline-block__info">
                                    <div class="tagline-block__info--text"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/tag_line_timer.php", array(), array("MODE" => "text")); ?></div>
                                    <div class="tagline-block__info--day">
                                        <div class="btn btn-orange"><?php echo timerCountdown(new DateTime(MAIN_PAGE_COUNTDOWN, new \DateTimeZone('Asia/Almaty')), SITE_ID); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <form class="tagline-form register-content__form main_form_1" action="#" method="post" name="main_form_1">
                            <div class="form-control form-control__group">
                                <input class="form-input" type="email" name="email" autocomplete="off" placeholder="<?=GetMessage('REGISTER_ENTER_EMAIL')?>"  required>
                                <button class="btn btn-orange form-control__btn form-control__btn--register" type="submit"><?=GetMessage('REGISTER')?></button>
                            </div>
                            <div class="form-control form-control__agreement">
                                <input class="form-checkbox" type="checkbox" id="regAgreement1"  required>
                                <label class="form-label-checkbox" for="regAgreement1"><?=GetMessage('REGISTER_PRIVATE_POLICY')?></label>
                            </div>
                        </form>
                        <div class="tagline-participants">
                            <div class="tagline-participants__img"><img class="lazyload" data-src="<?= INCLUDE_PATH ?>images/tagline-participants.png" alt="#" loading="lazy"></div>
                            <div class="tagline-participants__text"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/tag_line_participants.php", array(), array("MODE" => "text")); ?></div>
                        </div>
                    </div>
                    <div class="tagline-block__right">
                        <div class="tagline-block__wrap">
                            <div class="tagline-block__right--img">
                                <picture>
                                    <source media="(max-width: 1023px)" type="image/png" srcset="<?= INCLUDE_PATH ?>images/simple.png"><img class="lazyload" data-src="<?= INCLUDE_PATH ?>images/tagline-img.png" alt="#" loading="lazy">
									
                                </picture>
                            </div>
                            <?php if (timerCountdown(new DateTime(MAIN_PAGE_COUNTDOWN, new \DateTimeZone('Asia/Almaty')), SITE_ID)) { ?>
                                <div class="tagline-block__info">
                                    <div class="tagline-block__info--text"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/tag_line_timer.php", array(), array("MODE" => "text")); ?></div>
                                    <div class="tagline-block__info--day">
                                        <div class="btn btn-orange"><?php echo timerCountdown(new DateTime(MAIN_PAGE_COUNTDOWN, new \DateTimeZone('Asia/Almaty')), SITE_ID); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "main_info_slider",
            array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "N",
                "DISPLAY_PICTURE" => "N",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("", ""),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => IBLOCK_ID_MAIN_INFO_SLIDER,
                //"IBLOCK_TYPE" => "Content",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "N",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "20",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("title_ru", "title_kz","file_icon"),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N"
            )
        ); ?>
        <div class="stages-container" id="stages">
            <div class="container">
                <div class="h2 stages-content__title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/stages_title.php", array(), array("MODE" => "text")); ?></div>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "main_stages",
                    array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "N",
                        "DISPLAY_PICTURE" => "N",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => IBLOCK_ID_MAIN_STAGES,
                        //"IBLOCK_TYPE" => "Content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "N",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "20",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("stage_head_title_ru", "stage_head_title_kz", "stage_head_format", "stage_img_big", "stage_img_small", "stage_title_ru", "stage_title_kz", "stage_description_ru", "stage_description_kz"),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "SORT",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N"
                    )
                ); ?>
                <div class="stages-content__action"><a class="btn btn-orange btn-orange-shadow link-scroll" href="<?=($USER->IsAuthorized() ? '/ru/personal/profile/' : '#frmRegister') ?>"><?=GetMessage('REGISTER_REQUEST')?></a></div>
            </div>
        </div>
        <div class="speakers-container" id="speakers">
            <div class="container">
                <div class="h2 speakers-content__title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/speakers_title.php", array(), array("MODE" => "text")); ?></div>

				<?php $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "main_speakers",
                    array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "N",
                        "DISPLAY_PICTURE" => "N",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => IBLOCK_ID_MAIN_SPEAKERS,
                        //"IBLOCK_TYPE" => "Content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "N",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "20",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("speaker_avatar", "speaker_name_ru", "speaker_name_kz", "speaker_title_ru", "speaker_title_kz", "speaker_town_ru", "speaker_town_kz", "speaker_info_ru", "speaker_info_kz"),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "SORT",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N"
                    )
                ); ?>
            </div>
        </div>
        <div class="participant-container" id="participant">
            <div class="container">
                <div class="h2 participant-content__title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/participant_content_title.php", array(), array("MODE" => "text")); ?></div>
                <div class="participant-content">
                    <div class="participant-content__left">
                        <div class="participant-content__left--top">
                            <div class="participant-text">
                                <? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/participant_content_text.php", array(), array("MODE" => "text")); ?>
                            </div>
                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:news.list",
                                "main_participant",
                                array(
                                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                    "ADD_SECTIONS_CHAIN" => "N",
                                    "AJAX_MODE" => "N",
                                    "AJAX_OPTION_ADDITIONAL" => "",
                                    "AJAX_OPTION_HISTORY" => "N",
                                    "AJAX_OPTION_JUMP" => "N",
                                    "AJAX_OPTION_STYLE" => "Y",
                                    "CACHE_FILTER" => "N",
                                    "CACHE_GROUPS" => "Y",
                                    "CACHE_TIME" => "36000000",
                                    "CACHE_TYPE" => "A",
                                    "CHECK_DATES" => "Y",
                                    "DETAIL_URL" => "",
                                    "DISPLAY_BOTTOM_PAGER" => "N",
                                    "DISPLAY_DATE" => "Y",
                                    "DISPLAY_NAME" => "N",
                                    "DISPLAY_PICTURE" => "N",
                                    "DISPLAY_PREVIEW_TEXT" => "Y",
                                    "DISPLAY_TOP_PAGER" => "N",
                                    "FIELD_CODE" => array("", ""),
                                    "FILTER_NAME" => "",
                                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                    "IBLOCK_ID" => IBLOCK_ID_MAIN_PARTICIPANT,
                                    //"IBLOCK_TYPE" => "Content",
                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                    "INCLUDE_SUBSECTIONS" => "N",
                                    "MESSAGE_404" => "",
                                    "NEWS_COUNT" => "20",
                                    "PAGER_BASE_LINK_ENABLE" => "N",
                                    "PAGER_DESC_NUMBERING" => "N",
                                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                    "PAGER_SHOW_ALL" => "N",
                                    "PAGER_SHOW_ALWAYS" => "N",
                                    "PAGER_TEMPLATE" => ".default",
                                    "PAGER_TITLE" => "Новости",
                                    "PARENT_SECTION" => "",
                                    "PARENT_SECTION_CODE" => "",
                                    "PREVIEW_TRUNCATE_LEN" => "",
                                    "PROPERTY_CODE" => array("item_icon", "participant_title_ru", "participant_title_kz"),
                                    "SET_BROWSER_TITLE" => "N",
                                    "SET_LAST_MODIFIED" => "N",
                                    "SET_META_DESCRIPTION" => "N",
                                    "SET_META_KEYWORDS" => "N",
                                    "SET_STATUS_404" => "N",
                                    "SET_TITLE" => "N",
                                    "SHOW_404" => "N",
                                    "SORT_BY1" => "SORT",
                                    "SORT_BY2" => "SORT",
                                    "SORT_ORDER1" => "ASC",
                                    "SORT_ORDER2" => "ASC",
                                    "STRICT_SECTION_CHECK" => "N"
                                )
                            ); ?>
                        </div>
						<div class="participant-action"><a class="participant-button btn-blue btn-blue-shadow link-scroll btn-blue btn-blue-shadow link-scroll" href="<?=($USER->IsAuthorized() ? '/ru/personal/profile/' : '#frmRegister') ?>"><?=GetMessage('REGISTER')?></a></div>
                    
                       </div>
                    <div class="participant-content__right">
                        <div class="participant-content__right--img">
						<picture>
                                    
									<source media="(max-width: 767px)" type="image/png" srcset="<?= INCLUDE_PATH ?>images/grmob.png"><img class="lazyload" data-src="<?= INCLUDE_PATH ?>images/simple.png" alt="#" loading="lazy">								    </picture>
                            
                        </div>
                        <div class="participant-action"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="prizes-container" id="prizes">
            <div class="container">
                <div class="prizes-content">
                    <div class="prizes-content__left">
                        <div class="prizes-content__left-top">
                            <div class="prizes-content__left-block--img">
                                <picture>
                                    <source media="(max-width: 1023px)" type="image/png" srcset="<?= STATIC_PATH ?>images/simple.png"><img class="img-responsive lazyload" data-src="<?= INCLUDE_PATH ?>images/prizes/1.png" srcset="<?= INCLUDE_PATH ?>images/prizes/1.png 1x, <?= INCLUDE_PATH ?>images/prizes/1@2x.png 2x" alt="#" loading="lazy">
                                </picture>
                            </div>
                            <div class="prizes-circle">
                                <div class="prizes-circle__block is-color-1"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/prizes_final.php", array(), array("MODE" => "text")); ?></div>
                            </div>
                        </div>
                        <div class="prizes-content__left-bottom">
                            <div class="prizes-circle">
                                <div class="prizes-circle__block is-color-2"><img class="icon-snowflake2 lazyload" data-src="<?= STATIC_PATH ?>images/sprites/svg/icon-snowflake2.svg" alt="#" loading="lazy"></div>
                            </div>
                            <div class="prizes-content__left-block--img">
                                <picture>
                                    <source media="(max-width: 1023px)" type="image/png" srcset="<?= STATIC_PATH ?>images/simple.png"><img class="img-responsive lazyload" data-src="<?= INCLUDE_PATH ?>images/prizes/2.png" srcset="<?= INCLUDE_PATH ?>images/prizes/2.png 1x, <?= INCLUDE_PATH ?>images/prizes/2@2x.png 2x" alt="#" loading="lazy">
                                </picture>
                            </div>
                        </div>
                    </div>
                    <div class="prizes-content__right">
                        <div class="prizes-block">
                            <div class="prizes-block__date"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/prizes_date.php", array(), array("MODE" => "text")); ?></div>
                            <div class="prizes-block__title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/prizes_title.php", array(), array("MODE" => "text")); ?></span> </div>
                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:news.list",
                                "main_prizes",
                                array(
                                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                    "ADD_SECTIONS_CHAIN" => "N",
                                    "AJAX_MODE" => "N",
                                    "AJAX_OPTION_ADDITIONAL" => "",
                                    "AJAX_OPTION_HISTORY" => "N",
                                    "AJAX_OPTION_JUMP" => "N",
                                    "AJAX_OPTION_STYLE" => "Y",
                                    "CACHE_FILTER" => "N",
                                    "CACHE_GROUPS" => "Y",
                                    "CACHE_TIME" => "36000000",
                                    "CACHE_TYPE" => "A",
                                    "CHECK_DATES" => "Y",
                                    "DETAIL_URL" => "",
                                    "DISPLAY_BOTTOM_PAGER" => "N",
                                    "DISPLAY_DATE" => "Y",
                                    "DISPLAY_NAME" => "N",
                                    "DISPLAY_PICTURE" => "N",
                                    "DISPLAY_PREVIEW_TEXT" => "Y",
                                    "DISPLAY_TOP_PAGER" => "N",
                                    "FIELD_CODE" => array("", ""),
                                    "FILTER_NAME" => "",
                                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                    "IBLOCK_ID" => IBLOCK_ID_MAIN_PRIZES,
                                    //"IBLOCK_TYPE" => "Content",
                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                    "INCLUDE_SUBSECTIONS" => "N",
                                    "MESSAGE_404" => "",
                                    "NEWS_COUNT" => "20",
                                    "PAGER_BASE_LINK_ENABLE" => "N",
                                    "PAGER_DESC_NUMBERING" => "N",
                                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                    "PAGER_SHOW_ALL" => "N",
                                    "PAGER_SHOW_ALWAYS" => "N",
                                    "PAGER_TEMPLATE" => ".default",
                                    "PAGER_TITLE" => "Новости",
                                    "PARENT_SECTION" => "",
                                    "PARENT_SECTION_CODE" => "",
                                    "PREVIEW_TRUNCATE_LEN" => "",
                                    "PROPERTY_CODE" => array("prizes_place_ru", "prizes_place_kz", "prizes_info_ru", "prizes_info_kz"),
                                    "SET_BROWSER_TITLE" => "N",
                                    "SET_LAST_MODIFIED" => "N",
                                    "SET_META_DESCRIPTION" => "N",
                                    "SET_META_KEYWORDS" => "N",
                                    "SET_STATUS_404" => "N",
                                    "SET_TITLE" => "N",
                                    "SHOW_404" => "N",
                                    "SORT_BY1" => "SORT",
                                    "SORT_BY2" => "SORT",
                                    "SORT_ORDER1" => "ASC",
                                    "SORT_ORDER2" => "ASC",
                                    "STRICT_SECTION_CHECK" => "N"
                                )
                            ); ?>
                            <div class="prizes-block__bottom">
                                <? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/prizes_bottom.php", array(), array("MODE" => "text")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="advice-container">
            <div class="container">
                <div class="advice-head">
                    <div class="h2 advice-content__title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/advice_title.php", array(), array("MODE" => "text")); ?></div>

                </div>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "main_advice",
                    array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "N",
                        "DISPLAY_PICTURE" => "N",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => IBLOCK_ID_MAIN_ADVICE,
                        //"IBLOCK_TYPE" => "Content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "N",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "20",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("advice_avatar", "advice_title_ru", "advice_title_kz", "advice_info_ru", "advice_info_kz"),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "SORT",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N"
                    )
                ); ?>
            </div>
        </div>
        <div class="register-bottom__container">
            <div class="container">
                <div class="register-bottom__content">
                    <a name="frmRegister" id="frmRegister"></a>
                    <div class="register-bottom__title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/register_now_title.php", array(), array("MODE" => "text")); ?></div>
                    <div class="register-bottom__block">
                        <div class="register-bottom__block-left">
                            <? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/register_now_text.php", array(), array("MODE" => "text")); ?>
                        </div>
                        <div class="register-bottom__block-right">
                            <form class="register-content__form main_form_2" action="#" method="post"  name="main_form_2">
                                <div class="form-control form-control__group">
                                    <input class="form-input" type="email" name="email" autocomplete="off" placeholder="<?=GetMessage('REGISTER_ENTER_EMAIL')?>"  required>
                                    <button class="btn btn-orange form-control__btn form-control__btn--register" type="submit"><?=GetMessage('REGISTER')?></button>
                                </div>
                                <div class="form-control form-control__agreement">
                                    <input class="form-checkbox" type="checkbox" id="regAgreement2" required>
                                    <label class="form-label-checkbox" for="regAgreement2"><?=GetMessage('REGISTER_PRIVATE_POLICY')?></label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<div class="organizers-container">
    <div class="container">
        <div class="organizers-content">
<div class="organizers-block__title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/organizators.php", array(), array("MODE" => "text")); ?></div>
		            <div class="organizers-block">

                <?php $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "main_organizators",
                    array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "N",
                        "DISPLAY_PICTURE" => "N",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => IBLOCK_ID_MAIN_ORGAN,
                        //"IBLOCK_TYPE" => "Content",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "N",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "20",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("organ_img", "organ_text_ru", "organ_text_kz"),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "SORT",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N"
                    )
                ); ?>
				</div>
<div class="organizers-block__title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/general.php", array(), array("MODE" => "text")); ?></div>
            <div class="organizers-block">

<?php $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main_general", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "Y",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => IBLOCK_ID_MAIN_GENERAL,
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "8",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array("general_img","general_text_ru","general_text_kz"),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "main_general",
		"IBLOCK_TYPE" => "news",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
); ?>
            </div>
        </div>
    </div>
</div>	

    </main>
</div>