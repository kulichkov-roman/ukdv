<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
$this->__component->arResult["TEMPLATE_HTML"] = "";

if (empty($arResult["ITEMS"]))
	return;

ob_start();?>

<div id="contacts-page-container">
	<?$arIDs = array_keys($arResult["ITEMS"]);
	$activeID = array_shift($arIDs);
	if (count($arResult["ITEMS"]) > 1):?>
		<div id="tabs-container">
			<?foreach ($arResult["ITEMS"] as $itemID => $arItem):?>
				<div id="tszh-contacts-<?=$itemID?>" class="tab <?=$activeID == $itemID ? 'active' : ''?>" data-tszh_id="<?=$itemID?>" onclick="activateTszhContactsTab(this)">
					<?=$arItem["NAME"]?>
				</div>
			<?endforeach?>
		</div>
	<?endif?>

	<div id="orgs-contacts-container">
		<?foreach($arResult["ITEMS"] as $itemID => $arItem):
			$arGroups = array(
				array(
					"TITLE" => GetMessage("T_G_CONTACTS"),
					"FIELDS" => array("ADDRESS", "PHONE", "PHONE_DISP", "EMAIL", "OFFICE_HOURS"),
					"EXISTS" => $arParams["SHOW_FEEDBACK_FORM"],
				),
				array(
					"TITLE" => GetMessage("T_G_PROPS"),
					"FIELDS" => array("INN", "KPP", "RSCH", "KSCH", "LEGAL_ADDRESS", "HEAD_NAME"),
					"EXISTS" => false,
				),
			);
			foreach ($arItem as $field => $value)
			{
				if ($field == "OFFICE_HOURS" && is_array($value) && !empty($value) || $field != "OFFICE_HOURS" && strlen(trim($value)) > 0)
				{
					foreach ($arGroups as $key => $arGroup)
					{
						if (!$arGroup["EXISTS"] && in_array($field, $arGroup["FIELDS"]))
						{
							$arGroups[$key]["EXISTS"] = true;
							break;
						}
					}
				}
			}?>

			<div class="org-contacts <?=$activeID == $itemID ? 'active' : ''?>" id="tszh<?=$itemID?>">
				<h3 class="alt"><?=$arItem["NAME"]?></h3>
				<table class="org-contacts-table">
					<tr>
						<td class="org-requisites-td">
							<table class="group-table" <?//=$showMapFlag ? 'style="margin-right: ' . ($arParams["MAP_MAP_WIDTH"] + 15) . 'px;"' : ''?>>
								<?foreach ($arGroups as $groupKey => $arGroup):
									if (!$arGroup["EXISTS"])
										continue;?>
									<tr>
										<td colspan="2"><h3><?=$arGroup["TITLE"]?>:</h3></td>
									</tr>
									<?foreach ($arGroup["FIELDS"] as $field):
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
											if (strlen($value) > 0)
											{
												$value = preg_replace($pattern, $replacement, $value);
												$arValues[] = $value . " (" . GetMessage("T_DISPATCHER_ROOM") . ")";
											}
											$value = implode("<br />", $arValues);
										}
										elseif ($field == "RSCH")
										{
											$bank = trim($arItem["BANK"]);
											if (strlen($bank) > 0)
											{
												$value .= ", {$bank}";
												$bik = trim($arItem["BIK"]);
												if (strlen($bik) > 0)
												{
													$value .= " (" . GetMessage("T_BIK") . " {$bik})";
												}
											}
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
											<td><?=$value?></td>
										</tr>
									<?endforeach;
			            
									if ($groupKey == 0 && $arParams["SHOW_FEEDBACK_FORM"]):?>
										<tr>
											<td colspan="2" class="write-us"><a class="write-us" href="#feedbackForm"><?=GetMessage("T_WRITE_US")?></a></td>
										</tr>
									<?endif;
								endforeach?>
							</table>
						</td>
						<?$showMapFlag = $arParams["SHOW_MAP"] && strlen($arItem["ADDRESS"]) > 0;
						if ($showMapFlag):?>
							<td class="org-map-td">
								<div class="map-container">
									<#MAP_<?=$itemID?>#>
								</div>
							</td>
						<?endif?>
					</tr>
				</table>
			</div>
		<?endforeach?>
	</div>

	<?if ($arParams["SHOW_FEEDBACK_FORM"]):?>
		<#FEEDBACK_FORM#>
	<?endif?>
</div>
<?$this->__component->arResult["TEMPLATE_HTML"] = @ob_get_contents();
ob_end_clean();?>