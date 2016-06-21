<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Вопросы владельцев квартир");
$APPLICATION->SetTitle("Вопрос-ответ");

if ($_REQUEST['success'] != 1):

?>


	<table cellpadding="0" cellspacing="0" style="width: 100%;">
		<tbody>
		<tr>
			<td>
				<img width="320" alt="Дубров Сергей Геннадьевич" src="/upload/medialibrary/b54/IMG_6552.jpg" height="323" title="IMG_6552.jpg">
			</td>
			<td>
				<img width="320" alt="Дубров Сергей Геннадьевич" src="/upload/medialibrary/b54/IMG_6552.jpg" height="323" title="IMG_6552.jpg">
			</td>
		</tr>
		<tr>
			<td>
				<strong>Дубров Сергей Геннадьевич</strong><br>
				Должность: руководитель
			</td>
			<td>
				<strong>Дубров Сергей Геннадьевич</strong><br>
				Должность: главный инженер
			</td>
		</tr>
		</tbody>
	</table>

	<?$APPLICATION->IncludeComponent(
	"bitrix:support.faq",
	"qa",
	Array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "4",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"AJAX_MODE" => "N",
		"SEF_MODE" => "Y",
		"SECTION" => "-",
		"EXPAND_LIST" => "Y",
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"SEF_FOLDER" => "/questions-and-answers/",
		"SEF_URL_TEMPLATES" => Array(
			"section" => "#SECTION_ID#/",
			"detail" => "#SECTION_ID#/#ELEMENT_ID#/"
		),
		"VARIABLE_ALIASES" => Array(
			"section" => Array(),
			"detail" => Array(),
		)
	)
);?><?

endif;

?>
<a name="ask"></a>
<h2>Задать <em>вопрос</em></h2>
<?$APPLICATION->IncludeComponent("citrus:iblock.element.add.form", ".default", array(
	"IBLOCK_TYPE" => "services",
	"IBLOCK_ID" => "4",
	"STATUS_NEW" => "ANY",
	"LIST_URL" => "",
	"USE_CAPTCHA" => "Y",
	"USER_MESSAGE_EDIT" => "Спасибо, Ваш вопрос принят.<br />Номер вопроса: #ID#, Вы можете проверить его статус по этой <a href=\"/questions-and-answers/?check=#ID#\">ссылке</a>",
	"USER_MESSAGE_ADD" => "Спасибо, Ваш вопрос принят.<br />Номер вопроса: #ID#, Вы можете проверить его статус по этой <a href=\"/questions-and-answers/?check=#ID#\">ссылке</a>",
	"DEFAULT_INPUT_SIZE" => "40",
	"RESIZE_IMAGES" => "N",
	"PROPERTY_CODES" => array(
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => '12',
		3 => '13',
		4 => '14',
	),
	"PROPERTY_CODES_REQUIRED" => array(
		0 => "NAME",
	),
	"PROPERTY_CODES_EMAIL" => array(
		0 => "14",
	),
	"CHECK_EMAIL" => "Y",
	"GROUPS" => array(
		0 => "2",
	),
	"STATUS" => "INACTIVE",
	"ELEMENT_ASSOC" => "CREATED_BY",
	"MAX_USER_ENTRIES" => "100000",
	"MAX_LEVELS" => "100000",
	"LEVEL_LAST" => "N",
	"MAX_FILE_SIZE" => "0",
	"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
	"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
	"SEF_MODE" => "N",
	"SEF_FOLDER" => "/questions-and-answers/148/",
	"CUSTOM_TITLE_NAME" => "Представьтесь, пожалуйста",
	"CUSTOM_TITLE_TAGS" => "",
	"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
	"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
	"CUSTOM_TITLE_IBLOCK_SECTION" => "",
	"CUSTOM_TITLE_PREVIEW_TEXT" => "Ваш вопрос",
	"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
	"CUSTOM_TITLE_DETAIL_TEXT" => "",
	"CUSTOM_TITLE_DETAIL_PICTURE" => ""
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>