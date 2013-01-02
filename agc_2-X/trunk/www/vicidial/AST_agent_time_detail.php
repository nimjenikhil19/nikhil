<?php 
# AST_agent_time_detail.php
# 
# Pulls time stats per agent selectable by campaign or user group
# should be most accurate agent stats of all of the reports
#
# Copyright (C) 2012  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# CHANGES
# 90522-0723 - First build
# 90908-1103 - Added DEAD time stats
# 100203-1147 - Added CUSTOMER time statistics
# 100214-1421 - Sort menu alphabetically
# 100216-0042 - Added popup date selector
# 100712-1324 - Added system setting slave server option
# 100802-2347 - Added User Group Allowed Reports option validation
# 100914-1326 - Added lookup for user_level 7 users to set to reports only which will remove other admin links
# 101207-1634 - Changed limits on seconds to 65000 from 30000 in vicidial_agent_log
# 101207-1719 - Fixed download file formatting bugs(issue 394)
# 101208-0320 - Fixed issue 404
# 110307-1057 - Added user_case setting in options.php
# 110623-0728 - Fixed user group selection bug
# 110708-1727 - Added options.php setting for time precision
# 111104-1248 - Added user_group restrictions for selecting in-groups
# 120224-0910 - Added HTML display option with bar graphs
# 121130-0957 - Fix for user group permissions issue #588
#

require("dbconnect.php");
require("functions.php");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
if (isset($_GET["query_date"]))				{$query_date=$_GET["query_date"];}
	elseif (isset($_POST["query_date"]))	{$query_date=$_POST["query_date"];}
if (isset($_GET["end_date"]))				{$end_date=$_GET["end_date"];}
	elseif (isset($_POST["end_date"]))		{$end_date=$_POST["end_date"];}
if (isset($_GET["group"]))					{$group=$_GET["group"];}
	elseif (isset($_POST["group"]))			{$group=$_POST["group"];}
if (isset($_GET["user_group"]))				{$user_group=$_GET["user_group"];}
	elseif (isset($_POST["user_group"]))	{$user_group=$_POST["user_group"];}
if (isset($_GET["shift"]))					{$shift=$_GET["shift"];}
	elseif (isset($_POST["shift"]))			{$shift=$_POST["shift"];}
if (isset($_GET["stage"]))					{$stage=$_GET["stage"];}
	elseif (isset($_POST["stage"]))			{$stage=$_POST["stage"];}
if (isset($_GET["file_download"]))			{$file_download=$_GET["file_download"];}
	elseif (isset($_POST["file_download"]))	{$file_download=$_POST["file_download"];}
if (isset($_GET["DB"]))						{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))			{$DB=$_POST["DB"];}
if (isset($_GET["submit"]))					{$submit=$_GET["submit"];}
	elseif (isset($_POST["submit"]))		{$submit=$_POST["submit"];}
if (isset($_GET["SUBMIT"]))					{$SUBMIT=$_GET["SUBMIT"];}
	elseif (isset($_POST["SUBMIT"]))		{$SUBMIT=$_POST["SUBMIT"];}
if (isset($_GET["report_display_type"]))				{$report_display_type=$_GET["report_display_type"];}
	elseif (isset($_POST["report_display_type"]))	{$report_display_type=$_POST["report_display_type"];}

if (strlen($shift)<2) {$shift='ALL';}
if (strlen($stage)<2) {$stage='NAME';}

$report_name = 'Agent Time Detail';
$db_source = 'M';
$JS_text="<script language='Javascript'>\n";
$JS_onload="onload = function() {\n";

$user_case = '';
$TIME_agenttimedetail = '';
if (file_exists('options.php'))
	{
	require('options.php');
	}
if ($user_case == '1')
	{$userSQL = 'ucase(user)';}
if ($user_case == '2')
	{$userSQL = 'lcase(user)';}
if (strlen($userSQL)<2)
	{$userSQL = 'user';}
if (strlen($TIME_agenttimedetail)<1)
	{$TIME_agenttimedetail = 'H';}

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,outbound_autodial_active,slave_db_server,reports_use_slave_db FROM system_settings;";
$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysql_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysql_fetch_row($rslt);
	$non_latin =					$row[0];
	$outbound_autodial_active =		$row[1];
	$slave_db_server =				$row[2];
	$reports_use_slave_db =			$row[3];
	}
##### END SETTINGS LOOKUP #####
###########################################

if ( (strlen($slave_db_server)>5) and (preg_match("/$report_name/",$reports_use_slave_db)) )
	{
	mysql_close($link);
	$use_slave_server=1;
	$db_source = 'S';
	require("dbconnect.php");
#	echo "<!-- Using slave server $slave_db_server $db_source -->\n";
	}

$PHP_AUTH_USER = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_USER);
$PHP_AUTH_PW = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_PW);

$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level > 6 and view_reports='1' and active='Y';";
if ($DB) {echo "|$stmt|\n";}
if ($non_latin > 0) { $rslt=mysql_query("SET NAMES 'UTF8'");}
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$auth=$row[0];

$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level='7' and view_reports='1' and active='Y';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$reports_only_user=$row[0];

