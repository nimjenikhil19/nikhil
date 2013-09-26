<?php
# admin_NANPA_updater.php
# 
# Copyright (C) 2013  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# This script is designed to launch NANPA filter batch proccesses through the
# triggering process
#
# CHANGELOG:
# 130919-1503 - First build of script
#

$version = '2.8-1';
$build = '130919-1503';
$startMS = microtime();

require("dbconnect_mysqli.php");
require("functions.php");

$server_ip=$WEBserver_ip;
$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
if (isset($_GET["submit_form"]))			{$submit_form=$_GET["submit_form"];}
	elseif (isset($_POST["submit_form"]))	{$submit_form=$_POST["submit_form"];}
if (isset($_GET["delete_trigger_id"]))			{$delete_trigger_id=$_GET["delete_trigger_id"];}
	elseif (isset($_POST["delete_trigger_id"]))	{$delete_trigger_id=$_POST["delete_trigger_id"];}
if (isset($_GET["lists"]))			{$lists=$_GET["lists"];}
	elseif (isset($_POST["lists"]))	{$lists=$_POST["lists"];}
if (isset($_GET["fields_to_update"]))			{$fields_to_update=$_GET["fields_to_update"];}
	elseif (isset($_POST["fields_to_update"]))	{$fields_to_update=$_POST["fields_to_update"];}
if (isset($_GET["vl_field_update"]))			{$vl_field_update=$_GET["vl_field_update"];}
	elseif (isset($_POST["vl_field_update"]))	{$vl_field_update=$_POST["vl_field_update"];}
if (isset($_GET["cellphone_list_id"]))			{$cellphone_list_id=$_GET["cellphone_list_id"];}
	elseif (isset($_POST["cellphone_list_id"]))	{$cellphone_list_id=$_POST["cellphone_list_id"];}
if (isset($_GET["landline_list_id"]))			{$landline_list_id=$_GET["landline_list_id"];}
	elseif (isset($_POST["landline_list_id"]))	{$landline_list_id=$_POST["landline_list_id"];}
if (isset($_GET["invalid_list_id"]))			{$invalid_list_id=$_GET["invalid_list_id"];}
	elseif (isset($_POST["invalid_list_id"]))	{$invalid_list_id=$_POST["invalid_list_id"];}
if (isset($_GET["activation_delay"]))			{$activation_delay=$_GET["activation_delay"];}
	elseif (isset($_POST["activation_delay"]))	{$activation_delay=$_POST["activation_delay"];}
if (isset($_GET["DB"]))				{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))	{$DB=$_POST["DB"];}

$block_scheduling_while_running=0;

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,outbound_autodial_active,slave_db_server,reports_use_slave_db,active_voicemail_server FROM system_settings;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {$MAIN.="$stmt\n";}
$qm_conf_ct = mysqli_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$non_latin =					$row[0];
	$outbound_autodial_active =		$row[1];
	$slave_db_server =				$row[2];
	$reports_use_slave_db =			$row[3];
	$active_voicemail_server =		$row[4];
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

$NOW_DATE = date("Y-m-d");

$user_auth=0;
$auth=0;
$reports_auth=0;
$qc_auth=0;
$auth_message = user_authorization($PHP_AUTH_USER,$PHP_AUTH_PW,'QC',1);
if ($auth_message == 'GOOD')
	{$user_auth=1;}

if ($user_auth > 0)
	{
	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and user_level > 7;";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$auth=$row[0];

	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and user_level > 6 and view_reports > 0;";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$reports_auth=$row[0];

	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and user_level > 1 and qc_enabled > 0;";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$qc_auth=$row[0];

	$reports_only_user=0;
	$qc_only_user=0;
	if ( ($reports_auth > 0) and ($auth < 1) )
		{
		$ADD=999999;
		$reports_only_user=1;
		}
	if ( ($qc_auth > 0) and ($reports_auth < 1) and ($auth < 1) )
		{
		if ( ($ADD != '881') and ($ADD != '100000000000000') )
			{
            $ADD=100000000000000;
			}
		$qc_only_user=1;
		}
	if ( ($qc_auth < 1) and ($reports_auth < 1) and ($auth < 1) )
		{
		$VDdisplayMESSAGE = "You do not have permission to be here";
		Header ("Content-type: text/html; charset=utf-8");
		echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$auth_message|\n";
		exit;
		}
	}
