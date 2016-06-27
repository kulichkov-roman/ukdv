<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if (isset($_REQUEST['check'])) {

	$ID = IntVal($_REQUEST['check']);

	if ($ID > 0) {
		$rsElement = CIBlockElement::GetList(
			Array(),
			Array(
				"IBLOCK_ID" => $arParams['IBLOCK_ID'],
				'ID' => $ID
			),
			false,
			Array('nTopCount' => 1)
		);
		if ($obElement = $rsElement->GetNextElement()) {
			$arElement = $obElement->GetFields();
			$arElement['PROPERTIES'] = $obElement->GetProperties();
?>
<p>
	<strong><?=GetMessage("T_FAQ_QUESTION")?>:</strong>
	<br />
	<em><?=$arElement['PREVIEW_TEXT']?></em>
</p>
<?if (strlen($arElement['DETAIL_TEXT']) > 0):?>
	<div>
		<p style="margin-bottom: -1em;"><strong><?=GetMessage("T_FAQ_ANSWER")?>:</strong></p>
		<p><?=$arElement['DETAIL_TEXT']?></p>
	</div>
	<?if (strlen($arElement['PROPERTIES']['answer_author']['VALUE']) > 0):?>
		<p><?=GetMessage("T_FAQ_ANSWER_AUTHOR")?>: <strong><?=$arElement['PROPERTIES']['answer_author']['VALUE']?></strong></p>
	<?endif;?>
<?else:?>
<p><strong><?=GetMessage("T_FAQ_ANSWER")?>:</strong><br />
<em><?=GetMessage("T_FAQ_NO_ANSWER")?></em>.</p>
<?

if (strlen($arElement['PROPERTIES']['author_email']['VALUE']) && check_email($arElement['PROPERTIES']['author_email']['VALUE'])) {
	echo '<p>' . GetMessage("T_FAQ_ANSWER_ON_EMAIL") . '</p>';
}
?>
<?endif?>
<?
		} else {
			ShowMessage(str_replace('#ID#', $ID, GetMessage("T_FAQ_QUESTION_ID_NOT_FOUND")));
		}
	} else {
		ShowMessage(GetMessage("T_FAQ_QUESTION_NOT_FOUND"));
	}

	?><p><a href="<?=$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["faq"]?>"><?=GetMessage("T_FAQ_BACK_TO_SECTION")?></a></p><?

} else {

?>
<h3><?=GetMessage("T_FAQ_CHECK_QUESTION_STATUS")?></h3>
<form action="" method="get" style="margin: 5px 0;">
	<input type="text" name="check" class="search" placeholder="<?=GetMessage("T_FAQ_ENTER_QUESTION_NUMBER")?>"/>
	<button name="submit"><?=GetMessage("T_FAQ_CHECK")?></button>
</form>
<a class="ask-link" href="#ask"><strong><?=GetMessage("T_FAQ_ASK_QUESTION")?></strong></a>
<div class="dotted" class="anchor"></div>
<?$APPLICATION->IncludeComponent(
	"bitrix:support.faq.section.list",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"SECTION" => $arParams["SECTION"],
		"EXPAND_LIST" => $arParams["EXPAND_LIST"],
		"AJAX_MODE"	=> $arParams["AJAX_MODE"],
		"AJAX_OPTION_SHADOW"	=>	$arParams["AJAX_OPTION_SHADOW"],
		"AJAX_OPTION_JUMP"	=>	$arParams["AJAX_OPTION_JUMP"],
		"AJAX_OPTION_STYLE"	=>	$arParams["AJAX_OPTION_STYLE"],
		"AJAX_OPTION_HISTORY"	=>	$arParams["AJAX_OPTION_HISTORY"],

		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
	),
	$component
);?>
<?$APPLICATION->IncludeComponent(
	"citrus:support.faq.element.list",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"AJAX_MODE" => "N",
		"SECTION" => $arParams["SECTION"],
		"EXPAND_LIST" => $arParams["EXPAND_LIST"],
		"LINK_ELEMENTS" => "",
		"LINK_ELEMENTS_LINK" => "/support/faq/?ELEMENT_ID=#ELEMENT_ID#",
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",

		"SECTION_ID" => 0,
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"TOP_COUNT" => 5
	),
	$component
);?>
<?

}

