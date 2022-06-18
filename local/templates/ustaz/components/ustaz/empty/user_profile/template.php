<?php

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

$asset = Asset::getInstance();

$asset->addCss(STATIC_PATH . '/css/gradient.css');
$asset->addCss(STATIC_PATH . '/css/select2.css');
$asset->addCss(STATIC_PATH . '/css/tooltipster.bundle.css');
$asset->addCss(STATIC_PATH . '/css/datepicker.min.css');
$asset->addCss($templateFolder . '/style.css');

$asset->addJs(STATIC_PATH . "js/select2.min.js");
$asset->addJs(STATIC_PATH . "js/select-profile.js");
$asset->addJs(STATIC_PATH . "js/tooltipster.bundle.min.js");
$asset->addJs(STATIC_PATH . "js/datepicker.min.js");
$asset->addJs($templateFolder . "/script.js");

Loc::loadMessages(__FILE__);

//print_r($arResult);
?>
<div class="page-content">
    <main class="wrapper">
        <div class="main-content">
            <div class="container">
                <div class="main-wrapper">
                    <div class="main-container">
                        <div class="main-container__block main-container--style pt-0">
                            <? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/include_areas/user_profile_tabs.php", $arResult, array("MODE" => "text", "SHOW_BORDER" => false)); ?>
                            <form class="profile-container" action="#" method="post" enctype="multipart/form-data"
                                  id="formUserProfile" name="formUserProfile">
                                <div class="profile-sidebar__left">
                                    <div class="profile-photo">
                                        <div class="profile-photo__block">
                                            <div class="profile-photo__block--img">
                                                <img class="img-responsive" src="<?= $arResult['user']['avatar'] ?>">
                                            </div>
                                            <a class="profile-photo__delete" href="#" id="delete_avatar"></a>
                                        </div>
                                        <div class="profile-photo__action form-control">
                                            <input class="file-input" type="file" data-upload="file1upload"
                                                   id="file_avatar" name="file_avatar" accept="image/*" value="">
                                            <input type='hidden' id="delete_avatar_input" name='data[avatar_delete]'
                                                   value='0'>
                                            <label class="profile-photo__add"
                                                   for="file_avatar"><?= Loc::getMessage('USER_PROFILE_AVATAR_UPLOAD') ?></label>
                                            <div class="profile-photo__upload" id="file1upload"></div>
                                        </div>
                                    </div>
                                    <div class="profile-status">
                                        <div class="profile-status__btn status--<?= $arResult['status_css'][$arResult['user']['properties']['UF_PROFILE_STATUS']['XML_ID']] ?>"><?= Loc::getMessage('USER_PROFILE_STATUS_' . $arResult['user']['properties']['UF_PROFILE_STATUS']['XML_ID']) ?></div>
                                    </div>
                                </div>
                                <div class="profile-content">
                                    <div class="form-group">
                                        <div class="form-group__title"><?= Loc::getMessage('USER_PROFILE_TITLE_MYDATA') ?></div>
                                        <div class="form-group__block">
                                            <div class="form-group__row">
                                                <div class="form-group__col group-col--w50">
                                                    <div class="form-control form-group__control">
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_PLACEHOLDERS_LAST_NAME') ?>"
                                                               name="data[last_name]"
                                                               value="<?= $arResult['user']['LAST_NAME'] ?>">
                                                    </div>
                                                    <div class="form-control form-group__control">
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_PLACEHOLDERS_NAME') ?>"
                                                               name='data[name]'
                                                               value="<?= $arResult['user']['NAME'] ?>">
                                                    </div>
                                                    <div class="form-control form-group__control">
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_PLACEHOLDERS_SECOND_NAME') ?>"
                                                               name="data[second_name]"
                                                               value="<?= $arResult['user']['SECOND_NAME'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group__col group-col--w50">
                                                    <div class="form-control form-group__control">
                                                        <input class="form-input datepicker-here" type="text"
                                                               data-date-format="yyyy-mm-dd"
                                                               data-language="<?=SITE_ID?>"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_PLACEHOLDERS_BIRTHDAY') ?>"
                                                               name="data[personal_birthday]"
                                                               value="<? if (isset($arResult['user']['PERSONAL_BIRTHDAY_TRUE_WAY'])) {
                                                                   echo $arResult['user']['PERSONAL_BIRTHDAY_TRUE_WAY']->format('Y-m-d');
                                                               } ?>">
                                                    </div>
                                                    <div class="form-control form-group__control">
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_PLACEHOLDERS_CITY') ?>"
                                                               name="data[personal_city]"
                                                               value="<?= $arResult['user']['PERSONAL_CITY'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group__title"><?= Loc::getMessage('USER_PROFILE_TITLE_PROFDATA') ?></div>
                                        <div class="form-group__block">
                                            <div class="form-group__row">
                                                <div class="form-group__col group-col--w50">
                                                    <div class="form-control">
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_PLACEHOLDERS_SCHOOL') ?>"
                                                               name="data[uf_school]"
                                                               value="<?= $arResult['user']['UF_SCHOOL'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group__col group-col--w50">
                                                    <div class="form-control">
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_PLACEHOLDERS_SCHOOL_AREA') ?>"
                                                               name="data[uf_school_area]"
                                                               value="<?= $arResult['user']['UF_SCHOOL_AREA'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group__block">
                                            <div class="form-group__row row--inline form-group__row--mt form-group__row--mb">
                                                <div class="form-group__col">
                                                    <div class="form-control">
                                                        <input class="form-radio" type="radio"
                                                               name="data[uf_school_com]" id="shoolType1"
                                                               value="USER_PROFILE_OPTION_SCHOOL_COM_GOS" <? if ($arResult['user']['UF_SCHOOL_COM'] == 'USER_PROFILE_OPTION_SCHOOL_COM_GOS') {
                                                            echo ' checked';
                                                        } ?>>
                                                        <label class="form-radio__label"
                                                               for="shoolType1"><?= Loc::getMessage('USER_PROFILE_OPTION_SCHOOL_COM_GOS') ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group__col">
                                                    <div class="form-control">
                                                        <input class="form-radio" type="radio"
                                                               name="data[uf_school_com]" id="shoolType2"
                                                               value="USER_PROFILE_OPTION_SCHOOL_COM_NEGOS" <? if ($arResult['user']['UF_SCHOOL_COM'] == 'USER_PROFILE_OPTION_SCHOOL_COM_NEGOS') {
                                                            echo ' checked';
                                                        } ?>>
                                                        <label class="form-radio__label"
                                                               for="shoolType2"><?= Loc::getMessage('USER_PROFILE_OPTION_SCHOOL_COM_NEGOS') ?></label>
                                                    </div>
                                                </div>
												<div class="form-group__col">
													<div class="form-control">
														<input class="form-radio j_change_member_type" type="radio"
															   name="data[uf_member_type]" id="memberType1"
															   value="USER_PROFILE_OPTION_PERSON_TYPE_MEMBER" <? if ($arResult['user']['UF_MEMBER_TYPE'] == 'USER_PROFILE_OPTION_PERSON_TYPE_MEMBER') {
															echo ' checked';
														} ?>>
														<label class="form-radio__label"
															   for="memberType1"><?= Loc::getMessage('USER_PROFILE_OPTION_SCHOOL_MEMBER') ?></label>
													</div>
												</div>
												<div class="form-group__col">
													<div class="form-control">
														<input class="form-radio j_change_member_type" type="radio"
															   name="data[uf_member_type]" id="memberType2"
															   value="USER_PROFILE_OPTION_PERSON_TYPE_LISTENER" <? if ($arResult['user']['UF_MEMBER_TYPE'] == 'USER_PROFILE_OPTION_PERSON_TYPE_LISTENER') {
															echo ' checked';
														} ?>>
														<label class="form-radio__label"
															   for="memberType2"><?= Loc::getMessage('USER_PROFILE_OPTION_SCHOOL_LISTENER') ?></label>
													</div>
												</div>
                                            </div>
                                            <div class="form-group__row">
                                                <div class="form-group__col group-col--w50">
                                                    <div class="form-control form-group__control form-control--tooltip">
                                                        <i class="tooltip tooltip-btn tooltip-left"
                                                           title="<?= Loc::getMessage('USER_PROFILE_TOOLTIP_SCHOOL_TYPE') ?>"></i>
                                                        <!--select class="select-style select-js select-style__inline" name="data[uf_school_type]">
																	<? foreach ($arResult['selects']['USER_PROFILE_SELECT_SCHOOL_TYPE'] as $key => $value) { ?>
																	<option value="<?= $key ?>" <? if ($key == $arResult['user']['UF_SCHOOL_TYPE']) {
                                                            echo 'selected';
                                                        } ?>><?= $value ?></option>
																	<? } ?>
																</select-->
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_SELECT_SCHOOL_TYPE_TITLE') ?>"
                                                               name="data[uf_school_type]"
                                                               value="<?= $arResult['user']['UF_SCHOOL_TYPE'] ?>">
                                                    </div>
                                                    <div class="form-control form-group__control">
                                                        <select class="select-multiple select-style" multiple="multiple"
                                                                data-placeholder="<?= Loc::getMessage('USER_PROFILE_SELECT_LNG_TITLE') ?>"
                                                                name="data[uf_language][]">
                                                            <? $tmpLng = explode(',', $arResult['user']['UF_LANGUAGE']); ?>
                                                            <? foreach ($arResult['selects']['USER_PROFILE_SELECT_LANG'] as $key => $value) { ?>
                                                                <option value="<?= $key ?>" <? if (in_array($key, $tmpLng)) {
                                                                    echo 'selected';
                                                                } ?>><?= $value ?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-control form-group__control form-control--tooltip">
                                                        <i class="tooltip tooltip-btn tooltip-left"
                                                           title="<?= Loc::getMessage('USER_PROFILE_TOOLTIP_IM') ?>"></i>
                                                        <!--select class="select-multiple select-style" multiple="multiple" data-placeholder="<?= Loc::getMessage('USER_PROFILE_SELECT_IM_TITLE') ?>" name="data[uf_user_im][]">
																<? $tmpEdc = explode(',', $arResult['user']['UF_IM_TYPE']); ?>
																<? foreach ($arResult['selects']['USER_PROFILE_SELECT_IM_TYPE'] as $key => $value) { ?>
																	<option value="<?= $key ?>" <? if (in_array($key, $tmpEdc)) {
                                                            echo 'selected';
                                                        } ?>><?= $value ?></option>
																	<? } ?>
																</select-->
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_SELECT_IM_TITLE') ?>"
                                                               name="data[uf_user_im]"
                                                               value="<?= $arResult['user']['UF_IM_TYPE'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group__col group-col--w50">
                                                    <div class="form-control form-group__control">
                                                        <!--select class="select-js select-style" name="data[uf_specialty]">
																<? foreach ($arResult['selects']['USER_PROFILE_SELECT_SCHOOL_SPECIALTY'] as $key => $value) { ?>
																	<option value="<?= $key ?>" <? if ($key == $arResult['user']['UF_SPECIALTY']) {
                                                            echo 'selected';
                                                        } ?>><?= $value ?></option>
																	<? } ?>
																</select-->
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_SELECT_SCHOOL_SPECIALTY_TITLE') ?>"
                                                               name="data[uf_specialty]"
                                                               value="<?= $arResult['user']['UF_SPECIALTY'] ?>">
                                                    </div>
                                                    <div class="form-control form-group__control">
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_PLACEHOLDERS_EXPERIENCE') ?>"
                                                               name="data[uf_user_experience]"
                                                               value="<?= $arResult['user']['UF_USER_EXPERIENCE'] ?>">
                                                    </div>
                                                    <div class="form-control form-group__control">
                                                        <!--select class="select-js select-style"  name="data[uf_education]">
																<? foreach ($arResult['selects']['USER_PROFILE_SELECT_EDUCATION'] as $key => $value) { ?>
																	<option value="<?= $key ?>" <? if ($key == $arResult['user']['UF_EDUCATION']) {
                                                            echo 'selected';
                                                        } ?>><?= $value ?></option>
																	<? } ?>
																</select-->
                                                        <input class="form-input" type="text"
                                                               placeholder="<?= Loc::getMessage('USER_PROFILE_SELECT_EDUCATION_TITLE') ?>"
                                                               name="data[uf_education]"
                                                               value="<?= $arResult['user']['UF_EDUCATION'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-lg-32">
                                        <div class="form-group__title"><?= Loc::getMessage('USER_PROFILE_TITLE_PASSPORT') ?></div>
                                        <div class="form-group__block">
                                            <div class="form-group__row">
                                                <div class="form-group__col">
                                                    <div class="form-control">
                                                        <div class="file-load__block">
                                                            <input class="file-input" type="file"
                                                                   data-upload="file2upload" id="file_experience"
                                                                   name="file_experience">
                                                            <label class="btn-load__file"
                                                                   for="file_experience"><?= Loc::getMessage('USER_PROFILE_BUTTON_SELECT_FILE') ?></label>
                                                            <div class="file-load__content"
                                                                 id="file2upload" <?= !$arResult['show_confirm_button'] && $arResult['user']['UF_EXPERIENCE'] ? 'style="display:block"' : '' ?>>
                                                                <?= $arResult['user']['UF_EXPERIENCE_ARRAY']['ORIGINAL_NAME'] ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group__title"><?= Loc::getMessage('USER_PROFILE_TITLE_PROFDOC') ?></div>
                                        <div class="form-group__block">
                                            <div class="form-group__row">
                                                <div class="form-group__col">
                                                    <div class="form-control">
                                                        <div class="file-load__block">
                                                            <input class="file-input" type="file"
                                                                   data-upload="file3upload" id="file_profdoc"
                                                                   name="file_profdoc">
                                                            <label class="btn-load__file"
                                                                   for="file_profdoc"><?= Loc::getMessage('USER_PROFILE_BUTTON_SELECT_FILE') ?></label>
                                                            <div class="file-load__content"
                                                                 id="file3upload" <?= !$arResult['show_confirm_button'] && $arResult['user']['UF_FILE_PROFDOC'] ? 'style="display:block"' : '' ?>>
                                                                <?= $arResult['user']['UF_FILE_PROFDOC_ARRAY']['ORIGINAL_NAME'] ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group__title"><?= Loc::getMessage('USER_PROFILE_TITLE_LANG') ?></div>
                                        <div class="form-group__block">
                                            <div class="form-group__label"><?= Loc::getMessage('USER_PROFILE_TEXT_LANG') ?></div>
                                            <div class="clear"></div>
                                            <? $tmpParcLang = explode(',', $arResult['user']['UF_PARTICIPATION_LANG']); ?>
                                            <div class="form-group__row row--inline">
                                                <div class="form-group__col">
                                                    <div class="form-control">
                                                        <input class="form-checkbox" type="checkbox" id="language1"
                                                               name="data[uf_participation_lang][]"
                                                               value="USER_PROFILE_OPTION_PARTICIPATION_LANG_RU" <? if (in_array('USER_PROFILE_OPTION_PARTICIPATION_LANG_RU', $tmpParcLang)) {
                                                            echo ' checked';
                                                        } ?>>
                                                        <label class="form-label-checkbox"
                                                               for="language1"><?= Loc::getMessage('USER_PROFILE_OPTION_PARTICIPATION_LANG_RU') ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group__col">
                                                    <div class="form-control">
                                                        <input class="form-checkbox" type="checkbox" id="language2"
                                                               name="data[uf_participation_lang][]"
                                                               value="USER_PROFILE_OPTION_PARTICIPATION_LANG_KZ" <? if (in_array('USER_PROFILE_OPTION_PARTICIPATION_LANG_KZ', $tmpParcLang)) {
                                                            echo ' checked';
                                                        } ?>>
                                                        <label class="form-label-checkbox"
                                                               for="language2"><?= Loc::getMessage('USER_PROFILE_OPTION_PARTICIPATION_LANG_KZ') ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group__title"><?= Loc::getMessage('USER_PROFILE_TITLE_COMMENT') ?></div>
                                        <div class="form-group__block">
                                            <div class="form-group__label"><?= Loc::getMessage('USER_PROFILE_TEXT_COMMENT') ?></div>
                                            <div class="clear"></div>
                                            <? $tmpMtime = explode(',', $arResult['user']['UF_MEETUP_TIME']); ?>
                                            <div class="form-group__row row--inline form-group__row--mb">
                                                <div class="form-group__col">
                                                    <div class="form-control">
                                                        <input class="form-checkbox" type="checkbox" id="time1"
                                                               name="data[uf_meetup_time][]"
                                                               value="USER_PROFILE_OPTION_MEETUP_TIME_1" <? if (in_array('USER_PROFILE_OPTION_MEETUP_TIME_1', $tmpMtime)) {
                                                            echo ' checked';
                                                        } ?>>
                                                        <label class="form-label-checkbox"
                                                               for="time1"><?= Loc::getMessage('USER_PROFILE_OPTION_MEETUP_TIME_1') ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group__col">
                                                    <div class="form-control">
                                                        <input class="form-checkbox" type="checkbox" id="time2"
                                                               name="data[uf_meetup_time][]"
                                                               value="USER_PROFILE_OPTION_MEETUP_TIME_2" <? if (in_array('USER_PROFILE_OPTION_MEETUP_TIME_2', $tmpMtime)) {
                                                            echo ' checked';
                                                        } ?>>
                                                        <label class="form-label-checkbox"
                                                               for="time2"><?= Loc::getMessage('USER_PROFILE_OPTION_MEETUP_TIME_2') ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group__block">
                                            <div class="form-group__label"><?= Loc::getMessage('USER_PROFILE_TITLE_NOTES') ?></div>
                                            <div class="clear"></div>
                                            <div class="form-group__row">
                                                <div class="form-group__col">
                                                    <div class="form-control">
                                                        <textarea class="form-input"
                                                                  placeholder="<?= Loc::getMessage('USER_PROFILE_PLACEHOLDERS_USER_NOTES') ?>"
                                                                  name="data[uf_user_notes]"><?= $arResult['user']['UF_USER_NOTES'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group__status is-show">
                                        <div class="form-group__title"><?= Loc::getMessage('USER_PROFILE_TITLE_STATUS') ?></div>

                                        <div class="form-group__block">
                                            <div class="form-group__label form-label__status-<?= $arResult['status_css'][$arResult['user']['properties']['UF_PROFILE_STATUS']['XML_ID']] ?>"><?= Loc::getMessage('USER_PROFILE_STATUS_TEXT_' . $arResult['user']['properties']['UF_PROFILE_STATUS']['XML_ID']) ?><? if ($arResult['user']['properties']['UF_PROFILE_STATUS']['XML_ID'] == 'reject' && isset($arResult['user']['ADMIN_NOTES'])) {
                                                    echo $arResult['user']['ADMIN_NOTES'];
                                                } ?></div>
                                        </div>
                                    </div>
                                    <? if ($arResult['show_confirm_button']) { ?>
                                        <div class="form-group">
                                            <div class="form-group__block-action">
                                                <div class="form-group__block-action__head">
                                                    <div class="form-group__block-action__head-btn">
                                                        <button class="btn btn-blue btn-style--1"
                                                                type="submit"><?= Loc::getMessage('USER_PROFILE_BUTTON_SEND') ?></button>
                                                    </div>
                                                    <div class="form-group__error">
                                                        <div class="form-group__error-block"
                                                             style="display:none;"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group__block-action__body">
                                                    <div class="form-control">
                                                        <input class="form-checkbox" type="checkbox" id="formAgreement"
                                                               name="data[user_agreement]" value='1'>
                                                        <label class="form-label-checkbox"
                                                               for="formAgreement"><?= Loc::getMessage('USER_PROFILE_APPROVE_RULES') ?></label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php
$js = [
    'ERROR_FILE_TYPE' => Loc::getMessage('ERROR_FILE_TYPE'),
    'ERROR_FILE_SIZE' => Loc::getMessage('ERROR_FILE_SIZE'),
]
?>
<script>
    BX.message(<?=CUtil::PhpToJSObject($js)?>);

    $.fn.datepicker.language['<?=SITE_ID?>'] = {
        days: ['<?=Loc::getMessage('WEEK_DAY_7')?>', '<?=Loc::getMessage('WEEK_DAY_1')?>', '<?=Loc::getMessage('WEEK_DAY_2')?>', '<?=Loc::getMessage('WEEK_DAY_3')?>', '<?=Loc::getMessage('WEEK_DAY_4')?>', '<?=Loc::getMessage('WEEK_DAY_5')?>', '<?=Loc::getMessage('WEEK_DAY_6')?>'],
        daysShort: ['<?=Loc::getMessage('WEEK_DAY_SHORT_7')?>', '<?=Loc::getMessage('WEEK_DAY_SHORT_1')?>', '<?=Loc::getMessage('WEEK_DAY_SHORT_2')?>', '<?=Loc::getMessage('WEEK_DAY_SHORT_3')?>', '<?=Loc::getMessage('WEEK_DAY_SHORT_4')?>', '<?=Loc::getMessage('WEEK_DAY_SHORT_5')?>', '<?=Loc::getMessage('WEEK_DAY_SHORT_6')?>'],
        daysMin: ['<?=Loc::getMessage('WEEK_DAY_MIN_7')?>', '<?=Loc::getMessage('WEEK_DAY_MIN_1')?>', '<?=Loc::getMessage('WEEK_DAY_MIN_2')?>', '<?=Loc::getMessage('WEEK_DAY_MIN_3')?>', '<?=Loc::getMessage('WEEK_DAY_MIN_4')?>', '<?=Loc::getMessage('WEEK_DAY_MIN_5')?>', '<?=Loc::getMessage('WEEK_DAY_MIN_6')?>'],
        months: ['<?=Loc::getMessage('MONTH_1')?>', '<?=Loc::getMessage('MONTH_2')?>', '<?=Loc::getMessage('MONTH_3')?>', '<?=Loc::getMessage('MONTH_4')?>', '<?=Loc::getMessage('MONTH_5')?>', '<?=Loc::getMessage('MONTH_6')?>', '<?=Loc::getMessage('MONTH_7')?>', '<?=Loc::getMessage('MONTH_8')?>', '<?=Loc::getMessage('MONTH_9')?>', '<?=Loc::getMessage('MONTH_10')?>', '<?=Loc::getMessage('MONTH_11')?>', '<?=Loc::getMessage('MONTH_12')?>'],
        monthsShort: ['<?=Loc::getMessage('MONTH_SHORT_1')?>', '<?=Loc::getMessage('MONTH_SHORT_2')?>', '<?=Loc::getMessage('MONTH_SHORT_3')?>', '<?=Loc::getMessage('MONTH_SHORT_4')?>', '<?=Loc::getMessage('MONTH_SHORT_5')?>', '<?=Loc::getMessage('MONTH_SHORT_6')?>', '<?=Loc::getMessage('MONTH_SHORT_7')?>', '<?=Loc::getMessage('MONTH_SHORT_8')?>', '<?=Loc::getMessage('MONTH_SHORT_9')?>', '<?=Loc::getMessage('MONTH_SHORT_10')?>', '<?=Loc::getMessage('MONTH_SHORT_11')?>', '<?=Loc::getMessage('MONTH_SHORT_12')?>'],
        today: '<?=Loc::getMessage('TODAY')?>',
        clear: '<?=Loc::getMessage('CLEAR')?>',
        dateFormat: 'dd.mm.yyyy',
        timeFormat: 'hh:ii',
        firstDay: 1
    };
</script>