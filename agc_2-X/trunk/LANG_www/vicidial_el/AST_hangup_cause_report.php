<?php 
# AST_carrier_log_report.php
# 
# Copyright (C) 2012  Joe Johnson, Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# CHANGES
# 120331-2301 - First build
#


require("dbconnect.php");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
if (isset($_GET["query_date"]))				{$query_date=$_GET["query_date"];}
	elseif (isset($_POST["query_date"]))	{$query_date=$_POST["query_date"];}
if (isset($_GET["query_date_D"]))				{$query_date_D=$_GET["query_date_D"];}
	elseif (isset($_POST["query_date_D"]))	{$query_date_D=$_POST["query_date_D"];}
if (isset($_GET["query_date_T"]))				{$query_date_T=$_GET["query_date_T"];}
	elseif (isset($_POST["query_date_T"]))	{$query_date_T=$_POST["query_date_T"];}
if (isset($_GET["server_ip"]))					{$server_ip=$_GET["server_ip"];}
	elseif (isset($_POST["server_ip"]))			{$server_ip=$_POST["server_ip"];}
if (isset($_GET["hangup_cause"]))					{$hangup_cause=$_GET["hangup_cause"];}
	elseif (isset($_POST["hangup_cause"]))			{$hangup_cause=$_POST["hangup_cause"];}
if (isset($_GET["file_download"]))			{$file_download=$_GET["file_download"];}
	elseif (isset($_POST["file_download"]))	{$file_download=$_POST["file_download"];}
if (isset($_GET["lower_limit"]))			{$lower_limit=$_GET["lower_limit"];}
	elseif (isset($_POST["lower_limit"]))	{$lower_limit=$_POST["lower_limit"];}
if (isset($_GET["upper_limit"]))			{$upper_limit=$_GET["upper_limit"];}
	elseif (isset($_POST["upper_limit"]))	{$upper_limit=$_POST["upper_limit"];}
if (isset($_GET["DB"]))						{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))			{$DB=$_POST["DB"];}
if (isset($_GET["submit"]))					{$submit=$_GET["submit"];}
	elseif (isset($_POST["submit"]))		{$submit=$_POST["submit"];}
if (isset($_GET["ΕΠΙΒΕΒΑΙΩΣΗ"]))					{$ΕΠΙΒΕΒΑΙΩΣΗ=$_GET["ΕΠΙΒΕΒΑΙΩΣΗ"];}
	elseif (isset($_POST["ΕΠΙΒΕΒΑΙΩΣΗ"]))		{$ΕΠΙΒΕΒΑΙΩΣΗ=$_POST["ΕΠΙΒΕΒΑΙΩΣΗ"];}

$PHP_AUTH_USER = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_USER);
$PHP_AUTH_PW = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_PW);

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,outbound_autodial_active,slave_db_server,reports_use_slave_db FROM system_settings;";
$rslt=mysql_query($stmt, $link);
if ($DB) {$MAIN.="$stmt\n";}
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
	$MAIN.="<!-- Using slave server $slave_db_server $db_source -->\n";
	}

$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level >= 7 and view_reports='1' and active='Y';";
if ($DB) {$MAIN.="|$stmt|\n";}
if ($non_latin > 0) {$rslt=mysql_query("SET NAMES 'UTF8'");}
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$auth=$row[0];

$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level='7' and view_reports='1' and active='Y';";
if ($DB) {$MAIN.="|$stmt|\n";}
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$reports_only_user=$row[0];

