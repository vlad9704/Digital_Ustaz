<?php
CModule::IncludeModule("iblock");

require_once 'include/functions.php';
require_once 'include/constants.php';
require_once 'include/events.php';

/**
 * Включим отладку для языковых файлов.
 */
define('BX_MESS_LOG', $_SERVER['DOCUMENT_ROOT'] . '/localization.log');

/**
 * Необходимо для подключения модуля:
 * Отправка электронной почты через SMTP
 * https://marketplace.1c-bitrix.ru/solutions/wsrubi.smtp/
 */
include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");

//var_dump(SITE_TEMPLATE_PATH);
//echo SITE_TEMPLATE_PATH . "12";
//echo "123";


AddEventHandler('main', 'OnEpilog', '_Check404Error', 1);
function _Check404Error()
{
    if (defined('ERROR_404') && ERROR_404 == 'Y') {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        //include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/404.php';
        //include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';
    }
}


AddEventHandler('main', 'OnChangeUserProfileStatus', 'OnChangeUserStatus', 1);
AddEventHandler("main", "OnBeforeUserUpdate", array("UserUpdateEvent", "OnBeforeUserUpdateHandler"));
AddEventHandler("main", "OnAfterUserUpdate", array("UserUpdateEvent", "OnAfterUserUpdateHandler"));

/**
 * @param int $statusId Новый статус анкеты 1 - редактируется 2 - на модерации 3 - одобрена 4 - требуется правка
 * @param int $userId идентификатор пользователя
 */
function OnChangeUserStatus($statusId, $oldStatusId, $userId, $lid)
{
    $statusId = (int)$statusId;
    $oldStatusId = (int)$oldStatusId;
    $userId = (int)$userId;

    //Идентификатор сайта, от этого зависит текст уведомления
    if (!$lid) {
        $lid = SITE_ID;
    }

    if (!$statusId || !$userId) {
        return;
    }

    //Если статус не изменился
    if ($oldStatusId == $statusId) {
        return;
    }

    $user = \Bitrix\Main\UserTable::getById($userId)->fetch();
    if (!$user) {

        return;
    }

    $oldStatus = CUserFieldEnum::GetList([], ['ID' => $oldStatusId])->Fetch();
    $status = CUserFieldEnum::GetList([], ['ID' => $statusId])->Fetch();

    //ФИО
    $fullname = implode(' ', array_diff([$user['LAST_NAME'], $user['NAME'], $user['SECOND_NAME']], ['']));

    $emailFields = [
        "USER_NAME" => $fullname,
        "USER_EMAIL" => $user['EMAIL'],
        "USER_ID" => $user['ID'],
        "NEW_STATUS" => $status['VALUE'] ?? $statusId,
        "OLD_STATUS" => $oldStatus['VALUE'] ?? '',
    ];

    if ($statusId == 2) {
        //Отправляем сообщение менеджеру
        \Bitrix\Main\Mail\Event::send([
            "EVENT_NAME" => "CHANGE_USER_STATUS_MANAGER",
            "LID" => $lid,
            "C_FIELDS" => $emailFields,
        ]);
    } elseif (in_array($statusId, [3, 4])) {
        //Отправляем сообщение пользователю
        \Bitrix\Main\Mail\Event::send([
            "EVENT_NAME" => "CHANGE_USER_STATUS",
            "LID" => $lid,
            "C_FIELDS" => $emailFields,
        ]);
    }
}


class UserUpdateEvent
{
    public static $oldStatusId = 0;

    function OnBeforeUserUpdateHandler(&$arFields)
    {
        $arUser = CUser::GetByID($arFields['ID'])->Fetch();
        if ($arUser) {
            self::$oldStatusId = $arUser['UF_PROFILE_STATUS'];
        }

        //Если не установлена стадия и статус анкеты "Одобрен", переводим пользователя на 1 этам
        if (!$arFields['UF_COMPETITION_STAGE'] && $arFields['UF_PROFILE_STATUS'] == 3){
            $arFields['UF_COMPETITION_STAGE'] = 5;
        }
    }

    function OnAfterUserUpdateHandler($arFields)
    {
        //Если пользователь изменен, запускаем событие смены статуса
        if ($arFields['RESULT']) {
            $event = new \Bitrix\Main\Event('main', 'OnChangeUserProfileStatus', [
                'status_id' => $arFields['UF_PROFILE_STATUS'],
                'oldStatusId' => self::$oldStatusId,
                'user_id' => $arFields['ID'],
                'lid' => $arFields['LID']
            ]);

            $event->send();
        }
    }
}

