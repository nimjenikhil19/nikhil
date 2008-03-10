#!/usr/bin/perl
#
# ADMIN_update_server_ip.pl - updates IP address in DB and conf file
#
# This script is designed to update all database tables and the local 
# astguiclient.conf file to reflect a change in IP address. The script will 
# automatically default to the first eth address in the ifconfig output.
#
# Copyright (C) 2008  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# CHANGELOG
# 71205-2144 - added display of extensions.conf example for call routing
#
#
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
	if ( ($line =~ /^VARserver_ip/) && ($CLIserver_ip < 1) )
		{$VARold_server_ip = $line;   $VARold_server_ip =~ s/.*=//gi;}
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

############################################

$CLIold_server_ip=0;
$CLIserver_ip=0;

$secX = time();

# constants
$DB=1;  # Debug flag, set to 0 for no debug messages, lots of output
$US='_';
$MT[0]='';

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
	print "ADMIN_update_server_ip.pl - updates server_ip in the $VARDB_database\n";
	print "database and in the local /etc/astguiclient.conf file.\n";
	print "\n";
	print "command-line options:\n";
	print "  [--help] = this help screen\n";
	print "  [--debug] = verbose debug messages\n";
	print "  [--auto] = no prompts\n";
	print "configuration options:\n";
	print "  [--old-server_ip=192.168.0.1] = define old server IP address at runtime\n";
	print "  [--server_ip=192.168.0.2] = define new server IP address at runtime\n";
	print "\n";

	exit;
	}
	else
	{
		if ($args =~ /--debug/i) # Debug flag
		{
		$DB=1;
		}
		if ($args =~ /--auto/i) # no prompts flag
		{
		$AUTO=1;
		}
		if ($args =~ /--old-server_ip=/i) # CLI defined old server IP address
		{
		@CLIoldserver_ipARY = split(/--old-server_ip=/,$args);
		@CLIoldserver_ipARX = split(/ /,$CLIoldserver_ipARY[1]);
		if (length($CLIoldserver_ipARX[0])>2)
			{
			$VARold_server_ip = $CLIoldserver_ipARX[0];
			$VARold_server_ip =~ s/\/$| |\r|\n|\t//gi;
			$CLIold_server_ip=1;
			print "  CLI defined old server IP:  $VARold_server_ip\n";
			}
		}
		if ($args =~ /--server_ip=/i) # CLI defined server IP address
		{
		@CLIserver_ipARY = split(/--server_ip=/,$args);
		@CLIserver_ipARX = split(/ /,$CLIserver_ipARY[1]);
		if (length($CLIserver_ipARX[0])>2)
			{
			$VARserver_ip = $CLIserver_ipARX[0];
			$VARserver_ip =~ s/\/$| |\r|\n|\t//gi;
			$CLIserver_ip=1;
			print "  CLI defined server IP:      $VARserver_ip\n";
			}
		}
	}
}
else
{
#	print "no command line options set\n";
}
### end parsing run-time options ###

