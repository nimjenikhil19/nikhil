<?php
# leadloader_template_display.php - version 2.10
# 
# Copyright (C) 2015  Matt Florell,Joe Johnson <vicidial@gmail.com>    LICENSE: AGPLv2
#
# CHANGES
# 120402-2238 - First Build
# 120525-1039 - Added uploaded filename filtering
# 120529-1345 - Filename filter fix
# 130610-1101 - Finalized changing of all ereg instances to preg
# 130619-0902 - Added filtering of input to prevent SQL injection attacks and new user auth
# 130719-1914 - Added SQL to show template statuses to dedupe against, fixed issue where list IDs should be disabled until lead file for template is uploaded
# 130802-0623 - Added select list query for status deduping
# 130824-2320 - Changed to mysqli PHP functions
# 141007-2203 - Finalized adding QXZ translation to all admin files
# 141229-2021 - Added code for on-the-fly language translations display
# 150210-0619 - Fixed small display issue
#

require("dbconnect_mysqli.php");
require("functions.php");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
if (isset($_GET["list_id"]))				{$list_id=$_GET["list_id"];}
	elseif (isset($_POST["list_id"]))		{$list_id=$_POST["list_id"];}
if (isset($_GET["custom_fields_enabled"]))				{$custom_fields_enabled=$_GET["custom_fields_enabled"];}
	elseif (isset($_POST["custom_fields_enabled"]))		{$custom_fields_enabled=$_POST["custom_fields_enabled"];}

$sample_template_file=$_FILES["sample_template_file"];
$LF_orig = $_FILES['sample_template_file']['name'];
$LF_path = $_FILES['sample_template_file']['tmp_name'];

if (isset($_GET["sample_template_file_name"]))			{$sample_template_file_name=$_GET["sample_template_file_name"];}
	elseif (isset($_POST["sample_template_file_name"]))	{$sample_template_file_name=$_POST["sample_template_file_name"];}
if (isset($_FILES["sample_template_file"]))				{$sample_template_file_name=$_FILES["sample_template_file"]['name'];}
if (isset($_GET["form_action"]))				{$form_action=$_GET["form_action"];}
	elseif (isset($_POST["form_action"]))		{$form_action=$_POST["form_action"];}
if (isset($_GET["delimiter"]))				{$delimiter=$_GET["delimiter"];}
	elseif (isset($_POST["delimiter"]))		{$delimiter=$_POST["delimiter"];}
if (isset($_GET["template_id"]))				{$template_id=$_GET["template_id"];}
	elseif (isset($_POST["template_id"]))		{$template_id=$_POST["template_id"];}
if (isset($_GET["buffer"]))				{$buffer=$_GET["buffer"];}
	elseif (isset($_POST["buffer"]))	{$buffer=$_POST["buffer"];}
if (isset($_GET["DB"]))				{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))	{$DB=$_POST["DB"];}

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,admin_web_directory,custom_fields_enabled,webroot_writable,enable_languages,language_method FROM system_settings;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysqli_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$non_latin =				$row[0];
	$admin_web_directory =		$row[1];
	$custom_fields_enabled =	$row[2];
	$webroot_writable =			$row[3];
	$SSenable_languages =		$row[4];
	$SSlanguage_method =		$row[5];
	}
##### END SETTINGS LOOKUP #####
###########################################

if ($non_latin < 1)
	{
	$PHP_AUTH_USER = preg_replace('/[^-_0-9a-zA-Z]/', '', $PHP_AUTH_USER);
	$PHP_AUTH_PW = preg_replace('/[^-_0-9a-zA-Z]/', '', $PHP_AUTH_PW);
	}
else
	{
	$PHP_AUTH_PW = preg_replace("/'|\"|\\\\|;/","",$PHP_AUTH_PW);
	$PHP_AUTH_USER = preg_replace("/'|\"|\\\\|;/","",$PHP_AUTH_USER);
	}
$list_id = preg_replace('/in_file/', '0', $list_id);
$list_id = preg_replace('/[^0-9]/', '', $list_id);

$stmt="SELECT selected_language from vicidial_users where user='$PHP_AUTH_USER';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$sl_ct = mysqli_num_rows($rslt);
if ($sl_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$VUselected_language =		$row[0];
	}

$auth=0;
$auth_message = user_authorization($PHP_AUTH_USER,$PHP_AUTH_PW,'',1);
if ($auth_message == 'GOOD')
	{$auth=1;}