else
	{
	$VDdisplayMESSAGE = "Login incorrect, please try again";
	if ($auth_message == 'LOCK')
		{
		$VDdisplayMESSAGE = "Too many login attempts, try again in 15 minutes";
		Header ("Content-type: text/html; charset=utf-8");
		echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$auth_message|\n";
		exit;
		}
	Header("WWW-Authenticate: Basic realm=\"CONTACT-CENTER-ADMIN\"");
	Header("HTTP/1.0 401 Unauthorized");
	echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$PHP_AUTH_PW|$auth_message|\n";
	exit;
	}

if (strlen($active_voicemail_server)<7)
	{
	echo "ERROR: Admin -> System Settings -> Active Voicemail Server is not set\n";
	exit;
	}

if ($delete_trigger_id) 
	{
	$delete_stmt="delete from vicidial_process_triggers where trigger_id='$delete_trigger_id'";
	$delete_rslt=mysqli_query($link, $delete_stmt);
	}

$list_ct=count($lists);
if ($submit_form=="SUBMIT" && $list_ct>0 && (strlen($vl_field_update)>0 || strlen($cellphone_list_id)>0 || strlen($landline_list_id)>0 || strlen($invalid_list_id)>0) ) 
	{
	for ($i=0; $i<$list_ct; $i++) 
		{
		if ($lists[$i]=="---ALL---") 
			{
			unset($lists);
			#$lists[0]="---ALL---";
			$i=$list_ct;

			### Added to make sure that if ALL are selected, it's all inactives.  There is nothing in the actual NANPA filtering scripts that handle it
			### but it needs to be done
			$j=0;
			$stmt="SELECT list_id from vicidial_lists where active='N' order by list_id asc";
			$rslt=mysqli_query($link, $stmt);
			while ($row=mysqli_fetch_array($rslt)) 
				{
				$lists[$j]=$row[0];
				$j++;
				}
			}
		}
	$list_ct=count($lists);

	$cellphone_list_id=preg_replace('/[^0-9]/', '', $cellphone_list_id);
	$landline_list_id=preg_replace('/[^0-9]/', '', $landline_list_id);
	$invalid_list_id=preg_replace('/[^0-9]/', '', $invalid_list_id);

	$options="--user=$PHP_AUTH_USER --pass=$PHP_AUTH_PW ";
	
	$list_id_str="";
	for ($i=0; $i<$list_ct; $i++) 
		{
		$list_id_str.=$lists[$i]."--";
		}
	$list_id_str=substr($list_id_str, 0, -2);
	$options.="--list-id=$list_id_str ";
	
	if (strlen($cellphone_list_id)>0)	{$options.="--cellphone-list-id=$cellphone_list_id ";}
	if (strlen($landline_list_id)>0)	{$options.="--landline-list-id=$landline_list_id ";}
	if (strlen($invalid_list_id)>0)		{$options.="--invalid-list-id=$invalid_list_id ";}
	if (strlen($vl_field_update)>0)		{$options.="--vl-field-update=$vl_field_update ";}
	$options=trim($options);

	$uniqueid=date("U").".".rand(1, 9999);
	$ins_stmt="INSERT into vicidial_process_triggers (trigger_id, trigger_name, server_ip, trigger_time, trigger_run, user, trigger_lines) VALUES('NANPA_".$uniqueid."', 'NANPA updater SCREEN', '$active_voicemail_server', now()+INTERVAL $activation_delay MINUTE, '1', '$PHP_AUTH_USER', '/usr/share/astguiclient/nanpa_type_filter.pl --output-to-db $options')";
	$ins_rslt=mysqli_query($link, $ins_stmt);
	}
