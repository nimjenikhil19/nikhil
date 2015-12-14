<?php
# customer_chat_code.php
#
# Copyright (C) 2015  Joe Johnson, Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# Example for incorporating the customer side of the Vicidial chat into a web page.  
# Can be called as an include file, if desired.
#
# Builds:
# 151212-0829 - First Build for customer chat
#

if (isset($_GET["lead_id"]))	{$lead_id=$_GET["lead_id"];}
	elseif (isset($_POST["lead_id"]))	{$lead_id=$_POST["lead_id"];}
if (isset($_GET["chat_id"]))	{$chat_id=$_GET["chat_id"];}
	elseif (isset($_POST["chat_id"]))	{$chat_id=$_POST["chat_id"];}
if (isset($_GET["chat_group_id"]))	{$chat_group_id=$_GET["chat_group_id"];}
	elseif (isset($_POST["chat_group_id"]))	{$chat_group_id=$_POST["chat_group_id"];}
if (isset($_GET["email"]))	{$email=$_GET["email"];}
	elseif (isset($_POST["email"]))	{$email=$_POST["email"];}
if (isset($_GET["unique_userID"]))	{$unique_userID=$_GET["unique_userID"];}
	elseif (isset($_POST["unique_userID"]))	{$unique_userID=$_POST["unique_userID"];}
$URL_vars="?user=".urlencode($unique_userID)."&lead_id=".$lead_id."&group_id=".urlencode($chat_group_id)."&chat_id=".$chat_id."&email=".urlencode($email);
?>

<iframe src="/chat_customer/vicidial_chat_customer_side.php<?php echo $URL_vars; ?>" style="width:600;height:400;background-color:transparent;" scrolling="auto" frameborder="0" allowtransparency="true" id="ViCiDiAlChAtIfRaMe" name="ViCiDiAlChAtIfRaMe"/>
