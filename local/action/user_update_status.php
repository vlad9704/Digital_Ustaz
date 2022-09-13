<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Loader;

Loader::includeModule('main');

$arParams['SELECT'] = ['UF_PROFILE_STATUS'];

$user = new CUser;

$arRes = $user->getList([], 'asc', [], $arParams);
while($res = $arRes->Fetch())
{
	$rsRes = CUserFieldEnum::GetList(array(), array(
		'ID' => $res['UF_PROFILE_STATUS'],
	));
	if ( $arGender = $rsRes->GetNext() )
	{
		if($arGender['VALUE'] == 'Требуются правки' || $arGender['VALUE'] == 'Редактируется' || $arGender['VALUE'] == 'На модерации')
			$user->Update($res['ID'], ['UF_PROFILE_STATUS' => 3]);
	}
}