<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Официальный сайт управляющей компании");
$APPLICATION->SetTitle("ООО &quot;УК Дивногорский&quot;");
?><?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"slider",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DELAY" => "5000",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("PREVIEW_PICTURE"),
		"FILTER_NAME" => "",
		"HEIGHT" => "396",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"HOVER_PAUSE" => "Y",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "services",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"NEWS_COUNT" => "6",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Слайды",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(),
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_NEXT_PREV" => "N",
		"SHOW_PAGINATION" => "Y",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"SPEED" => "350",
		"WIDTH" => "605"
	)
);?>
<div class="our">
	<h1>О нашем УК</h1>
	<p>
		 Мы&nbsp;рады приветствовать Вас на&nbsp;страницах сайта нашей управляющей компании!
	</p>
	<p>
		 ООО "УК Дивногорский" оказывает услуги по&nbsp;управлению и&nbsp;обслуживанию жилых домов и&nbsp;коммерческой недвижимости с&nbsp;2014 года. На&nbsp;данный момент в&nbsp;управлении организации находится 14 жилых домов,&nbsp;это более 1584 квартиры.
	</p>
	<p>
		 Главной целью нашей компании является профессиональное предоставление качественных коммунальных услуг жителям.
	</p>
	<p>
		 Более 15 высококвалифицированных специалистов ООО "УК Дивногорский" ежедневно стараются обеспечить максимально комфортное проживание для граждан.
	</p>
	<p>
		 В&nbsp;целях снижения количества претензий, жалоб со&nbsp;стороны населения и&nbsp;повышения качества оказываемых услуг, была создана специальная служба по&nbsp;контролю качества услуг.
	</p>
	<p>
		 Основными мероприятиями, проводимыми нашей компанией, являются: осуществление общестроительных, инженерных, электромонтажных, специализированных строительных, изоляционных, штукатурных, малярных, <nobr>санитарно-технических</nobr> работ.
	</p>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>