header ("Content-type: text/html; charset=utf-8");
if ($SSnocache_admin=='1')
	{
	header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
	header ("Pragma: no-cache");                          // HTTP/1.0
	}


$schedule_stmt="SELECT *, sec_to_time(UNIX_TIMESTAMP(trigger_time)-UNIX_TIMESTAMP(now())) as time_until_execution from vicidial_process_triggers where trigger_name='NANPA updater SCREEN' and user='$PHP_AUTH_USER' and trigger_time>=now()";
$schedule_rslt=mysqli_query($link, $schedule_stmt);

$running_stmt="SELECT output_code from vicidial_nanpa_filter_log where user='$PHP_AUTH_USER' and status!='COMPLETED' order by output_code asc";
$running_rslt=mysqli_query($link, $running_stmt);
if (mysqli_num_rows($running_rslt)>0) {
	$iframe_url="";
	while ($run_row=mysqli_fetch_array($running_rslt)) {
		$iframe_url.="&output_codes_to_display[]=".$run_row[0];
	}
}

echo "<html>\n";
echo "<head>\n";
echo "<!-- VERSION: $admin_version   BUILD: $build   ADD: $ADD   PHP_SELF: $PHP_SELF-->\n";
echo "<META NAME=\"ROBOTS\" CONTENT=\"NONE\">\n";
echo "<META NAME=\"COPYRIGHT\" CONTENT=\"&copy; 2013 ViciDial Group\">\n";
echo "<META NAME=\"AUTHOR\" CONTENT=\"ViciDial Group\">\n";
if ($SSnocache_admin=='1')
	{
	echo "<META HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\">\n";
	echo "<META HTTP-EQUIV=\"Expires\" CONTENT=\"-1\">\n";
	echo "<META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"NO-CACHE\">\n";
	}
if ( ($SSadmin_modify_refresh > 1) and (preg_match("/^3/",$ADD)) )
	{
	$modify_refresh_set=1;
	if (preg_match("/^3/",$ADD)) {$modify_url = "$PHP_SELF?$QUERY_STRING";}
	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"$SSadmin_modify_refresh;URL=$modify_url\">\n";
	}
echo "<title>ADMIN NANPA UPDATER</title>";
?>
<script language="Javascript">
function StartRefresh() {
        rInt=window.setInterval(function() {RefreshNANPA("<?php echo $iframe_url; ?>")}, 10000);
}
function RefreshNANPA(spanURL) {
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	if (xmlhttp) {
		var nanpa_URL = "?"+spanURL;
		// alert(nanpa_URL);
		xmlhttp.open('POST', 'NANPA_running_processes.php');
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send(nanpa_URL);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var ProcessSpanText = null;
				ProcessSpanText = xmlhttp.responseText;
				document.getElementById("running_processes").innerHTML = ProcessSpanText;
				delete xmlhttp;
			}
		}
	}
}
function ShowPastProcesses(limit) {
	if (!limit){var limitURL="";} else {var limitURL="&process_limit="+limit;}

	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	if (xmlhttp) {
		var nanpa_URL = "&show_history=1"+limitURL;
		// alert(nanpa_URL);
		xmlhttp.open('POST', 'NANPA_running_processes.php');
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send(nanpa_URL);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var ProcessSpanText = null;
				ProcessSpanText = xmlhttp.responseText;
				document.getElementById("past_NANPA_scrubs").innerHTML = ProcessSpanText;
				delete xmlhttp;
			}
		}
	}
}
</script>
<?php
echo "</head>\n";
$ADMIN=$PHP_SELF;
$short_header=1;

echo "\n<BODY BGCOLOR=WHITE marginheight=0 marginwidth=0 leftmargin=0 topmargin=0 onLoad='RefreshNANPA(\"$iframe_url\"); StartRefresh()'>\n";

require("admin_header.php");

echo "<form action='$PHP_SELF' method='get' enctype='multipart/form-data'>";
echo "<BR>	<table align=left width='770' border=1 cellpadding=0 cellspacing=0 bgcolor=#D9E6FE>";

