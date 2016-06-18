<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

IncludeTemplateLangFile(__FILE__);

global $USER;

function TemplateShowButton($arParams = Array())
{
	if (!is_array($arParams))
		$arParams = Array();
	if (!array_key_exists('type', $arParams))
		$arParams['type'] = 'submit';
	if (!array_key_exists('title', $arParams))
		$arParams['title'] = GetMessage("TSZH_TEMPLATE_SEND");

	$strArgs = " type=\"{$arParams['type']}\"";
	foreach ($arParams['attr'] as $key=>$val)
	{
		$key = htmlspecialcharsbx($key);

		if (is_array($val)) {
			if ($key == 'style') {
				$val = implode('; ', $val);
			} else {
				$val = implode(' ', $val);
			}
		}
		$val = htmlspecialcharsbx($val);
		$strArgs .= " $key=\"$val\"";
	}
	?><button<?=$strArgs?>><?=$arParams['title']?></button><?
}

function TemplateShowTitle()
{
	global $APPLICATION;
	$arSite = $APPLICATION->GetSiteByDir();
	$siteName = strlen($arSite['SITE_NAME']) > 0 ? $arSite['SITE_NAME'] : $arSite['NAME'];
	$hasTitle = $APPLICATION->GetProperty('title') != $APPLICATION->GetTitle(false);
	$title = $APPLICATION->GetTitle('title');

	if (stripos($title, $siteName) === false && !$hasTitle)
		return strlen($title) > 0 ? "$title &ndash; $siteName" : $siteName;
	else
		return $title;
}

function TemplateShowPageTitle()
{
	global $APPLICATION;
	if ($APPLICATION->GetProperty('show_title', 'Y') == 'Y') {
		return '<h1 id="pagetitle">' . $APPLICATION->GetTitle(false) . '</h1>';
	}
	return '';
}

if (!function_exists("htmlspecialcharsbx"))
{
	function htmlspecialcharsbx($string, $flags = ENT_COMPAT)
	{
		//shitty function for php 5.4 where default encoding is UTF-8
		return htmlspecialcharsbx($string, $flags, (defined("BX_UTF") ? "UTF-8" : "ISO-8859-1"));
	}
}


?><!DOCTYPE html>
<html>
<head>
<?

CJsCore::Init(Array('jquery'));
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.placeholder.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.fancybox-1.3.4.pack.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/script.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/developers.js');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/colors.css');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/jquery.fancybox-1.3.4.css');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/developers.css');

$APPLICATION->ShowHead(false);

//$APPLICATION->ShowTitle(); — проходим автоматический тест монитора качества, вместо $APPLICATION->ShowTitle() используется собственная отложенная ф-ия TemplateShowTitle()
?>
<title><?$APPLICATION->AddBufferContent('TemplateShowTitle');?></title>
<!--[if lt IE 9]>
	<script src="<?=SITE_TEMPLATE_PATH?>/js/html5.js"></script>
	<script src="<?=SITE_TEMPLATE_PATH?>/js/IE9.js"></script>
<![endif]-->
<!--[if lt IE 10]>
	<script src="<?=SITE_TEMPLATE_PATH?>/pie/PIE.js"></script>
<![endif]-->
</head>
<body>
<?$APPLICATION->ShowPanel();?>

<div id="header">
	<div class="header-top"><div class="header-top-inner fix">
		<!--noindex--><?$APPLICATION->IncludeComponent(
			"bitrix:system.auth.form",
			"header-auth",
			Array(
				"REGISTER_URL" => SITE_DIR . "auth/?register=yes",
				"FORGOT_PASSWORD_URL" => SITE_DIR . "auth/?forgot_password=yes",
				"PROFILE_URL" => "/personal/profile/",
				"SHOW_ERRORS" => "Y"
			),
		false
		);?><!--/noindex-->
	</div></div>
	<div class="fix tit">
		<div class="header-title">
            <?$APPLICATION->IncludeFile(
				SITE_DIR . "include/title.php",
				Array(),
				Array("MODE" => "html")
            );?>
		</div>
		<div class="header-phone">
			<?$APPLICATION->IncludeFile(
				SITE_DIR . "include/telephone.php",
				Array(),
				Array("MODE"=>"html")
			);?>
		</div>
	</div>
</div>
<div id="top-links">
    <div class="menu">
		<?$APPLICATION->IncludeComponent("bitrix:menu", "top_multilevel", array(
			"ROOT_MENU_TYPE" => "top",
			"MENU_CACHE_TYPE" => "A",
			"MENU_CACHE_TIME" => "3600",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => Array(),
			"MAX_LEVEL" => "2",
			"CHILD_MENU_TYPE" => "show_add",
			"USE_EXT" => "Y",
			"ALLOW_MULTI_SELECT" => "N"
		),
		false
	);?></div>
	<!--noindex--><form id="search-form" action="<?=SITE_DIR?>search/" method="get">
		<input type="text" name="q"  placeholder="<?=GetMessage("TSZH_TEMPLATE_SITE_SEARCH")?>"/>
		<button type="submit"></button>
	</form><!--/noindex-->
</div>

<div id="content">
	<div class="fix">
	<?if ($APPLICATION->GetCurPage(false) != SITE_DIR):?>
		<?if ($APPLICATION->GetProperty('show_top_left', 'N') == 'Y'):?>
			<div class="left-menu">
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "left-menu", array(
				"AREA_FILE_SHOW" => "sect",
				"AREA_FILE_SUFFIX" => "left-menu-inc",
				"AREA_FILE_RECURSIVE" => "Y",
				"EDIT_TEMPLATE" => ""
				),
				false
				);?>
			</div>
		<?else: ?>
			<div id="left-area">
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "news-index", array(
					"AREA_FILE_SHOW" => "sect",
					"AREA_FILE_SUFFIX" => "right",
					"AREA_FILE_RECURSIVE" => "Y",
					"EDIT_TEMPLATE" => "top_side"
				),
				false
				);?>
			</div>
		<?endif?>
	<?endif?>
		
<?
if ($APPLICATION->GetCurPage(false) != SITE_DIR)
{
?>
	<div id="work">
		<?$APPLICATION->AddBufferContent('TemplateShowPageTitle');?>
	<?
}
?>