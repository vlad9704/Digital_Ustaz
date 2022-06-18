<?
//Какие вкладки показывать
if(!isset($user) || !$user){
    $userId = $GLOBALS["USER"]->GetId();
    $arUser = CUser::GetByID($userId)->Fetch();
    $user = $arUser;
}
$tabsStatus = getUserProfileTabsStatus($user);
//print_r($tabsStatus);
?>
<div class="profile-tabs">
    <ul class="profile-tabs__list<? if($tabsStatus['activity']['profile'] === false ||  $tabsStatus['tabs'] <= 2) { echo ' tabs-style-' . $tabsStatus['tabs']; }?>">
        <? if($tabsStatus['profile']) { ?><li class="<? if($tabsStatus['activity']['profile']) {echo 'is-active ';}?>profile-tab__item tab-item-1"><a class="profile-tab__btn" href="<? if(SITE_ID == 'ru') {echo '/ru';}?>/personal/profile/"><span><?=GetMessage('PROFILE_HEADER_MENU_PROFILE')?></span></a></li><? } ?>
        <? if($tabsStatus['competition']) { ?><li class="<? if($tabsStatus['activity']['competition']) {echo 'is-active ';}?>profile-tab__item tab-item-2 j_profile-tab__item_precent"><a class="profile-tab__btn" href="<?if(SITE_ID == 'ru') {echo '/ru';}?>/personal/competition/"><span><?=GetMessage('PROFILE_HEADER_MENU_PRIZE')?></span></a></li><? } ?>
        <? if($tabsStatus['learning']) { ?><li class="<? if($tabsStatus['activity']['learning']) {echo 'is-active ';}?>profile-tab__item tab-item-3"><a class="profile-tab__btn" href="<?if(SITE_ID == 'ru') {echo '/ru';}?>/personal/intensive/"><span><?=GetMessage('PROFILE_HEADER_MENU_LEARNING')?></span></a></li><? } ?>
    </ul>
</div>