AddEventHandler("iblock", "OnIBlockPropertyBuildList", array("CIBlockPropertyExpertId", "GetUserTypeDescription"));
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/tools/prop_userid.php');

class CIBlockPropertyExpertId extends CIBlockPropertyUserID
{
    const USER_TYPE = 'UserExpertID';

    public static function GetUserTypeDescription()
    {
        return array(
            "PROPERTY_TYPE" => "S",
            "USER_TYPE" => self::USER_TYPE,
            "DESCRIPTION" => 'Привязка к экспертам',
            "GetAdminListViewHTML" => array(__CLASS__, "GetAdminListViewHTML"),
            "GetPropertyFieldHtml" => array(__CLASS__, "GetPropertyFieldHtml"),
            "ConvertToDB" => array(__CLASS__, "ConvertToDB"),
            "ConvertFromDB" => array(__CLASS__, "ConvertFromDB"),
            "GetSettingsHTML" => array(__CLASS__, "GetSettingsHTML"),
            "AddFilterFields" => array(__CLASS__, 'AddFilterFields'),
            "GetAdminFilterHTML" => array(__CLASS__, "GetAdminFilterHTML"),
            "GetUIFilterProperty" => array(__CLASS__, 'GetUIFilterProperty')
        );
    }

    public static function GetAdminListViewHTML($arProperty, $value, $strHTMLControlName)
    {
        static $cache = array();
        $value = intval($value["VALUE"]);
        if (!array_key_exists($value, $cache)) {
            $rsUsers = CUser::GetList($by, $order, array("ID" => $value, 'GROUPS_ID' => 5));
            $cache[$value] = $rsUsers->Fetch();
        }
        $arUser = $cache[$value];
        if ($arUser) {
            return "[<a title='" . GetMessage("MAIN_EDIT_USER_PROFILE") . "' href='user_edit.php?ID=" . $arUser["ID"] . "&lang=" . LANGUAGE_ID . "'>" . $arUser["ID"] . "</a>]&nbsp;(" . htmlspecialcharsbx($arUser["LOGIN"]) . ") " . htmlspecialcharsbx($arUser["NAME"]) . " " . htmlspecialcharsbx($arUser["LAST_NAME"]);
        } else
            return "&nbsp;";
    }

    //PARAMETERS:
    //$arProperty - b_iblock_property.*
    //$value - array("VALUE","DESCRIPTION") -- here comes HTML form value
    //strHTMLControlName - array("VALUE","DESCRIPTION")
    //return:
    //safe html

    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        $selectOptions = '<option value="">Не указан</option>';
        $rsUsers = CUser::GetList($by, $order, array("ID" => $value, 'GROUPS_ID' => 5));
        while ($user = $rsUsers->GetNext()){
            $selected = $value['VALUE'] == $user['ID'] ? 'selected' : '';
            $selectOptions .= '<option '.$selected.' value="'.$user['ID'].'">'.$user['NAME'].' '.$user['LAST_NAME'].' ['.$user['ID'].']'.'</option>';
        }

        $return = '<select name="'.htmlspecialcharsbx($strHTMLControlName["VALUE"]).'">'.$selectOptions.'</select>';

        return $return;
    }
}

AddEventHandler("main", "OnBeforeProlog", "ExpertOnBeforePrologHandler", 50);

function ExpertOnBeforePrologHandler()
{
    $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

    if ($request->getQuery('logout') != 'yes' && !$request->isAjaxRequest()) {
        global $USER, $APPLICATION;
        $prefix = (SITE_ID == 'ru' ? '/ru' : '');
        if ($USER->IsAuthorized() && CSite::InGroup([5])) {
            $user = CUser::GetByID($USER->GetID())->Fetch();
            if (!$user['UF_EXPERT_AGREEMENT'] || $user['UF_EXPERT_AGREEMENT'] === 'N') {
                if ($request->getQuery('agree') && $request->getQuery('agree') === $_SESSION['agree_uniqid']) {
                    (new CUser())->Update($user['ID'], ['UF_EXPERT_AGREEMENT' => 'Y']);
                    unset($_SESSION['agree_uniqid']);
                } elseif (strpos($APPLICATION->GetCurPage(), '/agreement.php') === false) {
                    LocalRedirect($prefix . "/personal/expert/agreement.php");
                }
            }
        }

        if (strpos($APPLICATION->GetCurPage(), '/personal/') !== false) {
            if (!$USER->IsAuthorized()) {
                LocalRedirect($prefix . '/#modalLogin');
            } elseif (CSite::InGroup([5]) && strpos($APPLICATION->GetCurPage(), '/personal/expert') === false) {
                LocalRedirect($prefix . '/personal/expert/');
            }
        }
    }
}













