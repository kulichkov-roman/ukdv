<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>





<!--noindex-->
<div class="block-title">
	<a href="/questions-and-answers/">Оставьте онлайн-заявку</a>
</div>
<?$APPLICATION->IncludeComponent(
	"your:main.feedback", 
	".default", 
	array(
		"USE_CAPTCHA" => "Y",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "ukdiv@yandex.ru",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
		),
		"EVENT_MESSAGE_ID" => array(
		),
		"COMPONENT_TEMPLATE" => ".default",
		"EXT_FIELDS" => array(
			0 => "Адрес",
			1 => "Телефон",
		)
	),
	false
);?>
<!--/noindex-->