if (-e "$PATHconf") 
	{
	print "Previous astGUIclient configuration file found at: $PATHconf\n";
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
		if ( ($line =~ /^PATHlogs/) && ($CLIlogs < 1) )
			{$PATHlogs = $line;   $PATHlogs =~ s/.*=//gi;}
		if ( ($line =~ /^PATHagi/) && ($CLIagi < 1) )
			{$PATHagi = $line;   $PATHagi =~ s/.*=//gi;}
		if ( ($line =~ /^PATHweb/) && ($CLIweb < 1) )
			{$PATHweb = $line;   $PATHweb =~ s/.*=//gi;}
		if ( ($line =~ /^PATHsounds/) && ($CLIsounds < 1) )
			{$PATHsounds = $line;   $PATHsounds =~ s/.*=//gi;}
		if ( ($line =~ /^PATHmonitor/) && ($CLImonitor < 1) )
			{$PATHmonitor = $line;   $PATHmonitor =~ s/.*=//gi;}
#		if ( ($line =~ /^VARserver_ip/) && ($CLIserver_ip < 1) )
#			{$VARserver_ip = $line;   $VARserver_ip =~ s/.*=//gi;}
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
		if ( ($line =~ /^VARactive_keepalives/) && ($CLIactive_keepalives < 1) )
			{$VARactive_keepalives = $line;   $VARactive_keepalives =~ s/.*=//gi;}
		if ( ($line =~ /^VARfastagi_log_min_servers/) && ($CLIVARfastagi_log_min_servers < 1) )
			{$VARfastagi_log_min_servers = $line;   $VARfastagi_log_min_servers =~ s/.*=//gi;}
		if ( ($line =~ /^VARfastagi_log_max_servers/) && ($CLIVARfastagi_log_max_servers < 1) )
			{$VARfastagi_log_max_servers = $line;   $VARfastagi_log_max_servers =~ s/.*=//gi;}
		if ( ($line =~ /^VARfastagi_log_min_spare_servers/) && ($CLIVARfastagi_log_min_spare_servers < 1) )
			{$VARfastagi_log_min_spare_servers = $line;   $VARfastagi_log_min_spare_servers =~ s/.*=//gi;}
		if ( ($line =~ /^VARfastagi_log_max_spare_servers/) && ($CLIVARfastagi_log_max_spare_servers < 1) )
			{$VARfastagi_log_max_spare_servers = $line;   $VARfastagi_log_max_spare_servers =~ s/.*=//gi;}
		if ( ($line =~ /^VARfastagi_log_max_requests/) && ($CLIVARfastagi_log_max_requests < 1) )
			{$VARfastagi_log_max_requests = $line;   $VARfastagi_log_max_requests =~ s/.*=//gi;}
		if ( ($line =~ /^VARfastagi_log_checkfordead/) && ($CLIVARfastagi_log_checkfordead < 1) )
			{$VARfastagi_log_checkfordead = $line;   $VARfastagi_log_checkfordead =~ s/.*=//gi;}
		if ( ($line =~ /^VARfastagi_log_checkforwait/) && ($CLIVARfastagi_log_checkforwait < 1) )
			{$VARfastagi_log_checkforwait = $line;   $VARfastagi_log_checkforwait =~ s/.*=//gi;}
		$i++;
		}
	}

if ($AUTO)
	{
	$manual='n';
	@ip = `/sbin/ifconfig`;
	$j=0;
	while($#ip>=$j)
		{
		if ($ip[$j] =~ /inet addr/) {$VARserver_ip = $ip[$j]; $j=1000;}
		$j++;
		}
	$VARserver_ip =~ s/.*addr:| Bcast.*|\r|\n|\t| //gi;
	}
else
	{
	print("\nWould you like to use interactive mode (y/n): [y] ");
	$manual = <STDIN>;
	chomp($manual);
	}

if ($manual =~ /n/i)
	{
	$manual=0;
	}
else
	{
	$config_finished='NO';
	while ($config_finished =~/NO/)
		{
		print "\nSTARTING SERVER IP ADDRESS CHANGE FOR VICIDIAL...\n";

		##### BEGIN old_server_ip propmting and check #####
		$continue='NO';
		while ($continue =~/NO/)
			{
			print("\nOld server IP address or press enter for default: [$VARold_server_ip] ");
			$PROMPTold_server_ip = <STDIN>;
			chomp($PROMPTold_server_ip);
			if (length($PROMPTold_server_ip)>6)
				{
				$PROMPTold_server_ip =~ s/ |\n|\r|\t|\/$//gi;
				$VARold_server_ip=$PROMPTold_server_ip;
				$continue='YES';
				}
			else
				{
				$continue='YES';
				}
			}
		##### END old_server_ip propmting and check  #####

		##### BEGIN server_ip propmting and check #####
		if (length($VARserver_ip)<7)
			{	
			### get best guess of IP address from ifconfig output ###
			# inet addr:10.10.11.17  Bcast:10.10.255.255  Mask:255.255.0.0
			@ip = `/sbin/ifconfig`;
			$j=0;
			while($#ip>=$j)
				{
				if ($ip[$j] =~ /inet addr/) {$VARserver_ip = $ip[$j]; $j=1000;}
				$j++;
				}
			$VARserver_ip =~ s/.*addr:| Bcast.*|\r|\n|\t| //gi;
			}

		$continue='NO';
		while ($continue =~/NO/)
			{
			print("\nserver IP address or press enter for default: [$VARserver_ip] ");
			$PROMPTserver_ip = <STDIN>;
			chomp($PROMPTserver_ip);
			if (length($PROMPTserver_ip)>6)
				{
				$PROMPTserver_ip =~ s/ |\n|\r|\t|\/$//gi;
				$VARserver_ip=$PROMPTserver_ip;
				$continue='YES';
				}
			else
				{
				$continue='YES';
				}
			}
		##### END server_ip propmting and check  #####



		print "\n";
		print "  old server_ip:      $VARold_server_ip\n";
		print "  new server_ip:      $VARserver_ip\n";
		print "\n";

		print("Are these settings correct?(y/n): [y] ");
		$PROMPTconfig = <STDIN>;
		chomp($PROMPTconfig);
		if ( (length($PROMPTconfig)<1) or ($PROMPTconfig =~ /y/i) )
			{
			$config_finished='YES';
			}
		}
	}

print "Writing change to astguiclient.conf file: $PATHconf\n";

open(conf, ">$PATHconf") || die "can't open $PATHconf: $!\n";
print conf "# astguiclient.conf - configuration elements for the astguiclient package\n";
print conf "# this is the astguiclient configuration file \n";
print conf "# all comments will be lost if you run install.pl again\n";
print conf "\n";
print conf "# Paths used by astGUIclient\n";
print conf "PATHhome => $PATHhome\n";
print conf "PATHlogs => $PATHlogs\n";
print conf "PATHagi => $PATHagi\n";
print conf "PATHweb => $PATHweb\n";
print conf "PATHsounds => $PATHsounds\n";
print conf "PATHmonitor => $PATHmonitor\n\n";
print conf "\n";
print conf "# The IP address of this machine\n";
print conf "VARserver_ip => $VARserver_ip\n";
print conf "\n";
print conf "# Database connection information\n";
print conf "VARDB_server => $VARDB_server\n";
print conf "VARDB_database => $VARDB_database\n";
print conf "VARDB_user => $VARDB_user\n";
print conf "VARDB_pass => $VARDB_pass\n";
print conf "VARDB_port => $VARDB_port\n";
print conf "\n";
print conf "# Alpha-Numeric list of the astGUIclient processes to be kept running\n";
print conf "# (value should be listing of characters with no spaces: 123456)\n";
print conf "#  X - NO KEEPALIVE PROCESSES (use only if you want none to be keepalive)\n";
print conf "#  1 - AST_update\n";
print conf "#  2 - AST_send_listen\n";
print conf "#  3 - AST_VDauto_dial\n";
print conf "#  4 - AST_VDremote_agents\n";
print conf "#  5 - AST_VDadapt (If multi-server system, this must only be on one server)\n";
print conf "#  6 - FastAGI_log\n";
print conf "#  7 - AST_VDauto_dial_FILL (only for multi-server, this must only be on one server)\n";
print conf "VARactive_keepalives => $VARactive_keepalives\n";
print conf "\n";
print conf "# Settings for FastAGI logging server\n";
print conf "VARfastagi_log_min_servers => $VARfastagi_log_min_servers\n";
print conf "VARfastagi_log_max_servers => $VARfastagi_log_max_servers\n";
print conf "VARfastagi_log_min_spare_servers => $VARfastagi_log_min_spare_servers\n";
print conf "VARfastagi_log_max_spare_servers => $VARfastagi_log_max_spare_servers\n";
print conf "VARfastagi_log_max_requests => $VARfastagi_log_max_requests\n";
print conf "VARfastagi_log_checkfordead => $VARfastagi_log_checkfordead\n";
print conf "VARfastagi_log_checkforwait => $VARfastagi_log_checkforwait\n";
close(conf);


print "\nSTARTING DATABASE TABLES UPDATES PHASE...\n";

if (!$VARDB_port) {$VARDB_port='3306';}

use DBI;
$dbhA = DBI->connect("DBI:mysql:$VARDB_database:$VARDB_server:$VARDB_port", "$VARDB_user", "$VARDB_pass")
	or die "Couldn't connect to database: " . DBI->errstr;

print "  Updating servers table...\n";
$stmtA = "UPDATE servers SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

print "  Updating phones table...\n";
$stmtA = "UPDATE phones SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

print "  Updating inbound_numbers table...\n";
$stmtA = "UPDATE inbound_numbers SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

print "  Updating server_updater table...\n";
$stmtA = "UPDATE server_updater SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

print "  Updating conferences table...\n";
$stmtA = "UPDATE conferences SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

print "  Updating vicidial_conferences table...\n";
$stmtA = "UPDATE vicidial_conferences SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

print "  Updating vicidial_stations table...\n";
$stmtA = "UPDATE vicidial_stations SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

print "  Updating vicidial_remote_agents table...\n";
$stmtA = "UPDATE vicidial_remote_agents SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

print "  Updating phone_favorites table...\n";
$stmtA = "UPDATE phone_favorites SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

print "  Updating vicidial_server_trunks table...\n";
$stmtA = "UPDATE vicidial_server_trunks SET server_ip='$VARserver_ip' where server_ip='$VARold_server_ip';";
$affected_rows = $dbhA->do($stmtA);
if ($DB) {print "     |$affected_rows|$stmtA|\n";}

$dbhA->disconnect();

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

print "\nSERVER IP ADDRESS CHANGE FOR VICIDIAL FINISHED!\n";
print "\nPlease remember to change your extensions.conf entries for the new IP address:\n";
print "exten => _$VARremDIALstr*8600XXX,1,Goto(default,${EXTEN:16},1)\n";
print "exten => _$VARremDIALstr*8600XXX*.,1,Goto(default,${EXTEN:16},1)\n";
print "exten => _$VARremDIALstr*78600XXX,1,Goto(default,${EXTEN:16},1)\n";
print "exten => _$VARremDIALstr*78600XXX*.,1,Goto(default,${EXTEN:16},1)\n";
print "exten => _8600XXX*.,1,AGI(agi-VDADfixCXFER.agi)\n";
print "exten => _78600XXX*.,1,AGI(agi-VDADfixCXFER.agi)\n";


$secy = time();		$secz = ($secy - $secX);		$minz = ($secz/60);		# calculate script runtime so far
print "\n     - process runtime      ($secz sec) ($minz minutes)\n";


exit;


sub leading_zero($) 
{
    $_ = $_[0];
    s/^(\d)$/0$1/;
    s/^(\d\d)$/0$1/;
    return $_;
} # End of the leading_zero() routine.

