#!/usr/bin/perl
#
# ADMIN_keepalive_ALL.pl   version  2.2.0
#
# Designed to keep the astGUIclient processes alive and check every minute
# Replaces all other ADMIN_keepalive scripts
# Uses /etc/astguiclient.conf file to know which processes to keepalive
# Also, this script generates Asterisk conf files and reloads Asterisk
#
# Copyright (C) 2009  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# CHANGES
# 61011-1348 - First build
# 61120-2011 - Added option 7 for AST_VDauto_dial_FILL.pl
# 80227-1526 - Added option 8 for ip_relay
# 80526-1350 - Added option 9 for timeclock auto-logout
# 90211-1236 - Added auto-generation of conf files functions
# 90213-0625 - Separated the reloading of Asterisk into 4 separate steps
# 90325-2239 - Rewrote sending of reload commands to Asterisk
# 90327-1421 - Removed [globals] tag from auto-generated extensions file
# 90409-1251 - Fixed voicemail conf file issue
# 90506-1155 - Added Call Menu functionality
# 90513-0449 - Added audio store sync functionality
# 90519-1018 - Added upload file trigger for prompt recording if defined as voicemail server and voicemail/prompt recording extensions auto-generated
# 90529-0652 - Added phone_context and fixed calledid and voicemail for phones entries
# 90614-0753 - Added in-group routing to call menu feature
# 90617-0821 - Added phone ring timeout and call menu custom dialplan entry
#

$DB=0; # Debug flag
$MT[0]='';   $MT[1]='';
@psline=@MT;

