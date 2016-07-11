<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arParams["DISPLAY_TOP_PAGER"])
	echo "<div>{$arResult['NAV_STRING']}</div>\n";
?>
<script type="text/javascript">
	function expandMonth(month) {
		var monthElem = document.getElementById('circulating-sheet-' + month);
		if (monthElem && typeof(monthElem) != 'undefined') {
			monthElem.style.display = monthElem.style.display == 'none' ? '' : 'none';
		}
	}
</script>
<div class="sheet-type-select">
	<div class="sheet-type left-bordered <?=($arResult["SHEET_TYPE"] == Citrus\Tszh\Types\ReceiptType::MAIN) ? "main-bg" : "" ?> main-border"><a href="<?= $arResult["MAIN_URL"] ?>"><?= GetMessage("TSZH_SHOW_TAB1_RECEIPT") ?></a></div>
	<div class="sheet-type right-bordered <?=($arResult["SHEET_TYPE"] == Citrus\Tszh\Types\ReceiptType::OVERHAUL) ? "main-bg" : "" ?> main-border"><a href="<?= $arResult["OVERHAUL_URL"] ?>"><?= GetMessage("TSZH_SHOW_TAB2_RECEIPT") ?></a></div>
</div>
<table class="data-table">
	<thead>
	<tr>
		<th style="line-height: 29px;"><?= GetMessage("TSZH_SHEET_PERIOD") ?></th>
		<th><?= GetMessage("TSZH_SHEET_DEBT") ?><br/><?= GetMessage("TSZH_SHEET_BEG") ?></th>
		<th><?= GetMessage("TSZH_SHEET_SUMM") ?></th>
		<th class="rwd-optional"><?= GetMessage("TSZH_SHEET_CORRECTIONS") ?></th>
		<th><?= GetMessage("TSZH_SHEET_SUMMPAYED") ?></th>
		<th><?= GetMessage("TSZH_SHEET_DEBT") ?><br/><?= GetMessage("TSZH_SHEET_END") ?></th>
	</tr>
	</thead>
	<tbody><?

	if (count($arResult['PERIODS']) > 0):

		foreach ($arResult['PERIODS'] as $arPeriod):
			if (!is_array($arPeriod["ACCOUNT_PERIOD"]))
				continue;

			?>
			<tr>
				<td>
					<?
					if ($arPeriod["ONLY_DEBT"] != "Y"):
						?>
						<strong><a href="<?= $arPeriod['DETAIL_PAGE_URL'] ?>"
						           title="<?= GetMessage("TSZH_SHEET_CLICK_TO_SHOW") ?>"
						           onclick="expandMonth('<?= $arPeriod['ACCOUNT_PERIOD']['ID'] ?>'); return false;"><?= ToUpperFirstChar($arPeriod['DISPLAY_NAME']) ?></a></strong>:
						<br/>
						<small>(<a
								href="<?= CComponentEngine::MakePathFromTemplate($arParams['RECEIPT_URL'], Array("ID" => $arPeriod["ID"])) ?>"
								style="color: #666;"><?= GetMessage("TSZH_SHOW_RECEIPT") ?></a>)
						</small>
					<?
					else:
						?>
						<?= ToUpperFirstChar($arPeriod['DISPLAY_NAME']) ?>:
					<?
					endif;
					?>
				</td>
				<td class="cost"><?= CTszhPublicHelper::FormatCurrency($arPeriod['TOTAL_DEBT_BEG']) ?></td>
				<td class="cost"><?= CTszhPublicHelper::FormatCurrency($arPeriod['TOTAL_CHARGES']) ?></td>
				<td class="cost rwd-optional"><?= CTszhPublicHelper::FormatCurrency($arPeriod['CORRECTION']) ?></td>
				<td class="cost"><?= CTszhPublicHelper::FormatCurrency($arPeriod['TOTAL_PAYED']) ?></td>
				<td class="cost"><?= CTszhPublicHelper::FormatCurrency($arPeriod['TOTAL_DEBT_END']) ?></td>
			</tr>
			<?
			if ($arPeriod["ONLY_DEBT"] != "Y"):
				?>
				<tr style="display: none;" id="circulating-sheet-<?= $arPeriod['ACCOUNT_PERIOD']['ID'] ?>">
					<td colspan="5" style="padding-left: 125px;">
						<table class="data-table">
							<thead>
							<tr>
								<th style="line-height: 29px;"><?= GetMessage("TSZH_SHEET_SERVICE") ?></th>
								<th><?= GetMessage("TSZH_SHEET_SUMM") ?></th>
								<?
								if ($arParams["SHOW_SERVICE_CORRECTIONS"])
								{
									?>
									<th><?= GetMessage("TSZH_SHEET_CORRECTIONS") ?></th><?
								}
								?>
								<th><?= GetMessage("TSZH_SHEET_TO_PAY") ?></th>
							</tr>
							</thead>
							<tbody>
							<? if (count($arPeriod['CHARGES']) > 0): ?>
								<?foreach ($arPeriod['CHARGES'] as $arItem):

									if ($arItem["DEBT_ONLY"] == "Y" && $arItem["DEBT_END"] == 0)
										continue;

									?>
									<tr>
										<td><?= $arItem['SERVICE_NAME'] ?>:</td>
										<?
										if ($arItem["DEBT_ONLY"] == "Y")
										{
											?>
											<td style="text-align: right">&mdash;</td><?
										}
										else
										{
											?>
											<td class="cost"><?= CTszhPublicHelper::FormatCurrency($arItem['SUMM']) ?></td><?
										}

										if ($arParams["SHOW_SERVICE_CORRECTIONS"])
										{
											?>
											<td class="cost"><?= CTszhPublicHelper::FormatCurrency($arItem['CORRECTION']) ?></td><?
										}
										?>

										<td class="cost"><?= CTszhPublicHelper::FormatCurrency($arItem['DEBT_END']) ?></td>
									</tr>
								<? endforeach; ?>
								<tr>
									<td colspan="3"><a target="_blank"
									                   href="<?= CComponentEngine::MakePathFromTemplate($arParams["RECEIPT_URL"], Array("ID" => $arPeriod["ID"])) ?>"><?= GetMessage("TSZH_SHOW_RECEIPT_LONG") ?></a>
									</td>
								</tr>
							<? else: ?>
								<tr>
									<td colspan="3"><em><?= GetMessage("TSZH_SHEET_NO_CHARGES") ?></em></td>
								</tr>
							<?endif; ?>
							</tbody>
						</table>
					</td>
				</tr>
			<?
			endif;

		endforeach;

	else:

		?>
		<tr>
			<td colspan="5"><em><?= GetMessage("TSZH_SHEET_NO_DATA") ?></em></td>
		</tr>
	<?

	endif;

	?>
	</tbody>
