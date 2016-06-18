<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="block-title"><a href="/contacts/">Контакты</a></div>
<?$APPLICATION->IncludeComponent(
	"citrus:tszh.contacts",
	"block",
	Array(
		"CONTACTS_URL" => "/contacts/",
	),
	false
);?>
