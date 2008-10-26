<?
# admin_search_lead.php
# 
# Copyright (C) 2008  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# AST GUI database administration search for lead info
# admin_modify_lead.php
#
# this is the administration lead information modifier screen, the administrator 
# just needs to enter the leadID and then they can view and modify the information
# in the record for that lead
#
# changes:
# 60620-1055 - Added variable filtering to eliminate SQL injection attack threat
#            - Added required user/pass to gain access to this page
#            - Changed results to multi-record
# 80710-0023 - Added searching by list, user, status
#

require("dbconnect.php");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
if (isset($_GET["vendor_id"]))			{$vendor_id=$_GET["vendor_id"];}
	elseif (isset($_POST["vendor_id"]))	{$vendor_id=$_POST["vendor_id"];}
if (isset($_GET["phone"]))				{$phone=$_GET["phone"];}
	elseif (isset($_POST["phone"]))		{$phone=$_POST["phone"];}
if (isset($_GET["lead_id"]))			{$lead_id=$_GET["lead_id"];}
	elseif (isset($_POST["lead_id"]))	{$lead_id=$_POST["lead_id"];}
if (isset($_GET["submit"]))				{$submit=$_GET["submit"];}
	elseif (isset($_POST["submit"]))	{$submit=$_POST["submit"];}
if (isset($_GET["INVIA"]))				{$INVIA=$_GET["INVIA"];}
	elseif (isset($_POST["INVIA"]))	{$INVIA=$_POST["INVIA"];}
if (isset($_GET["DB"]))					{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))		{$DB=$_POST["DB"];}
if (isset($_GET["status"]))				{$status=$_GET["status"];}
	elseif (isset($_POST["status"]))	{$status=$_POST["status"];}
if (isset($_GET["user"]))				{$user=$_GET["user"];}
	elseif (isset($_POST["user"]))		{$user=$_POST["user"];}
if (isset($_GET["list_id"]))			{$list_id=$_GET["list_id"];}
	elseif (isset($_POST["list_id"]))	{$list_id=$_POST["list_id"];}

$PHP_AUTH_USER = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_USER);
$PHP_AUTH_PW = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_PW);

$STARTtime = date("U");
$TODAY = date("Y-m-d");
$NOW_TIME = date("Y-m-d H:i:s");


	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level > 7 and modify_leads='1';";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$auth=$row[0];

if ($WeBRooTWritablE > 0)
	{$fp = fopen ("./project_auth_entries.txt", "a");}