if ($auth < 1)
	{
	$VDdisplayMESSAGE = _QXZ("Login incorrect, please try again");
	if ($auth_message == 'LOCK')
		{
		$VDdisplayMESSAGE = _QXZ("Too many login attempts, try again in 15 minutes");
		Header ("Content-type: text/html; charset=utf-8");
		echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$auth_message|\n";
		exit;
		}
	Header("WWW-Authenticate: Basic realm=\"CONTACT-CENTER-ADMIN\"");
	Header("HTTP/1.0 401 Unauthorized");
	echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$PHP_AUTH_PW|$auth_message|\n";
	exit;
	}

$stmt="SELECT load_leads from vicidial_users where user='$PHP_AUTH_USER';";
$rslt=mysql_to_mysqli($stmt, $link);
$row=mysqli_fetch_row($rslt);
$LOGload_leads = $row[0];

if ($LOGload_leads < 1)
	{
	Header ("Content-type: text/html; charset=utf-8");
	echo _QXZ("You do not have permissions to load leads")."\n";
	exit;
	}

### REGEX to prevent weird characters from ending up in the fields
$field_regx = "['\"`\\;]";
# echo "-$LF_orig- --$sample_template_file_name--<BR>";
$sample_template_file_name=preg_replace("/^C:\\\\fakepath\\\\/i", '', $sample_template_file_name); # IE and Chrome patch

if ( (preg_match("/;|:|\/|\^|\[|\]|\"|\'|\*/",$LF_orig)) or (preg_match("/;|:|\/|\^|\[|\]|\"|\'|\*/",$sample_template_file_name)) )
	{
	echo _QXZ("ERROR: Invalid File Name").": $LF_orig $sample_template_file_name\n";
	exit;
	}

if ($template_id) {
	$stmt="select * from vicidial_custom_leadloader_templates where template_id='$template_id'";
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_array($rslt);
	echo _QXZ("TEMPLATE ID").": $template_id\n";
	echo _QXZ("TEMPLATE INFO").": $row[template_name]";
	if (strlen($row["template_description"])>0) {echo " - $row[template_description]";}
	echo "\n"._QXZ("WILL LOAD INTO LIST").": $row[list_id]\n";
	if (strlen($row["custom_table"])>0) {echo _QXZ("USES CUSTOM TABLE: YES")."\n";} else {echo _QXZ("USES CUSTOM TABLE: NO")."\n";}
	if (strlen($row["template_statuses"])>0) {echo _QXZ("WILL ONLY DEDUPE AGAINST STATUSES").": ".preg_replace('/\|/', ',', $row["template_statuses"])."\n";}
	exit;
}

if ($form_action=="prime_file" && $sample_template_file_name) 
	{
	$delim_set=0;
	if (preg_match("/\.csv$|\.xls$|\.xlsx$|\.ods$|\.sxc$/i", $sample_template_file_name)) 
		{
		$sample_template_file_name = preg_replace('/[^-\.\_0-9a-zA-Z]/','_',$sample_template_file_name);
		copy($LF_path, "/tmp/$sample_template_file_name");
		$new_filename = preg_replace("/\.csv$|\.xls$|\.xlsx$|\.ods$|\.sxc$/i", '.txt', $sample_template_file_name);
		$convert_command = "$WeBServeRRooT/$admin_web_directory/sheet2tab.pl /tmp/$sample_template_file_name /tmp/$new_filename";
		passthru("$convert_command", $fail_msg);
		$lead_file = "/tmp/$new_filename";
		if ($DB > 0) {echo "|$convert_command|";}

		if (preg_match("/\.csv$/i", $sample_template_file_name)) {$delim_name="CSV: "._QXZ("Comma Separated Values"); $template_file_type="CSV";}
		if (preg_match("/\.xls$/i", $sample_template_file_name)) {$delim_name="XLS: "._QXZ("MS Excel 2000-XP"); $template_file_type="XLS";}
		if (preg_match("/\.xlsx$/i", $sample_template_file_name)) {$delim_name="XLSX: "._QXZ("MS Excel 2007+"); $template_file_type="XLSX";}
		if (preg_match("/\.ods$/i", $sample_template_file_name)) {$delim_name="ODS: "._QXZ("OpenOffice.org OpenDocument Spreadsheet"); $template_file_type="ODS";}
		if (preg_match("/\.sxc$/i", $sample_template_file_name)) {$delim_name="SXC: "._QXZ("OpenOffice.org First Spreadsheet"); $template_file_type="SXC";}
		$delim_set=1;
		}
	else
		{
		copy($LF_path, "/tmp/vicidial_temp_file.txt");
		$lead_file = "/tmp/vicidial_temp_file.txt";
		$template_file_type="TXT";
		}
	$file=fopen("$lead_file", "r");
	if ($webroot_writable > 0)
		{$stmt_file=fopen("$WeBServeRRooT/$admin_web_directory/listloader_stmts.txt", "w");}

	$buffer=fgets($file, 4096);
	$buffer=preg_replace('/[\'\"\n]/i', '', $buffer);
	$tab_count=substr_count($buffer, "\t");
	$pipe_count=substr_count($buffer, "|");

	if ($delim_set < 1)
		{
		if ($tab_count>$pipe_count)
			{$delim_name=_QXZ("tab-delimited");} 
		else 
			{$delim_name=_QXZ("pipe-delimited");}
		} 
	if ($tab_count>$pipe_count)
		{$delimiter="\t";}
	else 
		{$delimiter="|";}
	echo "<script language='Javascript'>\n";
	#echo "parent.document.getElementById(\"sample_template_file_name\").value='$fail_msg';\n";
	#echo "parent.document.getElementById(\"convert_command\").value='$convert_command';\n";
	echo "parent.document.getElementById(\"template_file_type\").value='$template_file_type';\n";
	echo "parent.document.getElementById(\"template_file_delimiter\").value='".urlencode($delimiter)."';\n";
	echo "parent.document.getElementById(\"template_file_buffer\").value='".urlencode($buffer)."';\n";
	echo "parent.document.getElementById(\"template_list_id\").disabled=false;\n";
	echo "parent.document.getElementById(\"template_statuses\").disabled=false;\n";
	echo "</script>";
	$field_check=explode($delimiter, $buffer);
	flush();
	}