if( (strlen($PHP_AUTH_USER)<2) or (strlen($PHP_AUTH_PW)<2) or (!$auth))
	{
    Header("WWW-Authenticate: Basic realm=\"VICI-PROJECTS\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "Invalid Username/Password: |$PHP_AUTH_USER|$PHP_AUTH_PW|\n";
    exit;
	}

$stmt="SELECT user_group from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level > 6 and view_reports='1' and active='Y';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$LOGuser_group =			$row[0];

$stmt="SELECT allowed_campaigns,allowed_reports,admin_viewable_groups,admin_viewable_call_times from vicidial_user_groups where user_group='$LOGuser_group';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$LOGallowed_campaigns =			$row[0];
$LOGallowed_reports =			$row[1];
$LOGadmin_viewable_groups =		$row[2];
$LOGadmin_viewable_call_times =	$row[3];

if ( (!preg_match("/$report_name/",$LOGallowed_reports)) and (!preg_match("/ALL REPORTS/",$LOGallowed_reports)) )
	{
    Header("WWW-Authenticate: Basic realm=\"VICI-PROJECTS\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "You are not allowed to view this report: |$PHP_AUTH_USER|$report_name|\n";
    exit;
	}

$LOGallowed_campaignsSQL='';
$whereLOGallowed_campaignsSQL='';
if ( (!eregi("-ALL",$LOGallowed_campaigns)) )
	{
	$rawLOGallowed_campaignsSQL = preg_replace("/ -/",'',$LOGallowed_campaigns);
	$rawLOGallowed_campaignsSQL = preg_replace("/ /","','",$rawLOGallowed_campaignsSQL);
	$LOGallowed_campaignsSQL = "and campaign_id IN('$rawLOGallowed_campaignsSQL')";
	$whereLOGallowed_campaignsSQL = "where campaign_id IN('$rawLOGallowed_campaignsSQL')";
	}
$regexLOGallowed_campaigns = " $LOGallowed_campaigns ";

$LOGadmin_viewable_groupsSQL='';
$whereLOGadmin_viewable_groupsSQL='';
if ( (!eregi("--ALL--",$LOGadmin_viewable_groups)) and (strlen($LOGadmin_viewable_groups) > 3) )
	{
	$rawLOGadmin_viewable_groupsSQL = preg_replace("/ -/",'',$LOGadmin_viewable_groups);
	$rawLOGadmin_viewable_groupsSQL = preg_replace("/ /","','",$rawLOGadmin_viewable_groupsSQL);
	$LOGadmin_viewable_groupsSQL = "and user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
	$whereLOGadmin_viewable_groupsSQL = "where user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
	}

$LOGadmin_viewable_call_timesSQL='';
$whereLOGadmin_viewable_call_timesSQL='';
if ( (!eregi("--ALL--",$LOGadmin_viewable_call_times)) and (strlen($LOGadmin_viewable_call_times) > 3) )
	{
	$rawLOGadmin_viewable_call_timesSQL = preg_replace("/ -/",'',$LOGadmin_viewable_call_times);
	$rawLOGadmin_viewable_call_timesSQL = preg_replace("/ /","','",$rawLOGadmin_viewable_call_timesSQL);
	$LOGadmin_viewable_call_timesSQL = "and call_time_id IN('---ALL---','$rawLOGadmin_viewable_call_timesSQL')";
	$whereLOGadmin_viewable_call_timesSQL = "where call_time_id IN('---ALL---','$rawLOGadmin_viewable_call_timesSQL')";
	}

$MT[0]='';
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

$stmt="select campaign_id from vicidial_campaigns $whereLOGallowed_campaignsSQL order by campaign_id;";
$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$campaigns_to_print = mysql_num_rows($rslt);
$i=0;
while ($i < $campaigns_to_print)
	{
	$row=mysql_fetch_row($rslt);
	$groups[$i] =$row[0];
	if (ereg("-ALL",$group_string) )
		{$group[$i] = $groups[$i];}
	$i++;
	}

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
	$i++;
	}
if ( (ereg("--ALL--",$group_string) ) or ($group_ct < 1) )
	{$group_SQL = "";}
else
	{
	$group_SQL = eregi_replace(",$",'',$group_SQL);
	$group_SQL = "and campaign_id IN($group_SQL)";
	}

for ($i=0; $i<count($user_group); $i++)
	{
	if (eregi("--ALL--", $user_group[$i])) {$all_user_groups=1; $user_group="";}
	}
$stmt="select user_group from vicidial_user_groups $whereLOGadmin_viewable_groupsSQL order by user_group;";
$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$user_groups_to_print = mysql_num_rows($rslt);
$i=0;
while ($i < $user_groups_to_print)
	{
	$row=mysql_fetch_row($rslt);
	$user_groups[$i] =$row[0];
	if ($all_user_groups) {$user_group[$i]=$row[0];}
	$i++;
	}

$i=0;
$user_group_string='|';
$user_group_ct = count($user_group);
while($i < $user_group_ct)
	{
	$user_group_string .= "$user_group[$i]|";
	$user_group_SQL .= "'$user_group[$i]',";
	$user_groupQS .= "&user_group[]=$user_group[$i]";
	$i++;
	}
if ( (ereg("--ALL--",$user_group_string) ) or ($user_group_ct < 1) )
	{$user_group_SQL = "";}
else
	{
	$user_group_SQL = eregi_replace(",$",'',$user_group_SQL);
	$TCuser_group_SQL = $user_group_SQL;
	$user_group_SQL = "and vicidial_agent_log.user_group IN($user_group_SQL)";
	$TCuser_group_SQL = "and user_group IN($TCuser_group_SQL)";
	}

if ($DB) {echo "$user_group_string|$user_group_ct|$user_groupQS|$i<BR>";}

$stmt="select distinct pause_code,pause_code_name from vicidial_pause_codes;";
$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$statha_to_print = mysql_num_rows($rslt);
$i=0;
while ($i < $statha_to_print)
	{
	$row=mysql_fetch_row($rslt);
	$pause_code[$i] =		"$row[0]";
	$pause_code_name[$i] =	"$row[1]";
	$i++;
	}

$LINKbase = "$PHP_SELF?query_date=$query_date&end_date=$end_date$groupQS$user_groupQS&shift=$shift&DB=$DB";

if ($file_download < 1)
	{
	?>

	<HTML>
	<HEAD>
	<STYLE type="text/css">
	<!--
	   .yellow {color: white; background-color: yellow}
	   .red {color: white; background-color: red}
	   .blue {color: white; background-color: blue}
	   .purple {color: white; background-color: purple}
	-->
	 </STYLE>

	<?php

	echo "<script language=\"JavaScript\" src=\"calendar_db.js\"></script>\n";
	echo "<link rel=\"stylesheet\" href=\"calendar.css\">\n";
	echo "<link rel=\"stylesheet\" href=\"horizontalbargraph.css\">\n";

	echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">\n";
	echo "<TITLE>$report_name</TITLE></HEAD><BODY BGCOLOR=white marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";
	echo "<span style=\"position:absolute;left:0px;top:0px;z-index:20;\" id=admin_header>";

	$short_header=1;

	require("admin_header.php");

	echo "</span>\n";
	echo "<span style=\"position:absolute;left:3px;top:3px;z-index:19;\" id=agent_status_stats>\n";
	echo "<PRE><FONT SIZE=2>\n";
	}

if ( (strlen($group[0]) < 1) or (strlen($user_group[0]) < 1) )
	{
	echo "\n";
	echo "PLEASE SELECT A CAMPAIGN OR USER GROUP AND DATE-TIME ABOVE AND CLICK SUBMIT\n";
	echo " NOTE: stats taken from shift specified\n";
	}

else
	{
	if ($shift == 'TEST') 
		{
		$time_BEGIN = "09:45:00";  
		$time_END = "10:00:00";
		}
	if ($shift == 'AM') 
		{
		$time_BEGIN=$AM_shift_BEGIN;
		$time_END=$AM_shift_END;
		if (strlen($time_BEGIN) < 6) {$time_BEGIN = "03:45:00";}   
		if (strlen($time_END) < 6) {$time_END = "15:15:00";}
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

	if ($file_download < 1)
		{
		echo "Agent Time Detail                     $NOW_TIME\n";

		echo "Time range: $query_date_BEGIN to $query_date_END\n\n";
		}
	else
		{
		$file_output .= "Agent Time Detail                     $NOW_TIME\n";
		$file_output .= "Time range: $query_date_BEGIN to $query_date_END\n\n";
		}



	############################################################################
	##### BEGIN gathering information from the database section
	############################################################################

	### BEGIN gather user IDs and names for matching up later
	$stmt="select full_name,$userSQL from vicidial_users $whereLOGadmin_viewable_groupsSQL order by user limit 100000;";
	$rslt=mysql_query($stmt, $link);
	if ($DB) {echo "$stmt\n";}
	$users_to_print = mysql_num_rows($rslt);
	$i=0;
	$graph_stats=array();
	$max_calls=1;
	$max_timeclock=1;
	$max_agenttime=1;
	$max_wait=1;
	$max_talk=1;
	$max_dispo=1;
	$max_pause=1;
	$max_dead=1;
	$max_customer=1;
	$GRAPH="<a name='timegraph'/><table border='0' cellpadding='0' cellspacing='2' width='800'>";
	$GRAPH2="<tr><th class='column_header grey_graph_cell' id='timegraph1'><a href='#' onClick=\"DrawGraph('CALLS', '1'); return false;\">CALLS</a></th><th class='column_header grey_graph_cell' id='timegraph2'><a href='#' onClick=\"DrawGraph('TIMECLOCK', '2'); return false;\">TIME CLOCK</a></th><th class='column_header grey_graph_cell' id='timegraph3'><a href='#' onClick=\"DrawGraph('AGENTTIME', '3'); return false;\">AGENT TIME</a></th><th class='column_header grey_graph_cell' id='timegraph4'><a href='#' onClick=\"DrawGraph('WAIT', '4'); return false;\">WAIT</a></th><th class='column_header grey_graph_cell' id='timegraph14'><a href='#' onClick=\"DrawGraph('WAITPCT', '14'); return false;\">WAIT %</a></th><th class='column_header grey_graph_cell' id='timegraph5'><a href='#' onClick=\"DrawGraph('TALK', '5'); return false;\">TALK</a></th><th class='column_header grey_graph_cell' id='timegraph10'><a href='#' onClick=\"DrawGraph('TALKPCT', '10'); return false;\">TALKTIME%</a></th><th class='column_header grey_graph_cell' id='timegraph6'><a href='#' onClick=\"DrawGraph('DISPO', '6'); return false;\">DISPO</a></th><th class='column_header grey_graph_cell' id='timegraph11'><a href='#' onClick=\"DrawGraph('DISPOPCT', '11'); return false;\">DISPOTIME%</a></th><th class='column_header grey_graph_cell' id='timegraph7'><a href='#' onClick=\"DrawGraph('PAUSE', '7'); return false;\">PAUSE</a></th><th class='column_header grey_graph_cell' id='timegraph12'><a href='#' onClick=\"DrawGraph('PAUSEPCT', '12'); return false;\">PAUSETIME%</a></th><th class='column_header grey_graph_cell' id='timegraph8'><a href='#' onClick=\"DrawGraph('DEAD', '8'); return false;\">DEAD</a></th><th class='column_header grey_graph_cell' id='timegraph13'><a href='#' onClick=\"DrawGraph('DEADPCT', '13'); return false;\">DEADTIME%</a></th><th class='column_header grey_graph_cell' id='timegraph9'><a href='#' onClick=\"DrawGraph('CUSTOMER', '9'); return false;\">CUSTOMER</a></th>";
	$graph_header="<table cellspacing='0' cellpadding='0' class='horizontalgraph'><caption align='top'>AGENT TIME BREAKDOWN</caption><tr><th class='thgraph' scope='col'>STATUS</th>";
	$CALLS_graph=$graph_header."<th class='thgraph' scope='col'>CALLS </th></tr>";
	$TIMECLOCK_graph=$graph_header."<th class='thgraph' scope='col'>TIME CLOCK</th></tr>";
	$AGENTTIME_graph=$graph_header."<th class='thgraph' scope='col'>AGENT TIME</th></tr>";
	$WAIT_graph=$graph_header."<th class='thgraph' scope='col'>WAIT</th></tr>";
	$WAITPCT_graph=$graph_header."<th class='thgraph' scope='col'>WAIT %</th></tr>";
	$TALK_graph=$graph_header."<th class='thgraph' scope='col'>TALK</th></tr>";
	$TALKPCT_graph=$graph_header."<th class='thgraph' scope='col'>TALK TIME %</th></tr>";
	$DISPO_graph=$graph_header."<th class='thgraph' scope='col'>DISPO</th></tr>";
	$DISPOPCT_graph=$graph_header."<th class='thgraph' scope='col'>DISPO TIME %</th></tr>";
	$PAUSE_graph=$graph_header."<th class='thgraph' scope='col'>PAUSE</th></tr>";
	$PAUSEPCT_graph=$graph_header."<th class='thgraph' scope='col'>PAUSE TIME %</th></tr>";
	$DEAD_graph=$graph_header."<th class='thgraph' scope='col'>DEAD</th></tr>";
	$DEADPCT_graph=$graph_header."<th class='thgraph' scope='col'>DEAD TIME %</th></tr>";
	$CUSTOMER_graph=$graph_header."<th class='thgraph' scope='col'>CUSTOMER</th></tr>";
	
	while ($i < $users_to_print)
		{
		$row=mysql_fetch_row($rslt);
		$ULname[$i] =	$row[0];
		$ULuser[$i] =	$row[1];
		$i++;
		}
	### END gather user IDs and names for matching up later


	### BEGIN gather timeclock records per agent
	$stmt="select $userSQL,sum(login_sec) from vicidial_timeclock_log where event IN('LOGIN','START') and event_date >= '$query_date_BEGIN' and event_date <= '$query_date_END' $TCuser_group_SQL group by user limit 10000000;";
	$rslt=mysql_query($stmt, $link);
	if ($DB) {echo "$stmt\n";}
	$punches_to_print = mysql_num_rows($rslt);
	$i=0;
	while ($i < $punches_to_print)
		{
		$row=mysql_fetch_row($rslt);
		$TCuser[$i] =	$row[0];
		$TCtime[$i] =	$row[1];
		$i++;
		}
	### END gather timeclock records per agent


	### BEGIN gather pause code information by user IDs
	$sub_statuses='-';
	$sub_statusesTXT='';
	$sub_statusesHEAD='';
	$sub_statusesHTML='';
	$sub_statusesFILE='';
	$sub_statusesARY=$MT;
	$sub_status_count=0;
	$PCusers='-';
	$PCusersARY=$MT;
	$PCuser_namesARY=$MT;
	$user_count=0;
	$stmt="select $userSQL,sum(pause_sec),sub_status from vicidial_agent_log where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and pause_sec > 0 and pause_sec < 65000 $group_SQL $user_group_SQL group by user,sub_status order by user,sub_status desc limit 10000000;";
	$rslt=mysql_query($stmt, $link);
	if ($DB) {echo "$stmt\n";}
	$subs_to_print = mysql_num_rows($rslt);
	$i=0; 
	while ($i < $subs_to_print)
		{
		$row=mysql_fetch_row($rslt);
		$PCuser[$i] =		$row[0];
		$PCpause_sec[$i] =	$row[1];
		$sub_status[$i] =	$row[2];

		if (!eregi("-$sub_status[$i]-", $sub_statuses))
			{
			$sub_statusesTXT = sprintf("%10s", $sub_status[$i]);
			$sub_statusesHEAD .= "------------+";
			$sub_statusesHTML .= " $sub_statusesTXT |";
			$sub_statusesFILE .= ",$sub_status[$i]";
			$sub_statuses .= "$sub_status[$i]-";
			$sub_statusesARY[$sub_status_count] = $sub_status[$i];
			$sub_status_count++;

			$max_varname="max_".$sub_status[$i];
			$$max_varname=1;
			}
		if (!eregi("-$PCuser[$i]-", $PCusers))
			{
			$PCusers .= "$PCuser[$i]-";
			$PCusersARY[$user_count] = $PCuser[$i];
			$user_count++;
			}

		$i++;
		}
	### END gather pause code information by user IDs


	##### BEGIN Gather all agent time records and parse through them in PHP to save on DB load
	$stmt="select $userSQL,wait_sec,talk_sec,dispo_sec,pause_sec,lead_id,status,dead_sec from vicidial_agent_log where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' $group_SQL $user_group_SQL limit 10000000;";
	$rslt=mysql_query($stmt, $link);
	if ($DB) {echo "$stmt\n";}
	$rows_to_print = mysql_num_rows($rslt);
	$i=0;
	$j=0;
	$k=0;
	$uc=0;
	while ($i < $rows_to_print)
		{
		$row=mysql_fetch_row($rslt);
		$user =			$row[0];
		$wait =			$row[1];
		$talk =			$row[2];
		$dispo =		$row[3];
		$pause =		$row[4];
		$lead =			$row[5];
		$status =		$row[6];
		$dead =			$row[7];
		if ($wait > 65000) {$wait=0;}
		if ($talk > 65000) {$talk=0;}
		if ($dispo > 65000) {$dispo=0;}
		if ($pause > 65000) {$pause=0;}
		if ($dead > 65000) {$dead=0;}
		$customer =		($talk - $dead);
		if ($customer < 1)
			{$customer=0;}
		$TOTwait =	($TOTwait + $wait);
		$TOTtalk =	($TOTtalk + $talk);
		$TOTdispo =	($TOTdispo + $dispo);
		$TOTpause =	($TOTpause + $pause);
		$TOTdead =	($TOTdead + $dead);
		$TOTcustomer =	($TOTcustomer + $customer);
		$TOTALtime = ($TOTALtime + $pause + $dispo + $talk + $wait);
		if ( ($lead > 0) and ((!eregi("NULL",$status)) and (strlen($status) > 0)) ) {$TOTcalls++;}
		
		$user_found=0;
		if ($uc < 1) 
			{
			$Suser[$uc] = $user;
			$uc++;
			}
		$m=0;
		while ( ($m < $uc) and ($m < 50000) )
			{
			if ($user == "$Suser[$m]")
				{
				$user_found++;

				$Swait[$m] =	($Swait[$m] + $wait);
				$Stalk[$m] =	($Stalk[$m] + $talk);
				$Sdispo[$m] =	($Sdispo[$m] + $dispo);
				$Spause[$m] =	($Spause[$m] + $pause);
				$Sdead[$m] =	($Sdead[$m] + $dead);
				$Scustomer[$m] =	($Scustomer[$m] + $customer);
				if ( ($lead > 0) and ((!eregi("NULL",$status)) and (strlen($status) > 0)) ) {$Scalls[$m]++;}
				}
			$m++;
			}
		if ($user_found < 1)
			{
			$Scalls[$uc] =	0;
			$Suser[$uc] =	$user;
			$Swait[$uc] =	$wait;
			$Stalk[$uc] =	$talk;
			$Sdispo[$uc] =	$dispo;
			$Spause[$uc] =	$pause;
			$Sdead[$uc] =	$dead;
			$Scustomer[$uc] =	$customer;
			if ($lead > 0) {$Scalls[$uc]++;}
			$uc++;
			}

		$i++;
		}
	if ($DB) {echo "Done gathering $i records, analyzing...<BR>\n";}
	##### END Gather all agent time records and parse through them in PHP to save on DB load

	############################################################################
	##### END gathering information from the database section
	############################################################################




	##### BEGIN print the output to screen or put into file output variable
	if ($file_download < 1)
		{
		$ASCII_text.="AGENT TIME BREAKDOWN:\n";
		$ASCII_text.="+-----------------+----------+----------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+   +$sub_statusesHEAD\n";
		$ASCII_text.="| <a href=\"$LINKbase&stage=NAME\">USER NAME</a>       | <a href=\"$LINKbase&stage=ID\">ID</a>       | <a href=\"$LINKbase&stage=LEADS\">CALLS</a>    | <a href=\"$LINKbase&stage=TCLOCK\">TIME CLOCK</a> | <a href=\"$LINKbase&stage=TIME\">AGENT TIME</a> | WAIT       | WAIT %     | TALK       | TALK TIME %| DISPO      | DISPOTIME %| PAUSE      | PAUSETIME %| DEAD       | DEAD TIME %| CUSTOMER   |   |$sub_statusesHTML\n";
		$ASCII_text.="+-----------------+----------+----------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+   +$sub_statusesHEAD\n";

		
		}
	else
		{
		$file_output .= "USER,ID,CALLS,TIME CLOCK,AGENT TIME,WAIT,WAIT %,TALK,TALK TIME %,DISPO,DISPO TIME %,PAUSE,PAUSE TIME %,DEAD,DEAD TIME %,CUSTOMER$sub_statusesFILE\n";
		}
	##### END print the output to screen or put into file output variable





	############################################################################
	##### BEGIN formatting data for output section
	############################################################################

	##### BEGIN loop through each user formatting data for output
	$AUTOLOGOUTflag=0;
	$m=0;
	while ( ($m < $uc) and ($m < 50000) )
		{
		$SstatusesHTML='';
		$SstatusesFILE='';
		$Stime[$m] = ($Swait[$m] + $Stalk[$m] + $Sdispo[$m] + $Spause[$m]);
		$Swaitpct[$m]=(100*$Swait[$m]/$Stime[$m]);
		$Stalkpct[$m]=(100*$Stalk[$m]/$Stime[$m]);
		$Sdispopct[$m]=(100*$Sdispo[$m]/$Stime[$m]);
		$Spausepct[$m]=(100*$Spause[$m]/$Stime[$m]);
		$Sdeadpct[$m]=(100*$Sdead[$m]/$Stime[$m]);
		$RAWuser = $Suser[$m];
		$RAWcalls = $Scalls[$m];
		$RAWtimeSEC = $Stime[$m];

		if (trim($Scalls[$m])>$max_calls) {$max_calls=trim($Scalls[$m]);}
		if (trim($Stime[$m])>$max_agenttime) {$max_agenttime=trim($Stime[$m]);}
		if (trim($Swait[$m])>$max_wait) {$max_wait=trim($Swait[$m]);}
		if (trim($Stalk[$m])>$max_talk) {$max_talk=trim($Stalk[$m]);}
		if (trim($Sdispo[$m])>$max_dispo) {$max_dispo=trim($Sdispo[$m]);}
		if (trim($Spause[$m])>$max_pause) {$max_pause=trim($Spause[$m]);}
		if (trim($Sdead[$m])>$max_dead) {$max_dead=trim($Sdead[$m]);}
		if (trim($Scustomer[$m])>$max_customer) {$max_customer=trim($Scustomer[$m]);}
		if (trim($Swaitpct[$m])>$max_waitpct) {$max_waitpct=trim($Swaitpct[$m]);}
		if (trim($Stalkpct[$m])>$max_talkpct) {$max_talkpct=trim($Stalkpct[$m]);}
		if (trim($Sdispopct[$m])>$max_dispopct) {$max_dispopct=trim($Sdispopct[$m]);}
		if (trim($Spausepct[$m])>$max_pausepct) {$max_pausepct=trim($Spausepct[$m]);}
		if (trim($Sdeadpct[$m])>$max_deadpct) {$max_deadpct=trim($Sdeadpct[$m]);}
		$graph_stats[$m][1]=trim($Scalls[$m]);
		$graph_stats[$m][3]=trim($Stime[$m]);
		$graph_stats[$m][4]=trim($Swait[$m]);
		$graph_stats[$m][5]=trim($Stalk[$m]);
		$graph_stats[$m][6]=trim($Sdispo[$m]);
		$graph_stats[$m][7]=trim($Spause[$m]);
		$graph_stats[$m][8]=trim($Sdead[$m]);
		$graph_stats[$m][9]=trim($Scustomer[$m]);
		$graph_stats[$m][10]=trim(sprintf("%01.2f", $Stalkpct[$m]));
		$graph_stats[$m][11]=trim(sprintf("%01.2f", $Sdispopct[$m]));
		$graph_stats[$m][12]=trim(sprintf("%01.2f", $Spausepct[$m]));
		$graph_stats[$m][13]=trim(sprintf("%01.2f", $Sdeadpct[$m]));
		$graph_stats[$m][14]=trim(sprintf("%01.2f", $Swaitpct[$m]));

		$Swaitpct[$m]=	sprintf("%01.2f", $Swaitpct[$m]);
		$Stalkpct[$m]=	sprintf("%01.2f", $Stalkpct[$m]);
		$Sdispopct[$m]=	sprintf("%01.2f", $Sdispopct[$m]);
		$Spausepct[$m]=	sprintf("%01.2f", $Spausepct[$m]);
		$Sdeadpct[$m]=	sprintf("%01.2f", $Sdeadpct[$m]);
		$Swait[$m]=		sec_convert($Swait[$m],$TIME_agenttimedetail);
		$Stalk[$m]=		sec_convert($Stalk[$m],$TIME_agenttimedetail);
		$Sdispo[$m]=	sec_convert($Sdispo[$m],$TIME_agenttimedetail);
		$Spause[$m]=	sec_convert($Spause[$m],$TIME_agenttimedetail);
		$Sdead[$m]=	sec_convert($Sdead[$m],$TIME_agenttimedetail);
		$Scustomer[$m]=	sec_convert($Scustomer[$m],$TIME_agenttimedetail);
		$Stime[$m]=		sec_convert($Stime[$m],$TIME_agenttimedetail);

		$RAWtime = $Stime[$m];
		$RAWwait = $Swait[$m];
		$RAWtalk = $Stalk[$m];
		$RAWdispo = $Sdispo[$m];
		$RAWpause = $Spause[$m];
		$RAWdead = $Sdead[$m];
		$RAWcustomer = $Scustomer[$m];
		$RAWwaitpct = $Swaitpct[$m];
		$RAWtalkpct = $Stalkpct[$m];
		$RAWdispopct = $Sdispopct[$m];
		$RAWpausepct = $Spausepct[$m];
		$RAWdeadpct = $Sdeadpct[$m];

		$n=0;
		$user_name_found=0;
		while ($n < $users_to_print)
			{
			if ($Suser[$m] == "$ULuser[$n]")
				{
				$user_name_found++;
				$RAWname = $ULname[$n];
				$Sname[$m] = $ULname[$n];
				}
			$n++;
			}
		if ($user_name_found < 1)
			{
			$RAWname =		"NOT IN SYSTEM";
			$Sname[$m] =	$RAWname;
			}

		$n=0;
		$punches_found=0;
		while ($n < $punches_to_print)
			{
			if ($Suser[$m] == "$TCuser[$n]")
				{
				$punches_found++;
				$RAWtimeTCsec =		$TCtime[$n];
				$TOTtimeTC =		($TOTtimeTC + $TCtime[$n]);

				if (trim($RAWtimeTCsec)>$max_timeclock) {$max_timeclock=trim($RAWtimeTCsec);}
				$graph_stats[$m][2]=trim($RAWtimeTCsec);

				$StimeTC[$m]=		sec_convert($TCtime[$n],$TIME_agenttimedetail);
				$RAWtimeTC =		$StimeTC[$m];
				$StimeTC[$m] =		sprintf("%10s", $StimeTC[$m]);
				}
			$n++;
			}
		if ($punches_found < 1)
			{
			$RAWtimeTCsec =		"0";

			$graph_stats[$m][2]=0;
			
			$StimeTC[$m] =		"0:00"; 
			if ($TIME_agenttimedetail == 'HF')
				{$StimeTC[$m] =		"0:00:00";}
			$RAWtimeTC =		$StimeTC[$m];
			$StimeTC[$m] =		sprintf("%10s", $StimeTC[$m]);
			}

		### Check if the user had an AUTOLOGOUT timeclock event during the time period
		$TCuserAUTOLOGOUT = ' ';
		$stmt="select count(*) from vicidial_timeclock_log where event='AUTOLOGOUT' and user='$Suser[$m]' and event_date >= '$query_date_BEGIN' and event_date <= '$query_date_END';";
		$rslt=mysql_query($stmt, $link);
		if ($DB) {echo "$stmt\n";}
		$autologout_results = mysql_num_rows($rslt);
		if ($autologout_results > 0)
			{
			$row=mysql_fetch_row($rslt);
			if ($row[0] > 0)
				{
				$TCuserAUTOLOGOUT =	'*';
				$AUTOLOGOUTflag++;
				}
			}

		### BEGIN loop through each status ###
		$n=0;
		while ($n < $sub_status_count)
			{
			$Sstatus=$sub_statusesARY[$n];
			$SstatusTXT='';
			$varname=$Sstatus."_graph";
			$$varname=$graph_header."<th class='thgraph' scope='col'>$Sstatus</th></tr>";
			$max_varname="max_".$Sstatus;
			### BEGIN loop through each stat line ###
			$i=0; $status_found=0;
			while ( ($i < $subs_to_print) and ($status_found < 1) )
				{
				if ( ($Suser[$m]=="$PCuser[$i]") and ($Sstatus=="$sub_status[$i]") )
					{
					$USERcodePAUSE_MS =		sec_convert($PCpause_sec[$i],$TIME_agenttimedetail);
					if (strlen($USERcodePAUSE_MS)<1) {$USERcodePAUSE_MS='0';}
					$pfUSERcodePAUSE_MS =	sprintf("%10s", $USERcodePAUSE_MS);
					
					if ($PCpause_sec[$i]>$$max_varname) {$$max_varname=$PCpause_sec[$i];}
					$graph_stats_sub[$m][$n]=$PCpause_sec[$i];					

					$SstatusTXT = sprintf("%10s", $pfUSERcodePAUSE_MS);
					$SstatusesHTML .= " $SstatusTXT |";
					$SstatusesFILE .= ",$USERcodePAUSE_MS";
					$status_found++;
					}
				$i++;
				}
			if ($status_found < 1)
				{
				if ($TIME_agenttimedetail == 'HF')
					{
					$SstatusesHTML .= "    0:00:00 |";
					$SstatusesFILE .= ",0:00:00";
					}
				else
					{
					$SstatusesHTML .= "       0:00 |";
					$SstatusesFILE .= ",0:00";
					}
				}
			### END loop through each stat line ###
			$n++;
			}
		### END loop through each status ###

		$Swaitpct[$m]=		sprintf("%9s", $Swaitpct[$m])."%";
		$Stalkpct[$m]=		sprintf("%9s", $Stalkpct[$m])."%";
		$Sdispopct[$m]=		sprintf("%9s", $Sdispopct[$m])."%";
		$Spausepct[$m]=		sprintf("%9s", $Spausepct[$m])."%";
		$Sdeadpct[$m]=		sprintf("%9s", $Sdeadpct[$m])."%";
		$Swait[$m]=		sprintf("%10s", $Swait[$m]); 
		$Stalk[$m]=		sprintf("%10s", $Stalk[$m]); 
		$Sdispo[$m]=	sprintf("%10s", $Sdispo[$m]); 
		$Spause[$m]=	sprintf("%10s", $Spause[$m]); 
		$Sdead[$m]=		sprintf("%10s", $Sdead[$m]); 
		$Scustomer[$m]=		sprintf("%10s", $Scustomer[$m]);
		$Scalls[$m]=	sprintf("%8s", $Scalls[$m]); 
		$Stime[$m]=		sprintf("%10s", $Stime[$m]); 

		if ($non_latin < 1)
			{
			$Sname[$m]=	sprintf("%-15s", $Sname[$m]); 
			while(strlen($Sname[$m])>15) {$Sname[$m] = substr("$Sname[$m]", 0, -1);}
			$Suser[$m] =		sprintf("%-8s", $Suser[$m]);
			while(strlen($Suser[$m])>8) {$Suser[$m] = substr("$Suser[$m]", 0, -1);}
			}
		else
			{	
			$Sname[$m]=	sprintf("%-45s", $Sname[$m]); 
			while(mb_strlen($Sname[$m],'utf-8')>15) {$Sname[$m] = mb_substr("$Sname[$m]", 0, -1,'utf-8');}
			$Suser[$m] =	sprintf("%-24s", $Suser[$m]);
			while(mb_strlen($Suser[$m],'utf-8')>8) {$Suser[$m] = mb_substr("$Suser[$m]", 0, -1,'utf-8');}
			}


		if ($file_download < 1)
			{
			$Toutput = "| $Sname[$m] | <a href=\"./user_stats.php?user=$RAWuser\">$Suser[$m]</a> | $Scalls[$m] | $StimeTC[$m]$TCuserAUTOLOGOUT| $Stime[$m] | $Swait[$m] | $Swaitpct[$m] | $Stalk[$m] | $Stalkpct[$m] | $Sdispo[$m] | $Sdispopct[$m] | $Spause[$m] | $Spausepct[$m] | $Sdead[$m] | $Sdeadpct[$m] | $Scustomer[$m] |   |$SstatusesHTML\n";
			$graph_stats[$m][0]=trim("$Suser[$m] - $Sname[$m]");
#CALLS    | TIME CLOCK | AGENT TIME | WAIT       | TALK       | DISPO      | PAUSE      | DEAD       | CUSTOMER   |   |      LOGIN |      TRAIN |     TOILET |     PRECAL |      BREAK |            |      LUNCH |     LAGGED
			}
		else
			{
			if (strlen($RAWtime)<1) {$RAWtime='0';}
			if (strlen($RAWwait)<1) {$RAWwait='0';}
			if (strlen($RAWwaitpct)<0) {$RAWwaitpct='0.0%';}
			if (strlen($RAWtalk)<1) {$RAWtalk='0';}
			if (strlen($RAWtalkpct)<0) {$RAWtalkpct='0.0%';}
			if (strlen($RAWdispo)<1) {$RAWdispo='0';}
			if (strlen($RAWdispopct)<0) {$RAWdispopct='0.0%';}
			if (strlen($RAWpause)<1) {$RAWpause='0';}
			if (strlen($RAWpausepct)<0) {$RAWpausepct='0.0%';}
			if (strlen($RAWdead)<1) {$RAWdead='0';}
			if (strlen($RAWdeadpct)<0) {$RAWdeadpct='0.0%';}
			if (strlen($RAWcustomer)<1) {$RAWcustomer='0';}
			$fileToutput = "$RAWname,$RAWuser,$RAWcalls,$RAWtimeTC,$RAWtime,$RAWwait,$RAWwaitpct %,$RAWtalk,$RAWtalkpct %,$RAWdispo,$RAWdispopct %,$RAWpause,$RAWpausepct %,$RAWdead,$RAWdeadpct %,$RAWcustomer$SstatusesFILE\n";
			}

		$TOPsorted_output[$m] = $Toutput;
		$TOPsorted_outputFILE[$m] = $fileToutput;

		if ($stage == 'NAME')
			{
			$TOPsort[$m] =	'' . sprintf("%020s", $RAWname) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
			$TOPsortTALLY[$m]=$RAWcalls;
			}
		if ($stage == 'ID')
			{
			$TOPsort[$m] =	'' . sprintf("%08s", $RAWuser) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
			$TOPsortTALLY[$m]=$RAWcalls;
			}
		if ($stage == 'LEADS')
			{
			$TOPsort[$m] =	'' . sprintf("%08s", $RAWcalls) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
			$TOPsortTALLY[$m]=$RAWcalls;
			}
		if ($stage == 'TIME')
			{
			$TOPsort[$m] =	'' . sprintf("%010s", $RAWtimeSEC) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
			$TOPsortTALLY[$m]=$RAWtimeSEC;
			}
		if ($stage == 'TCLOCK')
			{
			$TOPsort[$m] =	'' . sprintf("%010s", $RAWtimeTCsec) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
			$TOPsortTALLY[$m]=$RAWtimeTCsec;
			}
		if (!ereg("NAME|ID|TIME|LEADS|TCLOCK",$stage))
			if ($file_download < 1)
				{$ASCII_text.="$Toutput";}
			else
				{$file_output .= "$fileToutput";}

		if ($TOPsortMAX < $TOPsortTALLY[$m]) {$TOPsortMAX = $TOPsortTALLY[$m];}

#		echo "$Suser[$m]|$Sname[$m]|$Swait[$m]|$Stalk[$m]|$Sdispo[$m]|$Spause[$m]|$Scalls[$m]\n";
		$m++;
		}
	##### END loop through each user formatting data for output


	$TOT_AGENTS = $m;
	$hTOT_AGENTS = sprintf("%4s", $TOT_AGENTS);
	$k=$m;

	if ($DB) {echo "Done analyzing...   $TOTwait|$TOTtalk|$TOTdispo|$TOTpause|$TOTdead|$TOTcustomer|$TOTALtime|$TOTcalls|$uc|<BR>\n";}


	### BEGIN sort through output to display properly ###
	if ( ($TOT_AGENTS > 0) and (ereg("NAME|ID|TIME|LEADS|TCLOCK",$stage)) )
		{
		if (ereg("ID",$stage))
			{sort($TOPsort, SORT_NUMERIC);}
		if (ereg("TIME|LEADS|TCLOCK",$stage))
			{rsort($TOPsort, SORT_NUMERIC);}
		if (ereg("NAME",$stage))
			{rsort($TOPsort, SORT_STRING);}

		$m=0;
		while ($m < $k)
			{
			$sort_split = explode("-----",$TOPsort[$m]);
			$i = $sort_split[1];
			$sort_order[$m] = "$i";
			if ($file_download < 1)
				{$ASCII_text.="$TOPsorted_output[$i]";}
			else
				{$file_output .= "$TOPsorted_outputFILE[$i]";}
			$m++;
			}
		}
	### END sort through output to display properly ###

	############################################################################
	##### END formatting data for output section
	############################################################################




	############################################################################
	##### BEGIN last line totals output section
	############################################################################
	$SUMstatusesHTML='';
	$SUMstatusesFILE='';
	$TOTtotPAUSE=0;
	$n=0;
	while ($n < $sub_status_count)
		{
		$Scalls=0;
		$Sstatus=$sub_statusesARY[$n];
		$SUMstatusTXT='';
		$total_var=$Sstatus."_total";
		### BEGIN loop through each stat line ###
		$i=0; $status_found=0;
		while ($i < $subs_to_print)
			{
			if ($Sstatus=="$sub_status[$i]")
				{
				$Scalls =		($Scalls + $PCpause_sec[$i]);
				$status_found++;
				}
			$i++;
			}
		### END loop through each stat line ###
		if ($status_found < 1)
			{
			$SUMstatusesHTML .= "          0 |";
			$$total_var="0";
			}
		else
			{
			$TOTtotPAUSE = ($TOTtotPAUSE + $Scalls);

			$USERsumstatPAUSE_MS =		sec_convert($Scalls,$TIME_agenttimedetail);
			$pfUSERsumstatPAUSE_MS =	sprintf("%11s", $USERsumstatPAUSE_MS);
			$$total_var="$pfUSERsumstatPAUSE_MS";

			$SUMstatusTXT = sprintf("%10s", $pfUSERsumstatPAUSE_MS);
			$SUMstatusesHTML .= "$SUMstatusTXT |";
			$SUMstatusesFILE .= ",$USERsumstatPAUSE_MS";
			}
		$n++;
		}
	### END loop through each status ###

	### call function to calculate and print dialable leads
	$TOTwaitpct=sprintf("%01.2f", (100*$TOTwait/$TOTALtime));
	$TOTtalkpct=sprintf("%01.2f", (100*$TOTtalk/$TOTALtime));
	$TOTdispopct=sprintf("%01.2f", (100*$TOTdispo/$TOTALtime));
	$TOTpausepct=sprintf("%01.2f", (100*$TOTpause/$TOTALtime));
	$TOTdeadpct=sprintf("%01.2f", (100*$TOTdead/$TOTALtime));
	$TOTwait = sec_convert($TOTwait,$TIME_agenttimedetail);
	$TOTtalk = sec_convert($TOTtalk,$TIME_agenttimedetail);
	$TOTdispo = sec_convert($TOTdispo,$TIME_agenttimedetail);
	$TOTpause = sec_convert($TOTpause,$TIME_agenttimedetail);
	$TOTdead = sec_convert($TOTdead,$TIME_agenttimedetail);
	$TOTcustomer = sec_convert($TOTcustomer,$TIME_agenttimedetail);
	$TOTALtime = sec_convert($TOTALtime,$TIME_agenttimedetail);
	$TOTtimeTC = sec_convert($TOTtimeTC,$TIME_agenttimedetail);

	$hTOTwaitpct =	sprintf("%10s", $TOTwaitpct)."%";
	$hTOTtalkpct =	sprintf("%10s", $TOTtalkpct)."%";
	$hTOTdispopct =	sprintf("%10s", $TOTdispopct)."%";
	$hTOTpausepct =	sprintf("%10s", $TOTpausepct)."%";
	$hTOTdeadpct =	sprintf("%10s", $TOTdeadpct)."%";
	$hTOTcalls = sprintf("%8s", $TOTcalls);
	$hTOTwait =	sprintf("%11s", $TOTwait);
	$hTOTtalk =	sprintf("%11s", $TOTtalk);
	$hTOTdispo =	sprintf("%11s", $TOTdispo);
	$hTOTpause =	sprintf("%11s", $TOTpause);
	$hTOTdead =	sprintf("%11s", $TOTdead);
	$hTOTcustomer =	sprintf("%11s", $TOTcustomer);
	$hTOTALtime = sprintf("%11s", $TOTALtime);
	$hTOTtimeTC = sprintf("%11s", $TOTtimeTC);
	###### END LAST LINE TOTALS FORMATTING ##########


 
	if ($file_download < 1)
		{
		$ASCII_text.="+-----------------+----------+----------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+   +$sub_statusesHEAD\n";
		$ASCII_text.="|  TOTALS        AGENTS:$hTOT_AGENTS | $hTOTcalls |$hTOTtimeTC |$hTOTALtime |$hTOTwait |$hTOTwaitpct |$hTOTtalk |$hTOTtalkpct |$hTOTdispo |$hTOTdispopct |$hTOTpause |$hTOTpausepct |$hTOTdead |$hTOTdeadpct |$hTOTcustomer |   |$SUMstatusesHTML\n";
		$ASCII_text.="+-----------------+----------+----------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+------------+   +$sub_statusesHEAD\n";
		if ($AUTOLOGOUTflag > 0)
			{echo "     * denotes AUTOLOGOUT from timeclock\n";}
		$ASCII_text.="\n\n</PRE>";

		for ($e=0; $e<count($sub_statusesARY); $e++) {
			$Sstatus=$sub_statusesARY[$e];
			$SstatusTXT=$Sstatus;
			if ($Sstatus=="") {$SstatusTXT="(blank)";}
			$GRAPH2.="<th class='column_header grey_graph_cell' id='timegraph".(15+$e)."'><a href='#' onClick=\"DrawGraph('$Sstatus', '".(15+$e)."'); return false;\">$SstatusTXT</a></th>";
		}

		for ($d=0; $d<count($graph_stats); $d++) {
			if ($d==0) {$class=" first";} else if (($d+1)==count($graph_stats)) {$class=" last";} else {$class="";}
			$CALLS_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][1]/$max_calls)."' height='16' />".$graph_stats[$d][1]."</td></tr>";
			$TIMECLOCK_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][2]/$max_timeclock)."' height='16' />".sec_convert($graph_stats[$d][2], 'HF')."</td></tr>";
			$AGENTTIME_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][3]/$max_agenttime)."' height='16' />".sec_convert($graph_stats[$d][3], 'HF')."</td></tr>";
			$WAIT_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][4]/$max_wait)."' height='16' />".sec_convert($graph_stats[$d][4], 'HF')."</td></tr>";
			$TALK_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][5]/$max_talk)."' height='16' />".sec_convert($graph_stats[$d][5], 'HF')."</td></tr>";
			$DISPO_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][6]/$max_dispo)."' height='16' />".sec_convert($graph_stats[$d][6], 'HF')."</td></tr>";
			$PAUSE_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][7]/$max_pause)."' height='16' />".sec_convert($graph_stats[$d][7], 'HF')."</td></tr>";
			$DEAD_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][8]/$max_dead)."' height='16' />".sec_convert($graph_stats[$d][8], 'HF')."</td></tr>";
			$CUSTOMER_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][9]/$max_customer)."' height='16' />".sec_convert($graph_stats[$d][9], 'HF')."</td></tr>";
			$TALKPCT_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][10]/$max_talkpct)."' height='16' />".$graph_stats[$d][10]." %</td></tr>";
			$DISPOPCT_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][11]/$max_dispopct)."' height='16' />".$graph_stats[$d][11]." %</td></tr>";
			$PAUSEPCT_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][12]/$max_pausepct)."' height='16' />".$graph_stats[$d][12]." %</td></tr>";
			$DEADPCT_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][13]/$max_deadpct)."' height='16' />".$graph_stats[$d][13]." %</td></tr>";
			$WAITPCT_graph.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats[$d][14]/$max_waitpct)."' height='16' />".$graph_stats[$d][14]." %</td></tr>";

			for ($e=0; $e<count($sub_statusesARY); $e++) {
				$Sstatus=$sub_statusesARY[$e];
				$varname=$Sstatus."_graph";
				$max_varname="max_".$Sstatus;
				#$max.= "<!-- $max_varname => ".$$max_varname." //-->\n";
			
				$$varname.="  <tr><td class='chart_td$class'>".$graph_stats[$d][0]."</td><td nowrap class='chart_td value$class'><img src='images/bar.png' alt='' width='".round(400*$graph_stats_sub[$d][$e]/$$max_varname)."' height='16' />".sec_convert($graph_stats_sub[$d][$e], 'HF')."</td></tr>";
			}
		}
		$CALLS_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($hTOTcalls)."</th></tr></table>";
		$TIMECLOCK_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($hTOTtimeTC)."</th></tr></table>";
		$AGENTTIME_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($hTOTALtime)."</th></tr></table>";
		$WAIT_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($hTOTwait)."</th></tr></table>";
		$TALK_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($hTOTtalk)."</th></tr></table>";
		$DISPO_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($hTOTdispo)."</th></tr></table>";
		$PAUSE_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($hTOTpause)."</th></tr></table>";
		$DEAD_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($hTOTdead)."</th></tr></table>";
		$CUSTOMER_graph.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($hTOTcustomer)."</th></tr></table>";
		$WAITPCT_graph.="<tr><th class='thgraph' scope='col'>AVERAGE:</th><th class='thgraph' scope='col'>".trim($hTOTwaitpct)."</th></tr></table>";
		$TALKPCT_graph.="<tr><th class='thgraph' scope='col'>AVERAGE:</th><th class='thgraph' scope='col'>".trim($hTOTtalkpct)."</th></tr></table>";
		$DISPOPCT_graph.="<tr><th class='thgraph' scope='col'>AVERAGE:</th><th class='thgraph' scope='col'>".trim($hTOTdispopct)."</th></tr></table>";
		$PAUSEPCT_graph.="<tr><th class='thgraph' scope='col'>AVERAGE:</th><th class='thgraph' scope='col'>".trim($hTOTpausepct)."</th></tr></table>";
		$DEADPCT_graph.="<tr><th class='thgraph' scope='col'>AVERAGE:</th><th class='thgraph' scope='col'>".trim($hTOTdeadpct)."</th></tr></table>";
		for ($e=0; $e<count($sub_statusesARY); $e++) {
			$Sstatus=$sub_statusesARY[$e];
			$total_var=$Sstatus."_total";
			$graph_var=$Sstatus."_graph";
			$$graph_var.="<tr><th class='thgraph' scope='col'>TOTAL:</th><th class='thgraph' scope='col'>".trim($$total_var)."</th></tr></table>";
#			$JS_text.="var ".$Sstatus."_graph=\"".$$graph_var."\";\n";
		}
		$JS_onload.="\tDrawGraph('CALLS', '1');\n"; 
		$JS_text.="function DrawGraph(graph, th_id) {\n";
		$JS_text.="	var CALLS_graph=\"$CALLS_graph\";\n";
		$JS_text.="	var TIMECLOCK_graph=\"$TIMECLOCK_graph\";\n";
		$JS_text.="	var AGENTTIME_graph=\"$AGENTTIME_graph\";\n";
		$JS_text.="	var WAIT_graph=\"$WAIT_graph\";\n";
		$JS_text.="	var TALK_graph=\"$TALK_graph\";\n";
		$JS_text.="	var DISPO_graph=\"$DISPO_graph\";\n";
		$JS_text.="	var PAUSE_graph=\"$PAUSE_graph\";\n";
		$JS_text.="	var DEAD_graph=\"$DEAD_graph\";\n";
		$JS_text.="	var CUSTOMER_graph=\"$CUSTOMER_graph\";\n";
		$JS_text.="	var WAITPCT_graph=\"$WAITPCT_graph\";\n";
		$JS_text.="	var TALKPCT_graph=\"$TALKPCT_graph\";\n";
		$JS_text.="	var DISPOPCT_graph=\"$DISPOPCT_graph\";\n";
		$JS_text.="	var PAUSEPCT_graph=\"$PAUSEPCT_graph\";\n";
		$JS_text.="	var DEADPCT_graph=\"$DEADPCT_graph\";\n";

		for ($e=0; $e<count($sub_statusesARY); $e++) {
			$Sstatus=$sub_statusesARY[$e];
			$graph_var=$Sstatus."_graph";
			$JS_text.="	var ".$Sstatus."_graph=\"".$$graph_var."\";\n";
		}

		$JS_text.="	for (var i=1; i<=".(14+count($sub_statusesARY))."; i++) {\n";
		$JS_text.="		var cellID=\"timegraph\"+i;\n";
		$JS_text.="		document.getElementById(cellID).style.backgroundColor='#DDDDDD';\n";
		$JS_text.="	}\n";
		$JS_text.="	var cellID=\"timegraph\"+th_id;\n";
		$JS_text.="	document.getElementById(cellID).style.backgroundColor='#999999';\n";
		$JS_text.="\n";
		$JS_text.="	var graph_to_display=eval(graph+\"_graph\");\n";
		$JS_text.="	document.getElementById('agent_time_detail_graph').innerHTML=graph_to_display;\n";
		$JS_text.="}\n";

		$GRAPH3="<tr><td colspan='".(14+$sub_status_count)."' class='graph_span_cell'><span id='agent_time_detail_graph'><BR>&nbsp;<BR></span></td></tr></table><BR><BR>";
		
		# echo $GRAPH.$GRAPH2.$GRAPH3.$max;
		}
	else
		{
		$file_output .= "TOTALS,$TOT_AGENTS,$TOTcalls,$TOTtimeTC,$TOTALtime,$TOTwait,$TOTwaitpct %,$TOTtalk,$TOTtalkpct %,$TOTdispo,$TOTpause,$TOTdead,$TOTcustomer$SUMstatusesFILE\n";
		}
	}

	############################################################################
	##### END formatting data for output section
	############################################################################





