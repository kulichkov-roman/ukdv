<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	ShowError('<br>&mdash; ', $arResult["ERROR_MESSAGE"]);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
}
?>

<form action="<?=$APPLICATION->GetCurPage()?>#feedbackForm" method="POST" id="feedbackForm">
	<input type="text" name="user_name" class="name styled"  placeholder="<?=GetMessage("MFT_NAME")?>"  value="<?=$arResult["AUTHOR_NAME"]?>">
	<input type="text" name="custom[0]" class="address styled" placeholder="<?=GetMessage("MFT_ADDRESS")?>" value="<?=$arResult["custom_0"]?>">
	<input type="text" name="custom[1]" class="phone styled" placeholder="<?=GetMessage("MFT_PHONE")?>" value="<?=$arResult["custom_1"]?>">
	<textarea name="MESSAGE"  class="text-mail styled"  placeholder="<?=GetMessage("MFT_MESSAGE")?>"><?=$arResult["MESSAGE"]?></textarea>

	<?
	echo bitrix_sessid_post();
	?>
	<?if($arParams["USE_CAPTCHA"] == "Y"){?>
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="190px">
					<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA"></td>
				<td align="left"><input type="text" name="captcha_word"  class="captcha" size="30" maxlength="50" value=""></td>
			</tr>
		</table>
	<?}?>

	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<button type="submit" name="submit" class="t" value="Y"><?=GetMessage("MFT_SUBMIT")?></button>
</form>

<?/*?>
<div class="mfeedback">
	<form action="" method="POST">
	<?=bitrix_sessid_post()?>
		<div class="mf-name">
			<div class="mf-text">
				<?=GetMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
		</div>
		<div class="mf-email">
			<div class="mf-text">
				<?=GetMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
		</div>

		<div class="mf-message">
			<div class="mf-text">
				<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<textarea name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
		</div>
		<?foreach($arParams["NEW_EXT_FIELDS"] as $i => $ext_field):?>
			<div class="mf-name">
				<div class="mf-text">
					<?=$ext_field?>
				</div>
				<input type="text" name="custom[<?$i?>]" value="<?=$arResult["custom_$i"]?>">
			</div>
		<?endforeach;?>
		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
		<div class="mf-captcha">
			<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
			<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
			<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
			<input type="text" name="captcha_word" size="30" maxlength="50" value="">
		</div>
		<?endif;?>
		<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
	</form>
</div>
<?*/?>
