<?php


AddEventHandler('main', 'OnAdminContextMenuShow', 'OrderDetailAdminContextMenuShow');
function OrderDetailAdminContextMenuShow(&$items){
    if (
        $_SERVER['REQUEST_METHOD']=='GET' &&
        $GLOBALS['APPLICATION']->GetCurPage()=='/bitrix/admin/iblock_list_admin.php' &&
         $_REQUEST['IBLOCK_ID'] = IBLOCK_COMPETITION_WORKS_RATING
    ) {
        $items[] = array(
            "TEXT"=>"Экспорт оценок",
            "LINK"=>"/local/admin/export/export_work_rating.php",
            "TITLE"=>"Экспорт оценок",
            "ICON"=>"btn_new",
        );

        $items[] = array(
            "TEXT"=>"Перевести на 2 этап",
            "LINK"=>"/local/admin/export/change_user_stage.php",
            "TITLE"=>"Перевести на 2 этап",
            "ICON"=>"btn_new",
            "LINK_PARAM" => 'onclick="return confirm(\'Вы уверены?\')"'
        );

        $items[] = array(
            "TEXT"=>"Экспорт пользователей",
            "LINK"=>"/local/admin/export/export_users.php",
            "TITLE"=>"Экспорт пользователей",
            "ICON"=>"btn_new",
        );

        $items[] = array(
            "TEXT"=>"Статистика по экспертам (1 этап)",
            "LINK"=>"/local/admin/export/experts_statistics.php?stage=1",
            "TITLE"=>"Экспорт статистики по экспертам",
            "ICON"=>"btn_new",
        );

        $items[] = array(
            "TEXT"=>"Статистика по экспертам (2 этап)",
            "LINK"=>"/local/admin/export/experts_statistics.php?stage=2",
            "TITLE"=>"Экспорт статистики по экспертам",
            "ICON"=>"btn_new",
        );

        $items[] = array(
            "TEXT"=>"Статистика по экспертам (3 этап)",
            "LINK"=>"/local/admin/export/experts_statistics.php?stage=3",
            "TITLE"=>"Экспорт статистики по экспертам",
            "ICON"=>"btn_new",
        );
    }
}