if ($file_download > 0)
	{
	$FILE_TIME = date("Ymd-His");
	$CSVfilename = "AGENT_TIME$US$FILE_TIME.csv";

	// We'll be outputting a TXT file
	header('Content-type: application/octet-stream');

	// It will be called LIST_101_20090209-121212.txt
	header("Content-Disposition: attachment; filename=\"$CSVfilename\"");
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	ob_clean();
	flush();

	echo "$file_output";

	exit;
	}

$NWB = " &nbsp; <a href=\"javascript:openNewWindow('/vicidial/admin.php?ADD=99999";
$NWE = "')\"><IMG SRC=\"help.gif\" WIDTH=20 HEIGHT=20 BORDER=0 ALT=\"HELP\" ALIGN=TOP></A>";

############################################################################
##### BEGIN HTML form section
############################################################################
$JS_onload.="}\n";
$JS_text.=$JS_onload;
$JS_text.="</script>\n";

if ($report_display_type=="HTML")
	{
	echo $JS_text;
	echo $GRAPH.$GRAPH2.$GRAPH3.$max;
	}
else
	{
	echo $ASCII_text;
	}

echo "<FORM ACTION=\"$PHP_SELF\" METHOD=GET name=vicidial_report id=vicidial_report>\n";
echo "<TABLE CELLSPACING=3><TR><TD VALIGN=TOP> Dates:<BR>";
echo "<INPUT TYPE=hidden NAME=DB VALUE=\"$DB\">\n";
echo "<INPUT TYPE=TEXT NAME=query_date SIZE=10 MAXLENGTH=10 VALUE=\"$query_date\">";

