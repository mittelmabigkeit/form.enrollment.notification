<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * */
 
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if( !Loader::includeModule("iblock") ) {
	throw new \Exception('Не загружены модули необходимые для работы компонента');
}

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = [];
$iblockFilter = !empty($arCurrentValues['IBLOCK_TYPE'])
	? ['TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y']
	: ['ACTIVE' => 'Y'];

$rsIBlock = CIBlock::GetList(['SORT' => 'ASC'], $iblockFilter);
while ($arr = $rsIBlock->Fetch()) {
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
}
unset($arr, $rsIBlock, $iblockFilter);

$arComponentParameters = [
    "AJAX_MODE" => [],
	"GROUPS" => [
		"SETTINGS" => [
			"NAME" => Loc::getMessage('AMIGOLAB_FORM_PROP_SETTINGS'),
			"SORT" => 500,
		],
		"SETTINGS_DOP" => [
			"NAME" => Loc::getMessage('AMIGOLAB_FORM_PROP_SETTINGS_DOP'),
			"SORT" => 600,
		]
	],
	"PARAMETERS" => [
		"IBLOCK_TYPE" => [
			"PARENT" => "SETTINGS",
			"NAME" => Loc::getMessage('AMIGOLAB_FORM_PROP_IBLOCK_TYPE'),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y"
		],
		"IBLOCK_ID" => [
			"PARENT" => "SETTINGS",
			"NAME" => Loc::getMessage('AMIGOLAB_FORM_PROP_IBLOCK_ID'),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y"
		],
		"PRODUCT_ID" => [
			"PARENT" => "SETTINGS_DOP",
			"NAME" => Loc::getMessage('AMIGOLAB_FORM_PROP_PRODUCT_ID'),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "",
			"COLS" => 25
		],
		"PRODUCT_NAME" => [
			"PARENT" => "SETTINGS_DOP",
			"NAME" => Loc::getMessage('AMIGOLAB_FORM_PROP_PRODUCT_NAME'),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "",
			"COLS" => 25
		],
		'CACHE_TIME' => ['DEFAULT' => 3600]
	]
];
?>