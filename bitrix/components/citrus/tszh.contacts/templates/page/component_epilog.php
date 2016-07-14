<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!$this->__template)
{
	$template = new CBitrixComponentTemplate();
	$template->Init($this);
	$this->__template = $template;
}

$html = $arResult["TEMPLATE_HTML"];

if (preg_match_all('/<#MAP_(\d+)#>/', $html, $arMatches))
{
	$arMapHtml = array();
	foreach ($arMatches[1] as $key => $tszhID):
		ob_start();?>
		<?$APPLICATION->IncludeComponent(
			"citrus:map.yandex.address",
			".default",
			array(
				"INIT_MAP_TYPE" => $arParams["MAP_INIT_MAP_TYPE"],
				"NAME" => htmlspecialcharsBack($arResult["ITEMS"][$tszhID]["NAME"]),
				"BODY" => "",
				"ADDRESS" => $arResult["ITEMS"][$tszhID]["ADDRESS"],
				"MAP_WIDTH" => $arParams["MAP_MAP_WIDTH"],
				"MAP_HEIGHT" => $arParams["MAP_MAP_HEIGHT"],
				"CONTROLS" => $arParams["MAP_CONTROLS"],
				"OPTIONS" => $arParams["MAP_OPTIONS"],
				"TSZH_ID" => $tszhID
			),
			$this,
			array(
				"HIDE_ICONS" => "Y"
			)
		);?>
		<?$arMapHtml[$arMatches[0][$key]] = @ob_get_contents();
		ob_end_clean();
	endforeach;

	$arStubs = array_keys($arMapHtml);
	foreach ($arStubs as $k => $v)
		$arStubs[$k] = "/{$v}/";
	$html = preg_replace($arStubs, array_values($arMapHtml), $html);
}

if (preg_match('/<#FEEDBACK_FORM#>/', $html, $arMatches))
{
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$arTszh = $arResult["ITEMS"][$_POST["tszh_id"]];

		$to = $arParams["FEEDBACK_FORM_EMAIL_TO"];
		$this->getFeedbackFormMailHeaders($arTszh, $from, $sender, $to);

		$_SESSION[$this->__name] = array(
			"TSZH_ID" => $arTszh["ID"],
			"HEADERS" => array(
				"FROM" => $from,
				"SENDER" => $sender,
				"TO" => $to,
			),
		);
	}
	else
	{
		$arTszhs = array_values($arResult["ITEMS"]);
		$arTszh = $arTszhs[0];
	}
	$arFeedbackFormHtml = "";
	ob_start();?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.feedback",
		".default",
		Array(
			"USE_CAPTCHA" => $arParams["FEEDBACK_FORM_USE_CAPTCHA"] ? "Y" : "N",
			"OK_TEXT" => $arParams["FEEDBACK_FORM_OK_TEXT"],
			"EMAIL_TO" => "",
			"REQUIRED_FIELDS" => $arParams["FEEDBACK_FORM_REQUIRED_FIELDS"],
			"EVENT_NAME" => "TSZH_FEEDBACK_FORM",
			"EVENT_MESSAGE_ID" => $arParams["FEEDBACK_FORM_EVENT_MESSAGE_ID"],
			"TSZH_ID" => $arTszh["ID"],
		),
		$this,
		array(
			"HIDE_ICONS" => "Y"
		)
	);?>
	<?$arFeedbackFormHtml = @ob_get_contents();
	ob_end_clean();

	$html = preg_replace('/<#FEEDBACK_FORM#>/', $arFeedbackFormHtml, $html);
}

echo $html;

if (strlen($_REQUEST["success"]) > 0 && count($arResult["ITEMS"]) > 1):?>
	<script>
		BX.ready(function () {
			activateTszhContactsTab(BX('tszh-contacts-<?=$_SESSION[$this->__name]["TSZH_ID"]?>'));
		});
	</script>
<?endif;