if( (strlen($PHP_AUTH_USER)<2) or (strlen($PHP_AUTH_PW)<2) or (!$auth))
	{
    Header("WWW-Authenticate: Basic realm=\"VICI-PROJECTS\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "Ακυρο Ονομα Χρήστη/Κωδικός Πρόσβασης: |$PHP_AUTH_USER|$PHP_AUTH_PW|\n";
    exit;
	}


if (strlen($query_date_D) < 6) {$query_date_D = "00:00:00";}
if (strlen($query_date_T) < 6) {$query_date_T = "23:59:59";}
$NOW_DATE = date("Y-m-d");
if (!isset($query_date)) {$query_date = $NOW_DATE;}

$server_ip_string='|';
$server_ip_ct = count($server_ip);
$i=0;
while($i < $server_ip_ct)
	{
	$server_ip_string .= "$server_ip[$i]|";
	$i++;
	}

$server_stmt="select distinct s.server_ip, s.server_description from servers s, vicidial_carrier_log vcl where s.server_ip=vcl.server_ip order by server_ip asc";
$server_rslt=mysql_query($server_stmt, $link);
$servers_to_print=mysql_num_rows($server_rslt);
$i=0;
while ($i < $servers_to_print)
	{
	$row=mysql_fetch_row($server_rslt);
	$LISTserverIPs[$i] =		$row[0];
	$LISTserver_names[$i] =	$row[1];
	if (ereg("-ALL",$server_ip_string) )
		{
		$server_ip[$i] = $LISTserverIPs[$i];
		}
	$i++;
	}

$i=0;
$server_ips_string='|';
$server_ip_ct = count($server_ip);
while($i < $server_ip_ct)
	{
	if ( (strlen($server_ip[$i]) > 0) and (preg_match("/\|$server_ip[$i]\|/",$server_ip_string)) )
		{
		$server_ips_string .= "$server_ip[$i]|";
		$server_ip_SQL .= "'$server_ip[$i]',";
		$server_ipQS .= "&server_ip[]=$server_ip[$i]";
		}
	$i++;
	}

if ( (ereg("--ALL--",$server_ip_string) ) or ($server_ip_ct < 1) )
	{
	$server_ip_SQL = "";
	$server_rpt_string="- ALL servers ";
	if (ereg("--ALL--",$server_ip_string)) {$server_ipQS="&server_ip[]=--ALL--";}
	}
else
	{
	$server_ip_SQL = eregi_replace(",$",'',$server_ip_SQL);
	$server_ip_SQL = "and server_ip IN($server_ip_SQL)";
	$server_rpt_string="- server(s) ".preg_replace('/\|/', ", ", substr($server_ip_string, 1, -1));
	}
if (strlen($server_ip_SQL)<3) {$server_ip_SQL="";}

########### HANGUP CAUSES
$hangup_cause_string='|';
$dialstatus_string='|';
$hangup_and_dialstatus_string='|';
$hangup_cause_ct = count($hangup_cause);

$i=0;
while($i < $hangup_cause_ct)
	{
	$hangup_array=explode("!", $hangup_cause[$i]);
	$hangup_and_dialstatus_string .= "$hangup_cause[$i]|";
	$hangup_cause_string .= "$hangup_array[0]|";
	$dialstatus_string .= "$hangup_array[1]|";
	$i++;
	}

$hangupcause_stmt="select distinct hangup_cause, dialstatus from vicidial_carrier_log order by dialstatus, hangup_cause asc";
$hangupcause_rslt=mysql_query($hangupcause_stmt, $link);
$causes_to_print=mysql_num_rows($hangupcause_rslt);
$i=0;
while ($i < $causes_to_print)
	{
	$row=mysql_fetch_row($hangupcause_rslt);
	$LISThangup_causes[$i] =		$row[0];
	$LISTdialstatuses[$i] =		$row[1];
	if (ereg("-ALL",$hangup_cause_string) )
		{
		$hangup_cause[$i] = $LISThangup_causes[$i];
		$dialstatus[$i] = $LISTdialstatuses[$i];
		}
	$i++;
	}
$i=0;
$hangup_causes_string='|';
$hangup_cause_ct = count($hangup_cause);
while($i < $hangup_cause_ct)
	{
	$hangup_array=explode("!", $hangup_cause[$i]);
	if ( (strlen($hangup_array[0]) > 0) and (preg_match("/\|$hangup_array[0]\|/",$hangup_cause_string)) and (strlen($hangup_array[1]) > 0) and (preg_match("/\|$hangup_array[1]\|/",$dialstatus_string)) )
		{
		$hangup_causes_string .= "$hangup_array[0]|";
		$hangup_cause_SQL .= "(hangup_cause='$hangup_array[0]' and dialstatus='$hangup_array[1]') OR";
		$hangup_causeQS .= "&hangup_cause[]=$hangup_cause[$i]";
		}
	$i++;
	}

if ( (ereg("--ALL--",$hangup_cause_string) ) or ($hangup_cause_ct < 1) )
	{
	$hangup_cause_SQL = "";
	$HC_rpt_string="- ALL hangup causes ";
	if (ereg("--ALL--",$hangup_cause_string)) {$hangup_causeQS="&hangup_cause[]=--ALL--";}
	}
else
	{
	$hangup_cause_SQL=preg_replace('/ OR$/', '', $hangup_cause_SQL);
	$hangup_cause_SQL = eregi_replace(",$",'',$hangup_cause_SQL);
	$hangup_cause_SQL = "and ($hangup_cause_SQL)";
	$hangup_and_dialstatus_string=preg_replace('/\!/', "-", $hangup_and_dialstatus_string);
	$HC_rpt_string="AND hangup cause(s) ".preg_replace('/\|/', ", ", substr($hangup_and_dialstatus_string, 1, -1));
	}
if (strlen($hangup_cause_SQL)<3) {$hangup_cause_SQL="";}
########################
$HEADER.="<HTML>\n";
$HEADER.="<HEAD>\n";
$HEADER.="<STYLE type=\"text/css\">\n";
$HEADER.="<!--\n";
$HEADER.="   .green {color: white; background-color: green}\n";
$HEADER.="   .red {color: white; background-color: red}\n";
$HEADER.="   .blue {color: white; background-color: blue}\n";
$HEADER.="   .purple {color: white; background-color: purple}\n";
$HEADER.="-->\n";
$HEADER.=" </STYLE>\n";
$HEADER.="<script language=\"JavaScript\" src=\"calendar_db.js\"></script>\n";
$HEADER.="<link rel=\"stylesheet\" href=\"calendar.css\">\n";
$HEADER.="<link rel=\"stylesheet\" href=\"horizontalbargraph.css\">\n";
$HEADER.="<link rel=\"stylesheet\" href=\"verticalbargraph.css\">\n";
$HEADER.="<script language=\"JavaScript\" src=\"wz_jsgraphics.js\"></script>\n";
$HEADER.="<script language=\"JavaScript\" src=\"line.js\"></script>\n";
$HEADER.="<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">\n";
$HEADER.="<TITLE>$report_name</TITLE></HEAD><BODY BGCOLOR=WHITE marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";

$short_header=1;

$MAIN.="<TABLE CELLPADDING=4 CELLSPACING=0><TR><TD>";
$MAIN.="<FORM ACTION=\"$PHP_SELF\" METHOD=GET name=vicidial_report id=vicidial_report>\n";
$MAIN.="<TABLE Border=0 cellspacing=5 cellpadding=5><TR><TD VALIGN=TOP align=center>\n";
$MAIN.="<INPUT TYPE=HIDDEN NAME=DB VALUE=\"$DB\">\n";
$MAIN.="Date:\n";
$MAIN.="<INPUT TYPE=TEXT NAME=query_date SIZE=10 MAXLENGTH=10 VALUE=\"$query_date\">";
$MAIN.="<script language=\"JavaScript\">\n";
$MAIN.="var o_cal = new tcal ({\n";
$MAIN.="	// form name\n";
$MAIN.="	'formname': 'vicidial_report',\n";
$MAIN.="	// input name\n";
$MAIN.="	'controlname': 'query_date'\n";
$MAIN.="});\n";
$MAIN.="o_cal.a_tpl.yearscroll = false;\n";
$MAIN.="// o_cal.a_tpl.weekstart = 1; // Δευτέρα week start\n";
$MAIN.="</script>\n";

$MAIN.="<BR><BR><INPUT TYPE=TEXT NAME=query_date_D SIZE=9 MAXLENGTH=8 VALUE=\"$query_date_D\">";

$MAIN.="<BR> to <BR><INPUT TYPE=TEXT NAME=query_date_T SIZE=9 MAXLENGTH=8 VALUE=\"$query_date_T\">";

$MAIN.="</TD><TD ROWSPAN=2 VALIGN=TOP>IP Διακομιστή:<BR/>\n";
$MAIN.="<SELECT SIZE=5 NAME=server_ip[] multiple>\n";
if  (eregi("--ALL--",$server_ip_string))
	{$MAIN.="<option value=\"--ALL--\" selected>-- ALL SERVERS --</option>\n";}
else
	{$MAIN.="<option value=\"--ALL--\">-- ALL SERVERS --</option>\n";}
$o=0;
while ($servers_to_print > $o)
	{
	if (ereg("\|$LISTserverIPs[$o]\|",$server_ip_string)) 
		{$MAIN.="<option selected value=\"$LISTserverIPs[$o]\">$LISTserverIPs[$o] - $LISTserver_names[$o]</option>\n";}
	else
		{$MAIN.="<option value=\"$LISTserverIPs[$o]\">$LISTserverIPs[$o] - $LISTserver_names[$o]</option>\n";}
	$o++;
	}
$MAIN.="</SELECT></TD>";

$MAIN.="<TD ROWSPAN=2 VALIGN=top align=center>Hangup Cause/Dial Status:<BR/>";
$MAIN.="<SELECT SIZE=5 NAME=hangup_cause[] multiple>\n";
if  (eregi("--ALL--",$hangup_cause_string))
	{$MAIN.="<option value=\"--ALL--\" selected>-- ALL HANGUP CAUSES --</option>\n";}
else
	{$MAIN.="<option value=\"--ALL--\">-- ALL HANGUP CAUSES --</option>\n";}
$o=0;
while ($causes_to_print > $o)
	{
	if (ereg("\|$LISThangup_causes[$o]!$LISTdialstatuses[$o]\|",$hangup_and_dialstatus_string)) 
		{$MAIN.="<option selected value=\"$LISThangup_causes[$o]!$LISTdialstatuses[$o]\">$LISThangup_causes[$o] - $LISTdialstatuses[$o]</option>\n";}
	else
		{$MAIN.="<option value=\"$LISThangup_causes[$o]!$LISTdialstatuses[$o]\">$LISThangup_causes[$o] - $LISTdialstatuses[$o]</option>\n";}
	$o++;
	}
$MAIN.="</SELECT></TD>";

$MAIN.="<TD ROWSPAN=2 VALIGN=top align=center>";

$MAIN.="</TD>\n";

$MAIN.="<TD ROWSPAN=2 VALIGN=middle align=center>\n";
$MAIN.="<INPUT TYPE=submit NAME=ΕΠΙΒΕΒΑΙΩΣΗ VALUE=ΥΠΟΒΑΛΛΩ><BR/><BR/>\n";
$MAIN.="</TD></TR></TABLE>\n";
if ($ΕΠΙΒΕΒΑΙΩΣΗ && $server_ip_ct>0) {
	$stmt="select hangup_cause, dialstatus, count(*) as ct From vicidial_carrier_log where call_date>='$query_date $query_date_D' and call_date<='$query_date $query_date_T' $server_ip_SQL $hangup_cause_SQL group by hangup_cause, dialstatus order by hangup_cause, dialstatus";
	$rslt=mysql_query($stmt, $link);
	$MAIN.="<PRE><font size=2>\n";
	if ($DB) {$MAIN.=$stmt."\n";}
	if (mysql_num_rows($rslt)>0) {
		$MAIN.="--- DIAL STATUS BREAKDOWN FOR $query_date, $query_date_D TO $query_date_T $server_rpt_string\n";
		$MAIN.="+--------------+-------------+---------+\n";
		$MAIN.="| HANGUP CAUSE | DIAL STATUS |  COUNT  |\n";
		$MAIN.="+--------------+-------------+---------+\n";
		$total_count=0;
		while ($row=mysql_fetch_array($rslt)) {
			$MAIN.="| ".sprintf("%-13s", $row["hangup_cause"]);
			$MAIN.="| ".sprintf("%-12s", $row["dialstatus"]);
			$MAIN.="| ".sprintf("%-8s", $row["ct"]);
			$MAIN.="|\n";
			$total_count+=$row["ct"];
		}
		$MAIN.="+--------------+-------------+---------+\n";
		$MAIN.="|                      TOTAL | ".sprintf("%-8s", $total_count)."|\n";
		$MAIN.="+--------------+-------------+---------+\n\n\n";

		$rpt_stmt="select vicidial_carrier_log.*, vicidial_log.phone_number from vicidial_carrier_log left join vicidial_log on vicidial_log.uniqueid=vicidial_carrier_log.uniqueid where vicidial_carrier_log.call_date>='$query_date $query_date_D' and vicidial_carrier_log.call_date<='$query_date $query_date_T' $server_ip_SQL $hangup_cause_SQL order by vicidial_carrier_log.call_date asc";
		$rpt_rslt=mysql_query($rpt_stmt, $link);
		if ($DB) {$MAIN.=$rpt_stmt."\n";}

		if (!$lower_limit) {$lower_limit=1;}
		if ($lower_limit+999>=mysql_num_rows($rpt_rslt)) {$upper_limit=($lower_limit+mysql_num_rows($rpt_rslt)%1000)-1;} else {$upper_limit=$lower_limit+999;}
		
		$MAIN.="--- CARRIER LOG RECORDS FOR $query_date, $query_date_D TO $query_date_T $server_rpt_string, $HC_rpt_string\n --- RECORDS #$lower_limit-$upper_limit               <a href=\"$PHP_SELF?ΕΠΙΒΕΒΑΙΩΣΗ=$ΕΠΙΒΕΒΑΙΩΣΗ&DB=$DB&type=$type&query_date=$query_date&query_date_D=$query_date_D&query_date_T=$query_date_T$server_ipQS&lower_limit=$lower_limit&upper_limit=$upper_limit&file_download=1\">[ΛΗΨΗ]</a>\n";
		$carrier_rpt.="+----------------------+---------------------+-----------------+-----------+--------------+-------------+------------------------------------------+-----------+---------------+--------------+\n";
		$carrier_rpt.="| UNIQUE ID            | CALL DATE           | ΔΙΑΚΟΜΙΣΤΗΣ IP       | LEAD ID   | HANGUP CAUSE | DIAL STATUS | CHANNEL                                  | DIAL TIME | ΑΠΑΝΤΗΣΗED TIME | PHONE NUMBER |\n";
		$carrier_rpt.="+----------------------+---------------------+-----------------+-----------+--------------+-------------+------------------------------------------+-----------+---------------+--------------+\n";
		$CSV_text="\"UNIQUE ID\",\"CALL DATE\",\"ΔΙΑΚΟΜΙΣΤΗΣ IP\",\"LEAD ID\",\"HANGUP CAUSE\",\"DIAL STATUS\",\"CHANNEL\",\"DIAL TIME\",\"ΑΠΑΝΤΗΣΗED TIME\",\"PHONE NUMBER\"\n";

		for ($i=1; $i<=mysql_num_rows($rpt_rslt); $i++) {
			$row=mysql_fetch_array($rpt_rslt);
			$phone_number=""; $phone_note="";

			if (strlen($row["phone_number"])==0) {
				$stmt2="select phone_number, alt_phone, address3 from vicidial_list where lead_id='$row[lead_id]'";
				$rslt2=mysql_query($stmt2, $link);
				$channel=$row["channel"];
				while ($row2=mysql_fetch_array($rslt2)) {
					if (strlen($row2["alt_phone"])>=7 && preg_match("/$row2[alt_phone]/", $channel)) {$phone_number=$row2["alt_phone"]; $phone_note="ALT";}
					else if (strlen($row2["address3"])>=7 && preg_match("/$row2[address3]/", $channel)) {$phone_number=$row2["address3"]; $phone_note="ADDR3";}
					else if (strlen($row2["phone_number"])>=7 && preg_match("/$row2[phone_number]/", $channel)) {$phone_number=$row2["phone_number"]; $phone_note="*";}
				}
			} else {
				$phone_number=$row["phone_number"];
			}

			$CSV_text.="\"$row[uniqueid]\",\"$row[call_date]\",\"$row[server_ip]\",\"$row[lead_id]\",\"$row[hangup_cause]\",\"$row[dialstatus]\",\"$row[channel]\",\"$row[dial_time]\",\"$row[answered_time]\",\"$phone_number\"\n";
			if ($i>=$lower_limit && $i<=$upper_limit) {
				if (strlen($row["channel"])>37) {$row["channel"]=substr($row["channel"],0,37)."...";}
				$carrier_rpt.="| ".sprintf("%-21s", $row["uniqueid"]); 
				$carrier_rpt.="| ".sprintf("%-20s", $row["call_date"]); 
				$carrier_rpt.="| ".sprintf("%-16s", $row["server_ip"]); 
				$carrier_rpt.="| ".sprintf("%-10s", $row["lead_id"]); 
				$carrier_rpt.="| ".sprintf("%-13s", $row["hangup_cause"]); 
				$carrier_rpt.="| ".sprintf("%-12s", $row["dialstatus"]); 
				$carrier_rpt.="| ".sprintf("%-41s", $row["channel"]); 
				$carrier_rpt.="| ".sprintf("%-10s", $row["dial_time"]); 
				$carrier_rpt.="| ".sprintf("%-14s", $row["answered_time"]); 
				$carrier_rpt.="| ".sprintf("%-13s", $phone_number)."|\n"; 
			}
		}
		$carrier_rpt.="+----------------------+---------------------+-----------------+-----------+--------------+-------------+------------------------------------------+-----------+---------------+--------------+\n";

		$carrier_rpt_hf="";
		$ll=$lower_limit-1000;
		if ($ll>=1) {
			$carrier_rpt_hf.="<a href=\"$PHP_SELF?ΕΠΙΒΕΒΑΙΩΣΗ=$ΕΠΙΒΕΒΑΙΩΣΗ&DB=$DB&type=$type&query_date=$query_date&query_date_D=$query_date_D&query_date_T=$query_date_T$hangup_causeQS$server_ipQS&lower_limit=$ll\">[<<< PREV 1000 records]</a>";
		} else {
			$carrier_rpt_hf.=sprintf("%-23s", " ");
		}
		$carrier_rpt_hf.=sprintf("%-145s", " ");
		if (($lower_limit+1000)<mysql_num_rows($rpt_rslt)) {
			if ($upper_limit+1000>=mysql_num_rows($rpt_rslt)) {$max_limit=mysql_num_rows($rpt_rslt)-$upper_limit;} else {$max_limit=1000;}
			$carrier_rpt_hf.="<a href=\"$PHP_SELF?ΕΠΙΒΕΒΑΙΩΣΗ=$ΕΠΙΒΕΒΑΙΩΣΗ&DB=$DB&type=$type&query_date=$query_date&query_date_D=$query_date_D&query_date_T=$query_date_T$server_ipQS$hangup_causeQS&lower_limit=".($lower_limit+1000)."\">[NEXT $max_limit records >>>]</a>";
		} else {
			$carrier_rpt_hf.=sprintf("%23s", " ");
		}
		$carrier_rpt_hf.="\n";
		$MAIN.=$carrier_rpt_hf.$carrier_rpt.$carrier_rpt_hf;
	} else {
		$MAIN.="*** NO RECORDS FOUND ***\n";
	}
	$MAIN.="</font></PRE>\n";

	$MAIN.="</form></BODY></HTML>\n";


}
	if ($file_download>0) {
		$FILE_TIME = date("Ymd-His");
		$CSVfilename = "AST_carrier_log_report_$US$FILE_TIME.csv";
		$CSV_text=preg_replace('/ +\"/', '"', $CSV_text);
		$CSV_text=preg_replace('/\" +/', '"', $CSV_text);
		// We'll be outputting a TXT file
		header('Content-type: application/octet-stream');

		// It will be called LIST_101_20090209-121212.txt
		header("Content-Disposition: attachment; filename=\"$CSVfilename\"");
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		ob_clean();
		flush();

		echo "$CSV_text";

		exit;
	} else {
		echo $HEADER;
		require("admin_header.php");
		echo $MAIN;
	}

?>
