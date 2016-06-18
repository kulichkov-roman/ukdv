<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	</div>
	<div class="clearfix"></div>
</div>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "page", // page | sect - area to include
		"AREA_FILE_SUFFIX" => "inc", // suffix of file to seek
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => "page_inc.php",
		"EDIT_MODE" => "html",
	),
	false
);?>
<?
if ($APPLICATION->GetProperty('show_top_left', 'N') == 'Y' || strlen($leftColContent) > 0)
{
	?>
	<div class="fix bottom-blocks<?=($APPLICATION->GetCurPage(false) != SITE_DIR ? ' dotted' : '')?>"><table><tr>
		<td class="bottom-block left"><?$APPLICATION->IncludeFile(SITE_DIR . "include/contacts.php", Array(), Array("MODE"=>"html"));?></td>
		<td class="bottom-block middle"><?$APPLICATION->IncludeFile(SITE_DIR . "include/schedule.php", Array(), Array("MODE"=>"html"));?></td>
		<td class="bottom-block right"><?$APPLICATION->IncludeFile(SITE_DIR . "include/useful_info.php", Array(), Array("MODE"=>"html"));?></td>
	</tr></table></div>
	<?
}

?>
<div id="bottom-menu">
	<div class="fix b-m">
<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom-menu", array(
	"ROOT_MENU_TYPE" => "bottom",
	"MENU_CACHE_TYPE" => "A",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array(
	),
	"MAX_LEVEL" => "2",
	"CHILD_MENU_TYPE" => "section",
	"USE_EXT" => "Y",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
	</div>
</div>
<div id="footer"><div class="footer-inner">
	<div id="copyright"><?$APPLICATION->IncludeFile(SITE_DIR . "include/copyright.php", Array(), Array("MODE"=>"html"));?></div>
	<div id="bx-composite-banner"></div>
	<?
		if (CModule::IncludeModule("citrus.tszhpayment") && ($paymentPath = CTszhPaySystem::getPaymentPath()))
		{
			?>
			<div class="footer-payment"><?=CTszhPaySystem::getPaymentLogo();?></div>
			<?
		}
	?>
</div></div>
</body>
</html>