### begin parsing run-time options ###
if (length($ARGV[0])>1)
{
	$i=0;
	while ($#ARGV >= $i)
	{
	$args = "$args $ARGV[$i]";
	$i++;
	}

	if ($args =~ /--help/i)
	{
	print "allowed run time options:\n  [-t] = test\n  [-debug] = verbose debug messages\n[-debugX] = Extra-verbose debug messages\n\n";
	}
	else
	{
		if ($args =~ /-debug/i)
		{
		$DB=1; # Debug flag
		}
		if ($args =~ /--debugX/i)
		{
		$DBX=1;
		print "\n----- SUPER-DUPER DEBUGGING -----\n\n";
		}
		if ($args =~ /-t/i)
		{
		$TEST=1;
		$T=1;
		}
	}
}
else
{
#	print "no command line options set\n";
}
### end parsing run-time options ###


# default path to astguiclient configuration file:
$PATHconf =		'/etc/astguiclient.conf';

open(conf, "$PATHconf") || die "can't open $PATHconf: $!\n";
@conf = <conf>;
close(conf);
$i=0;
foreach(@conf)
	{
	$line = $conf[$i];
	$line =~ s/ |>|\n|\r|\t|\#.*|;.*//gi;
	if ( ($line =~ /^PATHhome/) && ($CLIhome < 1) )
		{$PATHhome = $line;   $PATHhome =~ s/.*=//gi;}
	if ( ($line =~ /^VARactive_keepalives/) && ($CLIactive_keepalives < 1) )
		{$VARactive_keepalives = $line;   $VARactive_keepalives =~ s/.*=//gi;}
	$i++;
	}

##### list of codes for active_keepalives and what processes they correspond to
#	X - NO KEEPALIVE PROCESSES (use only if you want none to be keepalive)\n";
#	1 - AST_update\n";
#	2 - AST_send_listen\n";
#	3 - AST_VDauto_dial\n";
#	4 - AST_VDremote_agents\n";
#	5 - AST_VDadapt (If multi-server system, this must only be on one server)\n";
#	6 - FastAGI_log\n";
#	7 - AST_VDauto_dial_FILL\n";
#	8 - ip_relay for blind monitoring\n";
#	9 - Timeclock auto logout\n";

if ($VARactive_keepalives =~ /X/)
	{
	if ($DB) {print "X in active_keepalives, exiting...\n";}
	exit;
	}

$AST_update=0;
$AST_send_listen=0;
$AST_VDauto_dial=0;
$AST_VDremote_agents=0;
$AST_VDadapt=0;
$FastAGI_log=0;
$AST_VDauto_dial_FILL=0;
$ip_relay=0;
$timeclock_auto_logout=0;
$runningAST_update=0;
$runningAST_send=0;
$runningAST_listen=0;
$runningAST_VDauto_dial=0;
$runningAST_VDremote_agents=0;
$runningAST_VDadapt=0;
$runningFastAGI_log=0;
$runningAST_VDauto_dial_FILL=0;
$runningip_relay=0;

if ($VARactive_keepalives =~ /1/) 
	{
	$AST_update=1;
	if ($DB) {print "AST_update set to keepalive\n";}
	}
if ($VARactive_keepalives =~ /2/) 
	{
	$AST_send_listen=1;
	if ($DB) {print "AST_send_listen set to keepalive\n";}
	}
if ($VARactive_keepalives =~ /3/) 
	{
	$AST_VDauto_dial=1;
	if ($DB) {print "AST_VDauto_dial set to keepalive\n";}
	}
if ($VARactive_keepalives =~ /4/) 
	{
	$AST_VDremote_agents=1;
	if ($DB) {print "AST_VDremote_agents set to keepalive\n";}
	}
if ($VARactive_keepalives =~ /5/) 
	{
	$AST_VDadapt=1;
	if ($DB) {print "AST_VDadapt set to keepalive\n";}
	}
if ($VARactive_keepalives =~ /6/) 
	{
	$FastAGI_log=1;
	if ($DB) {print "FastAGI_log set to keepalive\n";}
	}
if ($VARactive_keepalives =~ /7/) 
	{
	$AST_VDauto_dial_FILL=1;
	if ($DB) {print "AST_VDauto_dial_FILL set to keepalive\n";}
	}
if ($VARactive_keepalives =~ /8/) 
	{
	$ip_relay=1;
	if ($DB) {print "ip_relay set to keepalive\n";}
	}
if ($VARactive_keepalives =~ /9/) 
	{
	$timeclock_auto_logout=1;
	if ($DB) {print "Check to see if Timeclock auto logout should run\n";}
	}

$REGhome = $PATHhome;
$REGhome =~ s/\//\\\//gi;






##### First, check and see which processes are running #####

### you may have to use a different ps command if you're not using Slackware Linux
#	@psoutput = `ps -f -C AST_update --no-headers`;
#	@psoutput = `ps -f -C AST_updat* --no-headers`;
#	@psoutput = `/bin/ps -f --no-headers -A`;
#	@psoutput = `/bin/ps -o pid,args -A`; ### use this one for FreeBSD
@psoutput = `/bin/ps -o "%p %a" --no-headers -A`;

$i=0;
foreach (@psoutput)
{
chomp($psoutput[$i]);
if ($DBX) {print "$i|$psoutput[$i]|     \n";}
@psline = split(/\/usr\/bin\/perl /,$psoutput[$i]);

	if ($psline[1] =~ /$REGhome\/AST_update\.pl/) 
		{
		$runningAST_update++;
		if ($DB) {print "AST_update RUNNING:              |$psline[1]|\n";}
		}
	if ($psline[1] =~ /AST_manager_se/) 
		{
		$runningAST_send++;
		if ($DB) {print "AST_send RUNNING:                |$psline[1]|\n";}
		}
	if ($psline[1] =~ /AST_manager_li/) 
		{
		$psoutput[$i] =~ s/ .*|\n|\r|\t| //gi;
		$listen_pid[$runningAST_listen] = $psoutput[$i];
		$runningAST_listen++;
		if ($DB) {print "AST_listen RUNNING:              |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/AST_VDauto_dial\.pl/) 
		{
		$runningAST_VDauto_dial++;
		if ($DB) {print "AST_VDauto_dial RUNNING:         |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/AST_VDremote_agents\.pl/) 
		{
		$runningAST_VDremote_agents++;
		if ($DB) {print "AST_VDremote_agents RUNNING:     |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/AST_VDadapt\.pl/) 
		{
		$runningAST_VDadapt++;
		if ($DB) {print "AST_VDadapt RUNNING:             |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/FastAGI_log\.pl/) 
		{
		$runningFastAGI_log++;
		if ($DB) {print "FastAGI_log RUNNING:             |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/AST_VDauto_dial_FILL\.pl/) 
		{
		$runningAST_VDauto_dial_FILL++;
		if ($DB) {print "AST_VDauto_dial_FILL RUNNING:    |$psline[1]|\n";}
		}
	if ($psoutput[$i] =~ / ip_relay /) 
		{
		$runningip_relay++;
		if ($DB) {print "ip_relay RUNNING:                |$psoutput[$i]|\n";}
		}
$i++;
}





##### Second, IF MORE THAN ONE LISTEN INSTANCE IS RUNNING, KILL THE SECOND ONE #####
@psline=@MT;
@psoutput=@MT;
@listen_pid=@MT;
if ($runningAST_listen > 1)
{
$runningAST_listen=0;

	sleep(1);

### you may have to use a different ps command if you're not using Slackware Linux
#	@psoutput = `ps -f -C AST_update --no-headers`;
#	@psoutput = `ps -f -C AST_updat* --no-headers`;
#	@psoutput = `/bin/ps -f --no-headers -A`;
#	@psoutput = `/bin/ps -o pid,args -A`; ### use this one for FreeBSD
@psoutput = `/bin/ps -o "%p %a" --no-headers -A`;

$i=0;
foreach (@psoutput)
	{
		chomp($psoutput[$i]);
	if ($DBX) {print "$i|$psoutput[$i]|     \n";}
	@psline = split(/\/usr\/bin\/perl /,$psoutput[$i]);
	$psoutput[$i] =~ s/^ *//gi;
	$psoutput[$i] =~ s/ .*|\n|\r|\t| //gi;

	if ($psline[1] =~ /AST_manager_li/) 
		{
		$listen_pid[$runningAST_listen] = $psoutput[$i];
		if ($DB) {print "AST_listen RUNNING:              |$psline[1]|$listen_pid[$runningAST_listen]|\n";}
		$runningAST_listen++;
		}

	$i++;
	}

if ($runningAST_listen > 1)
	{
	if ($DB) {print "Killing AST_manager_listen... |$listen_pid[1]|\n";}
	`/bin/kill -s 9 $listen_pid[1]`;
	}
}







##### Third, double-check that non-running scripts are not running #####
@psline=@MT;
@psoutput=@MT;

if ( 
	( ($AST_update > 0) && ($runningAST_update < 1) ) ||
	( ($AST_send_listen > 0) && ($runningAST_send < 1) ) ||
	( ($AST_send_listen > 0) && ($runningAST_listen < 1) ) ||
	( ($AST_VDauto_dial > 0) && ($runningAST_VDauto_dial < 1) ) ||
	( ($AST_VDremote_agents > 0) && ($runningAST_VDremote_agents < 1) ) ||
	( ($AST_VDadapt > 0) && ($runningAST_VDadapt < 1) ) ||
	( ($FastAGI_log > 0) && ($runningFastAGI_log < 1) ) ||
	( ($AST_VDauto_dial_FILL > 0) && ($runningAST_VDauto_dial_FILL < 1) ) ||
	( ($ip_relay > 0) && ($runningip_relay < 1) )
   )
{

if ($DB) {print "double check that processes are not running...\n";}

	sleep(1);

`PERL5LIB="$PATHhome/libs"; export PERL5LIB`;
### you may have to use a different ps command if you're not using Slackware Linux
#	@psoutput = `ps -f -C AST_update --no-headers`;
#	@psoutput = `ps -f -C AST_updat* --no-headers`;
#	@psoutput = `/bin/ps -f --no-headers -A`;
#	@psoutput = `/bin/ps -o pid,args -A`; ### use this one for FreeBSD
@psoutput2 = `/bin/ps -o "%p %a" --no-headers -A`;
$i=0;
foreach (@psoutput2)
	{
		chomp($psoutput2[$i]);
	if ($DBX) {print "$i|$psoutput2[$i]|     \n";}
	@psline = split(/\/usr\/bin\/perl /,$psoutput2[$i]);

	if ($psline[1] =~ /$REGhome\/AST_update\.pl/) 
		{
		$runningAST_update++;
		if ($DB) {print "AST_update RUNNING:              |$psline[1]|\n";}
		}
	if ($psline[1] =~ /AST_manager_se/) 
		{
		$runningAST_send++;
		if ($DB) {print "AST_send RUNNING:                |$psline[1]|\n";}
		}
	if ($psline[1] =~ /AST_manager_li/) 
		{
		$runningAST_listen++;
		if ($DB) {print "AST_listen RUNNING:              |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/AST_VDauto_dial\.pl/) 
		{
		$runningAST_VDauto_dial++;
		if ($DB) {print "AST_VDauto_dial RUNNING:         |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/AST_VDremote_agents\.pl/) 
		{
		$runningAST_VDremote_agents++;
		if ($DB) {print "AST_VDremote_agents RUNNING:     |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/AST_VDadapt\.pl/) 
		{
		$runningAST_VDadapt++;
		if ($DB) {print "AST_VDadapt RUNNING:             |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/FastAGI_log\.pl/) 
		{
		$runningFastAGI_log++;
		if ($DB) {print "FastAGI_log RUNNING:             |$psline[1]|\n";}
		}
	if ($psline[1] =~ /$REGhome\/AST_VDauto_dial_FILL\.pl/) 
		{
		$runningAST_VDauto_dial_FILL++;
		if ($DB) {print "AST_VDauto_dial_FILL RUNNING:    |$psline[1]|\n";}
		}
	if ($psoutput2[$i] =~ / ip_relay /) 
		{
		$runningip_relay++;
		if ($DB) {print "ip_relay RUNNING:                |$psoutput2[$i]|\n";}
		}
	$i++;
	}


if ( ($AST_update > 0) && ($runningAST_update < 1) )
	{ 
	if ($DB) {print "starting AST_update...\n";}
	# add a '-L' to the command below to activate logging
	`/usr/bin/screen -d -m -S ASTupdate $PATHhome/AST_update.pl`;
	}
if ( ($AST_send_listen > 0) && ($runningAST_send < 1) )
	{ 
	if ($DB) {print "starting AST_manager_send...\n";}
	# add a '-L' to the command below to activate logging
	`/usr/bin/screen -d -m -S ASTsend $PATHhome/AST_manager_send.pl`;
	}
if ( ($AST_send_listen > 0) && ($runningAST_listen < 1) )
	{ 
	if ($DB) {print "starting AST_manager_listen...\n";}
	# add a '-L' to the command below to activate logging
	`/usr/bin/screen -d -m -S ASTlisten $PATHhome/AST_manager_listen.pl`;
	}
if ( ($AST_VDauto_dial > 0) && ($runningAST_VDauto_dial < 1) )
	{ 
	if ($DB) {print "starting AST_VDauto_dial...\n";}
	# add a '-L' to the command below to activate logging
	`/usr/bin/screen -d -m -S ASTVDauto $PATHhome/AST_VDauto_dial.pl`;
	}
if ( ($AST_VDremote_agents > 0) && ($runningAST_VDremote_agents < 1) )
	{ 
	if ($DB) {print "starting AST_VDremote_agents...\n";}
	# add a '-L' to the command below to activate logging
	`/usr/bin/screen -d -m -S ASTVDremote $PATHhome/AST_VDremote_agents.pl`;
	}
if ( ($AST_VDadapt > 0) && ($runningAST_VDadapt < 1) )
	{ 
	if ($DB) {print "starting AST_VDadapt...\n";}
	# add a '-L' to the command below to activate logging
	`/usr/bin/screen -d -m -S ASTVDadapt $PATHhome/AST_VDadapt.pl --debug`;
	}
if ( ($FastAGI_log > 0) && ($runningFastAGI_log < 1) )
	{ 
	if ($DB) {print "starting FastAGI_log...\n";}
	# add a '-L' to the command below to activate logging
	`/usr/bin/screen -d -m -S ASTfastlog $PATHhome/FastAGI_log.pl --debug`;
	}
if ( ($AST_VDauto_dial_FILL > 0) && ($runningAST_VDauto_dial_FILL < 1) )
	{ 
	if ($DB) {print "starting AST_VDauto_dial_FILL...\n";}
	# add a '-L' to the command below to activate logging
	`/usr/bin/screen -d -m -S ASTVDautoFILL $PATHhome/AST_VDauto_dial_FILL.pl`;
	}
if ( ($ip_relay > 0) && ($runningip_relay < 1) )
	{ 
	if ($DB) {print "starting ip_relay through relay_control...\n";}
	`$PATHhome/ip_relay/relay_control start  2>/dev/null 1>&2`;
	}
}



### run the Timeclock auto-logout process ###
if ($timeclock_auto_logout > 0)
	{
	if ($DB) {print "running Timeclock auto-logout process...\n";}
	`/usr/bin/screen -d -m -S Timeclock $PATHhome/ADMIN_timeclock_auto_logout.pl 2>/dev/null 1>&2`;
	}
################################################################################
#####  END keepalive of ViciDial-related scripts
################################################################################








################################################################################
#####  START Creation of auto-generated conf files
################################################################################

# default path to astguiclient configuration file:
$PATHconf =		'/etc/astguiclient.conf';

open(conf, "$PATHconf") || die "can't open $PATHconf: $!\n";
@conf = <conf>;
close(conf);
$i=0;
foreach(@conf)
	{
	$line = $conf[$i];
	$line =~ s/ |>|\n|\r|\t|\#.*|;.*//gi;
	if ( ($line =~ /^PATHlogs/) && ($CLIlogs < 1) )
		{$PATHlogs = $line;   $PATHlogs =~ s/.*=//gi;}
	if ( ($line =~ /^PATHsounds/) && ($CLIsounds < 1) )
		{$PATHsounds = $line;   $PATHsounds =~ s/.*=//gi;}
	if ( ($line =~ /^VARserver_ip/) && ($CLIserver_ip < 1) )
		{$VARserver_ip = $line;   $VARserver_ip =~ s/.*=//gi;}
	if ( ($line =~ /^VARDB_server/) && ($CLIDB_server < 1) )
		{$VARDB_server = $line;   $VARDB_server =~ s/.*=//gi;}
	if ( ($line =~ /^VARDB_database/) && ($CLIDB_database < 1) )
		{$VARDB_database = $line;   $VARDB_database =~ s/.*=//gi;}
	if ( ($line =~ /^VARDB_user/) && ($CLIDB_user < 1) )
		{$VARDB_user = $line;   $VARDB_user =~ s/.*=//gi;}
	if ( ($line =~ /^VARDB_pass/) && ($CLIDB_pass < 1) )
		{$VARDB_pass = $line;   $VARDB_pass =~ s/.*=//gi;}
	if ( ($line =~ /^VARDB_port/) && ($CLIDB_port < 1) )
		{$VARDB_port = $line;   $VARDB_port =~ s/.*=//gi;}
	$i++;
	}

# Customized Variables
$server_ip = $VARserver_ip;		# Asterisk server IP
$THISserver_voicemail=0;
$voicemail_server_id='';
if (!$VARDB_port) {$VARDB_port='3306';}

use DBI;	  

$dbhA = DBI->connect("DBI:mysql:$VARDB_database:$VARDB_server:$VARDB_port", "$VARDB_user", "$VARDB_pass")
 or die "Couldn't connect to database: " . DBI->errstr;

##### Get the settings from system_settings #####
$stmtA = "SELECT sounds_central_control_active,active_voicemail_server FROM system_settings;";
#	print "$stmtA\n";
$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
$sthArows=$sthA->rows;
if ($sthArows > 0)
	{
	@aryA = $sthA->fetchrow_array;
	$sounds_central_control_active =	"$aryA[0]";
	$active_voicemail_server =			"$aryA[1]";
	}
$sthA->finish();
if ( ($active_voicemail_server =~ /$server_ip/) && ((length($active_voicemail_server)) eq (length($server_ip))) )
	{$THISserver_voicemail=1;}
else
	{
	$stmtA = "SELECT server_id FROM servers,system_settings where servers.server_ip=system_settings.active_voicemail_server;";
	#	print "$stmtA\n";
	$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
	$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
	$sthArows=$sthA->rows;
	if ($sthArows > 0)
		{
		@aryA = $sthA->fetchrow_array;
		$voicemail_server_id	=	$aryA[0];
		}
	$sthA->finish();
	}

##### Get the settings for this server's server_ip #####
$stmtA = "SELECT active_asterisk_server,generate_vicidial_conf,rebuild_conf_files,asterisk_version,sounds_update FROM servers where server_ip='$server_ip';";
#	print "$stmtA\n";
$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
$sthArows=$sthA->rows;
if ($sthArows > 0)
	{
	@aryA = $sthA->fetchrow_array;
	$active_asterisk_server	=	$aryA[0];
	$generate_vicidial_conf	=	$aryA[1];
	$rebuild_conf_files	=		$aryA[2];
	$asterisk_version =			$aryA[3];
	$sounds_update =			$aryA[4];
	}
$sthA->finish();


if ( ($active_asterisk_server =~ /Y/) && ($generate_vicidial_conf =~ /Y/) && ($rebuild_conf_files =~ /Y/) ) 
	{
	if ($DB) {print "generating new auto-gen conf files\n";}

	$stmtA="UPDATE servers SET rebuild_conf_files='N' where server_ip='$server_ip';";
	$affected_rows = $dbhA->do($stmtA);

	### format the new server_ip dialstring for example to use with extensions.conf
	$S='*';
	if( $VARserver_ip =~ m/(\S+)\.(\S+)\.(\S+)\.(\S+)/ )
		{
		$a = leading_zero($1); 
		$b = leading_zero($2); 
		$c = leading_zero($3); 
		$d = leading_zero($4);
		$VARremDIALstr = "$a$S$b$S$c$S$d";
		}

	$Lext  = "\n";
	$Lext .= "; Local Server: $server_ip\n";
	$Lext .= "exten => _$VARremDIALstr*.,1,Goto(default,\${EXTEN:16},1)\n";

	##### Get the server_id for this server's server_ip #####
	$stmtA = "SELECT server_id,vicidial_recording_limit FROM servers where server_ip='$server_ip';";
	#	print "$stmtA\n";
	$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
	$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
	$sthArows=$sthA->rows;
	if ($sthArows > 0)
		{
		@aryA = $sthA->fetchrow_array;
		$server_id	=					"$aryA[0]";
		$vicidial_recording_limit =		(60 * $aryA[1]);
		$i++;
		}
	$sthA->finish();

	##### Get the server_ips and server_ids of all VICIDIAL servers on the network #####
	$stmtA = "SELECT server_ip,server_id FROM servers where server_ip!='$server_ip' and active_asterisk_server='Y' order by server_ip;";
	#	print "$stmtA\n";
	$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
	$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
	$sthArows=$sthA->rows;
	$i=0;
	while ($sthArows > $i)
		{
		@aryA = $sthA->fetchrow_array;
		$server_ip[$i]	=	"$aryA[0]";
		$server_id[$i]	=	"$aryA[1]";

		if( $server_ip[$i] =~ m/(\S+)\.(\S+)\.(\S+)\.(\S+)/ )
			{
			$a = leading_zero($1); 
			$b = leading_zero($2); 
			$c = leading_zero($3); 
			$d = leading_zero($4);
			$VARremDIALstr = "$a$S$b$S$c$S$d";
			}
		$ext  .= "TRUNK$server_id[$i] = IAX2/$server_id:test\@$server_ip[$i]:4569\n";

		$iax  .= "register => $server_id:test\@$server_ip[$i]:4569\n";

		$Lext .= "; Remote Server VDAD extens: $server_id[$i] $server_ip[$i]\n";
		$Lext .= "exten => _$VARremDIALstr*.,1,Dial(\${TRUNK$server_id[$i]}/\${EXTEN:16},55,oT)\n";

		$Liax .= "\n";
		$Liax .= "[$server_id[$i]]\n";
		$Liax .= "accountcode=IAX$server_id[$i]\n";
		$Liax .= "secret=test\n";
		$Liax .= "type=friend\n";
		$Liax .= "context=default\n";
		$Liax .= "auth=plaintext\n";
		$Liax .= "host=dynamic\n";
		$Liax .= "permit=0.0.0.0/0.0.0.0\n";
		$Liax .= "disallow=all\n";
		$Liax .= "allow=ulaw\n";
		$Liax .= "qualify=yes\n";

		$i++;
		}
	$sthA->finish();

	##### Create Voicemail extensions for this server_ip
	if ( ($THISserver_voicemail > 0) || (length($voicemail_server_id) < 1) )
		{
		$Vext .= "; Voicemail Extensions:\n";
		$Vext .= "exten => _85026666666666.,1,Wait(1)\n";
		$Vext .= "exten => _85026666666666.,2,Voicemail(\${EXTEN:14}|u)\n";
		$Vext .= "exten => _85026666666666.,3,Hangup\n";
		$Vext .= "exten => 8500,1,VoicemailMain\n";
		$Vext .= "exten => 8500,2,Goto(s,6)\n";
		if ($asterisk_version =~ /^1.2/)
			{$Vext .= "exten => 8501,1,VoicemailMain(s\${CALLERIDNUM})\n";}
		else
			{$Vext .= "exten => 8501,1,VoicemailMain(s\${{CALLERID(num)}(num)})\n";}
		$Vext .= "exten => 8501,2,Hangup\n";
		$Vext .= "\n";
		$Vext .= "; Prompt Extensions:\n";
		$Vext .= "exten => 8167,1,Answer\n";
		$Vext .= "exten => 8167,2,AGI(agi-record_prompts.agi,wav-----720000)\n";
		$Vext .= "exten => 8167,3,Hangup\n";
		$Vext .= "exten => 8168,1,Answer\n";
		$Vext .= "exten => 8168,2,AGI(agi-record_prompts.agi,gsm-----720000)\n";
		$Vext .= "exten => 8168,3,Hangup\n";
		}
	else
		{
		$Vext .= "; Voicemail Extensions go to main voicemail server:\n";
		$Vext .= "exten => _85026666666666.,1,Dial(\${TRUNK$voicemail_server_id}/\${EXTEN},99,oT)\n";
		$Vext .= "exten => 8500,1,Dial(\${TRUNK$voicemail_server_id}/\${EXTEN},99,oT)\n";
		$Vext .= "exten => 8501,1,Dial(\${TRUNK$voicemail_server_id}/\${EXTEN},99,oT)\n";
		$Vext .= "\n";
		$Vext .= "; Prompt Extensions go to main voicemail server:\n";
		$Vext .= "exten => 8167,1,Dial(\${TRUNK$voicemail_server_id}/\${EXTEN},99,oT)\n";
		$Vext .= "exten => 8168,1,Dial(\${TRUNK$voicemail_server_id}/\${EXTEN},99,oT)\n";
		}

	$Vext .= "\n";
	$Vext .= "; this is used for recording conference calls, the client app sends the filename\n";
	$Vext .= ";    value as a callerID recordings go to /var/spool/asterisk/monitor (WAV)\n";
	$Vext .= ";    Recording is limited to 1 hour, to make longer, just change the server\n";
	$Vext .= ";    setting ViciDial Recording Limit\n";
	$Vext .= ";     this is the WAV verison, default\n";
	$Vext .= "exten => 8309,1,Answer\n";
	if ($asterisk_version =~ /^1.2/)
		{$Vext .= "exten => 8309,2,Monitor(wav,\${CALLERIDNAME})\n";}
	else
		{$Vext .= "exten => 8309,2,Monitor(wav,\${CALLERID(name)})\n";}
	$Vext .= "exten => 8309,3,Wait,$vicidial_recording_limit\n";
	$Vext .= "exten => 8309,4,Hangup\n";
	$Vext .= ";     this is the GSM verison\n";
	$Vext .= "exten => 8310,1,Answer\n";
	if ($asterisk_version =~ /^1.2/)
		{$Vext .= "exten => 8310,2,Monitor(gsm,\${CALLERIDNAME})\n";}
	else
		{$Vext .= "exten => 8310,2,Monitor(gsm,\${CALLERID(name)})\n";}
	$Vext .= "exten => 8310,3,Wait,$vicidial_recording_limit\n";
	$Vext .= "exten => 8310,4,Hangup\n";


	##### Get the IAX carriers for this server_ip #####
	$stmtA = "SELECT carrier_id,carrier_name,registration_string,template_id,account_entry,globals_string,dialplan_entry FROM vicidial_server_carriers where server_ip='$server_ip' and active='Y' and protocol='IAX2' order by carrier_id;";
	$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
	$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
	$sthArows=$sthA->rows;
	$i=0;
	while ($sthArows > $i)
		{
		@aryA = $sthA->fetchrow_array;
		$carrier_id[$i]	=			"$aryA[0]";
		$carrier_name[$i]	=		"$aryA[1]";
		$registration_string[$i] =	"$aryA[2]";
		$template_id[$i] =			"$aryA[3]";
		$account_entry[$i] =		"$aryA[4]";
		$globals_string[$i] =		"$aryA[5]";
		$dialplan_entry[$i] =		"$aryA[6]";
		$i++;
		}
	$sthA->finish();

	$i=0;
	while ($sthArows > $i)
		{
		$template_contents[$i]='';
		if ( (length($template_id[$i]) > 1) && ($template_id[$i] !~ /--NONE--/) ) 
			{
			$stmtA = "SELECT template_contents FROM vicidial_conf_templates where template_id='$template_id[$i]';";
			$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
			$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
			$sthBrows=$sthA->rows;
			if ($sthBrows > 0)
				{
				@aryA = $sthA->fetchrow_array;
				$template_contents[$i]	=	"$aryA[0]";
				}
			$sthA->finish();
			}
		$ext  .= "$globals_string[$i]\n";

		$iax  .= "$registration_string[$i]\n";

		$Lext .= "; VICIDIAL Carrier: $carrier_id[$i] - $carrier_name[$i]\n";
		$Lext .= "$dialplan_entry[$i]\n";

		$Liax .= "; VICIDIAL Carrier: $carrier_id[$i] - $carrier_name[$i]\n";
		$Liax .= "$account_entry[$i]\n";
		$Liax .= "$template_contents[$i]\n";

		$i++;
		}



	##### Get the SIP carriers for this server_ip #####
	$stmtA = "SELECT carrier_id,carrier_name,registration_string,template_id,account_entry,globals_string,dialplan_entry FROM vicidial_server_carriers where server_ip='$server_ip' and active='Y' and protocol='SIP' order by carrier_id;";
	$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
	$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
	$sthArows=$sthA->rows;
	$i=0;
	while ($sthArows > $i)
		{
		@aryA = $sthA->fetchrow_array;
		$carrier_id[$i]	=			"$aryA[0]";
		$carrier_name[$i]	=		"$aryA[1]";
		$registration_string[$i] =	"$aryA[2]";
		$template_id[$i] =			"$aryA[3]";
		$account_entry[$i] =		"$aryA[4]";
		$globals_string[$i] =		"$aryA[5]";
		$dialplan_entry[$i] =		"$aryA[6]";
		$i++;
		}
	$sthA->finish();

	$i=0;
	while ($sthArows > $i)
		{
		$template_contents[$i]='';
		if ( (length($template_id[$i]) > 1) && ($template_id[$i] !~ /--NONE--/) ) 
			{
			$stmtA = "SELECT template_contents FROM vicidial_conf_templates where template_id='$template_id[$i]';";
			$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
			$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
			$sthBrows=$sthA->rows;
			if ($sthBrows > 0)
				{
				@aryA = $sthA->fetchrow_array;
				$template_contents[$i]	=	"$aryA[0]";
				}
			$sthA->finish();
			}
		$ext  .= "$globals_string[$i]\n";

		$sip  .= "$registration_string[$i]\n";

		$Lext .= "; VICIDIAL Carrier: $carrier_id[$i] - $carrier_name[$i]\n";
		$Lext .= "$dialplan_entry[$i]\n";

		$Lsip .= "; VICIDIAL Carrier: $carrier_id[$i] - $carrier_name[$i]\n";
		$Lsip .= "$account_entry[$i]\n";
		$Lsip .= "$template_contents[$i]\n";

		$i++;
		}

	$Pext .= "\n";
	$Pext .= "; Phones direct dial extensions:\n";


	##### Get the IAX phone entries #####
	$stmtA = "SELECT extension,dialplan_number,voicemail_id,pass,template_id,conf_override,email,template_id,conf_override,outbound_cid,fullname,phone_context,phone_ring_timeout FROM phones where server_ip='$server_ip' and protocol='IAX2' and active='Y' order by extension;";
	#	print "$stmtA\n";
	$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
	$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
	$sthArows=$sthA->rows;
	$i=0;
	while ($sthArows > $i)
		{
		@aryA = $sthA->fetchrow_array;
		$extension[$i] =			"$aryA[0]";
		$dialplan[$i] =				"$aryA[1]";
		$voicemail[$i] =			"$aryA[2]";
		$pass[$i] =					"$aryA[3]";
		$template_id[$i] =			"$aryA[4]";
		$conf_override[$i] =		"$aryA[5]";
		$email[$i] =				"$aryA[6]";
		$template_id[$i] =			"$aryA[7]";
		$conf_override[$i] =		"$aryA[8]";
		$outbound_cid[$i] =			"$aryA[9]";
		$fullname[$i] =				"$aryA[10]";
		$phone_context[$i] =		"$aryA[11]";
		$phone_ring_timeout[$i] =	"$aryA[12]";
		$i++;
		}
	$sthA->finish();

	$i=0;
	while ($sthArows > $i)
		{
		$conf_entry_written=0;
		$template_contents[$i]='';
		if ( (length($template_id[$i]) > 1) && ($template_id[$i] !~ /--NONE--/) ) 
			{
			$stmtA = "SELECT template_contents FROM vicidial_conf_templates where template_id='$template_id[$i]';";
			$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
			$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
			$sthBrows=$sthA->rows;
			if ($sthBrows > 0)
				{
				@aryA = $sthA->fetchrow_array;
				$template_contents[$i]	=	"$aryA[0]";

				$Piax .= "\n\[$extension[$i]\]\n";
				$Piax .= "username=$extension[$i]\n";
				$Piax .= "secret=$pass[$i]\n";
				$Piax .= "callerid=\"$fullname[$i]\" <$outbound_cid[$i]>\n";
				$Piax .= "mailbox=$voicemail[$i]\n";
				$Piax .= "$template_contents[$i]\n";
				
				$conf_entry_written++;
				}
			$sthA->finish();
			}
		if (length($conf_override[$i]) > 10)
			{
			$Piax .= "\n\[$extension[$i]\]\n";
			$Piax .= "$conf_override[$i]\n";
			$conf_entry_written++;
			}
		if ($conf_entry_written < 1)
			{
			$Piax .= "\n\[$extension[$i]\]\n";
			$Piax .= "username=$extension[$i]\n";
			$Piax .= "secret=$pass[$i]\n";
			$Piax .= "callerid=\"$fullname[$i]\" <$outbound_cid[$i]>\n";
			$Piax .= "mailbox=$voicemail[$i]\n";
			$Piax .= "context=$phone_context[$i]\n";
			$Piax .= "type=friend\n";
			$Piax .= "auth=md5\n";
			$Piax .= "host=dynamic\n";
			}
		$Pext .= "exten => $dialplan[$i],1,Dial(IAX2/$extension[$i]|$phone_ring_timeout[$i]|)\n";
		$Pext .= "exten => $dialplan[$i],2,Voicemail($voicemail[$i]|u)\n";
		$Pext .= "exten => $dialplan[$i],3,Hangup\n";

		$vm  .= "$voicemail[$i] => $voicemail[$i],$extension[$i] Mailbox,$email[$i]\n";

		$i++;
		}


	##### Get the SIP phone entries #####
	$stmtA = "SELECT extension,dialplan_number,voicemail_id,pass,template_id,conf_override,email,template_id,conf_override,outbound_cid,fullname,phone_context,phone_ring_timeout FROM phones where server_ip='$server_ip' and protocol='SIP' and active='Y' order by extension;";
	#	print "$stmtA\n";
	$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
	$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
	$sthArows=$sthA->rows;
	$i=0;
	while ($sthArows > $i)
		{
		@aryA = $sthA->fetchrow_array;
		$extension[$i] =			"$aryA[0]";
		$dialplan[$i] =				"$aryA[1]";
		$voicemail[$i] =			"$aryA[2]";
		$pass[$i] =					"$aryA[3]";
		$template_id[$i] =			"$aryA[4]";
		$conf_override[$i] =		"$aryA[5]";
		$email[$i] =				"$aryA[6]";
		$template_id[$i] =			"$aryA[7]";
		$conf_override[$i] =		"$aryA[8]";
		$outbound_cid[$i] =			"$aryA[9]";
		$fullname[$i] =				"$aryA[10]";
		$phone_context[$i] =		"$aryA[11]";
		$phone_ring_timeout[$i] =	"$aryA[12]";
		$i++;
		}
	$sthA->finish();

	$i=0;
	while ($sthArows > $i)
		{
		$conf_entry_written=0;
		$template_contents[$i]='';
		if ( (length($template_id[$i]) > 1) && ($template_id[$i] !~ /--NONE--/) ) 
			{
			$stmtA = "SELECT template_contents FROM vicidial_conf_templates where template_id='$template_id[$i]';";
			$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
			$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
			$sthBrows=$sthA->rows;
			if ($sthBrows > 0)
				{
				@aryA = $sthA->fetchrow_array;
				$template_contents[$i]	=	"$aryA[0]";

				$Psip .= "\n\[$extension[$i]\]\n";
				$Psip .= "username=$extension[$i]\n";
				$Psip .= "secret=$pass[$i]\n";
				$Psip .= "callerid=\"$fullname[$i]\" <$outbound_cid[$i]>\n";
				$Psip .= "mailbox=$voicemail[$i]\n";
				$Psip .= "$template_contents[$i]\n";
				
				$conf_entry_written++;
				}
			$sthA->finish();
			}
		if (length($conf_override[$i]) > 10)
			{
			$Psip .= "\n\[$extension[$i]\]\n";
			$Psip .= "$conf_override[$i]\n";
			$conf_entry_written++;
			}
		if ($conf_entry_written < 1)
			{
			$Psip .= "\n\[$extension[$i]\]\n";
			$Psip .= "username=$extension[$i]\n";
			$Psip .= "secret=$pass[$i]\n";
			$Psip .= "callerid=\"$fullname[$i]\" <$outbound_cid[$i]>\n";
			$Psip .= "mailbox=$voicemail[$i]\n";
			$Psip .= "context=$phone_context[$i]\n";
			$Psip .= "type=friend\n";
			$Psip .= "host=dynamic\n";
			}
		$Pext .= "exten => $dialplan[$i],1,Dial(SIP/$extension[$i]|$phone_ring_timeout[$i]|)\n";
		$Pext .= "exten => $dialplan[$i],2,Voicemail($voicemail[$i]|u)\n";
		$Pext .= "exten => $dialplan[$i],3,Hangup\n";

		$vm  .= "$voicemail[$i] => $voicemail[$i],$extension[$i] Mailbox,$email[$i]\n";

		$i++;
		}





	##### Get the Call Menu entries #####
	$stmtA = "SELECT menu_id,menu_name,menu_prompt,menu_timeout,menu_timeout_prompt,menu_invalid_prompt,menu_repeat,menu_time_check,call_time_id,track_in_vdac,custom_dialplan_entry FROM vicidial_call_menu order by menu_id;";
	#	print "$stmtA\n";
	$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
	$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
	$sthArows=$sthA->rows;
	$i=0;
	while ($sthArows > $i)
		{
		@aryA = $sthA->fetchrow_array;
		$menu_id[$i] =				"$aryA[0]";
		$menu_name[$i] =			"$aryA[1]";
		$menu_prompt[$i] =			"$aryA[2]";
		$menu_timeout[$i] =			"$aryA[3]";
		$menu_timeout_prompt[$i] =	"$aryA[4]";
		$menu_invalid_prompt[$i] =	"$aryA[5]";
		$menu_repeat[$i] =			"$aryA[6]";
		$menu_time_check[$i] =		"$aryA[7]";
		$call_time_id[$i] =			"$aryA[8]";
		$track_in_vdac[$i] =		"$aryA[9]";
		$custom_dialplan_entry[$i]= "$aryA[10]";

		if ($track_in_vdac[$i] > 0)
			{$track_in_vdac[$i] = 'YES'}
		else
			{$track_in_vdac[$i] = 'NO'}
		$i++;
		}
	$sthA->finish();

	$i=0;
	$call_menu_ext = '';
	while ($sthArows > $i)
		{
		$stmtA = "SELECT option_value,option_description,option_route,option_route_value,option_route_value_context FROM vicidial_call_menu_options where menu_id='$menu_id[$i]' order by option_value;";
		#	print "$stmtA\n";
		$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
		$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
		$sthArowsJ=$sthA->rows;
		$j=0;
		$time_check_scheme = '';
		$time_check_route = '';
		$time_check_route_value = '';
		$time_check_route_context = '';
		$call_menu_timeout_ext = '';
		$call_menu_invalid_ext = '';
		$call_menu_options_ext = '';
		if ($DBX>0) {print "$sthArowsJ|$stmtA\n";}
		while ($sthArowsJ > $j)
			{
			@aryA = $sthA->fetchrow_array;
			$option_value[$j] =					"$aryA[0]";
			$option_description[$j] =			"$aryA[1]";
			$option_route[$j] =					"$aryA[2]";
			$option_route_value[$j] =			"$aryA[3]";
			$option_route_value_context[$j] =	"$aryA[4]";
			if ($option_value[$j] =~ /STAR/) {$option_value[$j] = '*';}
			if ($option_value[$j] =~ /HASH/) {$option_value[$j] = '#';}
			$j++;
			}

		$j=0;
		while ($sthArowsJ > $j)
			{
			$PRI=1;
			$call_menu_line='';
			if ( ($option_value[$j] =~ /TIMECHECK/) && ($menu_time_check[$i] > 0) && (length($call_time_id[$i])>0) )
				{
				$time_check_scheme =			$call_time_id[$i];
				$time_check_route =				$option_route[$j];
				$time_check_route_value =		$option_route_value[$j];
				$time_check_route_context =		$option_route_value_context[$j];
				}
			else
				{
				if (length($option_description[$j])>0)
					{
					$call_menu_line .= "; $option_description[$j]\n";
					}
				if ($option_value[$j] =~ /TIMEOUT/)
					{
					$option_value[$j] = 't';
					if ( (length($menu_timeout_prompt[$i])>0)  && ($menu_timeout_prompt[$i] !~ /NONE/) )
						{
						$call_menu_line .= "exten => t,1,Playback($menu_timeout_prompt[$i])\n";
						$PRI++;
						}
					}
				if ($option_value[$j] =~ /INVALID/)
					{
					if ( (length($menu_invalid_prompt[$i])>0) && ($menu_invalid_prompt[$i] !~ /NONE/) )
						{
						$call_menu_line .= "exten => i,1,Playback($menu_invalid_prompt[$i])\n";
						$PRI++;
						}
					$option_value[$j] = 'i';
					}
				if ($option_route[$j] =~ /AGI/)
					{
					$call_menu_line .= "exten => $option_value[$j],$PRI,AGI($option_route_value[$j])\n";
					}
				if ($option_route[$j] =~ /CALLMENU/)
					{
					$call_menu_line .= "exten => $option_value[$j],$PRI,Goto($option_route_value[$j],s,1)\n";
					}
				if ($option_route[$j] =~ /DID/)
					{
					$call_menu_line .= "exten => $option_value[$j],$PRI,Goto(trunkinbound,$option_route_value[$j],1)\n";
					}
				if ($option_route[$j] =~ /INGROUP/)
					{
					@IGoption_route_value_context = split(/,/,$option_route_value_context[$j]);
					$IGhandle_method =	$IGoption_route_value_context[0];
					$IGsearch_method =	$IGoption_route_value_context[1];
					$IGlist_id =		$IGoption_route_value_context[2];
					$IGcampaign_id =	$IGoption_route_value_context[3];
					$IGphone_code =		$IGoption_route_value_context[4];

					$call_menu_line .= "exten => $option_value[$j],$PRI,AGI(agi-VDAD_ALL_inbound.agi,$IGhandle_method-----$IGsearch_method-----$option_route_value[$j]-----$menu_id[$i]--------------------$IGlist_id-----$IGphone_code-----$IGcampaign_id)\n";
					}
				if ($option_route[$j] =~ /EXTENSION/)
					{
					if (length($option_route_value_context[$j])>0) {$option_route_value_context[$j] = "$option_route_value_context[$j],";}
					$call_menu_line .= "exten => $option_value[$j],$PRI,Goto($option_route_value_context[$j]$option_route_value[$j],1)\n";
					}
				if ($option_route[$j] =~ /VOICEMAIL/)
					{
					$call_menu_line .= "exten => $option_value[$j],$PRI,Goto(default,85026666666666$option_route_value[$j],1)\n";
					}
				if ($option_route[$j] =~ /HANGUP/)
					{
					if ( (length($option_route_value[$j])>0) && ($option_route_value[$j] !~ /NONE/) )
						{
						$call_menu_line .= "exten => $option_value[$j],$PRI,Playback($option_route_value[$j])\n";
						$call_menu_line .= "exten => $option_value[$j],n,Hangup\n";
						}
					else
						{
						$call_menu_line .= "exten => $option_value[$j],$PRI,Hangup\n";
						}
					}
				if ($option_route[$j] =~ /PHONE/)
					{
					$stmtA = "SELECT dialplan_number,server_ip FROM phones where login='$option_route_value[$j]';";
					#	print "$stmtA\n";
					$sthA = $dbhA->prepare($stmtA) or die "preparing: ",$dbhA->errstr;
					$sthA->execute or die "executing: $stmtA ", $dbhA->errstr;
					$sthArowsP=$sthA->rows;
					if ($sthArowsP > 0)
						{
						@aryA = $sthA->fetchrow_array;
						$Pdialplan =	"$aryA[0]";
						$Pserver_ip =	"$aryA[1]";

						### format the remote server dialstring to get the call to the overflow agent meetme room
						$S='*';
						if( $Pserver_ip =~ m/(\S+)\.(\S+)\.(\S+)\.(\S+)/ )
							{
							$a = leading_zero($1); 
							$b = leading_zero($2); 
							$c = leading_zero($3); 
							$d = leading_zero($4);
							$DIALstring = "$a$S$b$S$c$S$d$S";
							}
						$call_menu_line .= "exten => $option_value[$j],$PRI,Goto(default,$DIALstring$Pdialplan,1)\n";
						}
					$sthA->finish();
					}

				if ($option_value[$j] =~ /t/)
					{
					$call_menu_timeout_ext = "$call_menu_line";
					}
				if ($option_value[$j] =~ /i/)
					{
					$call_menu_invalid_ext = "$call_menu_line";
					}
				if ($option_value[$j] !~ /i|t/)
					{
					$call_menu_options_ext .= "$call_menu_line";
					}
				}
			if ($DBX>0) {print "$i|$j|     $menu_id[$i]|$option_value[$j]\n";}
			$j++;
			}
		$sthA->finish();


		$call_menu_ext .= "\n";
		$call_menu_ext .= "; $menu_name[$i]\n";
		$call_menu_ext .= "[$menu_id[$i]]\n";
		$call_menu_ext .= "exten => s,1,AGI(agi-VDAD_inbound_calltime_check.agi,-----$track_in_vdac[$i]-----$menu_id[$i]-----$time_check_scheme-----$time_check_route-----$time_check_route_value-----$time_check_route_context)\n";
		$call_menu_ext .= "exten => s,n,Background($menu_prompt[$i])\n";
		$call_menu_ext .= "exten => s,n,WaitExten($menu_timeout[$i])\n";
		$k=0;
		while ($k < $menu_repeat[$i]) 
			{
			$call_menu_ext .= "exten => s,n,Background($menu_prompt[$i])\n";
			$call_menu_ext .= "exten => s,n,WaitExten($menu_timeout[$i])\n";
			$k++;
			}
	#	$call_menu_ext .= "exten => s,n,Hangup\n";
		$call_menu_ext .= "\n";
		$call_menu_ext .= "$call_menu_options_ext";
		$call_menu_ext .= "\n";
		if (length($custom_dialplan_entry[$i]) > 4) 
			{
			$call_menu_ext .= "; custom dialplan entries\n";
			$call_menu_ext .= "$custom_dialplan_entry[$i]\n";
			$call_menu_ext .= "\n";
			}

		if (length($call_menu_timeout_ext) < 1)
			{
			if ( (length($menu_timeout_prompt[$i])>0)  && ($menu_timeout_prompt[$i] !~ /NONE/) )
				{
				$call_menu_ext .= "exten => t,1,Playback($menu_timeout_prompt[$i])\n";
				$call_menu_ext .= "exten => t,n,Goto(s,2)\n";
				}
			else
				{
				$call_menu_ext .= "exten => t,1,Goto(s,2)\n";
				}
			}
		else
			{
			$call_menu_ext .= "$call_menu_timeout_ext";
			}
		if (length($call_menu_invalid_ext) < 1)
			{
			if ( (length($menu_invalid_prompt[$i])>0) && ($menu_invalid_prompt[$i] !~ /NONE/) )
				{
				$call_menu_ext .= "exten => i,1,Playback($menu_invalid_prompt[$i])\n";
				$call_menu_ext .= "exten => i,n,Goto(s,2)\n";
				}
			else
				{
				$call_menu_ext .= "exten => i,1,Goto(s,2)\n";
				}
			}
		else
			{
			$call_menu_ext .= "$call_menu_invalid_ext";
			}

		$call_menu_ext .= "; hangup\n";
		$call_menu_ext .= 'exten => h,1,DeadAGI(agi://127.0.0.1:4577/call_log--HVcauses--PRI-----NODEBUG-----${HANGUPCAUSE}-----${DIALSTATUS}-----${DIALEDTIME}-----${ANSWEREDTIME})';
		$call_menu_ext .= "\n\n";

		$i++;
		}





	if ($DB) {print "writing auto-gen conf files\n";}

	open(ext, ">/etc/asterisk/extensions-vicidial.conf") || die "can't open /etc/asterisk/extensions-vicidial.conf: $!\n";
	open(iax, ">/etc/asterisk/iax-vicidial.conf") || die "can't open /etc/asterisk/iax-vicidial.conf: $!\n";
	open(sip, ">/etc/asterisk/sip-vicidial.conf") || die "can't open /etc/asterisk/sip-vicidial.conf: $!\n";
	open(vm, ">/etc/asterisk/voicemail-vicidial.conf") || die "can't open /etc/asterisk/voicemail-vicidial.conf: $!\n";

	print ext "; WARNING- THIS FILE IS AUTO-GENERATED BY VICIDIAL, ANY EDITS YOU MAKE WILL BE LOST\n";
	print ext "$ext\n";
	print ext "$call_menu_ext\n";
	print ext "[vicidial-auto]\n";
	print ext 'exten => h,1,DeadAGI(agi://127.0.0.1:4577/call_log--HVcauses--PRI-----NODEBUG-----${HANGUPCAUSE}-----${DIALSTATUS}-----${DIALEDTIME}-----${ANSWEREDTIME})';
	print ext "\n";
	print ext "$Lext\n";
	print ext "$Vext\n";
	print ext "$Pext\n";

	print iax "; WARNING- THIS FILE IS AUTO-GENERATED BY VICIDIAL, ANY EDITS YOU MAKE WILL BE LOST\n";
	print iax "$iax\n";
	print iax "$Liax\n";
	print iax "$Piax\n";

	print sip "; WARNING- THIS FILE IS AUTO-GENERATED BY VICIDIAL, ANY EDITS YOU MAKE WILL BE LOST\n";
	print sip "$sip\n";
	print sip "$Lsip\n";
	print sip "$Psip\n";

	print vm "; WARNING- THIS FILE IS AUTO-GENERATED BY VICIDIAL, ANY EDITS YOU MAKE WILL BE LOST\n";
#	print vm "[vicidial-auto]\n";
	print vm "$vm\n";

	close(ext);
	close(iax);
	close(sip);
	close(vm);


	sleep(1);

	### reload Asterisk
	if ($DB) {print "reloading asterisk\n";}
	if ($asterisk_version =~ /^1.2/)
		{
		`screen -XS asterisk eval 'stuff "sip reload\015"'`;
		sleep(1);
		`screen -XS asterisk eval 'stuff "iax2 reload\015"'`;
		sleep(1);
		`screen -XS asterisk eval 'stuff "extensions reload\015"'`;
		sleep(1);
		`screen -XS asterisk eval 'stuff "reload app_voicemail.so\015"'`;
		sleep(1);
		}
	else
		{
		`screen -XS asterisk eval 'stuff "sip reload\015"'`;
		sleep(1);
		`screen -XS asterisk eval 'stuff "iax2 reload\015"'`;
		sleep(1);
		`screen -XS asterisk eval 'stuff "dialplan reload\015"'`;
		sleep(1);
		`screen -XS asterisk eval 'stuff "module reload app_voicemail.so\015"'`;
		sleep(1);
		}

	}
################################################################################
#####  END Creation of auto-generated conf files
################################################################################








################################################################################
#####  BEGIN  Audio Store sync
################################################################################
$upload_audio = 0;
$upload_flag = '';
$soundsec=0;

if ( ($active_voicemail_server =~ /$server_ip/) && ((length($active_voicemail_server)) eq (length($server_ip))) )
	{
	if (-e "/prompt_count.txt")
		{
		open(test, "/prompt_count.txt") || die "can't open /prompt_count.txt: $!\n";
		@test = <test>;
		close(test);
		chomp($test[0]);
		$test[0] = ($test[0] + 85100000);
		$last_file_gsm = "$test[0].gsm";
		$last_file_wav = "$test[0].wav";

		if (-e "$PATHsounds/$last_file_gsm")
			{
			$sounddate = (-M "$PATHsounds/$last_file_gsm");
			$soundsec =	($sounddate * 86400);
			}
		if (-e "$PATHsounds/$last_file_wav")
			{
			$sounddate = (-M "$PATHsounds/$last_file_wav");
			$soundsec =	($sounddate * 86400);
			}
		if ($DB) {print "age of last audio prompt file: |$sounddate|$soundsec|   ($PATHsounds/$last_file_gsm|$last_file_wav)\n";}
		if ( ($soundsec > 300) && ($soundsec <= 360) )
			{
			$upload_audio = 1;
			$upload_flag = '--upload';
			}
		}
	}

if ( ($active_asterisk_server =~ /Y/) && ( ($sounds_update =~ /Y/) || ($upload_audio > 0) ) )
	{
	if ($sounds_central_control_active > 0)
		{
		if ($DB) {print "running audio store sync process...\n";}
		`/usr/bin/screen -d -m -S AudioStore $PATHhome/ADMIN_audio_store_sync.pl $upload_flag 2>/dev/null 1>&2`;
		}
	}


################################################################################
#####  END  Audio Store sync
################################################################################






if ($DB) {print "DONE\n";}

exit;



sub leading_zero($) 
{
    $_ = $_[0];
    s/^(\d)$/0$1/;
    s/^(\d\d)$/0$1/;
    return $_;
} # End of the leading_zero() routine.
