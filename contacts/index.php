<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("show_title", "N");
$APPLICATION->SetPageProperty("title", "Контакты компании");
$APPLICATION->SetTitle("Контакты");
?>
<h2>Контактная информация</h2>
<?$APPLICATION->IncludeComponent(
	"citrus:tszh.contacts",
	"page_custom",
	Array(
		"TSZH_ID" => "__TSZH_ALL__",
		"CACHE_TYPE"  =>  "A",
		"CACHE_TIME"  =>  36000000,

		"SHOW_MAP" => "Y",
		"MAP_INIT_MAP_TYPE" => "MAP",
		"MAP_MAP_WIDTH" => "370",
		"MAP_MAP_HEIGHT" => "300",
		"MAP_CONTROLS" => array("ZOOM", "TYPECONTROL", "SCALELINE"),
		"MAP_OPTIONS" => array("ENABLE_SCROLL_ZOOM", "ENABLE_DBLCLICK_ZOOM", "ENABLE_DRAGGING"),

		"SHOW_FEEDBACK_FORM" => "Y",
		"FEEDBACK_FORM_USE_CAPTCHA" => "Y",
		"FEEDBACK_FORM_OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"FEEDBACK_FORM_EMAIL_TO" => "",
		"FEEDBACK_FORM_REQUIRED_FIELDS" => array("NAME", "EMAIL", "MESSAGE"),
		"FEEDBACK_FORM_EVENT_MESSAGE_ID" => array(),
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
