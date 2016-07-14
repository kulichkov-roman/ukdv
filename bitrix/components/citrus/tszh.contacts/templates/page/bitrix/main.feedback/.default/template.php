<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>

<link type="text/css" rel="stylesheet" href="<?=$templateFolder?>/styles.css"></link>
<div id="contacts-page-feedback">
	<h3><a name="feedbackForm"></a><?=GetMessage("T_HEADER")?>:</h3>
	<?//echo '<pre>';print_r($arParams);echo '</pre>';
	//echo '<pre>';print_r($arResult);echo '</pre>';
	if (!empty($arResult["ERROR_MESSAGE"]))
	{
		ShowError('<br>&mdash; ', $arResult["ERROR_MESSAGE"]);
	}

	if (strlen($arResult["OK_MESSAGE"]) > 0 || strlen($_REQUEST["success"]) > 0):
		if (strlen($arResult["OK_MESSAGE"]) <= 0)
			$arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];?>
		<div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div>
	<?endif?>

	<?
	$frame = $this->createFrame()->begin('');
	?>
	<form action="<?=$APPLICATION->GetCurPage()?>#feedbackForm" method="POST">
		<div class="left-fields-container">
			<?=bitrix_sessid_post()?>
			<input type="hidden" name="tszh_id" id="feedback-tszh_id" value="<?=$arParams["TSZH_ID"]?>">
			<input type="text" name="user_name" class="name styled" placeholder="<?=GetMessage("MFT_NAME")?>"  value="<?=$arResult["AUTHOR_NAME"]?>">
			<input type="text" name="user_email" class="mail styled" placeholder="<?=GetMessage("MFT_EMAIL")?>" value="<?=$arResult["AUTHOR_EMAIL"]?>">

			<?if ($arParams["USE_CAPTCHA"] == "Y"):?>
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td width="190px">
						<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA"></td>
						<td align="left"><input type="text" name="captcha_word" class="captcha styled" placeholder="<?=GetMessage("MFT_INPUT_CAPTCHA")?>" size="30" maxlength="50" value=""></td>
					</tr>
				</table>
			<?endif?>
		</div>

		<div class="right-fields-container">
			<textarea name="MESSAGE"  class="text-mail styled" placeholder="<?=GetMessage("MFT_MESSAGE")?>"><?=$arResult["MESSAGE"]?></textarea>
		    <?/*<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">*/?>
			<button type="submit" name="submit" value="Y"><?=GetMessage("MFT_SUBMIT")?></button>
		</div>
	</form>
	<?
	$frame->end();
	?>
</div>