<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["ERROR_MESSAGE"]))
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
	<input type="text" name="user_email" class="mail styled" placeholder="<?=GetMessage("MFT_EMAIL")?>" value="<?=$arResult["AUTHOR_EMAIL"]?>">
	<textarea name="MESSAGE"  class="text-mail styled"  placeholder="<?=GetMessage("MFT_MESSAGE")?>"><?=$arResult["MESSAGE"]?></textarea>

<?
	// начало динамической части
	$frame = $this->createFrame()->begin('');
	echo bitrix_sessid_post();
?>
	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="190px">
			<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA"></td>
			<td align="left"><input type="text" name="captcha_word"  class="captcha" size="30" maxlength="50" value=""></td>
		</tr>
	</table>
	<?endif;?>
<?
	$frame->end();
?>
    <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<button type="submit" name="submit" class="t" value="Y"><?=GetMessage("MFT_SUBMIT")?></button>
</form>
