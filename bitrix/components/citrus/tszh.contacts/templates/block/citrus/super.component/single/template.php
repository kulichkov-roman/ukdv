<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if (empty($arParams["ITEMS"]))
	return;

if (!is_array($arParams["FIELDS"]))
	$arParams["FIELDS"] = array($arParams["FIELDS"]);
?>

<link type="text/css" rel="stylesheet" href="<?=$templateFolder?>/styles.css"></link>

<div id="contacts-block-container">
	<?$arItem = array_shift($arParams["ITEMS"]);?>
	<div class="org-contacts">

		<table class="contacts-table">
			<?foreach ($arParams["FIELDS"] as $fieldKey => $field):
				$value = trim($arItem[$field]);

				if ($field == "PHONE_DISP")
					continue;
				elseif ($field == "PHONE")
				{
					$arValues = array();
					$pattern = '#^(\+?\d+)\s*\((\d+)\)\s*(.+)$#';
					$replacement = '$1 ($2) <span class="phone-big">$3</span>';
					if (strlen($value) > 0)
					{
						$value = preg_replace($pattern, $replacement, $value);
						$arValues[] = $value;
					}
					$value = trim($arItem["PHONE_DISP"]);
					if (in_array("PHONE_DISP", $arParams["FIELDS"]) && strlen($value) > 0)
					{
						$value = preg_replace($pattern, $replacement, $value);
						$arValues[] = $value . " (" . GetMessage("T_DISPATCHER_ROOM") . ")";
					}
					$value = implode("<br />", $arValues);
				}
				elseif ($field == "OFFICE_HOURS")
				{
					$arSchedule = $arItem[$field];
					if (is_array($arSchedule) && !empty($arSchedule))
					{
						$value = '<table class="schedule-table">';
						foreach ($arSchedule as $deptScheduleKey => $arDeptSchedule)
						{
							foreach ($arDeptSchedule["SCHEDULE"] as $scheduleItemKey => $arScheduleItem)
							{
								$value .= "<tr>";
								$daysStr = trim($arScheduleItem["DAY"]);
								$daysStr = preg_replace('/(\s*)([^,]+)(,|$)/', '$1<span class="nowrap">$2$3</span>', $daysStr);
								$value .= "<td>{$daysStr}</td>";
								$class = "hours";
								if (count($arScheduleItem["HOURS"]) == 1 && preg_match('#' . GetMessage("T_HOLIDAY_PATTERN") . '#i' . (defined("BX_UTF") && BX_UTF ? 'u' : ''), $arScheduleItem["HOURS"][0]))
								{
									$class = "holiday";
									//$arScheduleItem["HOURS"][0] = "- " . $arScheduleItem["HOURS"][0];
								}
								$value .= "<td class=\"{$class}\">";
								$arHours = array();
								foreach ($arScheduleItem["HOURS"] as $hoursKey => $hours)
								{
									$arHours[] = "<span class=\"nowrap\">{$hours}</span>";
								}
								$value .= implode("<br />", $arHours);
								$deptName = "&nbsp;";
								if ($scheduleItemKey == 0 && strlen($arDeptSchedule["NAME"]) > 0)
									$deptName = "({$arDeptSchedule["NAME"]})";
								$value .= "</td><td class=\"deptname\" title=\"{$deptName}\">{$deptName}</td></tr>";
							}

							if ($deptScheduleKey < count($arSchedule)-1)
								$value .= '<tr><td colspan="3">&nbsp;</td></tr>';
						}
						$value .= "</table>";
					}
					else
						$value = "";
				}

				if (strlen($value) <= 0)
					continue;?>
				<tr>
					<td class="caption"><?=GetMessage("T_F_" . $field)?>:</td>
					<td <?=$fieldKey == count($arParams["FIELDS"])-1 ? 'class="office-hours-td"' : ''?>><?=$value?></td>
				</tr>
			<?endforeach?>
			<tr>
				<td style="padding: 0;"></td>
				<td class="detail-link"><a href="<?=preg_replace('/#CODE#/', $arItem["CODE"], $arParams["CONTACTS_URL"])?>"><?=GetMessage("T_DETAIL")?></a></td>
			</tr>
		</table>
	</div>
</div>