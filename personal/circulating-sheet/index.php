<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty('show_title', 'N');
$APPLICATION->SetTitle("Оборотная ведомость");
?>
<h2>Оборотная <em>ведомость</em></h2>

<?$APPLICATION->IncludeComponent("citrus:tszh.sheet", ".default", array(
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "300",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Периоды",
	"PAGER_SHOW_ALWAYS" => "Y",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "Y",
	"MAX_COUNT" => "10"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>