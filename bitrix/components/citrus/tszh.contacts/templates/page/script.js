var arMaps = [];

function activateTszhContactsTab(tabEl)
{
	if (BX.hasClass(tabEl, 'active'))
		return;

	var tszhID = tabEl.getAttribute('data-tszh_id');
	var res = BX.findChild(tabEl.parentNode, {'class': 'active'});
	if (res)
		BX.removeClass(res, 'active');
	BX.addClass(tabEl, 'active');

	var res = BX.findChild(BX('orgs-contacts-container'), {'class': 'active'});
	if (res)
		BX.removeClass(res, 'active');
	BX.addClass(BX('tszh' + tszhID), 'active');

	BX('feedback-tszh_id').value = tszhID;

	var arMap = arMaps[tszhID];
	if (arMap && !arMap.zoomed && arMap.map && arMap.map.getZoom() <= 0)
	{
		var center = arMap.map.getCenter();
		arMap.map.setCenter([0, 0], 15);
		arMap.map.panTo(center);
		arMap.zoomed = true;
	}
}

