<?php

/**
 * Определим путь до включаемых областей в зависимости от текущего SITE_ID
 */
switch(SITE_ID){
    case 'kz':
        /**
         * Включемые области для казахстана
         */
        define('INCLUDE_PATH', '/local/templates/ustaz/include_areas/kz/');
        break;
    case 'ru':
        /**
         * Включаемые области для версии на русском
         */
        define('INCLUDE_PATH', '/local/templates/ustaz/include_areas/ru/');
        break;
    default:
        /**
         *  Сайт не найден
         */
        throw new Exception("Не могу обрбаотать текущий SITE_ID - " . SITE_ID);
}

/**
 * Путь до файлов верстки (css, js etc). В будущем будет заменен на CDN 
 * Со слешем на конце.
 */
define('STATIC_PATH', 'https://static.almatyustazy.kz/');

/**
 * Инфоблоки
 */
//Главная страница
define('IBLOCK_ID_MAIN_INFO_SLIDER', getIblockIdByCode('main_info_slider'));
define('IBLOCK_ID_MAIN_STAGES', getIblockIdByCode('main_stages'));
define('IBLOCK_ID_MAIN_SPEAKERS', getIblockIdByCode('main_speakers'));
define('IBLOCK_ID_MAIN_PARTICIPANT', getIblockIdByCode('main_participant'));
define('IBLOCK_ID_MAIN_PRIZES', getIblockIdByCode('main_prizes'));
define('IBLOCK_ID_MAIN_ADVICE', getIblockIdByCode('main_advice'));
define('IBLOCK_ID_MAIN_ORGAN', getIblockIdByCode('main_organizators'));
define('IBLOCK_ID_MAIN_GENERAL', getIblockIdByCode('main_general'));
//Частые вопросы
define('IBLOCK_ID_FAQ', getIblockIdByCode('faq_list'));

//Конкурс
define('IBLOCK_COMPETITION_WORKS', getIblockIdByCode('competition_works'));
define('IBLOCK_COMPETITION_WORKS_RATING', getIblockIdByCode('works_evaluation'));
define('IBLOCK_COMPETITION_RATING_CRITERIA', getIblockIdByCode('criteria_for_evaluation'));

//Подпорка книг
define('IBLOCK_ID_BOOKS', getIblockIdByCode('books'));
define('IBLOCK_ID_BOOK_AUTHOR', getIblockIdByCode('authors'));

//Вебинары
define('IBLOCK_ID_WEBINARS', getIblockIdByCode('webinars'));
$arFilter1 = Array("IBLOCK_ID"=>2, "ID"=>6);
$res1 = CIBlockElement::GetList(Array(), $arFilter1); 
if ($ob1 = $res1->GetNextElement()){
    $arProps1 = $ob1->GetProperties(); 
   }
$arFilter2 = Array("IBLOCK_ID"=>2, "ID"=>7);
$res2 = CIBlockElement::GetList(Array(), $arFilter2); 
if ($ob2 = $res2->GetNextElement()){
    $arProps2 = $ob2->GetProperties(); 
   }
 $arFilter3 = Array("IBLOCK_ID"=>2, "ID"=>8);
$res3 = CIBlockElement::GetList(Array(), $arFilter3); 
if ($ob3 = $res3->GetNextElement()){
    $arProps3 = $ob3->GetProperties(); 
   }
 $arFilter4 = Array("IBLOCK_ID"=>2, "ID"=>7221);
$res4 = CIBlockElement::GetList(Array(), $arFilter4); 
if ($ob4 = $res4->GetNextElement()){
    $arProps4 = $ob4->GetProperties(); 
   }
/**
 * Последнее число приема заявок
 */
$MAINCOUNTDOWN = $arProps1[stage_date][VALUE];
$MAINCOUNTDOWN2 = $arProps2[stage_date][VALUE];
$MAINCOUNTDOWN3 = $arProps3[stage_date][VALUE];
$MAINCOUNTDOWN4 = $arProps4[stage_date][VALUE];
 define('MAIN_PAGE_COUNTDOWN',date($MAINCOUNTDOWN4));
 
/**
 * Получатель писем из формы обратной связи
 */
 define('FEEDBACK_RECIPIENT', 'main@digitalustazalmaty.kz');
 
/**
 * Даты окончания приема заявок для 1-2-3 этапа конкурса
 */
 define('COMPETITION_COUNTDOWN_STAGE_1', date($MAINCOUNTDOWN));
 define('COMPETITION_COUNTDOWN_STAGE_2', date($MAINCOUNTDOWN2));
 define('COMPETITION_COUNTDOWN_STAGE_3', date($MAINCOUNTDOWN3));

//Список стадий конкурса, по которым не принимаются работы
$disabledStages = [];
if (date($MAINCOUNTDOWN) <= date('d.m.Y H:i:s')){
    $disabledStages[] = 1;
}
if (date($MAINCOUNTDOWN2) <= date('d.m.Y H:i:s')){
    $disabledStages[] = 2;
}
if (date($MAINCOUNTDOWN3) <= date('d.m.Y H:i:s')){
    $disabledStages[] = 3;
}

define('DISABLED_STAGES', $disabledStages);

 /**
  * Идентификаторы языков для экспертов
  */
 define('EXPERT_LANG', [
     'ru' => 9,
     'kz' => 10,
 ]);

 
