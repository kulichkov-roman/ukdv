<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if (!empty($arResult))
{

	$selectedParent = -1;
	$currentParent = -1;
	foreach ($arResult as $key => $arItem)
	{
		if ($arItem['DEPTH_LEVEL'] == 1)
			$currentParent = $key;
		elseif ($arItem['DEPTH_LEVEL'] > 1 && $arItem['SELECTED'] && $currentParent >= 0)
			$selectedParent = $currentParent;
	}

	echo "<ul id=\"top-multilevel-menu\">\n";

	$previousLevel = 0;
	$hasPayment = CModule::IncludeModule("citrus.tszhpayment") && ($paymentPath = CTszhPaySystem::getPaymentPath());
	foreach ($arResult as $key=>$arItem)
	{
		if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel)
			echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));

		if ($hasPayment && !$USER->IsAuthorized() && $arItem["LINK"] == SITE_DIR . 'personal/')
			$arItem["LINK"] == $paymentPath;

		$itemClasses = Array();
		if (strlen($arItem['PARAMS']['class']) > 0)
			$itemClasses[] = $arItem['PARAMS']['class'];
		if ($key == count($arResult)-1)
			$itemClasses[] = 'last';
		if ($arItem['SELECTED'] || $key == $selectedParent)
			$itemClasses[] = 'selected';
		$class = count($itemClasses) > 0 ? ' class="' . implode(' ', $itemClasses) . '"' : '';
		echo "\t<li$class><a href=\"{$arItem["LINK"]}\">{$arItem["TEXT"]}</a>";

		if ($arItem['IS_PARENT'])
			echo "<ul>\n";
		else
			echo "</li>\n";

		$previousLevel = $arItem["DEPTH_LEVEL"];
	}

	if ($previousLevel > 1)
		echo str_repeat("</ul></li>", ($previousLevel-1) );

	echo "</ul>\n";
}

?>
