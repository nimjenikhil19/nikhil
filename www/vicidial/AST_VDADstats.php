<?php 
# AST_VDADstats.php
# 
# Copyright (C) 2014  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# CHANGES
# 60619-1718 - Added variable filtering to eliminate SQL injection attack threat
#            - Added required user/pass to gain access to this page
# 61215-1139 - Added drop percentage of answered and round-2 decimal
# 71008-1436 - Added shift to be defined in dbconnect_mysqli.php
# 71218-1155 - Added end_date for multi-day reports
# 80430-1920 - Added Customer hangup cause stats
# 80620-0031 - Fixed human answered calculation for drop perfentage
# 80709-0230 - Added time stats to call statuses
# 80717-2118 - Added calls/hour out of agent login time in status summary
# 80722-2049 - Added Status Category stats
# 81109-2341 - Added Productivity Rating
# 90225-1140 - Changed to multi-campaign capability
# 90310-2034 - Admin header
# 90508-0644 - Changed to PHP long tags
# 90524-2231 - Changed to use functions.php for seconds to HH:MM:SS conversion
# 90608-0251 - Added optional carrier codes stats, made graph at bottom optional
# 90806-0001 - Added CI(Customer Interaction/Human Answered) stats, added option to add inbound rollover stats to these
# 90827-1154 - Added List ID breakdown of calls
# 91222-0843 - Fixed ALL-CAMPAIGNS inbound rollover issue(bug #262), and some other bugs
# 100202-1034 - Added statuses to no-answer section
# 100214-1421 - Sort menu alphabetically
# 100216-0042 - Added popup date selector
# 100712-1324 - Added system setting slave server option
# 100802-2347 - Added User Group Allowed Reports option validation and allowed campaigns restrictions
# 100814-2307 - Added display of preset dials if presets are enabled in the campaign
# 100914-1326 - Added lookup for user_level 7 users to set to reports only which will remove other admin links
# 101207-1634 - Changed limits on seconds to 65000 from 36000 in vicidial_agent_log
# 120224-0910 - Added HTML display option with bar graphs
# 130414-0117 - Added report logging
# 130610-0956 - Finalized changing of all ereg instances to preg
# 130620-2227 - Added filtering of input to prevent SQL injection attacks and new user auth
# 130704-0941 - Fixed issue #675
# 130901-0818 - Changed to mysqli PHP functions
# 140108-0730 - Added webserver and hostname to report logging
# 140208-2033 - Added List select option
# 140215-0704 - Bug fixes related to Lists selection
# 140328-0005 - Converted division calculations to use MathZDC function
#

$startMS = microtime();

header ("Content-type: text/html; charset=utf-8");

require("dbconnect_mysqli.php");
require("functions.php");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
if (isset($_GET["print_calls"]))			{$print_calls=$_GET["print_calls"];}
	elseif (isset($_POST["print_calls"]))	{$print_calls=$_POST["print_calls"];}
if (isset($_GET["outbound_rate"]))			{$outbound_rate=$_GET["outbound_rate"];}
	elseif (isset($_POST["outbound_rate"]))	{$outbound_rate=$_POST["outbound_rate"];}
if (isset($_GET["costformat"]))				{$costformat=$_GET["costformat"];}
	elseif (isset($_POST["costformat"]))	{$costformat=$_POST["costformat"];}
if (isset($_GET["include_rollover"]))			{$include_rollover=$_GET["include_rollover"];}
	elseif (isset($_POST["include_rollover"]))	{$include_rollover=$_POST["include_rollover"];}
if (isset($_GET["carrier_stats"]))			{$carrier_stats=$_GET["carrier_stats"];}
	elseif (isset($_POST["carrier_stats"]))	{$carrier_stats=$_POST["carrier_stats"];}
if (isset($_GET["bottom_graph"]))			{$bottom_graph=$_GET["bottom_graph"];}
	elseif (isset($_POST["bottom_graph"]))	{$bottom_graph=$_POST["bottom_graph"];}
if (isset($_GET["agent_hours"]))			{$agent_hours=$_GET["agent_hours"];}
	elseif (isset($_POST["agent_hours"]))	{$agent_hours=$_POST["agent_hours"];}
if (isset($_GET["group"]))				{$group=$_GET["group"];}
	elseif (isset($_POST["group"]))		{$group=$_POST["group"];}
if (isset($_GET["list_ids"]))				{$list_ids=$_GET["list_ids"];}
	elseif (isset($_POST["list_ids"]))		{$list_ids=$_POST["list_ids"];}
if (isset($_GET["query_date"]))				{$query_date=$_GET["query_date"];}
	elseif (isset($_POST["query_date"]))	{$query_date=$_POST["query_date"];}
if (isset($_GET["end_date"]))				{$end_date=$_GET["end_date"];}
	elseif (isset($_POST["end_date"]))		{$end_date=$_POST["end_date"];}
if (isset($_GET["shift"]))				{$shift=$_GET["shift"];}
	elseif (isset($_POST["shift"]))		{$shift=$_POST["shift"];}
if (isset($_GET["DB"]))					{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))		{$DB=$_POST["DB"];}
if (isset($_GET["submit"]))				{$submit=$_GET["submit"];}
	elseif (isset($_POST["submit"]))	{$submit=$_POST["submit"];}
if (isset($_GET["SUBMIT"]))				{$SUBMIT=$_GET["SUBMIT"];}
	elseif (isset($_POST["SUBMIT"]))	{$SUBMIT=$_POST["SUBMIT"];}
if (isset($_GET["report_display_type"]))				{$report_display_type=$_GET["report_display_type"];}
	elseif (isset($_POST["report_display_type"]))	{$report_display_type=$_POST["report_display_type"];}

if (strlen($shift)<2) {$shift='ALL';}
if (strlen($bottom_graph)<2) {$bottom_graph='NO';}
if (strlen($carrier_stats)<2) {$carrier_stats='NO';}
if (strlen($include_rollover)<2) {$include_rollover='NO';}

$report_name = 'Outbound Calling Report';
$db_source = 'M';
$JS_text="<script language='Javascript'>\n";
$JS_onload="onload = function() {\n";

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,outbound_autodial_active,slave_db_server,reports_use_slave_db FROM system_settings;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysqli_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$non_latin =					$row[0];
	$outbound_autodial_active =		$row[1];
	$slave_db_server =				$row[2];
	$reports_use_slave_db =			$row[3];
	}
##### END SETTINGS LOOKUP #####
###########################################

##### SERVER CARRIER LOGGING LOOKUP #####
$stmt = "SELECT count(*) FROM servers where carrier_logging_active='Y' and max_vicidial_trunks > 0;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$srv_conf_ct = mysqli_num_rows($rslt);
if ($srv_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$carrier_logging_active =		$row[0];
	}

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
$group = preg_replace("/'|\"|\\\\|;/","",$group);

$auth=0;
$reports_auth=0;
$admin_auth=0;
$auth_message = user_authorization($PHP_AUTH_USER,$PHP_AUTH_PW,'REPORTS',1);
if ($auth_message == 'GOOD')
	{$auth=1;}