?>
<script language="JavaScript">
function openNewWindow(url)
	{
	window.open (url,"",'width=620,height=300,scrollbars=yes,menubar=yes,address=yes');
	}

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


echo "</TD><TD VALIGN=TOP> Campaigns:<BR>";
echo "<SELECT SIZE=5 NAME=group[] multiple>\n";
if  (eregi("--ALL--",$group_string))
	{echo "<option value=\"--ALL--\" selected>-- ALL CAMPAIGNS --</option>\n";}
else
	{echo "<option value=\"--ALL--\">-- ALL CAMPAIGNS --</option>\n";}
$o=0;
while ($campaigns_to_print > $o)
{
	if (eregi("$groups[$o]\|",$group_string)) {echo "<option selected value=\"$groups[$o]\">$groups[$o]</option>\n";}
	  else {echo "<option value=\"$groups[$o]\">$groups[$o]</option>\n";}
	$o++;
}
echo "</SELECT>\n";
echo "</TD><TD VALIGN=TOP>User Groups:<BR>";
echo "<SELECT SIZE=5 NAME=user_group[] multiple>\n";

if  (eregi("--ALL--",$user_group_string))
	{echo "<option value=\"--ALL--\" selected>-- ALL USER GROUPS --</option>\n";}
else
	{echo "<option value=\"--ALL--\">-- ALL USER GROUPS --</option>\n";}
