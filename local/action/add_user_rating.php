<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Loader;

Loader::includeModule('main');
Loader::includeModule('iblock');

$el = new CIBlockElement;

$arParams['SELECT'] = ['ID'];

$arResult = [
	'МУНБАЕВ Болат Ханатович' => '15',
	'Ибрагимов Нуржан Едилович' => '15',
	'Динабекова Алина Айбековна' => '15',
	'Исаев Ануар Асанович' => '15',
	'Жарболова Молдир Турсынгазыевна' => '15',
	'Какенова Жанна Сабырбекқызы' => '15',
	'Кыстауова ВЕНЕРА Кабылхановна' => '14',
	'Белоущенко Анастасия Сергеевна' => '14',
	'Алипбек Дамира Нурлановна' => '14',
	'Оразбахова Динара Бахытжановна' => '14',
	'Сайдахметова Гульдана Қанатқызы' => '13',
	'Каспихан Бауыржан Каспиханұлы' => '13',
	'Умирзаков Умирбек Асхатович' => '13',
	'Амалбекова Лунара Еркиновна' => '13',
	'Қожбанов Жұбаныш Мәлікұлы' => '13',
	'Исламова Айгерим Токтаржановна' => '13',
	'Есенгалиев Cанат Турганулы' => '12,7',
	'Махамбетова Газиза Ерсалатовна' => '12,5',
	'Мекебаева Айнур Алибековна' => '12',
	'Ташкенбаева Айгерим Турегелдиевна' => '12',
	'Төкен Бексұлтан Нұржанұлы' => '12',
	'Таныштыбаева Гаухар' => '12',
	'Бегимбетова Багила Еркебаевна' => '12',
	'Сансызбаева Гүлзат Сенімқызы' => '11',
	'Гончарук Татьяна' => '11',
	'Альшанова Жулдуз Сериковна' => '11',
	'Спиридопуло Василина Сергеевна' => '11',
	'Сарсембаева Багдагул Бақытқызы' => '11',
	'Кенесбай Гулнур Айбековна' => '10,7',
	'Чаева Айдана Кайратовна' => '10,7',
	'Реймбай Дәмелі' => '10,6',
	'Салимов Дастан Маликович' => '10,5',
	'Ауылбай Нұржан' => '10,3',
	'Абдрахманова Венера Талғатқызы' => '10',
	'Абухан Нұржан Нұрғалиұлы' => '10',
	'Әбдірайым Балнұр' => '10',
	'Мәсіпов Бауыржан Бақытжанұлы' => '10',
	'Есбосинова Раушан' => '10',
	'Грашман Анжелла' => '10',
	'Баймұханбетова Әсем Айдарханқызы' => '10',
	'МУСТАНОВА Назерке Жайлаукановна' => '10',
	'Медина Қасен Қасен' => '10',
	'Лаханова Бақытжамал Әріпханқызы' => '9,3',
	'Мақұлбек Әзиза Ақылбекқызы' => '9',
	'Жеңісова Меруерт Амангелдіқызы' => '9',
	'Айтметова Шолпан Алламуратовна' => '9',
	'Жумагереева Ару Онгаровна' => '9',
	'Кептербекова Гулбағым Кептербекқызы' => '9',
	'Айдар Дидар Нұрбекқызы' => '8,6',
	'Сеилканов Сатбек Аскарович' => '5,3',
	'Жаймаева Альбина Нурлыбековна' => '8',
	'Ерғалымова Жанна Ерғалымқызы' => '8',
	'Амирканова Дина Муктаровна' => '8',
	'Бейсебаева Сауле' => '8',
	'Дүтбаева Айдана Айбекқызы' => '8',
	'Прокопенко Алена' => '8',
	'Әмірбек Нұрсұлтан Оразгелдіұлы' => '8',
	'Бостанов Мейірбек Мамадаліұлы' => '8',
	'Клименко Эвелина Витальевна' => '8',
	'Ибдиминова Гульнара Ахтямовна' => '8',
	'Ұлжан Атілғазы' => '8',
	'Кенжегалиева Данагуль Нурлыбековна' => '7,6',
	'Тегис Әсел Тегісқызы' => '7,5',
	'Сабырова Арайлым' => '7,5',
	'Ұзақова Алуа Нұрлыбекқызы' => '7,4',
	'Жақсыбаев Ерқанат Серікұлы' => '7',
	'Темирешова Нургул Насебенқызы' => '7',
	'Назарбекова Айзат Сериккажыевна' => '7',
	'Саурбаева Айгуль Рысдавлетовна' => '7',
	'Маратұлы Мухаммедзаңғар' => '7',
	'Сыдыққұл Индира Ернатқызы' => '7',
	'Шәми Гүлназ Cәкенқызы' => '7',
	'Серіков Нұрлыбек Серікұлы' => '7',
	'Жанатбекова Райгуль Жанатбеккызы' => '6,7',
	'Тулепбергенова Алима Базарбековна' => '6,6',
	'Исмаил Ақерке Жақанқызы' => '6,5',
	'Торғанбеков Асан Ержанұлы' => '6',
	'Алдаберганова Гулбарчин Бакиткизи' => '6',
	'Алпысбай Қалаулым Мұхитқызы' => '6',
	'Турсунова Зумрат Нуршидиновна' => '6',
	'Терновая Анастасия Сергеевна' => '5,6',
	'Жумабекова Нурсулу Сейтазимовна' => '5,3',
	'Даниярова Әйгерім Даниярқызы' => '5',
	'Спанәлі Назерке Тәжібайқызы' => '5',
	'Мухпулова Румилям Эльмуратовна' => '5',
	'Тәутенбаева Айжан Жұмаділләқызы' => '5',
	'Айтбекова Инабат Дүйсенғалиқызы' => '4',
	'Ыдырысова Айжан Нурболатқызы' => '4',
	'Сапарбай Маржан Қанатқызы' => '4',
	'Қожақ Ләззат Мұратқызы' => '3,6',
	'Рахымханқызы Назерке' => '3,6',
	'Шоханова Тоқжан Асқарқызы' => '3,3',
	'Дүйсенбиев Алмас Маратұлы' => '3',
	'Гульнар Мархмадова' => '3',
	'Sangulova Altynay Alibekovna' => '3',
	'Ахметова Сахибам Сайдалимовна' => '3',
	'Терентьева Татьяна' => '2,3',
	'Нуржанова Самал Малькеевна' => '0'
];