$date = date("r");
$ip = getenv("REMOTE_ADDR");
$browser = getenv("HTTP_USER_AGENT");

  if( (strlen($PHP_AUTH_USER)<2) or (strlen($PHP_AUTH_PW)<2) or (!$auth))
	{
    Header("WWW-Authenticate: Basic realm=\"VICI-PROJECTS\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "Username/Password non validi: |$PHP_AUTH_USER|$PHP_AUTH_PW|\n";
    exit;
	}
  else
	{

	if($auth>0)
		{
		$office_no=strtoupper($PHP_AUTH_USER);
		$password=strtoupper($PHP_AUTH_PW);
			$stmt="SELECT full_name,modify_leads from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW'";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			$LOGfullname				=$row[0];
			$LOGmodify_leads			=$row[1];

		if ($WeBRooTWritablE > 0)
			{
			fwrite ($fp, "VICIDIAL|GOOD|$date|$PHP_AUTH_USER|$PHP_AUTH_PW|$ip|$browser|$LOGfullname|\n");
			fclose($fp);
			}
		}
	else
		{
		if ($WeBRooTWritablE > 0)
			{
			fwrite ($fp, "VICIDIAL|FAIL|$date|$PHP_AUTH_USER|$PHP_AUTH_PW|$ip|$browser|\n");
			fclose($fp);
			}
		}
	}

?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<title>VICIDIAL ADMIN: Ricerca Contatti</title>
</head>
<title>Operaciones de búsqueda del Lead</title>
</head>
<body bgcolor=white>
<? 
echo "<a href=\"./admin.php?ADD=100\">VICIDIAL ADMIN</a>: Lead search<BR>\n";


if ( (!$vendor_id) and (!$phone)  and (!$lead_id) and ( (strlen($status)<1) and (strlen($list_id)<1) and (strlen($user)<1) )) 
	{
	echo date("l F j, Y G:i:s A");
	echo "\n<br><br><center>\n";
	echo "<form method=post name=search action=\"$PHP_SELF\">\n";
	echo "<input type=hidden name=DB value=\"$DB\">\n";
	echo "<b>Per favore, inserisci:<br> Vendor ID(co`digo del vendedor del Lead): <input type=text name=vendor_id size=10 maxlength=10> or \n";
	echo "<br><b>un numero di telefono: <input type=text name=phone size=20 maxlength=16> or\n";
	echo "<br><b>un ID Contatto: <input type=text name=lead_id size=10 maxlength=10> or\n";
	echo "<br><b>esito: <input type=text name=status size=7 maxlength=6> &nbsp; \n";
	echo "<b>list ID: <input type=text name=list_id size=15 maxlength=14> &nbsp; \n";
	echo "<b>user: <input type=text name=user size=15 maxlength=20> <br><br>\n";
	echo "<input type=submit name=submit value=INVIA></b>\n";
	echo "</form>\n</center>\n";
	echo "</body></html>\n";
	exit;
	}

else
	{

	if ($vendor_id)
		{
		$stmt="SELECT * from vicidial_list where vendor_lead_code='" . mysql_real_escape_string($vendor_id) . "' order by modify_date desc limit 1000";
		}
	else
		{
		if ($phone)
			{
			$stmt="SELECT * from vicidial_list where phone_number='" . mysql_real_escape_string($phone) . "' order by modify_date desc limit 1000";
			}
		else
			{
			if ($lead_id)
				{
				$stmt="SELECT * from vicidial_list where lead_id='" . mysql_real_escape_string($lead_id) . "' order by modify_date desc limit 1000";
				}
			else
				{
				if ( (strlen($status)>0) or (strlen($list_id)>0) or (strlen($user)>0) )
					{
					$statusSQL = '';
					$list_idSQL = '';
					$userSQL = '';
					if (strlen($status)>0)	
						{
						$statusSQL = "status='" . mysql_real_escape_string($status) . "'"; $SQLctA++;
						}
					if (strlen($list_id)>0) 
						{
						if ($SQLctA > 0) {$andA = 'and';}
						$list_idSQL = "$andA list_id='" . mysql_real_escape_string($list_id) . "'"; $SQLctB++;
						}
					if (strlen($user)>0)	
						{
						if ( ($SQLctA > 0) or ($SQLctB > 0) ) {$andB = 'and';}
						$userSQL = "$andB user='" . mysql_real_escape_string($user) . "'";
						}
					$stmt="SELECT * from vicidial_list where $statusSQL $list_idSQL $userSQL order by modify_date desc limit 1000";
					}
				else
					{
					print "ERROR: you must search for something! Go back and search for something";
					exit;
					}
				}
			}
		}
	if ($DB)
		{
		echo "\n\n$stmt\n\n";
		}
	
	$rslt=mysql_query($stmt, $link);
	$results_to_print = mysql_num_rows($rslt);
	if ($results_to_print < 1)
		{
		echo date("l F j, Y G:i:s A");
		echo "\n<br><br><center>\n";
		echo "<b>Le variabili di ricerca inserite non sono attive in questo sistema</b><br><br>\n";
		echo "<b>Per favore torna indietro e controlla di nuovo le informazioni inserite, quindi reinviale di nuovo</b>\n";
		echo "</center>\n";
		echo "</body></html>\n";
		exit;
		}
	else
		{
		echo "<b>RESULTS: $results_to_print</b><BR><BR>\n";
		echo "<TABLE BGCOLOR=WHITE CELLPADDING=1 CELLSPACING=0>\n";
		echo "<TR BGCOLOR=BLACK>\n";
		echo "<TD ALIGN=LEFT><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>#</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>LEAD ID</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>ESITO</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>VENDOR ID</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>LAST AGENT</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>ID LISTA</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>PHONE</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>NOME</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>CITY</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>SECURITY</B></FONT></TD>\n";
		echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" COLOR=WHITE><B>LAST CALL</B></FONT></TD>\n";
		echo "</TR>\n";
		$o=0;
		while ($results_to_print > $o)
			{
			$row=mysql_fetch_row($rslt);
			$o++;
			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}
			echo "<TR $bgcolor>\n";
			echo "<TD ALIGN=LEFT><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$o</FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1><a href=\"admin_modify_lead.php?lead_id=$row[0]\" target=\"_blank\">$row[0]</a></FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$row[3]</FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$row[5]</FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$row[4]</FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$row[7]</FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$row[11]</FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$row[13] $row[15]</FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$row[19]</FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$row[28]</FONT></TD>\n";
			echo "<TD ALIGN=CENTER><FONT FACE=\"ARIAL,HELVETICA\" SIZE=1>$row[2]</FONT></TD>\n";
			echo "</TR>\n";
			}
		echo "</TABLE>\n";
		}		
	}




$ENDtime = date("U");

$RUNtime = ($ENDtime - $STARTtime);

echo "\n\n\n<br><br><br>\n<a href=\"$PHP_SELF\">NUOVA RICERCA</a>";


echo "\n\n\n<br><br><br>\nTempo Esecuzione Script: $RUNtime seconds";


?>



</body>
</html>