if ($auth > 0)
	{
	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and user_level > 7 and view_reports > 0;";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$admin_auth=$row[0];

	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and user_level > 6 and view_reports > 0;";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$reports_auth=$row[0];

	if ($reports_auth < 1)
		{
		$VDdisplayMESSAGE = "You are not allowed to view reports";
		Header ("Content-type: text/html; charset=utf-8");
		echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$auth_message|\n";
		exit;
		}
	if ( ($reports_auth > 0) and ($admin_auth < 1) )
		{
		$ADD=999999;
		$reports_only_user=1;
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

##### BEGIN log visit to the vicidial_report_log table #####
$LOGip = getenv("REMOTE_ADDR");
$LOGbrowser = getenv("HTTP_USER_AGENT");
$LOGscript_name = getenv("SCRIPT_NAME");
$LOGserver_name = getenv("SERVER_NAME");
$LOGserver_port = getenv("SERVER_PORT");
$LOGrequest_uri = getenv("REQUEST_URI");
$LOGhttp_referer = getenv("HTTP_REFERER");
if (preg_match("/443/i",$LOGserver_port)) {$HTTPprotocol = 'https://';}
  else {$HTTPprotocol = 'http://';}
if (($LOGserver_port == '80') or ($LOGserver_port == '443') ) {$LOGserver_port='';}
else {$LOGserver_port = ":$LOGserver_port";}
$LOGfull_url = "$HTTPprotocol$LOGserver_name$LOGserver_port$LOGrequest_uri";

$LOGhostname = php_uname('n');
if (strlen($LOGhostname)<1) {$LOGhostname='X';}
if (strlen($LOGserver_name)<1) {$LOGserver_name='X';}

$stmt="SELECT webserver_id FROM vicidial_webservers where webserver='$LOGserver_name' and hostname='$LOGhostname' LIMIT 1;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$webserver_id_ct = mysqli_num_rows($rslt);
if ($webserver_id_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$webserver_id = $row[0];
	}
else
	{
	##### insert webserver entry
	$stmt="INSERT INTO vicidial_webservers (webserver,hostname) values('$LOGserver_name','$LOGhostname');";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$affected_rows = mysqli_affected_rows($link);
	$webserver_id = mysqli_insert_id($link);
	}

$stmt="INSERT INTO vicidial_report_log set event_date=NOW(), user='$PHP_AUTH_USER', ip_address='$LOGip', report_name='$report_name', browser='$LOGbrowser', referer='$LOGhttp_referer', notes='$LOGserver_name:$LOGserver_port $LOGscript_name |$group[0], $query_date, $end_date, $shift, $file_download, $report_display_type|', url='$LOGfull_url', webserver='$webserver_id';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$report_log_id = mysqli_insert_id($link);
##### END log visit to the vicidial_report_log table #####

if ( (strlen($slave_db_server)>5) and (preg_match("/$report_name/",$reports_use_slave_db)) )
	{
	mysqli_close($link);
	$use_slave_server=1;
	$db_source = 'S';
	require("dbconnect_mysqli.php");
	echo "<!-- Using slave server $slave_db_server $db_source -->\n";
	}

$stmt="SELECT user_group from vicidial_users where user='$PHP_AUTH_USER';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$row=mysqli_fetch_row($rslt);
$LOGuser_group =			$row[0];

$stmt="SELECT allowed_campaigns,allowed_reports from vicidial_user_groups where user_group='$LOGuser_group';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$row=mysqli_fetch_row($rslt);
$LOGallowed_campaigns = $row[0];
$LOGallowed_reports =	$row[1];

if ( (!preg_match("/$report_name/",$LOGallowed_reports)) and (!preg_match("/ALL REPORTS/",$LOGallowed_reports)) )
	{
    Header("WWW-Authenticate: Basic realm=\"CONTACT-CENTER-ADMIN\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "You are not allowed to view this report: |$PHP_AUTH_USER|$report_name|\n";
    exit;
	}

$NOW_DATE = date("Y-m-d");
$NOW_TIME = date("Y-m-d H:i:s");
$STARTtime = date("U");
if (!isset($group)) {$group = '';}
if (!isset($query_date)) {$query_date = $NOW_DATE;}
if (!isset($end_date)) {$end_date = $NOW_DATE;}

$i=0;
$group_string='|';
$group_ct = count($group);
while($i < $group_ct)
	{
	$group_string .= "$group[$i]|";
	$i++;
	}

$LOGallowed_campaignsSQL='';
$whereLOGallowed_campaignsSQL='';
if ( (!preg_match('/\-ALL/i', $LOGallowed_campaigns)) )
	{
	$rawLOGallowed_campaignsSQL = preg_replace("/ -/",'',$LOGallowed_campaigns);
	$rawLOGallowed_campaignsSQL = preg_replace("/ /","','",$rawLOGallowed_campaignsSQL);
	$LOGallowed_campaignsSQL = "and campaign_id IN('$rawLOGallowed_campaignsSQL')";
	$whereLOGallowed_campaignsSQL = "where campaign_id IN('$rawLOGallowed_campaignsSQL')";
	}
$regexLOGallowed_campaigns = " $LOGallowed_campaigns ";

$stmt="select campaign_id,campaign_name from vicidial_campaigns $whereLOGallowed_campaignsSQL order by campaign_id;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$campaigns_to_print = mysqli_num_rows($rslt);
$i=0;
while ($i < $campaigns_to_print)
	{
	$row=mysqli_fetch_row($rslt);
	$groups[$i] =		$row[0];
	$group_names[$i] =	$row[1];
	if (preg_match('/\-ALL/',$group_string) )
		{$group[$i] = $groups[$i];}
	$i++;
	}

$rollover_groups_count=0;
$i=0;
$group_string='|';
$group_ct = count($group);
while($i < $group_ct)
	{
	if ( (preg_match("/ $group[$i] /",$regexLOGallowed_campaigns)) or (preg_match("/-ALL/",$LOGallowed_campaigns)) )
		{
		$group_string .= "$group[$i]|";
		$group_SQL .= "'$group[$i]',";
		$groupQS .= "&group[]=$group[$i]";
		}

	if (preg_match("/YES/i",$include_rollover))
		{
		$stmt="select drop_inbound_group from vicidial_campaigns where campaign_id='$group[$i]' $LOGallowed_campaignsSQL and drop_inbound_group NOT LIKE \"%NONE%\" and drop_inbound_group is NOT NULL and drop_inbound_group != '';";
		$rslt=mysql_to_mysqli($stmt, $link);
		if ($DB) {echo "$stmt\n";}
		$in_groups_to_print = mysqli_num_rows($rslt);
		if ($in_groups_to_print > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$group_drop_SQL .= "'$row[0]',";

			$rollover_groups_count++;
			}
		}

	$i++;
	}
if (strlen($group_drop_SQL) < 2)
	{$group_drop_SQL = "''";}
if ( (preg_match('/\-\-ALL\-\-/',$group_string) ) or ($group_ct < 1) or (strlen($group_string) < 2) )
	{
	$group_SQL = "$LOGallowed_campaignsSQL";
	$group_drop_SQL = "";
	}
else
	{
	$group_SQL = preg_replace('/,$/i', '',$group_SQL);
	$group_drop_SQL = preg_replace('/,$/i', '',$group_drop_SQL);
	$both_group_SQLand = "and ( (campaign_id IN($group_drop_SQL)) or (campaign_id IN($group_SQL)) )";
	$both_group_SQL = "where ( (campaign_id IN($group_drop_SQL)) or (campaign_id IN($group_SQL)) )";
	$group_SQLand = "and campaign_id IN($group_SQL)";
	$group_SQL = "where campaign_id IN($group_SQL)";
	$group_drop_SQLand = "and campaign_id IN($group_drop_SQL)";
	$group_drop_SQL = "where campaign_id IN($group_drop_SQL)";
	}

$i=0;
$list_id_string='|';
$list_id_ct = count($list_ids);
while($i < $list_id_ct)
	{
	$list_id_string .= "$list_ids[$i]|";
	$list_id_SQL .= "'$list_ids[$i]',";
	$list_idQS .= "&list_ids[]=$list_ids[$i]";
	$VL_INC=",vicidial_list";

	$i++;
	}

if ( (preg_match('/\-\-ALL\-\-/',$list_id_string) ) or ($list_id_ct < 1) or (strlen($list_id_string) < 2) )
	{
	$list_id_SQL = "";
	$list_id_drop_SQL = "";
	$VL_INC="";
	$skip_productivity_calc=0;
	}
else 
	{
	$list_id_SQL = preg_replace('/,$/i', '',$list_id_SQL);
	$list_id_SQLand = "and list_id IN($list_id_SQL)";
	$list_id_SQLandVALJOIN = "and vicidial_agent_log.lead_id=vicidial_list.lead_id and vicidial_list.list_id IN($list_id_SQL)";
	$list_id_SQLandUCLJOIN = "and user_call_log.lead_id=vicidial_list.lead_id and vicidial_list.list_id IN($list_id_SQL)";
	$list_id_SQL = "where list_id IN($list_id_SQL)";
	$skip_productivity_calc=1;
	}


$stmt="select vsc_id,vsc_name from vicidial_status_categories;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$statcats_to_print = mysqli_num_rows($rslt);
$i=0;
while ($i < $statcats_to_print)
	{
	$row=mysqli_fetch_row($rslt);
	$vsc_id[$i] =	$row[0];
	$vsc_name[$i] =	$row[1];
	$vsc_count[$i] = 0;
	$i++;
	}

$customer_interactive_statuses='';
$stmt="select status from vicidial_statuses where human_answered='Y';";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$statha_to_print = mysqli_num_rows($rslt);
$i=0;
while ($i < $statha_to_print)
	{
	$row=mysqli_fetch_row($rslt);
	$customer_interactive_statuses .= "'$row[0]',";
	$i++;
	}
$stmt="select status from vicidial_campaign_statuses where human_answered='Y' $group_SQLand;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$statha_to_print = mysqli_num_rows($rslt);
$i=0;
while ($i < $statha_to_print)
	{
	$row=mysqli_fetch_row($rslt);
	$customer_interactive_statuses .= "'$row[0]',";
	$i++;
	}
if (strlen($customer_interactive_statuses)>2)
	{$customer_interactive_statuses = substr("$customer_interactive_statuses", 0, -1);}
else
	{$customer_interactive_statuses="''";}

?>

<!DOCTYPE HTML>
<HEAD>
<STYLE type="text/css">
<!--
   .green {color: white; background-color: green}
   .red {color: white; background-color: red}
   .blue {color: white; background-color: blue}
   .purple {color: white; background-color: purple}
-->
 </STYLE>

<?php 

echo "<script language=\"JavaScript\" src=\"calendar_db.js\"></script>\n";
echo "<link rel=\"stylesheet\" href=\"calendar.css\">\n";
echo "<link rel=\"stylesheet\" href=\"horizontalbargraph.css\">\n";


echo "<script language=\"JavaScript\">\n";
$list_stmt="select list_id, list_name, campaign_id from vicidial_lists $whereLOGallowed_campaignsSQL order by list_id asc";
$list_rslt=mysql_to_mysqli($list_stmt, $link);
$list_rows=mysqli_num_rows($list_rslt);
$list_options="<select name='list_ids[]' id='list_ids' multiple size=5>\n";
	if  (preg_match('/\-\-ALL\-\-/',$list_id_string))
		{$list_options.="<option value=\"--ALL--\" selected>-- ALL LISTS --</option>\n";}
	else
		{$list_options.="<option value=\"--ALL--\">-- ALL LISTS --</option>\n";}


if ($list_rows>0) {

	$list_id_ary_str.="var list_id_ary=[";
	$list_name_ary_str.="var list_name_ary=[";
	$campaign_id_ary_str.="var campaign_id_ary=[";
	while ($list_row=mysqli_fetch_row($list_rslt)) {
		$list_id_ary_str.="'$list_row[0]',";
		$list_name_ary_str.="'$list_row[1]',";
		$campaign_id_ary_str.="'$list_row[2]',";

		if (preg_match("/\|$list_row[0]\|/i",$list_id_string)) {$list_options.="<option selected value=\"$list_row[0]\">$list_row[0] - $list_row[1]</option>\n";}
		  else {$list_options.="<option value=\"$list_row[0]\">$list_row[0] - $list_row[1]</option>\n";}

		#$list_options.="\t<option value='$list_row[0]'>$list_row[0] - $list_row[1]</option>\n";
	}
	$list_id_ary_str=preg_replace('/,$/', '', $list_id_ary_str)."];\n";
	$list_name_ary_str=preg_replace('/,$/', '', $list_name_ary_str)."];\n";
	$campaign_id_ary_str=preg_replace('/,$/', '', $campaign_id_ary_str)."];\n";

	echo $list_id_ary_str;
	echo $list_name_ary_str;
	echo $campaign_id_ary_str;
}

$list_options.="</select>\n";
?>

function LoadLists(FromBox) {
	if (!FromBox) {alert("NO"); return false;}
	var selectedCampaigns="|";
	var selectedcamps = new Array();



	for(i = 0; i < document.getElementById('group').options.length; i++) {
		if (document.getElementById('group').options[i].selected) {
			selectedCampaigns += document.getElementById('group').options[i].value+"|";
		} 
	}

	// Clear List menu
	document.getElementById('list_ids').options.length=0;
	var new_list = new Option();
	new_list.value = "--ALL--";
	new_list.text = "--ALL LISTS--";
	document.getElementById('list_ids')[0] = new_list;

	list_id_index=1;
	for (j=0; j<campaign_id_ary.length; j++) {
		var campaignID="/\|"+campaign_id_ary[j]+"\|/g";
		var campaign_matches = selectedCampaigns.match(campaignID);
		if (campaign_matches) {

			var new_list = new Option();
			new_list.value = list_id_ary[j];
			new_list.text = list_id_ary[j]+" - "+list_name_ary[j];
			document.getElementById('list_ids')[list_id_index] = new_list;
			list_id_index++;
		}
	}
}
<?php
echo "</script>\n";

echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">\n";
echo "<TITLE>$report_name</TITLE></HEAD><BODY BGCOLOR=WHITE marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";

$short_header=1;
$draw_graph=1;

require("admin_header.php");

echo "<TABLE CELLPADDING=4 CELLSPACING=0><TR><TD>";

echo "<FORM ACTION=\"$PHP_SELF\" METHOD=GET name=vicidial_report id=vicidial_report>\n";
echo "<TABLE CELLSPACING=3><TR><TD VALIGN=TOP> Dates:<BR>";
echo "<INPUT TYPE=HIDDEN NAME=agent_hours VALUE=\"$agent_hours\">\n";
echo "<INPUT TYPE=HIDDEN NAME=DB VALUE=\"$DB\">\n";
echo "<INPUT TYPE=HIDDEN NAME=outbound_rate VALUE=\"$outbound_rate\">\n";
echo "<INPUT TYPE=HIDDEN NAME=costformat VALUE=\"$costformat\">\n";
echo "<INPUT TYPE=HIDDEN NAME=print_calls VALUE=\"$print_calls\">\n";
echo "<INPUT TYPE=TEXT NAME=query_date SIZE=10 MAXLENGTH=10 VALUE=\"$query_date\">";

?>
<script language="JavaScript">
var o_cal = new tcal ({
	// form name
	'formname': 'vicidial_report',
	// input name
	'controlname': 'query_date'
});
o_cal.a_tpl.yearscroll = false;
// o_cal.a_tpl.weekstart = 1; // Monday week start
</script>
<?php

echo "<BR> to <BR><INPUT TYPE=TEXT NAME=end_date SIZE=10 MAXLENGTH=10 VALUE=\"$end_date\">";

?>
<script language="JavaScript">
var o_cal = new tcal ({
	// form name
	'formname': 'vicidial_report',
	// input name
	'controlname': 'end_date'
});
o_cal.a_tpl.yearscroll = false;
// o_cal.a_tpl.weekstart = 1; // Monday week start
</script>
<?php
if (preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT'])) {
	$JS_events="onBlur='LoadLists(this.form.group)' onKeyUp='LoadLists(this.form.group)'";
} else {
	$JS_events="onMouseUp='LoadLists(this.form.group)' onBlur='LoadLists(this.form.group)' onKeyUp='LoadLists(this.form.group)'";
}
echo "</TD><TD VALIGN=TOP> Campaigns:<BR>";
echo "<SELECT multiple SIZE=5 NAME=group[] id='group' $JS_events>\n";
if  (preg_match('/\-\-ALL\-\-/',$group_string))
	{echo "<option value=\"--ALL--\" selected>-- ALL CAMPAIGNS --</option>\n";}
else
	{echo "<option value=\"--ALL--\">-- ALL CAMPAIGNS --</option>\n";}
$o=0;
while ($campaigns_to_print > $o)
	{
	if (preg_match("/$groups[$o]\|/i",$group_string)) {echo "<option selected value=\"$groups[$o]\">$groups[$o] - $group_names[$o]</option>\n";}
	  else {echo "<option value=\"$groups[$o]\">$groups[$o] - $group_names[$o]</option>\n";}
	$o++;
	}
echo "</SELECT>\n";
echo "</TD><TD VALIGN=TOP>";
echo "Lists: <font size=1>(optional, possibly slow)</font><BR>\n";
echo $list_options;
echo "</TD><TD VALIGN=TOP>";
echo "Include Drop &nbsp; <BR>Rollover:<BR>";
echo "<SELECT SIZE=1 NAME=include_rollover>\n";
echo "<option selected value=\"$include_rollover\">$include_rollover</option>\n";
echo "<option value=\"YES\">YES</option>\n";
echo "<option value=\"NO\">NO</option>\n";
echo "</SELECT>\n";
echo "<BR>Bottom Graph: &nbsp; <BR>\n";
echo "<SELECT SIZE=1 NAME=bottom_graph>\n";
echo "<option selected value=\"$bottom_graph\">$bottom_graph</option>\n";
echo "<option value=\"YES\">YES</option>\n";
echo "<option value=\"NO\">NO</option>\n";
echo "</SELECT><BR>\n";
if ($carrier_logging_active > 0)
	{
	echo "</TD><TD VALIGN=TOP>Carrier Stats: &nbsp; <BR>";
	echo "<SELECT SIZE=1 NAME=carrier_stats>\n";
	echo "<option selected value=\"$carrier_stats\">$carrier_stats</option>\n";
	echo "<option value=\"YES\">YES</option>\n";
	echo "<option value=\"NO\">NO</option>\n";
	echo "</SELECT>\n";
	}
echo "<BR><BR>Display as:<BR>";
echo "<select name='report_display_type'>";
if ($report_display_type) {echo "<option value='$report_display_type' selected>$report_display_type</option>";}
echo "<option value='TEXT'>TEXT</option><option value='HTML'>HTML</option></select>\n<BR>";
echo "</TD><TD VALIGN=TOP>Shift: &nbsp; <BR>";
echo "<SELECT SIZE=1 NAME=shift>\n";
echo "<option selected value=\"$shift\">$shift</option>\n";
echo "<option value=\"\">--</option>\n";
echo "<option value=\"AM\">AM</option>\n";
echo "<option value=\"PM\">PM</option>\n";
echo "<option value=\"ALL\">ALL</option>\n";
echo "</SELECT><BR><BR>\n";
echo "<INPUT type=submit NAME=SUBMIT VALUE=SUBMIT>\n";
echo "</TD><TD VALIGN=TOP> &nbsp; &nbsp; &nbsp; &nbsp; ";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
if (strlen($group[0]) > 1)
	{
	echo " <a href=\"./admin.php?ADD=34&campaign_id=$group[0]\">MODIFY</a> | \n";
	echo " <a href=\"./admin.php?ADD=999999\">REPORTS</a> </FONT>\n";
	}
else
	{
	echo " <a href=\"./admin.php?ADD=10\">CAMPAIGNS</a> | \n";
	echo " <a href=\"./admin.php?ADD=999999\">REPORTS</a> </FONT>\n";
	}
echo "</TD></TR></TABLE>";
echo "</FORM>\n\n";

echo "<PRE><FONT SIZE=2>\n\n";


if (strlen($group[0]) < 1)
	{
	echo "\n\n";
	echo "PLEASE SELECT A CAMPAIGN AND DATE ABOVE AND CLICK SUBMIT\n";
	}

else
	{
	if ($shift == 'AM') 
		{
		$time_BEGIN=$AM_shift_BEGIN;
		$time_END=$AM_shift_END;
		if (strlen($time_BEGIN) < 6) {$time_BEGIN = "03:45:00";}   
		if (strlen($time_END) < 6) {$time_END = "15:14:59";}
		}
	if ($shift == 'PM') 
		{
		$time_BEGIN=$PM_shift_BEGIN;
		$time_END=$PM_shift_END;
		if (strlen($time_BEGIN) < 6) {$time_BEGIN = "15:15:00";}
		if (strlen($time_END) < 6) {$time_END = "23:15:00";}
		}
	if ($shift == 'ALL') 
		{
		if (strlen($time_BEGIN) < 6) {$time_BEGIN = "00:00:00";}
		if (strlen($time_END) < 6) {$time_END = "23:59:59";}
		}
	$query_date_BEGIN = "$query_date $time_BEGIN";   
	$query_date_END = "$end_date $time_END";


	$OUToutput = '';
	$OUToutput .= "Outbound Calling Stats                             $NOW_TIME\n";

	$OUToutput .= "\n";
	$OUToutput .= "Time range: $query_date_BEGIN to $query_date_END\n\n";
	$OUToutput .= "---------- TOTALS\n";

	$stmt="select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand;";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$row=mysqli_fetch_row($rslt);

	$TOTALcallsRAW = $row[0];
	$TOTALsec =		$row[1];
	$inTOTALcallsRAW=0;
	if (preg_match("/YES/i",$include_rollover))
		{
		$length_in_secZ=0;
		$queue_secondsZ=0;
		$agent_alert_delayZ=0;
		$stmt="select length_in_sec,queue_seconds,agent_alert_delay from vicidial_closer_log,vicidial_inbound_groups where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and group_id=campaign_id $group_drop_SQLand $list_id_SQLand;";
		$rslt=mysql_to_mysqli($stmt, $link);
		if ($DB) {echo "$stmt\n";}
		$INallcalls_to_printZ = mysqli_num_rows($rslt);
		$y=0;
		while ($y < $INallcalls_to_printZ)
			{
			$row=mysqli_fetch_row($rslt);

			$length_in_secZ = $row[0];
			$queue_secondsZ = $row[1];
			$agent_alert_delayZ = $row[2];

			$TOTALdelay =		round(MathZDC($agent_alert_delayZ, 1000));
			$thiscallsec = (($length_in_secZ - $queue_secondsZ) - $TOTALdelay);
			if ($thiscallsec < 0)
				{$thiscallsec = 0;}
			$inTOTALsec =	($inTOTALsec + $thiscallsec);	

			$y++;
			}

		$inTOTALcallsRAW =	$y;
		$TOTALsec = ($TOTALsec + $inTOTALsec);
		$inTOTALcalls =	sprintf("%10s", $inTOTALcallsRAW);
		}

	$TOTALcalls =	sprintf("%10s", $TOTALcallsRAW);
	$average_call_seconds = MathZDC($TOTALsec, $TOTALcallsRAW);
	$average_call_seconds = round($average_call_seconds, 2);
	$average_call_seconds =	sprintf("%10s", $average_call_seconds);

	$OUToutput .= "Total Calls placed from this Campaign:        $TOTALcalls\n";
	$OUToutput .= "Average Call Length for all Calls in seconds: $average_call_seconds\n";
	if (preg_match("/YES/i",$include_rollover))
		{$OUToutput .= "Calls that went to rollover In-Group:         $inTOTALcalls\n";}


	$OUToutput .= "\n";
	$OUToutput .= "---------- HUMAN ANSWERS\n";

	$stmt="select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and status IN($customer_interactive_statuses) $group_SQLand $list_id_SQLand;";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$row=mysqli_fetch_row($rslt);
	$CIcallsRAW =	$row[0];
	$CIsec =		$row[1];

	if (preg_match("/YES/i",$include_rollover))
		{
		$length_in_secZ=0;
		$queue_secondsZ=0;
		$agent_alert_delayZ=0;
		$stmt="select length_in_sec,queue_seconds,agent_alert_delay from vicidial_closer_log,vicidial_inbound_groups where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and group_id=campaign_id and vicidial_closer_log.status IN($customer_interactive_statuses) $group_drop_SQLand $list_id_SQLand;";
		$rslt=mysql_to_mysqli($stmt, $link);
		if ($DB) {echo "$stmt\n";}
		$INallcalls_to_printZ = mysqli_num_rows($rslt);
		$y=0;
		while ($y < $INallcalls_to_printZ)
			{
			$row=mysqli_fetch_row($rslt);

			$length_in_secZ = $row[0];
			$queue_secondsZ = $row[1];
			$agent_alert_delayZ = $row[2];

			$CIdelay =		round(MathZDC($agent_alert_delayZ, 1000));
			$thiscallsec = (($length_in_secZ - $queue_secondsZ) - $CIdelay);
			if ($thiscallsec < 0)
				{$thiscallsec = 0;}
			$inCIsec =	($inCIsec + $thiscallsec);	

			$y++;
			}

		$inCIcallsRAW =	$y;
		$CIsec = ($CIsec + $inCIsec);
		$CIcallsRAW = ($CIcallsRAW + $inCIcallsRAW);
		}

	$CIcalls =	sprintf("%10s", $CIcallsRAW);
	$average_ci_seconds = MathZDC($CIsec, $CIcallsRAW);
	$average_ci_seconds = round($average_ci_seconds, 2);
	$average_ci_seconds =	sprintf("%10s", $average_ci_seconds);
	$CIsec =		sec_convert($CIsec,'H'); 


	$OUToutput .= "Total Human Answered calls for this Campaign: $CIcalls\n";
	$OUToutput .= "Average Call Length for all HA in seconds:    $average_ci_seconds     Total Time: $CIsec\n";


	$OUToutput .= "\n";
	$OUToutput .= "---------- DROPS\n";

	$stmt="select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and status='DROP' and (length_in_sec <= 6000 or length_in_sec is null);";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$row=mysqli_fetch_row($rslt);
	$DROPcalls =	sprintf("%10s", $row[0]);
	$DROPcallsRAW =	$row[0];
	$DROPseconds =	$row[1];


	# GET LIST OF ALL STATUSES and create SQL from human_answered statuses
	$q=0;
	$stmt = "SELECT status,status_name,human_answered,category from vicidial_statuses;";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$statuses_to_print = mysqli_num_rows($rslt);
	$p=0;
	while ($p < $statuses_to_print)
		{
		$row=mysqli_fetch_row($rslt);
		$status[$q] =			$row[0];
		$status_name[$q] =		$row[1];
		$human_answered[$q] =	$row[2];
		$category[$q] =			$row[3];
		$statname_list["$status[$q]"] = "$status_name[$q]";
		$statcat_list["$status[$q]"] = "$category[$q]";
		if ($human_answered[$q]=='Y')
			{$camp_ANS_STAT_SQL .=	 "'$row[0]',";}
		$q++;
		$p++;
		}

	$stmt = "SELECT distinct status,status_name,human_answered,category from vicidial_campaign_statuses $group_SQL;";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$statuses_to_print = mysqli_num_rows($rslt);
	$p=0;
	while ($p < $statuses_to_print)
		{
		$row=mysqli_fetch_row($rslt);
		$status[$q] =			$row[0];
		$status_name[$q] =		$row[1];
		$human_answered[$q] =	$row[2];
		$category[$q] =			$row[3];
		$statname_list["$status[$q]"] = "$status_name[$q]";
		$statcat_list["$status[$q]"] = "$category[$q]";
		if ($human_answered[$q]=='Y')
			{$camp_ANS_STAT_SQL .=	 "'$row[0]',";}
		$q++;
		$p++;
		}
	$camp_ANS_STAT_SQL = preg_replace('/,$/i', '',$camp_ANS_STAT_SQL);


	$stmt="select count(*) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and status IN($camp_ANS_STAT_SQL);";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$row=mysqli_fetch_row($rslt);
	$ANSWERcalls =	$row[0];

	$DROPpercent = (MathZDC($DROPcallsRAW, $TOTALcalls) * 100);
	$DROPpercent = round($DROPpercent, 2);

	$DROPANSWERpercent = (MathZDC($DROPcallsRAW, $ANSWERcalls) * 100);
	$DROPANSWERpercent = round($DROPANSWERpercent, 2);

	$average_hold_seconds = MathZDC($DROPseconds, $DROPcallsRAW);
	$average_hold_seconds = round($average_hold_seconds, 2);
	$average_hold_seconds =	sprintf("%10s", $average_hold_seconds);

	$OUToutput .= "Total Outbound DROP Calls:                    $DROPcalls  $DROPpercent%\n";
	$OUToutput .= "Percent of DROP Calls taken out of Answers:   $DROPcalls / $ANSWERcalls  $DROPANSWERpercent%\n";

	if (preg_match("/YES/i",$include_rollover))
		{
		$inDROPANSWERpercent = (MathZDC($DROPcallsRAW, $CIcallsRAW) * 100);
		$inDROPANSWERpercent = round($inDROPANSWERpercent, 2);

		$OUToutput .= "Percent of DROP/Answer Calls with Rollover:   $DROPcalls / $CIcallsRAW  $inDROPANSWERpercent%\n";
		}

	$OUToutput .= "Average Length for DROP Calls in seconds:     $average_hold_seconds\n";

	$stmt = "select closer_campaigns from vicidial_campaigns $group_SQL;";
	$rslt=mysql_to_mysqli($stmt, $link);
	$ccamps_to_print = mysqli_num_rows($rslt);
	$c=0;
	while ($ccamps_to_print > $c)
		{
		$row=mysqli_fetch_row($rslt);
		$closer_campaigns = $row[0];
		$closer_campaigns = preg_replace("/^ | -$/","",$closer_campaigns);
		$closer_campaigns = preg_replace("/ /","','",$closer_campaigns);
		$closer_campaignsSQL .= "'$closer_campaigns',";
		$c++;
		}
	$closer_campaignsSQL = preg_replace('/,$/i', '',$closer_campaignsSQL);

	$stmt="select count(*) from vicidial_closer_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and  campaign_id IN($closer_campaignsSQL) $list_id_SQLand and status NOT IN('DROP','XDROP','HXFER','QVMAIL','HOLDTO','LIVE','QUEUE');";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$row=mysqli_fetch_row($rslt);
	$TOTALanswers = ($row[0] + $ANSWERcalls);

	
	$stmt = "SELECT sum(wait_sec + talk_sec + dispo_sec) from vicidial_agent_log$VL_INC where event_time >= '$query_date_BEGIN' and event_time <= '$query_date_END' and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 $group_SQLand $list_id_SQLandVALJOIN;";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$row=mysqli_fetch_row($rslt);
	$agent_non_pause_sec = $row[0];

	$AVG_ANSWERagent_non_pause_sec = (MathZDC($TOTALanswers, $agent_non_pause_sec) * 60);
	$AVG_ANSWERagent_non_pause_sec = round($AVG_ANSWERagent_non_pause_sec, 2);
	$AVG_ANSWERagent_non_pause_sec = sprintf("%10s", $AVG_ANSWERagent_non_pause_sec);

	if ($skip_productivity_calc) {
		$OUToutput .= "Productivity Rating:                                 N/A\n";
	} else {
		$OUToutput .= "Productivity Rating:                          $AVG_ANSWERagent_non_pause_sec\n";
	}




	$OUToutput .= "\n";
	$OUToutput .= "---------- NO ANSWERS\n";

	$stmt="select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and status IN('NA','ADC','AB','CPDB','CPDUK','CPDATB','CPDNA','CPDREJ','CPDINV','CPDSUA','CPDSI','CPDSNC','CPDSR','CPDSUK','CPDSV','CPDERR') and (length_in_sec <= 60 or length_in_sec is null);";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$row=mysqli_fetch_row($rslt);
	$autoNAcalls =	sprintf("%10s", $row[0]);

	$stmt="select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and status IN('B','DC','N') and (length_in_sec <= 60 or length_in_sec is null);";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$OUToutput .= "$stmt\n";}
	$row=mysqli_fetch_row($rslt);
	$manualNAcalls =	sprintf("%10s", $row[0]);

	$totalNAcalls = ($autoNAcalls + $manualNAcalls);
	$totalNAcalls =	sprintf("%10s", $totalNAcalls);


	$NApercent = (MathZDC($totalNAcalls, $TOTALcalls) * 100);
	$NApercent = round($NApercent, 2);
	
	$average_na_seconds = MathZDC($row[1], $row[0]);
	$average_na_seconds = round($average_na_seconds, 2);
	$average_na_seconds =	sprintf("%10s", $average_na_seconds);

	$OUToutput .= "Total NA calls -Busy,Disconnect,RingNoAnswer: $totalNAcalls  $NApercent%\n";
	$OUToutput .= "Total auto NA calls -system-set:              $autoNAcalls\n";
	$OUToutput .= "Total manual NA calls -agent-set:             $manualNAcalls\n";
	$OUToutput .= "Average Call Length for NA Calls in seconds:  $average_na_seconds\n";


	##############################
	#########  CALL HANGUP REASON STATS

	$TOTALcalls = 0;

	$ASCII_text .= "\n";
	$ASCII_text .= "---------- CALL HANGUP REASON STATS\n";
	$ASCII_text .= "+----------------------+------------+\n";
	$ASCII_text .= "| HANGUP REASON        | CALLS      |\n";
	$ASCII_text .= "+----------------------+------------+\n";

	$GRAPH.="<BR/><BR/><table cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"white\" summary=\"DID Summary\" class=\"horizontalgraph\">\n";
	$GRAPH.="<caption align='top'>CALL HANGUP REASON STATS</caption>";
	$GRAPH.="<tr>\n";
	$GRAPH.="<th class=\"thgraph\" scope=\"col\">DID</th>\n";
	$GRAPH.="<th class=\"thgraph\" scope=\"col\">CALLS</th>\n";
	$GRAPH.="</tr>\n";

	$stmt="select count(*),term_reason from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand group by term_reason;";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$ASCII_text .= "$stmt\n";}
	$reasons_to_print = mysqli_num_rows($rslt);
	$i=0;
	while ($i < $reasons_to_print)
		{
		$row=mysqli_fetch_row($rslt);

		$TOTALcalls = ($TOTALcalls + $row[0]);

		$REASONcount =	sprintf("%10s", $row[0]);while(strlen($REASONcount)>10) {$REASONcount = substr("$REASONcount", 0, -1);}
		$reason =	sprintf("%-20s", $row[1]);while(strlen($reason)>20) {$reason = substr("$reason", 0, -1);}
		if (preg_match('/NONE/',$reason))	{$reason = 'NO ANSWER           ';}
		if (preg_match('/CALLER/',$reason)) {$reason = 'CUSTOMER            ';}

		$ASCII_text .= "| $reason | $REASONcount |\n";

		if ($row[0]>$max_calls) {$max_calls=$row[0];}
		$graph_stats[$i][0]=$row[0];
		$graph_stats[$i][1]=$row[1];
		$i++;
		}

	$TOTALcalls =		sprintf("%10s", $TOTALcalls);

	$ASCII_text .= "+----------------------+------------+\n";
	$ASCII_text .= "| TOTAL:               | $TOTALcalls |\n";
	$ASCII_text .= "+----------------------+------------+\n";

	for ($d=0; $d<count($graph_stats); $d++) {
		if ($d==0) {$class=" first";} else if (($d+1)==count($graph_stats)) {$class=" last";} else {$class="";}
		$GRAPH.="  <tr>\n";
		$GRAPH.="	<td class=\"chart_td$class\">".$graph_stats[$d][1]."</td>\n";
		$GRAPH.="	<td nowrap class=\"chart_td value$class\"><img src=\"images/bar.png\" alt=\"\" width=\"".round(MathZDC(400*$graph_stats[$d][0], $max_calls))."\" height=\"16\" />".$graph_stats[$d][0]."</td>\n";
		$GRAPH.="  </tr>\n";
	}
	$GRAPH.="  <tr>\n";
	$GRAPH.="	<th class=\"thgraph\" scope=\"col\">TOTAL:</th>\n";
	$GRAPH.="	<th class=\"thgraph\" scope=\"col\">".trim($TOTALcalls)."</th>\n";
	$GRAPH.="  </tr>\n";
	$GRAPH.="</table><PRE>\n";
	$GRAPH_text.=$GRAPH;




	##############################
	#########  CALL STATUS STATS

	$TOTALcalls = 0;

	$ASCII_text .= "\n";
	$ASCII_text .= "---------- CALL STATUS STATS\n";
	$ASCII_text .= "+--------+----------------------+----------------------+------------+----------------------------------+----------+\n";
	$ASCII_text .= "|        |                      |                      |            |      CALL TIME                   |AGENT TIME|\n";
	$ASCII_text .= "| STATUS | DESCRIPTION          | CATEGORY             | CALLS      | TOTAL TIME | AVG TIME |CALLS/HOUR|CALLS/HOUR|\n";
	$ASCII_text .= "+--------+----------------------+----------------------+------------+------------+----------+----------+----------+\n";

	######## GRAPHING #########
	$GRAPH="<BR><BR><a name='cssgraph'/><table border='0' cellpadding='0' cellspacing='2' width='800'>";
	$GRAPH.="<tr><th width='20%' class='grey_graph_cell' id='cssgraph1'><a href='#' onClick=\"DrawCSSGraph('CALLS', '1'); return false;\">CALLS</a></th><th width=20% class='grey_graph_cell' id='cssgraph2'><a href='#' onClick=\"DrawCSSGraph('TOTALTIME', '2'); return false;\">TOTAL TIME</a></th><th width=20% class='grey_graph_cell' id='cssgraph3'><a href='#' onClick=\"DrawCSSGraph('AVGTIME', '3'); return false;\">AVG TIME</a></th><th width=20% class='grey_graph_cell' id='cssgraph4'><a href='#' onClick=\"DrawCSSGraph('CALLSHOUR', '4'); return false;\">CALLS/HR</a></th><th width=20% class='grey_graph_cell' id='cssgraph5'><a href='#' onClick=\"DrawCSSGraph('CALLSHOUR_agent', '5'); return false;\">AGENT CALLS/HR</a></th></tr>";
	$GRAPH.="<tr><td colspan='5' class='graph_span_cell'><span id='call_status_stats_graph'><BR>&nbsp;<BR></span></td></tr></table><BR><BR>";
	$graph_stats=array();
	$max_calls=1;
	$max_total_time=1;
	$max_avg_time=1;
	$max_callshr=1;
	$max_agentcallshr=1;
	$graph_header="<table cellspacing='0' cellpadding='0' summary='STATUS' class='horizontalgraph'><caption align='top'>CALL STATUS STATS</caption><tr><th class='thgraph' scope='col'>STATUS</th>";
	$CALLS_graph=$graph_header."<th class='thgraph' scope='col'>CALLS </th></tr>";
	$TOTALTIME_graph=$graph_header."<th class='thgraph' scope='col'>TOTAL TIME</th></tr>";
	$AVGTIME_graph=$graph_header."<th class='thgraph' scope='col'>AVG TIME</th></tr>";
	$CALLSHOUR_graph=$graph_header."<th class='thgraph' scope='col'>CALLS/HR</th></tr>";
	$CALLSHOUR_agent_graph=$graph_header."<th class='thgraph' scope='col'>AGENT CALLS/HR</th></tr>";
	###########################


	$campaignSQL = "$group_SQLand";
	if (preg_match("/YES/i",$include_rollover))
		{$campaignSQL = "$both_group_SQLand";}
	## Pull the count of agent seconds for the total tally
	$stmt="SELECT sum(pause_sec + wait_sec + talk_sec + dispo_sec) from vicidial_agent_log$VL_INC where event_time >= '$query_date_BEGIN' and event_time <= '$query_date_END' $campaignSQL $list_id_SQLandVALJOIN and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000;";
	$rslt=mysql_to_mysqli($stmt, $link);
	$Ctally_to_print = mysqli_num_rows($rslt);
	if ($Ctally_to_print > 0) 
		{
		$rowx=mysqli_fetch_row($rslt);
		$AGENTsec = "$rowx[0]";
		}
	if ($DB) {$ASCII_text .= "$AGENTsec|$Ctally_to_print|$stmt\n";}


	## get counts and time totals for all statuses in this campaign
	$rollover_exclude_dropSQL='';
	if (preg_match("/YES/i",$include_rollover))
		{$rollover_exclude_dropSQL = "and status NOT IN('DROP')";}
	$stmt="select count(*),status,sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $rollover_exclude_dropSQL $group_SQLand $list_id_SQLand group by status;";

	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$ASCII_text .= "$stmt\n";}
	$statuses_to_print = mysqli_num_rows($rslt);
	$i=0;
	while ($i < $statuses_to_print)
		{
		$row=mysqli_fetch_row($rslt);
		$STATUScountARY[$i] =	$row[0];
		$RAWstatusARY[$i] =		$row[1];
		$RAWhoursARY[$i] =		$row[2];
		$statusSQL .=			"'$row[1]',";
		$i++;
		}
	if (preg_match("/YES/i",$include_rollover))
		{
		if (strlen($statusSQL) < 2)
			{$statusSQL = "''";}
		else
			{
			$statusSQL = preg_replace('/,$/i', '',$statusSQL);
			}
		$stmt="select distinct status from vicidial_closer_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and status NOT IN($statusSQL) $group_drop_SQLand $list_id_SQLand;";
		$rslt=mysql_to_mysqli($stmt, $link);
		$inS_statuses_to_print = mysqli_num_rows($rslt);
		$n=0;
		while ($inS_statuses_to_print > $n) 
			{
			$rowx=mysqli_fetch_row($rslt);
			$STATUScountARY[$i] =	0;
			$RAWstatusARY[$i] =		$rowx[0];
			$RAWhoursARY[$i] =		0;
			$i++;
			$n++;
			$statuses_to_print++;
			}
		}


	$i=0;
	while ($i < $statuses_to_print)
		{
		$STATUScount = $STATUScountARY[$i];
		$RAWstatus = $RAWstatusARY[$i];
		$RAWhours = $RAWhoursARY[$i];

		if (preg_match("/YES/i",$include_rollover))
			{
			$stmt="select count(*),sum(length_in_sec) from vicidial_closer_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and status='$RAWstatus' $group_drop_SQLand $list_id_SQLand;";
			$rslt=mysql_to_mysqli($stmt, $link);
			$in_statuses_to_print = mysqli_num_rows($rslt);
			if ($in_statuses_to_print > 0) 
				{
				$rowx=mysqli_fetch_row($rslt);
				$inSTATUScount =	$rowx[0];
				$inRAWhours =		$rowx[1];

				$STATUScount = ($STATUScount + $inSTATUScount);
				$RAWhours = ($RAWhours + $inRAWhours);
				}
			}

		$r=0;
		while ($r < $statcats_to_print)
			{
			if ($statcat_list[$RAWstatus] == "$vsc_id[$r]")
				{
				$vsc_count[$r] = ($vsc_count[$r] + $STATUScount);
				}
			$r++;
			}
		if ($AGENTsec < 1) {$AGENTsec=1;}
		$TOTALcalls =	($TOTALcalls + $STATUScount);
		$TOTALtimeS =	($TOTALtimeS + $RAWhours);
		$STATUSrate =	MathZDC($STATUScount, MathZDC($TOTALsec, 3600) );
			$STATUSrate =	sprintf("%.2f", $STATUSrate);
		$AGENTrate =	MathZDC($STATUScount, MathZDC($AGENTsec, 3600) );
			$AGENTrate =	sprintf("%.2f", $AGENTrate);

		if ($STATUScount>$max_calls) {$max_calls=$STATUScount;}
		if ($RAWhours>$max_total_time) {$max_total_time=$RAWhours;}
		if ($STATUSavg_sec>$max_avg_time) {$max_avg_time=$STATUSavg_sec;}
		if ($STATUSrate>$max_callshr) {$max_callshr=$STATUSrate;}
		if ($AGENTrate>$max_agentcallshr) {$max_agentcallshr=$AGENTrate;}
		$graph_stats[$i][1]=$STATUScount;
		$graph_stats[$i][2]=$RAWhours;
		$graph_stats[$i][3]=MathZDC($RAWhours, $STATUScount);
		$graph_stats[$i][4]=$STATUSrate;
		$graph_stats[$i][5]=$AGENTrate;

		$STATUShours =		sec_convert($RAWhours,'H'); 
		$STATUSavg_sec =	MathZDC($RAWhours, $STATUScount); 
		$STATUSavg =		sec_convert($STATUSavg_sec,'H'); 

		$STATUScount =	sprintf("%10s", $STATUScount);while(strlen($STATUScount)>10) {$STATUScount = substr("$STATUScount", 0, -1);}
		$status =	sprintf("%-6s", $RAWstatus);while(strlen($status)>6) {$status = substr("$status", 0, -1);}
		$STATUShours =	sprintf("%10s", $STATUShours);while(strlen($STATUShours)>10) {$STATUShours = substr("$STATUShours", 0, -1);}
		$STATUSavg =	sprintf("%8s", $STATUSavg);while(strlen($STATUSavg)>8) {$STATUSavg = substr("$STATUSavg", 0, -1);}
		$STATUSrate =	sprintf("%8s", $STATUSrate);while(strlen($STATUSrate)>8) {$STATUSrate = substr("$STATUSrate", 0, -1);}
		$AGENTrate =	sprintf("%8s", $AGENTrate);while(strlen($AGENTrate)>8) {$AGENTrate = substr("$AGENTrate", 0, -1);}

		if ($non_latin < 1)
			{
			$status_name =	sprintf("%-20s", $statname_list[$RAWstatus]); 
			while(strlen($status_name)>20) {$status_name = substr("$status_name", 0, -1);}	
			$statcat =	sprintf("%-20s", $statcat_list[$RAWstatus]); 
			while(strlen($statcat)>20) {$statcat = substr("$statcat", 0, -1);}	
			}
		else
			{
			$status_name =	sprintf("%-60s", $statname_list[$RAWstatus]); 
			while(mb_strlen($status_name,'utf-8')>20) {$status_name = mb_substr("$status_name", 0, -1,'utf-8');}	
			$statcat =	sprintf("%-60s", $statcat_list[$RAWstatus]); 
			while(mb_strlen($statcat,'utf-8')>20) {$statcat = mb_substr("$statcat", 0, -1,'utf-8');}	
			}
		$graph_stats[$i][0]="$status - $status_name - $statcat";

		$ASCII_text .= "| $status | $status_name | $statcat | $STATUScount | $STATUShours | $STATUSavg | $STATUSrate | $AGENTrate |\n";

		$i++;
		}

	$TOTALrate =	MathZDC($TOTALcalls, MathZDC($TOTALsec, 3600) );
	$TOTALrate =	sprintf("%.2f", $TOTALrate);
	$aTOTALrate =	MathZDC($TOTALcalls, MathZDC($AGENTsec, 3600) );
	$aTOTALrate =	sprintf("%.2f", $aTOTALrate);

	$aTOTALhours =		sec_convert($AGENTsec,'H'); 
	$TOTALhours =		sec_convert($TOTALtimeS,'H'); 
	$TOTALavg_sec =		MathZDC($TOTALtimeS, $TOTALcalls);
	$TOTALavg =			sec_convert($TOTALavg_sec,'H'); 

	$TOTALcalls =	sprintf("%10s", $TOTALcalls);
	$TOTALhours =	sprintf("%10s", $TOTALhours);while(strlen($TOTALhours)>10) {$TOTALhours = substr("$TOTALhours", 0, -1);}
	$aTOTALhours =	sprintf("%10s", $aTOTALhours);while(strlen($aTOTALhours)>10) {$aTOTALhours = substr("$aTOTALhours", 0, -1);}
	$TOTALavg =	sprintf("%8s", $TOTALavg);while(strlen($TOTALavg)>8) {$TOTALavg = substr("$TOTALavg", 0, -1);}
	$TOTALrate =	sprintf("%8s", $TOTALrate);while(strlen($TOTALrate)>8) {$TOTALrate = substr("$TOTALrate", 0, -1);}
	$aTOTALrate =	sprintf("%8s", $aTOTALrate);while(strlen($aTOTALrate)>8) {$aTOTALrate = substr("$aTOTALrate", 0, -1);}

	$ASCII_text .= "+--------+----------------------+----------------------+------------+------------+----------+----------+----------+\n";
	$ASCII_text .= "| TOTAL:                                               | $TOTALcalls | $TOTALhours | $TOTALavg | $TOTALrate |          |\n";
#	$ASCII_text .= "|   AGENT TIME                                                      | $aTOTALhours |                     | $aTOTALrate |\n";
	$ASCII_text .= "+------------------------------------------------------+------------+------------+---------------------+----------+\n";

	for ($d=0; $d<count($graph_stats); $d++) {
		if ($d==0) {$class=" first";} else if (($d+1)==count($graph_stats)) {$class=" last";} else {$class="";}
		$CALLS_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(MathZDC(400*$graph_stats[$d][1], $max_calls))."' height='16' />".$graph_stats[$d][1]."</td></tr>";
		$TOTALTIME_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(MathZDC(400*$graph_stats[$d][2], $max_total_time))."' height='16' />".sec_convert($graph_stats[$d][2], 'H')."</td></tr>";
		$AVGTIME_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(MathZDC(400*$graph_stats[$d][3], $max_avg_time))."' height='16' />".sec_convert($graph_stats[$d][3], 'H')."</td></tr>";
		$CALLSHOUR_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(MathZDC(400*$graph_stats[$d][4], $max_callshr))."' height='16' />".$graph_stats[$d][4]."</td></tr>";
		$CALLSHOUR_agent_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(MathZDC(400*$graph_stats[$d][5], $max_agentcallshr))."' height='16' />".$graph_stats[$d][5]."</td></tr>";
	}
	$CALLS_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($TOTALcalls)."</th></tr></table>";
	$TOTALTIME_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($TOTALhours)."</th></tr></table>";
	$AVGTIME_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($TOTALavg)."</th></tr></table>";
	$CALLSHOUR_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($TOTALrate)."</th></tr></table>";
	$CALLSHOUR_agent_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($aTOTALrate)."</th></tr></table>";
	$JS_onload.="\tDrawCSSGraph('CALLS', '1');\n";
	$JS_text.="function DrawCSSGraph(graph, th_id) {\n";
	$JS_text.="	var CALLS_graph=\"$CALLS_graph\";\n";
	$JS_text.="	var TOTALTIME_graph=\"$TOTALTIME_graph\";\n";
	$JS_text.="	var AVGTIME_graph=\"$AVGTIME_graph\";\n";
	$JS_text.="	var CALLSHOUR_graph=\"$CALLSHOUR_graph\";\n";
	$JS_text.="	var CALLSHOUR_agent_graph=\"$CALLSHOUR_agent_graph\";\n";
	$JS_text.="\n";
	$JS_text.="	for (var i=1; i<=5; i++) {\n";
	$JS_text.="		var cellID=\"cssgraph\"+i;\n";
	$JS_text.="		document.getElementById(cellID).style.backgroundColor='#DDDDDD';\n";
	$JS_text.="	}\n";
	$JS_text.="	var cellID=\"cssgraph\"+th_id;\n";
	$JS_text.="	document.getElementById(cellID).style.backgroundColor='#999999';\n";
	$JS_text.="	var graph_to_display=eval(graph+\"_graph\");\n";
	$JS_text.="	document.getElementById('call_status_stats_graph').innerHTML=graph_to_display;\n";
	$JS_text.="}\n";

	$GRAPH_text.=$GRAPH;



	##############################
	#########  LIST ID BREAKDOWN STATS

	$TOTALcalls = 0;

	$ASCII_text .= "\n";
	$ASCII_text .= "---------- LIST ID STATS\n";
	$ASCII_text .= "+------------------------------------------+------------+\n";
	$ASCII_text .= "| LIST                                     | CALLS      |\n";
	$ASCII_text .= "+------------------------------------------+------------+\n";

	$GRAPH="</PRE><table cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"white\" summary=\"DID Summary\" class=\"horizontalgraph\">\n";
	$GRAPH.="<caption align='top'>LIST ID STATS</caption>";
	$GRAPH.="<tr>\n";
	$GRAPH.="<th class=\"thgraph\" scope=\"col\">LIST</th>\n";
	$GRAPH.="<th class=\"thgraph\" scope=\"col\">CALLS</th>\n";
	$GRAPH.="</tr>\n";

	$stmt="select count(*),list_id from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand group by list_id;";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$ASCII_text .= "$stmt\n";}
	$listids_to_print = mysqli_num_rows($rslt);
	$i=0;
	$max_calls=1; $graph_stats=array();
	while ($i < $listids_to_print)
		{
		$row=mysqli_fetch_row($rslt);
		$LISTIDcalls[$i] =	$row[0];
		$LISTIDlists[$i] =	$row[1];
		if ($row[0]>$max_calls) {$max_calls=$row[0];}
		$graph_stats[$i][0]=$row[0];
		$graph_stats[$i][1]=$row[1];
		$i++;
		}

	$i=0;
	while ($i < $listids_to_print)
		{
		$stmt="select list_name from vicidial_lists where list_id='$LISTIDlists[$i]';";
		$rslt=mysql_to_mysqli($stmt, $link);
		if ($DB) {$ASCII_text .= "$stmt\n";}
		$list_name_to_print = mysqli_num_rows($rslt);
		if ($list_name_to_print > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$LISTIDlist_names[$i] =	$row[0];
			}

		$TOTALcalls = ($TOTALcalls + $LISTIDcalls[$i]);

		$LISTIDcount =	sprintf("%10s", $LISTIDcalls[$i]);while(strlen($LISTIDcount)>10) {$LISTIDcount = substr("$LISTIDcount", 0, -1);}
		$LISTIDname =	sprintf("%-40s", "$LISTIDlists[$i] - $LISTIDlist_names[$i]");while(strlen($LISTIDname)>40) {$LISTIDname = substr("$LISTIDname", 0, -1);}

		$ASCII_text .= "| $LISTIDname | $LISTIDcount |\n";

		$i++;
		}

	$TOTALcalls =		sprintf("%10s", $TOTALcalls);

	$ASCII_text .= "+------------------------------------------+------------+\n";
	$ASCII_text .= "| TOTAL:                                   | $TOTALcalls |\n";
	$ASCII_text .= "+------------------------------------------+------------+\n";

	for ($d=0; $d<count($graph_stats); $d++) {
		if ($d==0) {$class=" first";} else if (($d+1)==count($graph_stats)) {$class=" last";} else {$class="";}
		$GRAPH.="  <tr>\n";
		$GRAPH.="	<td class=\"chart_td$class\">".$graph_stats[$d][1]."</td>\n";
		$GRAPH.="	<td nowrap class=\"chart_td value$class\"><img src=\"images/bar.png\" alt=\"\" width=\"".round(MathZDC(400*$graph_stats[$d][0], $max_calls))."\" height=\"16\" />".$graph_stats[$d][0]."</td>\n";
		$GRAPH.="  </tr>\n";
	}
	$GRAPH.="  <tr>\n";
	$GRAPH.="	<th class=\"thgraph\" scope=\"col\">TOTAL:</th>\n";
	$GRAPH.="	<th class=\"thgraph\" scope=\"col\">".trim($TOTALcalls)."</th>\n";
	$GRAPH.="  </tr>\n";
	$GRAPH.="</table><PRE>\n";

	$GRAPH_text.=$GRAPH;


	if ( ($carrier_logging_active > 0) and ($carrier_stats == 'YES') )
		{
		##############################
		#########  CARRIER STATS

		$ASCII_text .= "\n";
		$ASCII_text .= "---------- CARRIER CALL STATUSES\n";
		$ASCII_text .= "+----------------------+------------+\n";
		$ASCII_text .= "| STATUS               | CALLS      |\n";
		$ASCII_text .= "+----------------------+------------+\n";

		## get counts and time totals for all statuses in this campaign
		$stmt="select dialstatus,count(*) from vicidial_carrier_log vcl,vicidial_log vl where vcl.uniqueid=vl.uniqueid and vcl.call_date > \"$query_date_BEGIN\" and vcl.call_date < \"$query_date_END\" and vl.call_date > \"$query_date_BEGIN\" and vl.call_date < \"$query_date_END\" $group_SQLand $list_id_SQLand group by dialstatus order by dialstatus;";
		if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		$rslt=mysql_to_mysqli($stmt, $link);
		if ($DB) {$ASCII_text .= "$stmt\n";}
		$carrierstatuses_to_print = mysqli_num_rows($rslt);
		$i=0;
		while ($i < $carrierstatuses_to_print)
			{
			$row=mysqli_fetch_row($rslt);
			$TOTCARcalls = ($TOTCARcalls + $row[1]);
			$CARstatus =	sprintf("%-20s", $row[0]); while(strlen($CARstatus)>20) {$CARstatus = substr("$CARstatus", 0, -1);}
			$CARcount =		sprintf("%10s", $row[1]); while(strlen($CARcount)>10) {$CARcount = substr("$CARcount", 0, -1);}

			$ASCII_text .= "| $CARstatus | $CARcount |\n";

			$i++;
			}

		$TOTCARcalls =	sprintf("%10s", $TOTCARcalls); while(strlen($TOTCARcalls)>10) {$TOTCARcalls = substr("$TOTCARcalls", 0, -1);}

		$ASCII_text .= "+----------------------+------------+\n";
		$ASCII_text .= "| TOTAL                | $TOTCARcalls |\n";
		$ASCII_text .= "+----------------------+------------+\n";
		}


	## find if any selected campaigns have presets enabled
	$presets_enabled=0;
	$stmt="select count(*) from vicidial_campaigns where enable_xfer_presets='ENABLED' $group_SQLand;";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$ASCII_text .= "$stmt\n";}
	$presets_enabled_count = mysqli_num_rows($rslt);
	if ($presets_enabled_count > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$presets_enabled = $row[0];
		}

	if ($presets_enabled > 0)
		{
		##############################
		#########  PRESET DIAL STATS

		$ASCII_text .= "\n";
		$ASCII_text .= "---------- AGENT PRESET DIALS\n";
		$ASCII_text .= "+------------------------------------------+------------+\n";
		$ASCII_text .= "| PRESET NAME                              | CALLS      |\n";
		$ASCII_text .= "+------------------------------------------+------------+\n";

		$GRAPH="</PRE><table cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"white\" summary=\"DID Summary\" class=\"horizontalgraph\">\n";
		$GRAPH.="<caption align='top'>AGENT PRESET DIALS</caption>";
		$GRAPH.="<tr>\n";
		$GRAPH.="<th class=\"thgraph\" scope=\"col\">PRESET NAME</th>\n";
		$GRAPH.="<th class=\"thgraph\" scope=\"col\">CALLS</th>\n";
		$GRAPH.="</tr>\n";
		$max_calls=1; $graph_stats=array();

		## get counts and time totals for all statuses in this campaign
		$stmt="select preset_name,count(*) from user_call_log$VL_INC where call_date > \"$query_date_BEGIN\" and call_date < \"$query_date_END\" and preset_name!='' and preset_name is not NULL  $group_SQLand  $list_id_SQLandUCLJOIN group by preset_name order by preset_name;";
		$rslt=mysql_to_mysqli($stmt, $link);
		if ($DB) {$ASCII_text .= "$stmt\n";}
		$carrierstatuses_to_print = mysqli_num_rows($rslt);
		$i=0;
		while ($i < $carrierstatuses_to_print)
			{
			$row=mysqli_fetch_row($rslt);
			$TOTPREcalls = ($TOTPREcalls + $row[1]);
			$PREstatus =	sprintf("%-40s", $row[0]); while(strlen($PREstatus)>40) {$PREstatus = substr("$PREstatus", 0, -1);}
			$PREcount =		sprintf("%10s", $row[1]); while(strlen($PREcount)>10) {$PREcount = substr("$PREcount", 0, -1);}

			if ($row[1]>$max_calls) {$max_calls=$row[1];}
			$graph_stats[$i][0]=$row[1];
			$graph_stats[$i][1]=$row[0];

			$ASCII_text .= "| $PREstatus | $PREcount |\n";

			$i++;
			}

		for ($d=0; $d<count($graph_stats); $d++) {
			if ($d==0) {$class=" first";} else if (($d+1)==count($graph_stats)) {$class=" last";} else {$class="";}
			$GRAPH.="  <tr>\n";
			$GRAPH.="	<td class=\"chart_td$class\">".$graph_stats[$d][1]."</td>\n";
			$GRAPH.="	<td nowrap class=\"chart_td value$class\"><img src=\"images/bar.png\" alt=\"\" width=\"".round(MathZDC(400*$graph_stats[$d][0], $max_calls))."\" height=\"16\" />".$graph_stats[$d][0]."</td>\n";
			$GRAPH.="  </tr>\n";
		}
		$GRAPH.="  <tr>\n";
		$GRAPH.="	<th class=\"thgraph\" scope=\"col\">TOTAL CALLS:</th>\n";
		$GRAPH.="	<th class=\"thgraph\" scope=\"col\">".trim($TOTPREcalls)."</th>\n";
		$GRAPH.="  </tr>\n";
		$GRAPH.="</table><PRE>\n";

		$TOTPREcalls =	sprintf("%10s", $TOTPREcalls); while(strlen($TOTPREcalls)>10) {$TOTPREcalls = substr("$TOTPREcalls", 0, -1);}

		$ASCII_text .= "+------------------------------------------+------------+\n";
		$ASCII_text .= "| TOTAL                                    | $TOTPREcalls |\n";
		$ASCII_text .= "+------------------------------------------+------------+\n";

		$GRAPH_text.=$GRAPH;
		}


	##############################
	#########  STATUS CATEGORY STATS

	$ASCII_text .= "\n";
	$ASCII_text .= "---------- CUSTOM STATUS CATEGORY STATS\n";
	$ASCII_text .= "+----------------------+------------+--------------------------------+\n";
	$ASCII_text .= "| CATEGORY             | CALLS      | DESCRIPTION                    |\n";
	$ASCII_text .= "+----------------------+------------+--------------------------------+\n";

	$GRAPH="</PRE><table cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"white\" summary=\"DID Summary\" class=\"horizontalgraph\">\n";
	$GRAPH.="<caption align='top'>CUSTOM STATUS CATEGORY STATS</caption>";
	$GRAPH.="<tr>\n";
	$GRAPH.="<th class=\"thgraph\" scope=\"col\">CATEGORY</th>\n";
	$GRAPH.="<th class=\"thgraph\" scope=\"col\">CALLS</th>\n";
	$GRAPH.="</tr>\n";
	$max_calls=1; $graph_stats=array();

	$TOTCATcalls=0;
	$r=0; $i=0;
	while ($r < $statcats_to_print)
		{
		if ($vsc_id[$r] != 'UNDEFINED')
			{
			$TOTCATcalls = ($TOTCATcalls + $vsc_count[$r]);
			$category =	sprintf("%-20s", $vsc_id[$r]); while(strlen($category)>20) {$category = substr("$category", 0, -1);}
			$CATcount =	sprintf("%10s", $vsc_count[$r]); while(strlen($CATcount)>10) {$CATcount = substr("$CATcount", 0, -1);}
			$CATname =	sprintf("%-30s", $vsc_name[$r]); while(strlen($CATname)>30) {$CATname = substr("$CATname", 0, -1);}

			if ($vsc_count[$r]>$max_calls) {$max_calls=$vsc_count[$r];}
			$graph_stats[$i][0]=$vsc_count[$r];
			$graph_stats[$i][1]=$vsc_id[$r];
			$i++;

			$ASCII_text .= "| $category | $CATcount | $CATname |\n";
			}
		$r++;
		}

	$TOTCATcalls =	sprintf("%10s", $TOTCATcalls); while(strlen($TOTCATcalls)>10) {$TOTCATcalls = substr("$TOTCATcalls", 0, -1);}

	$ASCII_text .= "+----------------------+------------+--------------------------------+\n";
	$ASCII_text .= "| TOTAL                | $TOTCATcalls |\n";
	$ASCII_text .= "+----------------------+------------+\n";

	for ($d=0; $d<count($graph_stats); $d++) {
		if ($d==0) {$class=" first";} else if (($d+1)==count($graph_stats)) {$class=" last";} else {$class="";}
		$GRAPH.="  <tr>\n";
		$GRAPH.="	<td class=\"chart_td$class\">".$graph_stats[$d][1]."</td>\n";
		$GRAPH.="	<td nowrap class=\"chart_td value$class\"><img src=\"images/bar.png\" alt=\"\" width=\"".round(MathZDC(400*$graph_stats[$d][0], $max_calls))."\" height=\"16\" />".$graph_stats[$d][0]."</td>\n";
		$GRAPH.="  </tr>\n";
	}
	$GRAPH.="  <tr>\n";
	$GRAPH.="	<th class=\"thgraph\" scope=\"col\">TOTAL:</th>\n";
	$GRAPH.="	<th class=\"thgraph\" scope=\"col\">".trim($TOTCATcalls)."</th>\n";
	$GRAPH.="  </tr>\n";
	$GRAPH.="</table><PRE>\n";
	$GRAPH_text.=$GRAPH;


	##############################
	#########  USER STATS

	$TOTagents=0;
	$TOTcalls=0;
	$TOTtime=0;
	$TOTavg=0;

	$ASCII_text .= "\n";
	$ASCII_text .= "---------- AGENT STATS\n";
	$ASCII_text .= "+--------------------------+------------+------------+--------+\n";
	$ASCII_text .= "| AGENT                    | CALLS      | TIME H:M:S |AVERAGE |\n";
	$ASCII_text .= "+--------------------------+------------+------------+--------+\n";

	######## GRAPHING #########
	$graph_stats=array();
	$max_calls=1;
	$max_total_time=1;
	$max_avg_time=1;
	$GRAPH="<BR><BR><a name='AGENTgraph'/><table border='0' cellpadding='0' cellspacing='2' width='800'>";
	$GRAPH.="<tr><th width='33%' class='grey_graph_cell' id='AGENTgraph1'><a href='#' onClick=\"DrawAGENTGraph('CALLS', '1'); return false;\">CALLS</a></th><th width='33%' class='grey_graph_cell' id='AGENTgraph2'><a href='#' onClick=\"DrawAGENTGraph('TOTALTIME', '2'); return false;\">TOTAL TIME</a></th><th width='34%' class='grey_graph_cell' id='AGENTgraph3'><a href='#' onClick=\"DrawAGENTGraph('AVGTIME', '3'); return false;\">AVG TIME</a></th></tr>";
	$GRAPH.="<tr><td colspan='4' class='graph_span_cell'><span id='agent_stats_graph'><BR>&nbsp;<BR></span></td></tr></table><BR><BR>";
	$graph_header="<table cellspacing='0' cellpadding='0' class='horizontalgraph'><caption align='top'>AGENT STATS</caption><tr><th class='thgraph' scope='col'>STATUS</th>";
	$CALLS_graph=$graph_header."<th class='thgraph' scope='col'>CALLS </th></tr>";
	$TOTALTIME_graph=$graph_header."<th class='thgraph' scope='col'>TOTAL TIME</th></tr>";
	$AVGTIME_graph=$graph_header."<th class='thgraph' scope='col'>AVG TIME</th></tr>";
	###########################

	$stmt="select vicidial_log.user,full_name,count(*),sum(length_in_sec),avg(length_in_sec) from vicidial_log,vicidial_users where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and vicidial_log.user is not null and length_in_sec is not null and length_in_sec > 0 and vicidial_log.user=vicidial_users.user group by vicidial_log.user;";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$ASCII_text .= "$stmt\n";}
	$users_to_print = mysqli_num_rows($rslt);
	$i=0;
	while ($i < $users_to_print)
		{
		$row=mysqli_fetch_row($rslt);

		$RAWuser[$i] =			$row[0];
		$RAWfull_name[$i] =		$row[1];
		$RAWuser_calls[$i] =	$row[2];
		$RAWuser_talk[$i] =		$row[3];
		$RAWuser_average[$i] =	$row[4];

		$TOTcalls = ($TOTcalls + $row[2]);
		$TOTtime = ($TOTtime + $row[3]);

		$i++;
		}

	$i=0;
	while ($i < $users_to_print)
		{
		$user =	sprintf("%-6s", $RAWuser[$i]);while(strlen($user)>6) {$user = substr("$user", 0, -1);}
		if ($non_latin < 1)
			{
			$full_name =	sprintf("%-15s", $RAWfull_name[$i]); while(strlen($full_name)>15) {$full_name = substr("$full_name", 0, -1);}	
			}
		else
			{
			$full_name =	sprintf("%-45s", $RAWfull_name[$i]); while(mb_strlen($full_name,'utf-8')>15) {$full_name = mb_substr("$full_name", 0, -1,'utf-8');}	
			}
		if (preg_match("/YES/i",$include_rollover))
			{
			$length_in_secZ=0;
			$queue_secondsZ=0;
			$agent_alert_delayZ=0;
			$stmt="select length_in_sec,queue_seconds,agent_alert_delay from vicidial_closer_log,vicidial_inbound_groups where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and group_id=campaign_id and user='$RAWuser[$i]' $group_drop_SQLand $list_id_SQLand;";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$INallcalls_to_printZ = mysqli_num_rows($rslt);
			$y=0;
			while ($y < $INallcalls_to_printZ)
				{
				$row=mysqli_fetch_row($rslt);

				$length_in_secZ = $row[0];
				$queue_secondsZ = $row[1];
				$agent_alert_delayZ = $row[2];

				$CIdelay =		round(MathZDC($agent_alert_delayZ, 1000));
				$thiscallsec = (($length_in_secZ - $queue_secondsZ) - $CIdelay);
				if ($thiscallsec < 0)
					{$thiscallsec = 0;}
				$inCIsec =	($inCIsec + $thiscallsec);	

				$y++;
				}

			$inCIcallsRAW =	$y;
			$RAWuser_talk[$i] = ($RAWuser_talk[$i] + $inCIsec);
			$RAWuser_calls[$i] = ($RAWuser_calls[$i] + $inCIcallsRAW);

			$TOTcalls = ($TOTcalls + $inCIcallsRAW);
			$TOTtime = ($TOTtime + $inCIsec);
			}

		$USERcalls =	sprintf("%10s", $RAWuser_calls[$i]);
		$USERtotTALK =	$RAWuser_talk[$i];
		$USERavgTALK =	round(MathZDC($RAWuser_talk[$i], $RAWuser_calls[$i]));

#######
		if ($RAWuser_calls[$i]>$max_calls) {$max_calls=$RAWuser_calls[$i];}
		if ($RAWuser_talk[$i]>$max_total_time) {$max_total_time=$RAWuser_talk[$i];}
		if ($USERavgTALK>$max_avg_time) {$max_avg_time=$USERavgTALK;}
		$graph_stats[$i][0]="$user - $full_name";
		$graph_stats[$i][1]=$RAWuser_calls[$i];
		$graph_stats[$i][2]=$RAWuser_talk[$i];
		$graph_stats[$i][3]=$USERavgTALK;
#######


		$USERtotTALK_MS =	sec_convert($USERtotTALK,'H'); 
		$USERavgTALK_MS =	sec_convert($USERavgTALK,'H'); 

		$USERtotTALK_MS =	sprintf("%9s", $USERtotTALK_MS);
		$USERavgTALK_MS =	sprintf("%6s", $USERavgTALK_MS);

		$ASCII_text .= "| $user - $full_name | $USERcalls |  $USERtotTALK_MS | $USERavgTALK_MS |\n";

		$i++;
		}

	$rawTOTtime = $TOTtime;

	if (!$TOTcalls) {$TOTcalls = 1;}
	$TOTavg = MathZDC($TOTtime, $TOTcalls);

	$TOTavg_MS =	sec_convert($TOTavg,'H'); 
	$TOTtime_MS =	sec_convert($TOTtime,'H'); 

	$TOTavg =		sprintf("%6s", $TOTavg_MS);
	$TOTtime =		sprintf("%10s", $TOTtime_MS);

	$TOTagents =		sprintf("%10s", $i);
	$TOTcalls =			sprintf("%10s", $TOTcalls);
	$TOTtime =			sprintf("%8s", $TOTtime);
	$TOTavg =			sprintf("%6s", $TOTavg);

	$stmt="select avg(wait_sec) from vicidial_agent_log$VL_INC where event_time >= '$query_date_BEGIN' and event_time <= '$query_date_END' and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 $group_SQLand  $list_id_SQLandVALJOIN;";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {$ASCII_text .= "$stmt\n";}
	$row=mysqli_fetch_row($rslt);

	$AVGwait = $row[0];
	$AVGwait_MS =	sec_convert($AVGwait,'H'); 
	$AVGwait =		sprintf("%6s", $AVGwait_MS);

	$ASCII_text .= "+--------------------------+------------+------------+--------+\n";
	$ASCII_text .= "| TOTAL Agents: $TOTagents | $TOTcalls | $TOTtime | $TOTavg |\n";
	$ASCII_text .= "+--------------------------+------------+------------+--------+\n";
	$ASCII_text .= "| Average Wait time between calls                      $AVGwait |\n";
	$ASCII_text .= "+-------------------------------------------------------------+\n";

	for ($d=0; $d<count($graph_stats); $d++) {
		if ($d==0) {$class=" first";} else if (($d+1)==count($graph_stats)) {$class=" last";} else {$class="";}
		$CALLS_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(MathZDC(400*$graph_stats[$d][1], $max_calls))."' height='16' />".$graph_stats[$d][1]."</td></tr>";
		$TOTALTIME_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(MathZDC(400*$graph_stats[$d][2], $max_total_time))."' height='16' />".sec_convert($graph_stats[$d][2], 'H')."</td></tr>";
		$AVGTIME_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(MathZDC(400*$graph_stats[$d][3], $max_avg_time))."' height='16' />".sec_convert($graph_stats[$d][3], 'H')."</td></tr>";
	}
	$CALLS_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($TOTcalls)."</th></tr></table>";
	$TOTALTIME_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($TOTtime)."</th></tr></table>";
	$AVGTIME_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($TOTavg)."</th></tr></table>";
	$JS_onload.="\tDrawAGENTGraph('CALLS', '1');\n"; 
	$JS_text.="function DrawAGENTGraph(graph, th_id) {\n";
	$JS_text.="	var CALLS_graph=\"$CALLS_graph\";\n";
	$JS_text.="	var TOTALTIME_graph=\"$TOTALTIME_graph\";\n";
	$JS_text.="	var AVGTIME_graph=\"$AVGTIME_graph\";\n";
	$JS_text.="\n";
	$JS_text.="	for (var i=1; i<=3; i++) {\n";
	$JS_text.="		var cellID=\"AGENTgraph\"+i;\n";
	$JS_text.="		document.getElementById(cellID).style.backgroundColor='#DDDDDD';\n";
	$JS_text.="	}\n";
	$JS_text.="	var cellID=\"AGENTgraph\"+th_id;\n";
	$JS_text.="	document.getElementById(cellID).style.backgroundColor='#999999';\n";
	$JS_text.="	var graph_to_display=eval(graph+\"_graph\");\n";
	$JS_text.="	document.getElementById('agent_stats_graph').innerHTML=graph_to_display;\n";
	$JS_text.="}\n";
	$GRAPH_text.=$GRAPH;


	if ($costformat > 0)
		{
		$stmt="select campaign_id,phone_number,length_in_sec from vicidial_log,vicidial_users where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand  $list_id_SQLand and vicidial_log.user=vicidial_users.user;";
		$rslt=mysql_to_mysqli($stmt, $link);
		if ($DB) {echo "$stmt\n";}
		$allcalls_to_print = mysqli_num_rows($rslt);
		$w=0;
		while ($w < $allcalls_to_print)
			{
			$row=mysqli_fetch_row($rslt);

			if ($print_calls > 0)
				{echo "$row[0]\t$row[1]\t$row[2]\n";}
			$tempTALK = ($tempTALK + $row[2]);
			$w++;
			}
		if (preg_match("/YES/i",$include_rollover))
			{
			$stmt="select campaign_id,phone_number,length_in_sec,queue_seconds,agent_alert_delay from vicidial_closer_log,vicidial_inbound_groups where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and group_id=campaign_id $group_drop_SQLand $list_id_SQLand;";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$INallcalls_to_print = mysqli_num_rows($rslt);
			$w=0;
			while ($w < $INallcalls_to_print)
				{
				$row=mysqli_fetch_row($rslt);

				if ($print_calls > 0)
				{	echo "$row[0]\t$row[1]\t$row[2]\t$row[3]\t$row[4]\n";}
				$newTALK = ($row[2] - $row[3] - MathZDC($row[4], 1000) );
				if ($newTALK < 0) {$newTALK = 0;}
				$tempTALK = ($tempTALK + $newTALK);
				$w++;
				}
			}
		$tempTALKmin = MathZDC($tempTALK, 60);
		if ($print_calls > 0)
			{echo "$w\t$tempTALK\t$tempTALKmin\n";}

		echo "</PRE>\n<B>";
		$rawTOTtalk_min = round(MathZDC($tempTALK, 60));
		$outbound_cost =	($rawTOTtalk_min * $outbound_rate);
		$outbound_cost =	sprintf("%8.2f", $outbound_cost);

		echo "OUTBOUND $query_date to $end_date, &nbsp; $rawTOTtalk_min minutes at \$$outbound_rate = \$$outbound_cost</B>\n";

		if ($db_source == 'S')
			{
			mysqli_close($link);
			$use_slave_server=0;
			$db_source = 'M';
			require("dbconnect_mysqli.php");
			}

		$endMS = microtime();
		$startMSary = explode(" ",$startMS);
		$endMSary = explode(" ",$endMS);
		$runS = ($endMSary[0] - $startMSary[0]);
		$runM = ($endMSary[1] - $startMSary[1]);
		$TOTALrun = ($runS + $runM);

		$stmt="UPDATE vicidial_report_log set run_time='$TOTALrun' where report_log_id='$report_log_id';";
		if ($DB) {echo "|$stmt|\n";}
		$rslt=mysql_to_mysqli($stmt, $link);

		exit;
		}

	if ($report_display_type=="HTML")
		{
		$OUToutput.=$GRAPH_text;
		}
	else
		{
		$OUToutput.=$ASCII_text;
		}

	echo "$OUToutput";




	if ($bottom_graph == 'YES')
		{
		##############################
		#########  TIME STATS

		echo "\n";
		echo "---------- TIME STATS\n";

		echo "<FONT SIZE=0>\n";

		$hi_hour_count=0;
		$last_full_record=0;
		$i=0;
		$h=0;
		while ($i <= 96)
			{
			$stmt="select count(*) from vicidial_log where call_date >= '$query_date $h:00:00' and call_date <= '$query_date $h:14:59' $group_SQLand $list_id_SQLand;";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			$hour_count[$i] = $row[0];
			if ($hour_count[$i] > $hi_hour_count) {$hi_hour_count = $hour_count[$i];}
			if ($hour_count[$i] > 0) {$last_full_record = $i;}
			$stmt="select count(*) from vicidial_log where call_date >= '$query_date $h:00:00' and call_date <= '$query_date $h:14:59' $group_SQLand $list_id_SQLand and status='DROP';";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			$drop_count[$i] = $row[0];
			$i++;


			$stmt="select count(*) from vicidial_log where call_date >= '$query_date $h:15:00' and call_date <= '$query_date $h:29:59' $group_SQLand $list_id_SQLand;";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			$hour_count[$i] = $row[0];
			if ($hour_count[$i] > $hi_hour_count) {$hi_hour_count = $hour_count[$i];}
			if ($hour_count[$i] > 0) {$last_full_record = $i;}
			$stmt="select count(*) from vicidial_log where call_date >= '$query_date $h:15:00' and call_date <= '$query_date $h:29:59' $group_SQLand $list_id_SQLand and status='DROP';";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			$drop_count[$i] = $row[0];
			$i++;

			$stmt="select count(*) from vicidial_log where call_date >= '$query_date $h:30:00' and call_date <= '$query_date $h:44:59' $group_SQLand $list_id_SQLand;";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			$hour_count[$i] = $row[0];
			if ($hour_count[$i] > $hi_hour_count) {$hi_hour_count = $hour_count[$i];}
			if ($hour_count[$i] > 0) {$last_full_record = $i;}
			$stmt="select count(*) from vicidial_log where call_date >= '$query_date $h:30:00' and call_date <= '$query_date $h:44:59' $group_SQLand $list_id_SQLand and status='DROP';";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			$drop_count[$i] = $row[0];
			$i++;

			$stmt="select count(*) from vicidial_log where call_date >= '$query_date $h:45:00' and call_date <= '$query_date $h:59:59' $group_SQLand $list_id_SQLand;";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			$hour_count[$i] = $row[0];
			if ($hour_count[$i] > $hi_hour_count) {$hi_hour_count = $hour_count[$i];}
			if ($hour_count[$i] > 0) {$last_full_record = $i;}
			$stmt="select count(*) from vicidial_log where call_date >= '$query_date $h:45:00' and call_date <= '$query_date $h:59:59' $group_SQLand $list_id_SQLand and status='DROP';";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			$drop_count[$i] = $row[0];
			$i++;
			$h++;
			}

		$hour_multiplier = MathZDC(100, $hi_hour_count);

		echo "<!-- HICOUNT: $hi_hour_count|$hour_multiplier -->\n";
		echo "GRAPH IN 15 MINUTE INCREMENTS OF TOTAL CALLS PLACED FROM THIS CAMPAIGN\n";

		$k=1;
		$Mk=0;
		$call_scale = '0';
		while ($k <= 102) 
			{
			if ($Mk >= 5) 
				{
				$Mk=0;
				$scale_num=MathZDC($k, $hour_multiplier, 100);
				$scale_num = round($scale_num, 0);
				$LENscale_num = (strlen($scale_num));
				$k = ($k + $LENscale_num);
				$call_scale .= "$scale_num";
				}
			else
				{
				$call_scale .= " ";
				$k++;   $Mk++;
				}
			}


		echo "+------+-------------------------------------------------------------------------------------------------------+-------+-------+\n";
		#echo "| HOUR | GRAPH IN 15 MINUTE INCREMENTS OF TOTAL INCOMING CALLS FOR THIS GROUP                                  | DROPS | TOTAL |\n";
		echo "| HOUR |$call_scale| DROPS | TOTAL |\n";
		echo "+------+-------------------------------------------------------------------------------------------------------+-------+-------+\n";

		$ZZ = '00';
		$i=0;
		$h=4;
		$hour= -1;
		$no_lines_yet=1;

		while ($i <= 96)
			{
			$char_counter=0;
			$time = '      ';
			if ($h >= 4) 
				{
				$hour++;
				$h=0;
				if ($hour < 10) {$hour = "0$hour";}
				$time = "+$hour$ZZ+";
				}
			if ($h == 1) {$time = "   15 ";}
			if ($h == 2) {$time = "   30 ";}
			if ($h == 3) {$time = "   45 ";}
			$Ghour_count = $hour_count[$i];
			if ($Ghour_count < 1) 
				{
				if ( ($no_lines_yet) or ($i > $last_full_record) )
					{
					$do_nothing=1;
					}
				else
					{
					$hour_count[$i] =	sprintf("%-5s", $hour_count[$i]);
					echo "|$time|";
					$k=0;   while ($k <= 102) {echo " ";   $k++;}
					echo "| $hour_count[$i] |\n";
					}
				}
			else
				{
				$no_lines_yet=0;
				$Xhour_count = ($Ghour_count * $hour_multiplier);
				$Yhour_count = (99 - $Xhour_count);

				$Gdrop_count = $drop_count[$i];
				if ($Gdrop_count < 1) 
					{
					$hour_count[$i] =	sprintf("%-5s", $hour_count[$i]);

					echo "|$time|<SPAN class=\"green\">";
					$k=0;   while ($k <= $Xhour_count) {echo "*";   $k++;   $char_counter++;}
					echo "*X</SPAN>";   $char_counter++;
					$k=0;   while ($k <= $Yhour_count) {echo " ";   $k++;   $char_counter++;}
						while ($char_counter <= 101) {echo " ";   $char_counter++;}
					echo "| 0     | $hour_count[$i] |\n";

					}
				else
					{
					$Xdrop_count = ($Gdrop_count * $hour_multiplier);

				#	if ($Xdrop_count >= $Xhour_count) {$Xdrop_count = ($Xdrop_count - 1);}

					$XXhour_count = ( ($Xhour_count - $Xdrop_count) - 1 );

					$hour_count[$i] =	sprintf("%-5s", $hour_count[$i]);
					$drop_count[$i] =	sprintf("%-5s", $drop_count[$i]);

					echo "|$time|<SPAN class=\"red\">";
					$k=0;   while ($k <= $Xdrop_count) {echo ">";   $k++;   $char_counter++;}
					echo "D</SPAN><SPAN class=\"green\">";   $char_counter++;
					$k=0;   while ($k <= $XXhour_count) {echo "*";   $k++;   $char_counter++;}
					echo "X</SPAN>";   $char_counter++;
					$k=0;   while ($k <= $Yhour_count) {echo " ";   $k++;   $char_counter++;}
						while ($char_counter <= 102) {echo " ";   $char_counter++;}
					echo "| $drop_count[$i] | $hour_count[$i] |\n";
					}
				}
			
			
			$i++;
			$h++;
			}


		echo "+------+-------------------------------------------------------------------------------------------------------+-------+-------+\n";

		### END bottom graph
		}




	$ENDtime = date("U");
	$RUNtime = ($ENDtime - $STARTtime);
	echo "\nRun Time: $RUNtime seconds|$db_source\n";
	}

	$JS_onload.="}\n";
	$JS_text.=$JS_onload;	
	$JS_text.="</script>\n";
	echo $JS_text;

if ($db_source == 'S')
	{
	mysqli_close($link);
	$use_slave_server=0;
	$db_source = 'M';
	require("dbconnect_mysqli.php");
	}

$endMS = microtime();
$startMSary = explode(" ",$startMS);
$endMSary = explode(" ",$endMS);
$runS = ($endMSary[0] - $startMSary[0]);
$runM = ($endMSary[1] - $startMSary[1]);
$TOTALrun = ($runS + $runM);

$stmt="UPDATE vicidial_report_log set run_time='$TOTALrun' where report_log_id='$report_log_id';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);

?>
</FONT></PRE>
</TD></TR></TABLE>

</BODY></HTML>