$o=0;
while ($user_groups_to_print > $o)
	{
	if  (eregi("$user_groups[$o]\|",$user_group_string)) {echo "<option selected value=\"$user_groups[$o]\">$user_groups[$o]</option>\n";}
	  else {echo "<option value=\"$user_groups[$o]\">$user_groups[$o]</option>\n";}
	$o++;
	}
echo "</SELECT>\n";
echo "</TD><TD VALIGN=TOP>Shift:<BR>";
echo "<SELECT SIZE=1 NAME=shift>\n";
echo "<option selected value=\"$shift\">$shift</option>\n";
echo "<option value=\"\">--</option>\n";
echo "<option value=\"AM\">AM</option>\n";
echo "<option value=\"PM\">PM</option>\n";
echo "<option value=\"ALL\">ALL</option>\n";
echo "</SELECT><BR><BR>\n";
echo "Display as:<BR>";
echo "<select name='report_display_type'>";
if ($report_display_type) {echo "<option value='$report_display_type' selected>$report_display_type</option>";}
echo "<option value='TEXT'>TEXT</option><option value='HTML'>HTML</option></select>\n<BR><BR>";
echo "<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=SUBMIT>$NWB#agent_time_detail$NWE\n";
echo "</TD><TD VALIGN=TOP> &nbsp; &nbsp; &nbsp; &nbsp; ";

echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;\n";
echo " <a href=\"$LINKbase&stage=$stage&file_download=1\">DOWNLOAD</a> | \n";
echo " <a href=\"./admin.php?ADD=999999\">REPORTS</a> </FONT>\n";
echo "</FONT>\n";
echo "</TD></TR></TABLE>";

echo "</FORM>\n\n<BR>$db_source";
############################################################################
##### END HTML form section
############################################################################


$ENDtime = date("U");
$RUNtime = ($ENDtime - $STARTtime);
echo "<font size=1 color=white>$RUNtime</font>\n";


##### BEGIN horizontal yellow transparent bar graph overlay on top of agent stats
echo "</span>\n";
echo "<span style=\"position:absolute;left:3px;top:3px;z-index:18;\"  id=agent_status_bars>\n";
echo "<PRE><FONT SIZE=2>\n\n\n\n\n\n\n\n";

if ($stage == 'NAME') {$k=0;}
$m=0;
while ($m < $k)
	{
	$sort_split = explode("-----",$TOPsort[$m]);
	$i = $sort_split[1];
	$sort_order[$m] = "$i";

	if ( ($TOPsortTALLY[$i] < 1) or ($TOPsortMAX < 1) )
		{echo "                              \n";}
	else
		{
		echo "                              <SPAN class=\"yellow\">";
		$TOPsortPLOT = ( ($TOPsortTALLY[$i] / $TOPsortMAX) * 110 );
		$h=0;
		while ($h <= $TOPsortPLOT)
			{
			echo " ";
			$h++;
			}
		echo "</SPAN>\n";
		}
	$m++;
	}

echo "</span>\n";
##### END horizontal yellow transparent bar graph overlay on top of agent stats

?>

</BODY></HTML>