$arUsers = [
	'МУНБАЕВ Болат Ханатович',
	'Ибрагимов Нуржан Едилович',
	'Динабекова Алина Айбековна',
	'Исаев Ануар Асанович',
	'Жарболова Молдир Турсынгазыевна',
	'Какенова Жанна Сабырбекқызы',
	'Кыстауова ВЕНЕРА Кабылхановна',
	'Белоущенко Анастасия Сергеевна',
	'Алипбек Дамира Нурлановна',
	'Оразбахова Динара Бахытжановна',
	'Сайдахметова Гульдана Қанатқызы',
	'Каспихан Бауыржан Каспиханұлы',
	'Умирзаков Умирбек Асхатович',
	'Амалбекова Лунара Еркиновна',
	'Қожбанов Жұбаныш Мәлікұлы',
	'Исламова Айгерим Токтаржановна',
	'Есенгалиев Cанат Турганулы',
	'Махамбетова Газиза Ерсалатовна',
	'Мекебаева Айнур Алибековна',
	'Ташкенбаева Айгерим Турегелдиевна',
	'Төкен Бексұлтан Нұржанұлы',
	'Таныштыбаева Гаухар',
	'Бегимбетова Багила Еркебаевна',
	'Сансызбаева Гүлзат Сенімқызы',
	'Гончарук Татьяна',
	'Альшанова Жулдуз Сериковна',
	'Спиридопуло Василина Сергеевна',
	'Сарсембаева Багдагул Бақытқызы',
	'Кенесбай Гулнур Айбековна',
	'Чаева Айдана Кайратовна',
	'Реймбай Дәмелі',
	'Салимов Дастан Маликович',
	'Ауылбай Нұржан',
	'Абдрахманова Венера Талғатқызы',
	'Абухан Нұржан Нұрғалиұлы',
	'Әбдірайым Балнұр',
	'Мәсіпов Бауыржан Бақытжанұлы',
	'Есбосинова Раушан',
	'Грашман Анжелла',
	'Баймұханбетова Әсем Айдарханқызы',
	'МУСТАНОВА Назерке Жайлаукановна',
	'Медина Қасен Қасен',
	'Лаханова Бақытжамал Әріпханқызы',
	'Мақұлбек Әзиза Ақылбекқызы',
	'Жеңісова Меруерт Амангелдіқызы',
	'Айтметова Шолпан Алламуратовна',
	'Жумагереева Ару Онгаровна',
	'Кептербекова Гулбағым Кептербекқызы',
	'Айдар Дидар Нұрбекқызы',
	'Сеилканов Сатбек Аскарович',
	'Жаймаева Альбина Нурлыбековна',
	'Ерғалымова Жанна Ерғалымқызы',
	'Амирканова Дина Муктаровна',
	'Бейсебаева Сауле',
	'Дүтбаева Айдана Айбекқызы',
	'Прокопенко Алена',
	'Әмірбек Нұрсұлтан Оразгелдіұлы',
	'Бостанов Мейірбек Мамадаліұлы',
	'Клименко Эвелина Витальевна',
	'Ибдиминова Гульнара Ахтямовна',
	'Ұлжан Атілғазы',
	'Кенжегалиева Данагуль Нурлыбековна',
	'Тегис Әсел Тегісқызы',
	'Сабырова Арайлым',
	'Ұзақова Алуа Нұрлыбекқызы',
	'Жақсыбаев Ерқанат Серікұлы',
	'Темирешова Нургул Насебенқызы',
	'Назарбекова Айзат Сериккажыевна',
	'Саурбаева Айгуль Рысдавлетовна',
	'Маратұлы Мухаммедзаңғар',
	'Сыдыққұл Индира Ернатқызы',
	'Шәми Гүлназ Cәкенқызы',
	'Серіков Нұрлыбек Серікұлы',
	'Жанатбекова Райгуль Жанатбеккызы',
	'Тулепбергенова Алима Базарбековна',
	'Исмаил Ақерке Жақанқызы',
	'Торғанбеков Асан Ержанұлы',
	'Алдаберганова Гулбарчин Бакиткизи',
	'Алпысбай Қалаулым Мұхитқызы',
	'Турсунова Зумрат Нуршидиновна',
	'Терновая Анастасия Сергеевна',
	'Жумабекова Нурсулу Сейтазимовна',
	'Даниярова Әйгерім Даниярқызы',
	'Спанәлі Назерке Тәжібайқызы',
	'Мухпулова Румилям Эльмуратовна',
	'Тәутенбаева Айжан Жұмаділләқызы',
	'Айтбекова Инабат Дүйсенғалиқызы',
	'Ыдырысова Айжан Нурболатқызы',
	'Сапарбай Маржан Қанатқызы',
	'Қожақ Ләззат Мұратқызы',
	'Рахымханқызы Назерке',
	'Шоханова Тоқжан Асқарқызы',
	'Дүйсенбиев Алмас Маратұлы',
	'Гульнар Мархмадова',
	'Sangulova Altynay Alibekovna',
	'Ахметова Сахибам Сайдалимовна',
	'Терентьева Татьяна',
	'Нуржанова Самал Малькеевна'
];

$user = new CUser;

foreach ( $arUsers as $arUser )
{
	$arRes = $user->getList([], 'asc', ['NAME' => $arUser], $arParams);
	while($res = $arRes->getNext())
	{
		$arFindUsers[$res['ID']] = [
			'ID' => $res['ID'],
			'FIO' => trim($res['LAST_NAME']).' '.trim($res['NAME']).' '.trim($res['SECOND_NAME'])
		];
	}
}

/*foreach ( $arFindUsers as $arFindUser )
{
	$id = $el->add(['NAME' => $arFindUser['FIO'], 'IBLOCK_ID' => 30]);
	$el->SetPropertyValuesEx($id, false, ['RATING_BALL' => $arResult[$arFindUser['FIO']], 'USER_MEMBER' => $arFindUser['ID']]);
}*/