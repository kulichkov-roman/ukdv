<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if ($arParams['BX_EDITOR_RENDER_MODE'] == 'Y')
{
	?><img src="<?=$this->GetFolder()?>/images/screenshot.png" border="0" /><?
}
else
{
	$arTransParams = array(
		'INIT_MAP_TYPE' => $arParams['INIT_MAP_TYPE'],
//		'INIT_MAP_LON' => $arResult['POSITION']['yandex_lon'],
//		'INIT_MAP_LAT' => $arResult['POSITION']['yandex_lat'],
//		'INIT_MAP_SCALE' => $arResult['POSITION']['yandex_scale'],
//		'INIT_MAP_SCALE' => 15,
		'MAP_WIDTH' => $arParams['MAP_WIDTH'],
		'MAP_HEIGHT' => $arParams['MAP_HEIGHT'],
		'CONTROLS' => $arParams['CONTROLS'],
		'OPTIONS' => $arParams['OPTIONS'],
		'MAP_ID' => $arParams['MAP_ID'],
		'LOCALE' => $arParams['LOCALE'],
		'ONMAPREADY' => 'citrusYandexSetAddress'.$arParams['MAP_ID'],
	);

	if ($arParams['DEV_MODE'] == 'Y')
	{
		$arTransParams['DEV_MODE'] = 'Y';
		if ($arParams['WAIT_FOR_EVENT'])
			$arTransParams['WAIT_FOR_EVENT'] = $arParams['WAIT_FOR_EVENT'];
	}

	?>
	<script type="text/javascript">
	function citrusYandexSetAddress<?=$arParams["MAP_ID"]?>(map)
	{
		var mapContainerDiv = BX('BX_YMAP_<?=$arParams["MAP_ID"]?>');
		if (mapContainerDiv)
		{
			var mapContainerTd = BX.findParent(mapContainerDiv, { 'tag': 'td', 'class': 'org-map-td' });
			if (mapContainerTd)
			{
				/*var height = parseInt(mapContainerTd.clientWidth);
   				if (height < 300)
	   				height = '300px';
				else
					height += 'px';
				mapContainerDiv.style.width = mapContainerTd.clientWidth;
				mapContainerDiv.style.height = height;*/
				mapContainerDiv.style.width = '';
				//mapContainerDiv.style.height = '';
				BXMapYandexAfterShow('<?=$arParams["MAP_ID"]?>');
			}
		}

		arMaps[<?=$arParams["TSZH_ID"]?>] = { 'zoomed': false, 'map': map };

		var points = <?=CUtil::PhpToJsObject(Array($arParams['ADDRESS']))?>;
		
		ymaps.geocode(points[0], { results: 1 }).then(function (res) {
			var point = res.geoObjects.get(0);
			if (point) {
				point.properties.set('balloonContentHeader', '<?=CUtil::JSEscape($arParams["NAME"])?>');
				//point.properties.set('balloonContentBody', '<p><?=CUtil::JSEscape($arParams["BODY"])?></p>');
				point.properties.set('balloonContentBody', '');
				point.properties.set('balloonContentFooter', '<?=CUtil::JSEscape($arParams["ADDRESS"])?>');
				
				var coords = point.geometry.getCoordinates();
				map.setCenter(coords);
				map.setZoom(15);
				
				map.geoObjects.add(point);
				point.balloon.open();

				// zoom
				var geoObjects = map.geoObjects;
				var bounds = geoObjects.getBounds();
				if (bounds)
				{
					map.setBounds(bounds);
					
					var zoom = map.getZoom();
					map.options.set('avoidFractionalZoom', true);
					zoom = zoom <= 17 ? zoom : 17;
					map.setZoom(zoom*0.95, {avoidFractionalZoom: true});
				}
			}
			else {
				$('#<?=$arParams["MAP_ID"]?>').hide();

			}
		}, function (err) {
			$('#<?=$arParams["MAP_ID"]?>').hide();
		})
	}
	</script>
	<div class="citrus-yandex-map-address" id="<?=$arParams['MAP_ID']?>">
		<?$APPLICATION->IncludeComponent('bitrix:map.yandex.system', '.default', $arTransParams, false, array('HIDE_ICONS' => 'Y'));?>
	</div>
	<?
}
?>