</table>
<?

if ($arParams["DISPLAY_BOTTOM_PAGER"])
	echo "<div>{$arResult['NAV_STRING']}</div>\n";

?>

<?$debtEnd = 0;
foreach ($arResult['PERIODS'] as $arPeriod)
{
	if (!is_array($arPeriod["ACCOUNT_PERIOD"]) || $arPeriod["ONLY_DEBT"] == "Y")
		continue;
	$debtEnd = $arPeriod["ACCOUNT_PERIOD"]["DEBT_END"];
	break;
}

$summ2pay = $debtEnd;
if (COption::GetOptionString("citrus.tszh", "pay_to_executors_only", "N") == "Y")
{
	$summ2pay = 0;
	foreach ($arResult["PERIODS"] as $period)
	{
		if ($period["ACCOUNT_PERIOD"])
		{
			$summ2pay = CTszhAccountContractor::GetList(array(), array(
					"ACCOUNT_PERIOD_ID" => $period["ACCOUNT_PERIOD"]["ID"],
					"!CONTRACTOR_EXECUTOR" => "N"
				), array("SUMM"))->Fetch();
			$summ2pay = is_array($summ2pay) ? $summ2pay['SUMM'] - $period["ACCOUNT_PERIOD"]["PREPAYMENT"] : 0;
			break;
		}
	}
}
if ($summ2pay > 0 && CModule::IncludeModule("citrus.tszhpayment") && ($paymentPath = CTszhPaySystem::getPaymentPath($arResult["ACCOUNT"]["TSZH_SITE"])))
	echo '<div>' . GetMessage("CITRUS_TSZHPAYMENT_LINK", Array("#LINK#" => $paymentPath . '?summ=' . round($summ2pay))) . '</div>';?>