else if ($list_id>=0 && $form_action=="no_template") 
	{
	$campaign_stmt="select campaign_id from vicidial_lists where list_id='$list_id'";
	$campaign_rslt=mysql_to_mysqli($campaign_stmt, $link);
	if (mysqli_num_rows($campaign_rslt)>0) 
		{
		$campaign_row=mysqli_fetch_row($campaign_rslt);
		$campaign_id=$campaign_row[0];
		}
	$stmt="select status, status_name from vicidial_statuses UNION select status, status_name from vicidial_campaign_statuses where campaign_id='$campaign_id' order by status, status_name asc";
	$rslt=mysql_to_mysqli($stmt, $link);

	echo "<select id='dedupe_statuses' name='dedupe_statuses[]' size=5 multiple>\n";
	echo "\t<option value='--ALL--' selected>--"._QXZ("ALL DISPOSITIONS")."--</option>\n";
	while ($row=mysqli_fetch_array($rslt)) 
		{
		echo "\t<option value='$row[status]'>$row[status] - $row[status_name]</option>\n";
		}
	echo "</select>\n";
	}
else if ($form_action=="update_template") 
	{
	echo "Hi";
	} 
else
	{

	if ($list_id) 
		{
		$campaign_stmt="select campaign_id from vicidial_lists where list_id='$list_id'";
		$campaign_rslt=mysql_to_mysqli($campaign_stmt, $link);
		if (mysqli_num_rows($campaign_rslt)>0) 
			{
			$campaign_row=mysqli_fetch_row($campaign_rslt);
			$campaign_id=$campaign_row[0];
			}
		$stmt="select status, status_name from vicidial_statuses UNION select status, status_name from vicidial_campaign_statuses where campaign_id='$campaign_id' order by status, status_name asc";
		$rslt=mysql_to_mysqli($stmt, $link);

		echo "<select id='template_statuses' name='template_statuses[]' size=5 multiple>\n";
		echo "\t<option value='--ALL--' selected>--"._QXZ("ALL DISPOSITIONS")."--</option>\n";
		while ($row=mysqli_fetch_array($rslt)) 
			{
			echo "\t<option value='$row[status]'>$row[status] - $row[status_name]</option>\n";
			}
		echo "</select>\n";
		}
	echo "|||";
	
	if ( (preg_match("/;|:|\/|\^|\[|\]|\"|\'|\*/",$LF_orig)) or (preg_match("/;|:|\/|\^|\[|\]|\"|\'|\*/",$sample_template_file_name)) )
		{
		echo _QXZ("ERROR: Invalid File Name").": $LF_orig $sample_template_file_name\n";
		exit;
		}

	$fields_stmt = "SELECT list_id, vendor_lead_code, source_id, phone_code, phone_number, title, first_name, middle_initial, last_name, address1, address2, address3, city, state, province, postal_code, country_code, gender, date_of_birth, alt_phone, email, security_phrase, comments, rank, owner from vicidial_list limit 1";

	$vicidial_list_fields = '|lead_id|vendor_lead_code|source_id|list_id|gmt_offset_now|called_since_last_reset|phone_code|phone_number|title|first_name|middle_initial|last_name|address1|address2|address3|city|state|province|postal_code|country_code|gender|date_of_birth|alt_phone|email|security_phrase|comments|called_count|last_local_call_time|rank|owner|entry_list_id|';

	$vl_fields_count=substr_count($vicidial_listloader_fields, "|")-1;

	##### BEGIN custom fields columns list ###
	if ($custom_fields_enabled > 0)
		{
		$stmt="SHOW TABLES LIKE \"custom_$list_id\";";
		if ($DB>0) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
		$tablecount_to_print = mysqli_num_rows($rslt);
		if ($tablecount_to_print > 0) 
			{
			$stmt="SELECT count(*) from vicidial_lists_fields where list_id='$list_id';";
			if ($DB>0) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
			$fieldscount_to_print = mysqli_num_rows($rslt);
			if ($fieldscount_to_print > 0) 
				{
				$rowx=mysqli_fetch_row($rslt);
				$custom_records_count =	$rowx[0];

				$custom_SQL='';
				$stmt="SELECT field_id,field_label,field_name,field_description,field_rank,field_help,field_type,field_options,field_size,field_max,field_default,field_cost,field_required,multi_position,name_position,field_order from vicidial_lists_fields where list_id='$list_id' order by field_rank,field_order,field_label;";
				if ($DB>0) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
				$fields_to_print = mysqli_num_rows($rslt);
				$fields_list='';
				$o=0;
				while ($fields_to_print > $o) 
					{
					$rowx=mysqli_fetch_row($rslt);
					$A_field_label[$o] =	$rowx[1];
					$A_field_type[$o] =		$rowx[6];

					if ($DB>0) {echo "$A_field_label[$o]|$A_field_type[$o]\n";}

					if ( ($A_field_type[$o]!='DISPLAY') and ($A_field_type[$o]!='SCRIPT') )
						{
						if (!preg_match("/\|$A_field_label[$o]\|/",$vicidial_list_fields))
							{
							$custom_SQL .= ",$A_field_label[$o]";
							}
						}
					$o++;
					}

				$fields_stmt = "SELECT list_id, vendor_lead_code, source_id, phone_code, phone_number, title, first_name, middle_initial, last_name, address1, address2, address3, city, state, province, postal_code, country_code, gender, date_of_birth, alt_phone, email, security_phrase, comments, rank, owner $custom_SQL from vicidial_list, custom_$list_id limit 1";
				}
			}
		}
	##### END custom fields columns list ###

	##### Same code from the listloader page.  Since this is a custom template, it's assumed the layout is "custom" instead of "standard" and follows the coding as such
	#if (($sample_template_file) && ($LF_path))
	if ($delimiter && $buffer)
		{
		$total=0; $good=0; $bad=0; $dup=0; $post=0; $phone_list='';
		$row=explode($delimiter, preg_replace('/[\'\"]/i', '', $buffer));
		}

	echo "<table border=0 width='100%' cellpadding=0 cellspacing=0>";
	$rslt=mysql_to_mysqli("$fields_stmt", $link);
	$custom_fields_count=mysqli_num_fields($rslt)-$vl_fields_count;
	while ($fieldinfo=mysqli_fetch_field($rslt))
		{
		$rslt_field_name=$fieldinfo->name;
		if (preg_match("/$rslt_field_name/", $vicidial_list_fields)) {$bgcolor="#D9E6FE";} else {$bgcolor="#FED9D9";}

		echo "  <tr bgcolor='$bgcolor'>\r\n";
		echo "    <td align=right nowrap><font class=standard>".strtoupper(preg_replace('/_/i', ' ', $rslt_field_name)).": </font></td>\r\n";
		if ($rslt_field_name!="list_id") 
			{
			echo "    <td align=left><select name='$field_prefix".$rslt_field_name."_field' onChange='DrawTemplateStrings()'>\r\n";
			echo "     <option value='-1'>("._QXZ("none").")</option>\r\n";

			for ($j=0; $j<count($row); $j++) 
				{
				preg_replace('/\"/i', '', $row[$j]);
				echo "     <option value='$j'>\"$row[$j]\"</option>\r\n";
				}

			echo "    </select></td>\r\n";
			}
		else 
			{
			echo "    <td align=left>&nbsp;<font class='standard_bold'>$list_id<input type='hidden' name='".$field_prefix.$list_id."' value='$list_id'></font></td>\r\n";
			}
			echo "  </tr>\r\n";
		}
		echo "</table>";
}
?>