if (mysqli_num_rows($schedule_rslt)>0 || (mysqli_num_rows($running_rslt)>0)) {

	if (mysqli_num_rows($schedule_rslt)>0) {
		echo "<tr><td>";
		echo "<table width='770' cellpadding=5 cellspacing=0>";
		echo "<tr><th colspan='5' bgcolor='#015B91'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE SIZE=2>Your scheduled NANPA scrubs</th></tr>";
		echo "<tr>";
		echo "<td align='left' bgcolor='#015B91' width='150'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE SIZE=2>Date/time</th>";
		echo "<td align='left' bgcolor='#015B91' width='300'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE SIZE=2>Lists</th>";
		echo "<td align='left' bgcolor='#015B91' width='100'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE SIZE=2>Update field</th>";
		echo "<td align='left' bgcolor='#015B91' width='150'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE SIZE=2>Conversion lists</th>";
		echo "<td align='left' bgcolor='#015B91' width='70'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE SIZE=2>&nbsp;</th>";
		echo "</tr>";
		while ($row=mysqli_fetch_array($schedule_rslt)) {
			$trigger_array=explode(" ", $row["trigger_lines"]);
			$lists="";
			$vl_update_field="";
			$conversion_lists="";
			for ($q=1; $q<count($trigger_array); $q++) {
				if (preg_match('/--list-id=/', $trigger_array[$q]))
					{
					$data_in=explode("--list-id=", $trigger_array[$q]);
					$lists=trim($data_in[1]);
					$lists=preg_replace('/---/', "", $lists);
					$lists=preg_replace('/--/', ", ", $lists);
					}
				if (preg_match('/--vl-field-update=/', $trigger_array[$q]))
					{
					$data_in=explode("--vl-field-update=", $trigger_array[$q]);
					$vl_update_field=trim($data_in[1]);
					}
				if (preg_match('/--cellphone-list-id=/', $trigger_array[$q]))
					{
					$data_in=explode("--cellphone-list-id=", $trigger_array[$q]);
					$cellphone_list_id=trim($data_in[1]);
					$conversion_lists.="Cellphone list: $cellphone_list_id<BR>";
					}
				if (preg_match('/--landline-list-id=/', $trigger_array[$q]))
					{
					$data_in=explode("--landline-list-id=", $trigger_array[$q]);
					$landline_list_id=trim($data_in[1]);
					$conversion_lists.="Landline list: $landline_list_id<BR>";
					}
				if (preg_match('/--invalid-list-id=/', $trigger_array[$q]))
					{
					$data_in=explode("--invalid-list-id=", $trigger_array[$q]);
					$invalid_list_id=trim($data_in[1]);
					$conversion_lists.="Invalid list: $invalid_list_id<BR>";
					}
			}
			if (strlen($vl_update_field)==0) {$vl_update_field="**NONE**";}
			if (strlen($conversion_lists)==0) {$conversion_lists="**NONE**";}
			echo "<tr>";
			echo "<td align='left'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>$row[trigger_time]</font><BR><FONT FACE=\"ARIAL,HELVETICA\" size='1' color='red'>($row[time_until_execution] until run time)</font></td>";
			echo "<td align='left'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>$lists</font></td>";
			echo "<td align='left'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>$vl_update_field</font></td>";
			echo "<td align='left'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>$conversion_lists</font></td>";
			echo "<td align='center'><FONT FACE=\"ARIAL,HELVETICA\" size='1'><a href='$PHP_SELF?delete_trigger_id=$row[trigger_id]'>DELETE</a></font></td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</td></tr>";
	}

	if (mysqli_num_rows($running_rslt)>0) {
		echo "<tr><td>";
		$iframe_url="NANPA_running_processes.php?";
		while ($run_row=mysqli_fetch_array($running_rslt)) {
			$iframe_url.="output_codes_to_display[]=".$run_row[0];
		}
		#echo "<HR><iframe src='$iframe_url' style='width:100%;background-color:transparent;' scrolling='auto' frameborder='0' allowtransparency='true' width='100%'></iframe>";
		echo "<table width='770' cellpadding=0 cellspacing=0><tr><td>";
		echo "<span id='running_processes' name='running_processes'>";
		echo "</span>";
		echo "</td></tr></table>";

		echo "</td></tr>";
	}
}

############################################

if ( ( (mysqli_num_rows($schedule_rslt)>0) or (mysqli_num_rows($running_rslt)>0) ) and ($block_scheduling_while_running==1) ) 
	{$do_nothing=1;} 
else 
	{
	echo "<tr><td>";

	echo "<table width='770' cellpadding=5 cellspacing=0>";
	echo "<tr><th colspan='5' bgcolor='#015B91'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE SIZE=2>NANPA scrub scheduler</th></tr>";
	echo "<tr>";
	echo "<td align='left' valign='top' rowspan='4'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>Inactive lists:<BR/>\n";

	$stmt="SELECT list_id, list_name from vicidial_lists where active='N' order by list_id asc";
	$rslt=mysqli_query($link, $stmt);
	echo "<select name='lists[]' multiple size='5'>\n";
	echo "<option value='---ALL---'>---ALL LISTS---</option>\n";
	while ($row=mysqli_fetch_array($rslt)) 
		{
		echo "<option value='$row[0]'>$row[0] - $row[1]</option>\n";
		}

	echo "</select></font>";
	echo "</td>";
	echo "<td align='left' valign='top' rowspan='4'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>Field to update (optional):<BR/>\n";
	echo "<select name='vl_field_update'>\n";
	$stmt="SELECT * from vicidial_list limit 1";
	$rslt=mysqli_query($link, $stmt);
	echo "<option value=''>---NONE---</option>\n";
	while ($fieldinfo=mysqli_fetch_field($rslt)) 
		{
		$fieldname=$fieldinfo->name;
		echo "<option value='$fieldname'>$fieldname</option>\n";
		}
	echo "</select></font></td>";

	echo "<td align='left' valign='top' colspan='2'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>List conversions (optional):</font></td>\n";

	echo "<td align='left' valign='top' rowspan='4'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>Time until activation:<BR/>\n";
	echo "<select name='activation_delay'>\n";
	echo "<option value='1'>1 mins</option>\n";
	echo "<option SELECTED value='5'>5 mins</option>\n";
	echo "<option value='10'>10 mins</option>\n";
	echo "<option value='15'>15 mins</option>\n";
	echo "<option value='20'>20 mins</option>\n";
	echo "<option value='30'>30 mins</option>\n";
	echo "<option value='45'>45 mins</option>\n";
	echo "<option value='60'>1 hour</option>\n";
	echo "<option value='120'>2 hours</option>\n";
	echo "<option value='180'>3 hours</option>\n";
	echo "<option value='240'>4 hours</option>\n";
	echo "<option value='480'>8 hours</option>\n";
	echo "</select></font></td>";
	
	echo "</tr>\n";
	echo "<tr>";
	echo "<td align='right'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>Cellphone:</font></td><td align='left'><input type='text' name='cellphone_list_id' size='5' maxlength='10'></td></tr>";
	echo "<td align='right'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>Landline:</font></td><td align='left'><input type='text' name='landline_list_id' size='5' maxlength='10'></td></tr>";
	echo "<td align='right'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>Invalid:</font></td><td align='left'><input type='text' name='invalid_list_id' size='5' maxlength='10'></td></tr>";
	echo "</tr>";
	echo "<tr><td align='center' colspan='5'><input type='submit' value='SUBMIT' name='submit_form'></td></tr>";
	echo "</table>";

	echo "</td></tr>";
	}
echo "<tr><td>";
echo "<table width='770' cellpadding=0 cellspacing=0 bgcolor='#FFFFFF'>";
echo "<tr><td align='center'>";
echo "<span id='past_NANPA_scrubs'><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=1><a name='past_scrubs' href='#past_scrubs' onClick='ShowPastProcesses(10)'>View past scrubs</font></span>";
echo "</td></tr>";
echo "</table>";
echo "</td></tr>";

echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";
?>
