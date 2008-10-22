<?
# admin.php - VICIDIAL administration page
#
# Copyright (C) 2008  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#

require("dbconnect.php");

######################################################################################################
######################################################################################################
#######   static variable settings for display options
######################################################################################################
######################################################################################################

$page_width='770';
$section_width='720';
$header_font_size='3';
$subheader_font_size='2';
$subcamp_font_size='2';
$header_selected_bold='<b>';
$header_nonselected_bold='';
$users_color =		'#FFFF99';
$campaigns_color =	'#FFCC99';
$lists_color =		'#FFCCCC';
$ingroups_color =	'#CC99FF';
$remoteagent_color ='#CCFFCC';
$usergroups_color =	'#CCFFFF';
$scripts_color =	'#99FFCC';
$filters_color =	'#CCCCCC';
$admin_color =		'#FF99FF';
$reports_color =	'#99FF33';
#$users_color =		'#FFFF99';
#$campaigns_color =	'#FFFF99';
#$lists_color =		'#FFFF99';
#$ingroups_color =	'#FFFF99';
#$remoteagent_color ='#FFFF99';
#$usergroups_color =	'#FFFF99';
#$scripts_color =	'#FFFF99';
#$filters_color =	'#FFFF99';
#$admin_color =		'#FFFF99';
#$reports_color =	'#FFFF99';
	$times_color =		'#FF33FF';
	$phones_color =		'#FF33FF';
	$conference_color =	'#FF33FF';
	$server_color =		'#FF33FF';
	$settings_color = 	'#FF33FF';
	$status_color = 	'#FF33FF';
$users_font =		'BLACK';
$campaigns_font =	'BLACK';
$lists_font =		'BLACK';
$ingroups_font =	'BLACK';
$remoteagent_font =	'BLACK';
$usergroups_font =	'BLACK';
$scripts_font =		'BLACK';
$filters_font =		'BLACK';
$admin_font =		'BLACK';
$reports_font =		'BLACK';
	$times_font =		'BLACK';
	$phones_font =		'BLACK';
	$conference_font =	'BLACK';
	$server_font =		'BLACK';
	$settings_font = 	'BLACK';
	$status_font = 	'BLACK';
$subcamp_color =	'#FF9933';
$subcamp_font =		'BLACK';

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];

######################################################################################################
######################################################################################################
#######   Form variable declaration
######################################################################################################
######################################################################################################


if (isset($_GET["DB"]))				{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))	{$DB=$_POST["DB"];}
if (isset($_GET["active"]))	{$active=$_GET["active"];}
	elseif (isset($_POST["active"]))	{$active=$_POST["active"];}
if (isset($_GET["adaptive_dl_diff_target"]))	{$adaptive_dl_diff_target=$_GET["adaptive_dl_diff_target"];}
	elseif (isset($_POST["adaptive_dl_diff_target"]))	{$adaptive_dl_diff_target=$_POST["adaptive_dl_diff_target"];}
if (isset($_GET["adaptive_dropped_percentage"]))	{$adaptive_dropped_percentage=$_GET["adaptive_dropped_percentage"];}
	elseif (isset($_POST["adaptive_dropped_percentage"])){$adaptive_dropped_percentage=$_POST["adaptive_dropped_percentage"];}
if (isset($_GET["adaptive_intensity"]))	{$adaptive_intensity=$_GET["adaptive_intensity"];}
	elseif (isset($_POST["adaptive_intensity"]))	{$adaptive_intensity=$_POST["adaptive_intensity"];}
if (isset($_GET["adaptive_latest_server_time"]))	{$adaptive_latest_server_time=$_GET["adaptive_latest_server_time"];}
	elseif (isset($_POST["adaptive_latest_server_time"])){$adaptive_latest_server_time=$_POST["adaptive_latest_server_time"];}
if (isset($_GET["adaptive_maximum_level"]))	{$adaptive_maximum_level=$_GET["adaptive_maximum_level"];}
	elseif (isset($_POST["adaptive_maximum_level"]))	{$adaptive_maximum_level=$_POST["adaptive_maximum_level"];}
if (isset($_GET["SUB"]))			{$SUB=$_GET["SUB"];}
	elseif (isset($_POST["SUB"]))	{$SUB=$_POST["SUB"];}
if (isset($_GET["ADD"]))			{$ADD=$_GET["ADD"];}
	elseif (isset($_POST["ADD"]))	{$ADD=$_POST["ADD"];}
if (isset($_GET["admin_hangup_enabled"]))	{$admin_hangup_enabled=$_GET["admin_hangup_enabled"];}
	elseif (isset($_POST["admin_hangup_enabled"]))	{$admin_hangup_enabled=$_POST["admin_hangup_enabled"];}
if (isset($_GET["admin_hijack_enabled"]))	{$admin_hijack_enabled=$_GET["admin_hijack_enabled"];}
	elseif (isset($_POST["admin_hijack_enabled"]))	{$admin_hijack_enabled=$_POST["admin_hijack_enabled"];}
if (isset($_GET["admin_monitor_enabled"]))	{$admin_monitor_enabled=$_GET["admin_monitor_enabled"];}
	elseif (isset($_POST["admin_monitor_enabled"]))	{$admin_monitor_enabled=$_POST["admin_monitor_enabled"];}
if (isset($_GET["AFLogging_enabled"]))	{$AFLogging_enabled=$_GET["AFLogging_enabled"];}
	elseif (isset($_POST["AFLogging_enabled"]))	{$AFLogging_enabled=$_POST["AFLogging_enabled"];}
if (isset($_GET["agent_choose_ingroups"]))	{$agent_choose_ingroups=$_GET["agent_choose_ingroups"];}
	elseif (isset($_POST["agent_choose_ingroups"]))	{$agent_choose_ingroups=$_POST["agent_choose_ingroups"];}
if (isset($_GET["agentcall_manual"]))	{$agentcall_manual=$_GET["agentcall_manual"];}
	elseif (isset($_POST["agentcall_manual"]))	{$agentcall_manual=$_POST["agentcall_manual"];}
if (isset($_GET["agentonly_callbacks"]))	{$agentonly_callbacks=$_GET["agentonly_callbacks"];}
	elseif (isset($_POST["agentonly_callbacks"]))	{$agentonly_callbacks=$_POST["agentonly_callbacks"];}
if (isset($_GET["AGI_call_logging_enabled"]))	{$AGI_call_logging_enabled=$_GET["AGI_call_logging_enabled"];}
	elseif (isset($_POST["AGI_call_logging_enabled"]))	{$AGI_call_logging_enabled=$_POST["AGI_call_logging_enabled"];}
if (isset($_GET["agi_output"]))	{$agi_output=$_GET["agi_output"];}
	elseif (isset($_POST["agi_output"]))	{$agi_output=$_POST["agi_output"];}
if (isset($_GET["allcalls_delay"]))	{$allcalls_delay=$_GET["allcalls_delay"];}
	elseif (isset($_POST["allcalls_delay"]))	{$allcalls_delay=$_POST["allcalls_delay"];}
if (isset($_GET["allow_closers"]))	{$allow_closers=$_GET["allow_closers"];}
	elseif (isset($_POST["allow_closers"]))	{$allow_closers=$_POST["allow_closers"];}
if (isset($_GET["alt_number_dialing"]))	{$alt_number_dialing=$_GET["alt_number_dialing"];}
	elseif (isset($_POST["alt_number_dialing"]))	{$alt_number_dialing=$_POST["alt_number_dialing"];}
if (isset($_GET["alter_agent_interface_options"]))	{$alter_agent_interface_options=$_GET["alter_agent_interface_options"];}
	elseif (isset($_POST["alter_agent_interface_options"]))	{$alter_agent_interface_options=$_POST["alter_agent_interface_options"];}
if (isset($_GET["am_message_exten"]))	{$am_message_exten=$_GET["am_message_exten"];}
	elseif (isset($_POST["am_message_exten"]))	{$am_message_exten=$_POST["am_message_exten"];}
if (isset($_GET["amd_send_to_vmx"]))	{$amd_send_to_vmx=$_GET["amd_send_to_vmx"];}
	elseif (isset($_POST["amd_send_to_vmx"]))	{$amd_send_to_vmx=$_POST["amd_send_to_vmx"];}
if (isset($_GET["answer_transfer_agent"]))	{$answer_transfer_agent=$_GET["answer_transfer_agent"];}
	elseif (isset($_POST["answer_transfer_agent"]))	{$answer_transfer_agent=$_POST["answer_transfer_agent"];}
if (isset($_GET["ast_admin_access"]))	{$ast_admin_access=$_GET["ast_admin_access"];}
	elseif (isset($_POST["ast_admin_access"]))	{$ast_admin_access=$_POST["ast_admin_access"];}
if (isset($_GET["ast_delete_phones"]))	{$ast_delete_phones=$_GET["ast_delete_phones"];}
	elseif (isset($_POST["ast_delete_phones"]))	{$ast_delete_phones=$_POST["ast_delete_phones"];}
if (isset($_GET["asterisk_version"]))	{$asterisk_version=$_GET["asterisk_version"];}
	elseif (isset($_POST["asterisk_version"]))	{$asterisk_version=$_POST["asterisk_version"];}
if (isset($_GET["ASTmgrSECRET"]))	{$ASTmgrSECRET=$_GET["ASTmgrSECRET"];}
	elseif (isset($_POST["ASTmgrSECRET"]))	{$ASTmgrSECRET=$_POST["ASTmgrSECRET"];}
if (isset($_GET["ASTmgrUSERNAME"]))	{$ASTmgrUSERNAME=$_GET["ASTmgrUSERNAME"];}
	elseif (isset($_POST["ASTmgrUSERNAME"]))	{$ASTmgrUSERNAME=$_POST["ASTmgrUSERNAME"];}
if (isset($_GET["ASTmgrUSERNAMElisten"]))	{$ASTmgrUSERNAMElisten=$_GET["ASTmgrUSERNAMElisten"];}
	elseif (isset($_POST["ASTmgrUSERNAMElisten"]))	{$ASTmgrUSERNAMElisten=$_POST["ASTmgrUSERNAMElisten"];}
if (isset($_GET["ASTmgrUSERNAMEsend"]))	{$ASTmgrUSERNAMEsend=$_GET["ASTmgrUSERNAMEsend"];}
	elseif (isset($_POST["ASTmgrUSERNAMEsend"]))	{$ASTmgrUSERNAMEsend=$_POST["ASTmgrUSERNAMEsend"];}
if (isset($_GET["ASTmgrUSERNAMEupdate"]))	{$ASTmgrUSERNAMEupdate=$_GET["ASTmgrUSERNAMEupdate"];}
	elseif (isset($_POST["ASTmgrUSERNAMEupdate"]))	{$ASTmgrUSERNAMEupdate=$_POST["ASTmgrUSERNAMEupdate"];}
if (isset($_GET["attempt_delay"]))	{$attempt_delay=$_GET["attempt_delay"];}
	elseif (isset($_POST["attempt_delay"]))	{$attempt_delay=$_POST["attempt_delay"];}
if (isset($_GET["attempt_maximum"]))	{$attempt_maximum=$_GET["attempt_maximum"];}
	elseif (isset($_POST["attempt_maximum"]))	{$attempt_maximum=$_POST["attempt_maximum"];}
if (isset($_GET["auto_dial_level"]))	{$auto_dial_level=$_GET["auto_dial_level"];}
	elseif (isset($_POST["auto_dial_level"]))	{$auto_dial_level=$_POST["auto_dial_level"];}
if (isset($_GET["auto_dial_next_number"]))	{$auto_dial_next_number=$_GET["auto_dial_next_number"];}
	elseif (isset($_POST["auto_dial_next_number"]))	{$auto_dial_next_number=$_POST["auto_dial_next_number"];}
if (isset($_GET["available_only_ratio_tally"]))	{$available_only_ratio_tally=$_GET["available_only_ratio_tally"];}
	elseif (isset($_POST["available_only_ratio_tally"])){$available_only_ratio_tally=$_POST["available_only_ratio_tally"];}
if (isset($_GET["call_out_number_group"]))	{$call_out_number_group=$_GET["call_out_number_group"];}
	elseif (isset($_POST["call_out_number_group"]))	{$call_out_number_group=$_POST["call_out_number_group"];}
if (isset($_GET["call_parking_enabled"]))	{$call_parking_enabled=$_GET["call_parking_enabled"];}
	elseif (isset($_POST["call_parking_enabled"]))	{$call_parking_enabled=$_POST["call_parking_enabled"];}
if (isset($_GET["call_time_comments"]))	{$call_time_comments=$_GET["call_time_comments"];}
	elseif (isset($_POST["call_time_comments"]))	{$call_time_comments=$_POST["call_time_comments"];}
if (isset($_GET["call_time_id"]))	{$call_time_id=$_GET["call_time_id"];}
	elseif (isset($_POST["call_time_id"]))	{$call_time_id=$_POST["call_time_id"];}
if (isset($_GET["call_time_name"]))	{$call_time_name=$_GET["call_time_name"];}
	elseif (isset($_POST["call_time_name"]))	{$call_time_name=$_POST["call_time_name"];}
if (isset($_GET["CallerID_popup_enabled"]))	{$CallerID_popup_enabled=$_GET["CallerID_popup_enabled"];}
	elseif (isset($_POST["CallerID_popup_enabled"]))	{$CallerID_popup_enabled=$_POST["CallerID_popup_enabled"];}
if (isset($_GET["campaign_cid"]))	{$campaign_cid=$_GET["campaign_cid"];}
	elseif (isset($_POST["campaign_cid"]))	{$campaign_cid=$_POST["campaign_cid"];}
if (isset($_GET["campaign_detail"]))	{$campaign_detail=$_GET["campaign_detail"];}
	elseif (isset($_POST["campaign_detail"]))	{$campaign_detail=$_POST["campaign_detail"];}
if (isset($_GET["campaign_id"]))	{$campaign_id=$_GET["campaign_id"];}
	elseif (isset($_POST["campaign_id"]))	{$campaign_id=$_POST["campaign_id"];}
if (isset($_GET["campaign_name"]))	{$campaign_name=$_GET["campaign_name"];}
	elseif (isset($_POST["campaign_name"]))	{$campaign_name=$_POST["campaign_name"];}
if (isset($_GET["campaign_rec_exten"]))	{$campaign_rec_exten=$_GET["campaign_rec_exten"];}
	elseif (isset($_POST["campaign_rec_exten"]))	{$campaign_rec_exten=$_POST["campaign_rec_exten"];}
if (isset($_GET["campaign_rec_filename"]))	{$campaign_rec_filename=$_GET["campaign_rec_filename"];}
	elseif (isset($_POST["campaign_rec_filename"]))	{$campaign_rec_filename=$_POST["campaign_rec_filename"];}
if (isset($_GET["ingroup_rec_filename"]))	{$ingroup_rec_filename=$_GET["ingroup_rec_filename"];}
	elseif (isset($_POST["ingroup_rec_filename"]))	{$ingroup_rec_filename=$_POST["ingroup_rec_filename"];}
if (isset($_GET["campaign_recording"]))	{$campaign_recording=$_GET["campaign_recording"];}
	elseif (isset($_POST["campaign_recording"]))	{$campaign_recording=$_POST["campaign_recording"];}
if (isset($_GET["campaign_vdad_exten"]))	{$campaign_vdad_exten=$_GET["campaign_vdad_exten"];}
	elseif (isset($_POST["campaign_vdad_exten"]))	{$campaign_vdad_exten=$_POST["campaign_vdad_exten"];}
if (isset($_GET["change_agent_campaign"]))	{$change_agent_campaign=$_GET["change_agent_campaign"];}
	elseif (isset($_POST["change_agent_campaign"]))	{$change_agent_campaign=$_POST["change_agent_campaign"];}
if (isset($_GET["client_browser"]))	{$client_browser=$_GET["client_browser"];}
	elseif (isset($_POST["client_browser"]))	{$client_browser=$_POST["client_browser"];}
if (isset($_GET["closer_default_blended"]))	{$closer_default_blended=$_GET["closer_default_blended"];}
	elseif (isset($_POST["closer_default_blended"]))	{$closer_default_blended=$_POST["closer_default_blended"];}
if (isset($_GET["company"]))	{$company=$_GET["company"];}
	elseif (isset($_POST["company"]))	{$company=$_POST["company"];}
if (isset($_GET["computer_ip"]))	{$computer_ip=$_GET["computer_ip"];}
	elseif (isset($_POST["computer_ip"]))	{$computer_ip=$_POST["computer_ip"];}
if (isset($_GET["conf_exten"]))	{$conf_exten=$_GET["conf_exten"];}
	elseif (isset($_POST["conf_exten"]))	{$conf_exten=$_POST["conf_exten"];}
if (isset($_GET["conf_on_extension"]))	{$conf_on_extension=$_GET["conf_on_extension"];}
	elseif (isset($_POST["conf_on_extension"]))	{$conf_on_extension=$_POST["conf_on_extension"];}
if (isset($_GET["conferencing_enabled"]))	{$conferencing_enabled=$_GET["conferencing_enabled"];}
	elseif (isset($_POST["conferencing_enabled"]))	{$conferencing_enabled=$_POST["conferencing_enabled"];}
if (isset($_GET["CoNfIrM"]))	{$CoNfIrM=$_GET["CoNfIrM"];}
	elseif (isset($_POST["CoNfIrM"]))	{$CoNfIrM=$_POST["CoNfIrM"];}
if (isset($_GET["ct_default_start"]))	{$ct_default_start=$_GET["ct_default_start"];}
	elseif (isset($_POST["ct_default_start"]))	{$ct_default_start=$_POST["ct_default_start"];}
if (isset($_GET["ct_default_stop"]))	{$ct_default_stop=$_GET["ct_default_stop"];}
	elseif (isset($_POST["ct_default_stop"]))	{$ct_default_stop=$_POST["ct_default_stop"];}
if (isset($_GET["ct_friday_start"]))	{$ct_friday_start=$_GET["ct_friday_start"];}
	elseif (isset($_POST["ct_friday_start"]))	{$ct_friday_start=$_POST["ct_friday_start"];}
if (isset($_GET["ct_friday_stop"]))	{$ct_friday_stop=$_GET["ct_friday_stop"];}
	elseif (isset($_POST["ct_friday_stop"]))	{$ct_friday_stop=$_POST["ct_friday_stop"];}
if (isset($_GET["ct_monday_start"]))	{$ct_monday_start=$_GET["ct_monday_start"];}
	elseif (isset($_POST["ct_monday_start"]))	{$ct_monday_start=$_POST["ct_monday_start"];}
if (isset($_GET["ct_monday_stop"]))	{$ct_monday_stop=$_GET["ct_monday_stop"];}
	elseif (isset($_POST["ct_monday_stop"]))	{$ct_monday_stop=$_POST["ct_monday_stop"];}
if (isset($_GET["ct_saturday_start"]))	{$ct_saturday_start=$_GET["ct_saturday_start"];}
	elseif (isset($_POST["ct_saturday_start"]))	{$ct_saturday_start=$_POST["ct_saturday_start"];}
if (isset($_GET["ct_saturday_stop"]))	{$ct_saturday_stop=$_GET["ct_saturday_stop"];}
	elseif (isset($_POST["ct_saturday_stop"]))	{$ct_saturday_stop=$_POST["ct_saturday_stop"];}
if (isset($_GET["ct_sunday_start"]))	{$ct_sunday_start=$_GET["ct_sunday_start"];}
	elseif (isset($_POST["ct_sunday_start"]))	{$ct_sunday_start=$_POST["ct_sunday_start"];}
if (isset($_GET["ct_sunday_stop"]))	{$ct_sunday_stop=$_GET["ct_sunday_stop"];}
	elseif (isset($_POST["ct_sunday_stop"]))	{$ct_sunday_stop=$_POST["ct_sunday_stop"];}
if (isset($_GET["ct_thursday_start"]))	{$ct_thursday_start=$_GET["ct_thursday_start"];}
	elseif (isset($_POST["ct_thursday_start"]))	{$ct_thursday_start=$_POST["ct_thursday_start"];}
if (isset($_GET["ct_thursday_stop"]))	{$ct_thursday_stop=$_GET["ct_thursday_stop"];}
	elseif (isset($_POST["ct_thursday_stop"]))	{$ct_thursday_stop=$_POST["ct_thursday_stop"];}
if (isset($_GET["ct_tuesday_start"]))	{$ct_tuesday_start=$_GET["ct_tuesday_start"];}
	elseif (isset($_POST["ct_tuesday_start"]))	{$ct_tuesday_start=$_POST["ct_tuesday_start"];}
if (isset($_GET["ct_tuesday_stop"]))	{$ct_tuesday_stop=$_GET["ct_tuesday_stop"];}
	elseif (isset($_POST["ct_tuesday_stop"]))	{$ct_tuesday_stop=$_POST["ct_tuesday_stop"];}
if (isset($_GET["ct_wednesday_start"]))	{$ct_wednesday_start=$_GET["ct_wednesday_start"];}
	elseif (isset($_POST["ct_wednesday_start"]))	{$ct_wednesday_start=$_POST["ct_wednesday_start"];}
if (isset($_GET["ct_wednesday_stop"]))	{$ct_wednesday_stop=$_GET["ct_wednesday_stop"];}
	elseif (isset($_POST["ct_wednesday_stop"]))	{$ct_wednesday_stop=$_POST["ct_wednesday_stop"];}
if (isset($_GET["DBX_database"]))	{$DBX_database=$_GET["DBX_database"];}
	elseif (isset($_POST["DBX_database"]))	{$DBX_database=$_POST["DBX_database"];}
if (isset($_GET["DBX_pass"]))	{$DBX_pass=$_GET["DBX_pass"];}
	elseif (isset($_POST["DBX_pass"]))	{$DBX_pass=$_POST["DBX_pass"];}
if (isset($_GET["DBX_port"]))	{$DBX_port=$_GET["DBX_port"];}
	elseif (isset($_POST["DBX_port"]))	{$DBX_port=$_POST["DBX_port"];}
if (isset($_GET["DBX_server"]))	{$DBX_server=$_GET["DBX_server"];}
	elseif (isset($_POST["DBX_server"]))	{$DBX_server=$_POST["DBX_server"];}
if (isset($_GET["DBX_user"]))	{$DBX_user=$_GET["DBX_user"];}
	elseif (isset($_POST["DBX_user"]))	{$DBX_user=$_POST["DBX_user"];}
if (isset($_GET["DBY_database"]))	{$DBY_database=$_GET["DBY_database"];}
	elseif (isset($_POST["DBY_database"]))	{$DBY_database=$_POST["DBY_database"];}
if (isset($_GET["DBY_pass"]))	{$DBY_pass=$_GET["DBY_pass"];}
	elseif (isset($_POST["DBY_pass"]))	{$DBY_pass=$_POST["DBY_pass"];}
if (isset($_GET["DBY_port"]))	{$DBY_port=$_GET["DBY_port"];}
	elseif (isset($_POST["DBY_port"]))	{$DBY_port=$_POST["DBY_port"];}
if (isset($_GET["DBY_server"]))	{$DBY_server=$_GET["DBY_server"];}
	elseif (isset($_POST["DBY_server"]))	{$DBY_server=$_POST["DBY_server"];}
if (isset($_GET["DBY_user"]))	{$DBY_user=$_GET["DBY_user"];}
	elseif (isset($_POST["DBY_user"]))	{$DBY_user=$_POST["DBY_user"];}
if (isset($_GET["delete_call_times"]))	{$delete_call_times=$_GET["delete_call_times"];}
	elseif (isset($_POST["delete_call_times"]))	{$delete_call_times=$_POST["delete_call_times"];}
if (isset($_GET["delete_campaigns"]))	{$delete_campaigns=$_GET["delete_campaigns"];}
	elseif (isset($_POST["delete_campaigns"]))	{$delete_campaigns=$_POST["delete_campaigns"];}
if (isset($_GET["delete_filters"]))	{$delete_filters=$_GET["delete_filters"];}
	elseif (isset($_POST["delete_filters"]))	{$delete_filters=$_POST["delete_filters"];}
if (isset($_GET["delete_ingroups"]))	{$delete_ingroups=$_GET["delete_ingroups"];}
	elseif (isset($_POST["delete_ingroups"]))	{$delete_ingroups=$_POST["delete_ingroups"];}
if (isset($_GET["delete_lists"]))	{$delete_lists=$_GET["delete_lists"];}
	elseif (isset($_POST["delete_lists"]))	{$delete_lists=$_POST["delete_lists"];}
if (isset($_GET["delete_remote_agents"]))	{$delete_remote_agents=$_GET["delete_remote_agents"];}
	elseif (isset($_POST["delete_remote_agents"]))	{$delete_remote_agents=$_POST["delete_remote_agents"];}
if (isset($_GET["delete_scripts"]))	{$delete_scripts=$_GET["delete_scripts"];}
	elseif (isset($_POST["delete_scripts"]))	{$delete_scripts=$_POST["delete_scripts"];}
if (isset($_GET["delete_user_groups"]))	{$delete_user_groups=$_GET["delete_user_groups"];}
	elseif (isset($_POST["delete_user_groups"]))	{$delete_user_groups=$_POST["delete_user_groups"];}
if (isset($_GET["delete_users"]))	{$delete_users=$_GET["delete_users"];}
	elseif (isset($_POST["delete_users"]))	{$delete_users=$_POST["delete_users"];}
if (isset($_GET["dial_method"]))	{$dial_method=$_GET["dial_method"];}
	elseif (isset($_POST["dial_method"]))	{$dial_method=$_POST["dial_method"];}
if (isset($_GET["dial_prefix"]))	{$dial_prefix=$_GET["dial_prefix"];}
	elseif (isset($_POST["dial_prefix"]))	{$dial_prefix=$_POST["dial_prefix"];}
if (isset($_GET["dial_status_a"]))	{$dial_status_a=$_GET["dial_status_a"];}
	elseif (isset($_POST["dial_status_a"]))	{$dial_status_a=$_POST["dial_status_a"];}
if (isset($_GET["dial_status_b"]))	{$dial_status_b=$_GET["dial_status_b"];}
	elseif (isset($_POST["dial_status_b"]))	{$dial_status_b=$_POST["dial_status_b"];}
if (isset($_GET["dial_status_c"]))	{$dial_status_c=$_GET["dial_status_c"];}
	elseif (isset($_POST["dial_status_c"]))	{$dial_status_c=$_POST["dial_status_c"];}
if (isset($_GET["dial_status_d"]))	{$dial_status_d=$_GET["dial_status_d"];}
	elseif (isset($_POST["dial_status_d"]))	{$dial_status_d=$_POST["dial_status_d"];}
if (isset($_GET["dial_status_e"]))	{$dial_status_e=$_GET["dial_status_e"];}
	elseif (isset($_POST["dial_status_e"]))	{$dial_status_e=$_POST["dial_status_e"];}
if (isset($_GET["dial_timeout"]))	{$dial_timeout=$_GET["dial_timeout"];}
	elseif (isset($_POST["dial_timeout"]))	{$dial_timeout=$_POST["dial_timeout"];}
if (isset($_GET["dialplan_number"]))	{$dialplan_number=$_GET["dialplan_number"];}
	elseif (isset($_POST["dialplan_number"]))	{$dialplan_number=$_POST["dialplan_number"];}
if (isset($_GET["drop_call_seconds"]))	{$drop_call_seconds=$_GET["drop_call_seconds"];}
	elseif (isset($_POST["drop_call_seconds"]))	{$drop_call_seconds=$_POST["drop_call_seconds"];}
if (isset($_GET["drop_exten"]))	{$drop_exten=$_GET["drop_exten"];}
	elseif (isset($_POST["drop_exten"]))	{$drop_exten=$_POST["drop_exten"];}
if (isset($_GET["drop_action"]))	{$drop_action=$_GET["drop_action"];}
	elseif (isset($_POST["drop_action"]))	{$drop_action=$_POST["drop_action"];}
if (isset($_GET["dtmf_send_extension"]))	{$dtmf_send_extension=$_GET["dtmf_send_extension"];}
	elseif (isset($_POST["dtmf_send_extension"]))	{$dtmf_send_extension=$_POST["dtmf_send_extension"];}
if (isset($_GET["enable_fast_refresh"]))	{$enable_fast_refresh=$_GET["enable_fast_refresh"];}
	elseif (isset($_POST["enable_fast_refresh"]))	{$enable_fast_refresh=$_POST["enable_fast_refresh"];}
if (isset($_GET["enable_persistant_mysql"]))	{$enable_persistant_mysql=$_GET["enable_persistant_mysql"];}
	elseif (isset($_POST["enable_persistant_mysql"]))	{$enable_persistant_mysql=$_POST["enable_persistant_mysql"];}
if (isset($_GET["ext_context"]))	{$ext_context=$_GET["ext_context"];}
	elseif (isset($_POST["ext_context"]))	{$ext_context=$_POST["ext_context"];}
if (isset($_GET["extension"]))	{$extension=$_GET["extension"];}
	elseif (isset($_POST["extension"]))	{$extension=$_POST["extension"];}
if (isset($_GET["fast_refresh_rate"]))	{$fast_refresh_rate=$_GET["fast_refresh_rate"];}
	elseif (isset($_POST["fast_refresh_rate"]))	{$fast_refresh_rate=$_POST["fast_refresh_rate"];}
if (isset($_GET["force_logout"]))	{$force_logout=$_GET["force_logout"];}
	elseif (isset($_POST["force_logout"]))	{$force_logout=$_POST["force_logout"];}
if (isset($_GET["fronter_display"]))	{$fronter_display=$_GET["fronter_display"];}
	elseif (isset($_POST["fronter_display"]))	{$fronter_display=$_POST["fronter_display"];}
if (isset($_GET["full_name"]))	{$full_name=$_GET["full_name"];}
	elseif (isset($_POST["full_name"]))	{$full_name=$_POST["full_name"];}
if (isset($_GET["fullname"]))	{$fullname=$_GET["fullname"];}
	elseif (isset($_POST["fullname"]))	{$fullname=$_POST["fullname"];}
if (isset($_GET["get_call_launch"]))	{$get_call_launch=$_GET["get_call_launch"];}
	elseif (isset($_POST["get_call_launch"]))	{$get_call_launch=$_POST["get_call_launch"];}
if (isset($_GET["group_color"]))	{$group_color=$_GET["group_color"];}
	elseif (isset($_POST["group_color"]))	{$group_color=$_POST["group_color"];}
if (isset($_GET["group_id"]))	{$group_id=$_GET["group_id"];}
	elseif (isset($_POST["group_id"]))	{$group_id=$_POST["group_id"];}
if (isset($_GET["group_name"]))	{$group_name=$_GET["group_name"];}
	elseif (isset($_POST["group_name"]))	{$group_name=$_POST["group_name"];}
if (isset($_GET["groups"]))	{$groups=$_GET["groups"];}
	elseif (isset($_POST["groups"]))	{$groups=$_POST["groups"];}
if (isset($_GET["XFERgroups"]))	{$XFERgroups=$_GET["XFERgroups"];}
	elseif (isset($_POST["XFERgroups"]))	{$XFERgroups=$_POST["XFERgroups"];}
if (isset($_GET["HKstatus"]))	{$HKstatus=$_GET["HKstatus"];}
	elseif (isset($_POST["HKstatus"]))	{$HKstatus=$_POST["HKstatus"];}
if (isset($_GET["hopper_level"]))	{$hopper_level=$_GET["hopper_level"];}
	elseif (isset($_POST["hopper_level"]))	{$hopper_level=$_POST["hopper_level"];}
if (isset($_GET["hotkey"]))	{$hotkey=$_GET["hotkey"];}
	elseif (isset($_POST["hotkey"]))	{$hotkey=$_POST["hotkey"];}
if (isset($_GET["hotkeys_active"]))	{$hotkeys_active=$_GET["hotkeys_active"];}
	elseif (isset($_POST["hotkeys_active"]))	{$hotkeys_active=$_POST["hotkeys_active"];}
if (isset($_GET["install_directory"]))	{$install_directory=$_GET["install_directory"];}
	elseif (isset($_POST["install_directory"]))	{$install_directory=$_POST["install_directory"];}
if (isset($_GET["lead_filter_comments"]))	{$lead_filter_comments=$_GET["lead_filter_comments"];}
	elseif (isset($_POST["lead_filter_comments"]))	{$lead_filter_comments=$_POST["lead_filter_comments"];}
if (isset($_GET["lead_filter_id"]))	{$lead_filter_id=$_GET["lead_filter_id"];}
	elseif (isset($_POST["lead_filter_id"]))	{$lead_filter_id=$_POST["lead_filter_id"];}
if (isset($_GET["lead_filter_name"]))	{$lead_filter_name=$_GET["lead_filter_name"];}
	elseif (isset($_POST["lead_filter_name"]))	{$lead_filter_name=$_POST["lead_filter_name"];}
if (isset($_GET["lead_filter_sql"]))	{$lead_filter_sql=$_GET["lead_filter_sql"];}
	elseif (isset($_POST["lead_filter_sql"]))	{$lead_filter_sql=$_POST["lead_filter_sql"];}
if (isset($_GET["lead_order"]))	{$lead_order=$_GET["lead_order"];}
	elseif (isset($_POST["lead_order"]))	{$lead_order=$_POST["lead_order"];}
if (isset($_GET["list_id"]))	{$list_id=$_GET["list_id"];}
	elseif (isset($_POST["list_id"]))	{$list_id=$_POST["list_id"];}
if (isset($_GET["list_name"]))	{$list_name=$_GET["list_name"];}
	elseif (isset($_POST["list_name"]))	{$list_name=$_POST["list_name"];}
if (isset($_GET["load_leads"]))	{$load_leads=$_GET["load_leads"];}
	elseif (isset($_POST["load_leads"]))	{$load_leads=$_POST["load_leads"];}
if (isset($_GET["local_call_time"]))	{$local_call_time=$_GET["local_call_time"];}
	elseif (isset($_POST["local_call_time"]))	{$local_call_time=$_POST["local_call_time"];}
if (isset($_GET["local_gmt"]))	{$local_gmt=$_GET["local_gmt"];}
	elseif (isset($_POST["local_gmt"]))	{$local_gmt=$_POST["local_gmt"];}
if (isset($_GET["local_web_callerID_URL"]))	{$local_web_callerID_URL=$_GET["local_web_callerID_URL"];}
	elseif (isset($_POST["local_web_callerID_URL"]))	{$local_web_callerID_URL=$_POST["local_web_callerID_URL"];}
if (isset($_GET["login"]))	{$login=$_GET["login"];}
	elseif (isset($_POST["login"]))	{$login=$_POST["login"];}
if (isset($_GET["login_campaign"]))	{$login_campaign=$_GET["login_campaign"];}
	elseif (isset($_POST["login_campaign"]))	{$login_campaign=$_POST["login_campaign"];}
if (isset($_GET["login_pass"]))	{$login_pass=$_GET["login_pass"];}
	elseif (isset($_POST["login_pass"]))	{$login_pass=$_POST["login_pass"];}
if (isset($_GET["login_user"]))	{$login_user=$_GET["login_user"];}
	elseif (isset($_POST["login_user"]))	{$login_user=$_POST["login_user"];}
if (isset($_GET["max_vicidial_trunks"]))	{$max_vicidial_trunks=$_GET["max_vicidial_trunks"];}
	elseif (isset($_POST["max_vicidial_trunks"]))	{$max_vicidial_trunks=$_POST["max_vicidial_trunks"];}
if (isset($_GET["modify_call_times"]))	{$modify_call_times=$_GET["modify_call_times"];}
	elseif (isset($_POST["modify_call_times"]))	{$modify_call_times=$_POST["modify_call_times"];}
if (isset($_GET["modify_leads"]))	{$modify_leads=$_GET["modify_leads"];}
	elseif (isset($_POST["modify_leads"]))	{$modify_leads=$_POST["modify_leads"];}
if (isset($_GET["monitor_prefix"]))	{$monitor_prefix=$_GET["monitor_prefix"];}
	elseif (isset($_POST["monitor_prefix"]))	{$monitor_prefix=$_POST["monitor_prefix"];}
if (isset($_GET["next_agent_call"]))	{$next_agent_call=$_GET["next_agent_call"];}
	elseif (isset($_POST["next_agent_call"]))	{$next_agent_call=$_POST["next_agent_call"];}
if (isset($_GET["number_of_lines"]))	{$number_of_lines=$_GET["number_of_lines"];}
	elseif (isset($_POST["number_of_lines"]))	{$number_of_lines=$_POST["number_of_lines"];}
if (isset($_GET["old_campaign_id"]))	{$old_campaign_id=$_GET["old_campaign_id"];}
	elseif (isset($_POST["old_campaign_id"]))	{$old_campaign_id=$_POST["old_campaign_id"];}
if (isset($_GET["old_conf_exten"]))	{$old_conf_exten=$_GET["old_conf_exten"];}
	elseif (isset($_POST["old_conf_exten"]))	{$old_conf_exten=$_POST["old_conf_exten"];}
if (isset($_GET["old_extension"]))	{$old_extension=$_GET["old_extension"];}
	elseif (isset($_POST["old_extension"]))	{$old_extension=$_POST["old_extension"];}
if (isset($_GET["old_server_id"]))	{$old_server_id=$_GET["old_server_id"];}
	elseif (isset($_POST["old_server_id"]))	{$old_server_id=$_POST["old_server_id"];}
if (isset($_GET["old_server_ip"]))	{$old_server_ip=$_GET["old_server_ip"];}
	elseif (isset($_POST["old_server_ip"]))	{$old_server_ip=$_POST["old_server_ip"];}
if (isset($_GET["OLDuser_group"]))	{$OLDuser_group=$_GET["OLDuser_group"];}
	elseif (isset($_POST["OLDuser_group"]))	{$OLDuser_group=$_POST["OLDuser_group"];}
if (isset($_GET["omit_phone_code"]))	{$omit_phone_code=$_GET["omit_phone_code"];}
	elseif (isset($_POST["omit_phone_code"]))	{$omit_phone_code=$_POST["omit_phone_code"];}
if (isset($_GET["outbound_cid"]))	{$outbound_cid=$_GET["outbound_cid"];}
	elseif (isset($_POST["outbound_cid"]))	{$outbound_cid=$_POST["outbound_cid"];}
if (isset($_GET["park_ext"]))	{$park_ext=$_GET["park_ext"];}
	elseif (isset($_POST["park_ext"]))	{$park_ext=$_POST["park_ext"];}
if (isset($_GET["park_file_name"]))	{$park_file_name=$_GET["park_file_name"];}
	elseif (isset($_POST["park_file_name"]))	{$park_file_name=$_POST["park_file_name"];}
if (isset($_GET["park_on_extension"]))	{$park_on_extension=$_GET["park_on_extension"];}
	elseif (isset($_POST["park_on_extension"]))	{$park_on_extension=$_POST["park_on_extension"];}
if (isset($_GET["pass"]))	{$pass=$_GET["pass"];}
	elseif (isset($_POST["pass"]))	{$pass=$_POST["pass"];}
if (isset($_GET["phone_ip"]))	{$phone_ip=$_GET["phone_ip"];}
	elseif (isset($_POST["phone_ip"]))	{$phone_ip=$_POST["phone_ip"];}
if (isset($_GET["phone_login"]))	{$phone_login=$_GET["phone_login"];}
	elseif (isset($_POST["phone_login"]))	{$phone_login=$_POST["phone_login"];}
if (isset($_GET["phone_number"]))	{$phone_number=$_GET["phone_number"];}
	elseif (isset($_POST["phone_number"]))	{$phone_number=$_POST["phone_number"];}
if (isset($_GET["phone_pass"]))	{$phone_pass=$_GET["phone_pass"];}
	elseif (isset($_POST["phone_pass"]))	{$phone_pass=$_POST["phone_pass"];}
if (isset($_GET["phone_type"]))	{$phone_type=$_GET["phone_type"];}
	elseif (isset($_POST["phone_type"]))	{$phone_type=$_POST["phone_type"];}
if (isset($_GET["picture"]))	{$picture=$_GET["picture"];}
	elseif (isset($_POST["picture"]))	{$picture=$_POST["picture"];}
if (isset($_GET["protocol"]))	{$protocol=$_GET["protocol"];}
	elseif (isset($_POST["protocol"]))	{$protocol=$_POST["protocol"];}
if (isset($_GET["QUEUE_ACTION_enabled"]))	{$QUEUE_ACTION_enabled=$_GET["QUEUE_ACTION_enabled"];}
	elseif (isset($_POST["QUEUE_ACTION_enabled"]))	{$QUEUE_ACTION_enabled=$_POST["QUEUE_ACTION_enabled"];}
if (isset($_GET["recording_exten"]))	{$recording_exten=$_GET["recording_exten"];}
	elseif (isset($_POST["recording_exten"]))	{$recording_exten=$_POST["recording_exten"];}
if (isset($_GET["remote_agent_id"]))	{$remote_agent_id=$_GET["remote_agent_id"];}
	elseif (isset($_POST["remote_agent_id"]))	{$remote_agent_id=$_POST["remote_agent_id"];}
if (isset($_GET["reset_hopper"]))	{$reset_hopper=$_GET["reset_hopper"];}
	elseif (isset($_POST["reset_hopper"]))	{$reset_hopper=$_POST["reset_hopper"];}
if (isset($_GET["reset_list"]))	{$reset_list=$_GET["reset_list"];}
	elseif (isset($_POST["reset_list"]))	{$reset_list=$_POST["reset_list"];}
if (isset($_GET["safe_harbor_exten"]))	{$safe_harbor_exten=$_GET["safe_harbor_exten"];}
	elseif (isset($_POST["safe_harbor_exten"]))	{$safe_harbor_exten=$_POST["safe_harbor_exten"];}
if (isset($_GET["drop_action"]))	{$drop_action=$_GET["drop_action"];}
	elseif (isset($_POST["drop_action"]))	{$drop_action=$_POST["drop_action"];}
if (isset($_GET["scheduled_callbacks"]))	{$scheduled_callbacks=$_GET["scheduled_callbacks"];}
	elseif (isset($_POST["scheduled_callbacks"]))	{$scheduled_callbacks=$_POST["scheduled_callbacks"];}
if (isset($_GET["script_comments"]))	{$script_comments=$_GET["script_comments"];}
	elseif (isset($_POST["script_comments"]))	{$script_comments=$_POST["script_comments"];}
if (isset($_GET["script_id"]))	{$script_id=$_GET["script_id"];}
	elseif (isset($_POST["script_id"]))	{$script_id=$_POST["script_id"];}
if (isset($_GET["script_name"]))	{$script_name=$_GET["script_name"];}
	elseif (isset($_POST["script_name"]))	{$script_name=$_POST["script_name"];}
if (isset($_GET["script_text"]))	{$script_text=$_GET["script_text"];}
	elseif (isset($_POST["script_text"]))	{$script_text=$_POST["script_text"];}
if (isset($_GET["selectable"]))	{$selectable=$_GET["selectable"];}
	elseif (isset($_POST["selectable"]))	{$selectable=$_POST["selectable"];}
if (isset($_GET["server_description"]))	{$server_description=$_GET["server_description"];}
	elseif (isset($_POST["server_description"]))	{$server_description=$_POST["server_description"];}
if (isset($_GET["server_id"]))	{$server_id=$_GET["server_id"];}
	elseif (isset($_POST["server_id"]))	{$server_id=$_POST["server_id"];}
if (isset($_GET["server_ip"]))	{$server_ip=$_GET["server_ip"];}
	elseif (isset($_POST["server_ip"]))	{$server_ip=$_POST["server_ip"];}
if (isset($_GET["stage"]))	{$stage=$_GET["stage"];}
	elseif (isset($_POST["stage"]))	{$stage=$_POST["stage"];}
if (isset($_GET["state_call_time_state"]))	{$state_call_time_state=$_GET["state_call_time_state"];}
	elseif (isset($_POST["state_call_time_state"]))	{$state_call_time_state=$_POST["state_call_time_state"];}
if (isset($_GET["state_rule"]))	{$state_rule=$_GET["state_rule"];}
	elseif (isset($_POST["state_rule"]))	{$state_rule=$_POST["state_rule"];}
if (isset($_GET["status"]))	{$status=$_GET["status"];}
	elseif (isset($_POST["status"]))	{$status=$_POST["status"];}
if (isset($_GET["status_name"]))	{$status_name=$_GET["status_name"];}
	elseif (isset($_POST["status_name"]))	{$status_name=$_POST["status_name"];}
if (isset($_GET["submit"]))	{$submit=$_GET["submit"];}
	elseif (isset($_POST["submit"]))	{$submit=$_POST["submit"];}
if (isset($_GET["INVIA"]))	{$INVIA=$_GET["INVIA"];}
	elseif (isset($_POST["INVIA"]))	{$INVIA=$_POST["INVIA"];}
if (isset($_GET["sys_perf_log"]))	{$sys_perf_log=$_GET["sys_perf_log"];}
	elseif (isset($_POST["sys_perf_log"]))	{$sys_perf_log=$_POST["sys_perf_log"];}
if (isset($_GET["telnet_host"]))	{$telnet_host=$_GET["telnet_host"];}
	elseif (isset($_POST["telnet_host"]))	{$telnet_host=$_POST["telnet_host"];}
if (isset($_GET["telnet_port"]))	{$telnet_port=$_GET["telnet_port"];}
	elseif (isset($_POST["telnet_port"]))	{$telnet_port=$_POST["telnet_port"];}
if (isset($_GET["updater_check_enabled"]))	{$updater_check_enabled=$_GET["updater_check_enabled"];}
	elseif (isset($_POST["updater_check_enabled"]))	{$updater_check_enabled=$_POST["updater_check_enabled"];}
if (isset($_GET["use_internal_dnc"]))	{$use_internal_dnc=$_GET["use_internal_dnc"];}
	elseif (isset($_POST["use_internal_dnc"]))	{$use_internal_dnc=$_POST["use_internal_dnc"];}
if (isset($_GET["use_campaign_dnc"]))	{$use_campaign_dnc=$_GET["use_campaign_dnc"];}
	elseif (isset($_POST["use_campaign_dnc"]))	{$use_campaign_dnc=$_POST["use_campaign_dnc"];}
if (isset($_GET["user"]))	{$user=$_GET["user"];}
	elseif (isset($_POST["user"]))	{$user=$_POST["user"];}
if (isset($_GET["user_group"]))	{$user_group=$_GET["user_group"];}
	elseif (isset($_POST["user_group"]))	{$user_group=$_POST["user_group"];}
if (isset($_GET["user_level"]))	{$user_level=$_GET["user_level"];}
	elseif (isset($_POST["user_level"]))	{$user_level=$_POST["user_level"];}
if (isset($_GET["user_start"]))	{$user_start=$_GET["user_start"];}
	elseif (isset($_POST["user_start"]))	{$user_start=$_POST["user_start"];}
if (isset($_GET["user_switching_enabled"]))	{$user_switching_enabled=$_GET["user_switching_enabled"];}
	elseif (isset($_POST["user_switching_enabled"]))	{$user_switching_enabled=$_POST["user_switching_enabled"];}
if (isset($_GET["vd_server_logs"]))	{$vd_server_logs=$_GET["vd_server_logs"];}
	elseif (isset($_POST["vd_server_logs"]))	{$vd_server_logs=$_POST["vd_server_logs"];}
if (isset($_GET["VDstop_rec_after_each_call"]))	{$VDstop_rec_after_each_call=$_GET["VDstop_rec_after_each_call"];}
	elseif (isset($_POST["VDstop_rec_after_each_call"]))	{$VDstop_rec_after_each_call=$_POST["VDstop_rec_after_each_call"];}
if (isset($_GET["VICIDIAL_park_on_extension"]))	{$VICIDIAL_park_on_extension=$_GET["VICIDIAL_park_on_extension"];}
	elseif (isset($_POST["VICIDIAL_park_on_extension"]))	{$VICIDIAL_park_on_extension=$_POST["VICIDIAL_park_on_extension"];}
if (isset($_GET["VICIDIAL_park_on_filename"]))	{$VICIDIAL_park_on_filename=$_GET["VICIDIAL_park_on_filename"];}
	elseif (isset($_POST["VICIDIAL_park_on_filename"]))	{$VICIDIAL_park_on_filename=$_POST["VICIDIAL_park_on_filename"];}
if (isset($_GET["vicidial_recording"]))	{$vicidial_recording=$_GET["vicidial_recording"];}
	elseif (isset($_POST["vicidial_recording"]))	{$vicidial_recording=$_POST["vicidial_recording"];}
if (isset($_GET["vicidial_transfers"]))	{$vicidial_transfers=$_GET["vicidial_transfers"];}
	elseif (isset($_POST["vicidial_transfers"]))	{$vicidial_transfers=$_POST["vicidial_transfers"];}
if (isset($_GET["VICIDIAL_web_URL"]))	{$VICIDIAL_web_URL=$_GET["VICIDIAL_web_URL"];}
	elseif (isset($_POST["VICIDIAL_web_URL"]))	{$VICIDIAL_web_URL=$_POST["VICIDIAL_web_URL"];}
if (isset($_GET["voicemail_button_enabled"]))	{$voicemail_button_enabled=$_GET["voicemail_button_enabled"];}
	elseif (isset($_POST["voicemail_button_enabled"]))	{$voicemail_button_enabled=$_POST["voicemail_button_enabled"];}
if (isset($_GET["voicemail_dump_exten"]))	{$voicemail_dump_exten=$_GET["voicemail_dump_exten"];}
	elseif (isset($_POST["voicemail_dump_exten"]))	{$voicemail_dump_exten=$_POST["voicemail_dump_exten"];}
if (isset($_GET["voicemail_ext"]))	{$voicemail_ext=$_GET["voicemail_ext"];}
	elseif (isset($_POST["voicemail_ext"]))	{$voicemail_ext=$_POST["voicemail_ext"];}
if (isset($_GET["voicemail_exten"]))	{$voicemail_exten=$_GET["voicemail_exten"];}
	elseif (isset($_POST["voicemail_exten"]))	{$voicemail_exten=$_POST["voicemail_exten"];}
if (isset($_GET["voicemail_id"]))	{$voicemail_id=$_GET["voicemail_id"];}
	elseif (isset($_POST["voicemail_id"]))	{$voicemail_id=$_POST["voicemail_id"];}
if (isset($_GET["web_form_address"]))	{$web_form_address=$_GET["web_form_address"];}
	elseif (isset($_POST["web_form_address"]))	{$web_form_address=$_POST["web_form_address"];}
if (isset($_GET["wrapup_message"]))	{$wrapup_message=$_GET["wrapup_message"];}
	elseif (isset($_POST["wrapup_message"]))	{$wrapup_message=$_POST["wrapup_message"];}
if (isset($_GET["wrapup_seconds"]))	{$wrapup_seconds=$_GET["wrapup_seconds"];}
	elseif (isset($_POST["wrapup_seconds"]))	{$wrapup_seconds=$_POST["wrapup_seconds"];}
if (isset($_GET["xferconf_a_dtmf"]))	{$xferconf_a_dtmf=$_GET["xferconf_a_dtmf"];}
	elseif (isset($_POST["xferconf_a_dtmf"]))	{$xferconf_a_dtmf=$_POST["xferconf_a_dtmf"];}
if (isset($_GET["xferconf_a_number"]))	{$xferconf_a_number=$_GET["xferconf_a_number"];}
	elseif (isset($_POST["xferconf_a_number"]))	{$xferconf_a_number=$_POST["xferconf_a_number"];}
if (isset($_GET["xferconf_b_dtmf"]))	{$xferconf_b_dtmf=$_GET["xferconf_b_dtmf"];}
	elseif (isset($_POST["xferconf_b_dtmf"]))	{$xferconf_b_dtmf=$_POST["xferconf_b_dtmf"];}
if (isset($_GET["xferconf_b_number"]))	{$xferconf_b_number=$_GET["xferconf_b_number"];}
	elseif (isset($_POST["xferconf_b_number"]))	{$xferconf_b_number=$_POST["xferconf_b_number"];}
if (isset($_GET["vicidial_balance_active"]))	{$vicidial_balance_active=$_GET["vicidial_balance_active"];}
	elseif (isset($_POST["vicidial_balance_active"]))	{$vicidial_balance_active=$_POST["vicidial_balance_active"];}
if (isset($_GET["balance_trunks_offlimits"]))	{$balance_trunks_offlimits=$_GET["balance_trunks_offlimits"];}
	elseif (isset($_POST["balance_trunks_offlimits"]))	{$balance_trunks_offlimits=$_POST["balance_trunks_offlimits"];}
if (isset($_GET["dedicated_trunks"]))	{$dedicated_trunks=$_GET["dedicated_trunks"];}
	elseif (isset($_POST["dedicated_trunks"]))	{$dedicated_trunks=$_POST["dedicated_trunks"];}
if (isset($_GET["trunk_restriction"]))	{$trunk_restriction=$_GET["trunk_restriction"];}
	elseif (isset($_POST["trunk_restriction"]))	{$trunk_restriction=$_POST["trunk_restriction"];}
if (isset($_GET["campaigns"]))						{$campaigns=$_GET["campaigns"];}
	elseif (isset($_POST["campaigns"]))				{$campaigns=$_POST["campaigns"];}
if (isset($_GET["dial_level_override"]))			{$dial_level_override=$_GET["dial_level_override"];}
	elseif (isset($_POST["dial_level_override"]))	{$dial_level_override=$_POST["dial_level_override"];}
if (isset($_GET["concurrent_transfers"]))			{$concurrent_transfers=$_GET["concurrent_transfers"];}
	elseif (isset($_POST["concurrent_transfers"]))	{$concurrent_transfers=$_POST["concurrent_transfers"];}
if (isset($_GET["auto_alt_dial"]))			{$auto_alt_dial=$_GET["auto_alt_dial"];}
	elseif (isset($_POST["auto_alt_dial"]))	{$auto_alt_dial=$_POST["auto_alt_dial"];}
if (isset($_GET["modify_users"]))				{$modify_users=$_GET["modify_users"];}
	elseif (isset($_POST["modify_users"]))		{$modify_users=$_POST["modify_users"];}
if (isset($_GET["modify_campaigns"]))			{$modify_campaigns=$_GET["modify_campaigns"];}
	elseif (isset($_POST["modify_campaigns"]))	{$modify_campaigns=$_POST["modify_campaigns"];}
if (isset($_GET["modify_lists"]))				{$modify_lists=$_GET["modify_lists"];}
	elseif (isset($_POST["modify_lists"]))		{$modify_lists=$_POST["modify_lists"];}
if (isset($_GET["modify_scripts"]))				{$modify_scripts=$_GET["modify_scripts"];}
	elseif (isset($_POST["modify_scripts"]))	{$modify_scripts=$_POST["modify_scripts"];}
if (isset($_GET["modify_filters"]))				{$modify_filters=$_GET["modify_filters"];}
	elseif (isset($_POST["modify_filters"]))	{$modify_filters=$_POST["modify_filters"];}
if (isset($_GET["modify_ingroups"]))			{$modify_ingroups=$_GET["modify_ingroups"];}
	elseif (isset($_POST["modify_ingroups"]))	{$modify_ingroups=$_POST["modify_ingroups"];}
if (isset($_GET["modify_usergroups"]))			{$modify_usergroups=$_GET["modify_usergroups"];}
	elseif (isset($_POST["modify_usergroups"]))	{$modify_usergroups=$_POST["modify_usergroups"];}
if (isset($_GET["modify_remoteagents"]))			{$modify_remoteagents=$_GET["modify_remoteagents"];}
	elseif (isset($_POST["modify_remoteagents"]))	{$modify_remoteagents=$_POST["modify_remoteagents"];}
if (isset($_GET["modify_servers"]))				{$modify_servers=$_GET["modify_servers"];}
	elseif (isset($_POST["modify_servers"]))	{$modify_servers=$_POST["modify_servers"];}
if (isset($_GET["view_reports"]))				{$view_reports=$_GET["view_reports"];}
	elseif (isset($_POST["view_reports"]))		{$view_reports=$_POST["view_reports"];}
if (isset($_GET["agent_pause_codes_active"]))			{$agent_pause_codes_active=$_GET["agent_pause_codes_active"];}
	elseif (isset($_POST["agent_pause_codes_active"]))	{$agent_pause_codes_active=$_POST["agent_pause_codes_active"];}
if (isset($_GET["pause_code"]))					{$pause_code=$_GET["pause_code"];}
	elseif (isset($_POST["pause_code"]))		{$pause_code=$_POST["pause_code"];}
if (isset($_GET["pause_code_name"]))			{$pause_code_name=$_GET["pause_code_name"];}
	elseif (isset($_POST["pause_code_name"]))	{$pause_code_name=$_POST["pause_code_name"];}
if (isset($_GET["billable"]))					{$billable=$_GET["billable"];}
	elseif (isset($_POST["billable"]))			{$billable=$_POST["billable"];}
if (isset($_GET["campaign_description"]))			{$campaign_description=$_GET["campaign_description"];}
	elseif (isset($_POST["campaign_description"]))	{$campaign_description=$_POST["campaign_description"];}
if (isset($_GET["campaign_stats_refresh"]))			{$campaign_stats_refresh=$_GET["campaign_stats_refresh"];}
	elseif (isset($_POST["campaign_stats_refresh"])){$campaign_stats_refresh=$_POST["campaign_stats_refresh"];}
if (isset($_GET["list_description"]))			{$list_description=$_GET["list_description"];}
	elseif (isset($_POST["list_description"]))	{$list_description=$_POST["list_description"];}
if (isset($_GET["vicidial_recording_override"]))		{$vicidial_recording_override=$_GET["vicidial_recording_override"];}	
	elseif (isset($_POST["vicidial_recording_override"]))	{$vicidial_recording_override=$_POST["vicidial_recording_override"];}
if (isset($_GET["use_non_latin"]))				{$use_non_latin=$_GET["use_non_latin"];}
	elseif (isset($_POST["use_non_latin"]))		{$use_non_latin=$_POST["use_non_latin"];}
if (isset($_GET["webroot_writable"]))			{$webroot_writable=$_GET["webroot_writable"];}
	elseif (isset($_POST["webroot_writable"]))	{$webroot_writable=$_POST["webroot_writable"];}
if (isset($_GET["enable_queuemetrics_logging"]))	{$enable_queuemetrics_logging=$_GET["enable_queuemetrics_logging"];}
	elseif (isset($_POST["enable_queuemetrics_logging"]))	{$enable_queuemetrics_logging=$_POST["enable_queuemetrics_logging"];}
if (isset($_GET["queuemetrics_server_ip"]))				{$queuemetrics_server_ip=$_GET["queuemetrics_server_ip"];}
	elseif (isset($_POST["queuemetrics_server_ip"]))	{$queuemetrics_server_ip=$_POST["queuemetrics_server_ip"];}
if (isset($_GET["queuemetrics_dbname"]))			{$queuemetrics_dbname=$_GET["queuemetrics_dbname"];}
	elseif (isset($_POST["queuemetrics_dbname"]))	{$queuemetrics_dbname=$_POST["queuemetrics_dbname"];}
if (isset($_GET["queuemetrics_login"]))				{$queuemetrics_login=$_GET["queuemetrics_login"];}
	elseif (isset($_POST["queuemetrics_login"]))	{$queuemetrics_login=$_POST["queuemetrics_login"];}
if (isset($_GET["queuemetrics_pass"]))			{$queuemetrics_pass=$_GET["queuemetrics_pass"];}
	elseif (isset($_POST["queuemetrics_pass"]))	{$queuemetrics_pass=$_POST["queuemetrics_pass"];}
if (isset($_GET["queuemetrics_url"]))			{$queuemetrics_url=$_GET["queuemetrics_url"];}
	elseif (isset($_POST["queuemetrics_url"]))	{$queuemetrics_url=$_POST["queuemetrics_url"];}
if (isset($_GET["queuemetrics_log_id"]))			{$queuemetrics_log_id=$_GET["queuemetrics_log_id"];}
	elseif (isset($_POST["queuemetrics_log_id"]))	{$queuemetrics_log_id=$_POST["queuemetrics_log_id"];}
if (isset($_GET["dial_status"]))				{$dial_status=$_GET["dial_status"];}
	elseif (isset($_POST["dial_status"]))		{$dial_status=$_POST["dial_status"];}
if (isset($_GET["queuemetrics_eq_prepend"]))			{$queuemetrics_eq_prepend=$_GET["queuemetrics_eq_prepend"];}
	elseif (isset($_POST["queuemetrics_eq_prepend"]))	{$queuemetrics_eq_prepend=$_POST["queuemetrics_eq_prepend"];}
if (isset($_GET["vicidial_agent_disable"]))				{$vicidial_agent_disable=$_GET["vicidial_agent_disable"];}
	elseif (isset($_POST["vicidial_agent_disable"]))	{$vicidial_agent_disable=$_POST["vicidial_agent_disable"];}
if (isset($_GET["disable_alter_custdata"]))				{$disable_alter_custdata=$_GET["disable_alter_custdata"];}
	elseif (isset($_POST["disable_alter_custdata"]))	{$disable_alter_custdata=$_POST["disable_alter_custdata"];}
if (isset($_GET["alter_custdata_override"]))			{$alter_custdata_override=$_GET["alter_custdata_override"];}
	elseif (isset($_POST["alter_custdata_override"]))	{$alter_custdata_override=$_POST["alter_custdata_override"];}
if (isset($_GET["no_hopper_leads_logins"]))				{$no_hopper_leads_logins=$_GET["no_hopper_leads_logins"];}
	elseif (isset($_POST["no_hopper_leads_logins"]))	{$no_hopper_leads_logins=$_POST["no_hopper_leads_logins"];}
if (isset($_GET["enable_sipsak_messages"]))				{$enable_sipsak_messages=$_GET["enable_sipsak_messages"];}
	elseif (isset($_POST["enable_sipsak_messages"]))	{$enable_sipsak_messages=$_POST["enable_sipsak_messages"];}
if (isset($_GET["allow_sipsak_messages"]))				{$allow_sipsak_messages=$_GET["allow_sipsak_messages"];}
	elseif (isset($_POST["allow_sipsak_messages"]))		{$allow_sipsak_messages=$_POST["allow_sipsak_messages"];}
if (isset($_GET["admin_home_url"]))				{$admin_home_url=$_GET["admin_home_url"];}
	elseif (isset($_POST["admin_home_url"]))	{$admin_home_url=$_POST["admin_home_url"];}
if (isset($_GET["list_order_mix"]))				{$list_order_mix=$_GET["list_order_mix"];}
	elseif (isset($_POST["list_order_mix"]))	{$list_order_mix=$_POST["list_order_mix"];}
if (isset($_GET["vcl_id"]))						{$vcl_id=$_GET["vcl_id"];}
	elseif (isset($_POST["vcl_id"]))			{$vcl_id=$_POST["vcl_id"];}
if (isset($_GET["vcl_name"]))					{$vcl_name=$_GET["vcl_name"];}
	elseif (isset($_POST["vcl_name"]))			{$vcl_name=$_POST["vcl_name"];}
if (isset($_GET["list_mix_container"]))				{$list_mix_container=$_GET["list_mix_container"];}
	elseif (isset($_POST["list_mix_container"]))	{$list_mix_container=$_POST["list_mix_container"];}
if (isset($_GET["mix_method"]))					{$mix_method=$_GET["mix_method"];}
	elseif (isset($_POST["mix_method"]))		{$mix_method=$_POST["mix_method"];}
if (isset($_GET["human_answered"]))				{$human_answered=$_GET["human_answered"];}
	elseif (isset($_POST["human_answered"]))	{$human_answered=$_POST["human_answered"];}
if (isset($_GET["category"]))					{$category=$_GET["category"];}
	elseif (isset($_POST["category"]))			{$category=$_POST["category"];}
if (isset($_GET["vsc_id"]))						{$vsc_id=$_GET["vsc_id"];}
	elseif (isset($_POST["vsc_id"]))			{$vsc_id=$_POST["vsc_id"];}
if (isset($_GET["vsc_name"]))					{$vsc_name=$_GET["vsc_name"];}
	elseif (isset($_POST["vsc_name"]))			{$vsc_name=$_POST["vsc_name"];}
if (isset($_GET["vsc_description"]))			{$vsc_description=$_GET["vsc_description"];}
	elseif (isset($_POST["vsc_description"]))	{$vsc_description=$_POST["vsc_description"];}
if (isset($_GET["tovdad_display"]))				{$tovdad_display=$_GET["tovdad_display"];}
	elseif (isset($_POST["tovdad_display"]))	{$tovdad_display=$_POST["tovdad_display"];}
if (isset($_GET["mix_container_item"]))				{$mix_container_item=$_GET["mix_container_item"];}
	elseif (isset($_POST["mix_container_item"]))	{$mix_container_item=$_POST["mix_container_item"];}
if (isset($_GET["enable_agc_xfer_log"]))			{$enable_agc_xfer_log=$_GET["enable_agc_xfer_log"];}
	elseif (isset($_POST["enable_agc_xfer_log"]))	{$enable_agc_xfer_log=$_POST["enable_agc_xfer_log"];}
if (isset($_GET["after_hours_action"]))				{$after_hours_action=$_GET["after_hours_action"];}
	elseif (isset($_POST["after_hours_action"]))	{$after_hours_action=$_POST["after_hours_action"];}
if (isset($_GET["after_hours_message_filename"]))			{$after_hours_message_filename=$_GET["after_hours_message_filename"];}
	elseif (isset($_POST["after_hours_message_filename"]))	{$after_hours_message_filename=$_POST["after_hours_message_filename"];}
if (isset($_GET["after_hours_exten"]))				{$after_hours_exten=$_GET["after_hours_exten"];}
	elseif (isset($_POST["after_hours_exten"]))		{$after_hours_exten=$_POST["after_hours_exten"];}
if (isset($_GET["after_hours_voicemail"]))			{$after_hours_voicemail=$_GET["after_hours_voicemail"];}
	elseif (isset($_POST["after_hours_voicemail"]))	{$after_hours_voicemail=$_POST["after_hours_voicemail"];}
if (isset($_GET["welcome_message_filename"]))			{$welcome_message_filename=$_GET["welcome_message_filename"];}
	elseif (isset($_POST["welcome_message_filename"]))	{$welcome_message_filename=$_POST["welcome_message_filename"];}
if (isset($_GET["moh_context"]))					{$moh_context=$_GET["moh_context"];}
	elseif (isset($_POST["moh_context"]))			{$moh_context=$_POST["moh_context"];}
if (isset($_GET["onhold_prompt_filename"]))				{$onhold_prompt_filename=$_GET["onhold_prompt_filename"];}
	elseif (isset($_POST["onhold_prompt_filename"]))	{$onhold_prompt_filename=$_POST["onhold_prompt_filename"];}
if (isset($_GET["prompt_interval"]))				{$prompt_interval=$_GET["prompt_interval"];}
	elseif (isset($_POST["prompt_interval"]))		{$prompt_interval=$_POST["prompt_interval"];}
if (isset($_GET["agent_alert_exten"]))				{$agent_alert_exten=$_GET["agent_alert_exten"];}
	elseif (isset($_POST["agent_alert_exten"]))		{$agent_alert_exten=$_POST["agent_alert_exten"];}
if (isset($_GET["agent_alert_delay"]))				{$agent_alert_delay=$_GET["agent_alert_delay"];}
	elseif (isset($_POST["agent_alert_delay"]))		{$agent_alert_delay=$_POST["agent_alert_delay"];}
if (isset($_GET["group_rank"]))					{$group_rank=$_GET["group_rank"];}
	elseif (isset($_POST["group_rank"]))		{$group_rank=$_POST["group_rank"];}
if (isset($_GET["campaign_allow_inbound"]))				{$campaign_allow_inbound=$_GET["campaign_allow_inbound"];}
	elseif (isset($_POST["campaign_allow_inbound"]))	{$campaign_allow_inbound=$_POST["campaign_allow_inbound"];}
if (isset($_GET["manual_dial_list_id"]))				{$manual_dial_list_id=$_GET["manual_dial_list_id"];}
	elseif (isset($_POST["manual_dial_list_id"]))		{$manual_dial_list_id=$_POST["manual_dial_list_id"];}
if (isset($_GET["campaign_rank"]))				{$campaign_rank=$_GET["campaign_rank"];}
	elseif (isset($_POST["campaign_rank"]))		{$campaign_rank=$_POST["campaign_rank"];}
if (isset($_GET["source_campaign_id"]))				{$source_campaign_id=$_GET["source_campaign_id"];}
	elseif (isset($_POST["source_campaign_id"]))	{$source_campaign_id=$_POST["source_campaign_id"];}
if (isset($_GET["source_user_id"]))				{$source_user_id=$_GET["source_user_id"];}
	elseif (isset($_POST["source_user_id"]))	{$source_user_id=$_POST["source_user_id"];}
if (isset($_GET["source_group_id"]))			{$source_group_id=$_GET["source_group_id"];}
	elseif (isset($_POST["source_group_id"]))	{$source_group_id=$_POST["source_group_id"];}
if (isset($_GET["default_xfer_group"]))				{$default_xfer_group=$_GET["default_xfer_group"];}
	elseif (isset($_POST["default_xfer_group"]))	{$default_xfer_group=$_POST["default_xfer_group"];}
if (isset($_GET["qc_enabled"]))					{$qc_enabled=$_GET["qc_enabled"];}
	elseif (isset($_POST["qc_enabled"]))		{$qc_enabled=$_POST["qc_enabled"];}
if (isset($_GET["qc_user_level"]))				{$qc_user_level=$_GET["qc_user_level"];}
	elseif (isset($_POST["qc_user_level"]))		{$qc_user_level=$_POST["qc_user_level"];}
if (isset($_GET["qc_pass"]))					{$qc_pass=$_GET["qc_pass"];}
	elseif (isset($_POST["qc_pass"]))			{$qc_pass=$_POST["qc_pass"];}
if (isset($_GET["qc_finish"]))					{$qc_finish=$_GET["qc_finish"];}
	elseif (isset($_POST["qc_finish"]))			{$qc_finish=$_POST["qc_finish"];}
if (isset($_GET["qc_commit"]))					{$qc_commit=$_GET["qc_commit"];}
	elseif (isset($_POST["qc_commit"]))			{$qc_commit=$_POST["qc_commit"];}
if (isset($_GET["qc_campaigns"]))				{$qc_campaigns=$_GET["qc_campaigns"];}
	elseif (isset($_POST["qc_campaigns"]))		{$qc_campaigns=$_POST["qc_campaigns"];}
if (isset($_GET["qc_groups"]))					{$qc_groups=$_GET["qc_groups"];}
	elseif (isset($_POST["qc_groups"]))			{$qc_groups=$_POST["qc_groups"];}
if (isset($_GET["queue_priority"]))				{$queue_priority=$_GET["queue_priority"];}
	elseif (isset($_POST["queue_priority"]))	{$queue_priority=$_POST["queue_priority"];}
if (isset($_GET["drop_inbound_group"]))				{$drop_inbound_group=$_GET["drop_inbound_group"];}
	elseif (isset($_POST["drop_inbound_group"]))	{$drop_inbound_group=$_POST["drop_inbound_group"];}
if (isset($_GET["qc_statuses"]))			{$qc_statuses=$_GET["qc_statuses"];}
	elseif (isset($_POST["qc_statuses"]))	{$qc_statuses=$_POST["qc_statuses"];}
if (isset($_GET["qc_lists"]))				{$qc_lists=$_GET["qc_lists"];}
	elseif (isset($_POST["qc_lists"]))		{$qc_lists=$_POST["qc_lists"];}
if (isset($_GET["qc_get_record_launch"]))			{$qc_get_record_launch=$_GET["qc_get_record_launch"];}
	elseif (isset($_POST["qc_get_record_launch"]))	{$qc_get_record_launch=$_POST["qc_get_record_launch"];}
if (isset($_GET["qc_show_recording"]))				{$qc_show_recording=$_GET["qc_show_recording"];}
	elseif (isset($_POST["qc_show_recording"]))		{$qc_show_recording=$_POST["qc_show_recording"];}
if (isset($_GET["qc_shift_id"]))				{$qc_shift_id=$_GET["qc_shift_id"];}
	elseif (isset($_POST["qc_shift_id"]))		{$qc_shift_id=$_POST["qc_shift_id"];}
if (isset($_GET["qc_web_form_address"]))				{$qc_web_form_address=$_GET["qc_web_form_address"];}
	elseif (isset($_POST["qc_web_form_address"]))	{$qc_web_form_address=$_POST["qc_web_form_address"];}
if (isset($_GET["qc_script"]))						{$qc_script=$_GET["qc_script"];}
	elseif (isset($_POST["qc_script"]))				{$qc_script=$_POST["qc_script"];}
if (isset($_GET["ingroup_recording_override"]))		{$ingroup_recording_override=$_GET["ingroup_recording_override"];}	
	elseif (isset($_POST["ingroup_recording_override"]))	{$ingroup_recording_override=$_POST["ingroup_recording_override"];}
if (isset($_GET["code"]))				{$code=$_GET["code"];}	
	elseif (isset($_POST["code"]))		{$code=$_POST["code"];}
if (isset($_GET["code_name"]))			{$code_name=$_GET["code_name"];}	
	elseif (isset($_POST["code_name"]))	{$code_name=$_POST["code_name"];}
if (isset($_GET["afterhours_xfer_group"]))			{$afterhours_xfer_group=$_GET["afterhours_xfer_group"];}	
	elseif (isset($_POST["afterhours_xfer_group"]))	{$afterhours_xfer_group=$_POST["afterhours_xfer_group"];}
if (isset($_GET["alias_id"]))				{$alias_id=$_GET["alias_id"];}	
	elseif (isset($_POST["alias_id"]))		{$alias_id=$_POST["alias_id"];}
if (isset($_GET["alias_name"]))				{$alias_name=$_GET["alias_name"];}	
	elseif (isset($_POST["alias_name"]))		{$alias_name=$_POST["alias_name"];}
if (isset($_GET["logins_list"]))				{$logins_list=$_GET["logins_list"];}	
	elseif (isset($_POST["logins_list"]))		{$logins_list=$_POST["logins_list"];}
if (isset($_GET["shift_id"]))				{$shift_id=$_GET["shift_id"];}	
	elseif (isset($_POST["shift_id"]))		{$shift_id=$_POST["shift_id"];}
if (isset($_GET["shift_name"]))				{$shift_name=$_GET["shift_name"];}	
	elseif (isset($_POST["shift_name"]))		{$shift_name=$_POST["shift_name"];}
if (isset($_GET["shift_start_time"]))			{$shift_start_time=$_GET["shift_start_time"];}	
	elseif (isset($_POST["shift_start_time"]))	{$shift_start_time=$_POST["shift_start_time"];}
if (isset($_GET["shift_length"]))				{$shift_length=$_GET["shift_length"];}	
	elseif (isset($_POST["shift_length"]))		{$shift_length=$_POST["shift_length"];}
if (isset($_GET["shift_weekdays"]))				{$shift_weekdays=$_GET["shift_weekdays"];}	
	elseif (isset($_POST["shift_weekdays"]))	{$shift_weekdays=$_POST["shift_weekdays"];}
if (isset($_GET["group_shifts"]))			{$group_shifts=$_GET["group_shifts"];}	
	elseif (isset($_POST["group_shifts"]))	{$group_shifts=$_POST["group_shifts"];}
if (isset($_GET["timeclock_end_of_day"]))			{$timeclock_end_of_day=$_GET["timeclock_end_of_day"];}	
	elseif (isset($_POST["timeclock_end_of_day"]))	{$timeclock_end_of_day=$_POST["timeclock_end_of_day"];}
if (isset($_GET["survey_first_audio_file"]))			{$survey_first_audio_file=$_GET["survey_first_audio_file"];}	
	elseif (isset($_POST["survey_first_audio_file"]))	{$survey_first_audio_file=$_POST["survey_first_audio_file"];}
if (isset($_GET["survey_dtmf_digits"]))					{$survey_dtmf_digits=$_GET["survey_dtmf_digits"];}	
	elseif (isset($_POST["survey_dtmf_digits"]))		{$survey_dtmf_digits=$_POST["survey_dtmf_digits"];}
if (isset($_GET["survey_ni_digit"]))					{$survey_ni_digit=$_GET["survey_ni_digit"];}	
	elseif (isset($_POST["survey_ni_digit"]))			{$survey_ni_digit=$_POST["survey_ni_digit"];}
if (isset($_GET["survey_opt_in_audio_file"]))			{$survey_opt_in_audio_file=$_GET["survey_opt_in_audio_file"];}	
	elseif (isset($_POST["survey_opt_in_audio_file"]))	{$survey_opt_in_audio_file=$_POST["survey_opt_in_audio_file"];}
if (isset($_GET["survey_ni_audio_file"]))				{$survey_ni_audio_file=$_GET["survey_ni_audio_file"];}	
	elseif (isset($_POST["survey_ni_audio_file"]))		{$survey_ni_audio_file=$_POST["survey_ni_audio_file"];}
if (isset($_GET["survey_method"]))						{$survey_method=$_GET["survey_method"];}	
	elseif (isset($_POST["survey_method"]))				{$survey_method=$_POST["survey_method"];}
if (isset($_GET["survey_no_response_action"]))			{$survey_no_response_action=$_GET["survey_no_response_action"];}	
	elseif (isset($_POST["survey_no_response_action"]))	{$survey_no_response_action=$_POST["survey_no_response_action"];}
if (isset($_GET["survey_ni_status"]))					{$survey_ni_status=$_GET["survey_ni_status"];}	
	elseif (isset($_POST["survey_ni_status"]))			{$survey_ni_status=$_POST["survey_ni_status"];}
if (isset($_GET["survey_response_digit_map"]))			{$survey_response_digit_map=$_GET["survey_response_digit_map"];}	
	elseif (isset($_POST["survey_response_digit_map"]))	{$survey_response_digit_map=$_POST["survey_response_digit_map"];}
if (isset($_GET["survey_xfer_exten"]))					{$survey_xfer_exten=$_GET["survey_xfer_exten"];}	
	elseif (isset($_POST["survey_xfer_exten"]))			{$survey_xfer_exten=$_POST["survey_xfer_exten"];}
if (isset($_GET["survey_camp_record_dir"]))				{$survey_camp_record_dir=$_GET["survey_camp_record_dir"];}	
	elseif (isset($_POST["survey_camp_record_dir"]))	{$survey_camp_record_dir=$_POST["survey_camp_record_dir"];}
if (isset($_GET["add_timeclock_log"]))				{$add_timeclock_log=$_GET["add_timeclock_log"];}	
	elseif (isset($_POST["add_timeclock_log"]))		{$add_timeclock_log=$_POST["add_timeclock_log"];}
if (isset($_GET["modify_timeclock_log"]))			{$modify_timeclock_log=$_GET["modify_timeclock_log"];}	
	elseif (isset($_POST["modify_timeclock_log"]))	{$modify_timeclock_log=$_POST["modify_timeclock_log"];}
if (isset($_GET["delete_timeclock_log"]))			{$delete_timeclock_log=$_GET["delete_timeclock_log"];}	
	elseif (isset($_POST["delete_timeclock_log"]))	{$delete_timeclock_log=$_POST["delete_timeclock_log"];}
if (isset($_GET["phone_numbers"]))					{$phone_numbers=$_GET["phone_numbers"];}	
	elseif (isset($_POST["phone_numbers"]))			{$phone_numbers=$_POST["phone_numbers"];}
if (isset($_GET["vdc_header_date_format"]))					{$vdc_header_date_format=$_GET["vdc_header_date_format"];}	
	elseif (isset($_POST["vdc_header_date_format"]))		{$vdc_header_date_format=$_POST["vdc_header_date_format"];}
if (isset($_GET["vdc_customer_date_format"]))				{$vdc_customer_date_format=$_GET["vdc_customer_date_format"];}	
	elseif (isset($_POST["vdc_customer_date_format"]))		{$vdc_customer_date_format=$_POST["vdc_customer_date_format"];}
if (isset($_GET["vdc_header_phone_format"]))				{$vdc_header_phone_format=$_GET["vdc_header_phone_format"];}	
	elseif (isset($_POST["vdc_header_phone_format"]))		{$vdc_header_phone_format=$_POST["vdc_header_phone_format"];}
if (isset($_GET["disable_alter_custphone"]))			{$disable_alter_custphone=$_GET["disable_alter_custphone"];}	
	elseif (isset($_POST["disable_alter_custphone"]))	{$disable_alter_custphone=$_POST["disable_alter_custphone"];}
if (isset($_GET["alter_custphone_override"]))			{$alter_custphone_override=$_GET["alter_custphone_override"];}	
	elseif (isset($_POST["alter_custphone_override"]))	{$alter_custphone_override=$_POST["alter_custphone_override"];}
if (isset($_GET["vdc_agent_api_access"]))				{$vdc_agent_api_access=$_GET["vdc_agent_api_access"];}	
	elseif (isset($_POST["vdc_agent_api_access"]))		{$vdc_agent_api_access=$_POST["vdc_agent_api_access"];}
if (isset($_GET["vdc_agent_api_active"]))				{$vdc_agent_api_active=$_GET["vdc_agent_api_active"];}	
	elseif (isset($_POST["vdc_agent_api_active"]))		{$vdc_agent_api_active=$_POST["vdc_agent_api_active"];}
if (isset($_GET["display_queue_count"]))				{$display_queue_count=$_GET["display_queue_count"];}	
	elseif (isset($_POST["display_queue_count"]))		{$display_queue_count=$_POST["display_queue_count"];}
if (isset($_GET["sale_category"]))				{$sale_category=$_GET["sale_category"];}	
	elseif (isset($_POST["sale_category"]))		{$sale_category=$_POST["sale_category"];}
if (isset($_GET["dead_lead_category"]))				{$dead_lead_category=$_GET["dead_lead_category"];}	
	elseif (isset($_POST["dead_lead_category"]))	{$dead_lead_category=$_POST["dead_lead_category"];}
if (isset($_GET["manual_dial_filter"]))				{$manual_dial_filter=$_GET["manual_dial_filter"];}	
	elseif (isset($_POST["manual_dial_filter"]))	{$manual_dial_filter=$_POST["manual_dial_filter"];}
if (isset($_GET["agent_clipboard_copy"]))			{$agent_clipboard_copy=$_GET["agent_clipboard_copy"];}	
	elseif (isset($_POST["agent_clipboard_copy"]))	{$agent_clipboard_copy=$_POST["agent_clipboard_copy"];}
if (isset($_GET["agent_extended_alt_dial"]))			{$agent_extended_alt_dial=$_GET["agent_extended_alt_dial"];}	
	elseif (isset($_POST["agent_extended_alt_dial"]))	{$agent_extended_alt_dial=$_POST["agent_extended_alt_dial"];}
if (isset($_GET["play_place_in_line"]))				{$play_place_in_line=$_GET["play_place_in_line"];}	
	elseif (isset($_POST["play_place_in_line"]))	{$play_place_in_line=$_POST["play_place_in_line"];}
if (isset($_GET["play_estimate_hold_time"]))			{$play_estimate_hold_time=$_GET["play_estimate_hold_time"];}	
	elseif (isset($_POST["play_estimate_hold_time"]))	{$play_estimate_hold_time=$_POST["play_estimate_hold_time"];}
if (isset($_GET["hold_time_option"]))				{$hold_time_option=$_GET["hold_time_option"];}	
	elseif (isset($_POST["hold_time_option"]))		{$hold_time_option=$_POST["hold_time_option"];}
if (isset($_GET["hold_time_option_seconds"]))			{$hold_time_option_seconds=$_GET["hold_time_option_seconds"];}	
	elseif (isset($_POST["hold_time_option_seconds"]))	{$hold_time_option_seconds=$_POST["hold_time_option_seconds"];}
if (isset($_GET["hold_time_option_exten"]))				{$hold_time_option_exten=$_GET["hold_time_option_exten"];}	
	elseif (isset($_POST["hold_time_option_exten"]))	{$hold_time_option_exten=$_POST["hold_time_option_exten"];}
if (isset($_GET["hold_time_option_voicemail"]))				{$hold_time_option_voicemail=$_GET["hold_time_option_voicemail"];}	
	elseif (isset($_POST["hold_time_option_voicemail"]))	{$hold_time_option_voicemail=$_POST["hold_time_option_voicemail"];}
if (isset($_GET["hold_time_option_xfer_group"]))			{$hold_time_option_xfer_group=$_GET["hold_time_option_xfer_group"];}	
	elseif (isset($_POST["hold_time_option_xfer_group"]))	{$hold_time_option_xfer_group=$_POST["hold_time_option_xfer_group"];}
if (isset($_GET["hold_time_option_callback_filename"]))				{$hold_time_option_callback_filename=$_GET["hold_time_option_callback_filename"];}	
	elseif (isset($_POST["hold_time_option_callback_filename"]))	{$hold_time_option_callback_filename=$_POST["hold_time_option_callback_filename"];}
if (isset($_GET["hold_time_option_callback_list_id"]))				{$hold_time_option_callback_list_id=$_GET["hold_time_option_callback_list_id"];}	
	elseif (isset($_POST["hold_time_option_callback_list_id"]))		{$hold_time_option_callback_list_id=$_POST["hold_time_option_callback_list_id"];}
if (isset($_GET["hold_recall_xfer_group"]))				{$hold_recall_xfer_group=$_GET["hold_recall_xfer_group"];}	
	elseif (isset($_POST["hold_recall_xfer_group"]))	{$hold_recall_xfer_group=$_POST["hold_recall_xfer_group"];}
if (isset($_GET["no_delay_call_route"]))			{$no_delay_call_route=$_GET["no_delay_call_route"];}	
	elseif (isset($_POST["no_delay_call_route"]))	{$no_delay_call_route=$_POST["no_delay_call_route"];}
if (isset($_GET["play_welcome_message"]))			{$play_welcome_message=$_GET["play_welcome_message"];}	
	elseif (isset($_POST["play_welcome_message"]))	{$play_welcome_message=$_POST["play_welcome_message"];}
if (isset($_GET["did_id"]))					{$did_id=$_GET["did_id"];}	
	elseif (isset($_POST["did_id"]))		{$did_id=$_POST["did_id"];}
if (isset($_GET["source_did"]))				{$source_did=$_GET["source_did"];}	
	elseif (isset($_POST["source_did"]))	{$source_did=$_POST["source_did"];}
if (isset($_GET["did_pattern"]))			{$did_pattern=$_GET["did_pattern"];}	
	elseif (isset($_POST["did_pattern"]))	{$did_pattern=$_POST["did_pattern"];}
if (isset($_GET["did_description"]))			{$did_description=$_GET["did_description"];}	
	elseif (isset($_POST["did_description"]))	{$did_description=$_POST["did_description"];}
if (isset($_GET["did_active"]))				{$did_active=$_GET["did_active"];}	
	elseif (isset($_POST["did_active"]))	{$did_active=$_POST["did_active"];}
if (isset($_GET["did_route"]))				{$did_route=$_GET["did_route"];}	
	elseif (isset($_POST["did_route"]))		{$did_route=$_POST["did_route"];}
if (isset($_GET["exten_context"]))			{$exten_context=$_GET["exten_context"];}	
	elseif (isset($_POST["exten_context"]))	{$exten_context=$_POST["exten_context"];}
if (isset($_GET["phone"]))					{$phone=$_GET["phone"];}	
	elseif (isset($_POST["phone"]))			{$phone=$_POST["phone"];}
if (isset($_GET["user_unavailable_action"]))			{$user_unavailable_action=$_GET["user_unavailable_action"];}	
	elseif (isset($_POST["user_unavailable_action"]))	{$user_unavailable_action=$_POST["user_unavailable_action"];}
if (isset($_GET["user_route_settings_ingroup"]))			{$user_route_settings_ingroup=$_GET["user_route_settings_ingroup"];}	
	elseif (isset($_POST["user_route_settings_ingroup"]))	{$user_route_settings_ingroup=$_POST["user_route_settings_ingroup"];}
if (isset($_GET["call_handle_method"]))				{$call_handle_method=$_GET["call_handle_method"];}	
	elseif (isset($_POST["call_handle_method"]))	{$call_handle_method=$_POST["call_handle_method"];}
if (isset($_GET["agent_search_method"]))			{$agent_search_method=$_GET["agent_search_method"];}	
	elseif (isset($_POST["agent_search_method"]))	{$agent_search_method=$_POST["agent_search_method"];}
if (isset($_GET["phone_code"]))				{$phone_code=$_GET["phone_code"];}	
	elseif (isset($_POST["phone_code"]))	{$phone_code=$_POST["phone_code"];}
if (isset($_GET["email"]))					{$email=$_GET["email"];}	
	elseif (isset($_POST["email"]))			{$email=$_POST["email"];}
if (isset($_GET["modify_inbound_dids"]))			{$modify_inbound_dids=$_GET["modify_inbound_dids"];}	
	elseif (isset($_POST["modify_inbound_dids"]))	{$modify_inbound_dids=$_POST["modify_inbound_dids"];}
if (isset($_GET["delete_inbound_dids"]))			{$delete_inbound_dids=$_GET["delete_inbound_dids"];}	
	elseif (isset($_POST["delete_inbound_dids"]))	{$delete_inbound_dids=$_POST["delete_inbound_dids"];}
if (isset($_GET["three_way_call_cid"]))				{$three_way_call_cid=$_GET["three_way_call_cid"];}	
	elseif (isset($_POST["three_way_call_cid"]))	{$three_way_call_cid=$_POST["three_way_call_cid"];}


	if (isset($script_id)) {$script_id= strtoupper($script_id);}
	if (isset($lead_filter_id)) {$lead_filter_id = strtoupper($lead_filter_id);}

if (strlen($dial_status) > 0) 
	{
	$ADD='28';
	$status = $dial_status;
	}

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin FROM system_settings;";
$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysql_num_rows($rslt);
$i=0;
while ($i < $qm_conf_ct)
	{
	$row=mysql_fetch_row($rslt);
	$non_latin =					$row[0];
	$i++;
	}
##### END SETTINGS LOOKUP #####
###########################################

######################################################################################################
######################################################################################################
#######   Form variable filtering for security and data integrity
######################################################################################################
######################################################################################################

if ($non_latin < 1)
{
### DIGITS ONLY ###
$adaptive_dropped_percentage = ereg_replace("[^0-9]","",$adaptive_dropped_percentage);
$adaptive_latest_server_time = ereg_replace("[^0-9]","",$adaptive_latest_server_time);
$admin_hangup_enabled = ereg_replace("[^0-9]","",$admin_hangup_enabled);
$admin_hijack_enabled = ereg_replace("[^0-9]","",$admin_hijack_enabled);
$admin_monitor_enabled = ereg_replace("[^0-9]","",$admin_monitor_enabled);
$AFLogging_enabled = ereg_replace("[^0-9]","",$AFLogging_enabled);
$agent_choose_ingroups = ereg_replace("[^0-9]","",$agent_choose_ingroups);
$agentcall_manual = ereg_replace("[^0-9]","",$agentcall_manual);
$agentonly_callbacks = ereg_replace("[^0-9]","",$agentonly_callbacks);
$AGI_call_logging_enabled = ereg_replace("[^0-9]","",$AGI_call_logging_enabled);
$allcalls_delay = ereg_replace("[^0-9]","",$allcalls_delay);
$alter_agent_interface_options = ereg_replace("[^0-9]","",$alter_agent_interface_options);
$am_message_exten = ereg_replace("[^0-9]","",$am_message_exten);
$answer_transfer_agent = ereg_replace("[^0-9]","",$answer_transfer_agent);
$ast_admin_access = ereg_replace("[^0-9]","",$ast_admin_access);
$ast_delete_phones = ereg_replace("[^0-9]","",$ast_delete_phones);
$attempt_delay = ereg_replace("[^0-9]","",$attempt_delay);
$attempt_maximum = ereg_replace("[^0-9]","",$attempt_maximum);
$auto_dial_next_number = ereg_replace("[^0-9]","",$auto_dial_next_number);
$balance_trunks_offlimits = ereg_replace("[^0-9]","",$balance_trunks_offlimits);
$call_parking_enabled = ereg_replace("[^0-9]","",$call_parking_enabled);
$CallerID_popup_enabled = ereg_replace("[^0-9]","",$CallerID_popup_enabled);
$campaign_detail = ereg_replace("[^0-9]","",$campaign_detail);
$campaign_rec_exten = ereg_replace("[^0-9]","",$campaign_rec_exten);
$campaign_vdad_exten = ereg_replace("[^0-9]","",$campaign_vdad_exten);
$change_agent_campaign = ereg_replace("[^0-9]","",$change_agent_campaign);
$closer_default_blended = ereg_replace("[^0-9]","",$closer_default_blended);
$conf_exten = ereg_replace("[^0-9]","",$conf_exten);
$conf_on_extension = ereg_replace("[^0-9]","",$conf_on_extension);
$conferencing_enabled = ereg_replace("[^0-9]","",$conferencing_enabled);
$ct_default_start = ereg_replace("[^0-9]","",$ct_default_start);
$ct_default_stop = ereg_replace("[^0-9]","",$ct_default_stop);
$ct_friday_start = ereg_replace("[^0-9]","",$ct_friday_start);
$ct_friday_stop = ereg_replace("[^0-9]","",$ct_friday_stop);
$ct_monday_start = ereg_replace("[^0-9]","",$ct_monday_start);
$ct_monday_stop = ereg_replace("[^0-9]","",$ct_monday_stop);
$ct_saturday_start = ereg_replace("[^0-9]","",$ct_saturday_start);
$ct_saturday_stop = ereg_replace("[^0-9]","",$ct_saturday_stop);
$ct_sunday_start = ereg_replace("[^0-9]","",$ct_sunday_start);
$ct_sunday_stop = ereg_replace("[^0-9]","",$ct_sunday_stop);
$ct_thursday_start = ereg_replace("[^0-9]","",$ct_thursday_start);
$ct_thursday_stop = ereg_replace("[^0-9]","",$ct_thursday_stop);
$ct_tuesday_start = ereg_replace("[^0-9]","",$ct_tuesday_start);
$ct_tuesday_stop = ereg_replace("[^0-9]","",$ct_tuesday_stop);
$ct_wednesday_start = ereg_replace("[^0-9]","",$ct_wednesday_start);
$ct_wednesday_stop = ereg_replace("[^0-9]","",$ct_wednesday_stop);
$DBX_port = ereg_replace("[^0-9]","",$DBX_port);
$DBY_port = ereg_replace("[^0-9]","",$DBY_port);
$dedicated_trunks = ereg_replace("[^0-9]","",$dedicated_trunks);
$delete_call_times = ereg_replace("[^0-9]","",$delete_call_times);
$delete_campaigns = ereg_replace("[^0-9]","",$delete_campaigns);
$delete_filters = ereg_replace("[^0-9]","",$delete_filters);
$delete_ingroups = ereg_replace("[^0-9]","",$delete_ingroups);
$delete_lists = ereg_replace("[^0-9]","",$delete_lists);
$delete_remote_agents = ereg_replace("[^0-9]","",$delete_remote_agents);
$delete_scripts = ereg_replace("[^0-9]","",$delete_scripts);
$delete_user_groups = ereg_replace("[^0-9]","",$delete_user_groups);
$delete_users = ereg_replace("[^0-9]","",$delete_users);
$dial_timeout = ereg_replace("[^0-9]","",$dial_timeout);
$dialplan_number = ereg_replace("[^0-9]","",$dialplan_number);
$drop_call_seconds = ereg_replace("[^0-9]","",$drop_call_seconds);
$enable_fast_refresh = ereg_replace("[^0-9]","",$enable_fast_refresh);
$enable_persistant_mysql = ereg_replace("[^0-9]","",$enable_persistant_mysql);
$fast_refresh_rate = ereg_replace("[^0-9]","",$fast_refresh_rate);
$hopper_level = ereg_replace("[^0-9]","",$hopper_level);
$hotkey = ereg_replace("[^0-9]","",$hotkey);
$hotkeys_active = ereg_replace("[^0-9]","",$hotkeys_active);
$list_id = ereg_replace("[^0-9]","",$list_id);
$load_leads = ereg_replace("[^0-9]","",$load_leads);
$max_vicidial_trunks = ereg_replace("[^0-9]","",$max_vicidial_trunks);
$modify_call_times = ereg_replace("[^0-9]","",$modify_call_times);
$modify_users = ereg_replace("[^0-9]","",$modify_users);
$modify_campaigns = ereg_replace("[^0-9]","",$modify_campaigns);
$modify_lists = ereg_replace("[^0-9]","",$modify_lists);
$modify_scripts = ereg_replace("[^0-9]","",$modify_scripts);
$modify_filters = ereg_replace("[^0-9]","",$modify_filters);
$modify_ingroups = ereg_replace("[^0-9]","",$modify_ingroups);
$modify_usergroups = ereg_replace("[^0-9]","",$modify_usergroups);
$modify_remoteagents = ereg_replace("[^0-9]","",$modify_remoteagents);
$modify_servers = ereg_replace("[^0-9]","",$modify_servers);
$view_reports = ereg_replace("[^0-9]","",$view_reports);
$modify_leads = ereg_replace("[^0-9]","",$modify_leads);
$monitor_prefix = ereg_replace("[^0-9]","",$monitor_prefix);
$number_of_lines = ereg_replace("[^0-9]","",$number_of_lines);
$old_conf_exten = ereg_replace("[^0-9]","",$old_conf_exten);
$outbound_cid = ereg_replace("[^0-9]","",$outbound_cid);
$park_ext = ereg_replace("[^0-9]","",$park_ext);
$park_on_extension = ereg_replace("[^0-9]","",$park_on_extension);
$phone_number = ereg_replace("[^0-9]","",$phone_number);
$QUEUE_ACTION_enabled = ereg_replace("[^0-9]","",$QUEUE_ACTION_enabled);
$recording_exten = ereg_replace("[^0-9]","",$recording_exten);
$remote_agent_id = ereg_replace("[^0-9]","",$remote_agent_id);
$telnet_port = ereg_replace("[^0-9]","",$telnet_port);
$updater_check_enabled = ereg_replace("[^0-9]","",$updater_check_enabled);
$user_level = ereg_replace("[^0-9]","",$user_level);
$user_start = ereg_replace("[^0-9]","",$user_start);
$user_switching_enabled = ereg_replace("[^0-9]","",$user_switching_enabled);
$VDstop_rec_after_each_call = ereg_replace("[^0-9]","",$VDstop_rec_after_each_call);
$VICIDIAL_park_on_extension = ereg_replace("[^0-9]","",$VICIDIAL_park_on_extension);
$vicidial_recording = ereg_replace("[^0-9]","",$vicidial_recording);
$vicidial_transfers = ereg_replace("[^0-9]","",$vicidial_transfers);
$voicemail_button_enabled = ereg_replace("[^0-9]","",$voicemail_button_enabled);
$voicemail_dump_exten = ereg_replace("[^0-9]","",$voicemail_dump_exten);
$voicemail_ext = ereg_replace("[^0-9]","",$voicemail_ext);
$voicemail_exten = ereg_replace("[^0-9]","",$voicemail_exten);
$voicemail_id = ereg_replace("[^0-9]","",$voicemail_id);
$wrapup_seconds = ereg_replace("[^0-9]","",$wrapup_seconds);
$use_non_latin = ereg_replace("[^0-9]","",$use_non_latin);
$webroot_writable = ereg_replace("[^0-9]","",$webroot_writable);
$enable_queuemetrics_logging = ereg_replace("[^0-9]","",$enable_queuemetrics_logging);
$enable_sipsak_messages = ereg_replace("[^0-9]","",$enable_sipsak_messages);
$allow_sipsak_messages = ereg_replace("[^0-9]","",$allow_sipsak_messages);
$mix_container_item = ereg_replace("[^0-9]","",$mix_container_item);
$prompt_interval = ereg_replace("[^0-9]","",$prompt_interval);
$agent_alert_delay = ereg_replace("[^0-9]","",$agent_alert_delay);
$manual_dial_list_id = ereg_replace("[^0-9]","",$manual_dial_list_id);
$qc_user_level = ereg_replace("[^0-9]","",$qc_user_level);
$qc_pass = ereg_replace("[^0-9]","",$qc_pass);
$qc_finish = ereg_replace("[^0-9]","",$qc_finish);
$qc_commit = ereg_replace("[^0-9]","",$qc_commit);
$shift_start_time = ereg_replace("[^0-9]","",$shift_start_time);
$timeclock_end_of_day = ereg_replace("[^0-9]","",$timeclock_end_of_day);
$survey_xfer_exten = ereg_replace("[^0-9]","",$survey_xfer_exten);
$add_timeclock_log = ereg_replace("[^0-9]","",$add_timeclock_log);
$modify_timeclock_log = ereg_replace("[^0-9]","",$modify_timeclock_log);
$delete_timeclock_log = ereg_replace("[^0-9]","",$delete_timeclock_log);
$vdc_agent_api_access = ereg_replace("[^0-9]","",$vdc_agent_api_access);
$vdc_agent_api_active = ereg_replace("[^0-9]","",$vdc_agent_api_active);
$hold_time_option_seconds = ereg_replace("[^0-9]","",$hold_time_option_seconds);
$hold_time_option_callback_list_id = ereg_replace("[^0-9]","",$hold_time_option_callback_list_id);
$did_id = ereg_replace("[^0-9]","",$did_id);
$source_did = ereg_replace("[^0-9]","",$source_did);
$modify_inbound_dids = ereg_replace("[^0-9]","",$modify_inbound_dids);
$delete_inbound_dids = ereg_replace("[^0-9]","",$delete_inbound_dids);

### DIGITS and COLONS
$shift_length = ereg_replace("[^\:0-9]","",$shift_length);

### DIGITS and HASHES and STARS
$survey_dtmf_digits = ereg_replace("[^\#\*0-9]","",$survey_dtmf_digits);
$survey_ni_digit = ereg_replace("[^\#\*0-9]","",$survey_ni_digit);

### DIGITS and DASHES
$group_rank = ereg_replace("[^-0-9]","",$group_rank);
$campaign_rank = ereg_replace("[^-0-9]","",$campaign_rank);
$queue_priority = ereg_replace("[^-0-9]","",$queue_priority);

### DIGITS and NEWLINES
$phone_numbers = ereg_replace("[^\n0-9]","",$phone_numbers);

### Y or N ONLY ###
$active = ereg_replace("[^NY]","",$active);
$allow_closers = ereg_replace("[^NY]","",$allow_closers);
$reset_hopper = ereg_replace("[^NY]","",$reset_hopper);
$amd_send_to_vmx = ereg_replace("[^NY]","",$amd_send_to_vmx);
$alt_number_dialing = ereg_replace("[^NY]","",$alt_number_dialing);
$selectable = ereg_replace("[^NY]","",$selectable);
$reset_list = ereg_replace("[^NY]","",$reset_list);
$fronter_display = ereg_replace("[^NY]","",$fronter_display);
$use_internal_dnc = ereg_replace("[^NY]","",$use_internal_dnc);
$use_campaign_dnc = ereg_replace("[^NY]","",$use_campaign_dnc);
$omit_phone_code = ereg_replace("[^NY]","",$omit_phone_code);
$available_only_ratio_tally = ereg_replace("[^NY]","",$available_only_ratio_tally);
$sys_perf_log = ereg_replace("[^NY]","",$sys_perf_log);
$vicidial_balance_active = ereg_replace("[^NY]","",$vicidial_balance_active);
$vd_server_logs = ereg_replace("[^NY]","",$vd_server_logs);
$agent_pause_codes_active = ereg_replace("[^NY]","",$agent_pause_codes_active);
$campaign_stats_refresh = ereg_replace("[^NY]","",$campaign_stats_refresh);
$disable_alter_custdata = ereg_replace("[^NY]","",$disable_alter_custdata);
$no_hopper_leads_logins = ereg_replace("[^NY]","",$no_hopper_leads_logins);
$human_answered = ereg_replace("[^NY]","",$human_answered);
$tovdad_display = ereg_replace("[^NY]","",$tovdad_display);
$campaign_allow_inbound = ereg_replace("[^NY]","",$campaign_allow_inbound);
$disable_alter_custphone = ereg_replace("[^NY]","",$disable_alter_custphone);
$display_queue_count = ereg_replace("[^NY]","",$display_queue_count);
$qc_show_recording = ereg_replace("[^NY]","",$qc_show_recording);
$sale_category = ereg_replace("[^NY]","",$sale_category);
$dead_lead_category = ereg_replace("[^NY]","",$dead_lead_category);
$agent_extended_alt_dial  = ereg_replace("[^NY]","",$agent_extended_alt_dial);
$play_place_in_line  = ereg_replace("[^NY]","",$play_place_in_line);
$play_estimate_hold_time  = ereg_replace("[^NY]","",$play_estimate_hold_time);
$no_delay_call_route  = ereg_replace("[^NY]","",$no_delay_call_route);
$did_active  = ereg_replace("[^NY]","",$did_active);

$qc_enabled = ereg_replace("[^0-9NY]","",$qc_enabled);


### ALPHA-NUMERIC ONLY ###
$PHP_AUTH_USER = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_USER);
$PHP_AUTH_PW = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_PW);
$script_id = ereg_replace("[^0-9a-zA-Z]","",$script_id);
$submit = ereg_replace("[^0-9a-zA-Z]","",$submit);
$campaign_cid = ereg_replace("[^0-9a-zA-Z]","",$campaign_cid);
$get_call_launch = ereg_replace("[^0-9a-zA-Z]","",$get_call_launch);
$campaign_recording = ereg_replace("[^0-9a-zA-Z]","",$campaign_recording);
$ADD = ereg_replace("[^0-9a-zA-Z]","",$ADD);
$dial_prefix = ereg_replace("[^0-9a-zA-Z]","",$dial_prefix);
$state_call_time_state = ereg_replace("[^0-9a-zA-Z]","",$state_call_time_state);
$scheduled_callbacks = ereg_replace("[^0-9a-zA-Z]","",$scheduled_callbacks);
$concurrent_transfers = ereg_replace("[^0-9a-zA-Z]","",$concurrent_transfers);
$billable = ereg_replace("[^0-9a-zA-Z]","",$billable);
$pause_code = ereg_replace("[^0-9a-zA-Z]","",$pause_code);
$vicidial_recording_override = ereg_replace("[^0-9a-zA-Z]","",$vicidial_recording_override);
$ingroup_recording_override = ereg_replace("[^0-9a-zA-Z]","",$ingroup_recording_override);
$queuemetrics_log_id = ereg_replace("[^0-9a-zA-Z]","",$queuemetrics_log_id);
$after_hours_exten = ereg_replace("[^0-9a-zA-Z]","",$after_hours_exten);
$after_hours_voicemail = ereg_replace("[^0-9a-zA-Z]","",$after_hours_voicemail);
$qc_script = ereg_replace("[^0-9a-zA-Z]","",$qc_script);
$code = ereg_replace("[^0-9a-zA-Z]","",$code);
$survey_no_response_action = ereg_replace("[^0-9a-zA-Z]","",$survey_no_response_action);
$survey_ni_status = ereg_replace("[^0-9a-zA-Z]","",$survey_ni_status);
$qc_get_record_launch = ereg_replace("[^0-9a-zA-Z]","",$qc_get_record_launch);

### DIGITS and Dots
$server_ip = ereg_replace("[^\.0-9]","",$server_ip);
$auto_dial_level = ereg_replace("[^\.0-9]","",$auto_dial_level);
$adaptive_maximum_level = ereg_replace("[^\.0-9]","",$adaptive_maximum_level);
$phone_ip = ereg_replace("[^\.0-9]","",$phone_ip);
$old_server_ip = ereg_replace("[^\.0-9]","",$old_server_ip);
$computer_ip = ereg_replace("[^\.0-9]","",$computer_ip);
$queuemetrics_server_ip = ereg_replace("[^\.0-9]","",$queuemetrics_server_ip);

### ALPHA-NUMERIC and spaces and hash and star and comma
$xferconf_a_dtmf = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$xferconf_a_dtmf);
$xferconf_b_dtmf = ereg_replace("[^ \,\*\#0-9a-zA-Z]","",$xferconf_b_dtmf);

### ALPHACAPS-NUMERIC
$xferconf_a_number = ereg_replace("[^0-9A-Z]","",$xferconf_a_number);
$xferconf_b_number = ereg_replace("[^0-9A-Z]","",$xferconf_b_number);

### ALPHA-NUMERIC and underscore and dash
$agi_output = ereg_replace("[^-\_0-9a-zA-Z]","",$agi_output);
$ASTmgrSECRET = ereg_replace("[^-\_0-9a-zA-Z]","",$ASTmgrSECRET);
$ASTmgrUSERNAME = ereg_replace("[^-\_0-9a-zA-Z]","",$ASTmgrUSERNAME);
$ASTmgrUSERNAMElisten = ereg_replace("[^-\_0-9a-zA-Z]","",$ASTmgrUSERNAMElisten);
$ASTmgrUSERNAMEsend = ereg_replace("[^-\_0-9a-zA-Z]","",$ASTmgrUSERNAMEsend);
$ASTmgrUSERNAMEupdate = ereg_replace("[^-\_0-9a-zA-Z]","",$ASTmgrUSERNAMEupdate);
$call_time_id = ereg_replace("[^-\_0-9a-zA-Z]","",$call_time_id);
$campaign_id = ereg_replace("[^-\_0-9a-zA-Z]","",$campaign_id);
$CoNfIrM = ereg_replace("[^-\_0-9a-zA-Z]","",$CoNfIrM);
$DBX_database = ereg_replace("[^-\_0-9a-zA-Z]","",$DBX_database);
$DBX_pass = ereg_replace("[^-\_0-9a-zA-Z]","",$DBX_pass);
$DBX_user = ereg_replace("[^-\_0-9a-zA-Z]","",$DBX_user);
$DBY_database = ereg_replace("[^-\_0-9a-zA-Z]","",$DBY_database);
$DBY_pass = ereg_replace("[^-\_0-9a-zA-Z]","",$DBY_pass);
$DBY_user = ereg_replace("[^-\_0-9a-zA-Z]","",$DBY_user);
$dial_method = ereg_replace("[^-\_0-9a-zA-Z]","",$dial_method);
$dial_status_a = ereg_replace("[^-\_0-9a-zA-Z]","",$dial_status_a);
$dial_status_b = ereg_replace("[^-\_0-9a-zA-Z]","",$dial_status_b);
$dial_status_c = ereg_replace("[^-\_0-9a-zA-Z]","",$dial_status_c);
$dial_status_d = ereg_replace("[^-\_0-9a-zA-Z]","",$dial_status_d);
$dial_status_e = ereg_replace("[^-\_0-9a-zA-Z]","",$dial_status_e);
$ext_context = ereg_replace("[^-\_0-9a-zA-Z]","",$ext_context);
$group_id = ereg_replace("[^-\_0-9a-zA-Z]","",$group_id);
$lead_filter_id = ereg_replace("[^-\_0-9a-zA-Z]","",$lead_filter_id);
$local_call_time = ereg_replace("[^-\_0-9a-zA-Z]","",$local_call_time);
$login = ereg_replace("[^-\_0-9a-zA-Z]","",$login);
$login_campaign = ereg_replace("[^-\_0-9a-zA-Z]","",$login_campaign);
$login_pass = ereg_replace("[^-\_0-9a-zA-Z]","",$login_pass);
$login_user = ereg_replace("[^-\_0-9a-zA-Z]","",$login_user);
$next_agent_call = ereg_replace("[^-\_0-9a-zA-Z]","",$next_agent_call);
$old_campaign_id = ereg_replace("[^-\_0-9a-zA-Z]","",$old_campaign_id);
$old_server_id = ereg_replace("[^-\_0-9a-zA-Z]","",$old_server_id);
$OLDuser_group = ereg_replace("[^-\_0-9a-zA-Z]","",$OLDuser_group);
$park_file_name = ereg_replace("[^-\_0-9a-zA-Z]","",$park_file_name);
$pass = ereg_replace("[^-\_0-9a-zA-Z]","",$pass);
$phone_login = ereg_replace("[^-\_0-9a-zA-Z]","",$phone_login);
$phone_pass = ereg_replace("[^-\_0-9a-zA-Z]","",$phone_pass);
$PHP_AUTH_PW = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_PW);
$PHP_AUTH_USER = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_USER);
$protocol = ereg_replace("[^-\_0-9a-zA-Z]","",$protocol);
$server_id = ereg_replace("[^-\_0-9a-zA-Z]","",$server_id);
$stage = ereg_replace("[^-\_0-9a-zA-Z]","",$stage);
$state_rule = ereg_replace("[^-\_0-9a-zA-Z]","",$state_rule);
$status = ereg_replace("[^-\_0-9a-zA-Z]","",$status);
$trunk_restriction = ereg_replace("[^-\_0-9a-zA-Z]","",$trunk_restriction);
$user = ereg_replace("[^-\_0-9a-zA-Z]","",$user);
$user_group = ereg_replace("[^-\_0-9a-zA-Z]","",$user_group);
$VICIDIAL_park_on_filename = ereg_replace("[^-\_0-9a-zA-Z]","",$VICIDIAL_park_on_filename);
$auto_alt_dial = ereg_replace("[^-\_0-9a-zA-Z]","",$auto_alt_dial);
$dial_status = ereg_replace("[^-\_0-9a-zA-Z]","",$dial_status);
$queuemetrics_eq_prepend = ereg_replace("[^-\_0-9a-zA-Z]","",$queuemetrics_eq_prepend);
$vicidial_agent_disable = ereg_replace("[^-\_0-9a-zA-Z]","",$vicidial_agent_disable);
$alter_custdata_override = ereg_replace("[^-\_0-9a-zA-Z]","",$alter_custdata_override);
$list_order_mix = ereg_replace("[^-\_0-9a-zA-Z]","",$list_order_mix);
$vcl_id = ereg_replace("[^-\_0-9a-zA-Z]","",$vcl_id);
$mix_method = ereg_replace("[^-\_0-9a-zA-Z]","",$mix_method);
$category = ereg_replace("[^-\_0-9a-zA-Z]","",$category);
$vsc_id = ereg_replace("[^-\_0-9a-zA-Z]","",$vsc_id);
$moh_context = ereg_replace("[^-\_0-9a-zA-Z]","",$moh_context);
$agent_alert_exten = ereg_replace("[^-\_0-9a-zA-Z]","",$agent_alert_exten);
$source_campaign_id = ereg_replace("[^-\_0-9a-zA-Z]","",$source_campaign_id);
$source_user_id = ereg_replace("[^-\_0-9a-zA-Z]","",$source_user_id);
$source_group_id = ereg_replace("[^-\_0-9a-zA-Z]","",$source_group_id);
$default_xfer_group = ereg_replace("[^-\_0-9a-zA-Z]","",$default_xfer_group);
$drop_exten = ereg_replace("[^-\_0-9a-zA-Z]","",$drop_exten);
$safe_harbor_exten = ereg_replace("[^-\_0-9a-zA-Z]","",$safe_harbor_exten);
$drop_action = ereg_replace("[^-\_0-9a-zA-Z]","",$drop_action);
$drop_inbound_group = ereg_replace("[^-\_0-9a-zA-Z]","",$drop_inbound_group);
$afterhours_xfer_group = ereg_replace("[^-\_0-9a-zA-Z]","",$afterhours_xfer_group);
$after_hours_action = ereg_replace("[^-\_0-9a-zA-Z]","",$after_hours_action);
$alias_id = ereg_replace("[^-\_0-9a-zA-Z]","",$alias_id);
$shift_id = ereg_replace("[^-\_0-9a-zA-Z]","",$shift_id);
$qc_shift_id = ereg_replace("[^-\_0-9a-zA-Z]","",$qc_shift_id);
$survey_first_audio_file = ereg_replace("[^-\_0-9a-zA-Z]","",$survey_first_audio_file);
$survey_opt_in_audio_file = ereg_replace("[^-\_0-9a-zA-Z]","",$survey_opt_in_audio_file);
$survey_ni_audio_file = ereg_replace("[^-\_0-9a-zA-Z]","",$survey_ni_audio_file);
$survey_method = ereg_replace("[^-\_0-9a-zA-Z]","",$survey_method);
$alter_custphone_override = ereg_replace("[^-\_0-9a-zA-Z]","",$alter_custphone_override);
$manual_dial_filter = ereg_replace("[^-\_0-9a-zA-Z]","",$manual_dial_filter);
$agent_clipboard_copy = ereg_replace("[^-\_0-9a-zA-Z]","",$agent_clipboard_copy);
$hold_time_option = ereg_replace("[^-\_0-9a-zA-Z]","",$hold_time_option);
$hold_time_option_xfer_group = ereg_replace("[^-\_0-9a-zA-Z]","",$hold_time_option_xfer_group);
$hold_recall_xfer_group = ereg_replace("[^-\_0-9a-zA-Z]","",$hold_recall_xfer_group);
$play_welcome_message = ereg_replace("[^-\_0-9a-zA-Z]","",$play_welcome_message);
$did_route = ereg_replace("[^-\_0-9a-zA-Z]","",$did_route);
$user_unavailable_action = ereg_replace("[^-\_0-9a-zA-Z]","",$user_unavailable_action);
$user_route_settings_ingroup = ereg_replace("[^-\_0-9a-zA-Z]","",$user_route_settings_ingroup);
$call_handle_method = ereg_replace("[^-\_0-9a-zA-Z]","",$call_handle_method);
$agent_search_method = ereg_replace("[^-\_0-9a-zA-Z]","",$agent_search_method);
$hold_time_option_voicemail = ereg_replace("[^-\_0-9a-zA-Z]","",$hold_time_option_voicemail);
$hold_time_option_callback_filename = ereg_replace("[^-\_0-9a-zA-Z]","",$hold_time_option_callback_filename);
$exten_context = ereg_replace("[^-\_0-9a-zA-Z]","",$exten_context);
$three_way_call_cid = ereg_replace("[^-\_0-9a-zA-Z]","",$three_way_call_cid);

### ALPHA-NUMERIC and underscore and dash and comma
$logins_list = ereg_replace("[^-\,\_0-9a-zA-Z]","",$logins_list);

### ALPHA-NUMERIC and spaces
$lead_order = ereg_replace("[^ 0-9a-zA-Z]","",$lead_order);
### ALPHA-NUMERIC and hash
$group_color = ereg_replace("[^\#0-9a-zA-Z]","",$group_color);
### ALPHA-NUMERIC and hash and star and dot and underscore
$hold_time_option_exten = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$hold_time_option_exten);
$did_pattern = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$did_pattern);
$voicemail_ext = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$voicemail_ext);
$phone = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$phone);
$phone_code = ereg_replace("[^\*\#\.\_0-9a-zA-Z]","",$phone_code);

### ALPHA-NUMERIC and spaces dots, commas, dashes, underscores
$adaptive_dl_diff_target = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$adaptive_dl_diff_target);
$adaptive_intensity = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$adaptive_intensity);
$asterisk_version = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$asterisk_version);
$call_time_comments = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$call_time_comments);
$call_time_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$call_time_name);
$campaign_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$campaign_name);
$campaign_rec_filename = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$campaign_rec_filename);
$ingroup_rec_filename = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$ingroup_rec_filename);
$company = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$company);
$full_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$full_name);
$fullname = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$fullname);
$group_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$group_name);
$HKstatus = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$HKstatus);
$lead_filter_comments = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$lead_filter_comments);
$lead_filter_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$lead_filter_name);
$list_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$list_name);
$local_gmt = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$local_gmt);
$phone_type = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$phone_type);
$picture = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$picture);
$script_comments = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$script_comments);
$script_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$script_name);
$server_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$server_description);
$status = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$status);
$status_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$status_name);
$wrapup_message = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$wrapup_message);
$pause_code_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$pause_code_name);
$campaign_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$campaign_description);
$list_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$list_description);
$vcl_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$vcl_name);
$vsc_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$vsc_name);
$vsc_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$vsc_description);
$code_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$code_name);
$alias_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$alias_name);
$shift_name = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$shift_name);
$did_description = ereg_replace("[^ \.\,-\_0-9a-zA-Z]","",$did_description);

### ALPHA-NUMERIC and underscore and dash and slash and at and dot
$call_out_number_group = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$call_out_number_group);
$client_browser = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$client_browser);
$DBX_server = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$DBX_server);
$DBY_server = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$DBY_server);
$dtmf_send_extension = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$dtmf_send_extension);
$extension = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$extension);
$install_directory = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$install_directory);
$old_extension = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$old_extension);
$telnet_host = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$telnet_host);
$queuemetrics_dbname = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$queuemetrics_dbname);
$queuemetrics_login = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$queuemetrics_login);
$queuemetrics_pass = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$queuemetrics_pass);
$after_hours_message_filename = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$after_hours_message_filename);
$welcome_message_filename = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$welcome_message_filename);
$onhold_prompt_filename = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$onhold_prompt_filename);
$email = ereg_replace("[^-\.\:\/\@\_0-9a-zA-Z]","",$email);

### ALPHA-NUMERIC and underscore and dash and slash and at and space and colon
$vdc_header_date_format = ereg_replace("[^- \:\/\_0-9a-zA-Z]","",$vdc_header_date_format);
$vdc_customer_date_format = ereg_replace("[^- \:\/\_0-9a-zA-Z]","",$vdc_customer_date_format);

### ALPHA-NUMERIC and underscore and dash and at and space and parantheses
$vdc_header_phone_format = ereg_replace("[^- \(\)\_0-9a-zA-Z]","",$vdc_header_phone_format);

### remove semi-colons ###
$lead_filter_sql = ereg_replace(";","",$lead_filter_sql);
$list_mix_container = ereg_replace(";","",$list_mix_container);
$survey_response_digit_map = ereg_replace(";","",$survey_response_digit_map);
$survey_camp_record_dir = ereg_replace(";","",$survey_camp_record_dir);

### VARIABLES TO BE mysql_real_escape_string ###
# $web_form_address
# $queuemetrics_url
# $admin_home_url
# $qc_web_form_address

### VARIABLES not filtered at all ###
# $script_text

}	# end of non_latin


##### END VARIABLE FILTERING FOR SECURITY #####


# AST GUI database administration
# admin.php
# 
# CHANGELOG:
# 50315-1110 - Added Custom Campaign Statuses
# 50317-1438 - Added Fronter Display var to inbound groups
# 50322-1355 - Added custom callerID per campaign
# 50517-1356 - Added user_groups sections and user_group to vicidial_users
# 50517-1440 - Added ability to logout (must click OK with empty user/pass)
# 50602-1622 - Added lead loader pages to load new files into vicidial_list
# 50620-1351 - Added custom vdad transfer AGI extension per campaign
# 50810-1414 - modified in groups to kick out spaces and dashes
# 50908-2136 - Added Custom Campaign HotKeys
# 50914-0950 - Fixed user search by user_group
# 50926-1358 - Modified to allow for language translation
# 50926-1615 - Added WeBRooTWritablE write controls
# 51020-1008 - Added editable web address and park ext - NEW dial campaigns
# 51020-1056 - Added fields and help for campaign recording control
# 51123-1335 - Altered code to function in php globals=off
# 51208-1038 - Added user_level changes, function controls and default user phones
# 51208-1556 - Added deletion of users/lists/campaigns/in groups/remote agents
# 51213-1706 - Added add/delete/modify vicidial scripts
# 51214-1737 - Added preview of vicidial script in popup window
# 51219-1225 - Added campaign and ingroups script selector and get_call_launch field
# 51222-1055 - Added am_message_exten to campaigns to allow for AM Message button
# 51222-1125 - Fixed new vicidial_campaigns default values not being assigned bug
# 51222-1156 - Added LOG OUT ALL AGENTS ON THIS CAMPAIGN button to campaign screen
# 60204-0659 - Fixed hopper reset bug
# 60207-1413 - Added AMD send to voicemail extension and xfer-conf dtmf presets
# 60213-1100 - Added several vicidial_users permissions fields
# 60215-1319 - Added On-hold CallBacks display and links
# 60227-1226 - Fixed vicidial_inbound_groups insert bug
# 60413-1308 - Fixed list display to have 1 row/status: count and time zone tables
#            - Added status name in selected dial statuses in campaign screen
# 60417-1416 - Added vicidial_lead_filters sections
#            - Changed the header links to color-coded sectional with sublinks below
#            - Added filter name and script name to campaign and in-group modify sections
#            - Added callback and alt dial options to campaigns section
#            - Added callback, alt dial and other options to users section
# 60419-1628 - Alter Callbacks display to include status and LIVE listings, reordered
# 60421-1441 - check GET/POST vars lines with isset to not trigger PHP NOTICES
# 60425-2355 - Added agent options to vicidial_users, reformatted user page
# 60502-1627 - Added drop_call_seconds and safe_harbor_ fields to campaign screen
# 60503-1228 - Added drop_call_seconds and drop_ fields to inbound groups screen
# 60505-1117 - Added initial framework for new local_call_times tables and definitions
# 60506-1033 - More revisions to the local_call_time section
# 60508-1354 - Finished call_times and state_call_times sections
#            - Added modify/delete options for call_times
# 60509-1311 - Functionalize campaign dialable leads calculation
#            - Change state_call_times selection from call_times to only allow one per state
#            - Added dialable leads count popup to campaign screen if auto-calc is disabled
#            - Added test dialable leads count popup to filter screen 
# 60510-1050 - Added Wrapup seconds and Wrapup message to campaigns screen
# 60608-1401 - Added allowable inbound_groups checkboxes to CLOSER campaign detail screen
# 60609-1051 - Added add-to-dnc in LISTS section
# 60613-1415 - Added lead recycling options to campaign detail screen
# 60619-1523 - Added variable filtering to eliminate SQL injection attack threat
# 60622-1216 - Fixed HotKey addition form issues and variable filtering
# 60623-1159 - Fixed Scheduled Callbacks over-filtering bug and filter_sql bug
# 60808-1147 - Changed filtering for and added instructions for consutative transfers
# 60816-1552 - Added allcalls_delay start delay for recordings in vicidial.php
# 60817-2226 - Fixed bug that would not allow lead recycling of non-selectable statuses
# 60821-1543 - Added option to Omit Phone Code while dialing in vicidial
# 60821-1625 - Added ALLFORCE recording option for campaign_recording
# 60823-1154 - Added fields for adaptive dialing
# 60824-1326 - Added adaptive_latest_target_gmt for ADAPT_TAPERED dial method
# 60825-1205 - Added adaptive_intensity for ADAPT_ dial methods
# 60828-1019 - Changed adaptive_latest_target_gmt to adaptive_latest_server_time
# 60828-1115 - Added adaptive_dl_diff_target and changed intensity dropdown
# 60927-1246 - Added astguiclient/admin.php functions under SERVERS tab
# 61002-1402 - Added fields for vicidial balance trunk controls
# 61003-1123 - Added functions for vicidial_server_trunks records
# 61109-1022 - Added Emergency VDAC Jam Clear function to Campaign Detail screen
# 61110-1502 - Add ability to select NONE in dial statuses, new list_id must not be < 100
# 61122-1228 - Added user group campaign restrictions
# 61122-1535 - Changed script_text to unfiltered and added more variables to SCRIPTS
# 61129-1028 - Added headers to Users and Phones with clickable order-by titles
# 70108-1405 - Added ADAPT OVERRIDE to allow for forced dial_level changes in ADAPT dial methods
#            - Screen width definable at top of script, merged server_stats into this script
# 70109-1638 - Added ALTPH2 and ADDR3 hotkey options for alt number dialing with HotKeys
# 70109-1716 - Added concurrent_transfers option to vicidial_campaigns
# 70115-1152 - Aded (CLOSER|BLEND|INBND|_C$|_B$|_I$) options for CLOSER-type campaigns
# 70115-1532 - Added auto_alt_dial field to campaign screen for auto-dialing of alt numbers
# 70116-1200 - Added auto_alt_dial_status functionality to campaign screen
# 70117-1235 - Added header formatting variables at top of script
#            - Moved Call Times and Phones/Server functions to Admin section
# 70118-1706 - Added new user group displays and links
# 70123-1519 - Added user permission settings for all sections
# 70124-1346 - Fixed spelling errors and formatting consistency
# 70202-1120 - Added agent_pause_codes section to campaigns
# 70205-1204 - Added memo, last dialed, timestamp and stats-refresh fields to vicidial_campaigns/lists
# 70206-1323 - Added user setting for vicidial_recording_override
# 70212-1412 - Added system settings section
# 70214-1226 - Added QueueMetrics Log ID field to system settings section
# 70219-1102 - Changed campaign dial statuses to be one string allowing for high limit
# 70223-0957 - Added queuemetrics_eq_prepend for custom ENTERQUEUE prepending of a field
# 70302-1111 - Fixed small bug in dialable leads calculation
# 70314-1133 - Added insert selection on script forms
# 70319-1423 - Added Alter Customer Data and agent disable display functions
# 70319-1625 - Added option to allow agents to login to outbound campaigns with no leads in the hopper
# 70322-1455 - Added sipsak messages parameters
# 70402-1157 - Added HOME link and entry to system_settings table, added QM link on reports section
# 70516-1628 - Started reformatting campaigns to use submenus to break up options
# 70529-1653 - Added help for list mix
# 70530-1354 - Added human_answered field to statuses, added system status modification
# 70530-1714 - Added lists for all campaign subsections
# 70531-1631 - Development on List mix admin interface
# 70601-1629 - More development on List mix admin interface, formatting, and added some javascript
# 70602-1300 - More development on List mix admin interface, more javascript
# 70608-1459 - Added option to set LIVE Callbacks to INACTIVE after one month
# 70612-1451 - Added Callback INACTIVE link for after one week, sort by user/group/entrydate
# 70614-0231 - Added Status Categories, ability to Modify Statuses, moved system statuses to sub-section
# 70623-1008 - List Mix section now allows modification of list mix entries
# 70629-1721 - List Mix section adding and removing of list entries active
# 70706-1636 - List Mix section cleanup and more error-checking
# 70908-0941 - Added agc logile enable system_settings
# 71020-1934 - Added inbound groups options: on-hold music, messages, call_times
# 71022-1343 - Added inbound group ranks for users
# 71029-1710 - Added option for campaign to be inbound and/or blended with no restrictions on the campaign_id name
#            - Added 5th NEW and 6th NEW to the dial order options
# 71030-2010 - Added Manual Dial List ID field to campaigns table
# 71103-2207 - Added inbound_group_rank and fewest_calls to the inbound groups call order options
# 71113-1521 - Added campaign_rank to agent options
#            - Added ability to Copy a campaign's setting to a new campaign
# 71113-2225 - Added ability to copy user and in-group settings to new users and in-groups
# 71116-0942 - Added campaign_rank and fewest_calls as methods for agent call routing
# 71122-1135 - Added default transfer group for campaigns and inbound groups
# 71125-1751 - Added allowable transfer groups to campaign detail screen
# 80107-1204 - Started framework for new QC section
# 80112-0242 - Added more options for lead order
# 80211-1901 - Added DB Schema Version to system settings display
# 80224-1334 - Added Queue Priority to in-groups and campaigns
# 80302-0232 - added drop_action and transfer to in-group for both in-groups and outbound
# 80310-1504 - added QC settings section to campaign screen
# 80317-2037 - Added Recording override settings to in-groups
# 80414-1505 - More work on QC, added vicidial_qc_codes
# 80424-0442 - Added non_latin system_settings lookup at top to override dbconnect setting
# 80505-0333 - Added phones_alias sections to allow for load-balanced-phone-logins
# 80512-1529 - Added auto-generate of User ID feature
# 80515-1345 - Added Shifts sub-section to Admin section
# 80528-0001 - Added campaign survey sub-section
# 80528-1102 - Added user timeclock edit options
# 80608-1304 - Changed add-to-DNC to allow for multiple entries per submission
# 80625-0032 - Added time/phone display format options to system settings
# 80703-0124 - Added alter cust phone and api settings
# 80715-1130 - Added Recycle leads limit count
# 80719-1351 - Changed QC settings in campaigns and In-Groups
# 80809-2305 - Added Sale and Dead Lead categories to status categories page
# 80815-1036 - Added manual dial filter to capaigns
# 80823-2124 - Added copy to clipboard campaign option
# 80829-2359 - Added EXTENDED auto_alt_dial options
# 80831-0406 - Added agent screen extended alt-dial option to campaigns
# 80909-0553 - Added campaign-specific DNC list option and add
# 81002-1101 - Added more in-group options and new DID section and user options
# 81007-0936 - Added three_way_call_cid option to campaigns
# 81012-1725 - Added INBOUND_MAN dial method allowing for manual list dialing with inbound calls
#
# make sure you have added a user to the vicidial_users MySQL table with at least user_level 8 to access this page the first time

$admin_version = '2.0.5-145';
$build = '81012-1725';

$STARTtime = date("U");
$SQLdate = date("Y-m-d H:i:s");
$MT[0]='';
$US='_';

$month_old = mktime(0, 0, 0, date("m")-1, date("d"),  date("Y"));
$past_month_date = date("Y-m-d H:i:s",$month_old);
$week_old = mktime(0, 0, 0, date("m"), date("d")-7,  date("Y"));
$past_week_date = date("Y-m-d H:i:s",$week_old);

if ($force_logout)
{
  if( (strlen($PHP_AUTH_USER)>0) or (strlen($PHP_AUTH_PW)>0) )
	{
    Header("WWW-Authenticate: Basic realm=\"VICI-PROJECTS\"");
    Header("HTTP/1.0 401 Unauthorized");
	}
    echo "Ora non sei collegato. Grazie\n";
    exit;
}

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin FROM system_settings;";
$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysql_num_rows($rslt);
$i=0;
while ($i < $qm_conf_ct)
	{
	$row=mysql_fetch_row($rslt);
	$non_latin =					$row[0];
	$i++;
	}
##### END SETTINGS LOOKUP #####
###########################################

$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level > 7;";
if ($DB) {echo "|$stmt|\n";}
if ($non_latin > 0) {$rslt=mysql_query("SET NAMES 'UTF8'");}
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$auth=$row[0];

if ($WeBRooTWritablE > 0)
	{$fp = fopen ("./project_auth_entries.txt", "a");}

$date = date("r");
$ip = getenv("REMOTE_ADDR");
$browser = getenv("HTTP_USER_AGENT");

  if( (strlen($PHP_AUTH_USER)<2) or (strlen($PHP_AUTH_PW)<2) or ($auth<1))
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
			$stmt="SELECT * from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			$LOGfullname				=$row[3];
			$LOGuser_level				=$row[4];
			$LOGuser_group				=$row[5];
			$LOGdelete_users			=$row[8];
			$LOGdelete_user_groups		=$row[9];
			$LOGdelete_lists			=$row[10];
			$LOGdelete_campaigns		=$row[11];
			$LOGdelete_ingroups			=$row[12];
			$LOGdelete_remote_agents	=$row[13];
			$LOGload_leads				=$row[14];
			$LOGcampaign_detail			=$row[15];
			$LOGast_admin_access		=$row[16];
			$LOGast_delete_phones		=$row[17];
			$LOGdelete_scripts			=$row[18];
			$LOGdelete_filters			=$row[29];
			$LOGalter_agent_interface	=$row[30];
			$LOGdelete_call_times		=$row[32];
			$LOGmodify_call_times		=$row[33];
			$LOGmodify_users			=$row[34];
			$LOGmodify_campaigns		=$row[35];
			$LOGmodify_lists			=$row[36];
			$LOGmodify_scripts			=$row[37];
			$LOGmodify_filters			=$row[38];
			$LOGmodify_ingroups			=$row[39];
			$LOGmodify_usergroups		=$row[40];
			$LOGmodify_remoteagents		=$row[41];
			$LOGmodify_servers			=$row[42];
			$LOGview_reports			=$row[43];
			$LOGmodify_dids				=$row[56];
			$LOGdelete_dids				=$row[57];

			$stmt="SELECT allowed_campaigns from vicidial_user_groups where user_group='$LOGuser_group';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			$LOGallowed_campaigns		=$row[0];

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

######################################################################################################
######################################################################################################
#######   Header settings
######################################################################################################
######################################################################################################


header ("Content-type: text/html; charset=utf-8");
echo "<html>\n";
echo "<head>\n";
echo "<!-- VERSIONE: $admin_version   BUILD: $build   ADD: $ADD   PHP_SELF: $PHP_SELF-->\n";
echo "<title>VICIDIAL ADMIN: ";

if (!isset($ADD))   {$ADD=0;}

if ($ADD=="1")			{$hh='users';		echo "Aggiungi Nuovo Utente";}
if ($ADD=="1A")			{$hh='users';		echo "Copia Utente";}
if ($ADD==11)			{$hh='campaigns';	$sh='basic';	echo "Aggiungi Nuova Campagna";}
if ($ADD==12)			{$hh='campaigns';	$sh='basic';	echo "Copia Campagna";}
if ($ADD==111)			{$hh='lists';		echo "Aggiungi Nuova Lista";}
if ($ADD==121)			{$hh='lists';		echo "Agregue DNC Nuevo";}
if ($ADD==1111)			{$hh='ingroups';	echo "Aggiungi Nuovo Gruppo Inbound";}
if ($ADD==1211)			{$hh='ingroups';	echo "Copia Gruppo Inbound";}
if ($ADD==1311)			{$hh='ingroups';	echo "Add New DID";}
if ($ADD==1411)			{$hh='ingroups';	echo "Copy DID";}
if ($ADD==11111)		{$hh='remoteagent';	echo "Aggiungi Nuovo Operatore Remoto";}
if ($ADD==111111)		{$hh='usergroups';	echo "Aggiungi Nuovo Gruppo Utente";}
if ($ADD==1111111)		{$hh='scripts';		echo "Aggiungi Nuovo Script";}
if ($ADD==11111111)		{$hh='filters';		echo "Agiungi Nuovo Filtro";}
if ($ADD==111111111)	{$hh='admin';	$sh='times';	echo "Agregue El Nuevo Tiempo De la Llamada";}
if ($ADD==131111111)	{$hh='admin';	$sh='times';	echo "Add New Shift";}
if ($ADD==1111111111)	{$hh='admin';	$sh='times';	echo "Agregue El Nuevo Tiempo De la Llamada Del Estado";}
if ($ADD==11111111111)	{$hh='admin';	$sh='phones';	echo "AGGIUNGI TELEFONO";}
if ($ADD==12111111111)	{$hh='admin';	$sh='phones';	echo "AGGIUNGI TELEFONO ALIAS";}
if ($ADD==111111111111)	{$hh='admin';	$sh='server';	echo "AGGIUNGI SERVER";}
if ($ADD==1111111111111)	{$hh='admin';	$sh='conference';	echo "NUEVA CONFERENCIA";}
if ($ADD==11111111111111)	{$hh='admin';	$sh='conference';	echo "ADD NEW VICIDIAL CONFERENCE";}
if ($ADD=='2')			{$hh='users';		echo "Creazione Nuovo Utente";}
if ($ADD=='2A')			{$hh='users';		echo "Nueva Adicio`n Copiada Del Usuario";}
if ($ADD==20)			{$hh='campaigns';	$sh='basic';	echo "Nueva Adicio`n Copiada De la Campaña";}
if ($ADD==21)			{$hh='campaigns';	$sh='basic';	echo "Creazione Nuova Campagna";}
if ($ADD==22)			{$hh='campaigns';	$sh='status';	echo "Creazione Nuovo Esito Personalizzato Per Campagna";}
if ($ADD==23)			{$hh='campaigns';	$sh='hotkey';	echo "New Campagna HotKey Addition";}
if ($ADD==25)			{$hh='campaigns';	$sh='recycle';	echo "El Nuevo Plomo De la Campaña Recicla La Adicio`n";}
if ($ADD==26)			{$hh='campaigns';	$sh='autoalt';	echo "Nuevo Estado Del Dial Del Alt Del Automo`vil";}
if ($ADD==27)			{$hh='campaigns';	$sh='pause';	echo "Nuevo Co`digo De la Pausa Del Agente";}
if ($ADD==28)			{$hh='campaigns';	$sh='dialstat';	echo "Esito Campagna Aggiunto";}
if ($ADD==29)			{$hh='campaigns';	$sh='listmix';	echo "Mezcla De la Lista De la Campaña Agregada";}
if ($ADD==211)			{$hh='lists';		echo "Creazione Nuova Lista";}
if ($ADD==2111)			{$hh='ingroups';	echo "Creazione Nuovo Gruppo Inbound";}
if ($ADD==2011)			{$hh='ingroups';	echo "Nueva Adicin Copiada Del En-Grupo";}
if ($ADD==2311)			{$hh='ingroups';	echo "New DID Addition";}
if ($ADD==2411)			{$hh='ingroups';	echo "New Copied DID Addition";}
if ($ADD==21111)		{$hh='remoteagent';	echo "Creazuibe Nuovi Operatori Remoti";}
if ($ADD==211111)		{$hh='usergroups';	echo "Creazione Nuovo Gruppo Utenti";}
if ($ADD==2111111)		{$hh='scripts';		echo "Creazione Nuovo Script";}
if ($ADD==21111111)		{$hh='filters';		echo "Nueva Adicio`n Del Filtro";}
if ($ADD==211111111)	{$hh='admin';	$sh='times';	echo "Nueva Adicio`n Del Tiempo De la Llamada";}
if ($ADD==231111111)	{$hh='admin';	$sh='times';	echo "New Shift Addition";}
if ($ADD==2111111111)	{$hh='admin';	$sh='times';	echo "Nueva Adicio`n Del Tiempo De la Llamada Del Estado";}
if ($ADD==21111111111)	{$hh='admin';	$sh='phones';	echo "CREANDO telefono";}
if ($ADD==22111111111)	{$hh='admin';	$sh='phones';	echo "CREANDO telefono ALIAS";}
if ($ADD==211111111111)	{$hh='admin';	$sh='server';	echo "CREANDO SERVIDOR";}
if ($ADD==221111111111)	{$hh='admin';	$sh='server';	echo "ADICIo`N DEL NUEVO EXPEDIENTE DEL TRONCO DEL SERVIDOR VICIDIAL";}
if ($ADD==2111111111111)	{$hh='admin';	$sh='conference';	echo "CREANDO CONFERENCIA";}
if ($ADD==21111111111111)	{$hh='admin';	$sh='conference';	echo "ADDING NEW VICIDIAL CONFERENCE";}
if ($ADD==221111111111111)	{$hh='admin';	$sh='status';	echo "AGGIUNGI ESITI DI DEFAULT VICIDIAL";}
if ($ADD==231111111111111)	{$hh='admin';	$sh='status';	echo "ADICIo`N DE CATEGORÍA DEL ESTADO DE VICIDIAL";}
if ($ADD==241111111111111)	{$hh='admin';	$sh='status';	echo "ADDING VICIDIAL QC STATUS CODE";}
if ($ADD==3)			{$hh='users';		echo "Modifica Utente";}
if ($ADD==30)			{$hh='campaigns';	echo "Campagna Non Autorizzata";}
if ($ADD==31)			
		{
		$hh='campaigns';	$sh='detail';	echo "Modifica Campagna - Dettagliata - $campaign_id";
		if ($SUB==22)	{echo " - Esiti";}
		if ($SUB==23)	{echo " - Hot-Key";}
		if ($SUB==25)	{echo " -Riciclaggio ContattiEntries";}
		if ($SUB==26)	{echo " - Auto Alt Dial Esiti";}
		if ($SUB==27)	{echo " - Agent Codici Pausa";}
		if ($SUB==28)	{echo " - QC";}
		if ($SUB==29)	{echo " - List Mixes";}
		if ($SUB=='20A')	{echo " - Survey";}
		}
if ($ADD==34)
		{
		$hh='campaigns';	$sh='basic';	echo "Modifica Campagna - Vista Generale - $campaign_id";
		if ($SUB==22)	{echo " - Esiti";}
		if ($SUB==23)	{echo " - Hot-Key";}
		if ($SUB==25)	{echo " -Riciclaggio ContattiEntries";}
		if ($SUB==26)	{echo " - Auto Alt Dial Esiti";}
		if ($SUB==27)	{echo " - Agent Codici Pausa";}
		if ($SUB==28)	{echo " - QC";}
		if ($SUB==29)	{echo " - List Mixes";}
		if ($SUB=='20A')	{echo " - Survey";}
		}
if ($ADD==32)			{$hh='campaigns';	$sh='status';	echo "Esiti Campagna";}
if ($ADD==33)			{$hh='campaigns';	$sh='hotkey';	echo "Hot-Key Campagna";}
if ($ADD==35)			{$hh='campaigns';	$sh='recycle';	echo "El Plomo De la Campaña Recicla Entradas";}
if ($ADD==36)			{$hh='campaigns';	$sh='autoalt';	echo "Estados Auto Del Dial Del Alt De la Campaña";}
if ($ADD==37)			{$hh='campaigns';	$sh='pause';	echo "Codici Pausa Operatore per Campagna";}
if ($ADD==38)			{$hh='campaigns';	$sh='dialstat';	echo "Estados Del Dial De la Campaña";}
if ($ADD==39)			{$hh='campaigns';	$sh='listmix';	echo "Mezclas De la Lista De la Campaña";}
if ($ADD==311)			{$hh='lists';		echo "Modifica Lista";}
if ($ADD==3111)			{$hh='ingroups';	echo "Modifica Gruppo Inbound";}
if ($ADD==3311)			{$hh='ingroups';	echo "Modify DID";}
if ($ADD==31111)		{$hh='remoteagent';	echo "Modifica Operatori Remoti";}
if ($ADD==311111)		{$hh='usergroups';	echo "Modifica Gruppi Utenti";}
if ($ADD==3111111)		{$hh='scripts';		echo "Modifica Script";}
if ($ADD==31111111)		{$hh='filters';		echo "Modifica Filtro";}
if ($ADD==311111111)	{$hh='admin';	$sh='times';	echo "Modifique El Tiempo De la Llamada";}
if ($ADD==321111111)	{$hh='admin';	$sh='times';	echo "Modifique La Lista De las Definiciones Del Estado Del Tiempo De laLlamada";}
if ($ADD==331111111)	{$hh='admin';	$sh='times';	echo "Modify Shift";}
if ($ADD==3111111111)	{$hh='admin';	$sh='times';	echo "Modifique El Tiempo De la Llamada Del Estado";}
if ($ADD==31111111111)	{$hh='admin';	$sh='phones';	echo "MODIFICAR EL telefonO";}
if ($ADD==32111111111)	{$hh='admin';	$sh='phones';	echo "MODIFICAR EL telefonO ALIAS";}
if ($ADD==311111111111)	{$hh='admin';	$sh='server';	echo "MODIFICAR EL SERVIDOR";}
if ($ADD==3111111111111)	{$hh='admin';	$sh='conference';	echo "MODIFICAR LA CONFERENCIA";}
if ($ADD==31111111111111)	{$hh='admin';	$sh='conference';	echo "MODIFY VICIDIAL CONFERENCE";}
if ($ADD==311111111111111)	{$hh='admin';	$sh='settings';	echo "MODIFICA IMPOSTAZIONI DI SISTEMA";}
if ($ADD==321111111111111)	{$hh='admin';	$sh='status';	echo "MODIFICA ESITI DI DEFAULT VICIDIAL";}
if ($ADD==331111111111111)	{$hh='admin';	$sh='status';	echo "MODIFICA LE CATEGORIE DI ESITI DI VICIDIAL";}
if ($ADD==341111111111111)	{$hh='admin';	$sh='status';	echo "MODIFY VICIDIAL QC STATUS CODE";}
if ($ADD=="4A")			{$hh='users';		echo "Modifica Utente - Admin";}
if ($ADD=="4B")			{$hh='users';		echo "Modifica Utente - Admin";}
if ($ADD==4)			{$hh='users';		echo "Modifica Utente";}
if ($ADD==41)			{$hh='campaigns';	$sh='detail';	echo "Modifica Campagna";}
if ($ADD==42)			{$hh='campaigns';	$sh='status';	echo "Modifica Campagna Status";}
if ($ADD==43)			{$hh='campaigns';	$sh='hotkey';	echo "Modifica Campagna HotKey";}
if ($ADD==44)			{$hh='campaigns';	$sh='basic';	echo "Modifica Campagna - Vista Generale";}
if ($ADD==45)			{$hh='campaigns';	$sh='recycle';	echo "Modifique El Plomo De la Campaña Reciclan";}
if ($ADD==47)			{$hh='campaigns';	$sh='pause';	echo "Modifique El Co`digo De la Pausa Del Agente";}
if ($ADD==48)			{$hh='campaigns';	$sh='qc';	echo "Modifica Campagna QC Settings";}
if ($ADD==49)			{$hh='campaigns';	$sh='listmix';	echo "Modifique La Mezcla De la Lista De la Campaña";}
if ($ADD=='40A')		{$hh='campaigns';	$sh='survey';	echo "Modifica Campagna Survey";}
if ($ADD==411)			{$hh='lists';		echo "Modifica Lista";}
if ($ADD==4111)			{$hh='ingroups';	echo "Modifica Gruppo Inbound";}
if ($ADD==4311)			{$hh='ingroups';	echo "Modify DID";}
if ($ADD==41111)		{$hh='remoteagent';	echo "Modifica Operatori Remoti";}
if ($ADD==411111)		{$hh='usergroups';	echo "Modifica Gruppi Utenti";}
if ($ADD==4111111)		{$hh='scripts';		echo "Modifica Script";}
if ($ADD==41111111)		{$hh='filters';		echo "Modifica Filtro";}
if ($ADD==411111111)	{$hh='admin';	$sh='times';	echo "Modifique El Tiempo De la Llamada";}
if ($ADD==431111111)	{$hh='admin';	$sh='times';	echo "Modify Shift";}
if ($ADD==4111111111)	{$hh='admin';	$sh='times';	echo "Modifique El Tiempo De la Llamada Del Estado";}
if ($ADD==41111111111)	{$hh='admin';	$sh='phones';	echo "MODIFICAR EL telefonO";}
if ($ADD==42111111111)	{$hh='admin';	$sh='phones';	echo "MODIFICAR EL telefonO ALIAS";}
if ($ADD==411111111111)	{$hh='admin';	$sh='server';	echo "MODIFICAR EL SERVIDOR";}
if ($ADD==421111111111)	{$hh='admin';	$sh='server';	echo "MODIFIQUE EL EXPEDIENTE DEL TRONCO DEL SERVIDOR VICIDIAL";}
if ($ADD==4111111111111)	{$hh='admin';	$sh='conference';	echo "MODIFICAR LA CONFERENCIA";}
if ($ADD==41111111111111)	{$hh='admin';	$sh='conference';	echo "MODIFY VICIDIAL CONFERENCE";}
if ($ADD==411111111111111)	{$hh='admin';	$sh='settings';	echo "MODIFICA IMPOSTAZIONI DI SISTEMA";}
if ($ADD==421111111111111)	{$hh='admin';	$sh='status';	echo "MODIFICA ESITI DI DEFAULT VICIDIAL";}
if ($ADD==431111111111111)	{$hh='admin';	$sh='status';	echo "MODIFIQUE LAS CATEGORÍAS DEL ESTADO DE VICIDIAL";}
if ($ADD==441111111111111)	{$hh='admin';	$sh='status';	echo "MODIFY VICIDIAL QC STATUS CODE";}
if ($ADD==5)			{$hh='users';		echo "Delete User";}
if ($ADD==51)			{$hh='campaigns';	$sh='detail';	echo "Delete Campagna";}
if ($ADD==52)			{$hh='campaigns';	$sh='detail';	echo "Disconnetti Operatori";}
if ($ADD==53)			{$hh='campaigns';	$sh='detail';	echo "Claro Del Atasco De la Emergencia VDAC";}
if ($ADD==511)			{$hh='lists';		echo "Delete List";}
if ($ADD==5111)			{$hh='ingroups';	echo "Delete In-Group";}
if ($ADD==5311)			{$hh='ingroups';	echo "Delete DID";}
if ($ADD==51111)		{$hh='remoteagent';	echo "Suprima los agentes alejados";}
if ($ADD==511111)		{$hh='usergroups';	echo "Cancella Utenti Group";}
if ($ADD==5111111)		{$hh='scripts';		echo "Cancella Script";}
if ($ADD==51111111)		{$hh='filters';		echo "Cancella Filtro";}
if ($ADD==511111111)	{$hh='admin';	$sh='times';	echo "Delete Call Time";}
if ($ADD==531111111)	{$hh='admin';	$sh='times';	echo "Delete Shift";}
if ($ADD==5111111111)	{$hh='admin';	$sh='times';	echo "Tiempo De la Llamada Del Estado De la Cancelacio`n";}
if ($ADD==51111111111)	{$hh='admin';	$sh='phones';	echo "DELETE PHONE";}
if ($ADD==52111111111)	{$hh='admin';	$sh='phones';	echo "DELETE PHONE ALIAS";}
if ($ADD==511111111111)	{$hh='admin';	$sh='server';	echo "DELETE SERVER";}
if ($ADD==5111111111111)	{$hh='admin';	$sh='conference';	echo "DELETE CONFERENCE";}
if ($ADD==51111111111111)	{$hh='admin';	$sh='conference';	echo "DELETE VICIDIAL CONFERENCE";}
if ($ADD==6)			{$hh='users';		echo "Delete User";}
if ($ADD==61)			{$hh='campaigns';	$sh='detail';	echo "Delete Campagna";}
if ($ADD==62)			{$hh='campaigns';	$sh='detail';	echo "Disconnetti Operatori";}
if ($ADD==63)			{$hh='campaigns';	$sh='detail';	echo "Claro Del Atasco De la Emergencia VDAC";}
if ($ADD==65)			{$hh='campaigns';	$sh='recycle';	echo "El Plomo De la Cancelacio`n Recicla";}
if ($ADD==66)			{$hh='campaigns';	$sh='autoalt';	echo "Estado Auto Del Dial Del Alt De la Cancelacio`n";}
if ($ADD==67)			{$hh='campaigns';	$sh='pause';	echo "Co`digo De la Pausa Del Agente De la Cancelacio`n";}
if ($ADD==68)			{$hh='campaigns';	$sh='dialstat';	echo "Esito Campagna Rimosso";}
if ($ADD==69)			{$hh='campaigns';	$sh='listmix';	echo "La Mezcla De la Lista De la Campaña Quito`";}
if ($ADD==611)			{$hh='lists';		echo "Delete List";}
if ($ADD==6111)			{$hh='ingroups';	echo "Delete In-Group";}
if ($ADD==6311)			{$hh='ingroups';	echo "Delete DID";}
if ($ADD==61111)		{$hh='remoteagent';	echo "Suprima los agentes alejados";}
if ($ADD==611111)		{$hh='usergroups';	echo "Cancella Utenti Group";}
if ($ADD==6111111)		{$hh='scripts';		echo "Cancella Script";}
if ($ADD==61111111)		{$hh='filters';		echo "Cancella Filtro";}
if ($ADD==611111111)	{$hh='admin';	$sh='times';	echo "Delete Call Time";}
if ($ADD==631111111)	{$hh='admin';	$sh='times';	echo "Delete Shift";}
if ($ADD==6111111111)	{$hh='admin';	$sh='times';	echo "Tiempo De la Llamada Del Estado De la Cancelacio`n";}
if ($ADD==61111111111)	{$hh='admin';	$sh='phones';	echo "DELETE PHONE";}
if ($ADD==62111111111)	{$hh='admin';	$sh='phones';	echo "DELETE PHONE ALIAS";}
if ($ADD==611111111111)	{$hh='admin';	$sh='server';	echo "DELETE SERVER";}
if ($ADD==621111111111)	{$hh='admin';	$sh='server';	echo "EXPEDIENTE DEL TRONCO DEL SERVIDOR VICIDIAL DE LA CANCELACIo`N";}
if ($ADD==6111111111111)	{$hh='admin';	$sh='conference';	echo "DELETE CONFERENCE";}
if ($ADD==61111111111111)	{$hh='admin';	$sh='conference';	echo "DELETE VICIDIAL CONFERENCE";}
if ($ADD==73)			{$hh='campaigns';	echo "Cuenta Del Plomo De Dialable";}
if ($ADD==7111111)		{$hh='scripts';		echo "Anteprima Script";}
if ($ADD==0)			{$hh='users';		echo "Lista Utenti";}
if ($ADD==8)			{$hh='users';		echo "Richiami Dell`Operatore";}
if ($ADD==81)			{$hh='campaigns';	$sh='list';	echo "Richiami Nella Campagna";}
if ($ADD==811)			{$hh='lists';	echo "Richiami Nella Lista";}
if ($ADD==8111)			{$hh='usergroups';	echo "Richiami In Attesa In Questo Gruppo";}
if ($ADD==10)			{$hh='campaigns';	$sh='list';		echo "Campagnas";}
if ($ADD==100)			{$hh='lists';		echo "Liste";}
if ($ADD==1000)			{$hh='ingroups';	echo "In-Groups";}
if ($ADD==1300)			{$hh='ingroups';	echo "DIDs";}
if ($ADD==10000)		{$hh='remoteagent';	echo "Operatori Remoti";}
if ($ADD==100000)		{$hh='usergroups';	echo "Gruppi Utenti";}
if ($ADD==1000000)		{$hh='scripts';		echo "Script";}
if ($ADD==10000000)		{$hh='filters';		echo "Filtri";}
if ($ADD==100000000)	{$hh='admin';	$sh='times';	echo "Orari Chiamata";}
if ($ADD==130000000)	{$hh='admin';	$sh='times';	echo "Shifts";}
if ($ADD==1000000000)	{$hh='admin';	$sh='times';	echo "Tiempos De la Llamada Del Estado";}
if ($ADD==10000000000)	{$hh='admin';	$sh='phones';	echo "ELENCO TELEFONI";}
if ($ADD==12000000000)	{$hh='admin';	$sh='phones';	echo "PHONE ALIAS LIST";}
if ($ADD==100000000000)	{$hh='admin';	$sh='server';	echo "ELENCO SEEVER";}
if ($ADD==1000000000000)	{$hh='admin';	$sh='conference';	echo "LISTA DE  CONFERENCIAS";}
if ($ADD==10000000000000)	{$hh='admin';	$sh='conference';	echo "VICIDIAL LISTA DE  CONFERENCIAS";}
if ($ADD==550)			{$hh='users';		echo "Form di Ricerca";}
if ($ADD==551)			{$hh='users';		echo "BUSCAR telefonOS";}
if ($ADD==660)			{$hh='users';		echo "Risultati Ricerca";}
if ($ADD==661)			{$hh='users';		echo "RESULTADO DE LA BÚSQUEDA DE telefonOS";}
if ($ADD==99999)		{$hh='users';		echo "AIUTO";}
if ($ADD==999999)		{$hh='reports';		echo "REPORT";}

if ( ($ADD>9) && ($ADD < 99998) )
	{
	##### get scripts listing for dynamic pulldown
	$stmt="SELECT script_id,script_name from vicidial_scripts order by script_id";
	$rslt=mysql_query($stmt, $link);
	$scripts_to_print = mysql_num_rows($rslt);
	$scripts_list="<option value=\"\">NESSUNO</option>\n";

	$o=0;
	while ($scripts_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$scripts_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$scriptname_list["$rowx[0]"] = "$rowx[1]";
		$o++;
		}

	##### get filters listing for dynamic pulldown
	$stmt="SELECT lead_filter_id,lead_filter_name,lead_filter_sql from vicidial_lead_filters order by lead_filter_id";
	$rslt=mysql_query($stmt, $link);
	$filters_to_print = mysql_num_rows($rslt);
	$filters_list="<option value=\"\">NESSUNO</option>\n";

	$o=0;
	while ($filters_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$filters_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$filtername_list["$rowx[0]"] = "$rowx[1]";
		$filtersql_list["$rowx[0]"] = "$rowx[2]";
		$o++;
		}

	##### get call_times listing for dynamic pulldown
	$stmt="SELECT call_time_id,call_time_name from vicidial_call_times order by call_time_id";
	$rslt=mysql_query($stmt, $link);
	$times_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($times_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$call_times_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$call_timename_list["$rowx[0]"] = "$rowx[1]";
		$o++;
		}
	}

if ( ( (strlen($ADD)>4) && ($ADD < 99998) ) or ($ADD==3) or (($ADD>20) and ($ADD<70)) or ($ADD=="4A")  or ($ADD=="4B") or (strlen($ADD)==12) )
	{
	##### get server listing for dynamic pulldown
	$stmt="SELECT server_ip,server_description from servers order by server_ip";
	$rslt=mysql_query($stmt, $link);
	$servers_to_print = mysql_num_rows($rslt);
	$servers_list='';

	$o=0;
	while ($servers_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$servers_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
		}

	##### BEGIN get campaigns listing for rankings #####

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);
	$campaigns_list='';
	$campaigns_value='';
	$RANKcampaigns_list="<tr><td>CAMPAGNA</td><td> &nbsp; &nbsp; CLASSIFICA</td><td> &nbsp; &nbsp; CALLS</td></tr>\n";

	$o=0;
	while ($campaigns_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$campaign_id_values[$o] = $rowx[0];
		$campaign_name_values[$o] = $rowx[1];
		$o++;
		}

	$o=0;
	while ($campaigns_to_print > $o)
		{
		$stmt="SELECT campaign_rank,calls_today from vicidial_campaign_agents where user='$user' and campaign_id='$campaign_id_values[$o]'";
		$rslt=mysql_query($stmt, $link);
		$ranks_to_print = mysql_num_rows($rslt);
		if ($ranks_to_print > 0)
			{
			$row=mysql_fetch_row($rslt);
			$SELECT_campaign_rank = $row[0];
			$calls_today = $row[1];
			}
		else
			{$calls_today=0;   $SELECT_campaign_rank=0;}
		if ( ($ADD=="4A") or ($ADD=="4B") )
			{
			if (isset($_GET["RANK_$campaign_id_values[$o]"]))			{$campaign_rank=$_GET["RANK_$campaign_id_values[$o]"];}
				elseif (isset($_POST["RANK_$campaign_id_values[$o]"]))	{$campaign_rank=$_POST["RANK_$campaign_id_values[$o]"];}

			if ($ranks_to_print > 0)
				{
				$stmt="UPDATE vicidial_campaign_agents set campaign_rank='$campaign_rank', campaign_weight='$campaign_rank' where campaign_id='$campaign_id_values[$o]' and user='$user';";
				$rslt=mysql_query($stmt, $link);
				}
			else
				{
				$stmt="INSERT INTO vicidial_campaign_agents set campaign_rank='$campaign_rank', campaign_weight='$campaign_rank', campaign_id='$campaign_id_values[$o]', user='$user';";
				$rslt=mysql_query($stmt, $link);
				}

			$stmt="UPDATE vicidial_live_agents set campaign_weight='$campaign_rank' where campaign_id='$campaign_id_values[$o]' and user='$user';";
			$rslt=mysql_query($stmt, $link);
			}
		else {$campaign_rank = $SELECT_campaign_rank;}

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		# disable non user-group allowable campaign ranks
		$stmt="SELECT user_group from vicidial_users where user='$user';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		$Ruser_group =	$row[0];

		$stmt="SELECT allowed_campaigns from vicidial_user_groups where user_group='$Ruser_group';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		$allowed_campaigns =	$row[0];
		$allowed_campaigns = preg_replace("/ -$/","",$allowed_campaigns);
		$UGcampaigns = explode(" ", $allowed_campaigns);

		$p=0;   $RANK_camp_active=0;   $CR_disabled = '';
		if (eregi('-ALL-CAMPAIGNS-',$allowed_campaigns))
			{$RANK_camp_active++;}
		else
			{
			$UGcampaign_ct = count($UGcampaigns);
			while ($p < $UGcampaign_ct)
				{
				if ($campaign_id_values[$o] == $UGcampaigns[$p]) 
					{$RANK_camp_active++;}
				$p++;
				}
			}
		if ($RANK_camp_active < 1) {$CR_disabled = 'DISABLED';}

		$RANKcampaigns_list .= "<tr $bgcolor><td>";
		$campaigns_list .= "<a href=\"$PHP_SELF?ADD=31&campaign_id=$campaign_id_values[$o]\">$campaign_id_values[$o]</a> - $campaign_name_values[$o] <BR>\n";
		$RANKcampaigns_list .= "<a href=\"$PHP_SELF?ADD=31&campaign_id=$campaign_id_values[$o]\">$campaign_id_values[$o]</a> - $campaign_name_values[$o] </td>";
		$RANKcampaigns_list .= "<td> &nbsp; &nbsp; <select size=1 name=RANK_$campaign_id_values[$o] $CR_disabled>\n";
		$h="9";
		while ($h>=-9)
			{
			$RANKcampaigns_list .= "<option value=\"$h\"";
			if ($h==$campaign_rank)
				{$RANKcampaigns_list .= " SELECTED";}
			$RANKcampaigns_list .= ">$h</option>";
			$h--;
			}
		$RANKcampaigns_list .= "</select></td>\n";
		$RANKcampaigns_list .= "<td align=right> &nbsp; &nbsp; $calls_today</td></tr>\n";
		$o++;
		}
	##### END get campaigns listing for rankings #####


	##### BEGIN get inbound groups listing for checkboxes #####
	$xfer_groupsSQL='';
	if ( (($ADD>20) and ($ADD<70)) and ($ADD!=41) )
	{
	$stmt="SELECT closer_campaigns,xfer_groups from vicidial_campaigns where campaign_id='$campaign_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$closer_campaigns =	$row[0];
		$closer_campaigns = preg_replace("/ -$/","",$closer_campaigns);
		$groups = explode(" ", $closer_campaigns);
	$xfer_groups =	$row[1];
		$xfer_groups = preg_replace("/ -$/","",$xfer_groups);
		$XFERgroups = explode(" ", $xfer_groups);
	$xfer_groupsSQL = preg_replace("/^ | -$/","",$xfer_groups);
	$xfer_groupsSQL = preg_replace("/ /","','",$xfer_groupsSQL);
	$xfer_groupsSQL = "WHERE group_id IN('$xfer_groupsSQL')";
	}
	if ($ADD==41)
	{
	$p=0;
	$XFERgroup_ct = count($XFERgroups);
	while ($p < $XFERgroup_ct)
		{
		$xfer_groups .= " $XFERgroups[$p]";
		$p++;
		}
	$xfer_groupsSQL = preg_replace("/^ | -$/","",$xfer_groups);
	$xfer_groupsSQL = preg_replace("/ /","','",$xfer_groupsSQL);
	$xfer_groupsSQL = "WHERE group_id IN('$xfer_groupsSQL')";
	}

	if ( (($ADD==31111) or ($ADD==31111)) and (count($groups)<1) )
	{
	$stmt="SELECT closer_campaigns from vicidial_remote_agents where remote_agent_id='$remote_agent_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$closer_campaigns =	$row[0];
	$closer_campaigns = preg_replace("/ -$/","",$closer_campaigns);
	$groups = explode(" ", $closer_campaigns);
	}

	if ($ADD==3)
	{
	$stmt="SELECT closer_campaigns from vicidial_users where user='$user';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$closer_campaigns =	$row[0];
	$closer_campaigns = preg_replace("/ -$/","",$closer_campaigns);
	$groups = explode(" ", $closer_campaigns);
	}

	$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT') order by group_id";
	$rslt=mysql_query($stmt, $link);
	$groups_to_print = mysql_num_rows($rslt);
	$groups_list='';
	$groups_value='';
	$XFERgroups_list='';
	$RANKgroups_list="<tr><td>INBOUND GROUP</td><td> &nbsp; &nbsp; CLASSIFICA</td><td> &nbsp; &nbsp; CALLS</td></tr>\n";

	$o=0;
	while ($groups_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$group_id_values[$o] = $rowx[0];
		$group_name_values[$o] = $rowx[1];
		$o++;
		}

	$o=0;
	while ($groups_to_print > $o)
		{
		$stmt="SELECT group_rank,calls_today from vicidial_inbound_group_agents where user='$user' and group_id='$group_id_values[$o]'";
		$rslt=mysql_query($stmt, $link);
		$ranks_to_print = mysql_num_rows($rslt);
		if ($ranks_to_print > 0)
			{
			$row=mysql_fetch_row($rslt);
			$SELECT_group_rank = $row[0];
			$calls_today = $row[1];
			}
		else
			{$calls_today=0;   $SELECT_group_rank=0;}
		if ( ($ADD=="4A") or ($ADD=="4B") )
			{
			if (isset($_GET["RANK_$group_id_values[$o]"]))			{$group_rank=$_GET["RANK_$group_id_values[$o]"];}
				elseif (isset($_POST["RANK_$group_id_values[$o]"]))	{$group_rank=$_POST["RANK_$group_id_values[$o]"];}

			if ($ranks_to_print > 0)
				{
				$stmt="UPDATE vicidial_inbound_group_agents set group_rank='$group_rank', group_weight='$group_rank' where group_id='$group_id_values[$o]' and user='$user';";
				$rslt=mysql_query($stmt, $link);
				}
			else
				{
				$stmt="INSERT INTO vicidial_inbound_group_agents set group_rank='$group_rank', group_weight='$group_rank', group_id='$group_id_values[$o]', user='$user';";
				$rslt=mysql_query($stmt, $link);
				}

			$stmt="UPDATE vicidial_live_inbound_agents set group_weight='$group_rank' where group_id='$group_id_values[$o]' and user='$user';";
			$rslt=mysql_query($stmt, $link);
			}
		else {$group_rank = $SELECT_group_rank;}

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		$groups_list .= "<input type=\"checkbox\" name=\"groups[]\" value=\"$group_id_values[$o]\"";
		$XFERgroups_list .= "<input type=\"checkbox\" name=\"XFERgroups[]\" value=\"$group_id_values[$o]\"";
		$RANKgroups_list .= "<tr $bgcolor><td><input type=\"checkbox\" name=\"groups[]\" value=\"$group_id_values[$o]\"";
		$p=0;
		$group_ct = count($groups);
		while ($p < $group_ct)
			{
			if ($group_id_values[$o] == $groups[$p]) 
				{
				$groups_list .= " CHECKED";
				$RANKgroups_list .= " CHECKED";
				$groups_value .= " $group_id_values[$o]";
				}
			$p++;
			}
		$p=0;
		$XFERgroup_ct = count($XFERgroups);
		while ($p < $XFERgroup_ct)
			{
			if ($group_id_values[$o] == $XFERgroups[$p]) 
				{
				$XFERgroups_list .= " CHECKED";
				$XFERgroups_value .= " $group_id_values[$o]";
				}
			$p++;
			}
		$stmt="SELECT queue_priority from vicidial_inbound_groups where group_id='$group_id_values[$o]';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		$VIG_priority =			$row[0];

		$groups_list .= "> <a href=\"$PHP_SELF?ADD=3111&group_id=$group_id_values[$o]\">$group_id_values[$o]</a> - $group_name_values[$o] - $VIG_priority <BR>\n";
		$XFERgroups_list .= "> <a href=\"$PHP_SELF?ADD=3111&group_id=$group_id_values[$o]\">$group_id_values[$o]</a> - $group_name_values[$o] <BR>\n";
		$RANKgroups_list .= "> <a href=\"$PHP_SELF?ADD=3111&group_id=$group_id_values[$o]\">$group_id_values[$o]</a> - $group_name_values[$o] </td>";
		$RANKgroups_list .= "<td> &nbsp; &nbsp; <select size=1 name=RANK_$group_id_values[$o]>\n";
		$h="9";
		while ($h>=-9)
			{
			$RANKgroups_list .= "<option value=\"$h\"";
			if ($h==$group_rank)
				{$RANKgroups_list .= " SELECTED";}
			$RANKgroups_list .= ">$h</option>";
			$h--;
			}
		$RANKgroups_list .= "</select></td>\n";
		$RANKgroups_list .= "<td align=right> &nbsp; &nbsp; $calls_today</td></tr>\n";
		$o++;
		}
	if (strlen($groups_value)>2) {$groups_value .= " -";}
	if (strlen($XFERgroups_value)>2) {$XFERgroups_value .= " -";}
	}
	##### END get inbound groups listing for checkboxes #####


	##### BEGIN get campaigns listing for checkboxes #####
	if ( ($ADD==211111) or ($ADD==311111) or ($ADD==411111) or ($ADD==511111) or ($ADD==611111) )
	{
		if ( ($ADD==211111) or ($ADD==311111) or ($ADD==511111) or ($ADD==611111) )
		{
		$stmt="SELECT allowed_campaigns,qc_allowed_campaigns,qc_allowed_inbound_groups from vicidial_user_groups where user_group='$user_group';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		$allowed_campaigns =			$row[0];
		$qc_allowed_campaigns =			$row[1];
		$qc_allowed_inbound_groups =	$row[2];
		$allowed_campaigns = preg_replace("/ -$/","",$allowed_campaigns);
		$campaigns = explode(" ", $allowed_campaigns);
		$qc_allowed_campaigns = preg_replace("/ -$/","",$qc_allowed_campaigns);
		$qc_campaigns = explode(" ", $qc_allowed_campaigns);
		$qc_allowed_inbound_groups = preg_replace("/ -$/","",$qc_allowed_inbound_groups);
		$qc_groups = explode(" ", $qc_allowed_inbound_groups);
		}

	$campaigns_value='';
	$campaigns_list='<B><input type="checkbox" name="campaigns[]" value="-ALL-CAMPAIGNS-"';
	$qc_campaigns_value='';
	$qc_campaigns_list='<B><input type="checkbox" name="qc_campaigns[]" value="-ALL-CAMPAIGNS-"';
	$qc_groups_value='';
	$qc_groups_list='<B><input type="checkbox" name="qc_groups[]" value="-ALL-GROUPS-"';
		$p=0;
		while ($p<100)
			{
			if (eregi('ALL-CAMPAIGNS',$campaigns[$p])) 
				{
				$campaigns_list.=" CHECKED";
				$campaigns_value .= " -ALL-CAMPAIGNS- -";
				}
			if (eregi('ALL-CAMPAIGNS',$qc_campaigns[$p])) 
				{
				$qc_campaigns_list.=" CHECKED";
				$qc_campaigns_value .= " -ALL-CAMPAIGNS- -";
				}
			if (eregi('ALL-GROUPS',$qc_groups[$p])) 
				{
				$qc_groups_list.=" CHECKED";
				$qc_groups_value .= " -ALL-GROUPS- -";
				}
			$p++;
			}
	$campaigns_list.="> ALL-CAMPAIGNS - GLI UTENTI POSSONO VISUALIZZARE QUALSIASI CAMPAGNA</B><BR>\n";
	$qc_campaigns_list.="> ALL-CAMPAIGNS - USERS CAN QC ANY CAMPAIGN</B><BR>\n";
	$qc_groups_list.="> ALL-GROUPS - USERS CAN QC ANY INBOUND GROUP</B><BR>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($campaigns_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$campaign_id_value = $rowx[0];
		$campaign_name_value = $rowx[1];
		$campaigns_list .= "<input type=\"checkbox\" name=\"campaigns[]\" value=\"$campaign_id_value\"";
		$qc_campaigns_list .= "<input type=\"checkbox\" name=\"qc_campaigns[]\" value=\"$campaign_id_value\"";
		$p=0;
		while ($p<100)
			{
			if ($campaign_id_value == $campaigns[$p]) 
				{
			#	echo "<!--  X $p|$campaign_id_value|$campaigns[$p]| -->";
				$campaigns_list .= " CHECKED";
				$campaigns_value .= " $campaign_id_value";
				}
			if ($campaign_id_value == $qc_campaigns[$p]) 
				{
				$qc_campaigns_list .= " CHECKED";
				$qc_campaigns_value .= " $campaign_id_value";
				}
		#	echo "<!--  O $p|$campaign_id_value|$campaigns[$p]| -->";
			$p++;
			}
		$campaigns_list .= "> $campaign_id_value - $campaign_name_value<BR>\n";
		$qc_campaigns_list .= "> $campaign_id_value - $campaign_name_value<BR>\n";
		$o++;
		}

	$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT') order by group_id";
	$rslt=mysql_query($stmt, $link);
	$groups_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($groups_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$group_id_value = $rowx[0];
		$group_name_value = $rowx[1];
		$qc_groups_list .= "<input type=\"checkbox\" name=\"qc_groups[]\" value=\"$group_id_value\"";
		$p=0;
		while ($p<100)
			{
			if ($group_id_value == $qc_groups[$p]) 
				{
				$qc_groups_list .= " CHECKED";
				$qc_groups_value .= " $group_id_value";
				}
			$p++;
			}
		$qc_groups_list .= "> $group_id_value - $group_name_value<BR>\n";
		$o++;
		}

	if (strlen($campaigns_value)>2) {$campaigns_value .= " -";}
	if (strlen($qc_campaigns_value)>2) {$qc_campaigns_value .= " -";}
	if (strlen($qc_groups_value)>2) {$qc_groups_value .= " -";}
	}
	##### END get campaigns listing for checkboxes #####


	if ( (strlen($ADD)==11) or (strlen($ADD)>12) or ( ($ADD > 1299) and ($ADD < 9999) ) )
	{
	##### get server listing for dynamic pulldown
	$stmt="SELECT server_ip,server_description from servers order by server_ip";
	$rsltx=mysql_query($stmt, $link);
	$servers_to_print = mysql_num_rows($rsltx);
	$servers_list='';

	$o=0;
	while ($servers_to_print > $o)
		{
		$rowx=mysql_fetch_row($rsltx);
		$servers_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
		}
	}



$NWB = " &nbsp; <a href=\"javascript:openNewWindow('$PHP_SELF?ADD=99999";
$NWE = "')\"><IMG SRC=\"help.gif\" WIDTH=20 HEIGHT=20 Border=0 ALT=\"AIUTO\" ALIGN=TOP></A>";


######################################################################################################
######################################################################################################
#######   9 series, HELP screen
######################################################################################################
######################################################################################################


######################
# ADD=99999 display the HELP SCREENS
######################

if ($ADD==99999)
{
echo "</title>\n";
echo "</head>\n";
echo "<BODY BGCOLOR=white marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";
echo "<CENTER>\n";
echo "<TABLE WIDTH=98% BGCOLOR=#E6E6E6 cellpadding=2 cellspacing=0><TR><TD ALIGN=LEFT><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=4><B>VICIDIAL ADMIN: AIUTO<BR></B></FONT><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2><BR><BR>\n";

?>
<B><FONT SIZE=3>VICIDIAL_USERS TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_users-user">
<BR>
<B>Identificacio`n del usuario -</B> este campo es donde usted pone el número de la identificacio`n del usuario de VICIDIAL, puede ser hasta 8 dígitos en longitud, debe ser por lo menos 2 caracteres en longitud.

<BR>
<A NAME="vicidial_users-pass">
<BR>
<B>Contraseña -</B> este campo es donde usted pone la contraseña de los usuarios de VICIDIAL. Deben ser por lo menos 2 caracteres en longitud.

<BR>
<A NAME="vicidial_users-full_name">
<BR>
<B>Nombre completo -</B> este campo es donde usted pone el nombre completo de los usuarios de VICIDIAL. Deben ser por lo menos 2 caracteres en longitud.

<BR>
<A NAME="vicidial_users-user_level">
<BR>
<B>Nivel de usuario -</B> este menú es donde usted selecciona el nivel de usuario de los usuarios de VICIDIAL. Debe ser un nivel de 1 a registrar en VICIDIAL, debe ser llano mayor de 2 a abrirse una sesio`n como más cercano, deben ser el nivel de usuario 8 o mayor conseguir en la seccio`n de la tela del admin.

<BR>
<A NAME="vicidial_users-user_group">
<BR>
<B>Grupo de usuario -</B> este menú es donde usted selecciona a grupo de usuarios de VICIDIAL que este usuario pertenecerá a. Esto no tiene ninguna restricciones en este tiempo, este es justo subdividir a usuarios y permitir las características futuras basadas sobre e`l.

<BR>
<A NAME="vicidial_users-phone_login">
<BR>
<B>conexion del telefono -</B> aquí es para donde usted puede fijar un valor de la conexion del telefono del defecto cuando los registros del usuario en vicidial.php. Este valor poblará el phone_login automáticamente cuando el usuario entra con su usuario-pasar-campaña en la pantalla de la conexion de vicidial.php.

<BR>
<A NAME="vicidial_users-phone_pass">
<BR>
<B>Paso del telefono -</B> aquí es para donde usted puede fijar un valor del paso del telefono del defecto cuando los registros del usuario en vicidial.php. Este valor poblará los phone_pass automáticamente cuando el usuario entra con su usuario-pasar-campaña en la pantalla de la conexion de vicidial.php.

<BR>
<A NAME="vicidial_users-hotkeys_active">
<BR>
<B>Hot Keys activo -</B> esta opcio`n si el sistema a 1 permite que el usuario utilice la funcio`n ra`pida-dispositioning de Hot Keys adentro vicidial.php.

<BR>
<A NAME="vicidial_users-agent_choose_ingroups">
<BR>
<B>El agente elige Ingroups -</B> esta opcio`n si el sistema a 1 permite que el usuario elija los ingroups de los cuales recibirán llamadas cuando ellos conexion a una campaña MÁS CERCANA o DE ENTRADA. Si no el encargado necesitará fijar esto en su pantalla del detalle del usuario de la página del admin.

<BR>
<A NAME="vicidial_users-scheduled_callbacks">
<BR>
<B>Servicios repetidos programar -</B> esta opcio`n no prohibe a agente a la disposicion una llamada como CALLBK y elige los datos y el tiempo en los cuales el plomo será reactivado.

<BR>
<A NAME="vicidial_users-agentonly_callbacks">
<BR>
<B>Servicios repetidos del Agente-Solamente -</B> esta opcio`n permite que un agente fije un servicio repetido de modo que sean el único agente que puede llamar la parte posteriora del cliente. Esto Tambien permite que el agente vea sus listados del servicio repetido y los llame detrás cualquier momento desean a.

<BR>
<A NAME="vicidial_users-agentcall_manual">
<BR>
<B>Manual de la llamada del agente -</B> esta opcio`n permite que un agente incorpore manualmente un nuevo plomo en el sistema y los llame. Esto Tambien permite llamar de cualquier número de telefono de su pantalla vicidial y pone esa llamada en su sesio`n. Utilice esta opcio`n con la precaucio`n.

<BR>
<A NAME="vicidial_users-vicidial_recording">
<BR>
<B>grabacion de Vicidial -</B> esta opcio`n puede evitar que un agente haga cualquier grabacion despue`s de que se abran una sesio`n a vicidial. Esta opcio`n debe estar encendido para que vicidial siga la sesio`n de la grabacion de la campaña.

<BR>
<A NAME="vicidial_users-vicidial_transfers">
<BR>
<B>Vicidial transfiere -</B> esta opcio`n puede evitar que un agente abra la transferencia - la sesio`n de la conferencia de vicidial. Si esto es lisiado, el agente no puede llamada de los terceros o la transferencia oculta cualquiera llama.

<BR>
<A NAME="vicidial_users-closer_default_blended">
<BR>
<B>Un defecto más cercano mezclado -</B> esta opcio`n omite simplemente el checkbox mezclado en una pantalla MÁS CERCANA de la conexion.

<BR>
<A NAME="vicidial_users-vicidial_recording_override">
<BR>
<B>Invalidacio`n de la grabacion de VICIDIAL -</B> esta opcio`n seeliminará lo que es la opcio`n en la campaña para la grabacion.LISIADO no eliminará el ajuste de la grabacion de la campaña. NUNCAinhabilitará la grabacion en el cliente. ONDEMAND es el defecto ypermite que el agente comience y pare a registrar según lonecesitado. ALLCALLS comenzará la grabacion en el cliente siempreque una llamada se envíe a un agente. ALLFORCE comenzará lagrabacion en el cliente siempre que una llamada se envíe a un agenteque no da al agente ninguna opcio`n para parar el registrar. ParaALLCALLS y ALLFORCE hay una opcio`n para utilizar la grabacionretrasa para reducir en grabaciones y carga de sistema muy cortas delrecude.

<BR>
<A NAME="vicidial_users-vicidial_users-campaign_ranks">
<BR>
<B>La campaña alinea -</B> en esta seccio`n usted puede definir a la filaque un agente tendrá para cada campaña. Estas filas pueden serutilizadas para tener en cuenta la encaminamiento preferida de lallamada cuando la llamada siguiente del agente se fija alcampaign_rank.

<BR>
<A NAME="vicidial_users-closer_campaigns">
<BR>
<B>Grupos de entrada -</B> aquí es donde usted selecciona a grupos de entrada que usted desea recibir llamadas de si usted ha seleccionado la campaña MÁS CERCANA. Usted Tambien podrá fijar la fila, o el nivel de habilidad, en estaseccio`n para cada uno de los grupos de entrada así como poder ver elnúmero de las llamadas recibidas de cada grupo de entrada para esteagente específico. Tambien en esta seccio`n está la capacidad de dar al agente una filapara cada grupo de entrada. Estas filas pueden ser utilizadas para laencaminamiento preferida de la llamada cuando esa opcio`n seselecciona en la pantalla del en-grupo.

<BR>
<A NAME="vicidial_users-alter_custdata_override">
<BR>
<B>El agente altera la invalidacio`n de los datos del cliente -</B> estaopcio`n se eliminará lo que es la opcio`n en la campaña paraalterarse de los datos del cliente. NOT_ACTIVE utilizará lo que estápresente el ajuste para la campaña. ALLOW_ALTER permitirá siemprepara que el agente altere los datos del cliente, no importa que` es elajuste de la campaña. El defecto es NOT_ACTIVE.

<BR>
<A NAME="vicidial_users-alter_custphone_override">
<BR>
<B>Agent Alter Customer Phone Override -</B> This option will override whatever the option is in the campaign for altering of customer phone number. NOT_ACTIVE will use whatever setting is present for the campaign. ALLOW_ALTER will always allow for the agent to alter the customer phone number, no matter what the campaign setting is. Default is NOT_ACTIVE.

<BR>
<A NAME="vicidial_users-alter_agent_interface_options">
<BR>
<B>Altere las opciones de interfaz del agente -</B> esta opcio`n si el sistema a 1 permite que el usuario administrativo modifique las opciones de interfaz de los agentes en admin.php.

<BR>
<A NAME="vicidial_users-delete_users">
<BR>
<B>Usuarios de la cancelacio`n -</B> esta opcio`n si el sistema a 1 permite que el usuario suprima a otros usuarios del igual o de poco nivel de usuario del sistema.

<BR>
<A NAME="vicidial_users-delete_user_groups">
<BR>
<B>Suprima a grupos de usuario -</B> esta opcio`n si el sistema a 1 permite que el usuario suprima a grupos de usuario del sistema.

<BR>
<A NAME="vicidial_users-delete_lists">
<BR>
<B>La cancelacio`n enumera -</B> esta opcio`n si el sistema a 1 permite que el usuario suprima listas vicidial del sistema.

<BR>
<A NAME="vicidial_users-delete_campaigns">
<BR>
<B>La cancelacio`n hace campaña -</B> esta opcio`n si el sistema a 1 permite que el usuario suprima campañas vicidial del sistema.

<BR>
<A NAME="vicidial_users-delete_ingroups">
<BR>
<B>En-Grupos de la cancelacio`n -</B> esta opcio`n si el sistema a 1 permite que el usuario suprima a En-Grupos vicidial del sistema.

<BR>
<A NAME="vicidial_users-delete_remote_agents">
<BR>
<B>Suprima los agentes alejados -</B> esta opcio`n si el sistema a 1 permite que el usuario suprima agentes alejados vicidial del sistema.

<BR>
<A NAME="vicidial_users-load_leads">
<BR>
<B>La carga conduce -</B> esta opcio`n si el sistema a 1 permite que el usuario cargue los plomos vicidial en la tabla del vicidial_list por el cargador basado tela del plomo.

<BR>
<A NAME="vicidial_users-campaign_detail">
<BR>
<B>Detalle de la campaña -</B> esta opcio`n si el sistema a 1 permite que el usuario visio`n y modifique los elementos de la pantalla del detalle de la campaña.

<BR>
<A NAME="vicidial_users-ast_admin_access">
<BR>
<B>Acceso de AGC Admin -</B> esta opcio`n si el sistema a 1 permite a usuario a la conexion a las páginas astGUIclient del admin.

<BR>
<A NAME="vicidial_users-ast_delete_phones">
<BR>
<B>La cancelacio`n de AGC telefona -</B> esta opcio`n si el sistema a 1 permite que el usuario suprima entradas del telefono en las páginas astGUIclient del admin.

<BR>
<A NAME="vicidial_users-delete_scripts">
<BR>
<B>Escrituras de la cancelacio`n -</B> esta opcio`n si el sistema a 1 permite que el usuario suprima las escrituras de la campaña en la pantalla de la modificacio`n de la escritura.

<BR>
<A NAME="vicidial_users-modify_leads">
<BR>
<B>Modifique los plomos -</B> esta opcio`n si el sistema a 1 permite que el usuario modifique los plomos en la página de los resultados de la búsqueda del plomo de la seccio`n del admin.

<BR>
<A NAME="vicidial_users-change_agent_campaign">
<BR>
<B>Cambie la campaña del agente -</B> esta opcio`n si el sistema a 1 permite que el usuario altere la campaña que un agente está registrado en mientras que se registran en e`l.

<BR>
<A NAME="vicidial_users-delete_filters">
<BR>
<B>La cancelacio`n se filtra -</B> esta opcio`n permite que el usuario pueda suprimir los filtros vicidial del plomo del sistema.

<BR>
<A NAME="vicidial_users-delete_call_times">
<BR>
<B>Tiempos de la llamada de la cancelacio`n -</B> esta opcio`n permite que elusuario pueda suprimir expedientes vicidial de los tiempos de lallamada y expedientes vicidial de los tiempos de la llamada del estadodel sistema.

<BR>
<A NAME="vicidial_users-modify_call_times">
<BR>
<B>Modifique El Tiempo De la Llamadas -</B> This option allows the user to view and modify the call times and state call times records. A user doesn't need this option enabled if they only need to change the call times option on the campaigns screen.

<BR>
<A NAME="vicidial_users-modify_sections">
<BR>
<B>Modifique las secciones -</B> estas opciones permiten que el usuariovisio`n y modifique cada uno los expedientes de las secciones. Si elsistema a 0, el usuario puede considerar la lista de la seccio`n, perono el detalle o la pantalla de la modificacio`n de un expediente enesa seccio`n.

<BR>
<A NAME="vicidial_users-view_reports">
<BR>
<B>La visio`n divulga -</B> esta opcio`n permite que el usuario visio`n losinformes de VICIDIAL.

<BR>
<A NAME="vicidial_users-qc_enabled">
<BR>
<B>QC Enabled -</B> This option allows the user to log in to the Quality Control agent screen.

<BR>
<A NAME="vicidial_users-qc_user_level">
<BR>
<B>QC Livello Utente -</B> This setting defines what the agent Quality Control user level is. This will dictate the level of functionality for the agent in the QC section:<BR>
1 - Modify Nothing<BR>
2 - Modify Nothing Except Status<BR>
3 - Modify All Fields<BR>
4 - Verify First Round of QC<BR>
5 - View QC Statistics<BR>
6 - Ability to Modify FINISHed records<BR>
7 - Manager Level<BR>

<BR>
<A NAME="vicidial_users-qc_pass">
<BR>
<B>QC Record Pass -</B> This option allows the agent to specify that a record has passed the first round of QC after reviewing the record.

<BR>
<A NAME="vicidial_users-qc_finish">
<BR>
<B>QC Record Finish -</B> This option allows the agent to specify that a record has finished the second round of QC after reviewing the passed record.

<BR>
<A NAME="vicidial_users-qc_commit">
<BR>
<B>QC Record Commit -</B> This option allows the agent to specify that a record has been committed in QC. It can no longer be modified by anyone.

<BR>
<A NAME="vicidial_users-add_timeclock_log">
<BR>
<B>Add Timeclock Log Record -</B> This option allows the user to add records to the timeclock log.

<BR>
<A NAME="vicidial_users-modify_timeclock_log">
<BR>
<B>Modify Timeclock Log Record -</B> This option allows the user to modify records in the timeclock log.

<BR>
<A NAME="vicidial_users-delete_timeclock_log">
<BR>
<B>Delete Timeclock Log Record -</B> This option allows the user to delete records in the timeclock log.

<BR>
<A NAME="vicidial_users-vdc_agent_api_access">
<BR>
<B>Agent API Access -</B> This option allows the account to be used with the vicidial agent API commands.





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_CAMPAIGNS TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_campaigns-campaign_id">
<BR>
<B>Identificacio`n de la campaña -</B> Úste es el nombre corto de la campaña, e`l no es editable despue`s de la sumisio`n inicial, no puede contener espacios y debe estar entre 2 y 8 caracteres en longitudh.

<BR>
<A NAME="vicidial_campaigns-campaign_name">
<BR>
<B>Nombre de la campaña -</B> esta es la descripcio`n de la campaña, debe estar entre 6 y 40 caracteres en longitud.

<BR>
<A NAME="vicidial_campaigns-campaign_description">
<BR>
<B>Descripcio`n de la campaña -</B> esto es un campo de la nota para lacampaña, es opcional y puede ser un máximo de 255 caracteres enlongitud.

<BR>
<A NAME="vicidial_campaigns-campaign_changedate">
<BR>
<B>Fecha del cambio de la campaña -</B> esta es la vez última que losajustes para esta campaña fueron modificados de cualquier manera.

<BR>
<A NAME="vicidial_campaigns-campaign_logindate">
<BR>
<B>La fecha pasada de la conexion de la campaña -</B> esta es la vezúltima que un agente fue registrado en esta campaña.

<BR>
<A NAME="vicidial_campaigns-campaign_stats_refresh">
<BR>
<B>Los Stats de la campaña restauran -</B> este checkbox permitirá queusted fuerce un stats vicidial restaura, incluso si la campaña no esactiva.

<BR>
<A NAME="vicidial_campaigns-active">
<BR>
<B>Activo -</B> aquí es adonde usted fija la campaña a activo o a inactivo. Si es inactivo, noone puede registrar en e`l.

<BR>
<A NAME="vicidial_campaigns-park_ext">
<BR>
<B>Extension del parque -</B> aquí es donde usted puede modificar para requisitos particulares en-sostiene la música para VICIDIAL. Cercio`rese de que la extension este` en lugar en el extensions.conf y eso que señala al nombre de fichero abajo.

<BR>
<A NAME="vicidial_campaigns-park_file_name">
<BR>
<B>Nombre del archivo del parque -</B> aquí es donde usted puede modificar para requisitos particulares en-sostiene la música para VICIDIAL. Cercio`rese de que el nombre de fichero sea 10 caracteres en longitud o menos y que el archivo está en lugar en el directorio de /var/lib/asterisk/sounds.

<BR>
<A NAME="vicidial_campaigns-web_form_address">
<BR>
<B>Forma del Web -</B> aquí es donde usted puede fijar el Web page de encargo que será abierto cuando el usuario chasca encendido el boton de la FORMA del WEB.

<BR>
<A NAME="vicidial_campaigns-allow_closers">
<BR>
<B>Permita Closers -</B> aquí es donde usted puede fijar si los usuarios de esta campaña tendrán la opcio`n para enviar la llamada a un más cercano.

<BR>
<A NAME="vicidial_campaigns-default_xfer_group">
<BR>
<B>Grupo de la transferencia del defecto -</B> este campo es el En-Grupo deldefecto que será seleccionado automáticamente cuando el agente va almarco de la transferir-conferencia en su interfaz del agente.

<BR>
<A NAME="vicidial_campaigns-xfer_groups">
<BR>
<B>Grupos permitidos de la transferencia -</B> con estos listados delcheckbox usted puede seleccionar a los grupos a quienes los agentes enesta campaña pueden transferir llamadas. Permita Closers debe serpermitido para que esta opcio`n demuestre para arriba.

<BR>
<A NAME="vicidial_campaigns-campaign_allow_inbound">
<BR>
<B>Permita de entrada y mezclado -</B> aquí es donde usted puede fijar silos usuarios de esta campaña tendrán la opcio`n para tomar llamadasde entrada con esta campaña. Si usted desea hacer de entrada y desalida mezclada entonces esto se debe fijar a Y. Si usted deseasolamente hacer marcar de salida en esta campaña fijo` esto a N.Default es N.

<BR>
<A NAME="vicidial_campaigns-dial_status">
<BR>
<B>Estado del dial -</B> aquí es adonde usted fija los estados que usted está deseando marcar encendido dentro de las listas que son activas para la campaña abajo. Para agregar otro estado al dial, seleccio`nelo de la lista drop-downy el tecleo AGREGA. Para quitar uno de los estados del dial, chasqueencendido el acoplamiento del QUITAR al lado del estado que usteddesea quitar.

<BR>
<A NAME="vicidial_campaigns-lead_order">
<BR>
<B>Orden de la lista -</B> Este menú es donde usted selecciona co`mo los plomos que emparejan los estados seleccionados arriba serán puestos en la tolva del plomo:
 <BR> &nbsp; - DOWN: seleziona i primi contatti caricati nella tabella vicidial_list
 <BR> &nbsp; - UP: seleziona gli ultimi contatti caricati nella tabella vicidial_list
 <BR> &nbsp; - UP PHONE: seleziona il numero di telefono piu` grande e poi scorre verso il basso
 <BR> &nbsp; - DOWN PHONE: seleziona il numero di telefono piu` piccolo e poi scorre verso l`alto
 <BR> &nbsp; - UP LAST NAME: comienzo con los nombres pasados comenzando con Z y trabajos su manera abajo
 <BR> &nbsp; - DOWN LAST NAME: comienzo con los nombres pasados comenzando con A y trabajos su manera para arriba
 <BR> &nbsp; - UP COUNT: comienzo con los plomos y los trabajos llamados su manera abajo
 <BR> &nbsp; - DOWN COUNT: comienzo con menos plomos y trabajos llamados su manera para arriba
 <BR> &nbsp; - DOWN COUNT 2nd NEW: comienzo con menos plomos y trabajos llamados su manera para arriba que inserta un NEW plomo en cada otro lead(Must para no tener NEW seleccionado en los estados del dial)
 <BR> &nbsp; - DOWN COUNT 3nd NEW: comienzo con menos plomos y trabajos llamados su manera para arriba que inserta un NEW plomo en cada tercer lead(Must para no tener NEW seleccionado en los estados del dial)
 <BR> &nbsp; - DOWN COUNT 4th NEW: comienzo con menos plomos y trabajos llamados que su manera para arriba que inserta un NEW plomo en cada adelante conduzca (no debe tener NEW seleccionado en los estados del dial)

<BR>
<A NAME="vicidial_campaigns-hopper_level">
<BR>
<B>Tolva llana -</B> este es cuántos conducen los intentos de la escritura de VDhopper para mantener la tabla del vicidial_hopper para esta campaña. Si funciona la escritura de VDhopper cada minuto, haga esto levemente mayor que el número de plomos que usted entra a trave`s en un minuto.

<BR>
<A NAME="vicidial_campaigns-lead_filter_id">
<BR>
<B>Filtro del plomo -</B> este es un me`todo de filtrar sus plomos usando un fragmento de una pregunta del SQL. Utilice esta característica con la precaucio`n, e`l es fácil de parar el marcar accidentalmente con la alteracio`n más leve a la declaracio`n del SQL. El defecto no es NINGUNO.

<BR>
<A NAME="vicidial_campaigns-force_reset_hopper">
<BR>
<B>Reajuste de la fuerza de la tolva -</B> esto permite que usted limpie fuera del contenido de la tolva sobre la sumisio`n de la forma. Debe ser llenada otra vez cuando la escritura de VDhopper funciona.

<BR>
<A NAME="vicidial_campaigns-dial_method">
<BR>
<B>Me`todo del dial -</B> Este campo es la manera de definir co`mo el marcar debe ocurrir. Si el MANUAL entonces el auto_dial_level es bloqueado en 0 a menos que se cambie el me`todo del dial. Si COCIENTE entonces el normal marcando un número de líneas para los agentes activos. ADAPT_HARD_LIMIT marcará predictively hasta el porcentaje caído y despue`s no permitirá marcar agresivo una vez que se alcance el límite de la gota hasta que va el porcentaje abajo otra vez. ADAPT_TAPERED permite para el excedente de funcionamiento el porcentaje caído por la mitad primer de la cambio - según lo definido por el call_time seleccionado para la campaña y consigue más terminante mientras que se enciende la cambio. ADAPT_AVERAGE intenta mantener un promedio o el porcentaje caído que no impone límites duros tan agresivamente como los otros dos me`todos. Usted no puede cambiar el nivel auto del dial si usted está en cualesquiera de los me`todos del dial del ADAPTAR. Solamente el sintonizador puede cambiar el nivel del dial cuando en modo que marca profe`tico. INBOUND_MAN allows the agent to place manual dial calls from a campaign list while being able to take inbound calls between manual dial calls.

<BR>
<A NAME="vicidial_campaigns-auto_dial_level">
<BR>
<B>Nivel auto del dial -</B> aquí es adonde usted fija cuántos alinea VICIDIAL debe utilizar por medios del agente activo cero 0 que el marcar del automo`vil está apagado y los agentes chascarán para marcar cada número. Si no VICIDIAL mantendrá líneas que marcan iguales a los agentes activos multiplicados por el nivel del dial para llegar cuántas líneas debe permitir esta campaña en cada servidor. El checkbox de la INVALIDACIo`N del ADAPTAR permite que usted fuerceun nuevo nivel del dial aunque el me`todo del dial está en un mododel ADAPTAR. Esto es útil si hay una cambio dramática en la calidadde plomos y usted desea cambiar drástico el dial_level manualmente.

<BR>
<A NAME="vicidial_campaigns-available_only_ratio_tally">
<BR>
<B>Solamente cuenta disponible -</B> este campo si el sistema a Y deja haciafuera los agentes del estado de INCALL y de la COLETA al calcular elnúmero de llamadas al dial cuando no en modo de dial MANUAL. Eldefecto es N.

<BR>
<A NAME="vicidial_campaigns-adaptive_dropped_percentage">
<BR>
<B>Límite del porcentaje de la gota -</B> este campo es donde usted fijo` ellímite del porcentaje de llamadas caídas que usted quisiera mientrasque usaba un me`todo adaptante-profe`tico del dial, NO MANUAL o delCOCIENTE.

<BR>
<A NAME="vicidial_campaigns-adaptive_maximum_level">
<BR>
<B>El máximo adapta el dial llano -</B> este campo es donde usted fijo` ellímite del límite al numbr de líneas que usted quisiera marcado poragente mientras que usaba un me`todo adaptante-profe`tico del dial, NOMANUAL o del COCIENTE. Este número puede ser más alto que el nivelauto del dial si su hardware lo apoya. El valor debe ser un númeropositivo mayor de uno y puede tener defecto 3.0 de los lugaresdecimales.

<BR>
<A NAME="vicidial_campaigns-adaptive_latest_server_time">
<BR>
<B>El tiempo más último del servidor -</B> este campo es utilizadosolamente por el me`todo del dial de ADAPT_TAPERED. Usted debe entraren la hora y el minuto que usted parará el invitar de esta campaña,2100 significaría que usted parará el marcar de esta campaña en eltiempo del servidor de los 9PM. Esto permite que el algoritmo afiladodecida a co`mo agresivamente al dial cerca cuánto tiempo usted tienehasta que usted será el llamar acabado.

<BR>
<A NAME="vicidial_campaigns-adaptive_intensity">
<BR>
<B>Adapte el modificante de la intensidad -</B> este campo se utiliza paraajustar la intensidad profe`tica más alta o más baja. El más altoun número positivo que usted selecciona, mayor va el sintonizadoraumentará la llamada que establece el paso cuando para arriba y máslentamente va el sintonizador disminuirá la llamada que establece elpaso cuando abajo. Cuanto más bajo es el número negativo que ustedseleccionan aquí, más lentamente el sintonizador aumentará lallamada que establece el paso y más rápidamente el sintonizadorbajará la llamada que establece el paso cuando va abajo. El defectoes 0. Este campo no es utilizado por los me`todos del dial del MANUALo del COCIENTE.

<BR>
<A NAME="vicidial_campaigns-adaptive_dl_diff_target">
<BR>
<B>Blanco llana de la diferencia del dial -</B> este campo se utiliza paradefinir si usted desea apuntar tener un número específico de losagentes que esperan agentes de las llamadas o el esperar de llamadas.Por ejemplo si usted siempre quisiera tener en agente del promedio unolibre tomar llamadas inmediatamente usted fijaría esto a -1, si ustedquisiera apuntar siempre tener uno invita el asimiento que espera unagente que usted fijaría esto a 1. El defecto es 0. Este campo no esutilizado por los me`todos del dial del MANUAL o del COCIENTE.

<BR>
<A NAME="vicidial_campaigns-concurrent_transfers">
<BR>
<B>Transferencias concurrentes -</B> este ajuste se utiliza para definir elnúmero de las llamadas que se pueden enviar a los agentes en el mismotiempo. Se recomienda que este ajuste está dejado en el AUTOMo`VIL. Este campo no es utilizado por el me`todo MANUAL del dial.

<BR>
<A NAME="vicidial_campaigns-queue_priority">
<BR>
<B>Queue Priority -</B> This setting is used to define the order in which the calls from this outbound campaign should be answered in relation to the inbound calls if this campaign is in blended mode.

<BR>
<A NAME="vicidial_campaigns-auto_alt_dial">
<BR>
<B>Alt-Nu`mero auto que marca -</B> este ajuste se utiliza para marcarautomáticamente campos alternos del número mientras que marca en elCOCIENTE y ADAPTA me`todos del dial cuando no hay contacto en elnúmero de telefono principal para un plomo, los estados del NA, deB, de la C.C. y de N. Este ajuste no es utilizado por el me`todoMANUAL del dial. EXTENDED alternate numbers are numbers loaded into the system outside of the standard lead information screen. Using EXTENDED you can have hundreds of phone numbers for a single customer record.

<BR>
<A NAME="vicidial_campaigns-next_agent_call">
<BR>
<B>Llamada siguiente del agente -</B> esto se determina que` agente recibe la llamada siguiente que está disponible:
 <BR> &nbsp; - random: o`rdenes por el valor al azar de la actualizacio`n en la tabla de los vicidial_live_agents
 <BR> &nbsp; - oldest_call_start: las o`rdenes por la vez última un agente fueron enviadas una llamada. Resultados en los agentes que reciben el número casi igual de llamadas cabalmente.
 <BR> &nbsp; - oldest_call_finish: las o`rdenes por la vez última un agente acabaron una llamada. El agente de AKA que espera lo más de largo posible recibe la primera llamada.
 <BR> &nbsp; - overall_user_level: las o`rdenes por el user_level del agente según lo definido en los vicidial_users tabulan un user_level más alto recibirán más llamadas.
 <BR> &nbsp; - campaign_rank: o`rdenes de la fila dada al agente para la campaña. Lomás arriba posible a lo más bajo posible.
 <BR> &nbsp; - fewest_calls: o`rdenes por el número de las llamadas recibidas por unagente para ese grupo de entrada específico. Menos llamadas primero.

<BR>
<A NAME="vicidial_campaigns-local_call_time">
<BR>
<B>Tiempo de la llamada local -</B> aquí es adonde usted fijo` durante que` horas usted quisiera marcar, según lo determinado por el tiempo local en está en cuál usted está llamando. Esto es controlada por co`digo de área y ajustada por tiempo de los ahorros de la luz del día si es aplicable. Las pautas generales en los E.E.U.U. para el negocio al negocio son los 9am a los 5pm y el negocio a las llamadas del consumidor es los 9am a los 9pm.

<BR>
<A NAME="vicidial_campaigns-dial_timeout">
<BR>
<B>Descanso del dial -</B> si está definido, llamadas que normalmente retraso despue`s de que el descanso definido en extensions.conf en lugar de otro descanso en esta cantidad de segundos si es menos que el descanso de extensions.conf. Esto permite descansos del dial rápidamente que cambian del servidor al servidor y a limitar los efectos a una sola campaña. Si usted está teniendo muchos de llamadas del contestador automático o de Casella Vocale usted puede desear intentar cambiar este valor entre a 21-26 y ver si los resultados mejoran.

<BR>
<A NAME="vicidial_campaigns-dial_prefix">
<BR>
<B>Prefijo del dial -</B> este campo permite más fácilmente cambiar una trayectoria de marcar a salir con un diverso me`todo sin hacer una recarga en asterisco. El defecto es 9 basados sobre un 91NXXNXXXXXX en el dial plan - extensions.conf.

<BR>
<A NAME="vicidial_campaigns-omit_phone_code">
<BR>
<B>Omita el co`digo del telefono -</B> este campo permite que usted dejehacia fuera el campo del phone_code mientras que marca dentro deVICIDIAL. Por ejemplo si usted está marcando en el Reino Unido delReino Unido usted tendría 44 adentro como su campo del phone_codepara todos los plomos, pero usted apenas desea marcar 10 dígitos ensu extensions.conf dial plan para poner llamadas en vez de 44 entonces10 dígitos. El defecto es N.

<BR>
<A NAME="vicidial_campaigns-campaign_cid">
<BR>
<B>Campaña CallerID -</B> este campo permite enviar de un número de encargo del callerid en las llamadas de salida. Úste es el número que demostraría para arriba en el callerid de la persona que usted está llamando. El defecto es DESCONOCIDO. Esta opcio`n está solamente disponible si usted está utilizando PRIs - ISDN T1 o E1 - que tienen la característica de encargo del callerid se giraron. Esta característica puede Tambien trabajar con los troncos IAX2 dependiendo de lo que admite su abastecedor. El callerID de encargo se aplica solamente a las llamadas puestas para la campaña de VICIDIAL directamente, cualquier tercer persona llama o las transferencias no enviarán el callerID de encargo. NOTA: A veces el poner DESCONOCIDO o PRIVADO en el campo rendirá enviar de su número del callerID del defecto por su portador con las llamadas. Usted puede desear probar esto y poner 0000000000 en el campo del callerid en lugar de otro si usted no desea enviarle CallerID.

<BR>
<A NAME="vicidial_campaigns-campaign_vdad_exten">
<BR>
<B>Extension de la campaña VDAD -</B> este campo permite una extension de la transferencia del costumbre VDAD. Esto permite que usted utilice diversas escrituras del agi de VDADtransfer... dependiendo de su campaña. La transferencia AGI(exten 8365  agi-VDADtransfer.agi  del defecto) apenas envía inmediatamente invita a los agentes tan pronto como e`l se tome. Una encuesta sobre política AGI la muestra adicional es Tambien (8366  agi-VDADtransferSURVEY.agi ) ese ahora incluido los juegos un mensaje a la persona llamada y permite que e`l haga una opcio`n presionando buttons(effectively la pre-investigacio`n el plomo). Observe por favor eso a excepcio`n de los exámenes, llamadas políticas y las caridades esta forma de llamar son ilegales en los Estados Unidos.

<BR>
<A NAME="vicidial_campaigns-campaign_rec_exten">
<BR>
<B>Extension de Rec de la Campaña -</B> este campo permite para que una extension de encargo de la grabacion sea utilizada con VICIDIAL. Esto permite que usted utilice diversas extensiones dependiendo sobre cuánto tiempo usted desea permitir una grabacion máxima y que` tipo de codec usted desea registrar adentro. El defecto exten es 8309 que si usted sigue los ejemplos de SCRATCH_INSTALL registrarán en el formato de WAV para hasta que una hora. Otra opcio`n incluida en los ejemplos es 8310 que registrarán en el formato del GSM para hasta que una hora.

<BR>
<A NAME="vicidial_campaigns-campaign_recording">
<BR>
<B>grabacion de la campaña -</B> este menú permite que usted elija que`nivel de la grabacion se permite en esta campaña. NUNCAinhabilitará la grabacion en el cliente. ONDEMAND es el defecto ypermite que el agente comience y pare a registrar según lonecesitado. ALLCALLS comenzará la grabacion en el cliente siempreque una llamada se envíe a un agente. ALLFORCE comenzará lagrabacion en el cliente siempre que una llamada se envíe a un agenteque no da al agente ninguna opcio`n para parar el registrar. ParaALLCALLS y ALLFORCE hay una opcio`n para utilizar la grabacionretrasa para reducir en grabaciones y carga de sistema muy cortas delrecude.

<BR>
<A NAME="vicidial_campaigns-campaign_rec_filename">
<BR>
<B>Nombre de fichero de Rec de la campaña -</B> este campo permite que usted modifique el nombre para requisitos particulares de la grabacion cuando la grabacion de la campaña es ONDEMAND o ALLCALLS. Las variables permitidas son CAMPAIGN CUSTPHONE FULLDATE TINYDATE EPOCH AGENT. El defecto es FULLDATE_AGENT y parecería este 20051020-103108_6666. Otro ejemplo es CAMPAIGN_TINYDATE_CUSTPHONE que parecería este TESTCAMP_51020103108_3125551212. 50 char max.

<BR>
<A NAME="vicidial_campaigns-allcalls_delay">
<BR>
<B>La registracion retrasa -</B> para la grabacion de ALLCALLS y deALLFORCE solamente. Esta voluntad del ajuste retrasa comenzar de lagrabacion en todas las llamadas para el número de los segundosespecificados en este campo. El defecto es 0.

<BR>
<A NAME="vicidial_campaigns-campaign_script">
<BR>
<B>Escritura de la campaña -</B> este menú permite que usted elija la escritura que aparecerá en la pantalla de los agentes para esta campaña. No seleccione NONE no demostrar ninguna escritura para esta campaña.

<BR>
<A NAME="vicidial_campaigns-get_call_launch">
<BR>
<B>Consiga el lanzamiento de la llamada -</B> este menú permite que usted elija si usted desee automo`vil-lance la página en una ventana separada, auto-switch de la tela-forma a la lengüeta de la ESCRITURA o no haga nada cuando una llamada se envía al agente para esta campaña. 

<BR>
<A NAME="vicidial_campaigns-am_message_exten">
<BR>
<B>Mensaje del contestador automático -</B> este campo está para entrar en una extension para cegar llamadas de la transferencia a cuando el agente consigue un contestador automático y chasca encendido el boton del mensaje del contestador automático en el marco de la conferencia de la transferencia. Usted debe fijar esto exten para arriba en el dial plan - extensions.conf - y se cerciora de que juega un archivo audio despue`s que cuelga para arriba. 

<BR>
<A NAME="vicidial_campaigns-amd_send_to_vmx">
<BR>
<B>AMD envían a la VM exten -</B> este menú permite que usted defina si un mensaje este` dejado en un contestador automático cuando se detecta la llamada será remitido inmediatamente a la extension del Contestar-Ma`quina-Mensaje si AMD es activo y se determina que la llamada es un contestador automático.

<BR>
<A NAME="vicidial_campaigns-xferconf_a_dtmf">
<BR>
<B>Xfer-Conf DTMF -</B> Estos cuatro campos permiten para que usted tenga dos sistemas de conferencia de la transferencia y de precolocaciones de DTMF. Cuando se carga la llamada o la campaña, la escritura de vicidial.php demostrará dos botones en el marco de la transferir-conferencia y automo`vil-poblara` el nu`mero-a-dial y los campos del enviar-dtmf cuando está presionada. Si usted desea permitir transferencias consultivas, un fronter a unmás cercano, usted puede colocar CXFER pues uno de lasprecolocaciones del nu`mero-a-dial y del dial string apropiado seráenviado para hacer una transferencia consultiva local, entonces lalata LEAVE-3WAY-CALL justo del agente y movimiento encendido a sullamada siguiente. Si usted desea permitir transferencias ocultas declientes a una escritura de VICIDIAL AGI para registrar o un IVR,entonces coloque AXFER en el campo del nu`mero-a-dial. Usted puedeTambien especificar una extension de encargo despue`s del AXFER odel CXFER, por ejemplo si usted desea hacer transferencias consultivasinternas en vez de local que usted pondría CXFER90009 en el campo delnu`mero-a-dial.

<BR>
<A NAME="vicidial_campaigns-alt_number_dialing">
<BR>
<B>El marcar nume`rico del Alt del agente -</B> esta opcio`n permite que un agente marque manualmente el número de telefono o el campo alterno address3 despue`s de que se haya llamado el número principal.

<BR>
<A NAME="vicidial_campaigns-scheduled_callbacks">
<BR>
<B>Servicios repetidos programar -</B> esta opcio`n no prohibe a agente a la disposicion una llamada como CALLBK y elige los datos y el tiempo en los cuales el plomo será reactivado.

<BR>
<A NAME="vicidial_campaigns-drop_call_seconds">
<BR>
<B>Segundos de la llamada de la gota -</B> el número de segundos a partirdel tiempo que la línea de cliente se escoge encima de hasta que lallamada se considera una GOTA, so`lo se aplica a las llamadas desalida.

<BR>
<A NAME="vicidial_campaigns-drop_action">
<BR>
<B>Drop Action -</B> This menu allows you to choose what happens to a call when it has been waiting for longer than what is set in the Secondi Abbattimento Telefonata field. HANGUP will simply hang up the call, MESSAGE will send the call the Gota Exten that you have defined below, VOICEMAIL will send the call to the voicemail box that you have defined below and IN_GROUP will send the call to the Inbound Group that is defined below||

<BR>
<A NAME="vicidial_campaigns-safe_harbor_exten">
<BR>
<B>seguro puerto Exten -</B> este ser dial plan extension que desear seguropuerto audio archivo ser localizar en en su servidor.

<BR>
<A NAME="vicidial_campaigns-voicemail_ext">
<BR>
<B>Casella Vocale -</B> si estuvieron definidas, las llamadas que CAERÍAN normalmente en lugar de otro serían ordenadas a esta caja del voicemail para oír y para dejar un mensaje.

<BR>
<A NAME="vicidial_campaigns-drop_inbound_group">
<BR>
<B>Drop Transfer Group -</B> If Drop Action is set to IN_GROUP, the call will be sent to this inbound group if it reaches Secondi Abbattimento Telefonata.

<BR>
<A NAME="vicidial_campaigns-wrapup_seconds">
<BR>
<B>Segundos de Wrap Up -</B> el número de los segundos para forzar un agenteesperar antes de permitir que reciban o que marquen otra llamada. Elcontador de tiempo comienza tan pronto como un agente cuelgue paraarriba en su cliente - o en el caso del número alterno que marcacuando el agente acaba el plomo - defecto sea los segundos 0. Si elcontador de tiempo funciona hacia fuera antes de que el agente tengadispositioned la llamada, el agente todavía no se mueve encendido ala llamada siguiente hasta que seleccionan una disposicion.

<BR>
<A NAME="vicidial_campaigns-wrapup_message">
<BR>
<B>Mensaje de Wrap up -</B> esto es un mensaje campaña-especi`fico que seexhibirá en la pantalla del wrapup si se fijan los segundos delwrapup.

<BR>
<A NAME="vicidial_campaigns-use_internal_dnc">
<BR>
<B>Lista interna del uso DNC -</B> esto define si esta campaña es filtrarlos plomos contra la lista interna de DNC. Si se fija a Y, la tolvabuscará cada número de telefono en la lista de DNC antes de ponerlaen la tolva. Si está en la lista de DNC entonces que cambiará eseconduce estado a DNCL así que no puede ser marcada. El defecto es N.

<BR>
<A NAME="vicidial_campaigns-use_campaign_dnc">
<BR>
<B>Use Campagna DNC List -</B> This defines whether this campaign is to filter leads against a DNC list that is specific to that campaign only. If it is set to Y, the hopper will look for each phone number in the campaign-specific DNC list before placing it in the hopper. If it is in the campaign-specific DNC list then it will change that lead status to DNCC so it cannot be dialed. Default is N.

<BR>
<A NAME="vicidial_campaigns-closer_campaigns">
<BR>
<B>Grupos De entrada Permitidos -</B> For CLOSER campaigns only. Here is where you select the inbound groups you want agents in this CLOSER campaign to be able to take calls from. It is important for BLENDED inbound-outbound campaigns only to select the inbound groups that are used for agents in this campaign. The calls coming into the inbound groups selected here will be counted as active calls for a blended campaign even if all agents in the campaign are not logged in to receive calls from all of those selected inbound groups.

<BR>
<A NAME="vicidial_campaigns-agent_pause_codes_active">
<BR>
<B>La pausa del agente cifra activo -</B> permite que los agentes seleccionenun co`digo de la pausa cuando chascan encendido el boton de PAUSA envicidial.php. Los co`digos de la pausa son definibles por campaña enel fondo de la pantalla del detalle de la opinio`n de la campaña y sealmacenan en la tabla del vicidial_agent_log. El defecto es N.

<BR>
<A NAME="vicidial_campaigns-disable_alter_custdata">
<BR>
<B>Inhabilite alteran datos del cliente -</B> si el sistema a Y, no cambiacualquiera del expediente de datos del cliente cuando lasdisposiciones de un agente la llamada. El defecto es N.

<BR>
<A NAME="vicidial_campaigns-disable_alter_custphone">
<BR>
<B>Disable Alter Customer Phone -</B> If set to Y, does not change the customer phone number when an agent dispositions the call. Default is Y.

<BR>
<A NAME="vicidial_campaigns-no_hopper_leads_logins">
<BR>
<B>Permita Ninguno-Tolva-Conduce conexiones -</B> si el sistema a Y, permiteagentes a la conexion a la campaña incluso si no hay plomos cargadosen la tolva para esa campaña. Esta funcio`n no se necesita encampañas de CLOSER-type. El defecto es N.

<BR>
<A NAME="vicidial_campaigns-display_queue_count">
<BR>
<B>Agent Display Queue Count -</B> If set to Y, when a customer is waiting for an agent, the Queue Calls display at the top of the agent screen will turn red and show the number of waiting calls. Default is Y.

<BR>
<A NAME="vicidial_campaigns-list_order_mix">
<BR>
<B>Mezcla de la orden de la lista -</B> elimina los campos de la orden delplomo y del estado del dial. Utilizará los parámetros de la lista ydel estado para la entrada seleccionada de la mezcla de la lista en laseccio`n del submarino de la mezcla de la lista en lugar de otro. Eldefecto es LISIADO.

<BR>
<A NAME="vicidial_campaigns-vcl_id">
<BR>
<B>Identificacio`n de la mezcla de la lista -</B> identificacio`n de lamezcla de la lista. Debe ser a partir de 2-20 caracteres en longitudsin los espacios o la otra puntuacio`n especial.

<BR>
<A NAME="vicidial_campaigns-vcl_name">
<BR>
<B>Nombre de la mezcla de la lista -</B> nombre descriptivo de la mezcla dela lista. Debe ser a partir de 2-50 caracteres en longitud.

<BR>
<A NAME="vicidial_campaigns-list_mix_container">
<BR>
<B>Detalle de la mezcla de la lista -</B> la composicio`n de la entrada de lamezcla de la lista. Contiene la identificacio`n de la lista, la ordende la mezcla, los porcentajes y los estados que hacen para arriba estamezcla de la lista. Los porcentajes tienen que agregar siempre hasta100, y las listas todas tienen que ser activas y fijadas a la campañapara que la entrada de la mezcla de la orden sea activada.

<BR>
<A NAME="vicidial_campaigns-mix_method">
<BR>
<B>Me`todo de la mezcla de la lista -</B> el me`todo de mezclar a todas laspartes del detalle de la mezcla de la lista juntas. EVEN_MIX mezclarálos plomos de cada parte interpolada con las otras partes, como estos1.2.3.1.2.3.1.2.3. IN_ORDER pondrá los plomos en la orden en la cualse enumeran en la pantalla 1.1.1.2.2.2.3.3.3 del detalle de la mezclade la lista. La voluntad AL AZAR los puso en la orden AL AZAR1.3.2.1.1.3.2.1.3. El defecto es IN_ORDER.

<BR>
<A NAME="vicidial_campaigns-manual_dial_list_id">
<BR>
<B>Identificacio`n manual de la lista del dial -</B> el list_id del defectoque se utilizará cuando los placces de un agente una llamada manual yun nuevo expediente del plomo se crean en vicidial_list. El defecto es999. Este campo puede contener dígitos solamente.

<BR>
<A NAME="vicidial_campaigns-manual_dial_filter">
<BR>
<B>Manual Dial Filter -</B> This allows you to filter the calls that agents make in manual dial mode for this campaign by any combination of the following: DNC - to kick out, CAMPAIGNLISTE - the number must be within the lists for the campaign, NONE - no filter on manual dial or fast dial lists.

<BR>
<A NAME="vicidial_campaigns-agent_clipboard_copy">
<BR>
<B>Agent Screen Clipboard Copy -</B> THIS FEATURE IS CURRENTLY ONLY ENABLED FOR INTERNET EXPLORER. This feature allows you to select a field that will be copied to the computer clipboard of the agent computer upon a call being sent to an agent. Common uses for this are to allow for easy pasting of account numbers or phone numbers into legacy client applications on the agent computer.

<BR>
<A NAME="vicidial_campaigns-agent_extended_alt_dial">
<BR>
<B>Agent Screen Extended Alt Dial -</B> This feature allows for agents to access extended alternate phone numbers for leads beyond the standard Alt Phone and Address3 fields that can be used in VICIDIAL for phone numbers beyond the main phone number. The Extended phone numbers can be dialed automatically using the Auto-Alt-Dial feature in VICIDIAL Campagna settings, but enabling this Agent Screen feature will also allow for the agent to call these numbers from their agent screen as well as edit their information.

<BR>
<A NAME="vicidial_campaigns-three_way_call_cid">
<BR>
<B>3-Way Call CallerID De salida -</B> This defines what is sent out as the outbound callerID number from 3-way calls placed by the agent, CAMPAIGN uses the custom campaign callerID, CUSTOMER uses the number of the customer that is active on the agents screen and AGENT_PHONE uses the callerID for the phone that the agent is logged into.

<BR>
<A NAME="vicidial_campaigns-qc_enabled">
<BR>
<B>QC Enabled -</B> Setting this field to Y allows for the agent Quality Control features to work. Default is N.

<BR>
<A NAME="vicidial_campaigns-qc_statuses">
<BR>
<B>QC Esiti -</B> This area is where you select which statuses of leads should be gone over by the QC system. Place a check next to the status that you want QC to review. 

<BR>
<A NAME="vicidial_campaigns-qc_shift_id">
<BR>
<B>QC Shift -</B> This is the shift timeframe used to pull QC records for a campaign. The days of the week are ignored for these functions.

<BR>
<A NAME="vicidial_campaigns-qc_get_record_launch">
<BR>
<B>QC Get Record Launch-</B> This allows one of the following actions to be triggered upon a QC agent receiving a new record.

<BR>
<A NAME="vicidial_campaigns-qc_show_recording">
<BR>
<B>QC Show Recording -</B> This allows for a recording that may be linked with the QC record to be display in the QC agent screen.

<BR>
<A NAME="vicidial_campaigns-qc_web_form_address">
<BR>
<B>QC WebForm Address -</B> This is the website address that a QC agent can go to when clicking on the WEBFORM link in the QC screen.

<BR>
<A NAME="vicidial_campaigns-qc_script">
<BR>
<B>QC Script -</B> This is the script that can be used by QC agents in the SCRIPT tab in the QC screen.

<BR>
<A NAME="vicidial_campaigns-survey_first_audio_file">
<BR>
<B>Survey First Audio File -</B> This is the audio filename that is played as soon as the customer picks up the phone when running a survey campaign.

<BR>
<A NAME="vicidial_campaigns-survey_dtmf_digits">
<BR>
<B>Survey DTMF Digits -</B> This field is where you define the digits that a customer can press as an option on a survey campaign. valid dtmf digits are 0123456789*#

<BR>
<A NAME="vicidial_campaigns-survey_ni_digit">
<BR>
<B>Survey Not Interested Digit -</B> This field is where you define the customer digit pressed that will show they are Not Interested.

<BR>
<A NAME="vicidial_campaigns-survey_ni_status">
<BR>
<B>Survey Not Interested Status -</B> This field is where you select the status to be used for Not Interested. If DNC is used and the campaign is set to use DNC then the phone number will be automatically added to the VICIDIAL internal DNC list and possibly the campaign-specific DNC list.

<BR>
<A NAME="vicidial_campaigns-survey_opt_in_audio_file">
<BR>
<B>Survey Opt-in Audio File -</B> This is the audio filename that is played when the customer has opted-in to the survey, not opted-out or not responded if the no-response-action is set to OPTOUT. After this audio file is played, the Survey Method action is taken.

<BR>
<A NAME="vicidial_campaigns-survey_ni_audio_file">
<BR>
<B>Survey Not Interested Audio File -</B> This is the audio filename that is played when the customer has opted-out of the survey, not opted-in or not responded if the no-response-action is set to OPTIN. After this audio file is played, the call will be hung up.

<BR>
<A NAME="vicidial_campaigns-survey_method">
<BR>
<B>Survey Method -</B> This option defines what happens to a call after the customer has opted-in. AGENT_XFER will send the call to the next available agent. VOICEMAIL will send the call to the voicemail box that is specified in the Casella Vocale field. EXTENSION will send the customer to the extension defined in the Survey Xfer Extension field. HANGUP will hang up the customer. CAMPREC_60_WAV will send the customer to have a recording made with their response, this recording will be placed in a folder named as the campaign inside of the Survey Registrazioni Per Questa Campagna Directory.

<BR>
<A NAME="vicidial_campaigns-survey_no_response_action">
<BR>
<B>Survey No-Response Action -</B> This is where you define what will happen if there is no response to the survey question. OPTIN will only send the call on to the Survey Method if the customer presses a dtmf digit. OPTOUT will send the customer on to the Survey Method even if they do not press a dtmf digit.

<BR>
<A NAME="vicidial_campaigns-survey_response_digit_map">
<BR>
<B>Survey Response Digit Map -</B> This is the section where you can define a description to go with each dtmf digit option that the customer may select.

<BR>
<A NAME="vicidial_campaigns-survey_xfer_exten">
<BR>
<B>Survey Xfer Extension -</B> If the Survey Method of EXTENSION is selected then the customer call would be directed to this dialplan extension.

<BR>
<A NAME="vicidial_campaigns-survey_camp_record_dir">
<BR>
<B>Survey Registrazioni Per Questa Campagna Directory -</B> If the Survey Method of CAMPREC_60_WAV is selected then the customer response will be recorded and placed in a directory named after the campaign inside of this directory.







<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_LISTE TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_lists-list_id">
<BR>
<B>Identificacio`n de la lista -</B> Úste es el nombre nume`rico de la lista, e`l no es editable despue`s de la sumisio`n inicial, debe contener solamente números y debe estar entre 2 y 8 caracteres en longitud. Must be a number greater than 100.

<BR>
<A NAME="vicidial_lists-list_name">
<BR>
<B>Nombre de la lista -</B> esta es la descripcio`n de la lista, debe estar entre 2 y 20 caracteres en longitud.

<BR>
<A NAME="vicidial_lists-list_description">
<BR>
<B>Descripcio`n de la lista -</B> este es el campo de la nota para la lista,e`l es opcional.

<BR>
<A NAME="vicidial_lists-list_changedate">
<BR>
<B>Fecha del cambio de la lista -</B> esta es la vez última que los ajustespara esta lista fueron modificados de cualquier manera.

<BR>
<A NAME="vicidial_lists-list_lastcalldate">
<BR>
<B>Fecha de la llamada del último de la lista -</B> esta es la vez últimaque conduce fue marcado de esta lista.

<BR>
<A NAME="vicidial_lists-campaign_id">
<BR>
<B>Campaña -</B> esta es la campaña que esta lista pertenece a. Una lista se puede marcar solamente en una sola campaña contemporáneamente.

<BR>
<A NAME="vicidial_lists-active">
<BR>
<B>Activo -</B> esto define si la lista debe ser marcada encendido o no.

<BR>
<A NAME="vicidial_lists-reset_list">
<BR>
<B>Reajuste el Conducir-Llamar-Estado para esta lista -</B> esto reajusta todos los plomos en esta lista a N para "no llamado puesto que reajuste pasado" y significa que cualquier plomo puede ahora ser llamado si es el estado derecho según lo definido en la pantalla de la campaña.

<BR>
<A NAME="vicidial_list-dnc">
<BR>
<B>VICIDIAL DNC List -</B> This Do Not Call list contains every lead that has been set to a status of DNC in the system. Through the LISTE - AGREGUE EL NÚMERO A DNC page you are able to manually add numbers to this list so that they will not be called by campaigns that use the internal DNC list. There is also the option to add leads to the campaign-specific DNC lists for those campaigns that have them.



<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_INBOUND_GROUPS TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_inbound_groups-group_id">
<BR>
<B>Identificacio`n de grupo -</B> Úste es el nombre corto del grupo de entrada, e`l no es editable despue`s de la sumisio`n inicial, no debe contener cualquier espacio y debe estar entre 2 y 20 caracteres en longitud.

<BR>
<A NAME="vicidial_inbound_groups-group_name">
<BR>
<B>Nombre de grupo -</B> esta es la descripcio`n del grupo, debe estar entre 2 y 30 caracteres en longitud. No puede incluir rociadas -, plusses + o espacios .

<BR>
<A NAME="vicidial_inbound_groups-group_color">
<BR>
<B>Color del grupo -</B> este es el color que exhibe en el cliente app de VICIDIAL cuando una llamada viene adentro en este grupo. Debe estar entre 2 y 7 caracteres de largo. Si esto es una definicio`n del color de la tuerca hexagonal usted debe recordar poner a # al principio de la secuencia o VICIDIAL no trabajará correctamente.

<BR>
<A NAME="vicidial_inbound_groups-active">
<BR>
<B>Activo -</B> esto se determina si este grupo demuestra para arriba en la caja de la seleccio`n cuando un agente de VICIDIAL entra.

<BR>
<A NAME="vicidial_inbound_groups-web_form_address">
<BR>
<B>Forma del Web -</B> esta es la Direccion de encargo que el chascar en el boton de la FORMA del WEB en VICIDIAL le llevará para las llamadas que vienen adentro en este grupo.

<BR>
<A NAME="vicidial_inbound_groups-next_agent_call">
<BR>
<B>Llamada siguiente del agente -</B> esto se determina que` agente recibe la llamada siguiente que está disponible:
 <BR> &nbsp; - random: o`rdenes por el valor al azar de la actualizacio`n en la tabla de los vicidial_live_agents
 <BR> &nbsp; - oldest_call_start: las o`rdenes por la vez última un agente fueron enviadas una llamada. Resultados en los agentes que reciben el número casi igual de llamadas cabalmente.
 <BR> &nbsp; - oldest_call_finish: las o`rdenes por la vez última un agente acabaron una llamada. El agente de AKA que espera lo más de largo posible recibe la primera llamada.
 <BR> &nbsp; - overall_user_level: las o`rdenes por el user_level del agente según lo definido en los vicidial_users tabulan un user_level más alto recibirán más llamadas.
 <BR> &nbsp; - inbound_group_rank: o`rdenes de la fila dada al agente para el grupode entrada específico. Lo más arriba posible a lo más bajo posible.
 <BR> &nbsp; - fewest_calls: o`rdenes por el número de las llamadas recibidas por unagente para ese grupo de entrada específico. Menos llamadas primero.
 <BR> &nbsp; - campaign_rank: o`rdenes de la fila dada al agente para la campaña. Lomás arriba posible a lo más bajo posible.
 <BR> &nbsp; - fewest_calls_campaign: orders by the number of calls received by an agent for the campaign. Least calls first.
<BR>

<BR>
<A NAME="vicidial_inbound_groups-queue_priority">
<BR>
<B>Queue Priority -</B> This setting is used to define the order in which the calls from this inbound group should be answered in relation to calls from other inbound groups.

<A NAME="vicidial_inbound_groups-fronter_display">
<BR>
<B>Exhibicio`n de Fronter -</B> este campo se determina si el agente de entrada de VICIDIAL tendría el name(if del fronter allí es uno) exhibido en el campo del estado cuando la llamada viene al agente.

<BR>
<A NAME="vicidial_inbound_groups-ingroup_script">
<BR>
<B>Escritura de la campaña -</B> este menú permite que usted elija la escritura que aparecerá en la pantalla de los agentes para esta campaña. No seleccione NONE no demostrar ninguna escritura para esta campaña.

<BR>
<A NAME="vicidial_inbound_groups-get_call_launch">
<BR>
<B>Consiga el lanzamiento de la llamada -</B> este menú permite que usted elija si usted desee automo`vil-lance la página en una ventana separada, auto-switch de la tela-forma a la lengüeta de la ESCRITURA o no haga nada cuando una llamada se envía al agente para esta campaña. 

<BR>
<A NAME="vicidial_inbound_groups-xferconf_a_dtmf">
<BR>
<B>Xfer-Conf DTMF -</B> Estos cuatro campos permiten para que usted tenga dos sistemas de conferencia de la transferencia y de precolocaciones de DTMF. Cuando se carga la llamada o la campaña, la escritura de vicidial.php demostrará dos botones en el marco de la transferir-conferencia y automo`vil-poblara` el nu`mero-a-dial y los campos del enviar-dtmf cuando está presionada. Si usted desea permitir transferencias consultivas, un fronter a unmás cercano, usted puede colocar CXFER pues uno de lasprecolocaciones del nu`mero-a-dial y del dial string apropiado seráenviado para hacer una transferencia consultiva local, entonces lalata LEAVE-3WAY-CALL justo del agente y movimiento encendido a sullamada siguiente. Si usted desea permitir transferencias ocultas declientes a una escritura de VICIDIAL AGI para registrar o un IVR,entonces coloque AXFER en el campo del nu`mero-a-dial. Usted puedeTambien especificar una extension de encargo despue`s del AXFER odel CXFER, por ejemplo si usted desea hacer transferencias consultivasinternas en vez de local que usted pondría CXFER90009 en el campo delnu`mero-a-dial.

<BR>
<A NAME="vicidial_inbound_groups-drop_call_seconds">
<BR>
<B>Secondi Abbattimento Telefonata -</B> The number of seconds a call will stay in queue before being considered a DROP.

<BR>
<A NAME="vicidial_inbound_groups-drop_action">
<BR>
<B>Drop Action -</B> This menu allows you to choose what happens to a call when it has been waiting for longer than what is set in the Secondi Abbattimento Telefonata field. HANGUP will simply hang up the call, MESSAGE will send the call the Gota Exten that you have defined below, VOICEMAIL will send the call to the voicemail box that you have defined below and IN_GROUP will send the call to the Inbound Group that is defined below.

<BR>
<A NAME="vicidial_inbound_groups-drop_exten">
<BR>
<B>Gota Exten -</B> If Drop Action is set to MESSAGE, this is the dial plan extension that the call will be sent to if it reaches Secondi Abbattimento Telefonata.

<BR>
<A NAME="vicidial_inbound_groups-voicemail_ext">
<BR>
<B>Casella Vocale -</B> If Drop Action is set to VOICEMAIL, the call DROP would instead be directed to this voicemail box to hear and leave a message.

<BR>
<A NAME="vicidial_inbound_groups-drop_inbound_group">
<BR>
<B>Drop Transfer Group -</B> If Drop Action is set to IN_GROUP, the call will be sent to this inbound group if it reaches Secondi Abbattimento Telefonata.

<BR>
<A NAME="vicidial_inbound_groups-call_time_id">
<BR>
<B>Tiempo de la llamada -</B> este es el esquema del tiempo de la llamada autilizar para este grupo de entrada. Tenga presente que el tiempoestá basado en el tiempo del servidor. El defecto es 24hours.

<BR>
<A NAME="vicidial_inbound_groups-after_hours_action">
<BR>
<B>After Hours Action -</B> The action to perform if it is after hours as defined in the call time for this inbound group. HANGUP will immediately hangup the call, MESSASGE will play the file in the After Hours Message Filenam field, EXTENSION will send the call to the After Hours Extension in the dialplan and VOICEMAIL will send the call to the voicemail box listed in the After Hours Casella Vocale field, IN_GROUP will send the call to the inbound group selected in the After Hours Transfer Group select list. Default is MESSAGE.

<BR>
<A NAME="vicidial_inbound_groups-after_hours_message_filename">
<BR>
<B>Despue`s del nombre de fichero del mensaje de las horas -</B> el archivoaudio situado en el servidor que se jugará si la accio`n se fija alMENSAJE. El defecto es VM-ADIO`S

<BR>
<A NAME="vicidial_inbound_groups-after_hours_exten">
<BR>
<B>Despue`s de la extension de las horas -</B> la extension dialplan paraenviar la llamada si la accio`n se fija a la Extension. El defecto es8300.

<BR>
<A NAME="vicidial_inbound_groups-after_hours_voicemail">
<BR>
<B>Despue`s de las horas Casella Vocale -</B> la caja del voicemail para enviar lallamada si la accio`n se fija a VOICEMAIL.

<BR>
<A NAME="vicidial_inbound_groups-afterhours_xfer_group">
<BR>
<B>After Hours Transfer Group -</B> If After Hours Action is set to IN_GROUP, the call will be sent to this inbound group if it enters the in-group outside of the call time scheme defined for the in-group.

<BR>
<A NAME="vicidial_inbound_groups-welcome_message_filename">
<BR>
<B>Nombre de fichero agradable del mensaje -</B> el archivo audio situado enel servidor que se jugará cuando viene la llamada adentro. Si sistemaa ---NONE --- entonces no se jugará ningún mensaje. El defecto es---NONE ---

<BR>
<A NAME="vicidial_inbound_groups-play_welcome_message">
<BR>
<B>Play Benvenuti Message -</B> These settings select when to play the defined welcome message, ALWAYS will play it every time, NEVER will never play it, IF_WAIT_ONLY will only play the welcome message if the call does not immediately go to an agent, and YES_UNLESS_NODELAY will always play the welcome message unless the NO_DELAY setting is enabled. Default is ALWAYS.

<BR>
<A NAME="vicidial_inbound_groups-moh_context">
<BR>
<B>Música en contexto del asimiento -</B> la música en el contexto delasimiento para utilizar cuando colocan al cliente en asimiento. Eldefecto es defecto.

<BR>
<A NAME="vicidial_inbound_groups-onhold_prompt_filename">
<BR>
<B>En el nombre de fichero del aviso del asimiento -</B> el archivo audiosituado en el servidor que se jugará en un intervalo regular cuandoel cliente está en asimiento. El defecto es generic_hold. Estearchivo audio DEBE estar 9 segundos o menos en longitud.

<BR>
<A NAME="vicidial_inbound_groups-prompt_interval">
<BR>
<B>En el intervalo del aviso del asimiento -</B> la longitud de la hora ensegundos de esperar antes de jugar encendido el aviso del sostener. Eldefecto es 60. To disable the On Hold Prompt, set the interval to 0.

<BR>
<A NAME="vicidial_inbound_groups-play_place_in_line">
<BR>
<B>Play Place in Line -</B> This defines whether the caller will hear their place in line when they enter the queue as well as when they hear the announcemend. Default is N.

<BR>
<A NAME="vicidial_inbound_groups-play_estimate_hold_time">
<BR>
<B>Play Estimated Hold Time -</B> This defines whether the caller will hear the estimated hold time before they are transferred to an agent. Default is N.

<BR>
<A NAME="vicidial_inbound_groups-hold_time_option">
<BR>
<B>Hold Time Option -</B> This allows you to specify the routing of the call if the estimated hold time is over the amount of seconds specified below. Default is NONE.

<BR>
<A NAME="vicidial_inbound_groups-hold_time_option_seconds">
<BR>
<B>Hold Time Option Seconds -</B> If Hold Time Option is set to anything but NONE, this is the number of seconds of estimated hold time that will trigger the hold time option. Default is 360 seconds.

<BR>
<A NAME="vicidial_inbound_groups-hold_time_option_exten">
<BR>
<B>Hold Time Option Extension -</B> If Hold Time Option is set to EXTENSION, this is the dialplan extension that the call will be sent to if the estimated hold time exceeds the Hold Time Option Seconds.

<BR>
<A NAME="vicidial_inbound_groups-hold_time_option_voicemail">
<BR>
<B>Hold Time Option Casella Vocale -</B> If Hold Time Option is set to VOICEMAIL, this is the voicemail box that the call will be sent to if the estimated hold time exceeds the Hold Time Option Seconds.

<BR>
<A NAME="vicidial_inbound_groups-hold_time_option_xfer_group">
<BR>
<B>Hold Time Option Transfer In-Group -</B> If Hold Time Option is set to IN_GROUP, this is the inbound group that the call will be sent to if the estimated hold time exceeds the Hold Time Option Seconds.

<BR>
<A NAME="vicidial_inbound_groups-hold_time_option_callback_filename">
<BR>
<B>Hold Time Option Callback Filename -</B> If Hold Time Option is set to CALLERID_CALLBACK, this is the filename prompt that is played before the call is logged as a new lead to the list ID specified below if the estimated hold time exceeds the Hold Time Option Seconds.

<BR>
<A NAME="vicidial_inbound_groups-hold_time_option_callback_list_id">
<BR>
<B>Hold Time Option Callback ID Lista -</B> If Hold Time Option is set to CALLERID_CALLBACK, this is the ID Lista the call is added to as a new lead if the estimated hold time exceeds the Hold Time Option Seconds.

<BR>
<A NAME="vicidial_inbound_groups-agent_alert_exten">
<BR>
<B>Extension alerta del agente -</B> la extension a enviar en la sesio`ndel agente para anunciar que una llamada está viniendo al agente.Esta extension debe tener un aparato de lectura de un archivo audio.No utilizar esta funcio`n fijo` esto a X. Default es X.

<BR>
<A NAME="vicidial_inbound_groups-agent_alert_delay">
<BR>
<B>La alarma del agente retrasa -</B> la longitud de la hora en milisegundosde esperar antes de enviar la llamada al agente despue`s de jugarencendido la extension alerta del agente. El defecto es 1000.

<BR>
<A NAME="vicidial_inbound_groups-default_xfer_group">
<BR>
<B>Grupo de la transferencia del defecto -</B> este campo es el En-Grupo deldefecto que será seleccionado automáticamente cuando el agente va almarco de la transferir-conferencia en su interfaz del agente.

<BR>
<A NAME="vicidial_inbound_groups-ingroup_recording_override">
<BR>
<B>In-Group Recording Override -</B> This field allows for the overriding of the campaign call recording setting. This setting can be overridden by the vicidial_user recording override setting. DISABLED will not override the campaign recording setting. NEVER will disable recording on the client. ONDEMAND is the default and allows the agent to start and stop recording as needed. ALLCALLS will start recording on the client whenever a call is sent to an agent. ALLFORCE will start recording on the client whenever a call is sent to an agent giving the agent no option to stop recording.

<BR>
<A NAME="vicidial_inbound_groups-ingroup_rec_filename">
<BR>
<B>In-Group Recording Filename -</B> This field will override the Registrazioni Per Questa Campagna Filenaming Scheme unless it is set to NONE. The allowed variables are CAMPAIGN CUSTPHONE FULLDATE TINYDATE EPOCH AGENT. The default is FULLDATE_AGENT and would look like this 20051020-103108_6666. Another example is CAMPAIGN_TINYDATE_CUSTPHONE which would look like this TESTCAMP_51020103108_3125551212. 50 char max. Default is NONE.

<BR>
<A NAME="vicidial_inbound_groups-qc_enabled">
<BR>
<B>QC Enabled -</B> Setting this field to Y allows for the agent Quality Control features to work. Default is N.

<BR>
<A NAME="vicidial_inbound_groups-qc_statuses">
<BR>
<B>QC Esiti -</B> This area is where you select which statuses of leads should be gone over by the QC system. Place a check next to the status that you want QC to review. 

<BR>
<A NAME="vicidial_inbound_groups-qc_shift_id">
<BR>
<B>QC Shift -</B> This is the shift timeframe used to pull QC records for an inbound_group. The days of the week are ignored for these functions.

<BR>
<A NAME="vicidial_inbound_groups-qc_get_record_launch">
<BR>
<B>QC Get Record Launch-</B> This allows one of the following actions to be triggered upon a QC agent receiving a new record.

<BR>
<A NAME="vicidial_inbound_groups-qc_show_recording">
<BR>
<B>QC Show Recording -</B> This allows for a recording that may be linked with the QC record to be display in the QC agent screen.

<BR>
<A NAME="vicidial_inbound_groups-qc_web_form_address">
<BR>
<B>QC WebForm Address -</B> This is the website address that a QC agent can go to when clicking on the WEBFORM link in the QC screen.

<BR>
<A NAME="vicidial_inbound_groups-qc_script">
<BR>
<B>QC Script -</B> This is the script that can be used by QC agents in the SCRIPT tab in the QC screen.

<BR>
<A NAME="vicidial_inbound_groups-hold_recall_xfer_group">
<BR>
<B>Hold Recall Transfer In-Group -</B> If a customer calls back to this in-group more than once and this is not set to NONE, then the call will automatically be sent on to the In-Group selected in this field. Default is NONE.

<BR>
<A NAME="vicidial_inbound_groups-no_delay_call_route">
<BR>
<B>No Delay Call Route -</B> Setting this to Y will remove all wait times and audio prompts and attempt to send the call right to an agent. Does not override welcome message or on hold prompt settings. Default is N.




<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_INBOUND_DIDS TABELLA</FONT></B><BR><BR>
<BR>
<A NAME="vicidial_inbound_dids-did_pattern">
<BR>
<B>DID Extension -</B> This is the number, extension or DID that will trigger this entry and that you will route within the system using this function.

<BR>
<A NAME="vicidial_inbound_dids-did_description">
<BR>
<B>DID Description -</B> This is the description of the DID routing entry.

<BR>
<A NAME="vicidial_inbound_dids-did_active">
<BR>
<B>DID Active -</B> This the field where you set the DID entry to active or not. Default is Y.

<BR>
<A NAME="vicidial_inbound_dids-did_route">
<BR>
<B>DID Route -</B> This the type of route that you set the DID to use. EXTEN will send calls to the extension entered below, VOICEMAIL will send calls directly to the voicemail box entered below, AGENT will send calls to a VICIDIAL agent if they are logged in, PHONE will send the call to a phones entry selected below, IN_GROUP will send calls directly to the specified inbound group. Default is EXTEN.

<BR>
<A NAME="vicidial_inbound_dids-extension">
<BR>
<B>Extension -</B> If EXTEN is selected as the DID Route, then this is the dialplan extension that calls will be sent to. Default is 9998811112, no-service.

<BR>
<A NAME="vicidial_inbound_dids-exten_context">
<BR>
<B>Extension Context -</B> If EXTEN is selected as the DID Route, then this is the dialplan context that calls will be sent to. Default is default.

<BR>
<A NAME="vicidial_inbound_dids-voicemail_ext">
<BR>
<B>Buzon de voz -</B> If VOICEMAIL is selected as the DID Route, then this is the voicemail box that calls will be sent to. Default is empty.

<BR>
<A NAME="vicidial_inbound_dids-phone">
<BR>
<B>Phone Extension -</B> If PHONE is selected as the DID Route, then this is the phone extension that calls will be sent to.

<BR>
<A NAME="vicidial_inbound_dids-server_ip">
<BR>
<B>Phone IP Server -</B> If PHONE is selected as the DID Route, then this is the server IP for the phone extension that calls will be sent to.

<BR>
<A NAME="vicidial_inbound_dids-user">
<BR>
<B>User Agent -</B> If AGENT is selected as the DID Route, then this is the VICIDIAL Agent that calls will be sent to.

<BR>
<A NAME="vicidial_inbound_dids-user_unavailable_action">
<BR>
<B>User Unavailable Action -</B> If AGENT is selected as the DID Route, and the user is not logged in or available, then this is the route that the calls will take.

<BR>
<A NAME="vicidial_inbound_dids-user_route_settings_ingroup">
<BR>
<B>User Route Settings In-Group -</B> If AGENT is selected as the DID Route, then this is the In-Group that will be used for the queue settings as the caller is waiting to be sent to the agent. Default is AGENTDIRECT.

<BR>
<A NAME="vicidial_inbound_dids-group_id">
<BR>
<B>In-ID Gruppo -</B> If IN_GROUP is selected as the DID Route, then this is the In-Group that calls will be sent to.

<BR>
<A NAME="vicidial_inbound_dids-call_handle_method">
<BR>
<B>In-Group Call Handle Method -</B> If IN_GROUP is selected as the DID Route, then this is the call handling method used for these calls. CID will add a new lead record with every call using the CallerID as the phone number, CIDLOOKUP will attempt to lookup the phone number by the CallerID in the entire system, CIDLOOKUPRL will attampt to lookup the phone number by the CallerID in only one specified list, CIDLOOKUPRC will attampt to lookup the phone number by the CallerID in all of the lists that belong to the specified campaign, CLOSER is specified for VICIDIAL Closer calls, ANI will add a new lead record with every call using the ANI as the phone number, ANILOOKUP will attempt to lookup the phone number by the ANI in the entire system, ANILOOKUPRL will attampt to lookup the phone number by the ANI in only one specified list, XDIGITID will prompt the caller for an X digit code before the call will be put into the queue. Default is CID.

<BR>
<A NAME="vicidial_inbound_dids-agent_search_method">
<BR>
<B>In-Group Agent Search Method -</B> If IN_GROUP is selected as the DID Route, then this is the agent search method to be used by the inbound group, LO is Load-Balanced-Overflow and will try to send the call to an agent on the local server before trying to send it to an agent on another server, LB is Load-Balanced and will try to send the call to the next agent no matter what server they are on, SO is Server-Only and will only try to send the calls to agents on the server that the call came in on. Default is LB.

<BR>
<A NAME="vicidial_inbound_dids-list_id">
<BR>
<B>In-Group ID Lista -</B> If IN_GROUP is selected as the DID Route, then this is the ID Lista that leads may be searched through and that leads will be inserted into if necessary.

<BR>
<A NAME="vicidial_inbound_dids-campaign_id">
<BR>
<B>In-ID Gruppo Campagna -</B> If IN_GROUP is selected as the DID Route, then this is the ID Campagna that leads may be searched for in if the call handle method is CIDLOOKUPRC.

<BR>
<A NAME="vicidial_inbound_dids-phone_code">
<BR>
<B>In-Group Phone Code -</B> If IN_GROUP is selected as the DID Route, then this is the Phone Code used if a new lead is created.




<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_REMOTE_AGENTS TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_remote_agents-user_start">
<BR>
<B>Comienzo de la identificacio`n del usuario -</B> esta es la identificacio`n del usuario que comienza se utiliza que cuando las entradas alejadas del agente se insertan en el sistema. Si el número de líneas se fija más altamente de 1, este número es incrementado por uno hasta que cada línea tiene una entrada. Se cerciora de usted crear una nueva cuenta del usuario de VICIDIAL con un nivel de usuario de 4 o grande si usted quisiera que pudieran utilizar la página de vdremote.php para el acceso alejado de la tela de esta cuenta.

<BR>
<A NAME="vicidial_remote_agents-number_of_lines">
<BR>
<B>Número de líneas -</B> el define cuánto crea el agente alejado las entradas el sistema, y se determina cuántas líneas piensa que puede enviar con seguridad al número debajo.

<BR>
<A NAME="vicidial_remote_agents-server_ip">
<BR>
<B>IP del servidor -</B> Una entrada alejada del agente es solamente buena para un servidor específico, aquí es donde usted selecciona a que el servidor usted desea.

<BR>
<A NAME="vicidial_remote_agents-conf_exten">
<BR>
<B>Extension externa -</B> este es el número que usted desea las llamadas remitidas a. Cercio`rese de que sea un número dial plan completo y que si usted necesita 9 al principio usted lo pone adentro aquí. Pruebe marcando este número de un telefono en el sistema.

<BR>
<A NAME="vicidial_remote_agents-status">
<BR>
<B>Estado -</B> aquí es donde usted da vuelta al agente alejado por intervalos. Tan pronto como el agente sea activo el sistema asume que puede enviarle llamadas. Puede tomar hasta 30 segundos una vez que usted cambie el estado a inactivo para parar el recibir de llamadas.

<BR>
<A NAME="vicidial_remote_agents-campaign_id">
<BR>
<B>Campaña -</B> aquí es donde usted selecciona la campaña que estos agentes alejados serán registrados en. Necesidades de entrada de utilizar la campaña MÁS CERCANA y de seleccionar las campañas de entrada debajo de e`sa que usted desea recibir llamadas de.

<BR>
<A NAME="vicidial_remote_agents-closer_campaigns">
<BR>
<B>Grupos de entrada -</B> aquí es donde usted selecciona a grupos de entrada que usted desea recibir llamadas de si usted ha seleccionado la campaña MÁS CERCANA.


<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_CAMPAIGN_LISTE</FONT></B><BR><BR>
<A NAME="vicidial_campaign_lists">
<BR>
<B>Las listas dentro de esta campaña se enumeran aquí, si son activas son denotadas por la Y o N y usted pueden ir a la pantalla de la lista chascando en la identificacio`n de la lista en la primera columna.</B>


<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_CAMPAIGN_STATUSES TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_campaign_statuses">
<BR>
<B>Con el uso de los estados de encargo de la campaña, usted puede tener estados que existan solamente para una campaña específica. El estado debe ser 1-8 caracteres en longitud, la descripcio`n debe ser 2-30 caracteres en longitud y seleccionable define si demuestra para arriba en VICIDIAL como disposicion. Human_answered el campo se utiliza al calcular el porcentaje de lagota, o la tarifa del abandono. El ajuste human_answered a Yutilizará este estado al contar las llamadas humano-contestadas. La opcio`n de la categoría permite que usted agrupe varios estados enun catogy que se pueda utilizar para el análisis estadístico.</B>



<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_CAMPAIGN_HOTKEYS TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_campaign_hotkeys">
<BR>
<B>Con el uso de los hot keys de encargo de la campaña, los agentes que utilizan el retraso vicidial de la lata del tela-cliente y la disposicion llama apenas presionando una sola llave en su teclado.</B> Hay dos opciones especiales que usted puede utilizar conjuntamente conel número de telefono alterno que marca, ALTPH2 de HotKey - el dialcaliente del telefono alterno y el dial caliente ADDR3-----Address3permiten que un agente utilice un hotkey al retraso su llamada,permanecen en el mismo plomo, y marcan otro número del contacto deese conducen. 





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_LEAD_RECYCLE TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_lead_recycle">
<BR>
<B>Through the use of lead recycling, you can call specific statuses of leads again at a specified interval without resetting the entire list. Lead recycling is campaign-specific and does not have to be a selected dialable status in your campaign. The attempt delay field is the number of seconds until the lead can be placed back in the hopper, this number must be at least 120 seconds. The attempt maximum field is the maximum number of times that a lead of this status can be attempted before the list needs to be reset, this number can be from 1 to 10. You can activate and deactivate a lead recycle entry with the provided links.</B>





<BR><BR><BR><BR>

<B><FONT SIZE=3>ESTADOS AUTO DEL DIAL DE VICIDIAL ALT</FONT></B><BR><BR>
<A NAME="vicidial_auto_alt_dial_statuses">
<BR>
<B>Si se fija el campo que marca del Alt-Nu`mero auto, despue`s losplomos que son dispositioned bajo estos estados del dial del alt delautomo`vil tendrán su alt_phone y-o los campos address3 marcadosdespue`s de que cualesquiera de estos ninguno-contesten a estados sefijan.</B>





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL CODICI PAUSA OPERATORE</FONT></B><BR><BR>
<A NAME="vicidial_pause_codes">
<BR>
<B>Si la pausa del agente cifra el campo activo se fija a activo entonceslos agentes podrá seleccionar de estos co`digos de la pausa cuandochascan encendido el boton de PAUSA en sus pantallas. Estos datosentonces se almacenan en el registro vicidial del agente. El co`digode la pausa debe contener solamente letras y números y ser menos de 7caracteres de largo. El nombre del co`digo de la pausa puede estar nomás de largo de 30 caracteres.</B>





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_USER_GROUPS TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_user_groups-user_group">
<BR>
<B>Grupo de usuario -</B> este es el nombre corto de un grupo de usuario de Vicidial, intento para no utilizar ningunos espacios o puntuacio`n para los caracteres de este máximo 20 del campo, mínimo de 2 caracteres.

<BR>
<A NAME="vicidial_user_groups-group_name">
<BR>
<B>Nombre de grupo -</B> esta es la descripcio`n del máximo vicidial del grupo de usuario de 40 caracteres.

<BR>
<A NAME="vicidial_user_groups-group_shifts">
<BR>
<B>Group Shifts -</B> This is a selectable list of shifts that can restrict the agents login time on the system.

<BR>
<A NAME="vicidial_user_groups-allowed_campaigns">
<BR>
<B>Campañas permitidas -</B> esta es una lista seleccionable de lascampañas a las cuales los miembros de este grupo de usuario puedenabrirse una sesio`n. La opcio`n de ALL-CAMPAIGNS permite que losusuarios en este grupo consideren y se abran una sesio`n a cualquiercampaña en el sistema.

<BR>
<A NAME="vicidial_user_groups-qc_allowed_campaigns">
<BR>
<B>QC Campagne Permesse -</B> This is a selectable list of Campagne which members of this user group will be able to QC. The ALL-CAMPAIGNS option allows the users in this group to QC any campaign on the system.

<BR>
<A NAME="vicidial_user_groups-qc_allowed_inbound_groups">
<BR>
<B>QC Grupos De entrada Permitidos -</B> This is a selectable list of Gruppi Inbound which members of this user group will be able to QC. The ALL-GROUPS option allows the users in this user group to QC any inbound group on the system.





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_SCRIPT TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_scripts-script_id">
<BR>
<B>Identificacio`n de la escritura -</B> este es el nombre corto de una escritura de Vicidial. este necesita ser un identificador único. Intente no utilizar ningunos espacios o puntuacio`n para los caracteres de este máximo 10 del campo, mínimo de 2 caracteres.

<BR>
<A NAME="vicidial_scripts-script_name">
<B>Nombre de la escritura -</B> este es el título de una escritura de Vicidial. este es un resumen corto de los caracteres del máximo 50 de la escritura, mínimo de 2 caracteres. No debe haber espacios o puntuacio`n de la clase en campo de los theis.

<BR>
<A NAME="vicidial_scripts-script_comments">
<B>Comentarios de la escritura -</B> este es tal como donde usted puede poner los comentarios para una escritura de Vicidial - cambiantes para liberar mejora de sept. el 23 -. caracteres del máximo 255, mínimo de 2 caracteres.

<BR>
<A NAME="vicidial_scripts-script_text">
<B>Testo Script -</B> This is where you place the content of a Vicidial Script. Minimum of 2 characters. You can have customer information be auto-populated in this script using "--A--field--B--" where field is one of the following fieldnames: vendor_lead_code, source_id, list_id, gmt_offset_now, called_since_last_reset, phone_code, phone_number, title, first_name, middle_initial, last_name, address1, address2, address3, city, state, province, postal_code, country_code, gender, date_of_birth, alt_phone, email, security_phrase, comments, lead_id, campaign, phone_login, group, channel_group, SQLdate, epoch, uniqueid, customer_zap_channel, server_ip, SIPexten, session_id. For example, this sentence would print the persons name in it----<BR><BR>  Hello, can I speak with --A--first_name--B-- --A--last_name--B-- please? Well hello --A--title--B-- --A--last_name--B-- how are you today?<BR><BR> This would read----<BR><BR>Hello, can I speak with John Doe please? Well hello Mr. Doe how are you today?<BR><BR> You can also use an iframe to load a separate window within the SCRIPT tab, here is an example with prepopulated variables:

<DIV style="height:200px;width:400px;background:white;overflow:scroll;font-size:12px;font-family:sans-serif;" id=iframe_example>
&#60;iframe src="http://astguiclient.sf.net/test_VICIDIAL_output.php?lead_id=--A--lead_id--B--&#38;vendor_id=--A--vendor_lead_code--B--&#38;list_id=--A--list_id--B--&#38;gmt_offset_now=--A--gmt_offset_now--B--&#38;phone_code=--A--phone_code--B--&#38;phone_number=--A--phone_number--B--&#38;title=--A--title--B--&#38;first_name=--A--first_name--B--&#38;middle_initial=--A--middle_initial--B--&#38;last_name=--A--last_name--B--&#38;address1=--A--address1--B--&#38;address2=--A--address2--B--&#38;address3=--A--address3--B--&#38;city=--A--city--B--&#38;state=--A--state--B--&#38;province=--A--province--B--&#38;postal_code=--A--postal_code--B--&#38;country_code=--A--country_code--B--&#38;gender=--A--gender--B--&#38;date_of_birth=--A--date_of_birth--B--&#38;alt_phone=--A--alt_phone--B--&#38;email=--A--email--B--&#38;security_phrase=--A--security_phrase--B--&#38;comments=--A--comments--B--&#38;user=--A--user--B--&#38;campaign=--A--campaign--B--&#38;phone_login=--A--phone_login--B--&#38;fronter=--A--fronter--B--&#38;closer=--A--user--B--&#38;group=--A--group--B--&#38;channel_group=--A--group--B--&#38;SQLdate=--A--SQLdate--B--&#38;epoch=--A--epoch--B--&#38;uniqueid=--A--uniqueid--B--&#38;customer_zap_channel=--A--customer_zap_channel--B--&#38;server_ip=--A--server_ip--B--&#38;SIPexten=--A--SIPexten--B--&#38;session_id=--A--session_id--B--&#38;phone=--A--phone--B--" style="width:580;height:290;background-color:transparent;" scrolling="auto" frameborder="0" allowtransparency="true" id="popupFrame" name="popupFrame" width="460" height="290" STYLE="z-index:17"&#62;
&#60;/iframe&#62;
</DIV>

<BR>
<A NAME="vicidial_scripts-active">
<BR>
<B>Activo -</B> esto se determina si esta escritura se puede seleccionar para ser utilizado por una campaña.





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_LEAD_FILTRI TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_lead_filters-lead_filter_id">
<BR>
<B>Identificacio`n del filtro -</B> este es el nombre corto de un filtro del plomo de Vicidial. este necesita ser un identificador único. No utilice ningunos espacios o puntuacio`n para los caracteres de este máximo 10 del campo, mínimo de 2 caracteres.

<BR>
<A NAME="vicidial_lead_filters-lead_filter_name">
<B>Nombre del filtro -</B> este es un nombre más descriptivo del filtro. este es un resumen corto de los caracteres del máximo 30 del filtro, mínimo de 2 caracteres.

<BR>
<A NAME="vicidial_lead_filters-lead_filter_comments">
<B>El filtro comenta -</B> aquí es tal como donde usted puede poner los comentarios para un filtro de Vicidial - las llamadas todos los plomos de California -. los caracteres del máximo 255, mínimo de 2 caracteres.

<BR>
<A NAME="vicidial_lead_filters-lead_filter_sql">
<B>Filtro SQL -</B> Aquí es adonde usted pone el fragmento de la pregunta del SQL que usted desea filtrar cerca no comienza o el extremo con Y, eso será agregado por la escritura del cron de la tolva automáticamente. una pregunta del SQL del ejemplo que trabajaría aquí es el called_count 4 y called_count.





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_ORARI CHIAMATA TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_call_times-call_time_id">
<BR>
<B>Identificacio`n del tiempo de la llamada -</B> este es el nombre corto deuna definicio`n del tiempo de la llamada de Vicidial. este necesitaser un identificador único. No utilice ningunos espacios opuntuacio`n para los caracteres de este máximo 10 del campo, mínimode 2 caracteres.

<BR>
<A NAME="vicidial_call_times-call_time_name">
<B>Nombre del tiempo de la llamada -</B> este es un nombre más descriptivode la definicio`n del tiempo de la llamada. este es un resumen cortode los caracteres del máximo 30 de la definicio`n del tiempo de lallamada, mínimo de 2 caracteres.

<BR>
<A NAME="vicidial_call_times-call_time_comments">
<B>El tiempo de la llamada comenta -</B> aquí es donde usted puede poner loscomentarios para una definicio`n del tiempo de la llamada de Vicidialtal como -10am hasta los 4pm con restricciones adicionales del estadode la llamada -. los caracteres del máximo 255.

<BR>
<A NAME="vicidial_call_times-ct_default_start">
<B>Tiempos del comienzo y de parada del defecto -</B> este es el tiempo dedefecto paran que el llamar será permitido que sea comenzado o dentrode esta definicio`n del tiempo de la llamada si la hora de salida dela di`a-de-$$$-SEMANA no se define. 0 es medianoche. Evitar el llamarfijo` totalmente este campo a 2400 y fijo` el tiempo de parada deldefecto a 2400. Permitir el llamar 24 horas al día fijo` la hora desalida a 0 y el tiempo de parada a 2400.

<BR>
<A NAME="vicidial_call_times-ct_sunday_start">
<B>Tiempos del comienzo y de parada del día laborable -</B> estos son lostiempos de encargo por el día que se puede fijar para la definicio`ndel tiempo de la llamada que las mismas reglas se aplican como con lostiempos del comienzo y de parada del defecto.

<BR>
<A NAME="vicidial_call_times-ct_state_call_times">
<B>Definiciones del tiempo de la llamada del estado -</B> esta es la listade las definiciones específicas del tiempo de la llamada del estadoque se siguen en esta definicio`n del tiempo de la llamada.

<BR>
<A NAME="vicidial_call_times-state_call_time_state">
<B>Estado del tiempo de la llamada del estado -</B> este es el co`digo dedos letras para el estado que esta definicio`n del tiempo que llamaestá para. Para que esto sea en efecto la llamada local mida eltiempo que se fija en la campaña debe tener este expediente deltiempo de la llamada del estado en e`l así como todos los plomos quetienen dos co`digos del estado de la letra en ellos.




<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_SHIFTS TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_shifts-shift_id">
<BR>
<B>Shift ID -</B> This is the short name of a Vicidial Shift Definition. This needs to be a unique identifier. Do not use any spaces or punctuation for this field. max 20 characters, minimum of 2 characters.

<BR>
<A NAME="vicidial_shifts-shift_name">
<B>Shift Name -</B> This is a more descriptive name of the Shift Definition. This is a short summary of the Shift definition. max 50 characters, minimum of 2 characters.

<BR>
<A NAME="vicidial_shifts-shift_start_time">
<B>Shift Start Time -</B> This is the time that the campaign shift begins. Must only be numbers, 9:30 AM would be 0930 and 5:00 PM would be 1700.

<BR>
<A NAME="vicidial_shifts-shift_length">
<B>Shift Length -</B> This is the time in Hours and Minutes that the campaign shift lasts. 8 hours would be 08:00 and 7 hours and 30 minutes would be 07:30.

<BR>
<A NAME="vicidial_shifts-shift_weekdays">
<B>Shift Weekdays -</B> In this section you should choose the days of the week that this shift is active.




<BR><BR><BR><BR>

<B><FONT SIZE=3>FUNCIONALIDAD DEL CARGADOR DE LA LISTA DE VICIDIAL</FONT></B><BR><BR>
<A NAME="vicidial_list_loader">
<BR>
El cargador tela-basado básico del plomo de VICIDIAL se diseñasimplemente para tomar un archivo del plomo - hasta 8MB de tamaño quees la lengüeta o la pipa delimitada y para cargarlo en la tabla delvicidial_list. El cargador del plomo permite el campo que elige y deTXT- el texto claramente, los valores separados coma de CSV- y XLS-sobresalen formatos del archivo. El cargador del plomo no hace lavalidacio`n de datos, sino que permite que usted compruebe para sabersi hay duplicados en sí mismo, dentro de la campaña o dentro delsistema entero. Tambien, cercio`rese de que usted haya creado lalista que estos plomos son estar debajo de modo que usted puedautilizarlos. Aquí está una lista de los campos en su orden apropiadapara los archivos del plomo:
	<OL>
	<LI>Co`digo del plomo del vendedor - demuestra para arriba en el campo de la identificacio`n del vendedor del GUI
	<LI>Co`digo de fuente - uso interno solamente para los admins y DBAs
	<LI>Identificacio`n de la lista - el número de la lista que estos plomos demostrarán para arriba debajo
	<LI>Co`digo del telefono - el prefijo para el telefono number(1 para los E.E.U.U., 01144 para Reino Unido, 01161 para AUS, el etc)
	<LI>Número de telefono - debe ser por lo menos 8 dígitos de largo
	<LI>Título - título del customer(Mr. Ms señ., etc...)
	<LI>Nome
	<LI>Secondo Nome
	<LI>Cognome
	<LI>Indirizzo, linea 1
	<LI>Indirizzo, linea 2
	<LI>Indirizzo, linea 3
	<LI>Citta`
	<LI>Stato - limitato a 2 caratteri
	<LI>Provincia
	<LI>CAP
	<LI>Stato
	<LI>Sesso
	<LI>Data di Nascita
	<LI>Numero di Telefono Alternativo
	<LI>Email
	<LI>Frase De Seguridad
	<LI>Note
	</OL>

<BR>NOTAS: La funcionalidad del cargador del plomo del sobresalir espermitida por una serie de escrituras del Perl y necesita tener unarchivo correctamente configurado de /etc/astguiclient.conf en lugaren el web server. Tambien, los mo`dulos de un Perl de los pares sedeben cargar para ella para trabajar Tambien -oLE-Storage_Lite-Storage_Lite y la Hoja de balance-ParseExcel. Ustedpuede comprobar para saber si hay errores runtime en estos mirando suarchivo del error_log de apache. Tambien, para los cheques deduplicacio`n contra gampaign enumera, la lista que tiene nuevos plomosel entrar e`l necesita ser creada en el sistema antes de que ustedcomience a cargar los plomos.




<BR><BR><BR><BR>






<B><FONT SIZE=3>TABELLA TELEFONI</FONT></B><BR><BR>
<A NAME="phones-extension">
<BR>
<B>Extension del telefono -</B> este campo es donde usted pone los nombres del telefono que aparecen al marcar con asterisco no incluyendo el protocolo o la barra vertical del principio. Por ejemplo: para el telefono SIP/test101 del SIP la extension del telefono sería test101. Tambien, para los telefonos IAX2 compruebe que usted utiliza el nombre del telefono completo: IAX2/IAXphone1@IAXphone1 sería IAXphone1@IAXphone1. Para zap los telefonos compruebe que usted pone el canal completo: Zap/25-1 sería 25-1. Otra nota, compruebe que usted fija el protocolo abajo correctamente para su tipo de telefono.

<BR>
<A NAME="phones-dialplan_number">
<BR>
<B>Número del Dial plan -</B> este campo está para el número que usted marca para tener el anillo del telefono. Este número se define en el archivo de extensions.conf de su servidor asterisco

<BR>
<A NAME="phones-voicemail_id">
<BR>
<B>Caja de Buzon de Voz -</B> este campo es para la caja del Buzon de voz donde van los mensajes para al usuario de este telefono. Utilizamos esto para comprobar los mensajes del Buzon de voz y para que el usuario pueda acceder al Buzon de Voz desde astGUIclient.

<BR>
<A NAME="phones-outbound_cid">
<BR>
<B>CallerID de salida -</B> este campo es donde usted incorporara el número del callerID que usted quiera que aparezca en las llamadas de salida. Esto no funciona en las líneas RTB(non-PRI) T1/E1.

<BR>
<A NAME="phones-phone_ip">
<BR>
<B>Direccion IP del telefono -</B> This field is for the phone's IP address if it is a VOIP phone. This is an optional field

<BR>
<A NAME="phones-computer_ip">
<BR>
<B>Direccion IP del ordenador -</B> This field is for the user's computer IP address. This is an optional field

<BR>
<A NAME="phones-server_ip">
<BR>
<B>IP del servidor -</B> Este menú es donde usted selecciona en que servidor está el telefono activo.

<BR>
<A NAME="phones-login">
<BR>
<B>conexion -</B> la conexion usada para el usuario del telefono a laconexion a los usos del cliente.

<BR>
<A NAME="phones-pass">
<BR>
<B>Contraseña -</B> la contraseña usada para el usuario del telefono a laconexion a los usos del cliente.

<BR>
<A NAME="phones-status">
<BR>
<B>Estado -</B> el estado del telefono en el sistema, puede ser ACTIVO y ADMIN permiten que los clientes del GUI trabajen. ADMIN permite el acceso a este Web site de administracion. El resto de los estados no permiten el acceso al GUI o al Web de Admin.

<BR>
<A NAME="phones-active">
<BR>
<B>Cuenta activa -</B> si el telefono está activado ponerla en la lista del cliente del GUI.

<BR>
<A NAME="phones-phone_type">
<BR>
<B>Tipo de telefono -</B> solamente para informacion administrativas.

<BR>
<A NAME="phones-fullname">
<BR>
<B>Nombre completo -</B> usado por el GUIclient en la lista de telefonos activos.

<BR>
<A NAME="phones-company">
<BR>
<B>Compañía -</B> solamente para las notas administrativas.

<BR>
<A NAME="phones-picture">
<BR>
<B>Cuadro -</B> todavía no puesto en ejecucio`n.

<BR>
<A NAME="phones-messages">
<BR>
<B>Nuevos mensajes -</B> número de los nuevos mensajes del Buzon de Voz para este telefono en el servidor del asterisco.

<BR>
<A NAME="phones-old_messages">
<BR>
<B>Viejos mensajes -</B> número de los viejos mensajes del Buzon de Voz para este telefono en el servidor del asterisco.

<BR>
<A NAME="phones-protocol">
<BR>
<B>Protocolo del cliente -</B> el protocolo que el telefono utiliza para conectar con el servidor del asterisco: El Sip, IAX2, Zap. Tambien, para los números External remotos o los números SpeedDial que usted desea enumerar como telefonos.

<BR>
<A NAME="phones-local_gmt">
<BR>
<B>GMT local -</B> La diferencia a partir del tiempo malo del ZULÚ del time(or de Greenwich) donde se localiza el telefono. NO AJUSTE POR TIEMPO DE LOS AHORROS DE LA LUZ DEL DÍA. Esto es utilizada por la campaña de VICIDIAL para exhibir exactamente el tiempo y el tiempo del cliente.

<BR>
<A NAME="phones-ASTmgrUSERNAME">
<BR>
<B>conexion del encargado -</B> esta es la conexion que los clientes del GUI para este telefono utilizarán tener acceso a la base de datos donde residen los datos del servidor.

<BR>
<A NAME="phones-ASTmgrSECRET">
<BR>
<B>Secreto del encargado -</B> esta es la contraseña que los clientes del GUI para este telefono utilizarán tener acceso a la base de datos donde residen los datos del servidor.

<BR>
<A NAME="phones-login_user">
<BR>
<B>Usuario del defecto de VICIDIAL -</B> este debe poner un valor prefijado en el campo del usuario de VICIDIAL siempre que este usuario del telefono abra a cliente app de astVICIDIAL. Deje el espacio en blanco para ningún usuario.

<BR>
<A NAME="phones-login_pass">
<BR>
<B>Paso del defecto de VICIDIAL -</B> este debe poner un valor prefijado en el campo de la contraseña de VICIDIAL siempre que este usuario del telefono abra a cliente app de astVICIDIAL. Deje el espacio en blanco para ningún paso.

<BR>
<A NAME="phones-login_campaign">
<BR>
<B>Campaña del defecto de VICIDIAL -</B> este debe poner un valor prefijado en el campo de la campaña de VICIDIAL siempre que este usuario del telefono abra a cliente app de astVICIDIAL. Deje el espacio en blanco para ninguna campaña.

<BR>
<A NAME="phones-park_on_extension">
<BR>
<B>Parque Exten -</B> esta es la extension del estacionamiento del defecto para los apps del cliente. Verifique que diverso trabaje antes de que usted cambie esto.

<BR>
<A NAME="phones-conf_on_extension">
<BR>
<B>Extension de la conferencia -</B> esta es la extension del parque de la conferencia del defecto para los apps del cliente. Verifique que diverso trabaje antes de que usted cambie esto.

<BR>
<A NAME="phones-VICIDIAL_park_on_extension">
<BR>
<B>Parque Exten de VICIDIAL -</B> esta es la extension del estacionamiento del defecto para el cliente app de VICIDIAL. Verifique que diverso trabaje antes de que usted cambie esto.

<BR>
<A NAME="phones-VICIDIAL_park_on_filename">
<BR>
<B>Archivo del parque de VICIDIAL -</B> este es el nombre del archivo de la extension del parque del defecto VICIDIAL para los apps del cliente. Verifique que diverso trabaje antes de que usted cambie este limitado a 10 caracteres.

<BR>
<A NAME="phones-monitor_prefix">
<BR>
<B>Prefijo del monitor -</B> este es el prefijo dial plan para supervisar de zap los canales automáticamente dentro del app astGUIclient. Cambie solamente según los expedientes de extensiones de extensions.conf ZapBarge.

<BR>
<A NAME="phones-recording_exten">
<BR>
<B>grabacion Exten -</B> esta es la extension dial plan para la extension de la grabacion que se utiliza para caer en conferencias del meetme para registrarlas. Dura generalmente hasta que una hora si no parada verifica con el archivo de extensions.conf antes de cambiar.

<BR>
<A NAME="phones-voicemail_exten">
<BR>
<B>VMAIL Exten principal -</B> esta es la extension dial plan que va a comprobar su voicemail. verifica con el archivo de extensions.conf antes de cambiar.

<BR>
<A NAME="phones-voicemail_dump_exten">
<BR>
<B>VMAIL Dump Exten -</B> This is the dial plan prefix used to send calls directly to a user's voicemail from a live call in the astGUIclient app. verify with extensions.conf file before changing.

<BR>
<A NAME="phones-ext_context">
<BR>
<B>Contexto de Exten -</B> este es el contexto dial plan que este telefono utiliza sobre todo. Se asume que todos los números marcados por los apps del cliente están utilizando este contexto así que es una buena idea cerciorarse de que este es el contexto más amplio posible verifica con el archivo de extensions.conf antes de cambiar.

<BR>
<A NAME="phones-dtmf_send_extension">
<BR>
<B>DTMF envían el canal -</B> esta es la secuencia del canal usada para enviar sonidos de DTMF en conferencias del meetme de los apps del cliente. Verifique que exten y contexto con el archivo de extensions.conf.

<BR>
<A NAME="phones-call_out_number_group">
<BR>
<B>Grupo de salida de la llamada -</B> este es el grupo de canal que las llamadas de salida de este telefono están puestas de. Hay rutinas de un par en los apps del cliente que utilizan esto. Para zap los canales que usted desea utilizar algo como Zap/g2, porque los troncos IAX2 usted desearía utilizar el prefijo completo de IAX como IAX2/VICItest1:secret@10.10.10.15:4569. Verifique que los troncos con el file(it de extensions.conf sean generalmente lo que usted ha definido como la variable global del TRUNK en la tapa del archivo).

<BR>
<A NAME="phones-client_browser">
<BR>
<B>Localizacio`n del browser -</B> esto es aplicable solamente a los clientes de UNIX/LINUX, el camino absoluto a Mozilla o el browser de Firefox en la máquina verifica esto lanzándolo manualmente.

<BR>
<A NAME="phones-install_directory">
<BR>
<B>Instale el directorio -</B> este es el lugar en donde las escrituras astGUIclient y de astVICIDIAL están situadas en su máquina. Para Win32 debe ser algo como C:\AST_VICI y para UNIX debe ser algo como /usr/local/perl_TK. verifica esto manualmente.

<BR>
<A NAME="phones-local_web_callerID_URL">
<BR>
<B>URL de CallerID -</B> Ústa es la Direccion de la tela de la página usada para hacer operaciones de búsqueda de encargo del callerID que es la Direccion de prueba del defecto: http://astguiclient.sf.net/test_callerid_output.php

<BR>
<A NAME="phones-VICIDIAL_web_URL">
<BR>
<B>URL del defecto de VICIDIAL -</B> esta es la Direccion de la tela de la página usada para hacer preguntas de encargo de la forma del Web de VICIDIAL que es la Direccion de prueba del defecto: http://astguiclient.sf.net/test_VICIDIAL_output.php

<BR>
<A NAME="phones-AGI_call_logging_enabled">
<BR>
<B>Call Logging -</B> This is set to true if the call_log.agi file is in place in the extensions.conf file for all outbound and hang up 'h' extensions to log all calls. This should always be 1 because it is manditory for many astGUIclient and VICIDIAL features to work properly.

<BR>
<A NAME="phones-user_switching_enabled">
<BR>
<B>Cambio de Usuario -</B> Set to true to allow user to switch to another user account. NOTE: If user switches they can initiate recording on the new user's phone conversation

<BR>
<A NAME="phones-conferencing_enabled">
<BR>
<B>Comunicacio`n -</B> fije para verdad para permitir que el usuario comience llamadas de conferencia con hasta que seis líneas externas.

<BR>
<A NAME="phones-admin_hangup_enabled">
<BR>
<B>Retraso del Admin -</B> sistema a verdad para permitir que el usuario pueda al retraso cualquier línea en la voluntad con astGUIclient. Buena idea de permitir solamente esto para los usuarios del Admin.

<BR>
<A NAME="phones-admin_hijack_enabled">
<BR>
<B>Secuestro del Admin -</B> fije para verdad para permitir que el usuario pueda asir y volver a dirigir a su extension cualquier línea en la voluntad con astGUIclient. Buena idea de permitir solamente esto para los usuarios del Admin. Pero es muy útil para los encargados.

<BR>
<A NAME="phones-admin_monitor_enabled">
<BR>
<B>Monitor del Admin -</B> fije para verdad para permitir que el usuario pueda asir y volver a dirigir a su extension cualquier línea en la voluntad con astGUIclient. Buena idea de permitir solamente esto para los usuarios del Admin. Pero es muy útil para los encargados y como herramienta del entrenamiento.

<BR>
<A NAME="phones-call_parking_enabled">
<BR>
<B>Parque de llamada -</B> el sistema a verdad para permitir que el usuario pueda parquear invita el asimiento astGUIclient para ser tomado por cualquier otro usuario astGUIclient en el sistema. Las llamadas permanecen en el asimiento para hasta que un retraso de la media-hora entonces. Permitido generalmente para todos.

<BR>
<A NAME="phones-updater_check_enabled">
<BR>
<B>Cheque de Updater -</B> fije para verdad para exhibir una advertencia del popup que el tiempo del updater no ha cambiado en 20 segundos. Útil para los usuarios del Admin.

<BR>
<A NAME="phones-AFLogging_enabled">
<BR>
<B>AF Logging -</B> Set to true to log many actions of astGUIclient usage to a text file on the user's computer.

<BR>
<A NAME="phones-QUEUE_ACTION_enabled">
<BR>
<B>La coleta permitio` -</B> al sistema verdad para hacer que los apps del cliente utilicen el sistema central de la coleta del asterisco. Requerido para VICIDIAL y recomendado para todos los usuarios.

<BR>
<A NAME="phones-CallerID_popup_enabled">
<BR>
<B>Ventana emergente del CallerID -</B> sistema a verdad para tener en cuenta los números definidos en el archivo de extensions.conf para enviar las pantallas del popup de CallerID a los usuarios astGUIclient.

<BR>
<A NAME="phones-voicemail_button_enabled">
<BR>
<B>Boto`n de VMail -</B> fije para verdad para exhibir el boton de VOICEMAIL y los mensajes cuentan la exhibicio`n en astGUIclient.

<BR>
<A NAME="phones-enable_fast_refresh">
<BR>
<B>Rápido restaure -</B> fije para verdad para permitir un nuevo índice de restauran de la informacion de la llamada para el astGUIclient. La tarifa inhabilitada defecto es el ms 1000 (1 segundo). Puede aumentar la carga de sistema si usted baja este número.

<BR>
<A NAME="phones-fast_refresh_rate">
<BR>
<B>Rápido restaure la tarifa -</B> en milisegundos. Utilizado solamente si es rápido restaure se permite. La tarifa inhabilitada defecto es el ms 1000 (1 segundo). Puede aumentar la carga de sistema si usted baja este número.

<BR>
<A NAME="phones-enable_persistant_mysql">
<BR>
<B>Persistant MySQL -</B> si está permitida la conexion astGUIclient seguirá conectada en vez de conectar cada segundo. Útil si usted hace que un rápido restaure la tarifa fijada. Aumentará el número de conexiones en su máquina de MySQL.

<BR>
<A NAME="phones-auto_dial_next_number">
<BR>
<B>Número siguiente del dial auto -</B> si está permitido el cliente de VICIDIAL marcará el número siguiente en la lista automáticamente sobre la disposicion de una llamada a menos que seleccionaran "para parar el marcar" en la pantalla de la disposicion.

<BR>
<A NAME="phones-VDstop_rec_after_each_call">
<BR>
<B>Pare Rec despue`s de cada llamada -</B> si está permitido el cliente de VICIDIAL parará se está encendiendo cualquier grabacion despue`s de que haya sido cada llamada dispositioned. Útil si usted está haciendo muchos de la grabacion o usted están utilizando una forma de la tela para accionar la grabacion.

<BR>
<A NAME="phones-enable_sipsak_messages">
<BR>
<B>Permita los mensajes de SIPSAK -</B> si está permitido el servidorenviará mensajes al telefono del SIP a la exhibicio`n en laexhibicio`n del LCD del telefono cuando está registrado en VICIDIAL.La característica trabaja solamente con los telefonos del SIP yrequiere el uso del sipsak ser instalada en el web server. El defectoes 0.

<BR>
<A NAME="phones-DBX_server">
<BR>
<B>Servidor de DBX -</B> el servidor de la base de datos de MySQL con el cual este usuario debe conectar.

<BR>
<A NAME="phones-DBX_database">
<BR>
<B>Base de datos de DBX -</B> la base de datos de MySQL con la cual este usuario debe conectar. El defecto es asterisco.

<BR>
<A NAME="phones-DBX_user">
<BR>
<B>Usuario de DBX -</B> la conexion del usuario de MySQL que este usuario debe utilizar al conectar. El defecto es cron.

<BR>
<A NAME="phones-DBX_pass">
<BR>
<B>Paso de DBX -</B> la contraseña del usuario de MySQL que este usuario debe utilizar al conectar. El defecto es 1234.

<BR>
<A NAME="phones-DBX_port">
<BR>
<B>DBX viran -</B> el puerto de MySQL hacia el lado de babor TCP que este usuario debe utilizar al conectar. El defecto es 3306.

<BR>
<A NAME="phones-DBY_server">
<BR>
<B>Servidor de DBY -</B> el servidor de la base de datos de MySQL con el cual este usuario debe conectar. Secondario server, non utilizzato attualmente.

<BR>
<A NAME="phones-DBY_database">
<BR>
<B>Base de datos de DBY -</B> la base de datos de MySQL con la cual este usuario debe conectar. El defecto es asterisco. Secondario server, non utilizzato attualmente.

<BR>
<A NAME="phones-DBY_user">
<BR>
<B>Usuario de DBY -</B> la conexion del usuario de MySQL que este usuario debe utilizar al conectar. El defecto es cron. Secondario server, non utilizzato attualmente.

<BR>
<A NAME="phones-DBY_pass">
<BR>
<B>Paso de DBY -</B> la contraseña del usuario de MySQL que este usuario debe utilizar al conectar. El defecto es 1234. Secondario server, non utilizzato attualmente.

<BR>
<A NAME="phones-DBY_port">
<BR>
<B>DBY viran -</B> el puerto de MySQL hacia el lado de babor TCP que este usuario debe utilizar al conectar. El defecto es 3306. Secondario server, non utilizzato attualmente.

<BR>
<A NAME="phones-alias_id">
<BR>
<B>Alias ID -</B> The ID of the alias used to allow for phone load balanced logins. senza spazi or other special characters allowed. Must be between 2 and 20 characters in length.

<BR>
<A NAME="phones-alias_name">
<BR>
<B>Alias Name -</B> The name used to describe a phones alias, Must be between 2 and 50 characters in length.

<BR>
<A NAME="phones-logins_list">
<BR>
<B>Phones Logins List -</B> The comma separated list of phone logins used when an agent logs in using phone load balanced logins. The Agent application will find the active server with the fewest agents logged into it and place a call from that server to the agent upon login.

<BR>
<A NAME="phones-email">
<BR>
<B>Phones Email -</B> The email address associated with this phone entry. This is used for voicemail settings.



<BR><BR><BR><BR>

<B><FONT SIZE=3>TABELLA SERVER</FONT></B><BR><BR>
<A NAME="servers-server_id">
<BR>
<B>ID Del Servidor -</B>  Este campo es donde usted pone el nombre del servidor del asterisco, no tiene que ser un submarino oficial del dominio, apenas un apodo para identificar el servidor a los usuarios del Admin.

<BR>
<A NAME="servers-server_description">
<BR>
<B>Descripcio`n del servidor -</B> el campo donde usted utiliza una frase pequeña para describir el servidor del asterisco.

<BR>
<A NAME="servers-server_ip">
<BR>
<B>IP address del servidor -</B> el campo donde usted puso el IP address de la red del servidor del asterisco.

<BR>
<A NAME="servers-active">
<BR>
<B>Activo -</B> fije si el servidor del asterisco es activo o inactivo.

<BR>
<A NAME="servers-asterisk_version">
<BR>
<B>Versione Di Asterisk -</B> Set the version of Asterisk that you have installed on this server. Examples: '1.2', '1.0.8', '1.0.7', 'CVS_HEAD', 'REALLY OLD', etc... This is used because versions 1.0.8 and 1.0.9 have a different method of dealing with Local/ channels, a bug that has been fixed in CVS v1.0, and need to be treated differently when handling their Local/ channels. Also, current CVS_HEAD and the 1.2 release tree uses different manager and command output so it must be treated differently as well.

<BR>
<A NAME="servers-max_vicidial_trunks">
<BR>
<B>Troncos máximos de VICIDIAL -</B> este campo determinará el número de las líneas máximo que el auto-dialer de VICIDIAL procurará invitar este servidor. Si usted desea dedicar dos PRI llenos T1 a VICIDIALing en un servidor entonces usted fijaría esto a 46. E1 defecto es 96.

<BR>
<A NAME="servers-telnet_host">
<BR>
<B>Host Telnet -</B> This is the address or name of the Asterisk server and is how the manager applications connect to it from where they are running. If they are running on the Asterisk server, then the default of 'localhost' is fine.

<BR>
<A NAME="servers-telnet_port">
<BR>
<B>Porta Telnet -</B> This is the port of the Asterisk server Manager connection and is how the manager applications connect to it from where they are running. The default of '5038' is fine for a standard install.

<BR>
<A NAME="servers-ASTmgrUSERNAME">
<BR>
<B>Usuario Del Manager -</B> The username or login used to connect genericly to the Asterisk server manager. Default is 'cron'

<BR>
<A NAME="servers-ASTmgrSECRET">
<BR>
<B>Contraseña del Manager -</B> The secret or password used to connect genericly to the Asterisk server manager. Default is '1234'

<BR>
<A NAME="servers-ASTmgrUSERNAMEupdate">
<BR>
<B>Usuario del Updater del Manager -</B> The username or login used to connect to the Asterisk server manager optimized for the Update scripts. Default is 'updatecron' and assumes the same secret as the generic user.

<BR>
<A NAME="servers-ASTmgrUSERNAMElisten">
<BR>
<B>Usuario Listen del Manager -</B> The username or login used to connect to the Asterisk server manager optimized for scripts that only listen for output. Default is 'listencron' and assumes the same secret as the generic user.

<BR>
<A NAME="servers-ASTmgrUSERNAMEsend">
<BR>
<B>Usuario Send del Manager -</B> The username or login used to connect to the Asterisk server manager optimized for scripts that only send Actions to the manager. Default is 'sendcron' and assumes the same secret as the generic user.

<BR>
<A NAME="servers-local_gmt">
<BR>
<B>Server GMT offset -</B> The difference in hours from GMT time not adjusted for Daylight-Savings-Time of the server. Default is '-5'

<BR>
<A NAME="servers-voicemail_dump_exten">
<BR>
<B>Extension de Vmail Dump  -</B> The extension prefix used on this server to send calls directly through agc to a specific voicemail box. Default is '85026666666666'

<BR>
<A NAME="servers-answer_transfer_agent">
<BR>
<B>Extension del AD de VICIDIAL -</B> The default extension if none is present in the campaign to send calls to for VICIDIAL auto dialing. Default is '8365'

<BR>
<A NAME="servers-ext_context">
<BR>
<B>Contexto por Defecto -</B> The default dial plan context used for scripts that operate for this server. Default is 'default'

<BR>
<A NAME="servers-sys_perf_log">
<BR>
<B>Funcionamiento del sistema -</B> fijar esta opcio`n a Y permitirá laregistracion del stats del funcionamiento del sistema para lamáquina del servidor incluyendo carga de sistema, procesos delsistema y canales del asterisco en uso. El defecto es N.

<BR>
<A NAME="servers-vd_server_logs">
<BR>
<B>Registros del servidor -</B> fijar esta opcio`n a Y permitirá laregistracion de todas las escrituras relacionadas VICIDIAL a susficheros de diario del texto. Fijar esto a N parará registros de laescritura a los archivos para estos procesos, Tambien laregistracion de la pantalla del asterisco será lisiado si esto sefija a N cuando se comienza el asterisco. El defecto es Y.

<BR>
<A NAME="servers-agi_output">
<BR>
<B>AGI hecho salir -</B> fijar esta opcio`n a NINGUNOS inhabilitará salidade todas las escrituras relacionadas VICIDIAL de AGI. Fijar esto aSTDERR enviará el AGI hecho salir al asterisco CLI. Fijar esto alARCHIVO enviará la salida a un archivo en el directorio de losregistros. Fijar esto a AMBOS enviará salida al asterisco CLI y a unfichero de diario. El defecto es ARCHIVO.

<BR>
<A NAME="servers-vicidial_balance_active">
<BR>
<B>El marcar del balance de VICIDIAL -</B> fijar este campo a Y permitiráque el servidor ponga las llamadas del balance para las campañas enVICIDIAL para poder resolver el nivel definido del dial incluso si nohay agentes registrados en esa campaña en este servidor. El defectoes N.

<BR>
<A NAME="servers-balance_trunks_offlimits">
<BR>
<B>Balance Offlimits de VICIDIAL -</B> este ajuste define el número detroncos para no permitir el balance de VICIDIAL que marca parautilizar. Por ejemplo si usted tiene 40 troncos y offlimits vicidialmáximos del balance se fijan a 10 que usted podrá solamenteutilizar 30 líneas interurbanas para marcar del balance de VICIDIAL.El defecto es 0.


<BR><BR><BR><BR>

<B><FONT SIZE=3>TABLA DE CONFERENCIAS</FONT></B><BR><BR>
<A NAME="conferences-conf_exten">
<BR>
<B>Número de la conferencia -</B> este campo es donde usted pone el número del dialpna de la conferencia del meetme. Tambien se recomienda que el número del meetme en meetme.conf empareja este número para cada entrada. Esto está para las conferencias en astGUIclient y se utiliza para la funcionalidad de leave-3way-call en VICIDIAL.

<BR>
<A NAME="conferences-server_ip">
<BR>
<B>IP del servidor -</B> El menú donde usted selecciona el servidor del asterisco que esta conferencia estará encendido.




<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_SERVER_TRUNKS TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_server_trunks">
<BR>
<B>Los troncos del servidor de VICIDIAL permiten que usted restrinja laslíneas salientes que se utilizan en este servidor para la campañaque marca sobre una base de la por-campaña. Usted tiene la opcio`npara reservar un número de las líneas específico que se utilizaránpor solamente una campaña así como permitir que esa campañafuncione sobre sus líneas reservadas en cualesquiera líneas siguensiendo abiertas, según lo en las líneas totales usadas por vicidialen este servidor es de largo menos que fijar de los troncos delmáximo VICIDIAL. No tener cualesquiera de estos expedientespermitirá la campaña que marca la línea primero para tener tantaslíneas mientras que puede conseguir bajo fijar de los troncos delmáximo VICIDIAL.</B>





<BR><BR><BR><BR>

<B><FONT SIZE=3>SYSTEM_SETTINGS TABELLA</FONT></B><BR><BR>
<A NAME="settings-use_non_latin">
<BR>
<B>Uso No-Latino -</B> esta opcio`n permite que usted omita la escritura dela exhibicio`n de la tela los caracteres del uso UTF8 y que no haganinguna expresio`n regular de la latino-cara`cter-familia que sefiltra ni que no exhiba el formato. El defecto es 0.

<BR>
<A NAME="settings-webroot_writable">
<BR>
<B>Webroot escribible -</B> este ajuste permite que usted defina si losarchivos de la temperatura y los archivos de la autentificacio`n seancolocados en el webroot en su web server. El defecto es 1.

<BR>
<A NAME="settings-enable_queuemetrics_logging">
<BR>
<B>Permita la registracion de QueueMetrics -</B> este ajuste permite queusted defina si VICIDIAL inserte entradas del registro en la tabla dela base de datos del queue_log como lo hace la actividad de lascoletas del asterisco. QueueMetrics es un independiente, programa delanálisis estadístico de la cerrado-fuente. Usted debe tenerQueueMetrics instalado y configurado ya antes de permitir estacaracterística. El defecto es 0.

<BR>
<A NAME="settings-queuemetrics_server_ip">
<BR>
<B>IP del servidor de QueueMetrics -</B> este es el IP address de la base dedatos para su instalacio`n de QueueMetrics.

<BR>
<A NAME="settings-queuemetrics_dbname">
<BR>
<B>Nombre de la base de datos de QueueMetrics -</B> este es el nombre de labase de datos para su base de datos de QueueMetrics.

<BR>
<A NAME="settings-queuemetrics_login">
<BR>
<B>conexion de la base de datos de QueueMetrics -</B> este es el nombre delusuario usado para abrirse una sesio`n a su base de datos deQueueMetrics.

<BR>
<A NAME="settings-queuemetrics_pass">
<BR>
<B>Contraseña de la base de datos de QueueMetrics -</B> esta es lacontraseña usada para abrirse una sesio`n a su base de datos deQueueMetrics.

<BR>
<A NAME="settings-queuemetrics_url">
<BR>
<B>URL de QueueMetrics -</B> esta es la Direccion del URL o del Web siteusada para conseguir a su instalacio`n de QueueMetrics.

<BR>
<A NAME="settings-queuemetrics_log_id">
<BR>
<B>Identificacio`n del registro de QueueMetrics -</B> esta es laidentificacio`n del servidor que todos los registros de VICIDIAL queentran la base de datos de QueueMetrics utilizarán como identificadorpara cada expediente.

<BR>
<A NAME="settings-queuemetrics_eq_prepend">
<BR>
<B>QueueMetrics EnterQueue prepend -</B> este campo se utiliza para permitirprepending de una de las zonas de informaciones del vicidial_listdelante del número de telefono del cliente para los informesmodificados para requisitos particulares de QueueMetrics. El defectono es NINGUNO no poblar cualquier cosa.

<BR>
<A NAME="settings-vicidial_agent_disable">
<BR>
<B>El agente de VICIDIAL inhabilita la exhibicio`n -</B> este campo seutiliza para seleccionar cuando demostrar a un agente cuando susesio`n ha sido inhabilitada por el sistema, una accio`n del encargadoo por una medida externa. El ajuste de NOT_ACTIVE inhabilitará elmensaje en la pantalla de los agentes. El ajuste de LIVE_AGENTexhibirá solamente el mensaje lisiado cuando se ha quitado elexpediente de los vicidial_auto_calls de los agentes, por ejemplodurante un registro de estado de la máquina de la fuerza o registrode estado de la máquina de la emergencia. 

<BR>
<A NAME="settings-allow_sipsak_messages">
<BR>
<B>Permita los mensajes de SIPSAK -</B> si el sistema a 1, este permite queel ajuste de la tabla de los telefonos trabaje correctamente, elservidor enviará mensajes al telefono del SIP a la exhibicio`n en laexhibicio`n del LCD del telefono cuando está registrado en VICIDIAL.Esta característica trabaja solamente con los telefonos del SIP yrequiere el uso del sipsak ser instalada en el web server. El defectoes 0. 

<BR>
<A NAME="settings-vdc_agent_api_active">
<BR>
<B>Agent API Active -</B> If set to 1, this will allow the Agent API interface to function. Default is 0. 

<BR>
<A NAME="settings-admin_home_url">
<BR>
<B>URL casero del Admin -</B> esta es la Direccion del URL o del Web siteque usted irá si usted chasca encendido el acoplamiento CASERO en latapa de la página de admin.php.

<BR>
<A NAME="settings-enable_agc_xfer_log">
<BR>
<B>Permita el logfile de la transferencia del agente -</B> esta opcio`nregistrará a un logfile del texto en el webserver cada vez que unallamada se transfiere a un agente. El defecto es 0, inhabilitado.

<BR>
<A NAME="settings-timeclock_end_of_day">
<BR>
<B>Timeclock End Of Day -</B> This setting defines when all users are to be auto logged out of the timeclock system. Only runs once a day. must be only 4 digits 2 digit hour and 2 digit minutes in 24 hour time. Default is 0000.

<BR>
<A NAME="settings-timeclock_last_reset_date">
<BR>
<B>Timeclock Last Auto Logout -</B> This field displays the date of the last auto-logout.

<BR>
<A NAME="settings-vdc_header_date_format">
<BR>
<B>Agent Screen Header Date Format -</B> This menu allows you to choose the format of the date that shows up at the top of the VICIDIAL agent screen. The options for this setting are: default is MS_DASH_24HR<BR>
MS_DASH_24HR  2008-06-24 23:59:59 - Default date format with year month day followed by 24 hour time<BR>
US_SLASH_24HR 06/24/2008 23:59:59 - USA date format with month day year followed by 24 hour time<BR>
EU_SLASH_24HR 24/06/2008 23:59:59 - European date format with day month year followed by 24 hour time<BR>
AL_TEXT_24HR  JUN 24 23:59:59 - Text date format with abbreviated month day followed by 24 hour time<BR>
MS_DASH_AMPM  2008-06-24 11:59:59 PM - Default date format with year month day followed by 12 hour time<BR>
US_SLASH_AMPM 06/24/2008 11:59:59 PM - USA date format with month day year followed by 12 hour time<BR>
EU_SLASH_AMPM 24/06/2008 11:59:59 PM - European date format with day month year followed by 12 hour time<BR>
AL_TEXT_AMPM  JUN 24 11:59:59 PM - Text date format with abbreviated month day followed by 12 hour time<BR>

<BR>
<A NAME="settings-vdc_customer_date_format">
<BR>
<B>Agent Screen Customer Date Format -</B> This menu allows you to choose the format of the customer time zone date that shows up at the top of the Customer Information section of the VICIDIAL agent screen. The options for this setting are: default is AL_TEXT_AMPM<BR>
MS_DASH_24HR  2008-06-24 23:59:59 - Default date format with year month day followed by 24 hour time<BR>
US_SLASH_24HR 06/24/2008 23:59:59 - USA date format with month day year followed by 24 hour time<BR>
EU_SLASH_24HR 24/06/2008 23:59:59 - European date format with day month year followed by 24 hour time<BR>
AL_TEXT_24HR  JUN 24 23:59:59 - Text date format with abbreviated month day followed by 24 hour time<BR>
MS_DASH_AMPM  2008-06-24 11:59:59 PM - Default date format with year month day followed by 12 hour time<BR>
US_SLASH_AMPM 06/24/2008 11:59:59 PM - USA date format with month day year followed by 12 hour time<BR>
EU_SLASH_AMPM 24/06/2008 11:59:59 PM - European date format with day month year followed by 12 hour time<BR>
AL_TEXT_AMPM  JUN 24 11:59:59 PM - Text date format with abbreviated month day followed by 12 hour time<BR>

<BR>
<A NAME="settings-vdc_header_phone_format">
<BR>
<B>Agent Screen Customer Phone Format -</B> This menu allows you to choose the format of the customer phone number that shows up in the status section of the VICIDIAL agent screen. The options for this setting are: default is US_PARN<BR>
US_DASH 000-000-0000 - USA dash separated phone number<BR>
US_PARN (000)000-0000 - USA dash separated number with area code in parenthesis<BR>
MS_NODS 0000000000 - No formatting<BR>
UK_DASH 00 0000-0000 - UK dash separated phone number with space after city code<BR>
AU_SPAC 000 000 000 - Australia space separated phone number<BR>
IT_DASH 0000-000-000 - Italy dash separated phone number<BR>
FR_SPAC 00 00 00 00 00 - France space separated phone number<BR>

<A NAME="settings-vdc_agent_api_active">
<BR>
<B>Agent interface API Access Active -</B> This option allows you to enable or disable the agent interface API. Default is 0.

<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_STATUSES TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_statuses">
<BR>
<B>Con el uso de los estados de sistema, usted puede tener estados queexistan para la campaña y el en-grupo. El estado debe ser 1-6caracteres en longitud, la descripcio`n debe ser 2-30 caracteres enlongitud y seleccionable define si demuestra para arriba en VICIDIALcomo disposicion del agente. Human_answered el campo se utiliza alcalcular el porcentaje de la gota, o la tarifa del abandono. El ajustehuman_answered a Y utilizará este estado al contar las llamadashumano-contestadas. La opcio`n de la categoría permite que ustedagrupe varios estados en un catogy que se pueda utilizar para elanálisis estadístico.</B>


<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_STATUS_CATEGORIES TABELLA</FONT></B><BR><BR>
<A NAME="vicidial_status_categories">
<BR>
<B>Con el uso de las categorías del estado de sistema, usted puedeagrupar juntos estados para tener en cuenta análisis estadístico enun grupo de estados. La identificacio`n de la categoría debe ser 2-20caracteres en longitud sin espacios, el nombre debe ser 2-50caracteres en longitud, la descripcio`n es opcional y la exhibicio`nde TimeonVDAD define si ese estado será uno de hasta que 4 estadosque se puedan calcular y exhibir en el tiempo en informe del tiemporeal de VDAD.</B> The Sale Category and Dead Lead Category are both used by the List Suggestion system when analyzing list statistics.


<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL QC STATUS CODES</FONT></B><BR><BR>
<A NAME="vicidial_qc_status_codes">
<BR>
<B>The Quality Control-QC system within VICIDIAL has its own set of status codes separate from those within the call handling functions of VICIDIAL. QC statuse codes must be between 2 and 8 characters in length and contain no special characters like a space or colon. The QC status code description must be between 2 and 30 characters in length.</B>




<BR><BR><BR><BR><BR><BR><BR><BR>
<BR><BR><BR><BR><BR><BR><BR><BR>
FINE
</TD></TR></TABLE></BODY></HTML>
<?
exit;

#### END HELP SCREENS
}


######################################################################################################
######################################################################################################
#######   7 series, filter count preview and script preview
######################################################################################################
######################################################################################################




######################
# ADD=73 view dialable leads from a filter and a campaign
######################

if ($ADD==73)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "</title>\n";
	echo "</head>\n";
	echo "<BODY BGCOLOR=white marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT dial_statuses,local_call_time,lead_filter_id from vicidial_campaigns where campaign_id='$campaign_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$dial_statuses =		$row[0];
	$local_call_time =		$row[1];
	if ($lead_filter_id=='')
		{
		$lead_filter_id =	$row[2];
		if ($lead_filter_id=='') 
			{
			$lead_filter_id='NONE';
			}
		}

	$stmt="SELECT list_id,active,list_name from vicidial_lists where campaign_id='$campaign_id'";
	$rslt=mysql_query($stmt, $link);
	$lists_to_print = mysql_num_rows($rslt);
	$camp_lists='';
	$o=0;
	while ($lists_to_print > $o) {
		$rowx=mysql_fetch_row($rslt);
		$o++;
	if (ereg("Y", $rowx[1])) {$camp_lists .= "'$rowx[0]',";}
	}
	$camp_lists = eregi_replace(".$","",$camp_lists);

	$filterSQL = $filtersql_list[$lead_filter_id];
	$filterSQL = eregi_replace("^and|and$|^or|or$","",$filterSQL);
	if (strlen($filterSQL)>4)
		{$fSQL = "and $filterSQL";}
	else
		{$fSQL = '';}


	echo "<BR><BR>\n";
	echo "<B>Demuestre La Cuenta De los Plomos De Dialable</B> -<BR><BR>\n";
	echo "<B>CAMPAIGN:</B> $campaign_id<BR>\n";
	echo "<B>LISTE:</B> $camp_lists<BR>\n";
	echo "<B>ESITI:</B> $dial_statuses<BR>\n";
	echo "<B>FILTRO:</B> $lead_filter_id<BR>\n";
	echo "<B>CALL TIME:</B> $local_call_time<BR><BR>\n";

	### call function to calculate and print dialable leads
	dialable_leads($DB,$link,$local_call_time,$dial_statuses,$camp_lists,$fSQL);

	echo "<BR><BR>\n";
	echo "</BODY></HTML>\n";

	exit;
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=7111111 view sample script with test variables
######################

if ($ADD==7111111)
{
	##### TEST VARIABLES #####
	$vendor_lead_code = 'VENDOR:LEAD;CODE';
	$list_id = 'LISTID';
	$gmt_offset_now = 'GMTOFFSET';
	$phone_code = '1';
	$phone_number = '7275551212';
	$title = 'Mr.';
	$first_name = 'JOHN';
	$middle_initial = 'Q';
	$last_name = 'PUBLIC';
	$address1 = '1234 Main St.';
	$address2 = 'Apt. 3';
	$address3 = 'ADDRESS3';
	$city = 'CHICAGO';
	$state = 'IL';
	$province = 'PROVINCE';
	$postal_code = '33760';
	$country_code = 'USA';
	$gender = 'M';
	$date_of_birth = '1970-01-01';
	$alt_phone = '3125551212';
	$email = 'test@test.com';
	$security_phrase = 'SECUTIRY';
	$comments = 'COMMENTS FIELD';
	$RGfullname = 'JOE AGENT';
	$RGuser = '6666';
	$RGlead_id = '1234';
	$RGcampaign = 'TESTCAMP';
	$RGphone_login = 'gs102';
	$RGgroup = 'TESTCAMP';
	$RGchannel_group = 'TESTCAMP';
	$RGSQLdate = date("Y-m-d H:i:s");
	$RGepoch = date("U");
	$RGuniqueid = '1163095830.4136';
	$RGcustomer_zap_channel = 'Zap/1-1';
	$RGserver_ip = '10.10.10.15';
	$RGSIPexten = 'SIP/gs102';
	$RGsession_id = '8600051';

echo "</title>\n";
echo "</head>\n";
echo "<BODY BGCOLOR=white marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

$stmt="SELECT * from vicidial_scripts where script_id='$script_id';";
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$script_name =		$row[1];
$script_text =		$row[3];

if (eregi("iframe src",$script_text))
	{
	$vendor_lead_code = eregi_replace(' ','+',$vendor_lead_code);
	$list_id = eregi_replace(' ','+',$list_id);
	$gmt_offset_now = eregi_replace(' ','+',$gmt_offset_now);
	$phone_code = eregi_replace(' ','+',$phone_code);
	$phone_number = eregi_replace(' ','+',$phone_number);
	$title = eregi_replace(' ','+',$title);
	$first_name = eregi_replace(' ','+',$first_name);
	$middle_initial = eregi_replace(' ','+',$middle_initial);
	$last_name = eregi_replace(' ','+',$last_name);
	$address1 = eregi_replace(' ','+',$address1);
	$address2 = eregi_replace(' ','+',$address2);
	$address3 = eregi_replace(' ','+',$address2);
	$city = eregi_replace(' ','+',$city);
	$state = eregi_replace(' ','+',$state);
	$province = eregi_replace(' ','+',$province);
	$postal_code = eregi_replace(' ','+',$postal_code);
	$country_code = eregi_replace(' ','+',$country_code);
	$gender = eregi_replace(' ','+',$gender);
	$date_of_birth = eregi_replace(' ','+',$date_of_birth);
	$alt_phone = eregi_replace(' ','+',$alt_phone);
	$email = eregi_replace(' ','+',$email);
	$security_phrase = eregi_replace(' ','+',$security_phrase);
	$comments = eregi_replace(' ','+',$comments);
	$RGfullname = eregi_replace(' ','+',$RGfullname);
	$RGuser = eregi_replace(' ','+',$RGuser);
	$RGlead_id = eregi_replace(' ','+',$RGlead_id);
	$RGcampaign = eregi_replace(' ','+',$RGcampaign);
	$RGphone_login = eregi_replace(' ','+',$RGphone_login);
	$RGgroup = eregi_replace(' ','+',$RGgroup);
	$RGchannel_group = eregi_replace(' ','+',$RGchannel_group);
	$RGSQLdate = eregi_replace(' ','+',$RGSQLdate);
	$RGepoch = eregi_replace(' ','+',$RGepoch);
	$RGuniqueid = eregi_replace(' ','+',$RGuniqueid);
	$RGcustomer_zap_channel = eregi_replace(' ','+',$RGcustomer_zap_channel);
	$RGserver_ip = eregi_replace(' ','+',$RGserver_ip);
	$RGSIPexten = eregi_replace(' ','+',$RGSIPexten);
	$RGsession_id = eregi_replace(' ','+',$RGsession_id);
	}

$script_text = eregi_replace('--A--vendor_lead_code--B--',"$vendor_lead_code",$script_text);
$script_text = eregi_replace('--A--list_id--B--',"$list_id",$script_text);
$script_text = eregi_replace('--A--gmt_offset_now--B--',"$gmt_offset_now",$script_text);
$script_text = eregi_replace('--A--phone_code--B--',"$phone_code",$script_text);
$script_text = eregi_replace('--A--phone_number--B--',"$phone_number",$script_text);
$script_text = eregi_replace('--A--title--B--',"$title",$script_text);
$script_text = eregi_replace('--A--first_name--B--',"$first_name",$script_text);
$script_text = eregi_replace('--A--middle_initial--B--',"$middle_initial",$script_text);
$script_text = eregi_replace('--A--last_name--B--',"$last_name",$script_text);
$script_text = eregi_replace('--A--address1--B--',"$address1",$script_text);
$script_text = eregi_replace('--A--address2--B--',"$address2",$script_text);
$script_text = eregi_replace('--A--address3--B--',"$address3",$script_text);
$script_text = eregi_replace('--A--city--B--',"$city",$script_text);
$script_text = eregi_replace('--A--state--B--',"$state",$script_text);
$script_text = eregi_replace('--A--province--B--',"$province",$script_text);
$script_text = eregi_replace('--A--postal_code--B--',"$postal_code",$script_text);
$script_text = eregi_replace('--A--country_code--B--',"$country_code",$script_text);
$script_text = eregi_replace('--A--gender--B--',"$gender",$script_text);
$script_text = eregi_replace('--A--date_of_birth--B--',"$date_of_birth",$script_text);
$script_text = eregi_replace('--A--alt_phone--B--',"$alt_phone",$script_text);
$script_text = eregi_replace('--A--email--B--',"$email",$script_text);
$script_text = eregi_replace('--A--security_phrase--B--',"$security_phrase",$script_text);
$script_text = eregi_replace('--A--comments--B--',"$comments",$script_text);
$script_text = eregi_replace('--A--fullname--B--',"$RGfullname",$script_text);
$script_text = eregi_replace('--A--fronter--B--',"$RGuser",$script_text);
$script_text = eregi_replace('--A--user--B--',"$RGuser",$script_text);
$script_text = eregi_replace('--A--lead_id--B--',"$RGlead_id",$script_text);
$script_text = eregi_replace('--A--campaign--B--',"$RGcampaign",$script_text);
$script_text = eregi_replace('--A--phone_login--B--',"$RGphone_login",$script_text);
$script_text = eregi_replace('--A--group--B--',"$RGgroup",$script_text);
$script_text = eregi_replace('--A--channel_group--B--',"$RGchannel_group",$script_text);
$script_text = eregi_replace('--A--SQLdate--B--',"$RGSQLdate",$script_text);
$script_text = eregi_replace('--A--epoch--B--',"$RGepoch",$script_text);
$script_text = eregi_replace('--A--uniqueid--B--',"$RGuniqueid",$script_text);
$script_text = eregi_replace('--A--customer_zap_channel--B--',"$RGcustomer_zap_channel",$script_text);
$script_text = eregi_replace('--A--server_ip--B--',"$RGserver_ip",$script_text);
$script_text = eregi_replace('--A--SIPexten--B--',"$RGSIPexten",$script_text);
$script_text = eregi_replace('--A--session_id--B--',"$RGsession_id",$script_text);
$script_text = eregi_replace("\n","<BR>",$script_text);


echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "Anteprima Script: $script_id<BR>\n";
echo "<TABLE WIDTH=600><TR><TD>\n";
echo "<center><B>$script_name</B><BR></center>\n";
echo "$script_text\n";
echo "</TD></TR></TABLE></center>\n";

echo "</BODY></HTML>\n";

exit;
}




######################### HTML HEADER BEGIN #######################################
if ($hh=='users') 
	{$users_hh="bgcolor =\"$users_color\""; $users_fc="$users_font"; $users_bold="$header_selected_bold";}
	else {$users_hh=''; $users_fc='WHITE'; $users_bold="$header_nonselected_bold";}
if ($hh=='campaigns') 
	{$campaigns_hh="bgcolor=\"$campaigns_color\""; $campaigns_fc="$campaigns_font"; $campaigns_bold="$header_selected_bold";}
	else {$campaigns_hh=''; $campaigns_fc='WHITE'; $campaigns_bold="$header_nonselected_bold";}
if ($hh=='lists') 
	{$lists_hh="bgcolor=\"$lists_color\""; $lists_fc="$lists_font"; $lists_bold="$header_selected_bold";}
	else {$lists_hh=''; $lists_fc='WHITE'; $lists_bold="$header_nonselected_bold";}
if ($hh=='ingroups') 
	{$ingroups_hh="bgcolor=\"$ingroups_color\""; $ingroups_fc="$ingroups_font"; $ingroups_bold="$header_selected_bold";}
	else {$ingroups_hh=''; $ingroups_fc='WHITE'; $ingroups_bold="$header_nonselected_bold";}
if ($hh=='remoteagent') 
	{$remoteagent_hh="bgcolor=\"$remoteagent_color\""; $remoteagent_fc="$remoteagent_font"; $remoteagent_bold="$header_selected_bold";}
	else {$remoteagent_hh=''; $remoteagent_fc='WHITE'; $remoteagent_bold="$header_nonselected_bold";}
if ($hh=='usergroups') 
	{$usergroups_hh="bgcolor=\"$usergroups_color\""; $usergroups_fc="$usergroups_font"; $usergroups_bold="$header_selected_bold";}
	else {$usergroups_hh=''; $usergroups_fc='WHITE'; $usergroups_bold="$header_nonselected_bold";}
if ($hh=='scripts') 
	{$scripts_hh="bgcolor=\"$scripts_color\""; $scripts_fc="$scripts_font"; $scripts_bold="$header_selected_bold";}
	else {$scripts_hh=''; $scripts_fc='WHITE'; $scripts_bold="$header_nonselected_bold";}
if ($hh=='filters') 
	{$filters_hh="bgcolor=\"$filters_color\""; $filters_fc="$filters_font"; $filters_bold="$header_selected_bold";}
	else {$filters_hh=''; $filters_fc='WHITE'; $filters_bold="$header_nonselected_bold";}
if ($hh=='admin') 
	{$admin_hh="bgcolor=\"$admin_color\""; $admin_fc="$admin_font"; $admin_bold="$header_selected_bold";}
	else {$admin_hh=''; $admin_fc='WHITE'; $admin_bold="$header_nonselected_bold";}
if ($hh=='reports') 
	{$reports_hh="bgcolor=\"$reports_color\""; $reports_fc="$reports_font"; $reports_bold="$header_selected_bold";}
	else {$reports_hh=''; $reports_fc='WHITE'; $reports_bold="$header_nonselected_bold";}

echo "</title>\n";
echo "<script language=\"Javascript\">\n";

######################
# ADD=31 or 34 and SUB=29 for list mixes
######################
if ( ( ($ADD==34) or ($ADD==31) or ($ADD==49) ) and ($SUB==29) and ($LOGmodify_campaigns==1) and ( (eregi("$campaign_id",$LOGallowed_campaigns)) or (eregi("ALL-CAMPAIGNS",$LOGallowed_campaigns)) ) ) 
{

?>
//Mix Listestatus add and remove
function mod_mix_status(stage,vcl_id,entry) 
	{
	var mod_status = document.getElementById("dial_status_" + entry + "_" + vcl_id);
	if (mod_status.value.length < 1)
		{
		alert("You must select a status first");
		}
	else
		{
		var old_statuses = document.getElementById("status_" + entry + "_" + vcl_id);
		var ROold_statuses = document.getElementById("ROstatus_" + entry + "_" + vcl_id);
		var MODstatus = new RegExp(" " + mod_status.value + " ","g");
		if (stage=="ADD")
			{
			if (old_statuses.value.match(MODstatus))
				{
				alert("The status " + mod_status.value + " is already present");
				}
			else
				{
				var new_statuses = " " + mod_status.value + "" + old_statuses.value;
				old_statuses.value = new_statuses;
				ROold_statuses.value = new_statuses;
				mod_status.value = "";
				}
			}
		if (stage=="REMOVE")
			{
			var MODstatus = new RegExp(" " + mod_status.value + " ","g");
			old_statuses.value = old_statuses.value.replace(MODstatus, " ");
			ROold_statuses.value = ROold_statuses.value.replace(MODstatus, " ");
			}
		}
	}

//Mix Listepercent difference calculation and warning message
function mod_mix_percent(vcl_id,entries) 
	{
	var i=0;
	var total_percent=0;
	var percent_diff='';
	while(i < entries)
		{
		var mod_percent_field = document.getElementById("percentage_" + i + "_" + vcl_id);
		temp_percent = mod_percent_field.value * 1;
		total_percent = (total_percent + temp_percent);
		i++;
		}

	var mod_diff_percent = document.getElementById("PCT_DIFF_" + vcl_id);
	percent_diff = (total_percent - 100);
	if (percent_diff > 0)
		{
		percent_diff = '+' + percent_diff;
		}
	var mix_list_submit = document.getElementById("submit_" + vcl_id);
	if ( (percent_diff > 0) || (percent_diff < 0) )
		{
		mix_list_submit.disabled = true;
		document.getElementById("ERROR_" + vcl_id).innerHTML = "<font color=red><B>The Difference % must be 0</B></font>";
		}
	else
		{
		mix_list_submit.disabled = false;
		document.getElementById("ERROR_" + vcl_id).innerHTML = "";
		}

	mod_diff_percent.value = percent_diff;
	}

function submit_mix(vcl_id,entries) 
	{
	var h=1;
	var j=1;
	var list_mix_container='';
	var mod_list_mix_container_field = document.getElementById("list_mix_container_" + vcl_id);
	while(h < 11)
		{
		var i=0;
		while(i < entries)
			{
			var mod_list_id_field = document.getElementById("list_id_" + i + "_" + vcl_id);
			var mod_priority_field = document.getElementById("priority_" + i + "_" + vcl_id);
			var mod_percent_field = document.getElementById("percentage_" + i + "_" + vcl_id);
			var mod_statuses_field = document.getElementById("status_" + i + "_" + vcl_id);
			if (mod_priority_field.value==h)
				{
				list_mix_container = list_mix_container + mod_list_id_field.value + "|" + j + "|" + mod_percent_field.value + "|" + mod_statuses_field.value + "|:";
				j++
				}
			i++;
			}
		h++
		}
	mod_list_mix_container_field.value = list_mix_container;
	var form_to_submit = document.getElementById("" + vcl_id);
	form_to_submit.submit();
	}
<?
}
?>

function openNewWindow(url) {
  window.open (url,"",'width=620,height=300,scrollbars=yes,menubar=yes,address=yes');
}
function scriptInsertField() {
	openField = '--A--';
	closeField = '--B--';
	var textBox = document.scriptForm.script_text;
	var scriptIndex = document.getElementById("selectedField").selectedIndex;
	var insValue =  document.getElementById('selectedField').options[scriptIndex].value;
  if (document.selection) {
	//IE
	textBox = document.scriptForm.script_text;
	insValue = document.scriptForm.selectedField.options[document.scriptForm.selectedField.selectedIndex].text;
	textBox.focus();
	sel = document.selection.createRange();
	sel.text = openField + insValue + closeField;
  } else if (textBox.selectionStart || textBox.selectionStart == 0) {
	//Mozilla
	var startPos = textBox.selectionStart;
	var endPos = textBox.selectionEnd;
	textBox.value = textBox.value.substring(0, startPos)
	+ openField + insValue + closeField
	+ textBox.value.substring(endPos, textBox.value.length);
  } else {
	textBox.value += openField + insValue + closeField;
  }
}

<?

#### Javascript for auto-generate of user ID Button
if ( ($ADD==1) or ($ADD=="1A") )
{
?>
function user_auto()
	{
	var user_toggle = document.getElementById("user_toggle");
	var user_field = document.getElementById("user");
	if (user_toggle.value < 1)
		{
		user_field.value = 'AUTOGENERATEZZZ';
		user_field.disabled = true;
		user_toggle.value = 1;
		}
	else
		{
		user_field.value = '';
		user_field.disabled = false;
		user_toggle.value = 0;
		}
	}

function user_submit()
	{
	var user_field = document.getElementById("user");
	user_field.disabled = false;
	document.userform.submit();
	}

<?
}

### Javascript for shift end-time calculation and display
if ( ($ADD==131111111) or ($ADD==331111111) )
{
?>
function shift_time()
	{
	var start_time = document.getElementById("shift_start_time");
	var end_time = document.getElementById("shift_end_time");
	var length = document.getElementById("shift_length");

	var start_time_hour=start_time.value.substring(0,2);
	var start_time_min=start_time.value.substring(2,4);
	var end_time_hour=end_time.value.substring(0,2);
	var end_time_min=end_time.value.substring(2,4);
	start_time_hour=(start_time_hour * 1);
	start_time_min=(start_time_min * 1);
	end_time_hour=(end_time_hour * 1);
	end_time_min=(end_time_min * 1);

	if (start_time.value == end_time.value)
		{
		var shift_length = '24:00';
		}
	else
		{
		if ( (start_time_hour > end_time_hour) || ( (start_time_hour == end_time_hour) && (start_time_min > end_time_min) ) )
			{
			var shift_hour = ( (24 - start_time_hour) + end_time_hour);
			var shift_minute = ( (60 - start_time_min) + end_time_min);
			if (shift_minute >= 60) 
				{
				shift_minute = (shift_minute - 60);
				}
			else
				{
				shift_hour = (shift_hour - 1);
				}
			}
		else
			{
			var shift_hour = (end_time_hour - start_time_hour);
			var shift_minute = (end_time_min - start_time_min);
			}
		if (shift_minute < 0) 
			{
			shift_minute = (shift_minute + 60);
			shift_hour = (shift_hour - 1);
			}

		if (shift_hour < 10) {shift_hour = '0' + shift_hour}
		if (shift_minute < 10) {shift_minute = '0' + shift_minute}
		var shift_length = shift_hour + ':' + shift_minute;
		}
//	alert(start_time_hour + '|' + start_time_min + '|' + end_time_hour + '|' + end_time_min + '|--|' + shift_hour + ':' + shift_minute + '|' + shift_length + '|');

	length.value = shift_length;
	}

<?
}
echo "</script>\n";
echo "</head>\n";
echo "<BODY BGCOLOR=white marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";
echo "<!-- ILPV -->\n";
echo "<TD WIDTH=100 ALIGN=RIGHT VALIGN=TOP  NOWRAP><a href=\"../vicidial_en/admin.php?relogin=YES&VD_login=$VD_login&VD_campaign=$VD_campaign&phone_login=$phone_login&phone_pass=$phone_pass&VD_pass=$VD_pass\">English <img src=\"../agc/images/en.gif\" BORDER=0 HEIGHT=14 WIDTH=20></a></TD>\n";echo "<TD WIDTH=100 ALIGN=RIGHT VALIGN=TOP  BGCOLOR=\"#CCFFCC\" NOWRAP><a href=\"../vicidial_it/admin.php?relogin=YES&VD_login=$VD_login&VD_campaign=$VD_campaign&phone_login=$phone_login&phone_pass=$phone_pass&VD_pass=$VD_pass\">Italiano <img src=\"../agc/images/it.gif\" BORDER=0 HEIGHT=14 WIDTH=20></a></TD>\n";
$stmt="SELECT admin_home_url from system_settings;";
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$admin_home_url_LU =	$row[0];

?>
<CENTER>
<TABLE WIDTH=<?=$page_width ?> BGCOLOR=#D9E6FE cellpadding=2 cellspacing=0><TR BGCOLOR=#015B91><TD ALIGN=LEFT COLSPAN=5><FONT FACE="ARIAL,HELVETICA" COLOR=WHITE SIZE=2><B> &nbsp; VICIDIAL ADMIN - <a href="<? echo $admin_home_url_LU ?>"><FONT FACE="ARIAL,HELVETICA" COLOR=WHITE SIZE=1>HOME</a> | <A HREF="../agc/timeclock.php?referrer=admin"><FONT FACE="ARIAL,HELVETICA" COLOR=WHITE SIZE=1> Timeclock</A> | <a href="<? echo $PHP_SELF ?>?force_logout=1"><FONT FACE="ARIAL,HELVETICA" COLOR=WHITE SIZE=1>Logout</a></TD><TD ALIGN=RIGHT COLSPAN=6><FONT FACE="ARIAL,HELVETICA" COLOR=WHITE SIZE=2><B><? echo date("l F j, Y G:i:s A") ?> &nbsp; </B></TD></TR>

<TR BGCOLOR=#015B91>
<TD ALIGN=CENTER <?=$users_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=0"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$users_fc ?> SIZE=<?=$header_font_size ?>><?=$users_bold ?> Utenti </a></TD>
<TD ALIGN=CENTER <?=$campaigns_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=10"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$campaigns_fc ?> SIZE=<?=$header_font_size ?>><?=$campaigns_bold ?> Campagne </a></TD>
<TD ALIGN=CENTER <?=$lists_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=100"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$lists_fc ?> SIZE=<?=$header_font_size ?>><?=$lists_bold ?> Liste </a></TD>
<TD ALIGN=CENTER <?=$scripts_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=1000000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$scripts_fc ?> SIZE=<?=$header_font_size ?>><?=$scripts_bold ?> Script </a></TD>
<TD ALIGN=CENTER <?=$filters_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=10000000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$filters_fc ?> SIZE=<?=$header_font_size ?>><?=$filters_bold ?> Filtri </a></TD>
<TD ALIGN=CENTER <?=$ingroups_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=1000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$ingroups_fc ?> SIZE=<?=$header_font_size ?>><?=$ingroups_bold ?> Gruppi Inbound </a></TD>
<TD ALIGN=CENTER <?=$usergroups_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=100000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$usergroups_fc ?> SIZE=<?=$header_font_size ?>><?=$usergroups_bold ?> Gruppi Utenti </a></TD>
<TD ALIGN=CENTER <?=$remoteagent_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=10000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$remoteagent_fc ?> SIZE=<?=$header_font_size ?>><?=$remoteagent_bold ?> Operatori Remoti </a></TD>
<TD ALIGN=CENTER <?=$admin_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=10000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$admin_fc ?> SIZE=<?=$header_font_size ?>><?=$admin_bold ?> Admin </a></TD>
<TD ALIGN=CENTER <?=$reports_hh ?>><a href="<? echo $PHP_SELF ?>?ADD=999999"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$reports_fc ?> SIZE=<?=$header_font_size ?>><?=$reports_bold ?> Report </a></TD>
</TR>

<? if (strlen($users_hh) > 1) { 
	?>
<TR BGCOLOR=<?=$users_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> &nbsp; <a href="<? echo $PHP_SELF ?>"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Utenti </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Nuovo Utente </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1A"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Copia Utente </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=550"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Ricerca Utenti </a> &nbsp; | &nbsp; <a href="./user_stats.php?user=<?=$user ?>"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> User Stats </a> &nbsp; | &nbsp; <a href="./user_status.php?user=<?=$user ?>"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> User Status </a> &nbsp; | &nbsp; <a href="./AST_agent_time_sheet.php?agent=<?=$user ?>"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Time Sheet </a> </TD></TR>
<? } 
if (strlen($campaigns_hh) > 1) 
	{ 

#	if ($sh=='basic') {$basic_sh="bgcolor=\"$subcamp_color\""; $basic_fc="$subcamp_font";}
#		else {$basic_sh=''; $basic_fc='BLACK';}
#	if ($sh=='detail') {$detail_sh="bgcolor=\"$subcamp_color\""; $detail_fc="$subcamp_font";}
#		else {$detail_sh=''; $detail_fc='BLACK';}
#	if ($sh=='dialstat') {$dialstat_sh="bgcolor=\"$subcamp_color\""; $dialstat_fc="$subcamp_font";}
#		else {$dialstat_sh=''; $dialstat_fc='BLACK';}

	if ($sh=='basic') {$sh='list';}
	if ($sh=='detail') {$sh='list';}
	if ($sh=='dialstat') {$sh='list';}

	if ($sh=='list') {$list_sh="bgcolor=\"$subcamp_color\""; $list_fc="$subcamp_font";}
		else {$list_sh=''; $list_fc='BLACK';}
	if ($sh=='status') {$status_sh="bgcolor=\"$subcamp_color\""; $status_fc="$subcamp_font";}
		else {$status_sh=''; $status_fc='BLACK';}
	if ($sh=='hotkey') {$hotkey_sh="bgcolor=\"$subcamp_color\""; $hotkey_fc="$subcamp_font";}
		else {$hotkey_sh=''; $hotkey_fc='BLACK';}
	if ($sh=='recycle') {$recycle_sh="bgcolor=\"$subcamp_color\""; $recycle_fc="$subcamp_font";}
		else {$recycle_sh=''; $recycle_fc='BLACK';}
	if ($sh=='autoalt') {$autoalt_sh="bgcolor=\"$subcamp_color\""; $autoalt_fc="$subcamp_font";}
		else {$autoalt_sh=''; $autoalt_fc='BLACK';}
	if ($sh=='pause') {$pause_sh="bgcolor=\"$subcamp_color\""; $pause_fc="$subcamp_font";}
		else {$pause_sh=''; $pause_fc='BLACK';}
	if ($sh=='listmix') {$listmix_sh="bgcolor=\"$subcamp_color\""; $listmix_fc="$subcamp_font";}
		else {$listmix_sh=''; $listmix_fc='BLACK';}

	?>
<TR BGCOLOR=<?=$campaigns_color ?>>
<TD ALIGN=CENTER <?=$list_sh ?> COLSPAN=2><a href="<? echo $PHP_SELF ?>?ADD=10"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$list_fc ?> SIZE=<?=$subcamp_font_size ?>>Main Campagne</a></TD>
<TD ALIGN=LEFT <?=$status_sh ?> COLSPAN=1><a href="<? echo $PHP_SELF ?>?ADD=32"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$status_fc ?> SIZE=<?=$subcamp_font_size ?>> Esiti </a></TD>
<TD ALIGN=LEFT <?=$hotkey_sh ?> COLSPAN=1><a href="<? echo $PHP_SELF ?>?ADD=33"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$hotkey_fc ?> SIZE=<?=$subcamp_font_size ?>> Hot-Key </a></TD>
<TD ALIGN=LEFT <?=$recycle_sh ?> COLSPAN=2><a href="<? echo $PHP_SELF ?>?ADD=35"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$recycle_fc ?> SIZE=<?=$subcamp_font_size ?>>Riciclaggio Contatti</a></TD>
<TD ALIGN=LEFT <?=$autoalt_sh ?> COLSPAN=1><a href="<? echo $PHP_SELF ?>?ADD=36"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$autoalt_fc ?> SIZE=<?=$subcamp_font_size ?>> Chiama-Auto-Num-Altern</a></TD>
<TD ALIGN=LEFT <?=$pause_sh ?> COLSPAN=1><a href="<? echo $PHP_SELF ?>?ADD=37"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$pause_fc ?> SIZE=<?=$subcamp_font_size ?>>Codici Pausa</a></TD>
<TD ALIGN=LEFT <?=$listmix_sh ?> COLSPAN=2><a href="<? echo $PHP_SELF ?>?ADD=39"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$listmix_fc ?> SIZE=<?=$subcamp_font_size ?>>Mix Liste</a></TD>
</TR>
	<?
	if (strlen($list_sh) > 1) { 
		?>
	<TR BGCOLOR=<?=$subcamp_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subcamp_font_size ?>> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=10"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subcamp_font_size ?>> Visualizza Campagne </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=11"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subcamp_font_size ?>> Aggiungi Nuova Campagna </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=12"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subcamp_font_size ?>> Copia Campagna </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="./AST_timeonVDADallSUMMARY.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subcamp_font_size ?>> Riepilogo Campagne In Tempo Reale </a></TD></TR>
		<? } 

	} 
if (strlen($lists_hh) > 1) { 
	?>
<TR BGCOLOR=<?=$lists_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=100"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Liste </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Nuova Lista </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="admin_search_lead.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Ricerca Contatti </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=121"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Numero Alla Lista DNC </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="./new_listloader_superL.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Carica Nuovi Contatti </a></TD></TR>
<? } 
if (strlen($scripts_hh) > 1) { 
	?>
<TR BGCOLOR=<?=$scripts_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Script </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Nuovo Script </a></TD></TR>
<? } 
if (strlen($filters_hh) > 1) { 
	?>
<TR BGCOLOR=<?=$filters_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=10000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Filtri </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=11111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Nuovo Filtro </a></TD></TR>
<? } 
if (strlen($ingroups_hh) > 1) { 
	?>
<TR BGCOLOR=<?=$ingroups_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Gruppi Inbound </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Gruppo Inbound </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1211"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Copia Gruppo Inbound </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1300"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Show DIDs </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1311"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Add A New DID </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1411"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Copy DID </a></TD></TR>
<? } 
if (strlen($usergroups_hh) > 1) { 
	?>
<TR BGCOLOR=<?=$usergroups_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=100000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Gruppi Utenti </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>>Aggiungi Nuovo Gruppo Utente </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="group_hourly_stats.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Report Orario Per Gruppo </a></TD></TR>
<? } 
if (strlen($remoteagent_hh) > 1) { 
	?>
<TR BGCOLOR=<?=$remoteagent_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=10000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Operatori Remoti </a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=11111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>>Aggiungi Operatore Remoto </a></TD></TR>
<? } 

if (strlen($admin_hh) > 1) { 
	if ($sh=='times') {$times_sh="bgcolor=\"$times_color\""; $times_fc="$times_font";} # hard teal
		else {$times_sh=''; $times_fc='BLACK';}
	if ($sh=='phones') {$phones_sh="bgcolor=\"$server_color\""; $phones_fc="$phones_font";} # pink
		else {$phones_sh=''; $phones_fc='BLACK';}
	if ($sh=='server') {$server_sh="bgcolor=\"$server_color\""; $server_fc="$server_font";} # pink
		else {$server_sh=''; $server_fc='BLACK';}
	if ($sh=='conference') {$conference_sh="bgcolor=\"$server_color\""; $conference_fc="$server_font";} # pink
		else {$conference_sh=''; $conference_fc='BLACK';}
	if ($sh=='settings') {$settings_sh="bgcolor=\"$settings_color\""; $settings_fc="$settings_font";} # pink
		else {$settings_sh=''; $settings_fc='BLACK';}
	if ($sh=='status') {$status_sh="bgcolor=\"$status_color\""; $status_fc="$status_font";} # pink
		else {$status_sh=''; $status_fc='BLACK';}

	?>
<TR BGCOLOR=<?=$admin_color ?>>
<TD ALIGN=LEFT <?=$times_sh ?> COLSPAN=2><a href="<? echo $PHP_SELF ?>?ADD=100000000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$times_fc ?> SIZE=<?=$header_font_size ?>> Orari Chiamata </a></TD>
<TD ALIGN=LEFT <?=$phones_sh ?> COLSPAN=2><a href="<? echo $PHP_SELF ?>?ADD=10000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$phones_fc ?> SIZE=<?=$header_font_size ?>> Telefoni </a></TD>
<TD ALIGN=LEFT <?=$conference_sh ?> COLSPAN=2><a href="<? echo $PHP_SELF ?>?ADD=1000000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$conference_fc ?> SIZE=<?=$header_font_size ?>> Conferencias </a></TD>
<TD ALIGN=LEFT <?=$server_sh ?> COLSPAN=1><a href="<? echo $PHP_SELF ?>?ADD=100000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$server_fc ?> SIZE=<?=$header_font_size ?>> Server </a></TD>
<TD ALIGN=LEFT <?=$settings_sh ?> COLSPAN=1><a href="<? echo $PHP_SELF ?>?ADD=311111111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$settings_fc ?> SIZE=<?=$header_font_size ?>> Impostazioni di Sistema </a></TD>
<TD ALIGN=LEFT <?=$status_sh ?> COLSPAN=2><a href="<? echo $PHP_SELF ?>?ADD=321111111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$status_fc ?> SIZE=<?=$header_font_size ?>> Esiti di Default</a></TD>
</TR>
	<?
	if (strlen($times_sh) > 1) { 
		?>
	<TR BGCOLOR=<?=$times_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>><a href="<? echo $PHP_SELF ?>?ADD=100000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Elenca Orari Chiamata </a> &nbsp;| <a href="<? echo $PHP_SELF ?>?ADD=111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Nuovo Orario Chiamate </a> &nbsp;| <a href="<? echo $PHP_SELF ?>?ADD=1000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Elenca Orari Chiamata Per Stati </a> &nbsp;| <a href="<? echo $PHP_SELF ?>?ADD=1111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Nuovo Orario Chiamate Per Stato </a> &nbsp;| <a href="<? echo $PHP_SELF ?>?ADD=130000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Show Shifts </a> &nbsp;| <a href="<? echo $PHP_SELF ?>?ADD=131111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Add A New Shift </a></TD></TR>
		<? } 
	if (strlen($phones_sh) > 1) { 
		?>
	<TR BGCOLOR=<?=$phones_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=10000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Telefoni </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=11111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Un Nuovo Telefono </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=12000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Phone Alias List </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=12111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Un Nuovo Telefono Alias </a></TD></TR>
		<? }
	if (strlen($conference_sh) > 1) { 
		?>
	<TR BGCOLOR=<?=$conference_color ?>><TD ALIGN=LEFT COLSPAN=10><a href="<? echo $PHP_SELF ?>?ADD=1000000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>>Visualizza Conferenze </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1111111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Conferenza </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=10000000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Conferenze VICIDIAL </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=11111111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Conferenza VICIDIAL </a></TD></TR>
		<? }
	if (strlen($server_sh) > 1) { 
		?>
	<TR BGCOLOR=<?=$server_color ?>><TD ALIGN=LEFT COLSPAN=10><a href="<? echo $PHP_SELF ?>?ADD=100000000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Visualizza Server </a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=111111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Aggiungi Un Nuovo Server </a></TD></TR>
	<?}
	if (strlen($settings_sh) > 1) { 
		?>
	<TR BGCOLOR=<?=$settings_color ?>><TD ALIGN=LEFT COLSPAN=10><a href="<? echo $PHP_SELF ?>?ADD=311111111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Impostazioni di Sistema </a></TD></TR>
	<?}
	if (strlen($status_sh) > 1) { 
		?>
	<TR BGCOLOR=<?=$status_color ?>><TD ALIGN=LEFT COLSPAN=10><a href="<? echo $PHP_SELF ?>?ADD=321111111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Esiti di Default</a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=331111111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> Categorie di esiti</a> &nbsp; | &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=341111111111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>> QC Status Codes </a></TD></TR>
	<?}

### Do nothing if admin has no permissions
if($LOGast_admin_access < 1) 
	{
	$ADD='99999999999999999999';
	echo "</TABLE></center>\n";
	echo "Le no autorizan a visio`n esta página. Vaya por favor detrás.\n";
	}

} 
if (strlen($reports_hh) > 1) { 
	?>
<TR BGCOLOR=<?=$reports_color ?>><TD ALIGN=LEFT COLSPAN=10><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=<?=$subheader_font_size ?>><B> &nbsp; </B></TD></TR>
<? } ?>


<TR><TD ALIGN=LEFT COLSPAN=10 HEIGHT=2 BGCOLOR=#015B91></TD></TR>
<TR><TD ALIGN=LEFT COLSPAN=10>
<? 
######################### HTML HEADER BEGIN #######################################





######################################################################################################
######################################################################################################
#######   1 series, ADD NEW forms for inserting new records into the database
######################################################################################################
######################################################################################################


######################
# ADD=1 display the ADD NEW USER FORM SCREEN
######################

if ($ADD=="1")
{
	if ($LOGmodify_users==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>NUOVO UTENTE <form action=$PHP_SELF method=POST name=userform id=userform>\n";
	echo "<input type=hidden name=ADD value=2>\n";
	echo "<input type=hidden name=user_toggle id=user_toggle value=0>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Numero Utente: </td><td align=left><input type=text name=user id=user size=20 maxlength=10> <input type=button name=auto_user value=\"AUTO-GENERATE\" onClick=\"user_auto()\"> $NWB#vicidial_users-user$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Password: </td><td align=left><input type=text name=pass size=20 maxlength=10>$NWB#vicidial_users-pass$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Completo: </td><td align=left><input type=text name=full_name size=20 maxlength=100>$NWB#vicidial_users-full_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Livello Utente: </td><td align=left><select size=1 name=user_level>";
	$h=1;
	while ($h<=$LOGuser_level)
		{
		echo "<option>$h</option>";
		$h++;
		}
	echo "</select>$NWB#vicidial_users-user_level$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Gruppo Utente: </td><td align=left><select size=1 name=user_group>\n";

		$stmt="SELECT user_group,group_name from vicidial_user_groups order by user_group";
		$rslt=mysql_query($stmt, $link);
		$Ugroups_to_print = mysql_num_rows($rslt);
		$Ugroups_list='';

		$o=0;
		while ($Ugroups_to_print > $o) {
			$rowx=mysql_fetch_row($rslt);
			$Ugroups_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
		}
	echo "$Ugroups_list";
	echo "<option SELECTED>$user_group</option>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Login Telefono: </td><td align=left><input type=text name=phone_login size=20 maxlength=20>$NWB#vicidial_users-phone_login$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Password Telefono: </td><td align=left><input type=text name=phone_pass size=20 maxlength=20>$NWB#vicidial_users-phone_pass$NWE</td></tr>\n";
	echo "</select>$NWB#vicidial_users-user_group$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=button name=INVIA value=INVIA onClick=\"user_submit()\"></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=1A display the COPY USER FORM SCREEN
######################

if ($ADD=="1A")
{
	if ($LOGmodify_users==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>COPIA UTENTE<form action=$PHP_SELF method=POST name=userform id=userform>\n";
	echo "<input type=hidden name=ADD value=2A>\n";
	echo "<input type=hidden name=user_toggle id=user_toggle value=0>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Numero Utente: </td><td align=left><input type=text name=user id=user size=20 maxlength=10> <input type=button name=auto_user value=\"AUTO-GENERATE\" onClick=\"user_auto()\"> $NWB#vicidial_users-user$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Password: </td><td align=left><input type=text name=pass size=20 maxlength=10>$NWB#vicidial_users-pass$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Completo: </td><td align=left><input type=text name=full_name size=20 maxlength=100>$NWB#vicidial_users-full_name$NWE</td></tr>\n";

	if ($LOGuser_level==9) {$levelMAX=10;}
	else {$levelMAX=$LOGuser_level;}

	echo "<tr bgcolor=#B6D3FC><td align=right>Utente Da Copiare: </td><td align=left><select size=1 name=source_user_id>\n";

		$stmt="SELECT user,full_name from vicidial_users where user_level < $levelMAX order by full_name;";
		$rslt=mysql_query($stmt, $link);
		$Uusers_to_print = mysql_num_rows($rslt);
		$Uusers_list='';

		$o=0;
		while ($Uusers_to_print > $o) {
			$rowx=mysql_fetch_row($rslt);
			$Uusers_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
		}
	echo "$Uusers_list";
	echo "</select>$NWB#vicidial_users-user$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=button name=INVIA value=INVIA onClick=\"user_submit()\"></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=11 display the ADD NEW CAMPAIGN FORM SCREEN
######################

if ($ADD==11)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>NUOVA CAMPAGNA<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=21>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Campagna: </td><td align=left><input type=text name=campaign_id size=10 maxlength=8>$NWB#vicidial_campaigns-campaign_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Campagna: </td><td align=left><input type=text name=campaign_name size=30 maxlength=30>$NWB#vicidial_campaigns-campaign_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Descrizione Campagna: </td><td align=left><input type=text name=campaign_description size=30 maxlength=255>$NWB#vicidial_campaigns-campaign_description$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option></select>$NWB#vicidial_campaigns-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Extension del parking: </td><td align=left><input type=text name=park_ext size=10 maxlength=10>$NWB#vicidial_campaigns-park_ext$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nombre de fichero Del Parking: </td><td align=left><input type=text name=park_file_name size=10 maxlength=10>$NWB#vicidial_campaigns-park_file_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left><input type=text name=web_form_address size=50 maxlength=255>$NWB#vicidial_campaigns-web_form_address$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Permitir Closers: </td><td align=left><select size=1 name=allow_closers><option>Y</option><option>N</option></select>$NWB#vicidial_campaigns-allow_closers$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Livello Coda Chiamate: </td><td align=left><select size=1 name=hopper_level><option>1</option><option>5</option><option>10</option><option>20</option><option>50</option><option>100</option><option>200</option><option>500</option><option>1000</option><option>2000</option></select>$NWB#vicidial_campaigns-hopper_level$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Livello Auto Dial: </td><td align=left><select size=1 name=auto_dial_level><option selected>0</option><option>1</option><option>1.1</option><option>1.2</option><option>1.3</option><option>1.4</option><option>1.5</option><option>1.6</option><option>1.7</option><option>1.8</option><option>1.9</option><option>2.0</option><option>2.2</option><option>2.5</option><option>2.7</option><option>3.0</option><option>3.5</option><option>4.0</option></select>(0 = off)$NWB#vicidial_campaigns-auto_dial_level$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Operatore Da Scegliere Per La Chiamata Successiva: </td><td align=left><select size=1 name=next_agent_call><option >random</option><option>oldest_call_start</option><option>oldest_call_finish</option><option>overall_user_level</option><option>campaign_rank</option><option>fewest_calls</option></select>$NWB#vicidial_campaigns-next_agent_call$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Orario Chiamate: </td><td align=left><select size=1 name=local_call_time>";
	echo "$call_times_list";
	echo "</select>$NWB#vicidial_campaigns-local_call_time$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Casella Vocale: </td><td align=left><input type=text name=voicemail_ext size=10 maxlength=10 value=\"$voicemail_ext\">$NWB#vicidial_campaigns-voicemail_ext$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Script: </td><td align=left><select size=1 name=script_id>\n";
	echo "$scripts_list";
	echo "</select>$NWB#vicidial_campaigns-campaign_script$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Esegui all`avvio della telefonata: </td><td align=left><select size=1 name=get_call_launch><option selected>NESSUNO</option><option>SCRIPT</option><option>WEBFORM</option></select>$NWB#vicidial_campaigns-get_call_launch$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=12 display the COPY CAMPAIGN FORM SCREEN
######################

if ($ADD==12)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>COPIA UNA CAMPAGNA<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=20>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Campagna: </td><td align=left><input type=text name=campaign_id size=10 maxlength=8>$NWB#vicidial_campaigns-campaign_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Campagna: </td><td align=left><input type=text name=campaign_name size=30 maxlength=30>$NWB#vicidial_campaigns-campaign_name$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Campagna da copiare:</td><td align=left><select size=1 name=source_campaign_id>\n";

		$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
		$rslt=mysql_query($stmt, $link);
		$campaigns_to_print = mysql_num_rows($rslt);
		$campaigns_list='';

		$o=0;
		while ($campaigns_to_print > $o) {
			$rowx=mysql_fetch_row($rslt);
			$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
		}
	echo "$campaigns_list";
	echo "</select>$NWB#vicidial_campaigns-campaign_id$NWE</td></tr>\n";
	
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2>NOTE: Copying a campaign will copy all settings from the master campaign you select, but it will not copy a campaign-specific DNC list if there was one on the selected master campaign.</td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=111 display the ADD NEW LIST FORM SCREEN
######################

if ($ADD==111)
{
	if ($LOGmodify_lists==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>AGGIUNGI NUOVA LISTA<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=211>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Lista: </td><td align=left><input type=text name=list_id size=8 maxlength=8> (solo cifre)$NWB#vicidial_lists-list_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Lista: </td><td align=left><input type=text name=list_name size=20 maxlength=20>$NWB#vicidial_lists-list_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Descrizione Lista: </td><td align=left><input type=text name=list_description size=30 maxlength=255>$NWB#vicidial_lists-list_description$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Campagna: </td><td align=left><select size=1 name=campaign_id>\n";

		$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
		$rslt=mysql_query($stmt, $link);
		$campaigns_to_print = mysql_num_rows($rslt);
		$campaigns_list='';

		$o=0;
		while ($campaigns_to_print > $o) 
			{
			$rowx=mysql_fetch_row($rslt);
			$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}
	echo "$campaigns_list";
	echo "<option SELECTED>$campaign_id</option>\n";
	echo "</select>$NWB#vicidial_lists-campaign_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option>Y</option><option SELECTED>N</option></select>$NWB#vicidial_lists-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=121 display the ADD NUMBER TO DNC FORM SCREEN and add a new number
######################

if ($ADD==121)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

$campaigns_list = "<option SELECTED value=\"SYSTEM_INTERNAL\">SYSTEM_INTERNAL - INTERNAL VICIDIAL DNC LIST</option>\n";

$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns where use_campaign_dnc='Y' order by campaign_id";
$rslt=mysql_query($stmt, $link);
$campaigns_to_print = mysql_num_rows($rslt);

$o=0;
while ($campaigns_to_print > $o) 
	{
	$rowx=mysql_fetch_row($rslt);
	$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
	$o++;
	}

if (strlen($phone_numbers) > 2)
	{
	$PN = explode("\n",$phone_numbers);
	$PNct = count($PN);
	$p=0;
	while ($p < $PNct)
		{
		if (ereg('SYSTEM_INTERNAL',$campaign_id))
			{
			$stmt="SELECT count(*) from vicidial_dnc where phone_number='$PN[$p]';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			if ($row[0] > 0)
				{echo "<br>DNC NO AGREGADO - este número de telefono está en no llama ya lalista: $PN[$p]\n";}
			else
				{
				$stmt="INSERT INTO vicidial_dnc (phone_number) values('$PN[$p]');";
				$rslt=mysql_query($stmt, $link);

				echo "<br><B>DNC AGREGADO: $PN[$p]</B>\n";
				}
			}
		else
			{
			$stmt="SELECT count(*) from vicidial_campaign_dnc where phone_number='$PN[$p]' and campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			if ($row[0] > 0)
				{echo "<br>DNC NO AGREGADO - este número de telefono está en no llama ya lalista: $PN[$p] $campaign_id\n";}
			else
				{
				$stmt="INSERT INTO vicidial_campaign_dnc (phone_number,campaign_id) values('$PN[$p]','$campaign_id');";
				$rslt=mysql_query($stmt, $link);

				echo "<br><B>DNC AGREGADO: $PN[$p] $campaign_id</B>\n";
				}
			}
		$p++;
		}

	### LOG INSERTION TO LOG FILE ###
	if ($WeBRooTWritablE > 0)
		{
		$fp = fopen ("./admin_changes_log.txt", "a");
		fwrite ($fp, "$date|ADD A NEW DNC NUMBER|$PHP_AUTH_USER|$ip|'$phone_number','$campaign_id'|\n");
		fclose($fp);
		}
	}

echo "<br>ADD NUMBERS TO THE DNC LIST<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=121>\n";
echo "<center><TABLE width=$section_width cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>List: </td><td align=left><select size=1 name=campaign_id>\n";
echo "$campaigns_list";
echo "</select></td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Numero di Telefonos: <BR><BR> (one phone number per line only)<BR>$NWB#vicidial_list-dnc$NWE</td><td align=left><TEXTAREA name=phone_numbers ROWS=20 COLS=20></TEXTAREA></td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
echo "</TABLE></center>\n";

}


######################
# ADD=1111 display the ADD NEW INBOUND GROUP SCREEN
######################

if ($ADD==1111)
{
	if ($LOGmodify_ingroups==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>NUOVO GRUPPO INBOUND<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=2111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Gruppo: </td><td align=left><input type=text name=group_id size=20 maxlength=20> (senza spazi)$NWB#vicidial_inbound_groups-group_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Gruppo: </td><td align=left><input type=text name=group_name size=30 maxlength=30>$NWB#vicidial_inbound_groups-group_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Colore Gruppo: </td><td align=left id=\"group_color_td\"><input type=text name=group_color size=7 maxlength=7>$NWB#vicidial_inbound_groups-group_color$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option SELECTED>Y</option><option>N</option></select>$NWB#vicidial_inbound_groups-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left><input type=text name=web_form_address size=50 maxlength=255 value=\"$web_form_address\">$NWB#vicidial_inbound_groups-web_form_address$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Casella Vocale: </td><td align=left><input type=text name=voicemail_ext size=10 maxlength=10 value=\"$voicemail_ext\">$NWB#vicidial_inbound_groups-voicemail_ext$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Operatore Da Scegliere Per La Chiamata Successiva: </td><td align=left><select size=1 name=next_agent_call><option >random</option><option>oldest_call_start</option><option>oldest_call_finish</option><option>overall_user_level</option><option>inbound_group_rank</option><option>campaign_rank</option><option>fewest_calls</option><option>fewest_calls_campaign</option></select>$NWB#vicidial_inbound_groups-next_agent_call$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Mostrar Fronter: </td><td align=left><select size=1 name=fronter_display><option SELECTED>Y</option><option>N</option></select>$NWB#vicidial_inbound_groups-fronter_display$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Script: </td><td align=left><select size=1 name=script_id>\n";
	echo "$scripts_list";
	echo "</select>$NWB#vicidial_inbound_groups-ingroup_script$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Esegui all`avvio della telefonata: </td><td align=left><select size=1 name=get_call_launch><option selected>NESSUNO</option><option>SCRIPT</option><option>WEBFORM</option></select>$NWB#vicidial_inbound_groups-get_call_launch$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=1211 display the COPY INBOUND GROUP SCREEN
######################

if ($ADD==1211)
{
	if ($LOGmodify_ingroups==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>COPIA GRUPPO INBOUND<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=2011>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Gruppo: </td><td align=left><input type=text name=group_id size=20 maxlength=20> (senza spazi)$NWB#vicidial_inbound_groups-group_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Gruppo: </td><td align=left><input type=text name=group_name size=30 maxlength=30>$NWB#vicidial_inbound_groups-group_name$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>ID Gruppo Da Copiare: </td><td align=left><select size=1 name=source_group_id>\n";

		$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT') order by group_id";
		$rslt=mysql_query($stmt, $link);
		$groups_to_print = mysql_num_rows($rslt);
		$groups_list='';

		$o=0;
		while ($groups_to_print > $o) {
			$rowx=mysql_fetch_row($rslt);
			$groups_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
		}
	echo "$groups_list";
	echo "</select>$NWB#vicidial_inbound_groups-group_id$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=1311 display the ADD NEW DID SCREEN
######################

if ($ADD==1311)
{
	if ($LOGmodify_dids==1)
		{
		echo "<TABLE><TR><TD>\n";
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

		echo "<br>ADD A NEW DID<form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=ADD value=2311>\n";
		echo "<center><TABLE width=$section_width cellspacing=3>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>DID Extension: </td><td align=left><input type=text name=did_pattern size=20 maxlength=50> (senza spazi)$NWB#vicidial_inbound_dids-did_pattern$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>DID Descrizione: </td><td align=left><input type=text name=did_description size=40 maxlength=50>$NWB#vicidial_inbound_dids-did_description$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
		echo "</TABLE></center>\n";
		}
	else
		{
		echo "Non hai l`autorizzazione per accedere a questa pagina\n";
		exit;
		}
}


######################
# ADD=1411 display the COPY DID SCREEN
######################

if ($ADD==1411)
{
	if ($LOGmodify_dids==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>COPY DID<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=2411>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>DID Extension: </td><td align=left><input type=text name=did_pattern size=20 maxlength=50> (senza spazi)$NWB#vicidial_inbound_dids-did_pattern$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>DID Descrizione: </td><td align=left><input type=text name=did_description size=40 maxlength=50>$NWB#vicidial_inbound_dids-did_description$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Source DID: </td><td align=left><select size=1 name=source_did>\n";

		$stmt="SELECT did_id,did_pattern,did_description from vicidial_inbound_dids order by did_pattern";
		$rslt=mysql_query($stmt, $link);
		$dids_to_print = mysql_num_rows($rslt);
		$dids_list='';

		$o=0;
		while ($dids_to_print > $o) {
			$rowx=mysql_fetch_row($rslt);
			$dids_list .= "<option value=\"$rowx[0]\">$rowx[1] - $rowx[2]</option>\n";
			$o++;
		}
	echo "$dids_list";
	echo "</select>$NWB#vicidial_inbound_dids-did_pattern$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=11111 display the ADD NEW REMOTE AGENTS SCREEN
######################

if ($ADD==11111)
{
	if ($LOGmodify_remoteagents==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>NUOVO OPERATORE REMOTO<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=21111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Inizio ID Utente: </td><td align=left><input type=text name=user_start size=6 maxlength=6> (solo cifre, incremented)$NWB#vicidial_remote_agents-user_start$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Numero di Linee: </td><td align=left><input type=text name=number_of_lines size=3 maxlength=3> (solo cifre)$NWB#vicidial_remote_agents-number_of_lines$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>IP Server: </td><td align=left><select size=1 name=server_ip>\n";
	echo "$servers_list";
	echo "</select>$NWB#vicidial_remote_agents-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Numero Di Interno Remoto: </td><td align=left><input type=text name=conf_exten size=20 maxlength=20> (numero del dialplan usato per raggiungere gli operatori)$NWB#vicidial_remote_agents-conf_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Esito: </td><td align=left><select size=1 name=status><option>ATTIVO</option><option SELECTED>INACTIVE</option></select>$NWB#vicidial_remote_agents-status$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Campagna: </td><td align=left><select size=1 name=campaign_id>\n";
	echo "$campaigns_list";
	echo "</select>$NWB#vicidial_remote_agents-campaign_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Gruppi Inbound: </td><td align=left>\n";
	echo "$groups_list";
	echo "$NWB#vicidial_remote_agents-closer_campaigns$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	echo "NOTA: Potrebbero passare fino a 30 secondi prima che le modifiche qui effettuate possano essere accettate\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=111111 display the ADD NEW USERS GROUP SCREEN
######################

if ($ADD==111111)
{
	if ($LOGmodify_usergroups==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>NUOVO GRUPPO UTENTI<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=211111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Gruppo: </td><td align=left><input type=text name=user_group size=15 maxlength=20> (senza spazi e punteggiatura)$NWB#vicidial_user_groups-user_group$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Descrizione: </td><td align=left><input type=text name=group_name size=40 maxlength=40> (Descrizione del gruppo)$NWB#vicidial_user_groups-group_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=1111111 display the ADD NEW SCRIPT SCREEN
######################

if ($ADD==1111111)
{
	if ($LOGmodify_scripts==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>AGGIUNGI NUOVO SCRIPT<form name=scriptForm action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=2111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Script:: </td><td align=left><input type=text name=script_id size=12 maxlength=10> (senza spazi e punteggiatura)$NWB#vicidial_scripts-script_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Script: </td><td align=left><input type=text name=script_name size=40 maxlength=50> (titolo script)$NWB#vicidial_scripts-script_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Note Script: </td><td align=left><input type=text name=script_comments size=50 maxlength=255> $NWB#vicidial_scripts-script_comments$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option SELECTED>Y</option><option>N</option></select>$NWB#vicidial_scripts-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Testo Script: </td><td align=left>";
	# BEGIN Insert Field
	echo "<select id=\"selectedField\" name=\"selectedField\">";
	echo "<option>vendor_lead_code</option>";
	echo "<option>source_id</option>";
	echo "<option>list_id</option>";
	echo "<option>gmt_offset_now</option>";
	echo "<option>called_since_last_reset</option>";
	echo "<option>phone_code</option>";
	echo "<option>phone_number</option>";
	echo "<option>title</option>";
	echo "<option>first_name</option>";
	echo "<option>middle_initial</option>";
	echo "<option>last_name</option>";
	echo "<option>address1</option>";
	echo "<option>address2</option>";
	echo "<option>address3</option>";
	echo "<option>city</option>";
	echo "<option>state</option>";
	echo "<option>province</option>";
	echo "<option>postal_code</option>";
	echo "<option>country_code</option>";
	echo "<option>gender</option>";
	echo "<option>date_of_birth</option>";
	echo "<option>alt_phone</option>";
	echo "<option>email</option>";
	echo "<option>security_phrase</option>";
	echo "<option>comments</option>";
	echo "<option>lead_id</option>";
	echo "<option>campaign</option>";
	echo "<option>phone_login</option>";
	echo "<option>group</option>";
	echo "<option>channel_group</option>";
	echo "<option>SQLdate</option>";
	echo "<option>epoch</option>";
	echo "<option>uniqueid</option>";
	echo "<option>customer_zap_channel</option>";
	echo "<option>server_ip</option>";
	echo "<option>SIPexten</option>";
	echo "<option>session_id</option>";
	echo "</select>";
	echo "<input type=\"button\" name=\"insertField\" value=\"Insert\" onClick=\"scriptInsertField();\"><BR>";
	# END Insert Field
	echo "<TEXTAREA NAME=script_text ROWS=20 COLS=50 value=\"\"></TEXTAREA> $NWB#vicidial_scripts-script_text$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=11111111 display the ADD NEW FILTER SCREEN
######################

if ($ADD==11111111)
{
	if ($LOGmodify_filters==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>AGGIUNGI NUOVO FILTRO<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=21111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Filtro:</td><td align=left><input type=text name=lead_filter_id size=12 maxlength=10> (senza spazi e punteggiatura)$NWB#vicidial_lead_filters-lead_filter_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Del Filtro:</td><td align=left><input type=text name=lead_filter_name size=30 maxlength=30> (breve descrizione del filtro)$NWB#vicidial_lead_filters-lead_filter_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Commenti Del Filtro: </td><td align=left><input type=text name=lead_filter_comments size=50 maxlength=255> $NWB#vicidial_lead_filters-lead_filter_comments$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Filtro Sql: </td><td align=left><TEXTAREA NAME=lead_filter_sql ROWS=20 COLS=50 value=\"\"></TEXTAREA> $NWB#vicidial_lead_filters-lead_filter_sql$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=111111111 display the ADD NEW CALL TIME SCREEN
######################

if ($ADD==111111111)
{
	if ($LOGmodify_call_times==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>AGGIUNGI ORARIO CHIAMATE<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=211111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Orario Chiamate: </td><td align=left><input type=text name=call_time_id size=12 maxlength=10> (senza spazi e punteggiatura)$NWB#vicidial_call_times-call_time_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Orario Chiamate: </td><td align=left><input type=text name=call_time_name size=30 maxlength=30> (breve descrizione dell`orario chiamate)$NWB#vicidial_call_times-call_time_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Note Orario Chiamate: </td><td align=left><input type=text name=call_time_comments size=50 maxlength=255> $NWB#vicidial_call_times-call_time_comments$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2>Las opciones del día y del tiempo aparecerán una vez que usted hayacreado la definicio`n del tiempo de la llamada</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=1111111111 display the ADD NEW STATE CALL TIME SCREEN
######################

if ($ADD==1111111111)
{
	if ($LOGmodify_call_times==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>AGREGUE EL NUEVO TIEMPO DE LA LLAMADA DEL ESTADO<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=2111111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Identificacio`n Del Tiempo De la Llamada Del Estado: </td><td align=left><input type=text name=call_time_id size=12 maxlength=10> (senza spazi e punteggiatura)$NWB#vicidial_call_times-call_time_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>State Call Time State: </td><td align=left><input type=text name=state_call_time_state size=4 maxlength=2> (senza spazi e punteggiatura)$NWB#vicidial_call_times-state_call_time_state$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>_ Estado Llamar Tiempo Nombre: </td><td align=left><input type=text name=call_time_name size=30 maxlength=30> (breve descrizione dell`orario chiamate)$NWB#vicidial_call_times-call_time_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Comentarios Del Tiempo De la Llamada Del Estado: </td><td align=left><input type=text name=call_time_comments size=50 maxlength=255> $NWB#vicidial_call_times-call_time_comments$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2>Las opciones del día y del tiempo aparecerán una vez que usted hayacreado la definicio`n del tiempo de la llamada</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=131111111 display the ADD NEW SHIFT SCREEN
######################

if ($ADD==131111111)
{
	if ($LOGmodify_call_times==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>ADD NEW SHIFT<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=231111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Shift ID: </td><td align=left><input type=text name=shift_id size=22 maxlength=20> (senza spazi e punteggiatura)$NWB#vicidial_shifts-shift_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Shift Name: </td><td align=left><input type=text name=shift_name size=50 maxlength=50> (short description of the shift)$NWB#vicidial_shifts-shift_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Shift Start Time: </td><td align=left><input type=text name=shift_start_time size=5 maxlength=4 id=shift_start_time>\n";
	echo " &nbsp; Shift End Time: <input type=text name=shift_end_time size=5 maxlength=4 id=shift_end_time>\n";
	echo "<input type=button name=shift_calc value=\"Calculate Shift Length\" onClick=\"shift_time();\"> $NWB#vicidial_shifts-shift_start_time$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Shift Length: </td><td align=left><input type=text name=shift_length id=shift_length size=6 maxlength=5> $NWB#vicidial_shifts-shift_length$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Shift Weekdays: <BR>$NWB#vicidial_shifts-shift_weekdays$NWE</td><td align=left>\n";
	echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"0\">Sunday<BR>\n";
	echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"1\">Monday<BR>\n";
	echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"2\">Tuesday<BR>\n";
	echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"3\">Wednesday<BR>\n";
	echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"4\">Thursday<BR>\n";
	echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"5\">Friday<BR>\n";
	echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"6\">Saturday<BR>\n";
	echo "</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=11111111111 display the ADD NEW PHONE SCREEN
######################

if ($ADD==11111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>AGGIUNGI UN NUOVO TELEFONO<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=21111111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";

	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Interno Telefono: </td><td align=left><input type=text name=extension size=20 maxlength=100 value=\"\">$NWB#phones-extension$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Numero De Dial plan: </td><td align=left><input type=text name=dialplan_number size=15 maxlength=20> (solo cifre)$NWB#phones-dialplan_number$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Buzon de voz: </td><td align=left><input type=text name=voicemail_id size=10 maxlength=10> (solo cifre)$NWB#phones-voicemail_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>CallerID De salida: </td><td align=left><input type=text name=outbound_cid size=10 maxlength=20> (solo cifre)$NWB#phones-outbound_cid$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Direccion IP del telefono: </td><td align=left><input type=text name=phone_ip size=20 maxlength=15> (optional)$NWB#phones-phone_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Direccion IP del ordenador: </td><td align=left><input type=text name=computer_ip size=20 maxlength=15> (optional)$NWB#phones-computer_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>IP Server: </td><td align=left><select size=1 name=server_ip>\n";

	echo "$servers_list";
	echo "<option SELECTED>$row[5]</option>\n";
	echo "</select>$NWB#phones-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Login: </td><td align=left><input type=text name=login size=10 maxlength=10>$NWB#phones-login$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Password: </td><td align=left><input type=text name=pass size=10 maxlength=10>$NWB#phones-pass$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Esito: </td><td align=left><select size=1 name=status><option SELECTED>ATTIVO</option><option>SUSPENDED</option><option>CLOSED</option><option>PENDING</option><option>ADMIN</option></select>$NWB#phones-status$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Activa: </td><td align=left><select size=1 name=active><option SELECTED>Y</option><option>N</option></select>$NWB#phones-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Tipo Del telefono: </td><td align=left><input type=text name=phone_type size=20 maxlength=50>$NWB#phones-phone_type$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Completo: </td><td align=left><input type=text name=fullname size=20 maxlength=50>$NWB#phones-fullname$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Compania: </td><td align=left><input type=text name=company size=10 maxlength=10>$NWB#phones-company$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Foto: </td><td align=left><input type=text name=picture size=20 maxlength=19>$NWB#phones-picture$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Protocollo Client: </td><td align=left><select size=1 name=protocol><option SELECTED>SIP</option><option>Zap</option><option>IAX2</option><option>EXTERNAL</option></select>$NWB#phones-protocol$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Fuso Orario Locale: </td><td align=left><select size=1 name=local_gmt><option>12.75</option><option>12.00</option><option>11.00</option><option>10.00</option><option>9.50</option><option>9.00</option><option>8.00</option><option>7.00</option><option>6.50</option><option>6.00</option><option>5.75</option><option>5.50</option><option>5.00</option><option>4.50</option><option>4.00</option><option>3.50</option><option>3.00</option><option>2.00</option><option>1.00</option><option>0.00</option><option>-1.00</option><option>-2.00</option><option>-3.00</option><option>-3.50</option><option>-4.00</option><option SELECTED>-5.00</option><option>-6.00</option><option>-7.00</option><option>-8.00</option><option>-9.00</option><option>-10.00</option><option>-11.00</option><option>-12.00</option></select> (No ajustar para el DST)$NWB#phones-local_gmt$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=12111111111 display the ADD NEW PHONE ALIAS SCREEN
######################

if ($ADD==12111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>AGGIUNGI UN NUOVO TELEFONO ALIAS<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=22111111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";

	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Alias ID: </td><td align=left><input type=text name=alias_id size=20 maxlength=20 value=\"\">$NWB#phones-alias_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Alias Name: </td><td align=left><input type=text name=alias_name size=30 maxlength=50> $NWB#phones-alias_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Login Telefonos List: </td><td align=left><input type=text name=logins_list size=50 maxlength=255> (comma separated)$NWB#phones-logins_list$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=111111111111 display the ADD NEW SERVER SCREEN
######################

if ($ADD==111111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>AGGIUNGI UN NUOVO SERVER<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=211111111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Server: </td><td align=left><input type=text name=server_id size=10 maxlength=10>$NWB#servers-server_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Descrizione Server: </td><td align=left><input type=text name=server_description size=30 maxlength=255>$NWB#servers-server_description$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Indirizzo IP del Server: </td><td align=left><input type=text name=server_ip size=20 maxlength=15>$NWB#servers-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option></select>$NWB#servers-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Versione Di Asterisk: </td><td align=left><input type=text name=asterisk_version size=20 maxlength=20>$NWB#servers-asterisk_version$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=1111111111111 display the ADD NEW CONFERENCE SCREEN
######################

if ($ADD==1111111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>CREA UNA NUOVA CONFERENZA<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=2111111111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Número de la Conferencia: </td><td align=left><input type=text name=conf_exten size=8 maxlength=7> (solo cifre)$NWB#conferences-conf_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>IP Server: </td><td align=left><select size=1 name=server_ip>\n";

	echo "$servers_list";
	echo "<option SELECTED>$server_ip</option>\n";
	echo "</select>$NWB#conferences-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=11111111111111 display the ADD NEW VICIDIAL CONFERENCE SCREEN
######################

if ($ADD==11111111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>CREA UNA NUOVA CONFERENZA VICIDIAL<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=21111111111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Número de la Conferencia: </td><td align=left><input type=text name=conf_exten size=8 maxlength=7> (solo cifre)$NWB#conferences-conf_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>IP Server: </td><td align=left><select size=1 name=server_ip>\n";

	echo "$servers_list";
	echo "<option SELECTED>$server_ip</option>\n";
	echo "</select>$NWB#conferences-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}



######################################################################################################
######################################################################################################
#######   2 series, validates form data and inserts the new record into the database
######################################################################################################
######################################################################################################


######################
# ADD=2 adds the new user to the system
######################

if ($ADD=="2")
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_users where user='$user';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>UTENTE NON AGGIUNTO - Esiste gia` un utente nel sistema con questo numero utente\n";}
	else
		{
		if (ereg('AUTOGENERA',$user))
			{
			$user = 'AUTOGENERA';
			}
		 if ( (strlen($user) < 2) or (strlen($pass) < 2) or (strlen($full_name) < 2) or (strlen($user) > 10) )
			{
			 echo "<br>UTENTE NON AGGIUNTO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>user id must be between 2 and 10 characters long\n";
			 echo "<br>il nome e la password devono essere lunghi almeno 2 caratteri\n";
			}
		 else
			{
			if (ereg('AUTOGENERA',$user))
				{
				$new_user=0;
				$auto_user_add_value=0;
				while ($new_user < 2)
					{
					if ($new_user < 1)
						{
						$stmt = "SELECT auto_user_add_value FROM system_settings;";
						$rslt=mysql_query($stmt, $link);
						$ss_auav_ct = mysql_num_rows($rslt);
						if ($ss_auav_ct > 0)
							{
							$row=mysql_fetch_row($rslt);
							$auto_user_add_value = $row[0];
							}
						$new_user++;
						}
					$stmt = "SELECT count(*) FROM vicidial_users where user='$auto_user_add_value';";
					$rslt=mysql_query($stmt, $link);
					$row=mysql_fetch_row($rslt);
					if ($row[0] < 1)
						{
						$new_user++;
						}
					else 
						{
						echo "<!-- AG: $auto_user_add_value -->\n";
						$auto_user_add_value = ($auto_user_add_value + 7);
						}
					}
				$user = $auto_user_add_value;
				echo "<br><B>user_id has been auto-generated: $user</B><br>\n";

				$stmt="UPDATE system_settings SET auto_user_add_value='$user';";
				$rslt=mysql_query($stmt, $link);
				}
			echo "<br><B>UTENTE AGGIUNTO: $user</B>\n";

			$stmt="INSERT INTO vicidial_users (user,pass,full_name,user_level,user_group,phone_login,phone_pass) values('$user','$pass','$full_name','$user_level','$user_group','$phone_login','$phone_pass');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A USER          |$PHP_AUTH_USER|$ip|'$user','$pass','$full_name','$user_level','$user_group','$phone_login','$phone_pass'|\n");
				fclose($fp);
				}
			}
		}

$ADD=3;
}

######################
# ADD=2A adds the copied new user to the system
######################

if ($ADD=="2A")
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_users where user='$user';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>UTENTE NON AGGIUNTO - Esiste gia` un utente nel sistema con questo numero utente\n";}
	else
		{
		 if ( (strlen($user) < 2) or (strlen($pass) < 2) or (strlen($full_name) < 2) or (strlen($user) > 10) )
			{
			 echo "<br>UTENTE NON AGGIUNTO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>user id must be between 2 and 10 characters long\n";
			 echo "<br>il nome e la password devono essere lunghi almeno 2 caratteri\n";
			 echo "<!-- |$user|$pass|$full_name| -->\n";
			}
		 else
			{
			if (ereg('AUTOGENERA',$user))
				{
				$new_user=0;
				$auto_user_add_value=0;
				while ($new_user < 2)
					{
					if ($new_user < 1)
						{
						$stmt = "SELECT auto_user_add_value FROM system_settings;";
						$rslt=mysql_query($stmt, $link);
						$ss_auav_ct = mysql_num_rows($rslt);
						if ($ss_auav_ct > 0)
							{
							$row=mysql_fetch_row($rslt);
							$auto_user_add_value = $row[0];
							}
						$new_user++;
						}
					$stmt = "SELECT count(*) FROM vicidial_users where user='$auto_user_add_value';";
					$rslt=mysql_query($stmt, $link);
					$row=mysql_fetch_row($rslt);
					if ($row[0] < 1)
						{
						$new_user++;
						}
					else 
						{
						echo "<!-- AG: $auto_user_add_value -->\n";
						$auto_user_add_value = ($auto_user_add_value + 7);
						}
					}
				$user = $auto_user_add_value;
				echo "<br><B>user_id has been auto-generated: $user</B><br>\n";

				$stmt="UPDATE system_settings SET auto_user_add_value='$user';";
				$rslt=mysql_query($stmt, $link);
				}

			$stmt="INSERT INTO vicidial_users (user,pass,full_name,user_level,user_group,phone_login,phone_pass,delete_users,delete_user_groups,delete_lists,delete_campaigns,delete_ingroups,delete_remote_agents,load_leads,campaign_detail,ast_admin_access,ast_delete_phones,delete_scripts,modify_leads,hotkeys_active,change_agent_campaign,agent_choose_ingroups,closer_campaigns,scheduled_callbacks,agentonly_callbacks,agentcall_manual,vicidial_recording,vicidial_transfers,delete_filters,alter_agent_interface_options,closer_default_blended,delete_call_times,modify_call_times,modify_users,modify_campaigns,modify_lists,modify_scripts,modify_filters,modify_ingroups,modify_usergroups,modify_remoteagents,modify_servers,view_reports,vicidial_recording_override,alter_custdata_override,qc_enabled,qc_user_level,qc_pass,qc_finish,qc_commit,add_timeclock_log,modify_timeclock_log,delete_timeclock_log,alter_custphone_override,vdc_agent_api_access,modify_inbound_dids,delete_inbound_dids) SELECT \"$user\",\"$pass\",\"$full_name\",user_level,user_group,phone_login,phone_pass,delete_users,delete_user_groups,delete_lists,delete_campaigns,delete_ingroups,delete_remote_agents,load_leads,campaign_detail,ast_admin_access,ast_delete_phones,delete_scripts,modify_leads,hotkeys_active,change_agent_campaign,agent_choose_ingroups,closer_campaigns,scheduled_callbacks,agentonly_callbacks,agentcall_manual,vicidial_recording,vicidial_transfers,delete_filters,alter_agent_interface_options,closer_default_blended,delete_call_times,modify_call_times,modify_users,modify_campaigns,modify_lists,modify_scripts,modify_filters,modify_ingroups,modify_usergroups,modify_remoteagents,modify_servers,view_reports,vicidial_recording_override,alter_custdata_override,qc_enabled,qc_user_level,qc_pass,qc_finish,qc_commit,add_timeclock_log,modify_timeclock_log,delete_timeclock_log,alter_custphone_override,vdc_agent_api_access,modify_inbound_dids,delete_inbound_dids from vicidial_users where user=\"$source_user_id\";";
			$rslt=mysql_query($stmt, $link);

			$stmtA="INSERT INTO vicidial_inbound_group_agents (user,group_id,group_rank,group_weight,calls_today) SELECT \"$user\",group_id,group_rank,group_weight,\"0\" from vicidial_inbound_group_agents where user=\"$source_user_id\";";
			$rslt=mysql_query($stmtA, $link);

			$stmtA="INSERT INTO vicidial_campaign_agents (user,campaign_id,campaign_rank,campaign_weight,calls_today) SELECT \"$user\",campaign_id,campaign_rank,campaign_weight,\"0\" from vicidial_campaign_agents where user=\"$source_user_id\";";
			$rslt=mysql_query($stmtA, $link);

			echo "<br><B>USER COPIED: $user copied from $source_user_id</B>\n";
			echo "<br><br>\n";
			echo "<a href=\"$PHP_SELF?ADD=3&user=$user\">Click here to go to the user record</a>\n";
			echo "<br><br>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A COPIED USER   |$PHP_AUTH_USER|$ip|$user|$source_user_id|$stmt|\n");
				fclose($fp);
				}
			}
		}
exit;
}

######################
# ADD=21 adds the new campaign to the system
######################

if ($ADD==21)
{

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaigns where campaign_id='$campaign_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>CAMPAGNA NON AGGIUNTA - Esiste gia` una campagna nel sistema con questo ID\n";}
	else
		{
		$stmt="SELECT count(*) from vicidial_inbound_groups where group_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ($row[0] > 0)
			{echo "<br>CAMPAIGN NOT ADDED - there is already an inbound group in the system with this ID\n";}
		else
			{
			 if ( (strlen($campaign_id) < 2) or (strlen($campaign_id) > 8) or (strlen($campaign_name) < 6)  or (strlen($campaign_name) > 40) )
				{
				 echo "<br>CAMPAGNA NON AGGIUNTA - Per favore torna indietro e ricontrolla i dati inseriti\n";
				 echo "<br>L`ID Campagna deve essere lungo tra i 2 e gli 8 caratteri\n";
				 echo "<br>il nome della campagna deve essere lungo tra i 6 e i 40 caratteri\n";
				}
			 else
				{
				echo "<br><B>CAMPAGNA AGGIUNTA: $campaign_id</B>\n";

				$stmt="INSERT INTO vicidial_campaigns (campaign_id,campaign_name,campaign_description,active,dial_status_a,lead_order,park_ext,park_file_name,web_form_address,allow_closers,hopper_level,auto_dial_level,next_agent_call,local_call_time,voicemail_ext,campaign_script,get_call_launch,campaign_changedate,campaign_stats_refresh,list_order_mix) values('$campaign_id','$campaign_name','$campaign_description','$active','NEW','DOWN','$park_ext','$park_file_name','" . mysql_real_escape_string($web_form_address) . "','$allow_closers','$hopper_level','$auto_dial_level','$next_agent_call','$local_call_time','$voicemail_ext','$script_id','$get_call_launch','$SQLdate','Y','DISABLED');";
				$rslt=mysql_query($stmt, $link);

				$stmt="INSERT INTO vicidial_campaign_stats (campaign_id) values('$campaign_id');";
				$rslt=mysql_query($stmt, $link);

				echo "<!-- $stmt -->";
				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|NUOVA CAMPAGNA  |$PHP_AUTH_USER|$ip|$stmt|\n");
					fclose($fp);
					}

				}
			}
		}
$ADD=31;
}

######################
# ADD=20 adds copied new campaign to the system
######################

if ($ADD==20)
{

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaigns where campaign_id='$campaign_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>CAMPAGNA NON AGGIUNTA - Esiste gia` una campagna nel sistema con questo ID\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($campaign_id) > 8) or  (strlen($campaign_name) < 2) or (strlen($source_campaign_id) < 2) or (strlen($source_campaign_id) > 8) )
			{
			 echo "<br>CAMPAGNA NON AGGIUNTA - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>L`ID Campagna deve essere lungo tra i 2 e gli 8 caratteri\n";
			 echo "<br>source L`ID Campagna deve essere lungo tra i 2 e gli 8 caratteri\n";
			}
		 else
			{
			echo "<br><B>CAMPAIGN COPIED: $campaign_id copied from $source_campaign_id</B>\n";

			$stmt="INSERT INTO vicidial_campaigns (campaign_name,campaign_id,active,dial_status_a,dial_status_b,dial_status_c,dial_status_d,dial_status_e,lead_order,park_ext,park_file_name,web_form_address,allow_closers,hopper_level,auto_dial_level,next_agent_call,local_call_time,voicemail_ext,dial_timeout,dial_prefix,campaign_cid,campaign_vdad_exten,campaign_rec_exten,campaign_recording,campaign_rec_filename,campaign_script,get_call_launch,am_message_exten,amd_send_to_vmx,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,alt_number_dialing,scheduled_callbacks,lead_filter_id,drop_call_seconds,drop_action,safe_harbor_exten,display_dialable_count,wrapup_seconds,wrapup_message,closer_campaigns,use_internal_dnc,allcalls_delay,omit_phone_code,dial_method,available_only_ratio_tally,adaptive_dropped_percentage,adaptive_maximum_level,adaptive_latest_server_time,adaptive_intensity,adaptive_dl_diff_target,concurrent_transfers,auto_alt_dial,auto_alt_dial_statuses,agent_pause_codes_active,campaign_description,campaign_changedate,campaign_stats_refresh,campaign_logindate,dial_statuses,disable_alter_custdata,no_hopper_leads_logins,list_order_mix,campaign_allow_inbound,manual_dial_list_id,default_xfer_group,queue_priority,drop_inbound_group,qc_enabled,qc_statuses,qc_lists,qc_web_form_address,qc_script,survey_first_audio_file,survey_dtmf_digits,survey_ni_digit,survey_opt_in_audio_file,survey_ni_audio_file,survey_method,survey_no_response_action,survey_ni_status,survey_response_digit_map,survey_xfer_exten,survey_camp_record_dir,disable_alter_custphone,display_queue_count,qc_get_record_launch,qc_show_recording,qc_shift_id,manual_dial_filter,agent_clipboard_copy,agent_extended_alt_dial,use_campaign_dnc,three_way_call_cid) SELECT \"$campaign_name\",\"$campaign_id\",\"N\",dial_status_a,dial_status_b,dial_status_c,dial_status_d,dial_status_e,lead_order,park_ext,park_file_name,web_form_address,allow_closers,hopper_level,auto_dial_level,next_agent_call,local_call_time,voicemail_ext,dial_timeout,dial_prefix,campaign_cid,campaign_vdad_exten,campaign_rec_exten,campaign_recording,campaign_rec_filename,campaign_script,get_call_launch,am_message_exten,amd_send_to_vmx,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,alt_number_dialing,scheduled_callbacks,lead_filter_id,drop_call_seconds,drop_action,safe_harbor_exten,display_dialable_count,wrapup_seconds,wrapup_message,closer_campaigns,use_internal_dnc,allcalls_delay,omit_phone_code,dial_method,available_only_ratio_tally,adaptive_dropped_percentage,adaptive_maximum_level,adaptive_latest_server_time,adaptive_intensity,adaptive_dl_diff_target,concurrent_transfers,auto_alt_dial,auto_alt_dial_statuses,agent_pause_codes_active,campaign_description,campaign_changedate,campaign_stats_refresh,campaign_logindate,dial_statuses,disable_alter_custdata,no_hopper_leads_logins,\"DISABLED\",campaign_allow_inbound,manual_dial_list_id,default_xfer_group,queue_priority,drop_inbound_group,qc_enabled,qc_statuses,qc_lists,qc_web_form_address,qc_script,survey_first_audio_file,survey_dtmf_digits,survey_ni_digit,survey_opt_in_audio_file,survey_ni_audio_file,survey_method,survey_no_response_action,survey_ni_status,survey_response_digit_map,survey_xfer_exten,survey_camp_record_dir,disable_alter_custphone,display_queue_count,qc_get_record_launch,qc_show_recording,qc_shift_id,manual_dial_filter,agent_clipboard_copy,agent_extended_alt_dial,use_campaign_dnc,three_way_call_cid from vicidial_campaigns where campaign_id='$source_campaign_id';";
			$rslt=mysql_query($stmt, $link);

			$stmtA="INSERT INTO vicidial_campaign_stats (campaign_id) values('$campaign_id');";
			$rslt=mysql_query($stmtA, $link);

			$stmtA="INSERT INTO vicidial_campaign_statuses (status,status_name,selectable,campaign_id,human_answered,category) SELECT status,status_name,selectable,\"$campaign_id\",human_answered,category from vicidial_campaign_statuses where campaign_id='$source_campaign_id';";
			$rslt=mysql_query($stmtA, $link);

			$stmtA="INSERT INTO vicidial_campaign_hotkeys (status,hotkey,status_name,selectable,campaign_id) SELECT status,hotkey,status_name,selectable,\"$campaign_id\" from vicidial_campaign_hotkeys where campaign_id='$source_campaign_id';";
			$rslt=mysql_query($stmtA, $link);

			$stmtA="INSERT INTO vicidial_lead_recycle (status,attempt_delay,attempt_maximum,active,campaign_id) SELECT status,attempt_delay,attempt_maximum,active,\"$campaign_id\" from vicidial_lead_recycle where campaign_id='$source_campaign_id';";
			$rslt=mysql_query($stmtA, $link);

			$stmtA="INSERT INTO vicidial_pause_codes (pause_code,pause_code_name,billable,campaign_id) SELECT pause_code,pause_code_name,billable,\"$campaign_id\" from vicidial_pause_codes where campaign_id='$source_campaign_id';";
			$rslt=mysql_query($stmtA, $link);

			echo "<!-- $stmt -->";
			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|COPY TO NEW CAMPAIGN|$PHP_AUTH_USER|$ip|$campaign_id|$source_campaign_id|$stmt|$stmtA|\n");
				fclose($fp);
				}

			}
		}
$ADD=31;
}

######################
# ADD=22 adds the new campaign status to the system
######################

if ($ADD==22)
{

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaign_statuses where campaign_id='$campaign_id' and status='$status';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>ESITO CAMPAGNA NON AGGIUNTO - Esiste gia` un esito campagna con questo nome\n";}
	else
		{
		$stmt="SELECT count(*) from vicidial_statuses where status='$status';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ($row[0] > 0)
			{echo "<br>ESITO CAMPAGNA NON AGGIUNTO - esiste gia` un esito globale con questo nome\n";}
		else
			{
			 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) or (strlen($status_name) < 2) )
				{
				 echo "<br>ESITO CAMPAGNA NON AGGIUNTO - Per favore torna indietro e ricontrolla i dati inseriti\n";
				 echo "<br>l`esito deve essere lungo tra 1 e 8 caratteri\n";
				 echo "<br>il nome dell`esito deve essere lungo tra i 2 e i 30 caratteri\n";
				}
			 else
				{
				echo "<br><B>STATO PERSONALIZZATO PER CAMPAGNA AGGIUNTO: $campaign_id - $status</B>\n";

				$stmt="INSERT INTO vicidial_campaign_statuses (status,status_name,selectable,campaign_id,human_answered,category) values('$status','$status_name','$selectable','$campaign_id','$human_answered','$category');";
				$rslt=mysql_query($stmt, $link);

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|NUOVA CAMPAGNA STATUS |$PHP_AUTH_USER|$ip|$stmt|\n");
					fclose($fp);
					}
				}
			}
		}
$SUB=22;
$ADD=31;
}


######################
# ADD=23 adds the new campaign hotkey to the system
######################

if ($ADD==23)
{
	$HKstatus_data = explode('-----',$HKstatus);
	$status = $HKstatus_data[0];
	$status_name = $HKstatus_data[1];

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaign_hotkeys where campaign_id='$campaign_id' and hotkey='$hotkey' and hotkey='$hotkey';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>CAMPAIGN HOT KEY NOT ADDED - there is already a campaign-hotkey in the system with this hotkey\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) or (strlen($hotkey) < 1) )
			{
			 echo "<br>CAMPAÚA HOT KEY NO AGREGADA - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>hotkey must be a single character between 1 and 9 \n";
			 echo "<br>l`esito deve essere lungo tra 1 e 8 caratteri\n";
			}
		 else
			{
			echo "<br><B>HOTKEY AGGIUNTA: $campaign_id - $status - $hotkey</B>\n";

			$stmt="INSERT INTO vicidial_campaign_hotkeys values('$status','$hotkey','$status_name','$selectable','$campaign_id');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|NUOVA CAMPAGNA HOT KEY |$PHP_AUTH_USER|$ip|'$status','$hotkey','$status_name','$selectable','$campaign_id'|\n");
				fclose($fp);
				}
			}
		}
$SUB=23;
$ADD=31;
}


######################
# ADD=25 adds the new campaign lead recycle entry to the system
######################

if ($ADD==25)
{
	$status = eregi_replace("-----.*",'',$status);
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_lead_recycle where campaign_id='$campaign_id' and status='$status';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>El PLOMO de la CAMPAÑA RECICLA NO AGREGADO - hay ya unconducir-reciclaje para esta campaña con este estado\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) or ($attempt_delay < 120) or ($attempt_delay >= 43200) or ($attempt_maximum < 1) or ($attempt_maximum > 10) )
			{
			 echo "<br>CAMPAIGN LEAD RECYCLE NOT ADDED - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>el estado debe estar entre 1 y 6 caracteres en longitud\n";
			 echo "<br>la tentativa retrasa debe ser por lo menos 120 segundos and less than 43200 seconds or 12 hours\n";
			 echo "<br>las tentativas máximas deben ser a partir la 1 a 10\n";
			}
		 else
			{
			echo "<br><B>EL PLOMO DE LA CAMPAÑA RECICLA AGREGADO: $campaign_id - $status - $attempt_delay</B>\n";

			$stmt="INSERT INTO vicidial_lead_recycle(campaign_id,status,attempt_delay,attempt_maximum,active) values('$campaign_id','$status','$attempt_delay','$attempt_maximum','$active');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW LEAD RECYCLE    |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$SUB=25;
$ADD=31;
}


######################
# ADD=26 adds the new auto alt dial status to the campaign
######################

if ($ADD==26)
{
	$status = eregi_replace("-----.*",'',$status);
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaigns where campaign_id='$campaign_id' and auto_alt_dial_statuses LIKE \"% $status %\";";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>ESTADO AUTO DEL DIAL DEL ALT NO AGREGADO - hay ya una entrada para esta campaña con este estado\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) )
			{
			 echo "<br>ESTADO AUTO DEL DIAL DEL ALT NO AGREGADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>el estado debe estar entre 1 y 6 caracteres en longitud\n";
			}
		 else
			{
			echo "<br><B>ESTADO AUTO DEL DIAL DEL ALT AGREGADO: $campaign_id - $status</B>\n";

			$stmt="SELECT auto_alt_dial_statuses from vicidial_campaigns where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);

			if (strlen($row[0])<2) {$row[0] = ' -';}
			$auto_alt_dial_statuses = " $status$row[0]";
			$stmt="UPDATE vicidial_campaigns set auto_alt_dial_statuses='$auto_alt_dial_statuses' where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A AUTO-ALT-DIAL STATUS|$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$SUB=26;
$ADD=31;
}


######################
# ADD=27 adds the new campaign agent pause code entry to the system
######################

if ($ADD==27)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_pause_codes where campaign_id='$campaign_id' and pause_code='$pause_code';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>Co`DIGO DE LA PAUSA DEL AGENTE NO AGREGADO - hay ya una entrada para esta campaña con este code de la pausa\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($pause_code) < 1) or (strlen($pause_code) > 6) or (strlen($pause_code_name) < 2) )
			{
			 echo "<br>Co`DIGO DE LA PAUSA DEL AGENTE NO AGREGADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>pause code must be between 1 and 6 characters in length\n";
			 echo "<br>pause code name must be between 2 and 30 characters in length\n";
			}
		 else
			{
			echo "<br><B>EL Co`DIGO DE LA PAUSA DEL AGENTE AGREGo`: $campaign_id - $pause_code - $pause_code_name</B>\n";

			$stmt="INSERT INTO vicidial_pause_codes(campaign_id,pause_code,pause_code_name,billable) values('$campaign_id','$pause_code','$pause_code_name','$billable');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW AGENT PAUSE CODE|$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$SUB=27;
$ADD=31;
}


######################
# ADD=28 adds new status to the campaign dial statuses
######################

if ($ADD==28)
{
	$status = eregi_replace("-----.*",'',$status);
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaigns where campaign_id='$campaign_id' and dial_statuses LIKE \"% $status %\";";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>ESITO CHIAMATA PER CAMPAGNA NON AGGIUNTO - hay ya una entrada para esta campaña con este estado\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) )
			{
			 echo "<br>ESITO CHIAMATA PER CAMPAGNA NON AGGIUNTO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>el estado debe estar entre 1 y 6 caracteres en longitud\n";
			}
		 else
			{
			echo "<br><B>ESITO CHIAMATA PER CAMPAGNA AGGIUNTO: $campaign_id - $status</B>\n";

			$stmt="SELECT dial_statuses from vicidial_campaigns where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);

			if (strlen($row[0])<2) {$row[0] = ' -';}
			$dial_statuses = " $status$row[0]";
			$stmt="UPDATE vicidial_campaigns set dial_statuses='$dial_statuses' where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|AGGIUNGI CAMPAGNA DIAL STATUS  |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
#$SUB=28;
$ADD=31;
}


######################
# ADD=211 adds the new list to the system
######################

if ($ADD==211)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_lists where list_id='$list_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>LISTA NON AGGIUNTA - Esiste gia` una lista nel sistema con questo ID\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($list_name) < 2)  or ($list_id < 100) or (strlen($list_id) > 8) )
			{
			 echo "<br>LISTA NON AGGIUNTA - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>La ID de la lista debe estar entre 2 y 8 caracteres en longitud\n";
			 echo "<br>El nombre de la lista debe ser por lo menos 2 caracteres en longitud\n";
			 echo "<br>ID Lista must be greater than 100\n";
			 }
		 else
			{
			echo "<br><B>LISTA AGGIUNTA: $list_id</B>\n";

			$stmt="INSERT INTO vicidial_lists (list_id,list_name,campaign_id,active,list_description,list_changedate) values('$list_id','$list_name','$campaign_id','$active','$list_description','$SQLdate');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|AGGIUNGI NUOVA LISTA      |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=311;
}



######################
# ADD=2111 adds the new inbound group to the system
######################

if ($ADD==2111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_inbound_groups where group_id='$group_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>GRUPPO NON AGGIUNTO - l`ID specificato e` associato ad un gruppo gia` presente in sistema\n";}
	else
		{
		$stmt="SELECT count(*) from vicidial_campaigns where campaign_id='$group_id';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ($row[0] > 0)
			{echo "<br>GROUP NOT ADDED - there is already a campaign in the system with this ID\n";}
		else
			{
			 if ( (strlen($group_id) < 2) or (strlen($group_name) < 2)  or (strlen($group_color) < 2) or (strlen($group_id) > 20) or (eregi(' ',$group_id)) or (eregi("\-",$group_id)) or (eregi("\+",$group_id)) )
				{
				 echo "<br>GRUPPO NON AGGIUNTO - per favore torna indietro e ricontrolla i dati inseriti\n";
				 echo "<br>L`ID deve essere lungo tra i 2 e i 20 caratteri e non deve contenere ' -+'.\n";
				 echo "<br>Il nome ed il colore del gruppo devono essere lunghi almeno 2 caratteri\n";
				}
			 else
				{
				$stmt="INSERT INTO vicidial_inbound_groups (group_id,group_name,group_color,active,web_form_address,voicemail_ext,next_agent_call,fronter_display,ingroup_script,get_call_launch) values('$group_id','$group_name','$group_color','$active','" . mysql_real_escape_string($web_form_address) . "','$voicemail_ext','$next_agent_call','$fronter_display','$script_id','$get_call_launch');";
				$rslt=mysql_query($stmt, $link);

				$stmt="INSERT INTO vicidial_campaign_stats (campaign_id) values('$group_id');";
				$rslt=mysql_query($stmt, $link);

				echo "<br><B>GRUPPO AGGIUNTO: $group_id</B>\n";

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|ADD A NEW GROUP     |$PHP_AUTH_USER|$ip|$stmt|\n");
					fclose($fp);
					}
				}
			}
		}
$ADD=3111;
}


######################
# ADD=2011 adds copied inbound group to the system
######################

if ($ADD==2011)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_inbound_groups where group_id='$group_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>GRUPPO NON AGGIUNTO - l`ID specificato e` associato ad un gruppo gia` presente in sistema\n";}
	else
		{
		 if ( (strlen($group_id) < 2) or (strlen($group_name) < 2) or (strlen($group_id) > 20) or (eregi(' ',$group_id)) or (eregi("\-",$group_id)) or (eregi("\+",$group_id)) )
			{
			 echo "<br>GRUPPO NON AGGIUNTO - per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>L`ID deve essere lungo tra i 2 e i 20 caratteri e non deve contenere ' -+'.\n";
			 echo "<br>Il nome ed il colore del gruppo devono essere lunghi almeno 2 caratteri\n";
			}
		 else
			{
			$stmt="INSERT INTO vicidial_inbound_groups (group_id,group_name,group_color,active,web_form_address,voicemail_ext,next_agent_call,fronter_display,ingroup_script,get_call_launch,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,drop_call_seconds,drop_action,drop_exten,call_time_id,after_hours_action,after_hours_message_filename,after_hours_exten,after_hours_voicemail,welcome_message_filename,moh_context,onhold_prompt_filename,prompt_interval,agent_alert_exten,agent_alert_delay,default_xfer_group,queue_priority,drop_inbound_group,ingroup_recording_override,ingroup_rec_filename,afterhours_xfer_group,qc_enabled,qc_statuses,qc_shift_id,qc_get_record_launch,qc_show_recording,qc_web_form_address,qc_script,play_place_in_line,play_estimate_hold_time,hold_time_option,hold_time_option_seconds,hold_time_option_exten,hold_time_option_voicemail,hold_time_option_xfer_group,hold_time_option_callback_filename,hold_time_option_callback_list_id,hold_recall_xfer_group,no_delay_call_route,play_welcome_message) SELECT \"$group_id\",\"$group_name\",group_color,\"N\",web_form_address,voicemail_ext,next_agent_call,fronter_display,ingroup_script,get_call_launch,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,drop_call_seconds,drop_action,drop_exten,call_time_id,after_hours_action,after_hours_message_filename,after_hours_exten,after_hours_voicemail,welcome_message_filename,moh_context,onhold_prompt_filename,prompt_interval,agent_alert_exten,agent_alert_delay,default_xfer_group,queue_priority,drop_inbound_group,ingroup_recording_override,ingroup_rec_filename,afterhours_xfer_group,qc_enabled,qc_statuses,qc_shift_id,qc_get_record_launch,qc_show_recording,qc_web_form_address,qc_script,play_place_in_line,play_estimate_hold_time,hold_time_option,hold_time_option_seconds,hold_time_option_exten,hold_time_option_voicemail,hold_time_option_xfer_group,hold_time_option_callback_filename,hold_time_option_callback_list_id,hold_recall_xfer_group,no_delay_call_route,play_welcome_message from vicidial_inbound_groups where group_id=\"$source_group_id\";";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>GRUPPO AGGIUNTO: $group_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|COPIED TO NEW GROUP |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=3111;
}


######################
# ADD=2311 adds the new did to the system
######################

if ($ADD==2311)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_inbound_dids where did_id='$did_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>DID NOT ADDED - there is already a DID in the system with this ID\n";}
	else
		{
		$stmt="SELECT count(*) from vicidial_inbound_dids where did_pattern='$did_pattern';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ($row[0] > 0)
			{echo "<br>DID NOT ADDED - there is already a DID in the system with this extension\n";}
		else
			{
			 if ( (strlen($source_did) < 1) or (strlen($did_pattern) < 1) or (eregi(' ',$source_did)) or (eregi(' ',$did_pattern)) or (eregi("\+",$source_did)) )
				{
				 echo "<br>DID NOT ADDED - Per favore torna indietro e ricontrolla i dati inseriti\n";
				 echo "<br>DID Extension must be between 2 and 20 characters in length and contain no ' -+'.\n";
				}
			 else
				{
				$stmt="INSERT INTO vicidial_inbound_dids (did_pattern,did_description) values('$did_pattern','$did_description');";
				$rslt=mysql_query($stmt, $link);

				$stmt="SELECT did_id from vicidial_inbound_dids where did_pattern='$did_pattern';";
				$rslt=mysql_query($stmt, $link);
				$row=mysql_fetch_row($rslt);
				$did_id = $row[0];

				echo "<br><B>DID ADDED: $did_pattern $did_description    - $did_id</B>\n";

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|ADD A DID           |$PHP_AUTH_USER|$ip|$stmt|\n");
					fclose($fp);
					}
				}
			}
		}
$ADD=3311;
}


######################
# ADD=2411 adds copied did to the system
######################

if ($ADD==2411)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_inbound_dids where did_pattern='$did_pattern';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>DID NOT ADDED - there is already a DID in the system with this extension\n";}
	else
		{
		 if ( (strlen($did_id) < 1) or (strlen($did_pattern) < 1) or (eregi(' ',$did_id)) or (eregi(' ',$did_pattern)) or (eregi("\+",$did_id)) )
			{
			 echo "<br>DID NOT ADDED - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>DID Extension must be between 2 and 20 characters in length and contain no ' -+'.\n";
			}
		 else
			{
			$stmt="INSERT INTO vicidial_inbound_dids (did_pattern,did_description,did_active,did_route,extension,exten_context,voicemail_ext,phone,server_ip,user,user_unavailable_action,user_route_settings_ingroup,group_id,call_handle_method,agent_search_method,list_id,campaign_id,phone_code) SELECT \"$did_pattern\",\"$did_description\",did_active,did_route,extension,exten_context,voicemail_ext,phone,server_ip,user,user_unavailable_action,user_route_settings_ingroup,group_id,call_handle_method,agent_search_method,list_id,campaign_id,phone_code from vicidial_inbound_dids where did_id=\"$source_did\";";
			$rslt=mysql_query($stmt, $link);

			$stmt="SELECT did_id from vicidial_inbound_dids where did_pattern='$did_pattern';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			$did_id = $row[0];

			echo "<br><B>DID ADDED: $did_pattern     - $did_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|COPY A DID          |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=3311;
}


######################
# ADD=21111 adds new remote agents to the system
######################

if ($ADD==21111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_remote_agents where server_ip='$server_ip' and user_start='$user_start';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>AGENTES ALEJADOS NO AGREGADOS - hay ya una entrada alejada de los agentes comenzando con esta ID del usuario\n";}
	else
		{
		 if ( (strlen($server_ip) < 2) or (strlen($user_start) < 2)  or (strlen($campaign_id) < 2) or (strlen($conf_exten) < 2) )
			{
			 echo "<br>AGENTES ALEJADOS NO AGREGADOS - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>El comienzo de la ID del usuario y la extension externa deben ser por lo menos 2 caracteres en longitud\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_remote_agents values('','$user_start','$number_of_lines','$server_ip','$conf_exten','$status','$campaign_id','$groups_value');";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>OPERATORE REMOTO AGGIUNTO: $user_start</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW OPERATORI REMOTI ENTRY     |$PHP_AUTH_USER|$ip|'$user_start','$number_of_lines','$server_ip','$conf_exten','$status','$campaign_id','$groups_value'|\n");
				fclose($fp);
				}
			}
		}
$ADD=10000;
}

######################
# ADD=211111 adds new user group to the system
######################

if ($ADD==211111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_user_groups where user_group='$user_group';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>GRUPO de USUARIO NO AGREGADO - hay ya una entrada del grupo de usuario con este nombre\n";}
	else
		{
		 if ( (strlen($user_group) < 2) or (strlen($group_name) < 2) )
			{
			 echo "<br>GRUPO de USUARIO NO AGREGADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>El nombre y la descripcio`n de grupo deben ser por lo menos 2 caracteres en longitud\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_user_groups(user_group,group_name,allowed_campaigns) values('$user_group','$group_name','-ALL-CAMPAIGNS-');";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>GRUPPO UTENTI AGGIUNTO: $user_group</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|NUOVO UTENTE  GROUP ENTRY     |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=100000;
}

######################
# ADD=2111111 adds new script to the system
######################

if ($ADD==2111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_scripts where script_id='$script_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>SCRIPT NON AGGIUNTO - hay ya una entrada de la escritura con este nombre\n";}
	else
		{
		 if ( (strlen($script_id) < 2) or (strlen($script_name) < 2) or (strlen($script_text) < 2) )
			{
			 echo "<br>SCRIPT NON AGGIUNTO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>El nombre, la descripcio`n y el texto de la escritura deben ser por lo menos 2 caracteres en longitud\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_scripts values('$script_id','$script_name','$script_comments','$script_text','$active');";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>SCRIPT AGGIUNTO: $script_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW SCRIPT ENTRY         |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=1000000;
}


######################
# ADD=21111111 adds new filter to the system
######################

if ($ADD==21111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_lead_filters where lead_filter_id='$lead_filter_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>FILTRO NON AGGIUNTO - Esiste gia` un altro filtro con questo ID\n";}
	else
		{
		 if ( (strlen($lead_filter_id) < 2) or (strlen($lead_filter_name) < 2) or (strlen($lead_filter_sql) < 2) )
			{
			 echo "<br>FILTRO NON AGGIUNTO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>ID Filtro, nome e SQL devono essere lunghi almeno 2 caratteri\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_lead_filters SET lead_filter_id='$lead_filter_id',lead_filter_name='$lead_filter_name',lead_filter_comments='$lead_filter_comments',lead_filter_sql='$lead_filter_sql';";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>FILTRO AGGIUNTO: $lead_filter_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW FILTER ENTRY         |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=10000000;
}


######################
# ADD=211111111 adds new call time definition to the system
######################

if ($ADD==211111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_call_times where call_time_id='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>DEFINICIo`N DEL TIEMPO DE LA LLAMADA NO AGREGADA - hay ya una entrada de tiempo de la llamada con esta identificacio`n\n";}
	else
		{
		 if ( (strlen($call_time_id) < 2) or (strlen($call_time_name) < 2) )
			{
			 echo "<br>DEFINICIo`N DEL TIEMPO DE LA LLAMADA NO AGREGADA - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>La identificacio`n del tiempo de la llamada y el nombre deben ser porlo menos 2 caracteres en longitud\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_call_times SET call_time_id='$call_time_id',call_time_name='$call_time_name',call_time_comments='$call_time_comments';";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>ORARIO CHIAMATE AGGIUNTO: $call_time_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW CALL TIME ENTRY      |$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=311111111;
}


######################
# ADD=2111111111 adds new state call time definition to the system
######################

if ($ADD==2111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_state_call_times where state_call_time_id='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>DEFINICIo`N DEL TIEMPO DE LA LLAMADA DEL ESTADO NO AGREGADA - hay ya una entrada de tiempo de la llamada con esta identificacio`n\n";}
	else
		{
		 if ( (strlen($call_time_id) < 2) or (strlen($call_time_name) < 2) or (strlen($state_call_time_state) < 2) )
			{
			 echo "<br>DEFINICIo`N DEL TIEMPO DE LA LLAMADA DEL ESTADO NO AGREGADA - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>Indique que identificacio`n del tiempo de la llamada, nombre y estadodebe ser por lo menos 2 caracteres en longitud\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_state_call_times SET state_call_time_id='$call_time_id',state_call_time_name='$call_time_name',state_call_time_comments='$call_time_comments',state_call_time_state='$state_call_time_state';";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>ORARIO CHIAMATE PER STATO AGGIUNTO: $call_time_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW STATE CALL TIME ENTRY|$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=3111111111;
}


######################
# ADD=231111111 adds new shift definition to the system
######################

if ($ADD==231111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_shifts where shift_id='$shift_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>SHIFT DEFINITION NOT ADDED - there is already a shift entry with this ID\n";}
	else
		{
		$shift_length_test = eregi_replace(':','',$shift_length);
		 if ( (strlen($shift_id) < 2) or (strlen($shift_name) < 2) or (strlen($shift_start_time) < 4) or (strlen($shift_start_time) > 4) or (strlen($shift_length) < 5) or (strlen($shift_length) > 5) or ($shift_start_time > 2359) or ($shift_length_test > 2400) )
			{
			 echo "<br>SHIFT DEFINITION NOT ADDED - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>Shift ID and name must be at least 2 characters in length\n";
			 echo "<br>Shift Start Time must be 4 digits in length and be a valid time\n";
			 echo "<br>Shift Length must be 5 characters in length and be 24 hours or less\n";
			 }
		 else
			{
			$p=0;
			$shift_weekdays_ct = count($shift_weekdays);
			while ($p <= $shift_weekdays_ct)
				{
				$SHIFT_weekdays .= "$shift_weekdays[$p]";
				$p++;
				}
			$stmt="INSERT INTO vicidial_shifts SET shift_id='$shift_id',shift_name='$shift_name',shift_start_time='$shift_start_time',shift_length='$shift_length',shift_weekdays='$SHIFT_weekdays';";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>SHIFT ADDED: $shift_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW SHIFT ENTRY          |$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=331111111;
}


######################
# ADD=21111111111 adds new phone to the system
######################

if ($ADD==21111111111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from phones where extension='$extension' and server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>telefonO NO AGREGADO - hay ya un telefono en el sistema con esta extension/servidor\n";}
	else
		{
		$stmt="SELECT count(*) from phones where login='$login';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ($row[0] > 0)
			{echo "<br>PHONE NOT ADDED - there is already a Phone in the system with this login\n";}
		else
			{
			$stmt="SELECT count(*) from phones_alias where alias_id='$login';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			if ($row[0] > 0)
				{echo "<br>PHONE NOT ADDED - there is already a Phone alias in the system with this login\n";}
			else
				{
				 if ( (strlen($extension) < 1) or (strlen($server_ip) < 7) or (strlen($dialplan_number) < 1) or (strlen($voicemail_id) < 1) or (strlen($login) < 1)  or (strlen($pass) < 1))
					{echo "<br>telefonO NO AGREGADO - Per favore torna indietro e ricontrolla i dati inseriti\n";}
				 else
					{
					echo "<br>TELEFONO AGGIUNTO\n";

					$stmt="INSERT INTO phones (extension,dialplan_number,voicemail_id,phone_ip,computer_ip,server_ip,login,pass,status,active,phone_type,fullname,company,picture,protocol,local_gmt,outbound_cid) values('$extension','$dialplan_number','$voicemail_id','$phone_ip','$computer_ip','$server_ip','$login','$pass','$status','$active','$phone_type','$fullname','$company','$picture','$protocol','$local_gmt','$outbound_cid');";
					$rslt=mysql_query($stmt, $link);

					### LOG CHANGES TO LOG FILE ###
					if ($WeBRooTWritablE > 0)
						{
						$fp = fopen ("./admin_changes_log.txt", "a");
						fwrite ($fp, "$date|AGGIUNGI UN NUOVO TELEFONO                |$stmt|\n");
						fclose($fp);
						}
					}
				}
			}
		}
$ADD=31111111111;
}


######################
# ADD=22111111111 adds new phone alias to the system
######################

if ($ADD==22111111111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from phones_alias where alias_id='$alias_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>PHONE ALIAS NOT ADDED - there is already a Phone Alias in the system with this ID\n";}
	else
		{
		$stmt="SELECT count(*) from phones where login='$alias_id';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ($row[0] > 0)
			{echo "<br>PHONE ALIAS NOT ADDED - there is already a Login Telefono in the system with this ID\n";}
		else
			{
			 if ( (strlen($alias_id) < 1) or (strlen($alias_name) < 2) )
				{echo "<br>PHONE ALIAS NOT ADDED - Per favore torna indietro e ricontrolla i dati inseriti\n";}
			 else
				{
				echo "<br>PHONE ALIAS ADDED\n";

				$stmt="INSERT INTO phones_alias (alias_id,alias_name,logins_list) values('$alias_id','$alias_name','$logins_list');";
				$rslt=mysql_query($stmt, $link);

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|AGGIUNGI UN NUOVO TELEFONO ALIAS          |$stmt|\n");
					fclose($fp);
					}
				}
			}
		}
$ADD=32111111111;
}


######################
# ADD=211111111111 adds new server to the system
######################

if ($ADD==211111111111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from servers where server_id='$server_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>SERVER NON AGGIUNTO - Esiste gia` un altro server nel sistema con questo ID\n";}
	else
		{
		 if ( (strlen($server_id) < 1) or (strlen($server_ip) < 7) )
			{echo "<br>SERVER NON AGGIUNTO - Per favore torna indietro e ricontrolla i dati inseriti\n";}
		 else
			{
			echo "<br>SERVER AGGIUNTO\n";

			$stmt="INSERT INTO servers (server_id,server_description,server_ip,active,asterisk_version) values('$server_id','$server_description','$server_ip','$active','$asterisk_version');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|AGGIUNGI UN NUOVO SERVER               |$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=311111111111;
}


######################
# ADD=221111111111 adds the new vicidial server trunk record to the system
######################

if ($ADD==221111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT max_vicidial_trunks from servers where server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$rowx=mysql_fetch_row($rslt);
	$MAXvicidial_trunks = $rowx[0];
	
	$stmt="SELECT sum(dedicated_trunks) from vicidial_server_trunks where server_ip='$server_ip' and campaign_id !='$campaign_id';";
	$rslt=mysql_query($stmt, $link);
	$rowx=mysql_fetch_row($rslt);
	$SUMvicidial_trunks = ($rowx[0] + $dedicated_trunks);
	
	if ($SUMvicidial_trunks > $MAXvicidial_trunks)
		{
		echo "<br>EXPEDIENTE DEL TRONCO DEL SERVIDOR DE VICIDIAL NO AGREGADO - el número de troncos vicidial es demasiado alto: $SUMvicidial_trunks / $MAXvicidial_trunks\n";
		}
	else
		{
		$stmt="SELECT count(*) from vicidial_server_trunks where campaign_id='$campaign_id' and server_ip='$server_ip';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ($row[0] > 0)
			{echo "<br>EXPEDIENTE DEL TRONCO DEL SERVIDOR DE VICIDIAL NO AGREGADO - hay ya un expediente del servidor-tronco para esta campaña\n";}
		else
			{
			 if ( (strlen($campaign_id) < 2) or (strlen($server_ip) < 7) or (strlen($dedicated_trunks) < 1) or (strlen($trunk_restriction) < 1) )
				{
				 echo "<br>EXPEDIENTE DEL TRONCO DEL SERVIDOR DE VICIDIAL NO AGREGADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
				 echo "<br>la campaña debe estar entre 3 y 8 caracteres en longitud\n";
				 echo "<br>el server_ip retrasa debe ser por lo menos 7 caracteres\n";
				 echo "<br>los troncos deben ser un dígito a partir de la 0 a 9999\n";
				}
			 else
				{
				echo "<br><B>EL EXPEDIENTE DEL TRONCO DEL SERVIDOR DE VICIDIAL AGREGo`: $campaign_id - $server_ip - $dedicated_trunks - $trunk_restriction</B>\n";

				$stmt="INSERT INTO vicidial_server_trunks(server_ip,campaign_id,dedicated_trunks,trunk_restriction) values('$server_ip','$campaign_id','$dedicated_trunks','$trunk_restriction');";
				$rslt=mysql_query($stmt, $link);

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|ADD A NEW VICIDIAL TRUNK  |$PHP_AUTH_USER|$ip|$stmt|\n");
					fclose($fp);
					}
				}
			}
		}
$ADD=311111111111;
}


######################
# ADD=2111111111111 adds new conference to the system
######################

if ($ADD==2111111111111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from conferences where conf_exten='$conf_exten' and server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>CONFERENZA NON AGGIUNTA - Esiste gia` una conferenza nel sistema con questo ID e server\n";}
	else
		{
		 if ( (strlen($conf_exten) < 1) or (strlen($server_ip) < 7) )
			{echo "<br>CONFERENZA NON AGGIUNTA - Per favore torna indietro e ricontrolla i dati inseriti\n";}
		 else
			{
			echo "<br>CONFERENZA AGGIUNTA\n";

			$stmt="INSERT INTO conferences (conf_exten,server_ip) values('$conf_exten','$server_ip');";
			$rslt=mysql_query($stmt, $link);
			}
		}
$ADD=3111111111111;
}


######################
# ADD=21111111111111 adds new vicidial conference to the system
######################

if ($ADD==21111111111111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_conferences where conf_exten='$conf_exten' and server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>VICIDIAL CONFERENCE NOT ADDED - there is already a vicidial conference in the system with this ID and server\n";}
	else
		{
		 if ( (strlen($conf_exten) < 1) or (strlen($server_ip) < 7) )
			{echo "<br>VICIDIAL CONFERENZA NON AGGIUNTA - Per favore torna indietro e ricontrolla i dati inseriti\n";}
		 else
			{
			echo "<br>VICIDIAL CONFERENZA AGGIUNTA\n";

			$stmt="INSERT INTO vicidial_conferences (conf_exten,server_ip) values('$conf_exten','$server_ip');";
			$rslt=mysql_query($stmt, $link);
			}
		}
$ADD=31111111111111;
}


######################
# ADD=221111111111111 adds the new system status to the system
######################

if ($ADD==221111111111111)
{

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaign_statuses where status='$status';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>ESITO DI DEFAULT NON AGGIUNTO - there is already a campaign-status in the system with this name: $row[0]\n";}
	else
		{
		$stmt="SELECT count(*) from vicidial_statuses where status='$status';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ($row[0] > 0)
			{echo "<br>ESITO DI DEFAULT NON AGGIUNTO - there is already a global-status in the system with this name\n";}
		else
			{
			 if ( (strlen($status) < 1) or (strlen($status_name) < 2) )
				{
				 echo "<br>ESITO DI DEFAULT NON AGGIUNTO - Per favore torna indietro e ricontrolla i dati inseriti\n";
				 echo "<br>l`esito deve essere lungo tra 1 e 8 caratteri\n";
				 echo "<br>il nome dell`esito deve essere lungo tra i 2 e i 30 caratteri\n";
				}
			 else
				{
				echo "<br><B>ESITO DI DEFAULT AGGIUNTO: $status_name - $status</B>\n";

				$stmt="INSERT INTO vicidial_statuses (status,status_name,selectable,human_answered,category) values('$status','$status_name','$selectable','$human_answered','$category');";
				$rslt=mysql_query($stmt, $link);

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|ADD A NEW SYSTEM STATUS   |$PHP_AUTH_USER|$ip|$stmt|\n");
					fclose($fp);
					}
				}
			}
		}
$ADD=321111111111111;
}


######################
# ADD=231111111111111 adds the new status category to the system
######################

if ($ADD==231111111111111)
{

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_status_categories where vsc_id='$vsc_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>CATEGORIA DI ESITI NON AGGIUNTA - Esiste gia` una categoria di esiti con questo ID: $row[0]\n";}
	else
		{
		 if ( (strlen($vsc_id) < 2) or (strlen($vsc_id) > 20) or (strlen($vsc_name) < 2) )
			{
			 echo "<br>CATEGORIA DI ESITI NON AGGIUNTA - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>L` ID deve essere lungo tra i 2 e i 50 caratteri\n";
			 echo "<br>il nome deve essere lungo tra i 2 e i 50 caratteri\n";
			}
		 else
			{
			echo "<br><B>STATUS CATEGORY ADDED: $vsc_id - $vsc_name</B>\n";

			$stmt="SELECT count(*) from vicidial_status_categories where tovdad_display='Y' and vsc_id NOT IN('$vsc_id');";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			if ( ($row[0] > 3) and (ereg('Y',$tovdad_display)) )
				{
				$tovdad_display = 'N';
				echo "<br><B>ERRORE: Ci sono gia` 4 Categorie di Stato attivi nel display TimeOnVDAD</B>\n";
				}

			$stmt="INSERT INTO vicidial_status_categories (vsc_id,vsc_name,vsc_description,tovdad_display,sale_category,dead_lead_category) values('$vsc_id','$vsc_name','$vsc_description','$tovdad_display','$sale_category','$dead_lead_category');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW STATUS CATEGORY |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=331111111111111;
}



######################
# ADD=241111111111111 adds the new qc status code to the system
######################

if ($ADD==241111111111111)
{

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_qc_codes where code='$code';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>QC STATUS CODE NOT ADDED - there is already a qc status code in the system with this name: $row[0]\n";}
	else
		{
		 if ( (strlen($code) < 1) or (strlen($code_name) < 2) )
			{
			 echo "<br>QC STATUS CODE NOT ADDED - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>code must be between 1 and 8 characters in length\n";
			 echo "<br>code name must be between 2 and 30 characters in length\n";
			}
		 else
			{
			echo "<br><B>QC STATUS CODE ADDED: $code_name - $code</B>\n";

			$stmt="INSERT INTO vicidial_qc_codes (code,code_name) values('$code','$code_name');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW QC STATUS CODE  |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
$ADD=341111111111111;
}



######################################################################################################
######################################################################################################
#######   4 series, record modifications submitted and DB is modified, then on to 3 series forms below
######################################################################################################
######################################################################################################



######################
# ADD=4A submit user modifications to the system - ADMIN
######################

if ($ADD=="4A")
{
	if ($LOGmodify_users==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($pass) < 2) or (strlen($full_name) < 2) or (strlen($user_level) < 1) )
		{
		 echo "<br>USUARIO NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>La contraseña y el nombre completo cada ot de la necesidad sean por lo menos 2 caracteres en longitud\n";
		}
	 else
		{
		echo "<br><B>UTENTE MODIFICATO - ADMIN: $user</B>\n";

		$stmt="UPDATE vicidial_users set pass='$pass',full_name='$full_name',user_level='$user_level',user_group='$user_group',phone_login='$phone_login',phone_pass='$phone_pass',delete_users='$delete_users',delete_user_groups='$delete_user_groups',delete_lists='$delete_lists',delete_campaigns='$delete_campaigns',delete_ingroups='$delete_ingroups',delete_remote_agents='$delete_remote_agents',load_leads='$load_leads',campaign_detail='$campaign_detail',ast_admin_access='$ast_admin_access',ast_delete_phones='$ast_delete_phones',delete_scripts='$delete_scripts',modify_leads='$modify_leads',hotkeys_active='$hotkeys_active',change_agent_campaign='$change_agent_campaign',agent_choose_ingroups='$agent_choose_ingroups',closer_campaigns='$groups_value',scheduled_callbacks='$scheduled_callbacks',agentonly_callbacks='$agentonly_callbacks',agentcall_manual='$agentcall_manual',vicidial_recording='$vicidial_recording',vicidial_transfers='$vicidial_transfers',delete_filters='$delete_filters',alter_agent_interface_options='$alter_agent_interface_options',closer_default_blended='$closer_default_blended',delete_call_times='$delete_call_times',modify_call_times='$modify_call_times',modify_users='$modify_users',modify_campaigns='$modify_campaigns',modify_lists='$modify_lists',modify_scripts='$modify_scripts',modify_filters='$modify_filters',modify_ingroups='$modify_ingroups',modify_usergroups='$modify_usergroups',modify_remoteagents='$modify_remoteagents',modify_servers='$modify_servers',view_reports='$view_reports',vicidial_recording_override='$vicidial_recording_override',alter_custdata_override='$alter_custdata_override',qc_enabled='$qc_enabled',qc_user_level='$qc_user_level',qc_pass='$qc_pass',qc_finish='$qc_finish',qc_commit='$qc_commit',add_timeclock_log='$add_timeclock_log',modify_timeclock_log='$modify_timeclock_log',delete_timeclock_log='$delete_timeclock_log',alter_custphone_override='$alter_custphone_override',vdc_agent_api_access='$vdc_agent_api_access',modify_inbound_dids='$modify_inbound_dids',delete_inbound_dids='$delete_inbound_dids' where user='$user';";
		$rslt=mysql_query($stmt, $link);


		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY USER INFO    |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=3;		# go to user modification below
}


######################
# ADD=4B submit user modifications to the system - ADMIN
######################

if ($ADD=="4B")
{
	if ($LOGmodify_users==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($pass) < 2) or (strlen($full_name) < 2) or (strlen($user_level) < 1) )
		{
		 echo "<br>USUARIO NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>La contraseña y el nombre completo cada ot de la necesidad sean por lo menos 2 caracteres en longitud\n";
		}
	 else
		{
		echo "<br><B>UTENTE MODIFICATO - ADMIN: $user</B>\n";

		$stmt="UPDATE vicidial_users set pass='$pass',full_name='$full_name',user_level='$user_level',user_group='$user_group',phone_login='$phone_login',phone_pass='$phone_pass',hotkeys_active='$hotkeys_active',agent_choose_ingroups='$agent_choose_ingroups',closer_campaigns='$groups_value',scheduled_callbacks='$scheduled_callbacks',agentonly_callbacks='$agentonly_callbacks',agentcall_manual='$agentcall_manual',vicidial_recording='$vicidial_recording',vicidial_transfers='$vicidial_transfers',closer_default_blended='$closer_default_blended',vicidial_recording_override='$vicidial_recording_override',alter_custdata_override='$alter_custdata_override',qc_enabled='$qc_enabled',qc_user_level='$qc_user_level',qc_pass='$qc_pass',qc_finish='$qc_finish',qc_commit='$qc_commit',alter_custphone_override='$alter_custphone_override' where user='$user';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY USER INFO    |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=3;		# go to user modification below
}



######################
# ADD=4 submit user modifications to the system
######################

if ($ADD==4)
{
	if ($LOGmodify_users==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($pass) < 2) or (strlen($full_name) < 2) or (strlen($user_level) < 1) )
		{
		 echo "<br>USUARIO NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>La contraseña y el nombre completo cada ot de la necesidad sean por lo menos 2 caracteres en longitud\n";
		}
	 else
		{
		echo "<br><B>UTENTE MODIFICATO: $user</B>\n";

		$stmt="UPDATE vicidial_users set pass='$pass',full_name='$full_name',user_level='$user_level',user_group='$user_group',phone_login='$phone_login',phone_pass='$phone_pass' where user='$user';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY USER INFO    |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=3;		# go to user modification below
}

######################
# ADD=41 submit campaign modifications to the system
######################

if ($ADD==41)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_name) < 6) or (strlen($active) < 1) )
		{
		 echo "<br>CAMPAÚA NO MODIFICADA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>el nombre de la campaña necesita ser por lo menos 6 caracteres en longitud\n";
		 echo "<br>|$campaign_name|$active|\n";
		}
	 else
		{
		echo "<br><B>CAMPAGNA MODIFICATA: $campaign_id</B>\n";

		if ($dial_method == 'MANUAL') 
			{
			$auto_dial_level='0';
			$adlSQL = "auto_dial_level='0',";
			}
		else
			{
			if ($dial_level_override > 0)
				{
				$adlSQL = "auto_dial_level='$auto_dial_level',";
				}
			else
				{
				if ($dial_method == 'RATIO')
					{
					if ($auto_dial_level < 1) {$auto_dial_level = "1.0";}
					$adlSQL = "auto_dial_level='$auto_dial_level',";
					}
				else
					{
					$adlSQL = "";
					if ($auto_dial_level < 1) 
						{
						$auto_dial_level = "1.0";
						$adlSQL = "auto_dial_level='$auto_dial_level',";
						}
					}
				}
			}
		if ( (!ereg("DISABLED",$list_order_mix)) and ($hopper_level < 100) )
			{$hopper_level='100';}

		$stmtA="UPDATE vicidial_campaigns set campaign_name='$campaign_name',active='$active',dial_status_a='$dial_status_a',dial_status_b='$dial_status_b',dial_status_c='$dial_status_c',dial_status_d='$dial_status_d',dial_status_e='$dial_status_e',lead_order='$lead_order',allow_closers='$allow_closers',hopper_level='$hopper_level', $adlSQL next_agent_call='$next_agent_call', local_call_time='$local_call_time', voicemail_ext='$voicemail_ext', dial_timeout='$dial_timeout', dial_prefix='$dial_prefix', campaign_cid='$campaign_cid', campaign_vdad_exten='$campaign_vdad_exten', web_form_address='" . mysql_real_escape_string($web_form_address) . "', park_ext='$park_ext', park_file_name='$park_file_name', campaign_rec_exten='$campaign_rec_exten', campaign_recording='$campaign_recording', campaign_rec_filename='$campaign_rec_filename', campaign_script='$script_id', get_call_launch='$get_call_launch', am_message_exten='$am_message_exten', amd_send_to_vmx='$amd_send_to_vmx', xferconf_a_dtmf='$xferconf_a_dtmf',xferconf_a_number='$xferconf_a_number',xferconf_b_dtmf='$xferconf_b_dtmf',xferconf_b_number='$xferconf_b_number',lead_filter_id='$lead_filter_id',alt_number_dialing='$alt_number_dialing',scheduled_callbacks='$scheduled_callbacks',drop_action='$drop_action',drop_call_seconds='$drop_call_seconds',safe_harbor_exten='$safe_harbor_exten',wrapup_seconds='$wrapup_seconds',wrapup_message='$wrapup_message',closer_campaigns='$groups_value',use_internal_dnc='$use_internal_dnc',allcalls_delay='$allcalls_delay',omit_phone_code='$omit_phone_code',dial_method='$dial_method',available_only_ratio_tally='$available_only_ratio_tally',adaptive_dropped_percentage='$adaptive_dropped_percentage',adaptive_maximum_level='$adaptive_maximum_level',adaptive_latest_server_time='$adaptive_latest_server_time',adaptive_intensity='$adaptive_intensity',adaptive_dl_diff_target='$adaptive_dl_diff_target',concurrent_transfers='$concurrent_transfers',auto_alt_dial='$auto_alt_dial',agent_pause_codes_active='$agent_pause_codes_active',campaign_description='$campaign_description',campaign_changedate='$SQLdate',campaign_stats_refresh='$campaign_stats_refresh',disable_alter_custdata='$disable_alter_custdata',no_hopper_leads_logins='$no_hopper_leads_logins',list_order_mix='$list_order_mix',campaign_allow_inbound='$campaign_allow_inbound',manual_dial_list_id='$manual_dial_list_id',default_xfer_group='$default_xfer_group',xfer_groups='$XFERgroups_value',queue_priority='$queue_priority',drop_inbound_group='$drop_inbound_group',disable_alter_custphone='$disable_alter_custphone',display_queue_count='$display_queue_count',manual_dial_filter='$manual_dial_filter',agent_clipboard_copy='$agent_clipboard_copy',agent_extended_alt_dial='$agent_extended_alt_dial',use_campaign_dnc='$use_campaign_dnc',three_way_call_cid='$three_way_call_cid' where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmtA, $link);

		if ($reset_hopper == 'Y')
			{
			echo "<br>REAJUSTE DE LA TOLVA DEL PLOMO DE LA CAMPAÚA\n";
			echo "<br> - Espera 1 minuto antes de marcar el número siguiente\n";
			$stmt="DELETE from vicidial_hopper where campaign_id='$campaign_id' and status IN('READY','QUEUE','DONE');";
			$rslt=mysql_query($stmt, $link);

			### LOG RESET TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|CAMPAIGN HOPPERRESET|$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY CAMPAIGN INFO|$PHP_AUTH_USER|$ip|$stmtA|$reset_hopper|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=31;	# go to campaign modification form below
}

######################
# ADD=42 modify/delete campaign status in the system
######################

if ($ADD==42)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) )
		{
		 echo "<br>ESTADO de la CAMPAÚA NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>la ID de la campaña necesita ser por lo menos 2 caracteres en longitud\n";
		 echo "<br>el estado de la campaña necesita ser por lo menos los caracteres 1 en longitud\n";
		}
	 else
		{
		if (ereg('delete',$stage))
			{
			echo "<br><B>ESTADO DE ENCARGO DE LA CAMPAÚA SUPRIMIDO: $campaign_id - $status</B>\n";

			$stmt="DELETE FROM vicidial_campaign_statuses where campaign_id='$campaign_id' and status='$status';";
			$rslt=mysql_query($stmt, $link);

			$stmtA="DELETE FROM vicidial_campaign_hotkeys where campaign_id='$campaign_id' and status='$status';";
			$rslt=mysql_query($stmtA, $link);


			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|DELETE CAMPAIGN STATUS|$PHP_AUTH_USER|$ip|$stmt|$stmtA|\n");
				fclose($fp);
				}
			}
		if (ereg('modify',$stage))
			{
			echo "<br><B>ESITO PERSONALIZZATO PER CAMPAGNA MODIFICATO: $campaign_id - $status</B>\n";

			$stmt="UPDATE vicidial_campaign_statuses SET status_name='$status_name',selectable='$selectable',human_answered='$human_answered',category='$category' where campaign_id='$campaign_id' and status='$status';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFY CAMPAIGN STATUS|$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB=22;
$ADD=31;	# go to campaign modification form below
}

######################
# ADD=43 delete campaign hotkey in the system
######################

if ($ADD==43)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) or (strlen($hotkey) < 1) )
		{
		 echo "<br>CAMPAÚA HOT KEY NO MODIFICADA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>la ID de la campaña necesita ser por lo menos 2 caracteres en longitud\n";
		 echo "<br>el estado de la campaña necesita ser por lo menos los caracteres 1 en longitud\n";
		 echo "<br>the campaign hotkey needs to be at least 1 characters in length\n";
		}
	 else
		{
		echo "<br><B>LA CAMPAÚA DE ENCARGO HOT KEY SUPRIMIÚ: $campaign_id - $status - $hotkey</B>\n";

		$stmt="DELETE FROM vicidial_campaign_hotkeys where campaign_id='$campaign_id' and status='$status' and hotkey='$hotkey';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|DELETE CAMPAIGN STATUS|$PHP_AUTH_USER|$ip|DELETE FROM vicidial_campaign_hotkeys where campaign_id='$campaign_id' and status='$status' and hotkey='$hotkey'|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB=23;
$ADD=31;	# go to campaign modification form below
}

######################
# ADD=44 submit campaign modifications to the system - Basic View
######################

if ($ADD==44)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_name) < 6) or (strlen($active) < 1) )
		{
		 echo "<br>CAMPAÚA NO MODIFICADA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>el nombre de la campaña necesita ser por lo menos 6 caracteres en longitud\n";
		}
	 else
		{
		echo "<br><B>CAMPAGNA MODIFICATA: $campaign_id</B>\n";

		if ($dial_method == 'RATIO')
			{
			if ($auto_dial_level < 1) {$auto_dial_level = "1.0";}
			$adlSQL = "auto_dial_level='$auto_dial_level',";
			}
		else
			{
			if ($dial_method == 'MANUAL') 
				{
				$auto_dial_level='0';
				$adlSQL = "auto_dial_level='0',";
				}
			else
				{
				$adlSQL = "";
				if ($auto_dial_level < 1) 
					{
					$auto_dial_level = "1.0";
					$adlSQL = "auto_dial_level='$auto_dial_level',";
					}
				}
			}
		if ( (!ereg("DISABLED",$list_order_mix)) and ($hopper_level < 100) )
			{$hopper_level='100';}

		$stmtA="UPDATE vicidial_campaigns set campaign_name='$campaign_name',active='$active',dial_status_a='$dial_status_a',dial_status_b='$dial_status_b',dial_status_c='$dial_status_c',dial_status_d='$dial_status_d',dial_status_e='$dial_status_e',lead_order='$lead_order',hopper_level='$hopper_level', $adlSQL lead_filter_id='$lead_filter_id',dial_method='$dial_method',adaptive_intensity='$adaptive_intensity',campaign_changedate='$SQLdate',list_order_mix='$list_order_mix' where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmtA, $link);

		if ($reset_hopper == 'Y')
			{
			echo "<br>REAJUSTE DE LA TOLVA DEL PLOMO DE LA CAMPAÚA\n";
			echo "<br> - Espera 1 minuto antes de marcar el número siguiente\n";
			$stmt="DELETE from vicidial_hopper where campaign_id='$campaign_id' and status IN('READY','QUEUE','DONE');;";
			$rslt=mysql_query($stmt, $link);

			### LOG HOPPER RESET TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|CAMPAIGN HOPPERRESET|$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY CAMPAIGN INFO|$PHP_AUTH_USER|$ip|$stmtA|$reset_hopper|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=34;	# go to campaign modification form below
}

######################
# ADD=45 modify campaign lead recycle in the system
######################

if ($ADD==45)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) or ($attempt_delay < 120) or ($attempt_delay >= 43200) or ($attempt_maximum < 1) or ($attempt_maximum > 10) )
		{
		 echo "<br>CAMPAIGN LEAD RECYCLE NOT MODIFIED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>el estado debe estar entre 1 y 6 caracteres en longitud\n";
		 echo "<br>la tentativa retrasa debe ser por lo menos 120 segundos and less than 43200 seconds or 12 hours\n";
		 echo "<br>las tentativas máximas deben ser a partir la 1 a 10\n";
		}
	 else
		{
		echo "<br><B>CAMPAIGN LEAD MODIFIED: $campaign_id - $status - $attempt_delay</B>\n";

		$stmt="UPDATE vicidial_lead_recycle SET attempt_delay='$attempt_delay',attempt_maximum='$attempt_maximum',active='$active' where campaign_id='$campaign_id' and status='$status';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY LEAD RECYCLE   |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB=25;
$ADD=31;	# go to campaign modification form below
}

######################
# ADD=47 modify agent pause code in the system
######################

if ($ADD==47)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or (strlen($pause_code) < 1) or (strlen($pause_code) > 6) or (strlen($pause_code_name) < 2) )
		{
		 echo "<br>Co`DIGO DE LA PAUSA DEL AGENTE NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>pause_code must be between 1 and 6 characters in length\n";
		 echo "<br>pause_code name must be between 2 and 30 characters in length\n";
		}
	 else
		{
		echo "<br><B>AGENT PAUSE CODE MODIFIED: $campaign_id - $pause_code - $pause_code_name</B>\n";

		$stmt="UPDATE vicidial_pause_codes SET pause_code_name='$pause_code_name',billable='$billable' where campaign_id='$campaign_id' and pause_code='$pause_code';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY AGENT PAUSECODE|$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB=27;
$ADD=31;	# go to campaign modification form below
}


######################
# ADD=48 modify campaign QC settings in the system
######################

if ($ADD==48)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if (strlen($campaign_id) < 2)
		{
		 echo "<br>QC SETTINGS NOT MODIFIED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		}
	 else
		{
		$p=0;
		$qc_statuses_ct = count($qc_statuses);
		while ($p < $qc_statuses_ct)
			{
			$QC_statuses .= " $qc_statuses[$p]";
			$p++;
			}
		$p=0;
		$qc_lists_ct = count($qc_lists);
		while ($p < $qc_lists_ct)
			{
			$QC_lists .= " $qc_lists[$p]";
			$p++;
			}
		
		if (strlen($QC_statuses)>0) {$QC_statuses .= " -";}
		if (strlen($QC_lists)>0) {$QC_lists .= " -";}

		echo "<br><B>QC SETTINGS MODIFIED: $campaign_id</B>\n";

		$stmt="UPDATE vicidial_campaigns SET qc_enabled='$qc_enabled',qc_statuses='$QC_statuses',qc_lists='$QC_lists',qc_web_form_address='$qc_web_form_address',qc_script='$qc_script',qc_get_record_launch='$qc_get_record_launch',qc_show_recording='$qc_show_recording',qc_shift_id='$qc_shift_id' where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY CAMP QC SETTING|$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB=28;
$ADD=31;	# go to campaign modification form below
}


######################
# ADD=40A modify campaign survey settings in the system
######################

if ($ADD=='40A')
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if (strlen($campaign_id) < 2)
		{
		 echo "<br>SURVEY SETTINGS NOT MODIFIED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		}
	 else
		{
		echo "<br><B>SURVEY SETTINGS MODIFIED: $campaign_id</B>\n";

		$stmt="UPDATE vicidial_campaigns SET survey_first_audio_file='$survey_first_audio_file',survey_dtmf_digits='$survey_dtmf_digits',survey_ni_digit='$survey_ni_digit',survey_opt_in_audio_file='$survey_opt_in_audio_file',survey_ni_audio_file='$survey_ni_audio_file',survey_method='$survey_method',survey_no_response_action='$survey_no_response_action',survey_ni_status='$survey_ni_status',survey_response_digit_map='$survey_response_digit_map',survey_xfer_exten='$survey_xfer_exten',survey_camp_record_dir='$survey_camp_record_dir',voicemail_ext='$voicemail_ext' where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY CAMP SV SETTING|$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB='20A';
$ADD=31;	# go to campaign modification form below
}


######################
# ADD=49 modify campaign list mix in the system
######################

if ($ADD==49)
{
	if ($LOGmodify_campaigns==1)
	{
	##### MODIFY a list mix container entry #####
		if ($stage=='MODIFY')
		{
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

		$Flist_mix_container = "list_mix_container_$vcl_id";
		$Fmix_method = "mix_method_$vcl_id";
		$Fstatus = "status_$vcl_id";
		$Fvcl_name = "vcl_name_$vcl_id";

		if (isset($_GET[$Flist_mix_container]))				{$list_mix_container=$_GET[$Flist_mix_container];}
			elseif (isset($_POST[$Flist_mix_container]))	{$list_mix_container=$_POST[$Flist_mix_container];}
		if (isset($_GET[$Fmix_method]))						{$mix_method=$_GET[$Fmix_method];}
			elseif (isset($_POST[$Fmix_method]))			{$mix_method=$_POST[$Fmix_method];}
		if (isset($_GET[$Fstatus]))							{$status=$_GET[$Fstatus];}
			elseif (isset($_POST[$Fstatus]))				{$status=$_POST[$Fstatus];}
		if (isset($_GET[$Fvcl_name]))						{$vcl_name=$_GET[$Fvcl_name];}
			elseif (isset($_POST[$Fvcl_name]))				{$vcl_name=$_POST[$Fvcl_name];}
		$list_mix_container = preg_replace("/:$/","",$list_mix_container);

		 if ( (strlen($campaign_id) < 2) or (strlen($vcl_id) < 1) or (strlen($list_mix_container) < 6) or (strlen($vcl_name) < 2) )
			{
			 echo "<br>MIX LISTA NON MODIFICATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>vcl_id must be between 1 and 20 characters in length\n";
			 echo "<br>vcl_name name must be between 2 and 30 characters in length\n";
			}
		 else
			{
			$stmt="UPDATE vicidial_campaigns_list_mix SET vcl_name='$vcl_name',mix_method='$mix_method',list_mix_container='$list_mix_container' where campaign_id='$campaign_id' and vcl_id='$vcl_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFY LIST MIX       |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}

			echo "<br><B>MIX LISTA MODIFICATO: $campaign_id - $vcl_id - $vcl_name</B>\n";
			}
		}

	##### ADD a list mix container entry #####
		if ($stage=='ADD')
		{
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

		 if ( (strlen($campaign_id) < 2) or (strlen($vcl_id) < 1) or (strlen($list_id) < 1) )
			{
			 echo "<br>MIX LISTA NON MODIFICATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>vcl_id must be between 1 and 20 characters in length\n";
			 echo "<br>list_id must be at least 2 characters in length\n";
			}
		 else
			{
			$stmt="SELECT list_mix_container from vicidial_campaigns_list_mix where campaign_id='$campaign_id' and vcl_id='$vcl_id';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			$OLDlist_mix_container =	$row[0];
			$NEWlist_mix_container = "$OLDlist_mix_container:$list_id|10|0| -|";

			$stmt="UPDATE vicidial_campaigns_list_mix SET list_mix_container='$NEWlist_mix_container' where campaign_id='$campaign_id' and vcl_id='$vcl_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFY LIST MIX       |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}

			echo "<br><B>MIX LISTA MODIFICATO: $campaign_id - $vcl_id - $list_id</B>\n";
			}
		}

	##### REMOVE a list mix container entry #####
		if ($stage=='REMOVE')
		{
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

		 if ( (strlen($campaign_id) < 2) or (strlen($vcl_id) < 1) or (strlen($list_id) < 1) )
			{
			 echo "<br>MIX LISTA NON MODIFICATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>vcl_id must be between 1 and 20 characters in length\n";
			 echo "<br>list_id must be at least 2 characters in length\n";
			}
		 else
			{
			$stmt="SELECT list_mix_container from vicidial_campaigns_list_mix where campaign_id='$campaign_id' and vcl_id='$vcl_id';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			$MIXentries = $MT;
			$MIXentries = explode(":", $row[0]);
			$Ms_to_print = (count($MIXentries) - 0);

			if ($Ms_to_print < 2)
				{
				echo "<br><B>MIX LISTA NON MODIFICATO: Non puoi cancellare l`ultimo list_id da un mix di liste</B>\n";
				}
			else
				{
				$MIXdetailsPCT = explode('|', $MIXentries[$mix_container_item]);
				$MIXpercentPCT = $MIXdetailsPCT[2];

				$q=0;
				while ($Ms_to_print > $q) 
					{
					if ( ($mix_container_item > $q) or ($mix_container_item < $q) )
						{
						if ( ($q==0) and ($mix_container_item > 0) )
							{
							$MIXdetailsONE = explode('|', $MIXentries[$q]);
							$MIXpercentONE = ($MIXdetailsONE[2] + $MIXpercentPCT);
							$NEWlist_mix_container .= "$MIXdetailsONE[0]|$MIXdetailsONE[1]|$MIXpercentONE|$MIXdetailsONE[3]|:";
							}
						else
							{
							if ( ($q==1) and ($mix_container_item < 1) )
								{
								$MIXdetailsONE = explode('|', $MIXentries[$q]);
								$MIXpercentONE = ($MIXdetailsONE[2] + $MIXpercentPCT);
								$NEWlist_mix_container .= "$MIXdetailsONE[0]|$MIXdetailsONE[1]|$MIXpercentONE|$MIXdetailsONE[3]|:";
								}
							else
								{
								$NEWlist_mix_container .= "$MIXentries[$q]:";
								}
							}
						}
					$q++;
					}
				$NEWlist_mix_container = preg_replace("/.$/",'',$NEWlist_mix_container);

				$stmt="UPDATE vicidial_campaigns_list_mix SET list_mix_container='$NEWlist_mix_container' where campaign_id='$campaign_id' and vcl_id='$vcl_id';";
				$rslt=mysql_query($stmt, $link);

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|MODIFY LIST MIX       |$PHP_AUTH_USER|$ip|$stmt|\n");
					fclose($fp);
					}

				echo "<br><B>MIX LISTA MODIFICATO: $campaign_id - $vcl_id - $list_id - $mix_container_item</B>\n";
				}
			}
		}

	##### ADD a NEW list mix #####
		if ($stage=='NEWMIX')
		{
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

		 if ( (strlen($campaign_id) < 2) or (strlen($vcl_id) < 1) or (strlen($vcl_name) < 2) )
			{
			 echo "<br>MIX LISTA NON AGGIUNTO- Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>vcl_id must be between 1 and 20 characters in length\n";
			 echo "<br>vcl_name must be at least 2 characters in length\n";
			}
		 else
			{
			$stmt="SELECT count(*) from vicidial_campaigns_list_mix where vcl_id='$vcl_id';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			if ($row[0] > 0)
				{
				 echo "<br>MIX LISTA NON AGGIUNTO- Esiste gia` un mix di lista con questo ID\n";
				}
			else
				{
				$stmt="INSERT INTO vicidial_campaigns_list_mix SET list_mix_container='$list_id|1|100| $status -|',campaign_id='$campaign_id',vcl_id='$vcl_id',vcl_name='$vcl_name',mix_method='$mix_method',status='INACTIVE';";
				$rslt=mysql_query($stmt, $link);

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|MODIFY LIST MIX       |$PHP_AUTH_USER|$ip|$stmt|\n");
					fclose($fp);
					}

				echo "<br><B>MIX LISTA AGGIUNTO: $campaign_id - $vcl_id - $vcl_name</B>\n";
				}
			}
		}

	##### DELETE an existing list mix #####
		if ($stage=='DELMIX')
		{
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

		 if ( (strlen($campaign_id) < 2) or (strlen($vcl_id) < 1) )
			{
			 echo "<br>MIX LISTA NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>vcl_id must be between 1 and 20 characters in length\n";
			}
		 else
			{
			$stmt="DELETE from vicidial_campaigns_list_mix where vcl_id='$vcl_id' and campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFY LIST MIX       |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}

			echo "<br><B>MIX LISTA CANCELLATO: $campaign_id - $vcl_id - $vcl_name</B>\n";
			}
		}

	##### Set list mix entry to active #####
		if ($stage=='SETACTIVE')
		{
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

		 if ( (strlen($campaign_id) < 2) or (strlen($vcl_id) < 1) )
			{
			 echo "<br>MIX LISTA NON ATTIVATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>vcl_id must be between 1 and 20 characters in length\n";
			}
		 else
			{
			$stmt="UPDATE vicidial_campaigns_list_mix SET status='INACTIVE' where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);

			$stmt="UPDATE vicidial_campaigns_list_mix SET status='ACTIVE' where vcl_id='$vcl_id' and campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFY LIST MIX       |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}

			echo "<br><B>MIX LISTA ATTIVATO: $campaign_id - $vcl_id - $vcl_name</B>\n";
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB=29;
$ADD=31;	# go to campaign modification form below
}


######################
# ADD=411 submit list modifications to the system
######################

if ($ADD==411)
{
	if ($LOGmodify_lists==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($list_name) < 2) or (strlen($campaign_id) < 2) )
		{
		 echo "<br>LISTA NO MODIFICADA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>el nombre de la lista debe ser por lo menos 2 caracteres en longitud\n";
		}
	 else
		{
		echo "<br><B>LISTA MODIFICATA: $list_id</B>\n";

		$stmt="UPDATE vicidial_lists set list_name='$list_name',campaign_id='$campaign_id',active='$active',list_description='$list_description',list_changedate='$SQLdate' where list_id='$list_id';";
		$rslt=mysql_query($stmt, $link);

		if ($reset_list == 'Y')
			{
			echo "<br>RESET ESITI CONTATTI DELLA LISTA CHIAMATI\n";
			$stmtB="UPDATE vicidial_list set called_since_last_reset='N' where list_id='$list_id';";
			$rslt=mysql_query($stmtB, $link);

			### LOG RESET TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|RESET LIST CALLED   |$PHP_AUTH_USER|$ip|list_name='$list_name'|\n");
				fclose($fp);
				}
			}
		if ($campaign_id != "$old_campaign_id")
			{
			echo "<br>QUITAR LOS PLOMOS DE LA TOLVA DE LA LISTA DE VIEJA TOLVA DE LA CAMPAÚA ($old_campaign_id)\n";
			$stmtC="DELETE from vicidial_hopper where list_id='$list_id' and campaign_id='$old_campaign_id';";
			$rslt=mysql_query($stmtC, $link);
			}

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY LIST INFO    |$PHP_AUTH_USER|$ip|$stmt|$stmtB|$stmtC|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=311;	# go to list modification form below
}


######################
# ADD=4111 modify in-group info in the system
######################

if ($ADD==4111)
{
	if ($LOGmodify_ingroups==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($group_name) < 2) or (strlen($group_color) < 2) )
		{
		 echo "<br>GRUPO NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>el color del nombre de grupo y del grupo debe ser por lo menos 2 caracteres en longitud\n";
		}
	 else
		{
		$p=0;
		$qc_statuses_ct = count($qc_statuses);
		while ($p < $qc_statuses_ct)
			{
			$QC_statuses .= " $qc_statuses[$p]";
			$p++;
			}
		$p=0;
		$qc_lists_ct = count($qc_lists);
		while ($p < $qc_lists_ct)
			{
			$QC_lists .= " $qc_lists[$p]";
			$p++;
			}
		
		if (strlen($QC_statuses)>0) {$QC_statuses .= " -";}
		if (strlen($QC_lists)>0) {$QC_lists .= " -";}

		echo "<br><B>GRUPPO MODIFICATO: $group_id</B>\n";

		$stmt="UPDATE vicidial_inbound_groups set group_name='$group_name', group_color='$group_color', active='$active', web_form_address='" . mysql_real_escape_string($web_form_address) . "', voicemail_ext='$voicemail_ext', next_agent_call='$next_agent_call', fronter_display='$fronter_display', ingroup_script='$script_id', get_call_launch='$get_call_launch', xferconf_a_dtmf='$xferconf_a_dtmf',xferconf_a_number='$xferconf_a_number', xferconf_b_dtmf='$xferconf_b_dtmf',xferconf_b_number='$xferconf_b_number',drop_action='$drop_action',drop_call_seconds='$drop_call_seconds',drop_exten='$drop_exten',call_time_id='$call_time_id',after_hours_action='$after_hours_action',after_hours_message_filename='$after_hours_message_filename',after_hours_exten='$after_hours_exten',after_hours_voicemail='$after_hours_voicemail',welcome_message_filename='$welcome_message_filename',moh_context='$moh_context',onhold_prompt_filename='$onhold_prompt_filename',prompt_interval='$prompt_interval',agent_alert_exten='$agent_alert_exten',agent_alert_delay='$agent_alert_delay',default_xfer_group='$default_xfer_group',queue_priority='$queue_priority',drop_inbound_group='$drop_inbound_group',ingroup_recording_override='$ingroup_recording_override',ingroup_rec_filename='$ingroup_rec_filename',afterhours_xfer_group='$afterhours_xfer_group',qc_enabled='$qc_enabled',qc_statuses='$QC_statuses',qc_shift_id='$qc_shift_id',qc_get_record_launch='$qc_get_record_launch',qc_show_recording='$qc_show_recording',qc_web_form_address='$qc_web_form_address',qc_script='$qc_script',play_place_in_line='$play_place_in_line',play_estimate_hold_time='$play_estimate_hold_time',hold_time_option='$hold_time_option',hold_time_option_seconds='$hold_time_option_seconds',hold_time_option_exten='$hold_time_option_exten',hold_time_option_voicemail='$hold_time_option_voicemail',hold_time_option_xfer_group='$hold_time_option_xfer_group',hold_time_option_callback_filename='$hold_time_option_callback_filename',hold_time_option_callback_list_id='$hold_time_option_callback_list_id',hold_recall_xfer_group='$hold_recall_xfer_group',no_delay_call_route='$no_delay_call_route',play_welcome_message='$play_welcome_message' where group_id='$group_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY GROUP INFO   |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=3111;	# go to in-group modification form below
}



######################
# ADD=4311 modify did info in the system
######################

if ($ADD==4311)
{
	if ($LOGmodify_dids==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($did_id) < 1) or (strlen($did_pattern) < 1) )
		{
		 echo "<br>DID NOT MODIFIED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>did_extension must be at least 1 character in length\n";
		}
	 else
		{
		echo "<br><B>DID MODIFIED: $did_pattern</B>\n";

		$stmt="UPDATE vicidial_inbound_dids set did_pattern='$did_pattern',did_description='$did_description',did_active='$did_active',did_route='$did_route',extension='$extension',exten_context='$exten_context',voicemail_ext='$voicemail_ext',phone='$phone',server_ip='$server_ip',user='$user',user_unavailable_action='$user_unavailable_action',user_route_settings_ingroup='$user_route_settings_ingroup',group_id='$group_id',call_handle_method='$call_handle_method',agent_search_method='$agent_search_method',list_id='$list_id',campaign_id='$campaign_id',phone_code='$phone_code' where did_id='$did_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY DID INFO     |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=3311;	# go to did modification form below
}



######################
# ADD=41111 modify remote agents info in the system
######################

if ($ADD==41111)
{
	if ($LOGmodify_remoteagents==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($server_ip) < 2) or (strlen($user_start) < 2)  or (strlen($campaign_id) < 2) or (strlen($conf_exten) < 2) )
		{
		 echo "<br>AGENTES ALEJADOS NO MODIFICADOS - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>El comienzo de la ID del usuario y la extension externa deben ser por lo menos 2 caracteres en longitud\n";
		}
	 else
		{
		$stmt="UPDATE vicidial_remote_agents set user_start='$user_start', number_of_lines='$number_of_lines', server_ip='$server_ip', conf_exten='$conf_exten', status='$status', campaign_id='$campaign_id', closer_campaigns='$groups_value' where remote_agent_id='$remote_agent_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>LOS AGENTES ALEJADOS SE MODIFICARON</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY OPERATORI REMOTI ENTRY     |$PHP_AUTH_USER|$ip|set user_start='$user_start', number_of_lines='$number_of_lines', server_ip='$server_ip', conf_exten='$conf_exten', status='$status', campaign_id='$campaign_id', closer_campaigns='$groups_value' where remote_agent_id='$remote_agent_id'|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=31111;	# go to remote agents modification form below
}



######################
# ADD=411111 modify user group info in the system
######################

if ($ADD==411111)
{
	if ($LOGmodify_usergroups==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($user_group) < 2) or (strlen($group_name) < 2) )
		{
		 echo "<br>GRUPO de USUARIO NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>El nombre y la descripcio`n de grupo deben ser por lo menos 2 caracteres en longitud\n";
		}
	 else
		{
		$p=0;
		$GROUP_shifts=' ';
		$group_shifts_ct = count($group_shifts);
		while ($p <= $group_shifts_ct)
			{
			$GROUP_shifts .= "$group_shifts[$p] ";
			$p++;
			}
		$stmt="UPDATE vicidial_user_groups set user_group='$user_group', group_name='$group_name',allowed_campaigns='$campaigns_value',qc_allowed_campaigns='$qc_campaigns_value',qc_allowed_inbound_groups='$qc_groups_value',group_shifts='$GROUP_shifts' where user_group='$OLDuser_group';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>GRUPPO UTENTI MODIFICATO</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY USER GROUP ENTRY     |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=311111;	# go to user group modification form below
}

######################
# ADD=4111111 modify script in the system
######################

if ($ADD==4111111)
{
	if ($LOGmodify_scripts==1)
	{
	echo "<!-- $script_text -->\n";
	echo "<!--" . mysql_real_escape_string($script_text) . " -->\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($script_id) < 2) or (strlen($script_name) < 2) or (strlen($script_text) < 2) )
		{
		 echo "<br>SCRIPT NON MODIFICATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>El nombre, la descripcio`n y el texto de la escritura deben ser por lo menos 2 caracteres en longitud\n";
		}
	 else
		{
		$stmt="UPDATE vicidial_scripts set script_name='$script_name', script_comments='$script_comments', script_text='$script_text', active='$active' where script_id='$script_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>SCRIPT MODIFICATO</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY SCRIPT ENTRY         |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=3111111;	# go to script modification form below
}


######################
# ADD=41111111 modify filter in the system
######################

if ($ADD==41111111)
{
	if ($LOGmodify_filters==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($lead_filter_id) < 2) or (strlen($lead_filter_name) < 2) or (strlen($lead_filter_sql) < 2) )
		{
		 echo "<br>FILTRO NON MODIFICATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>ID Filtro, nome e SQL devono essere lunghi almeno 2 caratteri\n";
		}
	 else
		{
		$stmt="UPDATE vicidial_lead_filters set lead_filter_name='$lead_filter_name', lead_filter_comments='$lead_filter_comments', lead_filter_sql='$lead_filter_sql' where lead_filter_id='$lead_filter_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>FILTRO MODIFICATO</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY FILTER ENTRY         |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=31111111;	# go to filter modification form below
}


######################
# ADD=411111111 modify call time in the system
######################

if ($ADD==411111111)
{
	if ($LOGmodify_call_times==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($call_time_id) < 2) or (strlen($call_time_name) < 2) )
		{
		 echo "<br>TIEMPO DE LA LLAMADA NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>La identificacio`n del tiempo de la llamada y el nombre deben ser porlo menos 2 caracteres en longitud\n";
		}
	 else
		{
		$ct_default_start = preg_replace('/\D/', '', $ct_default_start);
		$ct_default_stop = preg_replace('/\D/', '', $ct_default_stop);
		$ct_sunday_start = preg_replace('/\D/', '', $ct_sunday_start);
		$ct_sunday_stop = preg_replace('/\D/', '', $ct_sunday_stop);
		$ct_monday_start = preg_replace('/\D/', '', $ct_monday_start);
		$ct_monday_stop = preg_replace('/\D/', '', $ct_monday_stop);
		$ct_tuesday_start = preg_replace('/\D/', '', $ct_tuesday_start);
		$ct_tuesday_stop = preg_replace('/\D/', '', $ct_tuesday_stop);
		$ct_wednesday_start = preg_replace('/\D/', '', $ct_wednesday_start);
		$ct_wednesday_stop = preg_replace('/\D/', '', $ct_wednesday_stop);
		$ct_thursday_start = preg_replace('/\D/', '', $ct_thursday_start);
		$ct_thursday_stop = preg_replace('/\D/', '', $ct_thursday_stop);
		$ct_friday_start = preg_replace('/\D/', '', $ct_friday_start);
		$ct_friday_stop = preg_replace('/\D/', '', $ct_friday_stop);
		$ct_saturday_start = preg_replace('/\D/', '', $ct_saturday_start);
		$ct_saturday_stop = preg_replace('/\D/', '', $ct_saturday_stop);
		$stmt="UPDATE vicidial_call_times set call_time_name='$call_time_name', call_time_comments='$call_time_comments', ct_default_start='$ct_default_start', ct_default_stop='$ct_default_stop', ct_sunday_start='$ct_sunday_start', ct_sunday_stop='$ct_sunday_stop', ct_monday_start='$ct_monday_start', ct_monday_stop='$ct_monday_stop', ct_tuesday_start='$ct_tuesday_start', ct_tuesday_stop='$ct_tuesday_stop', ct_wednesday_start='$ct_wednesday_start', ct_wednesday_stop='$ct_wednesday_stop', ct_thursday_start='$ct_thursday_start', ct_thursday_stop='$ct_thursday_stop', ct_friday_start='$ct_friday_start', ct_friday_stop='$ct_friday_stop', ct_saturday_start='$ct_saturday_start', ct_saturday_stop='$ct_saturday_stop' where call_time_id='$call_time_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>TIEMPO DE LA LLAMADA MODIFICADO</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY CALL TIME ENTRY      |$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=311111111;	# go to call time modification form below
}


######################
# ADD=4111111111 modify state call time in the system
######################

if ($ADD==4111111111)
{
	if ($LOGmodify_call_times==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($call_time_id) < 2) or (strlen($call_time_name) < 2) or (strlen($state_call_time_state) < 2) )
		{
		 echo "<br>TIEMPO DE LA LLAMADA DEL ESTADO NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Indique que identificacio`n del tiempo de la llamada, nombre y estadodebe ser por lo menos 2 caracteres en longitud\n";
		}
	 else
		{
		$ct_default_start = preg_replace('/\D/', '', $ct_default_start);
		$ct_default_stop = preg_replace('/\D/', '', $ct_default_stop);
		$ct_sunday_start = preg_replace('/\D/', '', $ct_sunday_start);
		$ct_sunday_stop = preg_replace('/\D/', '', $ct_sunday_stop);
		$ct_monday_start = preg_replace('/\D/', '', $ct_monday_start);
		$ct_monday_stop = preg_replace('/\D/', '', $ct_monday_stop);
		$ct_tuesday_start = preg_replace('/\D/', '', $ct_tuesday_start);
		$ct_tuesday_stop = preg_replace('/\D/', '', $ct_tuesday_stop);
		$ct_wednesday_start = preg_replace('/\D/', '', $ct_wednesday_start);
		$ct_wednesday_stop = preg_replace('/\D/', '', $ct_wednesday_stop);
		$ct_thursday_start = preg_replace('/\D/', '', $ct_thursday_start);
		$ct_thursday_stop = preg_replace('/\D/', '', $ct_thursday_stop);
		$ct_friday_start = preg_replace('/\D/', '', $ct_friday_start);
		$ct_friday_stop = preg_replace('/\D/', '', $ct_friday_stop);
		$ct_saturday_start = preg_replace('/\D/', '', $ct_saturday_start);
		$ct_saturday_stop = preg_replace('/\D/', '', $ct_saturday_stop);
		$stmt="UPDATE vicidial_state_call_times set state_call_time_name='$call_time_name', state_call_time_comments='$call_time_comments', sct_default_start='$ct_default_start', sct_default_stop='$ct_default_stop', sct_sunday_start='$ct_sunday_start', sct_sunday_stop='$ct_sunday_stop', sct_monday_start='$ct_monday_start', sct_monday_stop='$ct_monday_stop', sct_tuesday_start='$ct_tuesday_start', sct_tuesday_stop='$ct_tuesday_stop', sct_wednesday_start='$ct_wednesday_start', sct_wednesday_stop='$ct_wednesday_stop', sct_thursday_start='$ct_thursday_start', sct_thursday_stop='$ct_thursday_stop', sct_friday_start='$ct_friday_start', sct_friday_stop='$ct_friday_stop', sct_saturday_start='$ct_saturday_start', sct_saturday_stop='$ct_saturday_stop', state_call_time_state='$state_call_time_state'  where state_call_time_id='$call_time_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>TIEMPO DE LA LLAMADA DEL ESTADO MODIFICADO</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY STATE CALL TIME ENTRY|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=3111111111;	# go to state call time modification form below
}


######################
# ADD=431111111 modify shift in the system
######################

if ($ADD==431111111)
{
	if ($LOGmodify_call_times==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$shift_length_test = eregi_replace(':','',$shift_length);
	 if ( (strlen($shift_id) < 2) or (strlen($shift_name) < 2) or (strlen($shift_start_time) < 4) or (strlen($shift_start_time) > 4) or (strlen($shift_length) < 5) or (strlen($shift_length) > 5) or ($shift_start_time > 2359) or ($shift_length_test > 2400) )
		{
		echo "<br>SHIFT DEFINITION NOT MODIFIED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		echo "<br>Shift ID and name must be at least 2 characters in length\n";
		echo "<br>Shift Start Time must be 4 digits in length and be a valid time\n";
		echo "<br>Shift Length must be 5 characters in length and be 24 hours or less\n";
		}
	 else
		{
		$p=0;
		$shift_weekdays_ct = count($shift_weekdays);
		while ($p <= $shift_weekdays_ct)
			{
			$SHIFT_weekdays .= "$shift_weekdays[$p]";
			$p++;
			}
		$shift_start_time = preg_replace('/\D/', '', $shift_start_time);
		$stmt="UPDATE vicidial_shifts set shift_name='$shift_name', shift_start_time='$shift_start_time', shift_length='$shift_length', shift_weekdays='$SHIFT_weekdays' where shift_id='$shift_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>SHIFT MODIFIED</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY SHIFT ENTRY          |$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=331111111;	# go to shift modification form below
}


######################
# ADD=41111111111 modify phone record in the system
######################

if ($ADD==41111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT count(*) from phones where extension='$extension' and server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ( ($row[0] > 0) && ( ($extension != $old_extension) or ($server_ip != $old_server_ip) ) )
		{echo "<br>TELEFONO NON MODIFICATO - Esiste gia` un Telefono nel sistema con questo interno\/server\n";}
	else
		{
			 if ( (strlen($extension) < 1) or (strlen($server_ip) < 7) or (strlen($dialplan_number) < 1) or (strlen($voicemail_id) < 1) or (strlen($login) < 1)  or (strlen($pass) < 1))
			{echo "<br>TELEFONO NON MODIFICATO - Per favore torna indietro e ricontrolla i dati inseriti\n";}
		 else
			{
			echo "<br>TELEFONO MODIFICATO: $extension\n";

			$stmt="UPDATE phones set extension='$extension', dialplan_number='$dialplan_number', voicemail_id='$voicemail_id', phone_ip='$phone_ip', computer_ip='$computer_ip', server_ip='$server_ip', login='$login', pass='$pass', status='$status', active='$active', phone_type='$phone_type', fullname='$fullname', company='$company', picture='$picture', protocol='$protocol', local_gmt='$local_gmt', ASTmgrUSERNAME='$ASTmgrUSERNAME', ASTmgrSECRET='$ASTmgrSECRET', login_user='$login_user', login_pass='$login_pass', login_campaign='$login_campaign', park_on_extension='$park_on_extension', conf_on_extension='$conf_on_extension', VICIDIAL_park_on_extension='$VICIDIAL_park_on_extension', VICIDIAL_park_on_filename='$VICIDIAL_park_on_filename', monitor_prefix='$monitor_prefix', recording_exten='$recording_exten', voicemail_exten='$voicemail_exten', voicemail_dump_exten='$voicemail_dump_exten', ext_context='$ext_context', dtmf_send_extension='$dtmf_send_extension', call_out_number_group='$call_out_number_group', client_browser='$client_browser', install_directory='$install_directory', local_web_callerID_URL='" . mysql_real_escape_string($local_web_callerID_URL) . "', VICIDIAL_web_URL='" . mysql_real_escape_string($VICIDIAL_web_URL) . "', AGI_call_logging_enabled='$AGI_call_logging_enabled', user_switching_enabled='$user_switching_enabled', conferencing_enabled='$conferencing_enabled', admin_hangup_enabled='$admin_hangup_enabled', admin_hijack_enabled='$admin_hijack_enabled', admin_monitor_enabled='$admin_monitor_enabled', call_parking_enabled='$call_parking_enabled', updater_check_enabled='$updater_check_enabled', AFLogging_enabled='$AFLogging_enabled', QUEUE_ACTION_enabled='$QUEUE_ACTION_enabled', CallerID_popup_enabled='$CallerID_popup_enabled', voicemail_button_enabled='$voicemail_button_enabled', enable_fast_refresh='$enable_fast_refresh', fast_refresh_rate='$fast_refresh_rate', enable_persistant_mysql='$enable_persistant_mysql', auto_dial_next_number='$auto_dial_next_number', VDstop_rec_after_each_call='$VDstop_rec_after_each_call', DBX_server='$DBX_server', DBX_database='$DBX_database', DBX_user='$DBX_user', DBX_pass='$DBX_pass', DBX_port='$DBX_port', DBY_server='$DBY_server', DBY_database='$DBY_database', DBY_user='$DBY_user', DBY_pass='$DBY_pass', DBY_port='$DBY_port', outbound_cid='$outbound_cid', enable_sipsak_messages='$enable_sipsak_messages', email='$email' where extension='$old_extension' and server_ip='$old_server_ip';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFICAR EL telefonO          |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=31111111111;	# go to phone modification form below
}


######################
# ADD=42111111111 modify phone alias record in the system
######################

if ($ADD==42111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT count(*) from phones_alias where alias_id='$alias_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
		 if ( (strlen($alias_id) < 1) or (strlen($alias_name) < 2) )
		{echo "<br>PHONE ALIAS NOT MODIFIED - Per favore torna indietro e ricontrolla i dati inseriti\n";}
		 else
		{
		echo "<br>PHONE ALIAS MODIFIED: $alias_id\n";

		$stmt="UPDATE phones_alias set alias_name='$alias_name', logins_list='$logins_list' where alias_id='$alias_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFICAR EL telefonOS ALIAS   |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=32111111111;	# go to phone alias modification form below
}


######################
# ADD=411111111111 modify server record in the system
######################

if ($ADD==411111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT count(*) from servers where server_id='$server_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ( ($row[0] > 0) && ($server_id != $old_server_id) )
		{echo "<br>SERVER NOT MODIFIED - there is already a server in the system with this server_id\n";}
	else
		{
		$stmt="SELECT count(*) from servers where server_ip='$server_ip';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ( ($row[0] > 0) && ($server_ip != $old_server_ip) )
			{echo "<br>SERVIDOR NO MODIFICADO - hay ya un servidor en el sistema con este server_ip\n";}
		else
			{
			 if ( (strlen($server_id) < 1) or (strlen($server_ip) < 7) )
				{echo "<br>SERVIDOR NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";}
			 else
				{
				echo "<br>SERVER MODIFICATO: $server_ip\n";

				$stmt="UPDATE servers set server_id='$server_id',server_description='$server_description',server_ip='$server_ip',active='$active',asterisk_version='$asterisk_version', max_vicidial_trunks='$max_vicidial_trunks', telnet_host='$telnet_host', telnet_port='$telnet_port', ASTmgrUSERNAME='$ASTmgrUSERNAME', ASTmgrSECRET='$ASTmgrSECRET', ASTmgrUSERNAMEupdate='$ASTmgrUSERNAMEupdate', ASTmgrUSERNAMElisten='$ASTmgrUSERNAMElisten', ASTmgrUSERNAMEsend='$ASTmgrUSERNAMEsend', local_gmt='$local_gmt', voicemail_dump_exten='$voicemail_dump_exten', answer_transfer_agent='$answer_transfer_agent', ext_context='$ext_context', sys_perf_log='$sys_perf_log', vd_server_logs='$vd_server_logs', agi_output='$agi_output', vicidial_balance_active='$vicidial_balance_active', balance_trunks_offlimits='$balance_trunks_offlimits' where server_id='$old_server_id';";
				$rslt=mysql_query($stmt, $link);

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|MODIFICAR EL SERVIDOR         |$PHP_AUTH_USER|$ip|$stmt|\n");
					fclose($fp);
					}
				}
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=311111111111;	# go to server modification form below
}


######################
# ADD=421111111111 modify vicidial server trunks record in the system
######################

if ($ADD==421111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT max_vicidial_trunks from servers where server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$rowx=mysql_fetch_row($rslt);
	$MAXvicidial_trunks = $rowx[0];
	
	$stmt="SELECT sum(dedicated_trunks) from vicidial_server_trunks where server_ip='$server_ip' and campaign_id !='$campaign_id';";
	$rslt=mysql_query($stmt, $link);
	$rowx=mysql_fetch_row($rslt);
	$SUMvicidial_trunks = ($rowx[0] + $dedicated_trunks);
	
	if ($SUMvicidial_trunks > $MAXvicidial_trunks)
		{
		echo "<br>EXPEDIENTE DEL TRONCO DEL SERVIDOR DE VICIDIAL NO AGREGADO - el número de troncos vicidial es demasiado alto: $SUMvicidial_trunks / $MAXvicidial_trunks\n";
		}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($server_ip) < 7) or (strlen($dedicated_trunks) < 1) or (strlen($trunk_restriction) < 1) )
			{
			 echo "<br>EXPEDIENTE DEL TRONCO DEL SERVIDOR DE VICIDIAL NO MODIFICADO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>la campaña debe estar entre 3 y 8 caracteres en longitud\n";
			 echo "<br>el server_ip retrasa debe ser por lo menos 7 caracteres\n";
			 echo "<br>los troncos deben ser un dígito a partir de la 0 a 9999\n";
			}
		 else
			{
			echo "<br><B>EXPEDIENTE DEL TRONCO DEL SERVIDOR DE VICIDIAL MODIFICADO: $campaign_id - $server_ip - $dedicated_trunks - $trunk_restriction</B>\n";

			$stmt="UPDATE vicidial_server_trunks SET dedicated_trunks='$dedicated_trunks',trunk_restriction='$trunk_restriction' where campaign_id='$campaign_id' and server_ip='$server_ip';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFICAR EL SERVIDOR TRUNK   |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=311111111111;	# go to server modification form below
}


######################
# ADD=4111111111111 modify conference record in the system
######################

if ($ADD==4111111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT count(*) from conferences where conf_exten='$conf_exten' and server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ( ($row[0] > 0) && ( ($conf_exten != $old_conf_exten) or ($server_ip != $old_server_ip) ) )
		{echo "<br>CONFERENCIA - hay ya una conferencia en el sistema con esta extension - servidor NO MODIFICADO\n";}
	else
		{
		 if ( (strlen($conf_exten) < 1) or (strlen($server_ip) < 7) )
			{echo "<br>CONFERENCIA NO MODIFICADA - Per favore torna indietro e ricontrolla i dati inseriti\n";}
		 else
			{
			echo "<br>CONFERENCIA MODIFICADA: $conf_exten\n";

			$stmt="UPDATE conferences set conf_exten='$conf_exten',server_ip='$server_ip',extension='$extension' where conf_exten='$old_conf_exten';";
			$rslt=mysql_query($stmt, $link);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=3111111111111;	# go to conference modification form below
}


######################
# ADD=41111111111111 modify vicidial conference record in the system
######################

if ($ADD==41111111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT count(*) from vicidial_conferences where conf_exten='$conf_exten' and server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ( ($row[0] > 0) && ( ($conf_exten != $old_conf_exten) or ($server_ip != $old_server_ip) ) )
		{echo "<br>VICIDIAL CONFERENCIA - hay ya una conferencia en el sistema con esta extension - servidor NO MODIFICADO\n";}
	else
		{
		 if ( (strlen($conf_exten) < 1) or (strlen($server_ip) < 7) )
			{echo "<br>VICIDIAL CONFERENCIA NO MODIFICADA - Per favore torna indietro e ricontrolla i dati inseriti\n";}
		 else
			{
			echo "<br>VICIDIAL CONFERENCIA MODIFICADA: $conf_exten\n";

			$stmt="UPDATE vicidial_conferences set conf_exten='$conf_exten',server_ip='$server_ip',extension='$extension' where conf_exten='$old_conf_exten';";
			$rslt=mysql_query($stmt, $link);

			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=31111111111111;	# go to vicidial conference modification form below
}



######################
# ADD=411111111111111 modify vicidial system settings
######################

if ($ADD==411111111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>IMPOSTAZIONI DI SISTEMA MODIFICATE\n";

	$stmt="UPDATE system_settings set use_non_latin='$use_non_latin',webroot_writable='$webroot_writable',enable_queuemetrics_logging='$enable_queuemetrics_logging',queuemetrics_server_ip='$queuemetrics_server_ip',queuemetrics_dbname='$queuemetrics_dbname',queuemetrics_login='$queuemetrics_login',queuemetrics_pass='$queuemetrics_pass',queuemetrics_url='$queuemetrics_url',queuemetrics_log_id='$queuemetrics_log_id',queuemetrics_eq_prepend='$queuemetrics_eq_prepend',vicidial_agent_disable='$vicidial_agent_disable',allow_sipsak_messages='$allow_sipsak_messages',admin_home_url='$admin_home_url',enable_agc_xfer_log='$enable_agc_xfer_log',timeclock_end_of_day='$timeclock_end_of_day',vdc_header_date_format='$vdc_header_date_format',vdc_customer_date_format='$vdc_customer_date_format',vdc_header_phone_format='$vdc_header_phone_format',vdc_agent_api_active='$vdc_agent_api_active';";
	$rslt=mysql_query($stmt, $link);

	### LOG CHANGES TO LOG FILE ###
	if ($WeBRooTWritablE > 0)
		{
		$fp = fopen ("./admin_changes_log.txt", "a");
		fwrite ($fp, "$date|MODIFY SYSTEM SETTINGS|$PHP_AUTH_USER|$ip|$stmt|\n");
		fclose($fp);
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=311111111111111;	# go to vicidial system settings form below
}


######################
# ADD=421111111111111 modify/delete system status in the system
######################

if ($ADD==421111111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	if (ereg('delete',$stage))
		{
		if ( (strlen($status) < 1) or (preg_match("/^B$|^NA$|^DNC$|^NA$|^DROP$|^INCALL$|^QUEUE$|^NEW$/i",$status)) )
			{
			 echo "<br>ESITO DI DEFAULT NON ELIMINATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>el estado de sistema no puede ser un estado reservado:B,NA,DNC,NA,DROP,INCALL,QUEUE,NEW\n";
			 echo "<br>el estado de sistema necesita ser por lo menos los caracteres 1 enlongitud\n";
			}
		else
			{
			echo "<br><B>SYSTEM STATUS DELETED: $status</B>\n";

			$stmt="DELETE FROM vicidial_statuses where status='$status';";
			$rslt=mysql_query($stmt, $link);

			$stmtA="DELETE FROM vicidial_campaign_hotkeys where status='$status';";
			$rslt=mysql_query($stmtA, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|DELETE SYSTEM STATUS  |$PHP_AUTH_USER|$ip|$stmt|$stmtA|\n");
				fclose($fp);
				}
			}
		}
	if (ereg('modify',$stage))
		{
		if ( (strlen($status) < 1) or (strlen($status_name) < 2) )
			{
			 echo "<br>ESITO DI DEFAULT NON MODIFICATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>el estado de sistema necesita ser por lo menos los caracteres 1 enlongitud\n";
			 echo "<br>il nome di un esito di default deve essere lungo almeno 1 carattere\n";
			}
		else
			{
			echo "<br><B>ESITO DI DEFAULT MODIFICATO: $status</B>\n";

			$stmt="UPDATE vicidial_statuses SET status_name='$status_name',selectable='$selectable',human_answered='$human_answered',category='$category' where status='$status';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFY SYSTEM STATUS  |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=321111111111111;	# go to system settings modification form below
}


######################
# ADD=431111111111111 modify/delete status category in the system
######################

if ($ADD==431111111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($vsc_id) < 2)  or (preg_match("/^UNDEFINED$/i",$vsc_id)) )
		{
		 echo "<br>CATEGORIA ESITI NON MODIFICATA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>la categoria di esiti non puo` essere una categoria riservata: UNDEFINED\n";
		 echo "<br>il nome delle categorie di esiti deve essere lungo almeno 2 caratteri\n";
		}
	 else
		{
		if (ereg('delete',$stage))
			{
			echo "<br><B>CATEGORIA ESISI CANCELLATA: $vsc_id</B>\n";

			$stmt="DELETE FROM vicidial_status_categories where vsc_id='$vsc_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|DELETE STATUS CATEGORY|$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		if (ereg('modify',$stage))
			{
			echo "<br><B>CATEGORIA ESITI MODIFICATA: $vsc_id</B>\n";

			$stmt="SELECT count(*) from vicidial_status_categories where tovdad_display='Y' and vsc_id NOT IN('$vsc_id');";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			if ( ($row[0] > 3) and (ereg('Y',$tovdad_display)) )
				{
				$tovdad_display = 'N';
				echo "<br><B>ERRORE: Ci sono gia` 4 Categorie di Stato attivi nel display TimeOnVDAD</B>\n";
				}

			$stmt="UPDATE vicidial_status_categories SET vsc_name='$vsc_name',vsc_description='$vsc_description',tovdad_display='$tovdad_display',sale_category='$sale_category',dead_lead_category='$dead_lead_category' where vsc_id='$vsc_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFY STATUS CATEGORY|$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=331111111111111;	# go to system settings modification form below
}


######################
# ADD=441111111111111 modify/delete qc status code in the system
######################

if ($ADD==441111111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	if (ereg('delete',$stage))
		{
		if ( (strlen($code) < 1) or (preg_match("/^B$|^NA$|^DNC$|^NA$|^DROP$|^INCALL$|^QUEUE$|^NEW$/i",$code)) )
			{
			 echo "<br>QC STATUS CODE NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>the qc status code cannot be a reserved esito: B,NA,DNC,NA,DROP,INCALL,QUEUE,NEW\n";
			 echo "<br>the qc status code needs to be at least 1 characters in length\n";
			}
		else
			{
			echo "<br><B>QC STATUS CODE DELETED: $code</B>\n";

			$stmt="DELETE FROM vicidial_qc_codes where code='$code';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|DELETE QC STATUS CODE |$PHP_AUTH_USER|$ip|$stmt|$stmtA|\n");
				fclose($fp);
				}
			}
		}
	if (ereg('modify',$stage))
		{
		if ( (strlen($code) < 1) or (strlen($code_name) < 2) )
			{
			 echo "<br>QC STATUS CODE NOT MODIFIED - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>the qc status code needs to be at least 1 characters in length\n";
			 echo "<br>the qc status code name needs to be at least 1 characters in length\n";
			}
		else
			{
			echo "<br><B>QC STATUS CODE MODIFIED: $code</B>\n";

			$stmt="UPDATE vicidial_qc_codes SET code_name='$code_name' where code='$code';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|MODIFY QC STATUS CODE |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=341111111111111;	# go to qc status code modification form below
}




######################################################################################################
######################################################################################################
#######   5 series, delete records confirmation
######################################################################################################
######################################################################################################


######################
# ADD=5 confirmation before deletion of user
######################

if ($ADD==5)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($user) < 2) or ($LOGdelete_users < 1) )
		{
		 echo "<br>UTENTE NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>User be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N DE LA CANCELADURA DEL USUARIO: $user</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=6&user=$user&CoNfIrM=YES\">Clicca qui per cancellare questo utente $user</a><br><br><br>\n";
		}

$ADD='3';		# go to user modification below
}

######################
# ADD=51 confirmation before deletion of campaign
######################

if ($ADD==51)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or ($LOGdelete_campaigns < 1) )
		{
		 echo "<br>CAMPAGNA NON CANCELLATA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Campagna_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N DE LA CANCELADURA DE LA CAMPAÑA: $campaign_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=61&campaign_id=$campaign_id&CoNfIrM=YES\">Clicca qui per cancellare la campagna $campaign_id</a><br><br><br>\n";
		}

$ADD='31';		# go to campaign modification below
}

######################
# ADD=52 confirmation before logging all agents out of campaign of campaign
######################

if ($ADD==52)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if (strlen($campaign_id) < 2)
		{
		 echo "<br>OPERATORI NON DISCONNESSI DALLA CAMPAGNA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Campagna_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFERMA DISCONNESSIONE OPERATORE: $campaign_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=62&campaign_id=$campaign_id&CoNfIrM=YES\">Clicca qui per disconnettere tutti gli operatori $campaign_id</a><br><br><br>\n";
		}

$ADD='31';		# go to campaign modification below
}

######################
# ADD=53 confirmation before Emergency VDAC Jam Clear - deletes oldest LIVE vicidial_auto_call record
######################

if ($ADD==53)
{
	if (eregi('IN',$stage))
		{$group_id=$campaign_id;}
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if (strlen($campaign_id) < 2)
		{
		 echo "<br>VDAC NO DESPEJo` PARA LA CAMPAÑA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Campagna_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N CLARA DE VDAC: $campaign_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=63&campaign_id=$campaign_id&CoNfIrM=YES&&stage=$stage\">Chasque aquí para suprimir el más viejo VIVEN expediente en VDACpara $campaign_id</a><br><br><br>\n";
		}

# go to campaign modification below
if (eregi('IN',$stage))
	{$ADD='3111';}
else
	{$ADD='31';}	
}

######################
# ADD=511 confirmation before deletion of list
######################

if ($ADD==511)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($list_id) < 2) or ($LOGdelete_lists < 1) )
		{
		 echo "<br>LISTA NON CANCELLATA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>List_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N DE LA CANCELADURA DE LA LISTA: $list_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=611&list_id=$list_id&CoNfIrM=YES\">Clicca qui per cancellare la lista e tutti i suoi contatti $list_id</a><br><br><br>\n";
		}

$ADD='311';		# go to campaign modification below
}

######################
# ADD=5111 confirmation before deletion of in-group
######################

if ($ADD==5111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($group_id) < 2) or ($LOGdelete_ingroups < 1) )
		{
		 echo "<br>GRUPPO INBOUND NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Group_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFERMA ELIMINAZIONE GRUPPO INBOUND: $group_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=6111&group_id=$group_id&CoNfIrM=YES\">Clicca qui per cancellare il gruppo inbound $group_id</a><br><br><br>\n";
		}

$ADD='3111';		# go to in-group modification below
}

######################
# ADD=5311 confirmation before deletion of did
######################

if ($ADD==5311)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($did_id) < 1) or ($LOGdelete_dids < 1) )
		{
		 echo "<br>DID NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>did_id be at least 1 characters in length\n";
		}
	 else
		{
		echo "<br><B>DID DELETION CONFIRMATION: $group_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=6311&did_id=$did_id&CoNfIrM=YES\">Click here to delete DID $did_id</a><br><br><br>\n";
		}

$ADD='3311';		# go to did modification below
}

######################
# ADD=51111 confirmation before deletion of remote agent record
######################

if ($ADD==51111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($remote_agent_id) < 1) or ($LOGdelete_remote_agents < 1) )
		{
		 echo "<br>AGENTE ALEJADO NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Remote_agent_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N ALEJADA DE LA CANCELADURA DEL AGENTE: $remote_agent_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=61111&remote_agent_id=$remote_agent_id&CoNfIrM=YES\">Chasque aquí para suprimir el agente alejado $remote_agent_id</a><br><br><br>\n";
		}

$ADD='31111';		# go to remote agent modification below
}

######################
# ADD=511111 confirmation before deletion of user group record
######################

if ($ADD==511111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($user_group) < 2) or ($LOGdelete_user_groups < 1) )
		{
		 echo "<br>GRUPO DE USUARIO NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>User_group be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N DE LA CANCELADURA DEL GRUPO DE USUARIO: $user_group</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=611111&user_group=$user_group&CoNfIrM=YES\">Chasque aquí para suprimir a grupo de usuario $user_group</a><br><br><br>\n";
		}

$ADD='311111';		# go to user group modification below
}

######################
# ADD=5111111 confirmation before deletion of script record
######################

if ($ADD==5111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($script_id) < 2) or ($LOGdelete_scripts < 1) )
		{
		 echo "<br>SCRIPT NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Script_id must be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N DE LA CANCELADURA DE LA ESCRITURA: $script_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=6111111&script_id=$script_id&CoNfIrM=YES\">Clicca qui per cancellare lo script $script_id</a><br><br><br>\n";
		}

$ADD='3111111';		# go to script modification below
}

######################
# ADD=51111111 confirmation before deletion of filter record
######################

if ($ADD==51111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($lead_filter_id) < 2) or ($LOGdelete_filters < 1) )
		{
		 echo "<br>FILTRO NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>ID Filtro deve essere lungo almeno 2 caratteri\n";
		}
	 else
		{
		echo "<br><B>FILTER DELETION CONFIRMATION: $lead_filter_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=61111111&lead_filter_id=$lead_filter_id&CoNfIrM=YES\">Clicca qui per cancellare il filtro$lead_filter_id</a><br><br><br>\n";
		}

$ADD='31111111';		# go to filter modification below
}

######################
# ADD=511111111 confirmation before deletion of call time record
######################

if ($ADD==511111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($call_time_id) < 2) or ($LOGdelete_call_times < 1) )
		{
		 echo "<br>TIEMPO DE LA LLAMADA NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>_ llamar tiempo identificacio`n deber ser por lo menos 2 carácter enlongitud\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N DE LA CANCELADURA DEL TIEMPO DE LA LLAMADA: $call_time_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=611111111&call_time_id=$call_time_id&CoNfIrM=YES\">Click here to delete call time $call_time_id</a><br><br><br>\n";
		}

$ADD='311111111';		# go to call time modification below
}

######################
# ADD=5111111111 confirmation before deletion of state call time record
######################

if ($ADD==5111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($call_time_id) < 2) or ($LOGdelete_call_times < 1) )
		{
		 echo "<br>TIEMPO DE LA LLAMADA DEL ESTADO NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>_ llamar tiempo identificacio`n deber ser por lo menos 2 carácter enlongitud\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N DE LA CANCELADURA DEL TIEMPO DE LA LLAMADA DEL ESTADO: $call_time_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=6111111111&call_time_id=$call_time_id&CoNfIrM=YES\">Click here to delete state call time $call_time_id</a><br><br><br>\n";
		}

$ADD='3111111111';		# go to state call time modification below
}

######################
# ADD=531111111 confirmation before deletion of shift record
######################

if ($ADD==531111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($shift_id) < 2) or ($LOGdelete_call_times < 1) )
		{
		 echo "<br>SHIFT NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Shift ID must be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>SHIFT DELETION CONFIRMATION: $shift_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=631111111&shift_id=$shift_id&CoNfIrM=YES\">Click here to delete shift $shift_id</a><br><br><br>\n";
		}

$ADD='331111111';		# go to call time modification below
}

######################
# ADD=51111111111 confirmation before deletion of phone record
######################

if ($ADD==51111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($extension) < 2) or (strlen($server_ip) < 7) or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>TELEFONO NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Extension be at least 2 characters in length\n";
		 echo "<br>IP Server be at least 7 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFIRMACIo`N DE LA CANCELADURA DEL telefonO: $extension - $server_ip</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=61111111111&extension=$extension&server_ip=$server_ip&CoNfIrM=YES\">Clicca qui per cancellare il telefono $extension - $server_ip</a><br><br><br>\n";
		}
$ADD='31111111111';		# go to phone modification below
}


######################
# ADD=52111111111 confirmation before deletion of phone alias record
######################

if ($ADD==52111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($alias_id) < 1) or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>PHONE ALIAS NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Alias ID must be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>PHONE ALIAS DELETION CONFIRMATION: $alias_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=62111111111&alias_id=$alias_id&CoNfIrM=YES\">Clicca qui per cancellare il telefono alias $alias_id</a><br><br><br>\n";
		}
$ADD='32111111111';		# go to phone alias modification below
}


######################
# ADD=511111111111 confirmation before deletion of server record
######################

if ($ADD==511111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($server_id) < 2) or (strlen($server_ip) < 7) or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>SERVER NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>ID Server be at least 2 characters in length\n";
		 echo "<br>IP Server be at least 7 characters in length\n";
		}
	 else
		{
		echo "<br><B>SERVER DELETION CONFIRMATION: $server_id - $server_ip</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=611111111111&server_id=$server_id&server_ip=$server_ip&CoNfIrM=YES\">Clicca qui per cancellare il telefono $server_id - $server_ip</a><br><br><br>\n";
		}
$ADD='311111111111';		# go to server modification below
}


######################
# ADD=5111111111111 confirmation before deletion of conference record
######################

if ($ADD==5111111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($conf_exten) < 2) or (strlen($server_ip) < 7) or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>CONFERENCE NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Conference must be at least 2 characters in length\n";
		 echo "<br>IP Server be at least 7 characters in length\n";
		}
	 else
		{
		echo "<br><B>CONFERENCE DELETION CONFIRMATION: $conf_exten - $server_ip</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=6111111111111&conf_exten=$conf_exten&server_ip=$server_ip&CoNfIrM=YES\">Clicca qui per cancellare il telefono $conf_exten - $server_ip</a><br><br><br>\n";
		}
$ADD='3111111111111';		# go to conference modification below
}


######################
# ADD=51111111111111 confirmation before deletion of vicidial conference record
######################

if ($ADD==51111111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($conf_exten) < 2) or (strlen($server_ip) < 7) or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>VICIDIAL CONFERENCE NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Conference must be at least 2 characters in length\n";
		 echo "<br>IP Server be at least 7 characters in length\n";
		}
	 else
		{
		echo "<br><B>VICIDIAL CONFERENCE DELETION CONFIRMATION: $conf_exten - $server_ip</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=61111111111111&conf_exten=$conf_exten&server_ip=$server_ip&CoNfIrM=YES\">Clicca qui per cancellare il telefono $conf_exten - $server_ip</a><br><br><br>\n";
		}
$ADD='31111111111111';		# go to vicidial conference modification below
}



######################################################################################################
######################################################################################################
#######   6 series, delete records
######################################################################################################
######################################################################################################


######################
# ADD=6 delete user record
######################

if ($ADD==6)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( ( strlen($user) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_users < 1) )
		{
		 echo "<br>UTENTE NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>User be at least 2 characters in length\n";
		}
	 else
		{
		$stmtA="DELETE from vicidial_users where user='$user' limit 1;";
		$rslt=mysql_query($stmtA, $link);

		$stmt="DELETE from vicidial_campaign_agents where user='$user';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_inbound_group_agents where user='$user';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!!DELETING USER!!!!|$PHP_AUTH_USER|$ip|$user|$stmtA|$stmt|\n");
			fclose($fp);
			}
		echo "<br><B>CANCELADURA DEL USUARIO TERMINADA: $user</B>\n";
		echo "<br><br>\n";
		}

$ADD='0';		# go to user list
}

######################
# ADD=61 delete campaign record
######################

if ($ADD==61)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( ( strlen($campaign_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_campaigns < 1) )
		{
		 echo "<br>CAMPAGNA NON CANCELLATA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Campagna_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_campaigns where campaign_id='$campaign_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_campaign_agents where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_live_agents where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_campaign_statuses where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_campaign_hotkeys where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_callbacks where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_campaign_stats where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_lead_recycle where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_campaign_server_stats where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_server_trunks where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_pause_codes where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_campaigns_list_mix where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br>QUITAR LOS PLOMOS DE LA TOLVA DE LA LISTA DE VIEJA TOLVA DE LA CAMPAÚA ($campaign_id)\n";
		$stmt="DELETE from vicidial_hopper where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!DELETING CAMPAIGN!|$PHP_AUTH_USER|$ip|campaign_id='$campaign_id'|\n");
			fclose($fp);
			}
		echo "<br><B>LA CANCELADURA DE LA CAMPAÑA TERMINo`: $campaign_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='10';		# go to campaigns list
}

######################
# ADD=62 Logout all agents from a campaign
######################

if ($ADD==62)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if (strlen($campaign_id) < 2)
		{
		 echo "<br>OPERATORI NON DISCONNESSI DALLA CAMPAGNA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Campagna_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_live_agents where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!AGENT LOGOUT!!!!!!|$PHP_AUTH_USER|$ip|campaign_id='$campaign_id'|\n");
			fclose($fp);
			}
		echo "<br><B>DISCONNESSIONE OPERATORI COMPLETATA: $campaign_id</B>\n";
		echo "<br><br>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD='31';		# go to campaign modification below
}


######################
# ADD=63 Emergency VDAC Jam Clear
######################

if ($ADD==63)
{
	if ($LOGmodify_campaigns==1)
	{
	if (eregi('IN',$stage))
		{$group_id=$campaign_id;}
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if (strlen($campaign_id) < 2)
		{
		 echo "<br>VDAC NO DESPEJo` PARA LA CAMPAÑA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Campagna_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_auto_calls where status='LIVE' and campaign_id='$campaign_id' order by call_time limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|EMERGENCY VDAC CLEAR|$PHP_AUTH_USER|$ip|campaign_id='$campaign_id'|\n");
			fclose($fp);
			}
		echo "<br><B>DE REGISTRO PASADO DE VDAC DESPEJADA PARA LA CAMPAÑA: $campaign_id</B>\n";
		echo "<br><br>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
# go to campaign modification below
if (eregi('IN',$stage))
	{$ADD='3111';}
else
	{$ADD='31';}	
}


######################
# ADD=65 delete campaign lead recycle in the system
######################

if ($ADD==65)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) )
		{
		 echo "<br>EL PLOMO DE LA CAMPAÑA RECICLA NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>el estado debe estar entre 1 y 6 caracteres en longitud\n";
		 echo "<br>la tentativa retrasa debe ser por lo menos 120 segundos\n";
		 echo "<br>las tentativas máximas deben ser a partir la 1 a 10\n";
		}
	 else
		{
		echo "<br><B>EL PLOMO DE LA CAMPAÑA RECICLA SUPRIMIDO: $campaign_id - $status - $attempt_delay</B>\n";

		$stmt="DELETE FROM vicidial_lead_recycle where campaign_id='$campaign_id' and status='$status';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|DELETE LEAD RECYCLE   |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB=25;
$ADD=31;	# go to campaign modification form below
}


######################
# ADD=66 delete auto alt dial status from the campaign
######################

if ($ADD==66)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaigns where campaign_id='$campaign_id' and auto_alt_dial_statuses LIKE \"% $status %\";";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] < 1)
		{echo "<br>ESTADO AUTO DEL DIAL DEL ALT NO SUPRIMIDO - este estado del dial del alt del automo`vil no está en esta campaña\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) )
			{
			 echo "<br>ESTADO AUTO DEL DIAL DEL ALT NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>el estado debe estar entre 1 y 6 caracteres en longitud\n";
			}
		 else
			{
			echo "<br><B>ESTADO AUTO DEL DIAL DEL ALT SUPRIMIDO: $campaign_id - $status</B>\n";

			$stmt="SELECT auto_alt_dial_statuses from vicidial_campaigns where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);

			$auto_alt_dial_statuses = eregi_replace(" $status "," ",$row[0]);
			$stmt="UPDATE vicidial_campaigns set auto_alt_dial_statuses='$auto_alt_dial_statuses' where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|DELETE AUTALTDIALSTTUS|$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB=26;
$ADD=31;	# go to campaign modification form below
}

######################
# ADD=67 delete agent pause code in the system
######################

if ($ADD==67)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or (strlen($pause_code) < 1) )
		{
		 echo "<br>Co`DIGO DE LA PAUSA DE LA CAMPAÑA NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>pause code must be between 1 and 6 characters in length\n";
		}
	 else
		{
		echo "<br><B>CAMPAIGN PAUSE CODE DELETED: $campaign_id - $pause_code</B>\n";

		$stmt="DELETE FROM vicidial_pause_codes where campaign_id='$campaign_id' and pause_code='$pause_code';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|DELETE AGENT PAUSECODE|$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$SUB=27;
$ADD=31;	# go to campaign modification form below
}


######################
# ADD=68 remove campaign dial status
######################

if ($ADD==68)
{
	if ($LOGmodify_campaigns==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaigns where campaign_id='$campaign_id' and dial_statuses LIKE \"% $status %\";";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] < 1)
		{echo "<br>ESITO CAMPAGNA NON RIMOSSO - questo esito di chiamata non e` selezionato per questa campagna\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) )
			{
			 echo "<br>ESITO CAMPAGNA NON RIMOSSO - Per favore torna indietro e ricontrolla i dati inseriti\n";
			 echo "<br>el estado debe estar entre 1 y 6 caracteres en longitud\n";
			}
		 else
			{
			echo "<br><B>ESITO CAMPAGNA RIMOSSO: $campaign_id - $status</B>\n";

			$stmt="SELECT dial_statuses from vicidial_campaigns where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);

			$dial_statuses = eregi_replace(" $status "," ",$row[0]);
			$stmt="UPDATE vicidial_campaigns set dial_statuses='$dial_statuses' where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|DIAL STATUS REMOVED   |$PHP_AUTH_USER|$ip|$stmt|\n");
				fclose($fp);
				}
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
#$SUB=28;
$ADD=31;	# go to campaign modification form below
}

######################
# ADD=611 delete list record and all leads within it
######################

if ($ADD==611)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( ( strlen($list_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_lists < 1) )
		{
		 echo "<br>LISTA NON CANCELLATA - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>List_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_lists where list_id='$list_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		echo "<br>QUITAR LOS PLOMOS DE LA TOLVA DE LA LISTA DE VIEJA TOLVA DE LA CAMPAÚA ($list_id)\n";
		$stmt="DELETE from vicidial_hopper where list_id='$list_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br>QUITAR LOS PLOMOS DE LA LISTA DE LA TABLA DE VICIDIAL_LIST\n";
		$stmt="DELETE from vicidial_list where list_id='$list_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!!DELETING LIST!!!!|$PHP_AUTH_USER|$ip|list_id='$list_id'|\n");
			fclose($fp);
			}
		echo "<br><B>LA CANCELADURA DE LA LISTA TERMINo`: $list_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='100';		# go to lists list
}

######################
# ADD=6111 delete in-group record
######################

if ($ADD==6111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($group_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_ingroups < 1) )
		{
		 echo "<br>GRUPPO INBOUND NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Group_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_inbound_groups where group_id='$group_id' and group_id NOT IN('AGENTDIRECT') limit 1;";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_inbound_group_agents where group_id='$group_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_live_inbound_agents where group_id='$group_id';";
		$rslt=mysql_query($stmt, $link);

		$stmt="DELETE from vicidial_campaign_stats where campaign_id='$group_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING IN-GROUP!!|$PHP_AUTH_USER|$ip|group_id='$group_id'|\n");
			fclose($fp);
			}
		echo "<br><B>ELIMINAZIONE GRUPPO INBOUND COMPLETATA: $group_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='1000';		# go to in-group list
}

######################
# ADD=6311 delete did record
######################

if ($ADD==6311)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($did_id) < 1) or ($CoNfIrM != 'YES') or ($LOGdelete_dids < 1) )
		{
		 echo "<br>DID NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>did_id be at least 1 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_inbound_dids where did_id='$did_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING DID!!!!!!!|$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		echo "<br><B>DID DELETION COMPLETED: $did_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='1300';		# go to did list
}

######################
# ADD=61111 delete remote agent record
######################

if ($ADD==61111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($remote_agent_id) < 1) or ($CoNfIrM != 'YES') or ($LOGdelete_remote_agents < 1) )
		{
		 echo "<br>AGENTE ALEJADO NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Remote_agent_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_remote_agents where remote_agent_id='$remote_agent_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING RMTAGENT!!|$PHP_AUTH_USER|$ip|remote_agent_id='$remote_agent_id'|\n");
			fclose($fp);
			}
		echo "<br><B>CANCELADURA ALEJADA DEL AGENTE TERMINADA: $remote_agent_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='10000';		# go to remote agents list
}

######################
# ADD=611111 delete user group record
######################

if ($ADD==611111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($user_group) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_user_groups < 1) )
		{
		 echo "<br>GRUPO DE USUARIO NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>User_group be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_user_groups where user_group='$user_group' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING USRGROUP!!|$PHP_AUTH_USER|$ip|user_group='$user_group'|\n");
			fclose($fp);
			}
		echo "<br><B>CANCELADURA DEL GRUPO DE USUARIO TERMINADA: $user_group</B>\n";
		echo "<br><br>\n";
		}

$ADD='100000';		# go to user group list
}

######################
# ADD=6111111 delete script record
######################

if ($ADD==6111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($script_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_scripts < 1) )
		{
		 echo "<br>SCRIPT NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Script_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_scripts where script_id='$script_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING SCRIPT!!!!|$PHP_AUTH_USER|$ip|script_id='$script_id'|\n");
			fclose($fp);
			}
		echo "<br><B>CANCELADURA DE LA ESCRITURA TERMINADA: $script_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='1000000';		# go to script list
}


######################
# ADD=61111111 delete filter record
######################

if ($ADD==61111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($lead_filter_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_filters < 1) )
		{
		 echo "<br>FILTRO NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>ID Filtro deve essere lungo almeno 2 caratteri\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_lead_filters where lead_filter_id='$lead_filter_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING FILTER!!!!|$PHP_AUTH_USER|$ip|lead_filter_id='$lead_filter_id'|\n");
			fclose($fp);
			}
		echo "<br><B>CANCELLAZIONE FILTRO COMPLETATA: $lead_filter_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='10000000';		# go to filter list
}


######################
# ADD=611111111 delete call times record
######################

if ($ADD==611111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($call_time_id) < 2) or ($LOGdelete_call_times < 1) )
		{
		 echo "<br>TIEMPO DE LA LLAMADA NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>_ llamar tiempo identificacio`n deber ser por lo menos 2 carácter enlongitud\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_call_times where call_time_id='$call_time_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING CALL TIME!|$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		echo "<br><B>_ LLAMAR TIEMPO CANCELADURA TERMINAR: $call_time_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='100000000';		# go to call times list
}


######################
# ADD=6111111111 delete state call times record
######################

if ($ADD==6111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($call_time_id) < 2) or ($LOGdelete_call_times < 1) )
		{
		 echo "<br>TIEMPO DE LA LLAMADA DEL ESTADO NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>_ llamar tiempo identificacio`n deber ser por lo menos 2 carácter enlongitud\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_state_call_times where state_call_time_id='$call_time_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		$stmt="SELECT call_time_id,ct_state_call_times from vicidial_call_times where ct_state_call_times LIKE \"%|$call_time_id|%\" order by call_time_id;";
		$rslt=mysql_query($stmt, $link);
		$sct_to_print = mysql_num_rows($rslt);
		$sct_list='';

		$o=0;
		while ($sct_to_print > $o) {
			$rowx=mysql_fetch_row($rslt);
			$sct_ids[$o] = "$rowx[0]";
			$sct_states[$o] = "$rowx[1]";
			$o++;
		}
		$o=0;

		while ($sct_to_print > $o) {
			$sct_states[$o] = eregi_replace("\|$call_time_id\|",'|',$sct_states[$o]);
			$stmt="UPDATE vicidial_call_times set ct_state_call_times='$sct_states[$o]' where call_time_id='$sct_ids[$o]';";
			$rslt=mysql_query($stmt, $link);
			echo "$stmt\n";
			echo "Regla Del Estado Quitada: $sct_ids[$o]<BR>\n";
			$o++;
		}

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING CALL TIME!|$PHP_AUTH_USER|$ip|state_call_time_id='$call_time_id'|\n");
			fclose($fp);
			}
		echo "<br><B>CANCELADURA DEL TIEMPO DE LA LLAMADA DEL ESTADO TERMINADA: $call_time_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='1000000000';		# go to call times list
}


######################
# ADD=631111111 delete shift record
######################

if ($ADD==631111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($shift_id) < 2) or ($LOGdelete_call_times < 1) )
		{
		 echo "<br>SHIFT NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Shift ID must be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_shifts where shift_id='$shift_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING SHIFT!!!!!|$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		echo "<br><B>SHIFT DELETION COMPLETED: $shift_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='130000000';		# go to shifts list
}


######################
# ADD=61111111111 delete phone record
######################

if ($ADD==61111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($extension) < 2) or (strlen($server_ip) < 7) or ($CoNfIrM != 'YES') or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>TELEFONO NON CANCELLATO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Extension be at least 2 characters in length\n";
		 echo "<br>IP Server be at least 7 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from phones where extension='$extension' and server_ip='$server_ip' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!!DELETING PHONE!!!|$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		echo "<br><B>LA CANCELADURA DEL telefonO TERMINo`: $extension - $server_ip</B>\n";
		echo "<br><br>\n";
		}
$ADD='10000000000';		# go to phone list
}


######################
# ADD=62111111111 delete phone alias record
######################

if ($ADD==62111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($alias_id) < 2) or ($CoNfIrM != 'YES') or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>PHONE ALIAS NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Alias ID must be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from phones_alias where alias_id='$alias_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETE PHONE ALIAS!|$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		echo "<br><B>PHONE ALIAS DELETION COMPLETED: $alias_id</B>\n";
		echo "<br><br>\n";
		}
$ADD='12000000000';		# go to phone alias list
}


######################
# ADD=611111111111 delete server record
######################

if ($ADD==611111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($server_id) < 2) or (strlen($server_ip) < 7) or ($CoNfIrM != 'YES') or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>SERVER NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>ID Server be at least 2 characters in length\n";
		 echo "<br>IP Server be at least 7 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from servers where server_id='$server_id' and server_ip='$server_ip' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!!DELETING SERVER!!|$PHP_AUTH_USER|$ip|server_id='$server_id'|server_ip='$server_ip'|\n");
			fclose($fp);
			}
		echo "<br><B>SERVER DELETION COMPLETED: $server_id - $server_ip</B>\n";
		echo "<br><br>\n";
		}
$ADD='100000000000';		# go to server list
}


######################
# ADD=621111111111 delete vicidial server trunk record in the system
######################

if ($ADD==621111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or (strlen($server_ip) < 7) )
		{
		 echo "<br>EXPEDIENTE DEL TRONCO DEL SERVIDOR DE VICIDIAL NO SUPRIMIDO - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>la campaña debe estar entre 3 y 8 caracteres en longitud\n";
		 echo "<br>el server_ip retrasa debe ser por lo menos 7 caracteres\n";
		}
	 else
		{
		echo "<br><B>EXPEDIENTE DEL TRONCO DEL SERVIDOR DE VICIDIAL SUPRIMIDO: $campaign_id - $server_ip</B>\n";

		$stmt="DELETE FROM vicidial_server_trunks where campaign_id='$campaign_id' and server_ip='$server_ip';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|DELETE SERVER TRUNK   |$PHP_AUTH_USER|$ip|$stmt|\n");
			fclose($fp);
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
$ADD=311111111111;	# go to server modification form below
}


######################
# ADD=6111111111111 delete conference record
######################

if ($ADD==6111111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($conf_exten) < 2) or (strlen($server_ip) < 7) or ($CoNfIrM != 'YES') or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>CONFERENCE NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Conference be at least 2 characters in length\n";
		 echo "<br>IP Server be at least 7 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from conferences where conf_exten='$conf_exten' and server_ip='$server_ip' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!!DELETING CONF!!!!|$PHP_AUTH_USER|$ip|conf_exten='$conf_exten'|server_ip='$server_ip'|\n");
			fclose($fp);
			}
		echo "<br><B>CONFERENCE DELETION COMPLETED: $conf_exten - $server_ip</B>\n";
		echo "<br><br>\n";
		}
$ADD='1000000000000';		# go to conference list
}


######################
# ADD=61111111111111 delete vicidial conference record
######################

if ($ADD==61111111111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($conf_exten) < 2) or (strlen($server_ip) < 7) or ($CoNfIrM != 'YES') or ($LOGast_delete_phones < 1) )
		{
		 echo "<br>VICIDIAL CONFERENCE NOT DELETED - Per favore torna indietro e ricontrolla i dati inseriti\n";
		 echo "<br>Conference be at least 2 characters in length\n";
		 echo "<br>IP Server be at least 7 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_conferences where conf_exten='$conf_exten' and server_ip='$server_ip' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!!DELETING CONF!!!!|$PHP_AUTH_USER|$ip|conf_exten='$conf_exten'|server_ip='$server_ip'|\n");
			fclose($fp);
			}
		echo "<br><B>VICIDIAL CONFERENCE DELETION COMPLETED: $conf_exten - $server_ip</B>\n";
		echo "<br><br>\n";
		}
$ADD='10000000000000';		# go to vicidial conference list
}





######################################################################################################
######################################################################################################
#######   3 series, record modification forms
######################################################################################################
######################################################################################################




######################
# ADD=3 modify user info in the system
######################

if ($ADD==3)
{
	if ($LOGmodify_users==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_users where user='$user';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$user_level =			$row[4];
	$user_group =			$row[5];
	$phone_login =			$row[6];
	$phone_pass =			$row[7];
	$delete_users =			$row[8];
	$delete_user_groups =	$row[9];
	$delete_lists =			$row[10];
	$delete_campaigns =		$row[11];
	$delete_ingroups =		$row[12];
	$delete_remote_agents =	$row[13];
	$load_leads =			$row[14];
	$campaign_detail =		$row[15];
	$ast_admin_access =		$row[16];
	$ast_delete_phones =	$row[17];
	$delete_scripts =		$row[18];
	$modify_leads =			$row[19];
	$hotkeys_active =		$row[20];
	$change_agent_campaign =$row[21];
	$agent_choose_ingroups =$row[22];
	$scheduled_callbacks =	$row[24];
	$agentonly_callbacks =	$row[25];
	$agentcall_manual =		$row[26];
	$vicidial_recording =	$row[27];
	$vicidial_transfers =	$row[28];
	$delete_filters =		$row[29];
	$alter_agent_interface_options =$row[30];
	$closer_default_blended =		$row[31];
	$delete_call_times =	$row[32];
	$modify_call_times =	$row[33];
	$modify_users =			$row[34];
	$modify_campaigns =		$row[35];
	$modify_lists =			$row[36];
	$modify_scripts =		$row[37];
	$modify_filters =		$row[38];
	$modify_ingroups =		$row[39];
	$modify_usergroups =	$row[40];
	$modify_remoteagents =	$row[41];
	$modify_servers =		$row[42];
	$view_reports =			$row[43];
	$vicidial_recording_override =	$row[44];
	$alter_custdata_override = $row[45];
	$qc_enabled =			$row[46];
	$qc_user_level =		$row[47];
	$qc_pass =				$row[48];
	$qc_finish =			$row[49];
	$qc_commit =			$row[50];
	$add_timeclock_log =	$row[51];
	$modify_timeclock_log = $row[52];
	$delete_timeclock_log = $row[53];
	$alter_custphone_override = $row[54];
	$vdc_agent_api_access = $row[55];
	$modify_inbound_dids =	$row[56];
	$delete_inbound_dids =	$row[57];


	if ( ($user_level >= $LOGuser_level) and ($LOGuser_level < 9) )
		{
		echo "<br>Non hai l`autorizzazione per modificare questo utente: $row[1]\n";
		}
	else
		{
		echo "<br>MODIFICA UN UTENTE: $row[1]<form action=$PHP_SELF method=POST>\n";
		if ($LOGuser_level > 8)
			{echo "<input type=hidden name=ADD value=4A>\n";}
		else
			{
			if ($LOGalter_agent_interface == "1")
				{echo "<input type=hidden name=ADD value=4B>\n";}
			else
				{echo "<input type=hidden name=ADD value=4>\n";}
			}
		echo "<input type=hidden name=user value=\"$row[1]\">\n";
		echo "<center><TABLE width=$section_width cellspacing=3>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Numero Utente: </td><td align=left><b>$row[1]</b>$NWB#vicidial_users-user$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Password: </td><td align=left><input type=text name=pass size=20 maxlength=10 value=\"$row[2]\">$NWB#vicidial_users-pass$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Nome Completo: </td><td align=left><input type=text name=full_name size=30 maxlength=30 value=\"$row[3]\">$NWB#vicidial_users-full_name$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Livello Utente: </td><td align=left><select size=1 name=user_level>";
		$h=1;
		while ($h<=$LOGuser_level)
			{
			echo "<option>$h</option>";
			$h++;
			}
		echo "<option SELECTED>$row[4]</option></select>$NWB#vicidial_users-user_level$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right><A HREF=\"$PHP_SELF?ADD=311111&user_group=$user_group\">Gruppo Utente</A>: </td><td align=left><select size=1 name=user_group>\n";

			$stmt="SELECT user_group,group_name from vicidial_user_groups order by user_group";
			$rslt=mysql_query($stmt, $link);
			$Ugroups_to_print = mysql_num_rows($rslt);
			$Ugroups_list='';

			$o=0;
			while ($Ugroups_to_print > $o) {
				$rowx=mysql_fetch_row($rslt);
				$Ugroups_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
				$o++;
			}
		echo "$Ugroups_list";
		echo "<option SELECTED>$user_group</option>\n";
		echo "</select>$NWB#vicidial_users-user_group$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Login Telefono: </td><td align=left><input type=text name=phone_login size=20 maxlength=20 value=\"$phone_login\">$NWB#vicidial_users-phone_login$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Password Telefono: </td><td align=left><input type=text name=phone_pass size=20 maxlength=20 value=\"$phone_pass\">$NWB#vicidial_users-phone_pass$NWE</td></tr>\n";

		if ( ($LOGuser_level > 8) or ($LOGalter_agent_interface == "1") )
			{
			echo "<tr bgcolor=#015B91><td colspan=2 align=center><font color=white><B>OPZIONI INTERFACCIA OPERATORE:</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>El Agente Elige Ingroups: </td><td align=left><select size=1 name=agent_choose_ingroups><option>0</option><option>1</option><option SELECTED>$agent_choose_ingroups</option></select>$NWB#vicidial_users-agent_choose_ingroups$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>Hot Keys Activo: </td><td align=left><select size=1 name=hotkeys_active><option>0</option><option>1</option><option SELECTED>$hotkeys_active</option></select>$NWB#vicidial_users-hotkeys_active$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>Servicios repetidos Programar: </td><td align=left><select size=1 name=scheduled_callbacks><option>0</option><option>1</option><option SELECTED>$scheduled_callbacks</option></select>$NWB#vicidial_users-scheduled_callbacks$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>Richiami esclusivi dell`operatore: </td><td align=left><select size=1 name=agentonly_callbacks><option>0</option><option>1</option><option SELECTED>$agentonly_callbacks</option></select>$NWB#vicidial_users-agentonly_callbacks$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>Chiamata Manuale Operatore: </td><td align=left><select size=1 name=agentcall_manual><option>0</option><option>1</option><option SELECTED>$agentcall_manual</option></select>$NWB#vicidial_users-agentcall_manual$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>Registrazione Vicidial: </td><td align=left><select size=1 name=vicidial_recording><option>0</option><option>1</option><option SELECTED>$vicidial_recording</option></select>$NWB#vicidial_users-vicidial_recording$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>Trasferimenti Vicidial: </td><td align=left><select size=1 name=vicidial_transfers><option>0</option><option>1</option><option SELECTED>$vicidial_transfers</option></select>$NWB#vicidial_users-vicidial_transfers$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>Un Defecto Más cercano Mezclado: </td><td align=left><select size=1 name=closer_default_blended><option>0</option><option>1</option><option SELECTED>$closer_default_blended</option></select>$NWB#vicidial_users-closer_default_blended$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>Invalidacio`n De la grabacion de VICIDIAL:</td><td align=left><select size=1 name=vicidial_recording_override><option>DISABLED</option><option>NEVER</option><option>ONDEMAND</option><option>ALLCALLS</option><option>ALLFORCE</option><option SELECTED>$vicidial_recording_override</option></select>$NWB#vicidial_users-vicidial_recording_override$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>El Agente Altera La Invalidacio`n De los Datos Del Cliente: </td><td align=left><select size=1 name=alter_custdata_override><option>NOT_ACTIVE</option><option>ALLOW_ALTER</option><option SELECTED>$alter_custdata_override</option></select>$NWB#vicidial_users-alter_custdata_override$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=right>Agent Alter Customer Phone Override: </td><td align=left><select size=1 name=alter_custphone_override><option>NOT_ACTIVE</option><option>ALLOW_ALTER</option><option SELECTED>$alter_custphone_override</option></select>$NWB#vicidial_users-alter_custphone_override$NWE</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=center colspan=2>Classifiche Campagna:$NWB#vicidial_users-campaign_ranks$NWE<BR>\n";
			echo "<table border=0>\n";
			echo "$RANKcampaigns_list";
			echo "</table>\n";
			echo "</td></tr>\n";
			echo "<tr bgcolor=#B6D3FC><td align=center colspan=2>Gruppi Inbound: $NWB#vicidial_users-closer_campaigns$NWE<BR>\n";
			echo "<table border=0>\n";
			echo "$RANKgroups_list";
			echo "</table>\n";
			echo "</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>QC Enabled: </td><td align=left><select size=1 name=qc_enabled><option>0</option><option>1</option><option SELECTED>$qc_enabled</option></select>$NWB#vicidial_users-qc_enabled$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>QC Livello Utente: </td><td align=left><select size=1 name=qc_user_level><option value=1>1 - Modify Nothing</option><option value=2>2 - Modify Nothing Except Status</option><option value=3>3 - Modify All Fields</option><option value=4>4 - Verify First Round of QC</option><option value=5>5 - View QC Statistics</option><option value=6>6 - Ability to Modify FINISHed records</option><option value=7>7 - Manager Level</option><option SELECTED>$qc_user_level</option></select>$NWB#vicidial_users-qc_user_level$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>QC Pass: </td><td align=left><select size=1 name=qc_pass><option>0</option><option>1</option><option SELECTED>$qc_pass</option></select>$NWB#vicidial_users-qc_pass$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>QC Finish: </td><td align=left><select size=1 name=qc_finish><option>0</option><option>1</option><option SELECTED>$qc_finish</option></select>$NWB#vicidial_users-qc_finish$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>QC Commit: </td><td align=left><select size=1 name=qc_commit><option>0</option><option>1</option><option SELECTED>$qc_commit</option></select>$NWB#vicidial_users-qc_commit$NWE</td></tr>\n";
			}
		if ($LOGuser_level > 8)
			{
			echo "<tr bgcolor=#015B91><td colspan=2 align=center><font color=white><B>OPZIONI INTERFACCIA AMMINISTRATORE:</td></tr>\n";

#9BB9FB
#B9CBFD
			echo "<tr bgcolor=#9BB9FB><td align=right>Visualizza Report: </td><td align=left><select size=1 name=view_reports><option>0</option><option>1</option><option SELECTED>$view_reports</option></select>$NWB#vicidial_users-view_reports$NWE</td></tr>\n";

			echo "<tr bgcolor=#B9CBFD><td align=right>Modifica Opzioni Interfaccia Operatore: </td><td align=left><select size=1 name=alter_agent_interface_options><option>0</option><option>1</option><option SELECTED>$alter_agent_interface_options</option></select>$NWB#vicidial_users-alter_agent_interface_options$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Modifica Utenti: </td><td align=left><select size=1 name=modify_users><option>0</option><option>1</option><option SELECTED>$modify_users</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Cambia la campagna di un operatore: </td><td align=left><select size=1 name=change_agent_campaign><option>0</option><option>1</option><option SELECTED>$change_agent_campaign</option></select>$NWB#vicidial_users-change_agent_campaign$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Cancella Utenti: </td><td align=left><select size=1 name=delete_users><option>0</option><option>1</option><option SELECTED>$delete_users</option></select>$NWB#vicidial_users-delete_users$NWE</td></tr>\n";

			echo "<tr bgcolor=#9BB9FB><td align=right>Modifique A Grupos De Usuario: </td><td align=left><select size=1 name=modify_usergroups><option>0</option><option>1</option><option SELECTED>$modify_usergroups</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>Suprima a grupos de usuario: </td><td align=left><select size=1 name=delete_user_groups><option>0</option><option>1</option><option SELECTED>$delete_user_groups</option></select>$NWB#vicidial_users-delete_user_groups$NWE</td></tr>\n";

			echo "<tr bgcolor=#B9CBFD><td align=right>Modifica Liste: </td><td align=left><select size=1 name=modify_lists><option>0</option><option>1</option><option SELECTED>$modify_lists</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Cancella Liste: </td><td align=left><select size=1 name=delete_lists><option>0</option><option>1</option><option SELECTED>$delete_lists</option></select>$NWB#vicidial_users-delete_lists$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Carica Contatti: </td><td align=left><select size=1 name=load_leads><option>0</option><option>1</option><option SELECTED>$load_leads</option></select>$NWB#vicidial_users-load_leads$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Modifica Contatti: </td><td align=left><select size=1 name=modify_leads><option>0</option><option>1</option><option SELECTED>$modify_leads</option></select>$NWB#vicidial_users-modify_leads$NWE</td></tr>\n";

			echo "<tr bgcolor=#9BB9FB><td align=right>Modifica Campagne: </td><td align=left><select size=1 name=modify_campaigns><option>0</option><option>1</option><option SELECTED>$modify_campaigns</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>Dettagli Campagna: </td><td align=left><select size=1 name=campaign_detail><option>0</option><option>1</option><option SELECTED>$campaign_detail</option></select>$NWB#vicidial_users-campaign_detail$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>Cancella Campagne: </td><td align=left><select size=1 name=delete_campaigns><option>0</option><option>1</option><option SELECTED>$delete_campaigns</option></select>$NWB#vicidial_users-delete_campaigns$NWE</td></tr>\n";

			echo "<tr bgcolor=#B9CBFD><td align=right>Modifica Gruppi Inbound: </td><td align=left><select size=1 name=modify_ingroups><option>0</option><option>1</option><option SELECTED>$modify_ingroups</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>En-Grupos de la cancelacio`n: </td><td align=left><select size=1 name=delete_ingroups><option>0</option><option>1</option><option SELECTED>$delete_ingroups</option></select>$NWB#vicidial_users-delete_ingroups$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Modify DIDs: </td><td align=left><select size=1 name=modify_inbound_dids><option>0</option><option>1</option><option SELECTED>$modify_inbound_dids</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Delete DIDs: </td><td align=left><select size=1 name=delete_inbound_dids><option>0</option><option>1</option><option SELECTED>$delete_inbound_dids</option></select>$NWB#vicidial_users-delete_ingroups$NWE</td></tr>\n";

			echo "<tr bgcolor=#9BB9FB><td align=right>Modifica Operatori Remoti: </td><td align=left><select size=1 name=modify_remoteagents><option>0</option><option>1</option><option SELECTED>$modify_remoteagents</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>Suprima los agentes alejados: </td><td align=left><select size=1 name=delete_remote_agents><option>0</option><option>1</option><option SELECTED>$delete_remote_agents</option></select>$NWB#vicidial_users-delete_remote_agents$NWE</td></tr>\n";

			echo "<tr bgcolor=#B9CBFD><td align=right>Modifica Script: </td><td align=left><select size=1 name=modify_scripts><option>0</option><option>1</option><option SELECTED>$modify_scripts</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Cancella Script: </td><td align=left><select size=1 name=delete_scripts><option>0</option><option>1</option><option SELECTED>$delete_scripts</option></select>$NWB#vicidial_users-delete_scripts$NWE</td></tr>\n";

			echo "<tr bgcolor=#9BB9FB><td align=right>Modifica Filtri: </td><td align=left><select size=1 name=modify_filters><option>0</option><option>1</option><option SELECTED>$modify_filters</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>Cancella Filtros: </td><td align=left><select size=1 name=delete_filters><option>0</option><option>1</option><option SELECTED>$delete_filters</option></select>$NWB#vicidial_users-delete_filters$NWE</td></tr>\n";

			echo "<tr bgcolor=#B9CBFD><td align=right>Acceso de AGC Admin: </td><td align=left><select size=1 name=ast_admin_access><option>0</option><option>1</option><option SELECTED>$ast_admin_access</option></select>$NWB#vicidial_users-ast_admin_access$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>La cancelacio`n de AGC telefona: </td><td align=left><select size=1 name=ast_delete_phones><option>0</option><option>1</option><option SELECTED>$ast_delete_phones</option></select>$NWB#vicidial_users-ast_delete_phones$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Modifique El Tiempo De la Llamadas: </td><td align=left><select size=1 name=modify_call_times><option>0</option><option>1</option><option SELECTED>$modify_call_times</option></select>$NWB#vicidial_users-modify_call_times$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Delete Orari Chiamata: </td><td align=left><select size=1 name=delete_call_times><option>0</option><option>1</option><option SELECTED>$delete_call_times</option></select>$NWB#vicidial_users-delete_call_times$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Modifica Server: </td><td align=left><select size=1 name=modify_servers><option>0</option><option>1</option><option SELECTED>$modify_servers</option></select>$NWB#vicidial_users-modify_sections$NWE</td></tr>\n";
			echo "<tr bgcolor=#B9CBFD><td align=right>Agent API Access: </td><td align=left><select size=1 name=vdc_agent_api_access><option>0</option><option>1</option><option SELECTED>$vdc_agent_api_access</option></select>$NWB#vicidial_users-vdc_agent_api_access$NWE</td></tr>\n";

			echo "<tr bgcolor=#9BB9FB><td align=right>Add Timeclock Log Record: </td><td align=left><select size=1 name=add_timeclock_log><option>0</option><option>1</option><option SELECTED>$add_timeclock_log</option></select>$NWB#vicidial_users-add_timeclock_log$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>Modify Timeclock Log Record: </td><td align=left><select size=1 name=modify_timeclock_log><option>0</option><option>1</option><option SELECTED>$modify_timeclock_log</option></select>$NWB#vicidial_users-modify_timeclock_log$NWE</td></tr>\n";
			echo "<tr bgcolor=#9BB9FB><td align=right>Delete Timeclock Log Record: </td><td align=left><select size=1 name=delete_timeclock_log><option>0</option><option>1</option><option SELECTED>$delete_timeclock_log</option></select>$NWB#vicidial_users-delete_timeclock_log$NWE</td></tr>\n";
			}
		echo "<tr bgcolor=#B9CBFD><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
		echo "</TABLE></center>\n";

		if ($LOGdelete_users > 0)
			{
			echo "<br><br><a href=\"$PHP_SELF?ADD=5&user=$row[1]\">CANCELLA QUESTO UTENTE</a>\n";
			}
		echo "<br><br><a href=\"./AST_agent_time_sheet.php?agent=$row[1]\">Clicca qui per la tabella degli orari dell`utente</a>\n";
		echo "<br><br><a href=\"./user_status.php?user=$row[1]\">Clicca qui per visualizzare lo stato dell`utente</a>\n";
		echo "<br><br><a href=\"./user_stats.php?user=$row[1]\">Clicca qui per le statistiche dell`utente</a>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=8&user=$row[1]\">Clicca qui per i richiami dell`utente</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=31 modify campaign info in the system - Detail view
######################

if ( ($LOGcampaign_detail < 1) and ($ADD==31) ) {$ADD=34;}	# send to Basic if not allowed

if ( ($ADD==31) and ( (!eregi("$campaign_id",$LOGallowed_campaigns)) and (!eregi("ALL-CAMPAIGNS",$LOGallowed_campaigns)) ) ) 
	{$ADD=30;}	# send to not allowed screen if not in vicidial_user_groups allowed_campaigns list

if ($ADD==31)
{
	if ($LOGmodify_campaigns==1)
	{
		if ($stage=='show_dialable')
		{
			$stmt="UPDATE vicidial_campaigns set display_dialable_count='Y' where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);
		}
		if ($stage=='hide_dialable')
		{
			$stmt="UPDATE vicidial_campaigns set display_dialable_count='N' where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);
		}

		$stmt="SELECT * from vicidial_campaigns where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		$campaign_name = $row[1];
		$dial_status_a = $row[3];
		$dial_status_b = $row[4];
		$dial_status_c = $row[5];
		$dial_status_d = $row[6];
		$dial_status_e = $row[7];
		$lead_order = $row[8];
		$web_form_address = $row[11];
		$allow_closers = $row[12];
		$hopper_level = $row[13];
		$auto_dial_level = $row[14];
		$next_agent_call = $row[15];
		$local_call_time = $row[16];
		$voicemail_ext = $row[17];
		$dial_timeout = $row[18];
		$dial_prefix = $row[19];
		$campaign_cid = $row[20];
		$campaign_vdad_exten = $row[21];
		$campaign_rec_exten = $row[22];
		$campaign_recording = $row[23];
		$campaign_rec_filename = $row[24];
		$script_id = $row[25];
		$get_call_launch = $row[26];
		$am_message_exten = $row[27];
		$amd_send_to_vmx = $row[28];
		$xferconf_a_dtmf = $row[29];
		$xferconf_a_number = $row[30];
		$xferconf_b_dtmf = $row[31];
		$xferconf_b_number = $row[32];
		$alt_number_dialing = $row[33];
		$scheduled_callbacks = $row[34];
		$lead_filter_id = $row[35];
			if ($lead_filter_id=='') {$lead_filter_id='NONE';}
		$drop_call_seconds = $row[36];
		$drop_action = $row[37];
		$safe_harbor_exten = $row[38];
		$display_dialable_count = $row[39];
		$wrapup_seconds = $row[40];
		$wrapup_message = $row[41];
	#	$closer_campaigns = $row[42];
		$use_internal_dnc = $row[43];
		$allcalls_delay = $row[44];
		$omit_phone_code = $row[45];
		$dial_method = $row[46];
		$available_only_ratio_tally = $row[47];
		$adaptive_dropped_percentage = $row[48];
		$adaptive_maximum_level = $row[49];
		$adaptive_latest_server_time = $row[50];
		$adaptive_intensity = $row[51];
		$adaptive_dl_diff_target = $row[52];
		$concurrent_transfers = $row[53];
		$auto_alt_dial = $row[54];
		$auto_alt_dial_statuses = $row[55];
		$agent_pause_codes_active = $row[56];
		$campaign_description = $row[57];
		$campaign_changedate = $row[58];
		$campaign_stats_refresh = $row[59];
		$campaign_logindate = $row[60];
		$dial_statuses = $row[61];
		$disable_alter_custdata = $row[62];
		$no_hopper_leads_logins = $row[63];
		$list_order_mix = $row[64];
		$campaign_allow_inbound = $row[65];
		$manual_dial_list_id = $row[66];
		$default_xfer_group = $row[67];
		$queue_priority = $row[69];
		$drop_inbound_group = $row[70];
		$qc_enabled = $row[71];
		$qc_statuses = $row[72];
		$qc_lists = $row[73];
		$qc_shift_id = $row[74];
		$qc_get_record_launch = $row[75];
		$qc_show_recording = $row[76];
		$qc_web_form_address = $row[77];
		$qc_script = $row[78];
		$survey_first_audio_file = $row[79];
		$survey_dtmf_digits = $row[80];
		$survey_ni_digit = $row[81];
		$survey_opt_in_audio_file = $row[82];
		$survey_ni_audio_file = $row[83];
		$survey_method = $row[84];
		$survey_no_response_action = $row[85];
		$survey_ni_status = $row[86];
		$survey_response_digit_map = $row[87];
		$survey_xfer_exten = $row[88];
		$survey_camp_record_dir = $row[89];
		$disable_alter_custphone = $row[90];
		$display_queue_count = $row[91];
		$manual_dial_filter = $row[92];
		$agent_clipboard_copy = $row[93];
		$agent_extended_alt_dial = $row[94];
		$use_campaign_dnc = $row[95];
		$three_way_call_cid = $row[96];

	if (ereg("DISABLED",$list_order_mix))
		{$DEFlistDISABLE = '';	$DEFstatusDISABLED=0;}
	else
		{$DEFlistDISABLE = 'disabled';	$DEFstatusDISABLED=1;}

	$stmt="SELECT count(*) from vicidial_campaigns_list_mix where campaign_id='$campaign_id' and status='ACTIVE'";
	$rslt=mysql_query($stmt, $link);
	$rowx=mysql_fetch_row($rslt);
	if ($rowx[0] < 1)
		{
		$mixes_list="<option SELECTED value=\"DISABLED\">DISABLED</option>\n";
		$mixname_list["DISABLED"] = "DISABLED";
		}
	else
		{
		##### get list_mix listings for dynamic pulldown
		$stmt="SELECT vcl_id,vcl_name from vicidial_campaigns_list_mix where campaign_id='$campaign_id' and status='ACTIVE' limit 1";
		$rslt=mysql_query($stmt, $link);
		$mixes_to_print = mysql_num_rows($rslt);
		$mixes_list="<option value=\"DISABLED\">DISABLED</option>\n";

		$o=0;
		while ($mixes_to_print > $o)
			{
			$rowx=mysql_fetch_row($rslt);
			$mixes_list .= "<option value=\"ACTIVE\">ACTIVE ($rowx[0] - $rowx[1])</option>\n";
			$mixname_list["ACTIVE"] = "$rowx[0] - $rowx[1]";
			$o++;
			}
		}

	$dial_statuses = preg_replace("/ -$/","",$dial_statuses);
	$Dstatuses = explode(" ", $dial_statuses);
	$Ds_to_print = (count($Dstatuses) -1);

	$qc_statuses = preg_replace("/^ | -$/","",$qc_statuses);
	$QCstatuses = explode(" ", $qc_statuses);
	$QCs_to_print = (count($QCstatuses) -0);

	$qc_lists = preg_replace("/^ | -$/","",$qc_lists);
	$QClists = explode(" ", $qc_lists);
	$QCL_to_print = (count($QClists) -0);

	##### get status listings for dynamic pulldown
	$stmt="SELECT * from vicidial_statuses order by status";
	$rslt=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rslt);
	$statuses_list='';
	$dial_statuses_list='';
	$qc_statuses_list='';
	$survey_ni_status_list='';

	$o=0;
	while ($statuses_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		$statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		if ($rowx[0] != 'CBHOLD') 
			{
			$dial_statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			if ($survey_ni_status == $rowx[0])
				{
				$survey_ni_status_list .= "<option value=\"$rowx[0]\" SELECTED>$rowx[0] - $rowx[1]</option>\n";
				}
			else
				{
				$survey_ni_status_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
				}
			}
		$statname_list["$rowx[0]"] = "$rowx[1]";
		$LRstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";
		if (eregi("Y",$rowx[2]))
			{$HKstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";}

		$qc_statuses_list .= "<input type=\"checkbox\" name=\"qc_statuses[]\" value=\"$rowx[0]\"";
		$p=0;
		while ($p < $QCs_to_print)
			{
			if ($rowx[0] == $QCstatuses[$p]) 
				{
				$qc_statuses_list .= " CHECKED";
				}
			$p++;
			}
		$qc_statuses_list .= "> $rowx[0] - $rowx[1]<BR>\n";

		$o++;
		}

	$stmt="SELECT * from vicidial_campaign_statuses where campaign_id='$campaign_id' order by status";
	$rslt=mysql_query($stmt, $link);
	$Cstatuses_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($Cstatuses_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		$statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		if ($rowx[0] != 'CBHOLD') {$dial_statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";}
		$statname_list["$rowx[0]"] = "$rowx[1]";
		$LRstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";
		if (eregi("Y",$rowx[2]))
			{$HKstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";}

		$qc_statuses_list .= "<input type=\"checkbox\" name=\"qc_statuses[]\" value=\"$rowx[0]\"";
		$p=0;
		while ($p < $QCs_to_print)
			{
			if ($rowx[0] == $QCstatuses[$p]) 
				{
				$qc_statuses_list .= " CHECKED";
				}
			$p++;
			}
		$qc_statuses_list .= "> $rowx[0] - $rowx[1]<BR>\n";

		$o++;
		}

	##### get in-groups listings for dynamic drop in-group pulldown
	$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT') order by group_id";
	$rslt=mysql_query($stmt, $link);
	$Dgroups_to_print = mysql_num_rows($rslt);
	$Dgroups_menu='';
	$Dgroups_selected=0;
	$o=0;
	while ($Dgroups_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		$Dgroups_menu .= "<option ";
		if ($drop_inbound_group == "$rowx[0]") 
			{
			$Dgroups_menu .= "SELECTED ";
			$Dgroups_selected++;
			}
		$Dgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
		}
	if ($Dgroups_selected < 1) 
		{$Dgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
	else 
		{$Dgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}


	##### get in-groups listings for dynamic transfer group pulldown list menu
	$stmt="SELECT group_id,group_name from vicidial_inbound_groups $xfer_groupsSQL order by group_id";
	$rslt=mysql_query($stmt, $link);
	$Xgroups_to_print = mysql_num_rows($rslt);
	$Xgroups_menu='';
	$Xgroups_selected=0;
	$o=0;
	while ($Xgroups_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		$Xgroups_menu .= "<option ";
		if ($default_xfer_group == "$rowx[0]") 
			{
			$Xgroups_menu .= "SELECTED ";
			$Xgroups_selected++;
			}
		$Xgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
		}
	if ($Xgroups_selected < 1) 
		{$Xgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
	else 
		{$Xgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}


	if ($SUB<1)		{$camp_detail_color=$subcamp_color;}
		else		{$camp_detail_color=$campaigns_color;}
	if ($SUB==22)	{$camp_statuses_color=$subcamp_color;}
		else		{$camp_statuses_color=$campaigns_color;}
	if ($SUB==23)	{$camp_hotkeys_color=$subcamp_color;}
		else		{$camp_hotkeys_color=$campaigns_color;}
	if ($SUB==25)	{$camp_recycle_color=$subcamp_color;}
		else		{$camp_recycle_color=$campaigns_color;}
	if ($SUB==26)	{$camp_autoalt_color=$subcamp_color;}
		else		{$camp_autoalt_color=$campaigns_color;}
	if ($SUB==27)	{$camp_pause_color=$subcamp_color;}
		else		{$camp_pause_color=$campaigns_color;}
	if ($SUB==28)	{$camp_qc_color=$subcamp_color;}
		else		{$camp_qc_color=$campaigns_color;}
	if ($SUB==29)	{$camp_listmix_color=$subcamp_color;}
		else		{$camp_listmix_color=$campaigns_color;}
	if ($SUB=='20A')	{$camp_survey_color=$subcamp_color;}
		else		{$camp_survey_color=$campaigns_color;}
	echo "<TABLE WIDTH=$page_width CELLPADDING=2 CELLSPACING=0><TR BGCOLOR=\"$campaigns_color\">\n";
	echo "<TD><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\"> <B>$row[0]</B>: </font></TD>";
	echo "<TD><a href=\"$PHP_SELF?ADD=34&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Basic </font></a></TD>";
	echo "<TD BGCOLOR=\"$camp_detail_color\"> <a href=\"$PHP_SELF?ADD=31&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Dettagliata </font></a> </TD>";
	echo "<TD BGCOLOR=\"$camp_statuses_color\"><a href=\"$PHP_SELF?ADD=31&SUB=22&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Esiti</font></a></TD>";
	echo "<TD BGCOLOR=\"$camp_hotkeys_color\"><a href=\"$PHP_SELF?ADD=31&SUB=23&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Hot-Key</font></a></TD>";
	echo "<TD BGCOLOR=\"$camp_recycle_color\"><a href=\"$PHP_SELF?ADD=31&SUB=25&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Riciclaggio Contatti</font></a></TD>";
	echo "<TD BGCOLOR=\"$camp_autoalt_color\"><a href=\"$PHP_SELF?ADD=31&SUB=26&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Chiama Auto Num Altern</font></a></TD>";
	echo "<TD BGCOLOR=\"$camp_pause_color\"><a href=\"$PHP_SELF?ADD=31&SUB=27&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Codici Pausa</font></a></TD>";
	echo "<TD BGCOLOR=\"$camp_qc_color\"><a href=\"$PHP_SELF?ADD=31&SUB=28&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">QC</font></a></TD>";
	echo "<TD BGCOLOR=\"$camp_listmix_color\"><a href=\"$PHP_SELF?ADD=31&SUB=29&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">List Mix</font></a></TD>";
	echo "<TD BGCOLOR=\"$camp_survey_color\"><a href=\"$PHP_SELF?ADD=31&SUB=20A&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Survey</font></a></TD>";
	echo "<TD> <a href=\"./AST_timeonVDADall.php?RR=4&DB=0&group=$row[0]\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Real-Time</font></a></TD>\n";
	echo "</TR></TABLE>\n";

	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<center>\n";

	if ($SUB < 1)
		{
		echo "<form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=ADD value=41>\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
		echo "<TABLE width=$section_width cellspacing=3>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>ID Campagna: </td><td align=left><b>$row[0]</b>$NWB#vicidial_campaigns-campaign_id$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Nome Campagna: </td><td align=left><input type=text name=campaign_name size=40 maxlength=40 value=\"$campaign_name\">$NWB#vicidial_campaigns-campaign_name$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Descrizione Campagna: </td><td align=left><input type=text name=campaign_description size=40 maxlength=255 value=\"$campaign_description\">$NWB#vicidial_campaigns-campaign_description$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Campagna Change Date: </td><td align=left>$campaign_changedate &nbsp; $NWB#vicidial_campaigns-campaign_changedate$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Campagna Login Date: </td><td align=left>$campaign_logindate &nbsp; $NWB#vicidial_campaigns-campaign_logindate$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option SELECTED>$row[2]</option></select>$NWB#vicidial_campaigns-active$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Extension del parking: </td><td align=left><input type=text name=park_ext size=10 maxlength=10 value=\"$row[9]\"> - Filename: <input type=text name=park_file_name size=10 maxlength=10 value=\"$row[10]\">$NWB#vicidial_campaigns-park_ext$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left><input type=text name=web_form_address size=50 maxlength=255 value=\"$web_form_address\">$NWB#vicidial_campaigns-web_form_address$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Permitir Closers: </td><td align=left><select size=1 name=allow_closers><option>Y</option><option>N</option><option SELECTED>$allow_closers</option></select>$NWB#vicidial_campaigns-allow_closers$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Permita de entrada y mezclado:</td><td align=left><select size=1 name=campaign_allow_inbound><option>Y</option><option>N</option><option SELECTED>$campaign_allow_inbound</option></select>$NWB#vicidial_campaigns-campaign_allow_inbound$NWE</td></tr>\n";

		$o=0;
		while ($Ds_to_print > $o) 
			{
			$o++;
			$Dstatus = $Dstatuses[$o];

			echo "<tr bgcolor=#B6D3FC><td align=right>Esito Chiamata $o: </td><td align=left> \n";

			if ($DEFstatusDISABLED > 0)
				{
				echo "<font color=grey><DEL><b>$Dstatus</b> - $statname_list[$Dstatus] &nbsp; &nbsp; &nbsp; &nbsp; <font size=2>\n";
				echo "REMOVE</DEL></td></tr>\n";
				}
			else
				{
				echo "<b>$Dstatus</b> - $statname_list[$Dstatus] &nbsp; &nbsp; &nbsp; &nbsp; <font size=2>\n";
				echo "<a href=\"$PHP_SELF?ADD=68&campaign_id=$campaign_id&status=$Dstatuses[$o]\">RIMUOVI</a></td></tr>\n";
				}
			}

		echo "<tr bgcolor=#B6D3FC><td align=right>Aggiungi Un Esito Chiamata: </td><td align=left><select size=1 name=dial_status $DEFlistDISABLE>\n";
		echo "<option value=\"\"> - NONE - </option>\n";

		echo "$dial_statuses_list";
		echo "</select> &nbsp; \n";
		echo "<input type=submit name=submit value=ADD> &nbsp; &nbsp; $NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Ordine Lista: </td><td align=left><select size=1 name=lead_order ><option>DOWN</option><option>UP</option><option>DOWN PHONE</option><option>UP PHONE</option><option>DOWN LAST NAME</option><option>UP LAST NAME</option><option>DOWN COUNT</option><option>UP COUNT</option><option>DOWN 2nd NEW</option><option>DOWN 3rd NEW</option><option>DOWN 4th NEW</option><option>DOWN 5th NEW</option><option>DOWN 6th NEW</option><option>UP 2nd NEW</option><option>UP 3rd NEW</option><option>UP 4th NEW</option><option>UP 5th NEW</option><option>UP 6th NEW</option><option>DOWN PHONE 2nd NEW</option><option>DOWN PHONE 3rd NEW</option><option>DOWN PHONE 4th NEW</option><option>DOWN PHONE 5th NEW</option><option>DOWN PHONE 6th NEW</option><option>UP PHONE 2nd NEW</option><option>UP PHONE 3rd NEW</option><option>UP PHONE 4th NEW</option><option>UP PHONE 5th NEW</option><option>UP PHONE 6th NEW</option><option>DOWN LAST NAME 2nd NEW</option><option>DOWN LAST NAME 3rd NEW</option><option>DOWN LAST NAME 4th NEW</option><option>DOWN LAST NAME 5th NEW</option><option>DOWN LAST NAME 6th NEW</option><option>UP LAST NAME 2nd NEW</option><option>UP LAST NAME 3rd NEW</option><option>UP LAST NAME 4th NEW</option><option>UP LAST NAME 5th NEW</option><option>UP LAST NAME 6th NEW</option><option>DOWN COUNT 2nd NEW</option><option>DOWN COUNT 3rd NEW</option><option>DOWN COUNT 4th NEW</option><option>DOWN COUNT 5th NEW</option><option>DOWN COUNT 6th NEW</option><option>UP COUNT 2nd NEW</option><option>UP COUNT 3rd NEW</option><option>UP COUNT 4th NEW</option><option>UP COUNT 5th NEW</option><option>UP COUNT 6th NEW</option><option SELECTED>$lead_order</option></select>$NWB#vicidial_campaigns-lead_order$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=31&SUB=29&campaign_id=$campaign_id&vcl_id=$list_order_mix\">List Mix</a>: </td><td align=left><select size=1 name=list_order_mix>\n";
		echo "$mixes_list";
		if (ereg("DISABLED",$list_order_mix))
			{echo "<option selected value=\"$list_order_mix\">$list_order_mix - $mixname_list[$list_order_mix]</option>\n";}
		else
			{echo "<option selected value=\"ACTIVE\">ACTIVE ($mixname_list[ACTIVE])</option>\n";}
		echo "</select>$NWB#vicidial_campaigns-list_order_mix$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=31111111&lead_filter_id=$lead_filter_id\">Filtro Contatti</a>: </td><td align=left><select size=1 name=lead_filter_id>\n";
		echo "$filters_list";
		echo "<option selected value=\"$lead_filter_id\">$lead_filter_id - $filtername_list[$lead_filter_id]</option>\n";
		echo "</select>$NWB#vicidial_campaigns-lead_filter_id$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Livello Coda Chiamate: </td><td align=left><select size=1 name=hopper_level><option>1</option><option>5</option><option>10</option><option>20</option><option>50</option><option>100</option><option>200</option><option>500</option><option>700</option><option>1000</option><option>2000</option><option SELECTED>$hopper_level</option></select>$NWB#vicidial_campaigns-hopper_level$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Forza Il Reset Della Coda Chiamate: </td><td align=left><select size=1 name=reset_hopper><option>Y</option><option SELECTED>N</option></select>$NWB#vicidial_campaigns-force_reset_hopper$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Metodo Chiamata: </td><td align=left><select size=1 name=dial_method><option >MANUAL</option><option>RATIO</option><option>ADAPT_HARD_LIMIT</option><option>ADAPT_TAPERED</option><option>ADAPT_AVERAGE</option><option>INBOUND_MAN</option><option SELECTED>$dial_method</option></select>$NWB#vicidial_campaigns-dial_method$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Livello Auto Dial: </td><td align=left><select size=1 name=auto_dial_level><option >0</option><option>1</option><option>1.1</option><option>1.2</option><option>1.3</option><option>1.4</option><option>1.5</option><option>1.6</option><option>1.7</option><option>1.8</option><option>1.9</option><option>2.0</option><option>2.2</option><option>2.5</option><option>2.7</option><option>3.0</option><option>3.5</option><option>4.0</option><option SELECTED>$auto_dial_level</option></select>(0 = off)$NWB#vicidial_campaigns-auto_dial_level$NWE &nbsp; &nbsp; &nbsp; <input type=checkbox name=dial_level_override value=\"1\">FORZA LIVELLO ANCHE CON MODALITA` ADAPT</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Conta Solo Disponibili: </td><td align=left><select size=1 name=available_only_ratio_tally><option >Y</option><option>N</option><option SELECTED>$available_only_ratio_tally</option></select>$NWB#vicidial_campaigns-available_only_ratio_tally$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Limita Percentuale Abbattuti: </td><td align=left><select size=1 name=adaptive_dropped_percentage>\n";
		$n=100;
		while ($n>=1)
			{
			echo "<option>$n</option>\n";
			$n--;
			}
		echo "<option SELECTED>$adaptive_dropped_percentage</option></select>% $NWB#vicidial_campaigns-adaptive_dropped_percentage$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Livello Auto-Dial Massimo In Modalita` Adapt: </td><td align=left><input type=text name=adaptive_maximum_level size=6 maxlength=6 value=\"$adaptive_maximum_level\"><i>number only</i> $NWB#vicidial_campaigns-adaptive_maximum_level$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Ultimo Orario Chiamate: </td><td align=left><input type=text name=adaptive_latest_server_time size=6 maxlength=4 value=\"$adaptive_latest_server_time\"><i>4 solo cifre</i> $NWB#vicidial_campaigns-adaptive_latest_server_time$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Modifica Intensita` Adapt Auto-Dial: </td><td align=left><select size=1 name=adaptive_intensity>\n";
		$n=40;
		while ($n>=-40)
			{
			$dtl = 'Balanced';
			if ($n<0) {$dtl = 'Less Intense';}
			if ($n>0) {$dtl = 'More Intense';}
			if ($n == $adaptive_intensity) 
				{echo "<option SELECTED value=\"$n\">$n - $dtl</option>\n";}
			else
				{echo "<option value=\"$n\">$n - $dtl</option>\n";}
			$n--;
			}
		echo "</select> $NWB#vicidial_campaigns-adaptive_intensity$NWE</td></tr>\n";



		echo "<tr bgcolor=#BDFFBD><td align=right>Blanco Llana De la Diferencia Del Dial: </td><td align=left><select size=1 name=adaptive_dl_diff_target>\n";
		$n=40;
		while ($n>=-40)
			{
			$nabs = abs($n);
			$dtl = 'Balanced';
			if ($n<0) {$dtl = 'Agents Waiting for Calls';}
			if ($n>0) {$dtl = 'Calls Waiting for Agents';}
			if ($n == $adaptive_dl_diff_target) 
				{echo "<option SELECTED value=\"$n\">$n --- $nabs $dtl</option>\n";}
			else
				{echo "<option value=\"$n\">$n --- $nabs $dtl</option>\n";}
			$n--;
			}
		echo "</select> $NWB#vicidial_campaigns-adaptive_dl_diff_target$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Transferencias Concurrentes: </td><td align=left><select size=1 name=concurrent_transfers><option >AUTO</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10<option SELECTED>$concurrent_transfers</option></select>$NWB#vicidial_campaigns-concurrent_transfers$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Queue Priority: </td><td align=left><select size=1 name=queue_priority>\n";
		$n=99;
		while ($n>=-99)
			{
			$dtl = 'Even';
			if ($n<0) {$dtl = 'Lower';}
			if ($n>0) {$dtl = 'Higher';}
			if ($n == $queue_priority) 
				{echo "<option SELECTED value=\"$n\">$n - $dtl</option>\n";}
			else
				{echo "<option value=\"$n\">$n - $dtl</option>\n";}
			$n--;
			}
		echo "</select> $NWB#vicidial_campaigns-queue_priority$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>El Marcar Auto Del Alt-Nu`mero: </td><td align=left><select size=1 name=auto_alt_dial><option >NESSUNO</option><option>ALT_ONLY</option><option>ADDR3_ONLY</option><option>ALT_AND_ADDR3</option><option>ALT_AND_EXTENDED</option><option>ALT_AND_ADDR3_AND_EXTENDED</option><option>EXTENDED_ONLY</option><option SELECTED>$auto_alt_dial</option></select>$NWB#vicidial_campaigns-auto_alt_dial$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Operatore Da Scegliere Per La Chiamata Successiva: </td><td align=left><select size=1 name=next_agent_call><option >random</option><option>oldest_call_start</option><option>oldest_call_finish</option><option>overall_user_level</option><option>campaign_rank</option><option>fewest_calls</option><option SELECTED>$next_agent_call</option></select>$NWB#vicidial_campaigns-next_agent_call$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=311111111&call_time_id=$local_call_time\">Orario Chiamate: </a></td><td align=left><select size=1 name=local_call_time>\n";
		echo "$call_times_list";
		echo "<option selected value=\"$local_call_time\">$local_call_time - $call_timename_list[$local_call_time]</option>\n";
		echo "</select>$NWB#vicidial_campaigns-local_call_time$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Timeout Chiamata: </td><td align=left><input type=text name=dial_timeout size=3 maxlength=3 value=\"$dial_timeout\"> <i>in seconds</i>$NWB#vicidial_campaigns-dial_timeout$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Prefisso Chiamata: </td><td align=left><input type=text name=dial_prefix size=20 maxlength=20 value=\"$dial_prefix\"> <font size=1>for 91NXXNXXXXXX value would be 9, for no dial prefix use X</font>$NWB#vicidial_campaigns-dial_prefix$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Ometti Prefisso Telefono: </td><td align=left><select size=1 name=omit_phone_code><option>Y</option><option>N</option><option SELECTED>$omit_phone_code</option></select>$NWB#vicidial_campaigns-omit_phone_code$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>CallerID della Campagna: </td><td align=left><input type=text name=campaign_cid size=20 maxlength=20 value=\"$campaign_cid\">$NWB#vicidial_campaigns-campaign_cid$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Exten VDAD de La campaña: </td><td align=left><input type=text name=campaign_vdad_exten size=10 maxlength=20 value=\"$campaign_vdad_exten\">$NWB#vicidial_campaigns-campaign_vdad_exten$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Interno Registrazioni Per Questa Campagna: </td><td align=left><input type=text name=campaign_rec_exten size=10 maxlength=10 value=\"$campaign_rec_exten\">$NWB#vicidial_campaigns-campaign_rec_exten$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Registrazioni Per Questa Campagna: </td><td align=left><select size=1 name=campaign_recording><option>NEVER</option><option>ONDEMAND</option><option>ALLCALLS</option><option>ALLFORCE</option><option SELECTED>$campaign_recording</option></select>$NWB#vicidial_campaigns-campaign_recording$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Nome Registrazioni Per Questa Campagna: </td><td align=left><input type=text name=campaign_rec_filename size=50 maxlength=50 value=\"$campaign_rec_filename\">$NWB#vicidial_campaigns-campaign_rec_filename$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Ritardo Registrazione: </td><td align=left><input type=text name=allcalls_delay size=3 maxlength=3 value=\"$allcalls_delay\"> <i>in seconds</i>$NWB#vicidial_campaigns-allcalls_delay$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=3111111&script_id=$script_id\">Script</a>: </td><td align=left><select size=1 name=script_id>\n";
		echo "$scripts_list";
		echo "<option selected value=\"$script_id\">$script_id - $scriptname_list[$script_id]</option>\n";
		echo "</select>$NWB#vicidial_campaigns-campaign_script$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Esegui all`avvio della telefonata: </td><td align=left><select size=1 name=get_call_launch><option selected>NESSUNO</option><option>SCRIPT</option><option>WEBFORM</option><option selected>$get_call_launch</option></select>$NWB#vicidial_campaigns-get_call_launch$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Messaggio Segreteria Telefonica: </td><td align=left><input type=text name=am_message_exten size=10 maxlength=20 value=\"$am_message_exten\">$NWB#vicidial_campaigns-am_message_exten$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>AMD envían a la VM exten: </td><td align=left><select size=1 name=amd_send_to_vmx><option>Y</option><option>N</option><option SELECTED>$amd_send_to_vmx</option></select>$NWB#vicidial_campaigns-amd_send_to_vmx$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Transfiera -Conf DTMF 1: </td><td align=left><input type=text name=xferconf_a_dtmf size=20 maxlength=50 value=\"$xferconf_a_dtmf\">$NWB#vicidial_campaigns-xferconf_a_dtmf$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Transfiera -Conf El Número 1: </td><td align=left><input type=text name=xferconf_a_number size=20 maxlength=50 value=\"$xferconf_a_number\">$NWB#vicidial_campaigns-xferconf_a_dtmf$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Transfiera -Conf DTMF 2: </td><td align=left><input type=text name=xferconf_b_dtmf size=20 maxlength=50 value=\"$xferconf_b_dtmf\">$NWB#vicidial_campaigns-xferconf_a_dtmf$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Transfiera -Conf El Número 2: </td><td align=left><input type=text name=xferconf_b_number size=20 maxlength=50 value=\"$xferconf_b_number\">$NWB#vicidial_campaigns-xferconf_a_dtmf$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>El Marcar Del Número Del Alt: </td><td align=left><select size=1 name=alt_number_dialing><option>Y</option><option>N</option><option SELECTED>$alt_number_dialing</option></select>$NWB#vicidial_campaigns-alt_number_dialing$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Servicios repetidos Programar: </td><td align=left><select size=1 name=scheduled_callbacks><option>Y</option><option>N</option><option SELECTED>$scheduled_callbacks</option></select>$NWB#vicidial_campaigns-scheduled_callbacks$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Secondi Abbattimento Telefonata: </td><td align=left><input type=text name=drop_call_seconds size=5 maxlength=2 value=\"$drop_call_seconds\">$NWB#vicidial_campaigns-drop_call_seconds$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Drop Action: </td><td align=left><select size=1 name=drop_action><option>HANGUP</option><option>MESSAGE</option><option>VOICEMAIL</option><option>IN_GROUP</option><option SELECTED>$drop_action</option></select>$NWB#vicidial_campaigns-drop_action$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Interno Messaggio Telefonata Abbattuta: </td><td align=left><input type=text name=safe_harbor_exten size=10 maxlength=20 value=\"$safe_harbor_exten\">$NWB#vicidial_campaigns-safe_harbor_exten$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Casella Vocale: </td><td align=left><input type=text name=voicemail_ext size=10 maxlength=10 value=\"$voicemail_ext\">$NWB#vicidial_campaigns-voicemail_ext$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Drop Transfer Gruppo: </td><td align=left><select size=1 name=drop_inbound_group>";
		echo "$Dgroups_menu";
		echo "</select>$NWB#vicidial_campaigns-drop_inbound_group$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Secondi Riposo Operatore: </td><td align=left><input type=text name=wrapup_seconds size=5 maxlength=3 value=\"$wrapup_seconds\">$NWB#vicidial_campaigns-wrapup_seconds$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Messaggio Riposo Operatore: </td><td align=left><input type=text name=wrapup_message size=40 maxlength=255 value=\"$wrapup_message\">$NWB#vicidial_campaigns-wrapup_message$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Controlla In Lista Contatti Da NON CHIAMARE: </td><td align=left><select size=1 name=use_internal_dnc><option>Y</option><option>N</option><option SELECTED>$use_internal_dnc</option></select>$NWB#vicidial_campaigns-use_internal_dnc$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Use Campagna DNC List: </td><td align=left><select size=1 name=use_campaign_dnc><option>Y</option><option>N</option><option SELECTED>$use_campaign_dnc</option></select>$NWB#vicidial_campaigns-use_campaign_dnc$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>AgentCodici PausaAttivo: </td><td align=left><select size=1 name=agent_pause_codes_active><option>Y</option><option>N</option><option SELECTED>$agent_pause_codes_active</option></select>$NWB#vicidial_campaigns-agent_pause_codes_active$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Aggiornamento Statistiche Campagna: </td><td align=left><select size=1 name=campaign_stats_refresh><option>Y</option><option>N</option><option SELECTED>$campaign_stats_refresh</option></select>$NWB#vicidial_campaigns-campaign_stats_refresh$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Disabilita modifica dati clienti: </td><td align=left><select size=1 name=disable_alter_custdata><option>Y</option><option>N</option><option SELECTED>$disable_alter_custdata</option></select>$NWB#vicidial_campaigns-disable_alter_custdata$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Disable Alter Customer Phone: </td><td align=left><select size=1 name=disable_alter_custphone><option>Y</option><option>N</option><option SELECTED>$disable_alter_custphone</option></select>$NWB#vicidial_campaigns-disable_alter_custphone$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Abilita Login Senza Contatti Da Chiamare: </td><td align=left><select size=1 name=no_hopper_leads_logins><option>Y</option><option>N</option><option SELECTED>$no_hopper_leads_logins</option></select>$NWB#vicidial_campaigns-no_hopper_leads_logins$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Agent Display Queue Count: </td><td align=left><select size=1 name=display_queue_count><option>Y</option><option>N</option><option SELECTED>$display_queue_count</option></select>$NWB#vicidial_campaigns-display_queue_count$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>ID Lista Chiamate Manuali:</td><td align=left><input type=text name=manual_dial_list_id size=15 maxlength=12 value=\"$manual_dial_list_id\">$NWB#vicidial_campaigns-manual_dial_list_id$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Manual Dial Filter: </td><td align=left><select size=1 name=manual_dial_filter><option>NESSUNO</option><option>DNC_ONLY</option><option>CAMPLISTE_ONLY</option><option>DNC_AND_CAMPLISTE</option><option SELECTED>$manual_dial_filter</option></select>$NWB#vicidial_campaigns-manual_dial_filter$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Agent Screen Clipboard Copy: </td><td align=left><select size=1 name=agent_clipboard_copy><option>NESSUNO</option><option>lead_id</option><option>list_id</option><option>title</option><option>first_name</option><option>middle_initial</option><option>last_name</option><option>phone_code</option><option>phone_number</option><option>address1</option><option>address2</option><option>address3</option><option>city</option><option>state</option><option>province</option><option>postal_code</option><option>country_code</option><option>alt_phone</option><option>comments</option><option>date_of_birth</option><option>email</option><option>gender</option><option>gmt_offset_now</option><option>security_phrase</option><option>vendor_lead_code</option><option SELECTED>$agent_clipboard_copy</option></select>$NWB#vicidial_campaigns-agent_clipboard_copy$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Agent Screen Extended Alt Dial: </td><td align=left><select size=1 name=agent_extended_alt_dial><option>Y</option><option>N</option><option SELECTED>$agent_extended_alt_dial</option></select>$NWB#vicidial_campaigns-agent_extended_alt_dial$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>3-Way Call CallerID De salida: </td><td align=left><select size=1 name=three_way_call_cid><option>CAMPAGNA</option><option>CUSTOMER</option><option>AGENT_PHONE</option><option SELECTED>$three_way_call_cid</option></select>$NWB#vicidial_campaigns-three_way_call_cid$NWE</td></tr>\n";

		if ($campaign_allow_inbound == 'Y')
			{
			echo "<tr bgcolor=#B6D3FC><td align=right>Grupos De entrada Permitidos: <BR>";
			echo " $NWB#vicidial_campaigns-closer_campaigns$NWE</td><td align=left>\n";
			echo "$groups_list";
			echo "</td></tr>\n";
			}

		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo De la Transferencia Del Defecto:</td><td align=left><select size=1 name=default_xfer_group>";
		echo "$Xgroups_menu";
		echo "</select>$NWB#vicidial_campaigns-default_xfer_group$NWE</td></tr>\n";

		if ($allow_closers == 'Y')
			{
			echo "<tr bgcolor=#B6D3FC><td align=right>Grupos Permitidos De la Transferencia:<BR>";
			echo " $NWB#vicidial_campaigns-xfer_groups$NWE</td><td align=left>\n";
			echo "$XFERgroups_list";
			echo "</td></tr>\n";
			}

		echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
		echo "</TABLE></center></FORM>\n";

	echo "<center>\n";
	echo "<br><b>LISTE IN QUESTA CAMPAGNA: &nbsp; $NWB#vicidial_campaign_lists$NWE</b><br>\n";
	echo "<TABLE width=400 cellspacing=3>\n";
	echo "<tr><td>ID LISTA</td><td>NOME LISTA</td><td>ATTIVO</td></tr>\n";

		$active_lists = 0;
		$inactive_lists = 0;
		$stmt="SELECT list_id,active,list_name from vicidial_lists where campaign_id='$campaign_id'";
		$rslt=mysql_query($stmt, $link);
		$lists_to_print = mysql_num_rows($rslt);
		$camp_lists='';

		$o=0;
		while ($lists_to_print > $o) 
			{
				$rowx=mysql_fetch_row($rslt);
				$o++;
			if (ereg("Y", $rowx[1])) {$active_lists++;   $camp_lists .= "'$rowx[0]',";}
			if (ereg("N", $rowx[1])) {$inactive_lists++;}

			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}

			echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=311&list_id=$rowx[0]\">$rowx[0]</a></td><td><font size=1>$rowx[2]</td><td><font size=1>$rowx[1]</td></tr>\n";
			}
		echo "</table></center><br>\n";
		echo "<center><b>\n";

		$filterSQL = $filtersql_list[$lead_filter_id];
		$filterSQL = eregi_replace("^and|and$|^or|or$","",$filterSQL);
		if (strlen($filterSQL)>4)
			{$fSQL = "and $filterSQL";}
		else
			{$fSQL = '';}

			$camp_lists = eregi_replace(".$","",$camp_lists);
		echo "Questa campagna ha $active_lists liste attive e $inactive_lists lista inattive<br><br>\n";

		if ($display_dialable_count == 'Y')
			{
			### call function to calculate and print dialable leads
			dialable_leads($DB,$link,$local_call_time,$dial_statuses,$camp_lists,$fSQL);
			echo " - <font size=1><a href=\"$PHP_SELF?ADD=31&campaign_id=$campaign_id&stage=hide_dialable\">NASCONDI</a></font><BR><BR>";
			}
		else
			{
			echo "<a href=\"$PHP_SELF?ADD=73&campaign_id=$campaign_id\" target=\"_blank\">Popup Dialable Leads Count</a>";
			echo " - <font size=1><a href=\"$PHP_SELF?ADD=31&campaign_id=$campaign_id&stage=show_dialable\">MOSTRA</a></font><BR><BR>";
			}





			$stmt="SELECT count(*) FROM vicidial_hopper where campaign_id='$campaign_id' and status IN('READY')";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_query($stmt, $link);
			$rowx=mysql_fetch_row($rslt);
			$hopper_leads = "$rowx[0]";

		echo "Questa campagna ha $hopper_leads contatti nella coda chiamate<br><br>\n";
		echo "<a href=\"./AST_VICIDIAL_hopperlist.php?group=$campaign_id\">Clicca qui per vedere quali numeri sono nella coda chiamate in questo momento</a><br><br>\n";
		echo "<a href=\"$PHP_SELF?ADD=81&campaign_id=$campaign_id\">Clicca qui per visualizzare tutti i richiami in attesa per questa campagna</a><BR><BR>\n";
		echo "<a href=\"./AST_VDADstats.php?group=$campaign_id\">Clicca qui per vedere il report VDAD per questa campagna</a><BR><BR>\n";
		echo "</b></center>\n";
		}


	##### CAMPAIGN CUSTOM STATUSES #####
	if ($SUB==22)
		{

	##### get status category listings for dynamic pulldown
	$stmt="SELECT vsc_id,vsc_name from vicidial_status_categories order by vsc_id desc";
	$rslt=mysql_query($stmt, $link);
	$cats_to_print = mysql_num_rows($rslt);
	$cats_list="";

	$o=0;
	while ($cats_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$cats_list .= "<option value=\"$rowx[0]\">$rowx[0] - " . substr($rowx[1],0,20) . "</option>\n";
		$catsname_list["$rowx[0]"] = substr($rowx[1],0,20);
		$o++;
		}


		echo "<center>\n";
		echo "<br><b>ESITI PERSONALIZZATI PER QUESTA CAMPAGNA: &nbsp; $NWB#vicidial_campaign_statuses$NWE</b><br>\n";
		echo "<TABLE width=500 cellspacing=3>\n";
		echo "<tr><td>ESITO</td><td>DESCRIZIONE</td><td>SELEZIONABILE</td><td>RISPOSTA UMANA</td><td>CANCELLA</td></tr>\n";

		$stmt="SELECT * from vicidial_campaign_statuses where campaign_id='$campaign_id'";
		$rslt=mysql_query($stmt, $link);
		$statuses_to_print = mysql_num_rows($rslt);
		$o=0;
		while ($statuses_to_print > $o) 
			{
			$rowx=mysql_fetch_row($rslt);
			$AScategory = $rowx[5];
			$o++;

			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}

			echo "<tr $bgcolor><td><form action=$PHP_SELF method=POST>\n";
			echo "<input type=hidden name=ADD value=42>\n";
			echo "<input type=hidden name=stage value=modify>\n";
			echo "<input type=hidden name=status value=\"$rowx[0]\">\n";
			echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
			echo "<font size=2><B>$rowx[0]</B></td>\n";
			echo "<td><input type=text name=status_name size=20 maxlength=30 value=\"$rowx[1]\"></td>\n";
			echo "<td><select size=1 name=selectable><option>Y</option><option>N</option><option selected>$rowx[2]</option></select></td>\n";
			echo "<td><select size=1 name=human_answered><option>Y</option><option>N</option><option selected>$rowx[4]</option></select></td>\n";
			echo "<td>\n";
			echo "<select size=1 name=category>\n";
			echo "$cats_list";
			echo "<option selected value=\"$AScategory\">$AScategory - $catsname_list[$AScategory]</option>\n";
			echo "</select>\n";
			echo "</td>\n";
			echo "<td align=center nowrap><font size=1><input type=submit name=submit value=MODIFY> &nbsp; &nbsp; &nbsp; &nbsp; \n";
			echo " &nbsp; \n";
			echo "<a href=\"$PHP_SELF?ADD=42&campaign_id=$campaign_id&status=$rowx[0]&stage=delete\">CANCELLA</a>\n";
			echo "</form></td></tr>\n";
			}

		echo "</table>\n";

		echo "<br>AGGIUNGI NUOVO ESITO PERSONALIZZATO PER CAMPAGNA<BR><form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=ADD value=22>\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
		echo "Esito: <input type=text name=status size=10 maxlength=8> &nbsp; \n";
		echo "Descrizione: <input type=text name=status_name size=20 maxlength=30> &nbsp; \n";
		echo "Selezionabile: <select size=1 name=selectable><option>Y</option><option>N</option></select> &nbsp; \n";
		echo "Risposta Umana: <select size=1 name=human_answered><option>Y</option><option>N</option></select> &nbsp; \n";
		echo "Categoria: \n";
		echo "<select size=1 name=category>\n";
		echo "$cats_list";
		echo "<option selected value=\"$AScategory\">$AScategory - $catsname_list[$AScategory]</option>\n";
		echo "</select> &nbsp; <BR>\n";
		echo "<input type=submit name=submit value=ADD><BR>\n";

		echo "</FORM><br>\n";
		}

	##### CAMPAIGN HOTKEYS #####
	if ($SUB==23)
		{
		echo "<br><b>HOT KEY PERSONALIZZATE PER QUESTA CAMPAGNA: &nbsp; $NWB#vicidial_campaign_hotkeys$NWE</b><br>\n";
		echo "<TABLE width=400 cellspacing=3>\n";
		echo "<tr><td>HOT KEY</td><td>ESITO</td><td>DESCRIZIONE</td><td>CANCELLA</td></tr>\n";

			$stmt="SELECT * from vicidial_campaign_hotkeys where campaign_id='$campaign_id' order by hotkey";
			$rslt=mysql_query($stmt, $link);
			$statuses_to_print = mysql_num_rows($rslt);
			$o=0;
			while ($statuses_to_print > $o) {
				$rowx=mysql_fetch_row($rslt);
				$o++;

			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}

			echo "<tr $bgcolor><td><font size=1>$rowx[1]</td><td><font size=1>$rowx[0]</td><td><font size=1>$rowx[2]</td><td><font size=1><a href=\"$PHP_SELF?ADD=43&campaign_id=$campaign_id&status=$rowx[0]&hotkey=$rowx[1]&action=DELETE\">CANCELLA</a></td></tr>\n";

			}

		echo "</table>\n";

		echo "<br>AGGIUNGI NUOVA HOT KEY PERSONALIZZATA PER QUESTA CAMPAGNA<BR><form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=ADD value=23>\n";
		echo "<input type=hidden name=selectable value=Y>\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
		echo "Hotkey: <select size=1 name=hotkey>\n";
		echo "<option>1</option>\n";
		echo "<option>2</option>\n";
		echo "<option>3</option>\n";
		echo "<option>4</option>\n";
		echo "<option>5</option>\n";
		echo "<option>6</option>\n";
		echo "<option>7</option>\n";
		echo "<option>8</option>\n";
		echo "<option>9</option>\n";
		echo "</select> &nbsp; \n";
		echo "Esito: <select size=1 name=HKstatus>\n";
		echo "$HKstatuses_list\n";
		echo "<option value=\"ALTPH2-----Alternate Phone Hot Dial\">ALTPH2 - Alternate Phone Hot Dial</option>\n";
		echo "<option value=\"ADDR3-----Address3 Hot Dial\">ADDR3 - Address3 Hot Dial</option>\n";
		echo "</select> &nbsp; \n";
		echo "<input type=submit name=submit value=ADD><BR>\n";
		echo "</form><BR>\n";
		}

	##### CAMPAIGN LEAD RECYCLING #####
	if ($SUB==25)
		{
		### display counts on leads that have hit the limit in this campaign
		$stmt="SELECT list_id,active,list_name from vicidial_lists where campaign_id='$campaign_id'";
		$rslt=mysql_query($stmt, $link);
		$lists_to_print = mysql_num_rows($rslt);
		$camp_lists='';
		$o=0;
		while ($lists_to_print > $o) 
			{
			$rowx=mysql_fetch_row($rslt);
			if (ereg("Y", $rowx[1])) {$camp_lists .= "'$rowx[0]',";}
			$o++;
			}
		$camp_lists = eregi_replace(".$","",$camp_lists);

		$stmt="SELECT * from vicidial_lead_recycle where campaign_id='$campaign_id' order by status";
		$rslt=mysql_query($stmt, $link);
		$recycle_to_print = mysql_num_rows($rslt);
		$o=0;
		while ($recycle_to_print > $o) 
			{
			$rowx=mysql_fetch_row($rslt);
			$RECYCLE_status[$o] =	$rowx[2];
			$RECYCLE_delay[$o] =	$rowx[3];
			$RECYCLE_attempt[$o] =	$rowx[4];
			$RECYCLE_active[$o] =	$rowx[5];
			$RECYCLE_count[$o] = "'Y','Y1','Y2','Y3','Y4','Y5','Y6','Y7','Y8','Y9','Y10'";
			if ($RECYCLE_attempt[$o]==1) {$RECYCLE_count[$o] = "'Y1','Y2','Y3','Y4','Y5','Y6','Y7','Y8','Y9','Y10'";}
			if ($RECYCLE_attempt[$o]==2) {$RECYCLE_count[$o] = "'Y2','Y3','Y4','Y5','Y6','Y7','Y8','Y9','Y10'";}
			if ($RECYCLE_attempt[$o]==3) {$RECYCLE_count[$o] = "'Y3','Y4','Y5','Y6','Y7','Y8','Y9','Y10'";}
			if ($RECYCLE_attempt[$o]==4) {$RECYCLE_count[$o] = "'Y4','Y5','Y6','Y7','Y8','Y9','Y10'";}
			if ($RECYCLE_attempt[$o]==5) {$RECYCLE_count[$o] = "'Y5','Y6','Y7','Y8','Y9','Y10'";}
			if ($RECYCLE_attempt[$o]==6) {$RECYCLE_count[$o] = "'Y6','Y7','Y8','Y9','Y10'";}
			if ($RECYCLE_attempt[$o]==7) {$RECYCLE_count[$o] = "'Y7','Y8','Y9','Y10'";}
			if ($RECYCLE_attempt[$o]==8) {$RECYCLE_count[$o] = "'Y8','Y9','Y10'";}
			if ($RECYCLE_attempt[$o]==9) {$RECYCLE_count[$o] = "'Y9','Y10'";}
			if ($RECYCLE_attempt[$o]>9) {$RECYCLE_count[$o] = "'Y10'";}
			$o++;
			}
		$o=0;

		echo "<br><br><b>CONTATTI DA RICICLARE IN QUESTA CAMPAGNA: &nbsp; $NWB#vicidial_lead_recycle$NWE</b><br>\n";
		echo "<TABLE width=700 cellspacing=3>\n";
		echo "<tr><td>ESITO</td><td>RITARDO NUOVO TENTATIVO</td><td>MASSIMO TENTATIVI</td><td>LEADS AT LIMIT</td><td>ATTIVO</td><td> </td><td>CANCELLA</td></tr>\n";

		while ($recycle_to_print > $o) 
			{
			$recycle_limit=0;
			if (strlen($camp_lists) > 2)
				{
				$stmt="SELECT count(*) from vicidial_list where status='$RECYCLE_status[$o]' and list_id IN($camp_lists) and called_since_last_reset IN($RECYCLE_count[$o]);";
				if ($DB) {echo "|$stmt|\n";}
				$rslt=mysql_query($stmt, $link);
				$counts_to_print = mysql_num_rows($rslt);
				if ($counts_to_print > 0) 
					{
					$rowx=mysql_fetch_row($rslt);
					$recycle_limit = $rowx[0];
					}
				}

			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}

			echo "<tr $bgcolor><td><font size=2> &nbsp; $RECYCLE_status[$o]<form action=$PHP_SELF method=POST>\n";
			echo "<input type=hidden name=status value=\"$RECYCLE_status[$o]\">\n";
			echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
			echo "<input type=hidden name=ADD value=45></td>\n";
			echo "<td><font size=1><input type=text size=7 maxlength=5 name=attempt_delay value=\"$RECYCLE_delay[$o]\"></td>\n";
			echo "<td><font size=1><input type=text size=5 maxlength=3 name=attempt_maximum value=\"$RECYCLE_attempt[$o]\"></td>\n";
			echo "<td align=right><font size=2>$recycle_limit &nbsp; </td>\n";
			echo "<td><select size=1 name=active><option>Y</option><option>N</option><option SELECTED>$RECYCLE_active[$o]</option></select></td>\n";
			echo "<td><font size=1><input type=submit name=submit value=MODIFY></form></td>\n";
			echo "<td><font size=1><a href=\"$PHP_SELF?ADD=65&campaign_id=$campaign_id&status=$RECYCLE_status[$o]\">CANCELLA</a></td></tr>\n";
			$o++;
			}

		echo "</table>\n";

		echo "<br>AGGIUNGI NUOVO ESITO DA RICICLARE<BR><form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=ADD value=25>\n";
		echo "<input type=hidden name=active value=\"N\">\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
		echo "Esito: <select size=1 name=status>\n";
		echo "$LRstatuses_list\n";
		echo "</select> &nbsp; \n";
		echo "Intervallo Tra Tentativi: <input type=text size=7 maxlength=5 name=attempt_delay>\n";
		echo "Massimo Tentativi: <input type=text size=5 maxlength=3 name=attempt_maximum>\n";
		echo "<input type=submit name=submit value=ADD><BR>\n";

		echo "</FORM><br>\n";
		echo "<br>\n";
		echo "* Lead counts taken from active lists in the campaign only.\n";
		}

	##### CAMPAIGN AUTO-ALT-NUMBER DIALING #####
	if ($SUB==26)
		{
		echo "<br><br><b>ESITI PER I QUALI CHIAMARE I NUMERI ALTERNATIVI: &nbsp; $NWB#vicidial_auto_alt_dial_statuses$NWE</b><br>\n";
		echo "<TABLE width=500 cellspacing=3>\n";
		echo "<tr><td>ESITI</td><td>CANCELLA</td></tr>\n";

		$auto_alt_dial_statuses = preg_replace("/ -$/","",$auto_alt_dial_statuses);
		$AADstatuses = explode(" ", $auto_alt_dial_statuses);
		$AADs_to_print = (count($AADstatuses) -1);

		$o=0;
		while ($AADs_to_print > $o) 
			{
			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}
			$o++;

			echo "<tr $bgcolor><td><font size=1>$AADstatuses[$o]</td>\n";
			echo "<td><font size=1><a href=\"$PHP_SELF?ADD=66&campaign_id=$campaign_id&status=$AADstatuses[$o]\">CANCELLA</a></td></tr>\n";
			}

		echo "</table>\n";

		echo "<br>AGGIUNGI NUOVO ESITO CHIAMA-AUTO-NUM-ALTERN<BR><form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=ADD value=26>\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
		echo "Esito: <select size=1 name=status>\n";
		echo "$LRstatuses_list\n";
		echo "</select> &nbsp; \n";
		echo "<input type=submit name=submit value=ADD><BR>\n";

		echo "</FORM><br>\n";
		}

	##### CAMPAIGN PAUSE CODES #####
	if ($SUB==27)
		{
		echo "<br><br><b>CODICI PAUSA OPERATORE PER QUESTA CAMPAGNA: &nbsp; $NWB#vicidial_pause_codes$NWE</b><br>\n";
		echo "<TABLE width=500 cellspacing=3>\n";
		echo "<tr><td>CODICI PAUSA</td><td>FATTURABILE</td><td>MODIFICA</td><td>CANCELLA</td></tr>\n";

			$stmt="SELECT * from vicidial_pause_codes where campaign_id='$campaign_id' order by pause_code";
			$rslt=mysql_query($stmt, $link);
			$pause_codes_to_print = mysql_num_rows($rslt);
			$o=0;
			while ($pause_codes_to_print > $o) {
				$rowx=mysql_fetch_row($rslt);
				$o++;

			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}

			echo "<tr $bgcolor><td><form action=$PHP_SELF method=POST><font size=1>$rowx[0]\n";
			echo "<input type=hidden name=ADD value=47>\n";
			echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
			echo "<input type=hidden name=pause_code value=\"$rowx[0]\"> &nbsp;\n";
			echo "<input type=text size=20 maxlength=30 name=pause_code_name value=\"$rowx[1]\"></td>\n";
			echo "<td><select size=1 name=billable><option>YES</option><option>NO</option><option>HALF</option><option SELECTED>$rowx[2]</option></select></td>\n";
			echo "<td><font size=1><input type=submit name=submit value=MODIFY></form></td>\n";
			echo "<td><font size=1><a href=\"$PHP_SELF?ADD=67&campaign_id=$campaign_id&pause_code=$rowx[0]\">CANCELLA</a></td></tr>\n";
			}

		echo "</table>\n";

		echo "<br>NUOVO CODICE PAUSA<BR><form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=ADD value=27>\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
		echo "Codice Pausa: <input type=text size=8 maxlength=6 name=pause_code>\n";
		echo "Nome Codice Pausa: <input type=text size=20 maxlength=30 name=pause_code_name>\n";
		echo " &nbsp; Fatturabile: <select size=1 name=billable><option>YES</option><option>NO</option><option>HALF</option></select>\n";
		echo "<input type=submit name=submit value=ADD><BR>\n";

		echo "</center></FORM><br>\n";
		}

	##### CAMPAIGN QC SETTINGS #####
	if ($SUB==28)
		{
		$stmt="SELECT list_id,list_name,active from vicidial_lists where campaign_id='$campaign_id'";
		$rslt=mysql_query($stmt, $link);
		$lists_to_print = mysql_num_rows($rslt);
		$qc_lists_list='';

		$p=0;
		while ($lists_to_print > $p) 
			{
			$rowx=mysql_fetch_row($rslt);
			$qc_lists_list .= "<input type=\"checkbox\" name=\"qc_lists[]\" value=\"$rowx[0]\"";
			$r=0;
			while ($r < $QCL_to_print)
				{
				if ($rowx[0] == $QClists[$r]) 
					{
					$qc_lists_list .= " CHECKED";
					}
				$r++;
				}
			$qc_lists_list .= "> $rowx[0] - $rowx[1] - $rowx[2]<BR>\n";

			$p++;
			}

		##### get scripts listings for pulldown
		$stmt="SELECT script_id,script_name from vicidial_scripts order by script_id";
		$rslt=mysql_query($stmt, $link);
		$scripts_to_print = mysql_num_rows($rslt);
		$QCscripts_list="";
		$o=0;
		while ($scripts_to_print > $o)
			{
			$rowx=mysql_fetch_row($rslt);
			$QCscripts_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$scriptname_list["$rowx[0]"] = "$rowx[1]";
			$o++;
			}
		##### get shifts listings for pulldown
		$stmt="SELECT shift_id,shift_name from vicidial_shifts order by shift_id";
		$rslt=mysql_query($stmt, $link);
		$shifts_to_print = mysql_num_rows($rslt);
		$QCshifts_list="";
		$o=0;
		while ($shifts_to_print > $o)
			{
			$rowx=mysql_fetch_row($rslt);
			$QCshifts_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$shiftname_list["$rowx[0]"] = "$rowx[1]";
			$o++;
			}

		echo "<br><br><b>QC SETTINGS FOR THIS CAMPAIGN:</b><br>\n";
		echo "<form action=$PHP_SELF method=POST><center><TABLE width=700 cellspacing=3>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right><input type=hidden name=ADD value=48>\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
		echo "QC Enabled: </td><td><select size=1 name=qc_enabled><option>Y</option><option>N</option><option SELECTED>$qc_enabled</option></select> $NWB#vicidial_campaigns-qc_enabled$NWE</td></tr>\n";
		echo "<tr bgcolor=#9BB9FB><td align=right>QC Esiti: <BR> $NWB#vicidial_campaigns-qc_statuses$NWE</td><td>$qc_statuses_list</td></tr>\n";
#		echo "<tr bgcolor=#B9CBFD><td align=right>QC Lists: <BR> $NWB#vicidial_campaigns-qc_lists$NWE</td><td>$qc_lists_list</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>QC WebForm: </td><td align=left><input type=text name=qc_web_form_address size=50 maxlength=255 value=\"$qc_web_form_address\">$NWB#vicidial_campaigns-qc_web_form_address$NWE</td></tr>\n";

		echo "<tr bgcolor=#B9CBFD><td align=right><a href=\"$PHP_SELF?ADD=3111111&script_id=$script_id\">QC Script</a>: </td><td align=left><select size=1 name=qc_script>\n";
		echo "$QCscripts_list";
		echo "<option selected value=\"$qc_script\">$qc_script - $scriptname_list[$qc_script]</option>\n";
		echo "</select>$NWB#vicidial_campaigns-qc_script$NWE</td></tr>\n";

		echo "<tr bgcolor=#B9CBFD><td align=right><a href=\"$PHP_SELF?ADD=331111111&shift_id=$qc_shift_id\">QC Shift</a>: </td><td align=left><select size=1 name=qc_shift_id>\n";
		echo "$QCshifts_list";
		echo "<option selected value=\"$qc_shift_id\">$qc_shift_id - $shiftname_list[$qc_shift_id]</option>\n";
		echo "</select>$NWB#vicidial_campaigns-qc_shift_id$NWE</td></tr>\n";

		echo "<tr bgcolor=#B9CBFD><td align=right>QC Get Record Launch: </td><td><select size=1 name=qc_get_record_launch><option>NESSUNO</option><option>SCRIPT</option><option>WEBFORM</option><option>QCSCRIPT</option><option>QCWEBFORM</option><option SELECTED>$qc_get_record_launch</option></select> $NWB#vicidial_campaigns-qc_get_record_launch$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>QC Show Recording: </td><td><select size=1 name=qc_show_recording><option>Y</option><option>N</option><option SELECTED>$qc_show_recording</option></select> $NWB#vicidial_campaigns-qc_show_recording$NWE</td></tr>\n";

		echo "<tr bgcolor=#B9CBFD><td align=center colspan=2><input type=submit name=submit value=INVIA></td></tr>\n";
		echo "</table>\n";
		echo "<BR></center></FORM><br>\n";
		}

	##### CAMPAIGN SURVEY SETTINGS #####
	if ($SUB=='20A')
		{

		echo "<center><br><b>SURVEY SETTINGS FOR THIS CAMPAIGN:</b><br>\n";
		echo "<form action=$PHP_SELF method=POST><center><TABLE width=750 cellspacing=3>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right><input type=hidden name=ADD value=40A>\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";

		echo "<tr bgcolor=#B9CBFD><td align=right>Survey First Audio File: </td><td><input type=text size=50 maxlength=50 name=survey_first_audio_file value=\"$survey_first_audio_file\"> $NWB#vicidial_campaigns-survey_first_audio_file$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey DTMF Digits: </td><td><input type=text size=16 maxlength=16 name=survey_dtmf_digits value=\"$survey_dtmf_digits\"> $NWB#vicidial_campaigns-survey_dtmf_digits$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey Not Interested Digit: </td><td><input type=text size=5 maxlength=1 name=survey_ni_digit value=\"$survey_ni_digit\"> $NWB#vicidial_campaigns-survey_ni_digit$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey Opt-in Audio File: </td><td><input type=text size=50 maxlength=50 name=survey_opt_in_audio_file value=\"$survey_opt_in_audio_file\"> $NWB#vicidial_campaigns-survey_opt_in_audio_file$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey Not Interested Audio File: </td><td><input type=text size=50 maxlength=50 name=survey_ni_audio_file value=\"$survey_ni_audio_file\"> $NWB#vicidial_campaigns-survey_ni_audio_file$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey Method: </td><td><select size=1 name=survey_method><option>AGENT_XFER</option><option>VOICEMAIL</option><option>INTERNO</option><option>HANGUP</option><option>CAMPREC_60_WAV</option><option SELECTED>$survey_method</option></select> $NWB#vicidial_campaigns-survey_method$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey No-Response Action: </td><td><select size=1 name=survey_no_response_action><option>OPTIN</option><option>OPTOUT</option><option SELECTED>$survey_no_response_action</option></select> $NWB#vicidial_campaigns-survey_no_response_action$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey Not Interested Esito: </td><td><select name=survey_ni_status>$survey_ni_status_list</select> $NWB#vicidial_campaigns-survey_ni_status$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey Response Digit Map: </td><td><input type=text size=70 maxlength=100 name=survey_response_digit_map value=\"$survey_response_digit_map\"> $NWB#vicidial_campaigns-survey_response_digit_map$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey Survey Xfer Extension: </td><td><input type=text size=12 maxlength=20 name=survey_xfer_exten value=\"$survey_xfer_exten\"> $NWB#vicidial_campaigns-survey_xfer_exten$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Survey Registrazioni Per Questa Campagna Directory: </td><td><input type=text size=70 maxlength=255 name=survey_camp_record_dir value=\"$survey_camp_record_dir\"> $NWB#vicidial_campaigns-survey_camp_record_dir$NWE</td></tr>\n";
		echo "<tr bgcolor=#B9CBFD><td align=right>Casella Vocale: </td><td><input type=text size=12 maxlength=20 name=voicemail_ext value=\"$voicemail_ext\"> $NWB#vicidial_campaigns-voicemail_ext$NWE</td></tr>\n";

		echo "<tr bgcolor=#B9CBFD><td align=center colspan=2><input type=submit name=submit value=INVIA></td></tr>\n";
		echo "</table>\n";
		echo "<BR></center></FORM><br>\n";
		}


	if ($SUB < 1)
		{
		echo "<BR><BR>\n";
		echo "<a href=\"$PHP_SELF?ADD=52&campaign_id=$campaign_id\">DISCONNETTI TUTTI GLI OPERATORI DI QUESTA CAMPAGNA</a><BR><BR>\n";
		echo "<a href=\"$PHP_SELF?ADD=53&campaign_id=$campaign_id\">EMERGENCY VDAC CLEAR FOR THIS CAMPAIGN</a><BR><BR>\n";

		if ($LOGdelete_campaigns > 0)
			{
			echo "<br><br><a href=\"$PHP_SELF?ADD=51&campaign_id=$campaign_id\">CANCELLA QUESTA CAMPAGNA</a>\n";
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=34 modify campaign info in the system - Basic View
######################

if ( ($ADD==34) and ( (!eregi("$campaign_id",$LOGallowed_campaigns)) and (!eregi("ALL-CAMPAIGNS",$LOGallowed_campaigns)) ) ) 
	{$ADD=30;}	# send to not allowed screen if not in vicidial_user_groups allowed_campaigns list

if ($ADD==34)
{
	if ($LOGmodify_campaigns==1)
	{
		if ($stage=='show_dialable')
		{
			$stmt="UPDATE vicidial_campaigns set display_dialable_count='Y' where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);
		}
		if ($stage=='hide_dialable')
		{
			$stmt="UPDATE vicidial_campaigns set display_dialable_count='N' where campaign_id='$campaign_id';";
			$rslt=mysql_query($stmt, $link);
		}

		$stmt="SELECT * from vicidial_campaigns where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		$dial_status_a = $row[3];
		$dial_status_b = $row[4];
		$dial_status_c = $row[5];
		$dial_status_d = $row[6];
		$dial_status_e = $row[7];
		$lead_order = $row[8];
		$hopper_level = $row[13];
		$auto_dial_level = $row[14];
		$next_agent_call = $row[15];
		$local_call_time = $row[16];
		$voicemail_ext = $row[17];
		$dial_timeout = $row[18];
		$dial_prefix = $row[19];
		$campaign_cid = $row[20];
		$campaign_vdad_exten = $row[21];
		$script_id = $row[25];
		$get_call_launch = $row[26];
		$lead_filter_id = $row[35];
			if ($lead_filter_id=='') {$lead_filter_id='NONE';}
		$display_dialable_count = $row[39];
		$dial_method = $row[46];
		$adaptive_intensity = $row[51];
		$campaign_description = $row[57];
		$campaign_changedate = $row[58];
		$campaign_stats_refresh = $row[59];
		$campaign_logindate = $row[60];
		$dial_statuses = $row[61];
		$list_order_mix = $row[64];
		$default_xfer_group = $row[67];
		$campaign_allow_inbound = $row[65];
		$default_xfer_group = $row[67];

	if (ereg("DISABLED",$list_order_mix))
		{$DEFlistDISABLE = '';	$DEFstatusDISABLED=0;}
	else
		{$DEFlistDISABLE = 'disabled';	$DEFstatusDISABLED=1;}

		$stmt="SELECT * from vicidial_statuses order by status";
		$rslt=mysql_query($stmt, $link);
		$statuses_to_print = mysql_num_rows($rslt);
		$statuses_list='';
		$dial_statuses_list='';
		$o=0;
		while ($statuses_to_print > $o) 
			{
			$rowx=mysql_fetch_row($rslt);
			$statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			if ($rowx[0] != 'CBHOLD') {$dial_statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";}
			$statname_list["$rowx[0]"] = "$rowx[1]";
			$LRstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";
			if (eregi("Y",$rowx[2]))
				{$HKstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";}
			$o++;
			}

		$stmt="SELECT * from vicidial_campaign_statuses where campaign_id='$campaign_id' order by status";
		$rslt=mysql_query($stmt, $link);
		$Cstatuses_to_print = mysql_num_rows($rslt);

		$o=0;
		while ($Cstatuses_to_print > $o) 
			{
			$rowx=mysql_fetch_row($rslt);
			$statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			if ($rowx[0] != 'CBHOLD') {$dial_statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";}
			$statname_list["$rowx[0]"] = "$rowx[1]";
			$LRstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";
			if (eregi("Y",$rowx[2]))
				{$HKstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";}
			$o++;
			}

		$dial_statuses = preg_replace("/ -$/","",$dial_statuses);
		$Dstatuses = explode(" ", $dial_statuses);
		$Ds_to_print = (count($Dstatuses) -1);

	$stmt="SELECT count(*) from vicidial_campaigns_list_mix where campaign_id='$campaign_id' and status='ACTIVE'";
	$rslt=mysql_query($stmt, $link);
	$rowx=mysql_fetch_row($rslt);
	if ($rowx[0] < 1)
		{
		$mixes_list="<option SELECTED value=\"DISABLED\">DISABLED</option>\n";
		$mixname_list["DISABLED"] = "DISABLED";
		}
	else
		{
		##### get list_mix listings for dynamic pulldown
		$stmt="SELECT vcl_id,vcl_name from vicidial_campaigns_list_mix where campaign_id='$campaign_id' and status='ACTIVE' limit 1";
		$rslt=mysql_query($stmt, $link);
		$mixes_to_print = mysql_num_rows($rslt);
		$mixes_list="<option value=\"DISABLED\">DISABLED</option>\n";

		$o=0;
		while ($mixes_to_print > $o)
			{
			$rowx=mysql_fetch_row($rslt);
			$mixes_list .= "<option value=\"ACTIVE\">ACTIVE ($rowx[0] - $rowx[1])</option>\n";
			$mixname_list["ACTIVE"] = "$rowx[0] - $rowx[1]";
			$o++;
			}
		}

	if ($SUB<1)		{$camp_detail_color=$subcamp_color;}
		else		{$camp_detail_color=$campaigns_color;}
	if ($SUB==22)	{$camp_statuses_color=$subcamp_color;}
		else		{$camp_statuses_color=$campaigns_color;}
	if ($SUB==23)	{$camp_hotkeys_color=$subcamp_color;}
		else		{$camp_hotkeys_color=$campaigns_color;}
	if ($SUB==25)	{$camp_recycle_color=$subcamp_color;}
		else		{$camp_recycle_color=$campaigns_color;}
	if ($SUB==26)	{$camp_autoalt_color=$subcamp_color;}
		else		{$camp_autoalt_color=$campaigns_color;}
	if ($SUB==27)	{$camp_pause_color=$subcamp_color;}
		else		{$camp_pause_color=$campaigns_color;}
	if ($SUB==29)	{$camp_listmix_color=$subcamp_color;}
		else		{$camp_listmix_color=$campaigns_color;}
	echo "<TABLE WIDTH=$page_width CELLPADDING=2 CELLSPACING=0><TR BGCOLOR=\"$campaigns_color\">\n";
	echo "<TD><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\"> <B>$row[0]</B>: </font></TD>";
	echo "<TD BGCOLOR=\"$camp_detail_color\"><a href=\"$PHP_SELF?ADD=34&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Vista Generale </font></a></TD>";
	echo "<TD> <a href=\"$PHP_SELF?ADD=31&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Vista Dettagliata</font></a> </TD>";
	echo "<TD BGCOLOR=\"$camp_listmix_color\"> <a href=\"$PHP_SELF?ADD=34&SUB=29&campaign_id=$campaign_id\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">List Mix</font></a> </TD>";
	echo "<TD> <a href=\"./AST_timeonVDADall.php?RR=4&DB=0&group=$row[0]\"><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\">Schermata Tempo Reale</font></a></TD>\n";
	echo "<TD WIDTH=300><font size=2 color=$subcamp_font face=\"ARIAL,HELVETICA\"> &nbsp; </font></TD>\n";
	echo "</TR></TABLE>\n";

	if ($SUB < 1)
		{
		echo "<TABLE><TR><TD>\n";
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
		echo "<form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=ADD value=44>\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
		echo "<center><TABLE width=$section_width cellspacing=3>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>ID Campagna: </td><td align=left><b>$row[0]</b>$NWB#vicidial_campaigns-campaign_id$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Nome Campagna: </td><td align=left><input type=text name=campaign_name size=40 maxlength=40 value=\"$row[1]\">$NWB#vicidial_campaigns-campaign_name$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Descrizione Campagna: </td><td align=left>$row[57]$NWB#vicidial_campaigns-campaign_description$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Campagna Change Date: </td><td align=left>$campaign_changedate &nbsp; $NWB#vicidial_campaigns-campaign_changedate$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Campagna Login Date: </td><td align=left>$campaign_logindate &nbsp; $NWB#vicidial_campaigns-campaign_logindate$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option SELECTED>$row[2]</option></select>$NWB#vicidial_campaigns-active$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Extension del parking: </td><td align=left>$row[9] - $row[10]$NWB#vicidial_campaigns-park_ext$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left>$row[11]$NWB#vicidial_campaigns-web_form_address$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Permitir Closers: </td><td align=left>$row[12] $NWB#vicidial_campaigns-allow_closers$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo De la Transferencia Del Defecto:</td><td align=left>$default_xfer_group $NWB#vicidial_campaigns-default_xfer_group$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Permita de entrada y mezclado:</td><td align=left>$campaign_allow_inbound $NWB#vicidial_campaigns-campaign_allow_inbound$NWE</td></tr>\n";

		$o=0;
		while ($Ds_to_print > $o) 
			{
			$o++;
			$Dstatus = $Dstatuses[$o];

			echo "<tr bgcolor=#B6D3FC><td align=right>Esito Chiamata $o: </td><td align=left> \n";
			if ($DEFstatusDISABLED > 0)
				{
				echo "<font color=grey><DEL><b>$Dstatus</b> - $statname_list[$Dstatus] &nbsp; &nbsp; &nbsp; &nbsp; <font size=2>\n";
				echo "REMOVE</DEL></td></tr>\n";
				}
			else
				{
				echo "<b>$Dstatus</b> - $statname_list[$Dstatus] &nbsp; &nbsp; &nbsp; &nbsp; <font size=2>\n";
				echo "<a href=\"$PHP_SELF?ADD=68&campaign_id=$campaign_id&status=$Dstatuses[$o]\">RIMUOVI</a></td></tr>\n";
				}
			}

		echo "<tr bgcolor=#B6D3FC><td align=right>Aggiungi Un Esito Chiamata: </td><td align=left><select size=1 name=dial_status $DEFlistDISABLE>\n";
		echo "<option value=\"\"> - NONE - </option>\n";

		echo "$dial_statuses_list";
		echo "</select> &nbsp; \n";
		echo "<input type=submit name=submit value=ADD> &nbsp; &nbsp; $NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Ordine Lista: </td><td align=left><select size=1 name=lead_order><option>DOWN</option><option>UP</option><option>DOWN PHONE</option><option>UP PHONE</option><option>DOWN LAST NAME</option><option>UP LAST NAME</option><option>DOWN COUNT</option><option>UP COUNT</option><option>DOWN 2nd NEW</option><option>DOWN 3rd NEW</option><option>DOWN 4th NEW</option><option>DOWN 5th NEW</option><option>DOWN 6th NEW</option><option>UP 2nd NEW</option><option>UP 3rd NEW</option><option>UP 4th NEW</option><option>UP 5th NEW</option><option>UP 6th NEW</option><option>DOWN PHONE 2nd NEW</option><option>DOWN PHONE 3rd NEW</option><option>DOWN PHONE 4th NEW</option><option>DOWN PHONE 5th NEW</option><option>DOWN PHONE 6th NEW</option><option>UP PHONE 2nd NEW</option><option>UP PHONE 3rd NEW</option><option>UP PHONE 4th NEW</option><option>UP PHONE 5th NEW</option><option>UP PHONE 6th NEW</option><option>DOWN LAST NAME 2nd NEW</option><option>DOWN LAST NAME 3rd NEW</option><option>DOWN LAST NAME 4th NEW</option><option>DOWN LAST NAME 5th NEW</option><option>DOWN LAST NAME 6th NEW</option><option>UP LAST NAME 2nd NEW</option><option>UP LAST NAME 3rd NEW</option><option>UP LAST NAME 4th NEW</option><option>UP LAST NAME 5th NEW</option><option>UP LAST NAME 6th NEW</option><option>DOWN COUNT 2nd NEW</option><option>DOWN COUNT 3rd NEW</option><option>DOWN COUNT 4th NEW</option><option>DOWN COUNT 5th NEW</option><option>DOWN COUNT 6th NEW</option><option>UP COUNT 2nd NEW</option><option>UP COUNT 3rd NEW</option><option>UP COUNT 4th NEW</option><option>UP COUNT 5th NEW</option><option>UP COUNT 6th NEW</option><option SELECTED>$lead_order</option></select>$NWB#vicidial_campaigns-lead_order$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=31&SUB=29&campaign_id=$campaign_id&vcl_id=$list_order_mix\">List Mix</a>: </td><td align=left><select size=1 name=list_order_mix>\n";
		echo "$mixes_list";
		if (ereg("DISABLED",$list_order_mix))
			{echo "<option selected value=\"$list_order_mix\">$list_order_mix - $mixname_list[$list_order_mix]</option>\n";}
		else
			{echo "<option selected value=\"ACTIVE\">ACTIVE ($mixname_list[ACTIVE])</option>\n";}
		echo "</select>$NWB#vicidial_campaigns-list_order_mix$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=31111111&lead_filter_id=$lead_filter_id\">Filtro Contatti</a>: </td><td align=left><select size=1 name=lead_filter_id>\n";
		echo "$filters_list";
		echo "<option selected value=\"$lead_filter_id\">$lead_filter_id - $filtername_list[$lead_filter_id]</option>\n";
		echo "</select>$NWB#vicidial_campaigns-lead_filter_id$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Livello Coda Chiamate: </td><td align=left><select size=1 name=hopper_level><option>1</option><option>5</option><option>10</option><option>20</option><option>50</option><option>100</option><option>200</option><option>500</option><option>700</option><option>1000</option><option>2000</option><option SELECTED>$hopper_level</option></select>$NWB#vicidial_campaigns-hopper_level$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Forza Il Reset Della Coda Chiamate: </td><td align=left><select size=1 name=reset_hopper><option>Y</option><option SELECTED>N</option></select>$NWB#vicidial_campaigns-force_reset_hopper$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Metodo Chiamata: </td><td align=left><select size=1 name=dial_method><option >MANUAL</option><option>RATIO</option><option>ADAPT_HARD_LIMIT</option><option>ADAPT_TAPERED</option><option>ADAPT_AVERAGE</option><option>INBOUND_MAN</option><option SELECTED>$dial_method</option></select>$NWB#vicidial_campaigns-dial_method$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Livello Auto Dial: </td><td align=left><select size=1 name=auto_dial_level><option >0</option><option>1</option><option>1.1</option><option>1.2</option><option>1.3</option><option>1.4</option><option>1.5</option><option>1.6</option><option>1.7</option><option>1.8</option><option>1.9</option><option>2.0</option><option>2.2</option><option>2.5</option><option>2.7</option><option>3.0</option><option>3.5</option><option>4.0</option><option SELECTED>$auto_dial_level</option></select>(0 = off)$NWB#vicidial_campaigns-auto_dial_level$NWE</td></tr>\n";

		echo "<tr bgcolor=#BDFFBD><td align=right>Modifica Intensita` Adapt Auto-Dial: </td><td align=left><select size=1 name=adaptive_intensity>\n";
		$n=40;
		while ($n>=-40)
			{
			$dtl = 'Balanced';
			if ($n<0) {$dtl = 'Less Intense';}
			if ($n>0) {$dtl = 'More Intense';}
			if ($n == $adaptive_intensity) 
				{echo "<option SELECTED value=\"$n\">$n - $dtl</option>\n";}
			else
				{echo "<option value=\"$n\">$n - $dtl</option>\n";}
			$n--;
			}
		echo "</select> $NWB#vicidial_campaigns-adaptive_intensity$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=3111111&script_id=$script_id\">Script</a>: </td><td align=left>$script_id</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Esegui all`avvio della telefonata: </td><td align=left>$get_call_launch</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
		echo "</TABLE></center></FORM>\n";

		echo "<center>\n";
		echo "<br><b>LISTE IN QUESTA CAMPAGNA: &nbsp; $NWB#vicidial_campaign_lists$NWE</b><br>\n";
		echo "<TABLE width=400 cellspacing=3>\n";
		echo "<tr><td>ID LISTA</td><td>NOME LISTA</td><td>ATTIVO</td></tr>\n";

			$active_lists = 0;
			$inactive_lists = 0;
			$stmt="SELECT list_id,active,list_name from vicidial_lists where campaign_id='$campaign_id'";
			$rslt=mysql_query($stmt, $link);
			$lists_to_print = mysql_num_rows($rslt);
			$camp_lists='';

			$o=0;
			while ($lists_to_print > $o) {
				$rowx=mysql_fetch_row($rslt);
				$o++;
			if (ereg("Y", $rowx[1])) {$active_lists++;   $camp_lists .= "'$rowx[0]',";}
			if (ereg("N", $rowx[1])) {$inactive_lists++;}

			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}

			echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=311&list_id=$rowx[0]\">$rowx[0]</a></td><td><font size=1>$rowx[2]</td><td><font size=1>$rowx[1]</td></tr>\n";

			}

		echo "</table></center><br>\n";
		echo "<center><b>\n";

		$filterSQL = $filtersql_list[$lead_filter_id];
		$filterSQL = eregi_replace("^and|and$|^or|or$","",$filterSQL);
		if (strlen($filterSQL)>4)
			{$fSQL = "and $filterSQL";}
		else
			{$fSQL = '';}

			$camp_lists = eregi_replace(".$","",$camp_lists);
		echo "Questa campagna ha $active_lists liste attive e $inactive_lists lista inattive<br><br>\n";


		if ($display_dialable_count == 'Y')
			{
			### call function to calculate and print dialable leads
			dialable_leads($DB,$link,$local_call_time,$dial_statuses,$camp_lists,$fSQL);
			echo " - <font size=1><a href=\"$PHP_SELF?ADD=34&campaign_id=$campaign_id&stage=hide_dialable\">NASCONDI</a></font><BR><BR>";
			}
		else
			{
			echo "<a href=\"$PHP_SELF?ADD=73&campaign_id=$campaign_id\" target=\"_blank\">Popup Dialable Leads Count</a>";
			echo " - <font size=1><a href=\"$PHP_SELF?ADD=31&campaign_id=$campaign_id&stage=show_dialable\">MOSTRA</a></font><BR><BR>";
			}



			$stmt="SELECT count(*) FROM vicidial_hopper where campaign_id='$campaign_id' and status IN('READY')";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_query($stmt, $link);
			$rowx=mysql_fetch_row($rslt);
			$hopper_leads = "$rowx[0]";

		echo "Questa campagna ha $hopper_leads contatti nella coda chiamate<br><br>\n";
		echo "<a href=\"./AST_VICIDIAL_hopperlist.php?group=$campaign_id\">Clicca qui per vedere quali numeri sono nella coda chiamate in questo momento</a><br><br>\n";
		echo "<a href=\"$PHP_SELF?ADD=81&campaign_id=$campaign_id\">Clicca qui per visualizzare tutti i richiami in attesa per questa campagna</a><BR><BR>\n";
		echo "<a href=\"./AST_VDADstats.php?group=$campaign_id\">Clicca qui per vedere il report VDAD per questa campagna</a><BR><BR>\n";
		echo "</b></center>\n";

		echo "<br>\n";

		### list of agent rank or skill-level for this campaign
		echo "<center>\n";
		echo "<br><b>CLASSIFICA OPERATORI PER QUESTA CAMPAGNA:</b><br>\n";
		echo "<TABLE width=400 cellspacing=3>\n";
		echo "<tr><td>UTENTE</td><td> &nbsp; &nbsp; CLASSIFICA</td><td> &nbsp; &nbsp; CHIAMATE OGGI</td></tr>\n";

			$stmt="SELECT user,campaign_rank,calls_today from vicidial_campaign_agents where campaign_id='$campaign_id'";
			$rsltx=mysql_query($stmt, $link);
			$users_to_print = mysql_num_rows($rsltx);

			$o=0;
			while ($users_to_print > $o) {
				$rowx=mysql_fetch_row($rsltx);
				$o++;

			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}

			echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=3&user=$rowx[0]\">$rowx[0]</a></td><td><font size=1>$rowx[1]</td><td><font size=1>$rowx[2]</td></tr>\n";
			}

		echo "</table></center><br>\n";


		echo "<a href=\"$PHP_SELF?ADD=52&campaign_id=$campaign_id\">DISCONNETTI TUTTI GLI OPERATORI DI QUESTA CAMPAGNA</a><BR><BR>\n";


		if ($LOGdelete_campaigns > 0)
			{
			echo "<br><br><a href=\"$PHP_SELF?ADD=51&campaign_id=$campaign_id\">CANCELLA QUESTA CAMPAGNA</a>\n";
			}
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=31 or 34 and SUB=29 for list mixes
######################
if ( ( ($ADD==34) or ($ADD==31) ) and ( (!eregi("$campaign_id",$LOGallowed_campaigns)) and (!eregi("ALL-CAMPAIGNS",$LOGallowed_campaigns)) ) ) 
	{$ADD=30;}	# send to not allowed screen if not in vicidial_user_groups allowed_campaigns list

if ( ($ADD==34) or ($ADD==31) )
{
	if ($LOGmodify_campaigns==1)
	{
	##### CAMPAIGN LIST MIX SETTINGS #####
	if ($SUB==29)
		{
		##### get list_id listings for dynamic pulldown
		$stmt="SELECT list_id,list_name from vicidial_lists where campaign_id='$campaign_id' order by list_id";
		$rslt=mysql_query($stmt, $link);
		$mixlists_to_print = mysql_num_rows($rslt);
		$mixlists_list="";

		$o=0;
		while ($mixlists_to_print > $o)
			{
			$rowx=mysql_fetch_row($rslt);
			$mixlists_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$mixlistsname_list["$rowx[0]"] = "$rowx[1]";
			$o++;
			}


		echo "<br><br><b>MIX LISTA PER QUESTA CAMPAGNA: &nbsp; $NWB#vicidial_campaigns-list_order_mix$NWE</b><br>\n";

		echo "<br><br><b>Experimental Feature in development!!! NON-FUNCTIONAL</b><br>\n";


		$stmt="SELECT * from vicidial_campaigns_list_mix where campaign_id='$campaign_id' order by status, vcl_id";
		$rslt=mysql_query($stmt, $link);
		$listmixes = mysql_num_rows($rslt);
		$o=0;
		while ($listmixes > $o) 
			{
			$rowx=mysql_fetch_row($rslt);
			$vcl_id=$rowx[0];
			$o++;

			if ($o < 2)
				{$tablecolor='bgcolor="#99FF99"';   $bgcolor='bgcolor="#CCFFCC"';}
			else
				{
				if (eregi("1$|3$|5$|7$|9$", $o))
					{$tablecolor='bgcolor="#B9CBFD"';   $bgcolor='bgcolor="#9BB9FB"';} 
				else
					{$tablecolor='bgcolor="#9BB9FB"';   $bgcolor='bgcolor="#B9CBFD"';}
				}
			echo "<a name=\"$vcl_id\"><BR>\n";
			echo "<span id=\"LISTMIX$US$vcl_id$US$o\">";
			echo "<TABLE width=740 cellspacing=3 $tablecolor>\n";
			echo "<tr><td colspan=6>\n";
			echo "<form action=\"$PHP_SELF#$vcl_id\" method=POST name=$vcl_id id=$vcl_id>\n";
			echo "<input type=hidden name=ADD value=49>\n";
			echo "<input type=hidden name=SUB value=29>\n";
			echo "<input type=hidden name=stage value=\"MODIFY\">\n";
			echo "<input type=hidden name=vcl_id value=\"$vcl_id\">\n";
			echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
			echo "<input type=hidden name=list_mix_container$US$vcl_id id=list_mix_container$US$vcl_id value=\"\">\n";
			echo "<B>$vcl_id:</B>\n";
			echo "<input type=text size=40 maxlength=50 name=vcl_name$US$vcl_id id=vcl_name$US$vcl_id value=\"$rowx[1]\">\n";
			echo " &nbsp; &nbsp; <a href=\"$PHP_SELF?ADD=49&SUB=29&stage=DELMIX&campaign_id=$campaign_id&vcl_id=$vcl_id\">DELETE LIST MIX</a></td></tr>\n";
			echo "<tr><td colspan=3>Esito: \n";
			if ($rowx[5]=='INACTIVE')
				{
				echo "<B>$rowx[5]</B>\n";
				echo "<a href=\"$PHP_SELF?ADD=49&SUB=29&stage=SETACTIVE&campaign_id=$campaign_id&vcl_id=$vcl_id\"><font size=1>ATTIVA</font></a></td>\n";
				}
			else
				{echo "<B>$rowx[5]</B></td>\n";}
			echo "<td colspan=3>Method:\n";
			echo "<select size=1 name=mix_method$US$vcl_id id=method$US$vcl_id><option value=\"EVEN_MIX\">EVEN_MIX</option><option value=\"IN_ORDER\">IN_ORDER</option><option value=\"RANDOM\">RANDOM</option><option SELECTED value=\"$rowx[4]\">$rowx[4]</option></select></td></tr>\n";
			echo "<tr><td>ID LISTA</td><td>PRIORITY</td><td>% MIX</td><td>ESITI</td><td></td></tr>\n";

# list_id|order|percent|statuses|:list_id|order|percent|statuses|:...
# 101|1|40| A B NA -|:102|2|25| NEW -|:103|3|30| DROP CALLBK -|:101|4|5| DROP -|
# INSERT INTO vicidial_campaigns_list_mix values('TESTMIX','TESTCAMP List Mix','TESTCAMP','101|1|40| A B NA -|:102|2|25| NEW -|:103|3|30| DROP CALLBK -|:101|4|5| DROP -|','IN_ORDER','ACTIVE');
# INSERT INTO vicidial_campaigns_list_mix values('TESTMIX2','TESTCAMP List Mix2','TESTCAMP','101|1|20| A B -|:102|2|45| NEW -|:103|3|30| DROP CALLBK -|:101|4|5| DROP -|','IN_ORDER','ACTIVE');
# INSERT INTO vicidial_campaigns_list_mix values('TESTMIX3','TESTCAMP List Mix3','TESTCAMP','101|1|30| A NA -|:102|2|35| NEW -|:103|3|30| DROP CALLBK -|:101|4|5| DROP -|','IN_ORDER','ACTIVE');

			$MIXentries = $MT;
			$MIXentries = explode(":", $rowx[3]);
			$Ms_to_print = (count($MIXentries) - 0);
			$q=0;
			while ($Ms_to_print > $q) 
				{
				$MIXdetails = explode('|', $MIXentries[$q]);
				$MIXdetailsLIST = $MIXdetails[0];

				$dial_statuses = preg_replace("/ -$/","",$dial_statuses);
				$Dstatuses = explode(" ", $dial_statuses);
				$Ds_to_print = (count($Dstatuses) - 0);
				$Dsql = '';
				$r=0;
				while ($Ds_to_print > $r) 
					{
					$r++;
					$Dsql .= "'$Dstatuses[$r]',";
					}
				$Dsql = preg_replace("/,$/","",$Dsql);

				echo "<tr $bgcolor><td NOWRAP><font size=3>\n";
				echo "<input type=hidden name=list_id$US$q$US$vcl_id id=list_id$US$q$US$vcl_id value=$MIXdetailsLIST>\n";
				echo "<a href=\"$PHP_SELF?ADD=311&list_id=$MIXdetailsLIST\">List</a>: $MIXdetailsLIST &nbsp; <font size=1><a href=\"$PHP_SELF?ADD=49&SUB=29&stage=REMOVE&campaign_id=$campaign_id&vcl_id=$vcl_id&mix_container_item=$q&list_id=$MIXdetailsLIST#$vcl_id\">RIMUOVI</a></font></td>\n";

				echo "<td><select size=1 name=priority$US$q$US$vcl_id id=priority$US$q$US$vcl_id>\n";
				$n=10;
				while ($n>=1)
					{
					echo "<option value=\"$n\">$n</option>\n";
					$n = ($n-1);
					}
				echo "<option SELECTED value=\"$MIXdetails[1]\">$MIXdetails[1]</option></select></td>\n";

				echo "<td><select size=1 name=\"percentage$US$q$US$vcl_id\" id=\"percentage$US$q$US$vcl_id\" onChange=\"mod_mix_percent('$vcl_id','$Ms_to_print')\">\n";
				$n=100;
				while ($n>=0)
					{
					echo "<option value=\"$n\">$n</option>\n";
					$n = ($n-5);
					}
				echo "<option SELECTED value=\"$MIXdetails[2]\">$MIXdetails[2]</option></select></td>\n";

				
				echo "<td><input type=hidden name=status$US$q$US$vcl_id id=status$US$q$US$vcl_id value=\"$MIXdetails[3]\"><input type=text size=20 maxlength=255 name=ROstatus$US$q$US$vcl_id id=ROstatus$US$q$US$vcl_id value=\"$MIXdetails[3]\" READONLY></td>\n";
				echo "<td NOWRAP>\n";



				echo "<select size=1 name=dial_status$US$q$US$vcl_id id=dial_status$US$q$US$vcl_id>\n";
				echo "<option value=\"\"> - Select A Status - </option>\n";

				echo "$dial_statuses_list";
				echo "</select> <font size=2><B>\n";
				echo "<a href=\"#\" onclick=\"mod_mix_status('ADD','$vcl_id','$q');return false;\">ADD</a> &nbsp; \n";
				echo "<a href=\"#\" onclick=\"mod_mix_status('REMOVE','$vcl_id','$q');return false;\">RIMUOVI</a>\n";
				echo "</font></B></td></tr>\n";


				echo "</td></tr>\n";


				$q++;

				}



			
			echo "<tr $bgcolor><td colspan=3 align=right><font size=2>\n";
			echo "Difference %: <input type=text size=4 name=PCT_DIFF_$vcl_id id=PCT_DIFF_$vcl_id value=0 readonly>\n";
			echo "</td>\n";

			echo "<td colspan=2><input type=button name=submit_$vcl_id id=submit_$vcl_id value=\"INVIA\" onClick=\"submit_mix('$vcl_id','$Ms_to_print')\"> &nbsp; \n";
			echo "<span id=ERROR_$vcl_id></span>\n";
			echo "</form></td></tr>\n";


			echo "<tr $bgcolor><td colspan=4 align=right><font size=2>\n";
			echo "<form action=\"$PHP_SELF#$vcl_id\" method=POST name=$vcl_id id=$vcl_id>\n";
			echo "<input type=hidden name=ADD value=49>\n";
			echo "<input type=hidden name=SUB value=29>\n";
			echo "<input type=hidden name=stage value=\"ADD\">\n";
			echo "<input type=hidden name=vcl_id value=\"$vcl_id\">\n";
			echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
			echo "List: <select size=1 name=list_id>\n";
			echo "$mixlists_list";
			echo "<option selected value=\"\">ADD ANOTHER ENTRY</option>\n";
			echo "</select></td>\n";
			
			if ($q > 9) {$AE_disabled = 'DISABLED';}
			else {$AE_disabled = '';}
			echo "<td><input type=submit name=submit value=\"ADD ENTRY\" $AE_disabled>\n";
			echo "</form></td></tr>\n";
			echo "</table></span>\n";
			}


		echo "<br><br><B>AGGIUNGI NUOVA LISTA MIX</B><BR><form action=$PHP_SELF method=POST>\n";
		echo "<table border=0>\n";
		echo "<tr $bgcolor><td><form action=\"$PHP_SELF#$vcl_id\" method=POST>\n";
		echo "<input type=hidden name=ADD value=49>\n";
		echo "<input type=hidden name=SUB value=29>\n";
		echo "<input type=hidden name=stage value=\"NEWMIX\">\n";
		echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
		echo "Mix ID: <input type=text size=20 maxlength=20 name=vcl_id value=\"\"></td>\n";
		echo "<td>Mix Name: <input type=text size=30 maxlength=50 name=vcl_name value=\"\"></td>\n";
		echo "<td>Mix Method: ";
		echo "<select size=1 name=mix_method><option value=\"EVEN_MIX\">EVEN_MIX</option><option value=\"IN_ORDER\">IN_ORDER</option><option value=\"RANDOM\">RANDOM</option></select></td></tr>\n";
		echo "<tr $bgcolor><td>List: <select size=1 name=list_id>\n";
		echo "$mixlists_list";
		echo "</select></td>\n";
		echo "<td>Dial Esito: <select size=1 name=status>\n";
		echo "$dial_statuses_list";
		echo "</select></td>\n";
		echo "<td> &nbsp; <input type=submit name=submit value=INVIA></form></td>\n";
		echo "</tr>\n";
		echo "</table>\n";

		echo "<br>\n";

		}
	}
}


######################
# ADD=30 campaign not allowed
######################

if ($ADD==30)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
echo "You do not have permission to view campaign $campaign_id\n";
}


######################
# ADD=32 display all campaign statuses
######################
if ($ADD==32)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ELENCO ESITI PERSONALIZZATI PER CAMPAGNA:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr>\n";
echo "<td><B>CAMPAGNA</B></td>\n";
echo "<td><B>NOME</B></td>\n";
echo "<td><B>ESITI</B></td>\n";
echo "<td><B>MODIFICA</B></td>\n";
echo "</tr>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		$row=mysql_fetch_row($rslt);
		$campaigns_id_list[$o] = $row[0];
		$campaigns_name_list[$o] = $row[1];
		$o++;
		}

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=22&campaign_id=$campaigns_id_list[$o]\">$campaigns_id_list[$o]</a></td>";
		echo "<td><font size=1> $campaigns_name_list[$o] </td>";
		echo "<td><font size=1> ";

		$stmt="SELECT status from vicidial_campaign_statuses where campaign_id='$campaigns_id_list[$o]' order by status";
		$rslt=mysql_query($stmt, $link);
		$campstatus_to_print = mysql_num_rows($rslt);
		$p=0;
		while ( ($campstatus_to_print > $p) and ($p < 10) )
			{
			$row=mysql_fetch_row($rslt);
			echo "$row[0] ";
			$p++;
			}
		if ($p<1) 
			{echo "<font color=grey><DEL>NESSUNO</DEL></font>";}
		echo "</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=22&campaign_id=$campaigns_id_list[$o]\">MODIFICA ESITI</a></td></tr>\n";
		$o++;
		}

echo "</TABLE></center>\n";
}


######################
# ADD=33 display all campaign hotkeys
######################
if ($ADD==33)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ELENCO HOTKEY CAMPAGNE:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr>\n";
echo "<td><B>CAMPAGNA</B></td>\n";
echo "<td><B>NOME</B></td>\n";
echo "<td><B>HOTKEY</B></td>\n";
echo "<td><B>MODIFICA</B></td>\n";
echo "</tr>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		$row=mysql_fetch_row($rslt);
		$campaigns_id_list[$o] = $row[0];
		$campaigns_name_list[$o] = $row[1];
		$o++;
		}

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=23&campaign_id=$campaigns_id_list[$o]\">$campaigns_id_list[$o]</a></td>";
		echo "<td><font size=1> $campaigns_name_list[$o] </td>";
		echo "<td><font size=1> ";

		$stmt="SELECT status from vicidial_campaign_hotkeys where campaign_id='$campaigns_id_list[$o]' order by status";
		$rslt=mysql_query($stmt, $link);
		$campstatus_to_print = mysql_num_rows($rslt);
		$p=0;
		while ( ($campstatus_to_print > $p) and ($p < 10) )
			{
			$row=mysql_fetch_row($rslt);
			echo "$row[0] ";
			$p++;
			}
		if ($p<1) 
			{echo "<font color=grey><DEL>NESSUNO</DEL></font>";}
		echo "</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=23&campaign_id=$campaigns_id_list[$o]\">MODIFICA HOTKEY</a></td></tr>\n";
		$o++;
		}

echo "</TABLE></center>\n";
}


######################
# ADD=35 display all campaign lead recycle entries
######################
if ($ADD==35)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ELENCO CONTATTI DA RICICLARE:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr>\n";
echo "<td><B>CAMPAGNA</B></td>\n";
echo "<td><B>NOME</B></td>\n";
echo "<td><B>ESITI DA RICICLARE</B></td>\n";
echo "<td><B>MODIFICA</B></td>\n";
echo "</tr>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		$row=mysql_fetch_row($rslt);
		$campaigns_id_list[$o] = $row[0];
		$campaigns_name_list[$o] = $row[1];
		$o++;
		}

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=25&campaign_id=$campaigns_id_list[$o]\">$campaigns_id_list[$o]</a></td>";
		echo "<td><font size=1> $campaigns_name_list[$o] </td>";
		echo "<td><font size=1> ";

		$stmt="SELECT status from vicidial_lead_recycle where campaign_id='$campaigns_id_list[$o]' order by status";
		$rslt=mysql_query($stmt, $link);
		$campstatus_to_print = mysql_num_rows($rslt);
		$p=0;
		while ( ($campstatus_to_print > $p) and ($p < 10) )
			{
			$row=mysql_fetch_row($rslt);
			echo "$row[0] ";
			$p++;
			}
		if ($p<1) 
			{echo "<font color=grey><DEL>NESSUNO</DEL></font>";}
		echo "</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=25&campaign_id=$campaigns_id_list[$o]\">MODIFICA CONTATTI DA RICICLARE</a></td></tr>\n";
		$o++;
		}

echo "</TABLE></center>\n";
}


######################
# ADD=36 display all campaign auto-alt dial entries
######################
if ($ADD==36)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ELENCO ESITI PER I QUALI CHIAMARE AUTOMATICAMENTE IL NUMERO ALTERNATIVO:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr>\n";
echo "<td><B>CAMPAGNA</B></td>\n";
echo "<td><B>NOME</B></td>\n";
echo "<td><B>CHIAMA-AUTO-NUM-ALTERN</B></td>\n";
echo "<td><B>MODIFICA</B></td>\n";
echo "</tr>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		$row=mysql_fetch_row($rslt);
		$campaigns_id_list[$o] = $row[0];
		$campaigns_name_list[$o] = $row[1];
		$o++;
		}

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=26&campaign_id=$campaigns_id_list[$o]\">$campaigns_id_list[$o]</a></td>";
		echo "<td><font size=1> $campaigns_name_list[$o] </td>";
		echo "<td><font size=1> ";

		$stmt="SELECT auto_alt_dial_statuses from vicidial_campaigns where campaign_id='$campaigns_id_list[$o]';";
		$rslt=mysql_query($stmt, $link);
		$campstatus_to_print = mysql_num_rows($rslt);
		$p=0;
		while ( ($campstatus_to_print > $p) and ($p < 10) )
			{
			$row=mysql_fetch_row($rslt);
			echo "$row[0] ";
			$p++;
			}
		if (strlen($row[0])<3) 
			{echo "<font color=grey><DEL>NESSUNO</DEL></font>";}
		echo "</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=26&campaign_id=$campaigns_id_list[$o]\">MODIFICA CHIAMA-AUTO-NUM-ALTERN</a></td></tr>\n";
		$o++;
		}

echo "</TABLE></center>\n";
}


######################
# ADD=37 display all campaign agent pause codes
######################
if ($ADD==37)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ELENCO CODICI PAUSA OPERATORE PER CAMPAGNA:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr>\n";
echo "<td><B>CAMPAGNA</B></td>\n";
echo "<td><B>NOME</B></td>\n";
echo "<td><B>CODICI PAUSA</B></td>\n";
echo "<td><B>MODIFICA</B></td>\n";
echo "</tr>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		$row=mysql_fetch_row($rslt);
		$campaigns_id_list[$o] = $row[0];
		$campaigns_name_list[$o] = $row[1];
		$o++;
		}

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=27&campaign_id=$campaigns_id_list[$o]\">$campaigns_id_list[$o]</a></td>";
		echo "<td><font size=1> $campaigns_name_list[$o] </td>";
		echo "<td><font size=1> ";

		$stmt="SELECT pause_code from vicidial_pause_codes where campaign_id='$campaigns_id_list[$o]' order by pause_code;";
		$rslt=mysql_query($stmt, $link);
		$campstatus_to_print = mysql_num_rows($rslt);
		$p=0;
		while ( ($campstatus_to_print > $p) and ($p < 10) )
			{
			$row=mysql_fetch_row($rslt);
			echo "$row[0] ";
			$p++;
			}
		if ($p<1) 
			{echo "<font color=grey><DEL>NESSUNO</DEL></font>";}
		echo "</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=27&campaign_id=$campaigns_id_list[$o]\">MODIFICA CODICI PAUSA</a></td></tr>\n";
		$o++;
		}

echo "</TABLE></center>\n";
}


######################
# ADD=39 display all campaign list mixes
######################
if ($ADD==39)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>LISTADOS DE LA MEZCLA DE LA LISTA DE LA CAMPAÑA:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr>\n";
echo "<td><B>CAMPAGNA</B></td>\n";
echo "<td><B>NOME</B></td>\n";
echo "<td><B>LIST MIX</B></td>\n";
echo "<td><B>MODIFICA</B></td>\n";
echo "</tr>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		$row=mysql_fetch_row($rslt);
		$campaigns_id_list[$o] = $row[0];
		$campaigns_name_list[$o] = $row[1];
		$o++;
		}

	$o=0;
	while ($campaigns_to_print > $o) 
		{
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=29&campaign_id=$campaigns_id_list[$o]\">$campaigns_id_list[$o]</a></td>";
		echo "<td><font size=1> $campaigns_name_list[$o] </td>";
		echo "<td><font size=1> ";

		$stmt="SELECT vcl_id from vicidial_campaigns_list_mix where campaign_id='$campaigns_id_list[$o]' order by status,vcl_id;";
		$rslt=mysql_query($stmt, $link);
		$campstatus_to_print = mysql_num_rows($rslt);
		$p=0;
		while ( ($campstatus_to_print > $p) and ($p < 10) )
			{
			$row=mysql_fetch_row($rslt);
			echo "$row[0] ";
			$p++;
			}
		if ($p<1) 
			{echo "<font color=grey><DEL>NESSUNO</DEL></font>";}
		echo "</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31&SUB=29&campaign_id=$campaigns_id_list[$o]\">MODIFY LIST MIX</a></td></tr>\n";
		$o++;
		}

echo "</TABLE></center>\n";
}





######################
# ADD=311 modify list info in the system
######################

if ($ADD==311)
{
	if ($LOGmodify_lists==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_lists where list_id='$list_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$campaign_id = $row[2];
	$active = $row[3];
	$list_description = $row[4];
	$list_changedate = $row[5];
	$list_lastcalldate = $row[6];

	# grab names of global statuses and statuses in the selected campaign
	$stmt="SELECT * from vicidial_statuses order by status";
	$rslt=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($statuses_to_print > $o) {
		$rowx=mysql_fetch_row($rslt);
		$statuses_list["$rowx[0]"] = "$rowx[1]";
		$o++;
	}

	$stmt="SELECT * from vicidial_campaign_statuses where campaign_id='$campaign_id' order by status";
	$rslt=mysql_query($stmt, $link);
	$Cstatuses_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($Cstatuses_to_print > $o) {
		$rowx=mysql_fetch_row($rslt);
		$statuses_list["$rowx[0]"] = "$rowx[1]";
		$o++;
	}
	# end grab status names


	echo "<br>MODIFICA I DATI DELLA LISTA: $row[0]<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=411>\n";
	echo "<input type=hidden name=list_id value=\"$row[0]\">\n";
	echo "<input type=hidden name=old_campaign_id value=\"$row[2]\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Lista: </td><td align=left><b>$row[0]</b>$NWB#vicidial_lists-list_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Lista: </td><td align=left><input type=text name=list_name size=20 maxlength=20 value=\"$row[1]\">$NWB#vicidial_lists-list_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Descrizione Lista: </td><td align=left><input type=text name=list_description size=30 maxlength=255 value=\"$list_description\">$NWB#vicidial_lists-list_description$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=34&campaign_id=$campaign_id\">Campagna</a>: </td><td align=left><select size=1 name=campaign_id>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);
	$campaigns_list='';
	$o=0;
	while ($campaigns_to_print > $o) {
		$rowx=mysql_fetch_row($rslt);
		$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
	}
	echo "$campaigns_list";
	echo "<option SELECTED>$campaign_id</option>\n";
	echo "</select>$NWB#vicidial_lists-campaign_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option SELECTED>$active</option></select>$NWB#vicidial_lists-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Resetta questa lista allo stato di `contatti non chiamati`: </td><td align=left><select size=1 name=reset_list><option>Y</option><option SELECTED>N</option></select>$NWB#vicidial_lists-reset_list$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Data Modifica Lista: </td><td align=left>$list_changedate &nbsp; $NWB#vicidial_lists-list_changedate$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Data Ultima Telefonata </td><td align=left>$list_lastcalldate &nbsp; $NWB#vicidial_lists-list_lastcalldate$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";

	echo "<center>\n";
	echo "<br><b>ESITI IN QUESTA LISTA:</b><br>\n";
	echo "<TABLE width=500 cellspacing=3>\n";
	echo "<tr><td>ESITO</td><td>NOME ESITO</td><td>CHIAMATI</td><td>NON CHIAMATI</td></tr>\n";

	$leads_in_list = 0;
	$leads_in_list_N = 0;
	$leads_in_list_Y = 0;
	$stmt="SELECT status,called_since_last_reset,count(*) from vicidial_list where list_id='$list_id' group by status,called_since_last_reset order by status,called_since_last_reset";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rslt);

	$o=0;
	$lead_list['count'] = 0;
	$lead_list['Y_count'] = 0;
	$lead_list['N_count'] = 0;
	while ($statuses_to_print > $o) 
	{
	    $rowx=mysql_fetch_row($rslt);
	    
	    $lead_list['count'] = ($lead_list['count'] + $rowx[2]);
	    if ($rowx[1] == 'N') 
	    {
		$since_reset = 'N';
		$since_resetX = 'Y';
	    }
	    else 
	    {
		$since_reset = 'Y';
		$since_resetX = 'N';
	    } 
	    $lead_list[$since_reset][$rowx[0]] = ($lead_list[$since_reset][$rowx[0]] + $rowx[2]);
	    $lead_list[$since_reset.'_count'] = ($lead_list[$since_reset.'_count'] + $rowx[2]);
	    #If opposite side is not set, it may not in the future so give it a value of zero
	    if (!isset($lead_list[$since_resetX][$rowx[0]])) 
	    {
		$lead_list[$since_resetX][$rowx[0]]=0;
	    }
	    $o++;
	}
 
	$o=0;
	if ($lead_list['count'] > 0)
	{
		while (list($dispo,) = each($lead_list[$since_reset]))
		{

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		if ($dispo == 'CBHOLD')
			{
			$CLB="<a href=\"$PHP_SELF?ADD=811&list_id=$list_id\">";
			$CLE="</a>";
			}
		else
			{
			$CLB='';
			$CLE='';
			}

		echo "<tr $bgcolor><td><font size=1>$CLB$dispo$CLE</td><td><font size=1>$statuses_list[$dispo]</td><td><font size=1>".$lead_list['Y'][$dispo]."</td><td><font size=1>".$lead_list['N'][$dispo]." </td></tr>\n";
		$o++;
		}
	}

	echo "<tr><td colspan=2><font size=1>SUBTOTALI</td><td><font size=1>$lead_list[Y_count]</td><td><font size=1>$lead_list[N_count]</td></tr>\n";
	echo "<tr bgcolor=\"#9BB9FB\"><td><font size=1>TOTALE</td><td colspan=3 align=center><font size=1>$lead_list[count]</td></tr>\n";

	echo "</table></center><br>\n";
	unset($lead_list);


	echo "<center>\n";
	echo "<br><b>FUSI ORARI IN QUESTA LISTA:</b><br>\n";
	echo "<TABLE width=500 cellspacing=3>\n";
	echo "<tr><td>FUSO ORARIO ATTUALE (ora locale)</td><td>CHIAMATI</td><td>NON CHIAMATI</td></tr>\n";

	$stmt="SELECT gmt_offset_now,called_since_last_reset,count(*) from vicidial_list where list_id='$list_id' group by gmt_offset_now,called_since_last_reset order by gmt_offset_now,called_since_last_reset";
	$rslt=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rslt);

	$o=0;
	$plus='+';
	$lead_list['count'] = 0;
	$lead_list['Y_count'] = 0;
	$lead_list['N_count'] = 0;
	while ($statuses_to_print > $o) 
	{
	    $rowx=mysql_fetch_row($rslt);
	    
	    $lead_list['count'] = ($lead_list['count'] + $rowx[2]);
	    if ($rowx[1] == 'N') 
	    {
		$since_reset = 'N';
		$since_resetX = 'Y';
	    }
	    else 
	    {
		$since_reset = 'Y';
		$since_resetX = 'N';
	    } 
	    $lead_list[$since_reset][$rowx[0]] = ($lead_list[$since_reset][$rowx[0]] + $rowx[2]);
	    $lead_list[$since_reset.'_count'] = ($lead_list[$since_reset.'_count'] + $rowx[2]);
	    #If opposite side is not set, it may not in the future so give it a value of zero
	    if (!isset($lead_list[$since_resetX][$rowx[0]])) 
	    {
		$lead_list[$since_resetX][$rowx[0]]=0;
	    }
	    $o++;
	}

	if ($lead_list['count'] > 0)
	{
		while (list($tzone,) = each($lead_list[$since_reset]))
		{
		$LOCALzone=3600 * $tzone;
		$LOCALdate=gmdate("D M Y H:i", time() + $LOCALzone);

		if ($tzone >= 0) {$DISPtzone = "$plus$tzone";}
		else {$DISPtzone = "$tzone";}
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

			echo "<tr $bgcolor><td><font size=1>".$DISPtzone." &nbsp; &nbsp; ($LOCALdate)</td><td><font size=1>".$lead_list['Y'][$tzone]."</td><td><font size=1>".$lead_list['N'][$tzone]."</td></tr>\n";
		}
	}

	echo "<tr><td><font size=1>SUBTOTALI</td><td><font size=1>$lead_list[Y_count]</td><td><font size=1>$lead_list[N_count]</td></tr>\n";
	echo "<tr bgcolor=\"#9BB9FB\"><td><font size=1>TOTALE</td><td colspan=2 align=center><font size=1>$lead_list[count]</td></tr>\n";

	echo "</table></center><br>\n";
	unset($lead_list);



	$leads_in_list = 0;
	$leads_in_list_N = 0;
	$leads_in_list_Y = 0;
	$stmt="SELECT status,called_count,count(*) from vicidial_list where list_id='$list_id' group by status,called_count order by status,called_count";
	$rslt=mysql_query($stmt, $link);
	$status_called_to_print = mysql_num_rows($rslt);

	$o=0;
	$sts=0;
	$first_row=1;
	$all_called_first=1000;
	$all_called_last=0;
	while ($status_called_to_print > $o) 
	{
	$rowx=mysql_fetch_row($rslt);
	$leads_in_list = ($leads_in_list + $rowx[2]);
	$count_statuses[$o]			= "$rowx[0]";
	$count_called[$o]			= "$rowx[1]";
	$count_count[$o]			= "$rowx[2]";
	$all_called_count[$rowx[1]] = ($all_called_count[$rowx[1]] + $rowx[2]);

	if ( (strlen($status[$sts]) < 1) or ($status[$sts] != "$rowx[0]") )
		{
		if ($first_row) {$first_row=0;}
		else {$sts++;}
		$status[$sts] = "$rowx[0]";
		$status_called_first[$sts] = "$rowx[1]";
		if ($status_called_first[$sts] < $all_called_first) {$all_called_first = $status_called_first[$sts];}
		}
	$leads_in_sts[$sts] = ($leads_in_sts[$sts] + $rowx[2]);
	$status_called_last[$sts] = "$rowx[1]";
	if ($status_called_last[$sts] > $all_called_last) {$all_called_last = $status_called_last[$sts];}

	$o++;
	}




	echo "<center>\n";
	echo "<br><b>CHIAMATE EFFETTUATE IN QUESTA LISTA:</b><br>\n";
	echo "<TABLE width=500 cellspacing=1>\n";
	echo "<tr><td align=left><font size=1>ESITO</td><td align=center><font size=1>NOME ESITO</td>";
	$first = $all_called_first;
	while ($first <= $all_called_last)
		{
		if (eregi("1$|3$|5$|7$|9$", $first)) {$AB='bgcolor="#AFEEEE"';} 
		else{$AB='bgcolor="#E0FFFF"';}
		echo "<td align=center $AB><font size=1>$first</td>";
		$first++;
		}
	echo "<td align=center><font size=1>SUBTOTALE</td></tr>\n";

		$sts=0;
		$statuses_called_to_print = count($status);
		while ($statuses_called_to_print > $sts) 
		{
		$Pstatus = $status[$sts];
		if (eregi("1$|3$|5$|7$|9$", $sts))
			{$bgcolor='bgcolor="#B9CBFD"';   $AB='bgcolor="#9BB9FB"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';   $AB='bgcolor="#B9CBFD"';}
	#	echo "$status[$sts]|$status_called_first[$sts]|$status_called_last[$sts]|$leads_in_sts[$sts]|\n";
	#	echo "$status[$sts]|";
		echo "<tr $bgcolor><td><font size=1>$Pstatus</td><td><font size=1>$statuses_list[$Pstatus]</td>";

		$first = $all_called_first;
		while ($first <= $all_called_last)
			{
			if (eregi("1$|3$|5$|7$|9$", $sts))
				{
				if (eregi("1$|3$|5$|7$|9$", $first)) {$AB='bgcolor="#9BB9FB"';} 
				else{$AB='bgcolor="#B9CBFD"';}
				}
			else
				{
				if (eregi("0$|2$|4$|6$|8$", $first)) {$AB='bgcolor="#9BB9FB"';} 
				else{$AB='bgcolor="#B9CBFD"';}
				}

			$called_printed=0;
			$o=0;
			while ($status_called_to_print > $o) 
				{
				if ( ($count_statuses[$o] == "$Pstatus") and ($count_called[$o] == "$first") )
					{
					$called_printed++;
					echo "<td $AB><font size=1> $count_count[$o]</td>";
					}


				$o++;
				}
			if (!$called_printed) 
				{echo "<td $AB><font size=1> &nbsp;</td>";}
			$first++;
			}
		echo "<td><font size=1>$leads_in_sts[$sts]</td></tr>\n\n";

		$sts++;
		}

	echo "<tr><td align=center colspan=2><b><font size=1>TOTALE</td>";
	$first = $all_called_first;
	while ($first <= $all_called_last)
		{
		if (eregi("1$|3$|5$|7$|9$", $first)) {$AB='bgcolor="#AFEEEE"';} 
		else{$AB='bgcolor="#E0FFFF"';}
		echo "<td align=center $AB><b><font size=1>$all_called_count[$first]</td>";
		$first++;
		}
	echo "<td align=center><b><font size=1>$leads_in_list</td></tr>\n";

	echo "</table></center><br>\n";





	echo "<center><b>\n";

	echo "<br><br><a href=\"$PHP_SELF?ADD=811&list_id=$list_id\">Clicca qui per visualizzare tutti i richiami in attesa in questa lista</a><BR><BR>\n";

	if ($LOGdelete_lists > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=511&list_id=$list_id\">CANCELLA QUESTA LISTA</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}



######################
# ADD=3111 modify in-group info in the system
######################

if ($ADD==3111)
{
	if ($LOGmodify_ingroups==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_inbound_groups where group_id='$group_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$group_name =				$row[1];
	$group_color =				$row[2];
	$active =					$row[3];
	$web_form_address =			$row[4];
	$voicemail_ext =			$row[5];
	$next_agent_call =			$row[6];
	$fronter_display =			$row[7];
	$script_id =				$row[8];
	$get_call_launch =			$row[9];
	$xferconf_a_dtmf =			$row[10];
	$xferconf_a_number =		$row[11];
	$xferconf_b_dtmf =			$row[12];
	$xferconf_b_number =		$row[13];
	$drop_call_seconds =		$row[14];
	$drop_action =				$row[15];
	$drop_exten =				$row[16];
	$call_time_id =				$row[17];
	$after_hours_action =		$row[18];
	$after_hours_message_filename =	$row[19];
	$after_hours_exten =		$row[20];
	$after_hours_voicemail =	$row[21];
	$welcome_message_filename =	$row[22];
	$moh_context =				$row[23];
	$onhold_prompt_filename =	$row[24];
	$prompt_interval =			$row[25];
	$agent_alert_exten =		$row[26];
	$agent_alert_delay =		$row[27];
	$default_xfer_group =		$row[28];
	$queue_priority =			$row[29];
	$drop_inbound_group =		$row[30];
	$ingroup_recording_override = $row[31];
	$ingroup_rec_filename =		$row[32];
	$afterhours_xfer_group =	$row[33];
	$qc_enabled =				$row[34];
	$qc_statuses =				$row[35];
	$qc_shift_id =				$row[36];
	$qc_get_record_launch =		$row[37];
	$qc_show_recording =		$row[38];
	$qc_web_form_address =		$row[39];
	$qc_script =				$row[40];
	$play_place_in_line = 		$row[41];
	$play_estimate_hold_time = 	$row[42];
	$hold_time_option = 		$row[43];
	$hold_time_option_seconds = $row[44];
	$hold_time_option_exten = 	$row[45];
	$hold_time_option_voicemail = 	$row[46];
	$hold_time_option_xfer_group = 	$row[47];
	$hold_time_option_callback_filename =	$row[48];
	$hold_time_option_callback_list_id = 	$row[49];
	$hold_recall_xfer_group = 	$row[50];
	$no_delay_call_route = 		$row[51];
	$play_welcome_message = 	$row[52];

	##### get in-groups listings for dynamic pulldown
	$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT') order by group_id";
	$rslt=mysql_query($stmt, $link);
	$Xgroups_to_print = mysql_num_rows($rslt);
	$Xgroups_menu='';
	$Xgroups_selected=0;
	$Dgroups_menu='';
	$Dgroups_selected=0;
	$Agroups_menu='';
	$Agroups_selected=0;
	$Hgroups_menu='';
	$Hgroups_selected=0;
	$Tgroups_menu='';
	$Tgroups_selected=0;
	$o=0;
	while ($Xgroups_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		$Xgroups_menu .= "<option ";
		$Dgroups_menu .= "<option ";
		$Agroups_menu .= "<option ";
		$Tgroups_menu .= "<option ";
		$Hgroups_menu .= "<option ";
		if ($default_xfer_group == "$rowx[0]") 
			{
			$Xgroups_menu .= "SELECTED ";
			$Xgroups_selected++;
			}
		if ($drop_inbound_group == "$rowx[0]") 
			{
			$Dgroups_menu .= "SELECTED ";
			$Dgroups_selected++;
			}
		if ($afterhours_xfer_group == "$rowx[0]") 
			{
			$Agroups_menu .= "SELECTED ";
			$Agroups_selected++;
			}
		if ($hold_time_option_xfer_group == "$rowx[0]") 
			{
			$Tgroups_menu .= "SELECTED ";
			$Tgroups_selected++;
			}
		if ($hold_recall_xfer_group == "$rowx[0]") 
			{
			$Hgroups_menu .= "SELECTED ";
			$Hgroups_selected++;
			}
		$Xgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$Dgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		if ($group_id!=$rowx[0])
			{
			$Agroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$Tgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$Hgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			}
		$o++;
		}
	if ($Xgroups_selected < 1) 
		{$Xgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
	else 
		{$Xgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}
	if ($Dgroups_selected < 1) 
		{$Dgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
	else 
		{$Dgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}
	if ($Agroups_selected < 1) 
		{$Agroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
	else 
		{$Agroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}
	if ($Tgroups_selected < 1) 
		{$Tgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
	else 
		{$Tgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}
	if ($Hgroups_selected < 1) 
		{$Hgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
	else 
		{$Hgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}


	echo "<br>MODIFICAR UN REGISTRO DE LOS GRUPOS: $row[0]<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=4111>\n";
	echo "<input type=hidden name=group_id value=\"$row[0]\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Gruppo: </td><td align=left><b>$row[0]</b>$NWB#vicidial_inbound_groups-group_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Gruppo: </td><td align=left><input type=text name=group_name size=30 maxlength=30 value=\"$row[1]\">$NWB#vicidial_inbound_groups-group_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Colore Gruppo: </td><td align=left bgcolor=\"$row[2]\" id=\"group_color_td\"><input type=text name=group_color size=7 maxlength=7 value=\"$row[2]\">$NWB#vicidial_inbound_groups-group_color$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option SELECTED>$active</option></select>$NWB#vicidial_inbound_groups-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left><input type=text name=web_form_address size=50 maxlength=255 value=\"$web_form_address\">$NWB#vicidial_inbound_groups-web_form_address$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Operatore Da Scegliere Per La Chiamata Successiva: </td><td align=left><select size=1 name=next_agent_call><option >random</option><option>oldest_call_start</option><option>oldest_call_finish</option><option>overall_user_level</option><option>inbound_group_rank</option><option>campaign_rank</option><option>fewest_calls</option><option>fewest_calls_campaign</option><option SELECTED>$next_agent_call</option></select>$NWB#vicidial_inbound_groups-next_agent_call$NWE</td></tr>\n";

	echo "<tr bgcolor=#BDFFBD><td align=right>Queue Priority: </td><td align=left><select size=1 name=queue_priority>\n";
	$n=99;
	while ($n>=-99)
		{
		$dtl = 'Even';
		if ($n<0) {$dtl = 'Lower';}
		if ($n>0) {$dtl = 'Higher';}
		if ($n == $queue_priority) 
			{echo "<option SELECTED value=\"$n\">$n - $dtl</option>\n";}
		else
			{echo "<option value=\"$n\">$n - $dtl</option>\n";}
		$n--;
		}
	echo "</select> $NWB#vicidial_inbound_groups-queue_priority$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Mostrar Fronter: </td><td align=left><select size=1 name=fronter_display><option>Y</option><option>N</option><option SELECTED>$fronter_display</option></select>$NWB#vicidial_inbound_groups-fronter_display$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=3111111&script_id=$script_id\">Script</a>: </td><td align=left><select size=1 name=script_id>\n";
	echo "$scripts_list";
	echo "<option selected value=\"$script_id\">$script_id - $scriptname_list[$script_id]</option>\n";
	echo "</select>$NWB#vicidial_inbound_groups-ingroup_script$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Esegui all`avvio della telefonata: </td><td align=left><select size=1 name=get_call_launch><option selected>NESSUNO</option><option>SCRIPT</option><option>WEBFORM</option><option selected>$get_call_launch</option></select>$NWB#vicidial_inbound_groups-get_call_launch$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Transfiera -Conf DTMF 1: </td><td align=left><input type=text name=xferconf_a_dtmf size=20 maxlength=50 value=\"$xferconf_a_dtmf\">$NWB#vicidial_inbound_groups-xferconf_a_dtmf$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Transfiera -Conf El Número 1: </td><td align=left><input type=text name=xferconf_a_number size=20 maxlength=50 value=\"$xferconf_a_number\">$NWB#vicidial_inbound_groups-xferconf_a_dtmf$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Transfiera -Conf DTMF 2: </td><td align=left><input type=text name=xferconf_b_dtmf size=20 maxlength=50 value=\"$xferconf_b_dtmf\">$NWB#vicidial_inbound_groups-xferconf_a_dtmf$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Transfiera -Conf El Número 2: </td><td align=left><input type=text name=xferconf_b_number size=20 maxlength=50 value=\"$xferconf_b_number\">$NWB#vicidial_inbound_groups-xferconf_a_dtmf$NWE</td></tr>\n";

	echo "<tr bgcolor=#99FFCC><td align=right>Secondi Abbattimento Telefonata: </td><td align=left><input type=text name=drop_call_seconds size=5 maxlength=4 value=\"$drop_call_seconds\">$NWB#vicidial_inbound_groups-drop_call_seconds$NWE</td></tr>\n";

	echo "<tr bgcolor=#99FFCC><td align=right>Drop Action: </td><td align=left><select size=1 name=drop_action><option>HANGUP</option><option>MESSAGE</option><option>VOICEMAIL</option><option>IN_GROUP</option><option SELECTED>$drop_action</option></select>$NWB#vicidial_inbound_groups-drop_action$NWE</td></tr>\n";

	echo "<tr bgcolor=#99FFCC><td align=right>Gota Exten: </td><td align=left><input type=text name=drop_exten size=10 maxlength=20 value=\"$drop_exten\">$NWB#vicidial_inbound_groups-drop_exten$NWE</td></tr>\n";

	echo "<tr bgcolor=#99FFCC><td align=right>Casella Vocale: </td><td align=left><input type=text name=voicemail_ext size=10 maxlength=10 value=\"$voicemail_ext\">$NWB#vicidial_inbound_groups-voicemail_ext$NWE</td></tr>\n";

	echo "<tr bgcolor=#99FFCC><td align=right>Drop Transfer Gruppo: </td><td align=left><select size=1 name=drop_inbound_group>";
	echo "$Dgroups_menu";
	echo "</select>$NWB#vicidial_inbound_groups-drop_inbound_group$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=311111111&call_time_id=$call_time_id\">Tempo Chiamata: </a></td><td align=left><select size=1 name=call_time_id>\n";
	echo "$call_times_list";
	echo "<option selected value=\"$call_time_id\">$call_time_id - $call_timename_list[$call_time_id]</option>\n";
	echo "</select>$NWB#vicidial_inbound_groups-call_time_id$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Despue`s De la Accio`n De las Horas:</td><td align=left><select size=1 name=after_hours_action><option>HANGUP</option><option>MESSAGE</option><option>INTERNO</option><option>VOICEMAIL</option><option>IN_GROUP</option><option SELECTED>$after_hours_action</option></select>$NWB#vicidial_inbound_groups-after_hours_action$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Despue`s De Nombre de fichero Del Mensaje De las Horas:</td><td align=left><input type=text name=after_hours_message_filename size=20 maxlength=50 value=\"$after_hours_message_filename\">$NWB#vicidial_inbound_groups-after_hours_message_filename$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Despue`s De la Extension De las Horas:</td><td align=left><input type=text name=after_hours_exten size=10 maxlength=20 value=\"$after_hours_exten\">$NWB#vicidial_inbound_groups-after_hours_exten$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Despue`s De las Horas Casella Vocale:</td><td align=left><input type=text name=after_hours_voicemail size=10 maxlength=20 value=\"$after_hours_voicemail\">$NWB#vicidial_inbound_groups-after_hours_voicemail$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>After Hours Transfer Gruppo: </td><td align=left><select size=1 name=afterhours_xfer_group>";
	echo "$Agroups_menu";
	echo "</select>$NWB#vicidial_inbound_groups-afterhours_xfer_group$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Nombre de fichero Agradable Del Mensaje:</td><td align=left><input type=text name=welcome_message_filename size=20 maxlength=50 value=\"$welcome_message_filename\">$NWB#vicidial_inbound_groups-welcome_message_filename$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Play Benvenuti Message: </td><td align=left><select size=1 name=play_welcome_message><option>ALWAYS</option><option>NEVER</option><option>IF_WAIT_ONLY</option><option>YES_UNLESS_NODELAY</option><option SELECTED>$play_welcome_message</option></select>$NWB#vicidial_inbound_groups-play_welcome_message$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Context Musica di Attesa:</td><td align=left><input type=text name=moh_context size=10 maxlength=20 value=\"$moh_context\">$NWB#vicidial_inbound_groups-moh_context$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>En Nombre de fichero Del Aviso Del Asimiento:</td><td align=left><input type=text name=onhold_prompt_filename size=20 maxlength=50 value=\"$onhold_prompt_filename\">$NWB#vicidial_inbound_groups-onhold_prompt_filename$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>En Intervalo Del Aviso Del Asimiento:</td><td align=left><input type=text name=prompt_interval size=5 maxlength=5 value=\"$prompt_interval\">$NWB#vicidial_inbound_groups-prompt_interval$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Play Place in Line: </td><td align=left><select size=1 name=play_place_in_line><option>Y</option><option>N</option><option SELECTED>$play_place_in_line</option></select>$NWB#vicidial_inbound_groups-play_place_in_line$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Play Estimated Hold Time: </td><td align=left><select size=1 name=play_estimate_hold_time><option>Y</option><option>N</option><option SELECTED>$play_estimate_hold_time</option></select>$NWB#vicidial_inbound_groups-play_estimate_hold_time$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Hold Time Option: </td><td align=left><select size=1 name=hold_time_option><option>NESSUNO</option><option>INTERNO</option><option>VOICEMAIL</option><option>IN_GROUP</option><option>CALLERID_CALLBACK</option><option>DROP_ACTION</option><option>PRESS_VMAIL</option><option SELECTED>$hold_time_option</option></select>$NWB#vicidial_inbound_groups-hold_time_option$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Hold Time Option Seconds: </td><td align=left><input type=text name=hold_time_option_seconds size=5 maxlength=5 value=\"$hold_time_option_seconds\">$NWB#vicidial_inbound_groups-hold_time_option_seconds$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Hold Time Option Extension: </td><td align=left><input type=text name=hold_time_option_exten size=20 maxlength=20 value=\"$hold_time_option_exten\">$NWB#vicidial_inbound_groups-hold_time_option_exten$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Hold Time Option Casella Vocale: </td><td align=left><input type=text name=hold_time_option_voicemail size=20 maxlength=20 value=\"$hold_time_option_voicemail\">$NWB#vicidial_inbound_groups-hold_time_option_voicemail$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Hold Time Option Transfer In-Gruppo: </td><td align=left><select size=1 name=hold_time_option_xfer_group>";
	echo "$Tgroups_menu";
	echo "</select>$NWB#vicidial_inbound_groups-hold_time_option_xfer_group$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Hold Time Option Callback Filename: </td><td align=left><input type=text name=hold_time_option_callback_filename size=20 maxlength=20 value=\"$hold_time_option_callback_filename\">$NWB#vicidial_inbound_groups-hold_time_option_callback_filename$NWE</td></tr>\n";

	echo "<tr bgcolor=#CCFFFF><td align=right>Hold Time Option Callback ID Lista: </td><td align=left><input type=text name=hold_time_option_callback_list_id size=14 maxlength=14 value=\"$hold_time_option_callback_list_id\">$NWB#vicidial_inbound_groups-hold_time_option_callback_list_id$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Extension Alerta Del Agente:</td><td align=left><input type=text name=agent_alert_exten size=10 maxlength=20 value=\"$agent_alert_exten\">$NWB#vicidial_inbound_groups-agent_alert_exten$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>La Alarma Del Agente Retrasa:</td><td align=left><input type=text name=agent_alert_delay size=6 maxlength=6 value=\"$agent_alert_delay\">$NWB#vicidial_inbound_groups-agent_alert_delay$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Grupo De la Transferencia Del Defecto:</td><td align=left><select size=1 name=default_xfer_group>";
	echo "$Xgroups_menu";
	echo "</select>$NWB#vicidial_inbound_groups-default_xfer_group$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>Hold Recall Transfer In-Gruppo: </td><td align=left><select size=1 name=hold_recall_xfer_group>";
	echo "$Hgroups_menu";
	echo "</select>$NWB#vicidial_inbound_groups-hold_recall_xfer_group$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>No Delay Call Route: </td><td align=left><select size=1 name=no_delay_call_route><option>Y</option><option>N</option><option SELECTED>$no_delay_call_route</option></select>$NWB#vicidial_inbound_groups-no_delay_call_route$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>In-Group Recording Override: </td><td align=left><select size=1 name=ingroup_recording_override><option>DISABLED</option><option>NEVER</option><option>ONDEMAND</option><option>ALLCALLS</option><option>ALLFORCE</option><option SELECTED>$ingroup_recording_override</option></select>$NWB#vicidial_inbound_groups-ingroup_recording_override$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>In-Group Recording Filename: </td><td align=left><input type=text name=ingroup_rec_filename size=50 maxlength=50 value=\"$ingroup_rec_filename\">$NWB#vicidial_inbound_groups-ingroup_rec_filename$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2> &nbsp; </td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2> Inbound Group QC Settings: </td></tr>\n";

	##### get status listings for dynamic pulldown
	$qc_statuses = preg_replace("/^ | -$/","",$qc_statuses);
	$QCstatuses = explode(" ", $qc_statuses);
	$QCs_to_print = (count($QCstatuses) -0);
	$stmt="SELECT * from vicidial_statuses where status NOT IN('QUEUE','INCALL') order by status";
	$rslt=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rslt);
	$qc_statuses_list='';

	$o=0;
	while ($statuses_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		$qc_statuses_list .= "<input type=\"checkbox\" name=\"qc_statuses[]\" value=\"$rowx[0]\"";
		$p=0;
		while ($p < $QCs_to_print)
			{
			if ($rowx[0] == $QCstatuses[$p]) 
				{
				$qc_statuses_list .= " CHECKED";
				}
			$p++;
			}
		$qc_statuses_list .= "> $rowx[0] - $rowx[1]<BR>\n";

		$o++;
		}

	$stmt="SELECT distinct(status),status_name from vicidial_campaign_statuses order by status";
	$rslt=mysql_query($stmt, $link);
	$Cstatuses_to_print = mysql_num_rows($rslt);

	$o=0;
	while ($Cstatuses_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		if (!ereg("\"$rowx[0]\"",$qc_statuses_list))
			{
			$qc_statuses_list .= "<input type=\"checkbox\" name=\"qc_statuses[]\" value=\"$rowx[0]\"";
			$p=0;
			while ($p < $QCs_to_print)
				{
				if ($rowx[0] == $QCstatuses[$p]) 
					{
					$qc_statuses_list .= " CHECKED";
					}
				$p++;
				}
			$qc_statuses_list .= "> $rowx[0] - $rowx[1]<BR>\n";
			}
		$o++;
		}

	##### get scripts listings for pulldown
	$stmt="SELECT script_id,script_name from vicidial_scripts order by script_id";
	$rslt=mysql_query($stmt, $link);
	$scripts_to_print = mysql_num_rows($rslt);
	$QCscripts_list="";
	$o=0;
	while ($scripts_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$QCscripts_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$scriptname_list["$rowx[0]"] = "$rowx[1]";
		$o++;
		}
	##### get shifts listings for pulldown
	$stmt="SELECT shift_id,shift_name from vicidial_shifts order by shift_id";
	$rslt=mysql_query($stmt, $link);
	$shifts_to_print = mysql_num_rows($rslt);
	$QCshifts_list="";
	$o=0;
	while ($shifts_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$QCshifts_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$shiftname_list["$rowx[0]"] = "$rowx[1]";
		$o++;
		}

	echo "<tr bgcolor=#9BB9FB><td align=right>QC Enabled: </td><td><select size=1 name=qc_enabled><option>Y</option><option>N</option><option SELECTED>$qc_enabled</option></select> $NWB#vicidial_inbound_groups-qc_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#9BB9FB><td align=right>QC Esiti: <BR> $NWB#vicidial_inbound_groups-qc_statuses$NWE</td><td>$qc_statuses_list</td></tr>\n";
	echo "<tr bgcolor=#B9CBFD><td align=right>QC WebForm: </td><td align=left><input type=text name=qc_web_form_address size=50 maxlength=255 value=\"$qc_web_form_address\">$NWB#vicidial_inbound_groups-qc_web_form_address$NWE</td></tr>\n";

	echo "<tr bgcolor=#B9CBFD><td align=right><a href=\"$PHP_SELF?ADD=3111111&script_id=$script_id\">QC Script</a>: </td><td align=left><select size=1 name=qc_script>\n";
	echo "$QCscripts_list";
	echo "<option selected value=\"$qc_script\">$qc_script - $scriptname_list[$qc_script]</option>\n";
	echo "</select>$NWB#vicidial_inbound_groups-qc_script$NWE</td></tr>\n";

	echo "<tr bgcolor=#B9CBFD><td align=right><a href=\"$PHP_SELF?ADD=331111111&shift_id=$qc_shift_id\">QC Shift</a>: </td><td align=left><select size=1 name=qc_shift_id>\n";
	echo "$QCshifts_list";
	echo "<option selected value=\"$qc_shift_id\">$qc_shift_id - $shiftname_list[$qc_shift_id]</option>\n";
	echo "</select>$NWB#vicidial_inbound_groups-qc_shift_id$NWE</td></tr>\n";

	echo "<tr bgcolor=#B9CBFD><td align=right>QC Get Record Launch: </td><td><select size=1 name=qc_get_record_launch><option>NESSUNO</option><option>SCRIPT</option><option>WEBFORM</option><option>QCSCRIPT</option><option>QCWEBFORM</option><option SELECTED>$qc_get_record_launch</option></select> $NWB#vicidial_inbound_groups-qc_get_record_launch$NWE</td></tr>\n";
	echo "<tr bgcolor=#B9CBFD><td align=right>QC Show Recording: </td><td><select size=1 name=qc_show_recording><option>Y</option><option>N</option><option SELECTED>$qc_show_recording</option></select> $NWB#vicidial_inbound_groups-qc_show_recording$NWE</td></tr>\n";

	echo "<tr bgcolor=#B9CBFD><td align=center colspan=2><input type=submit name=submit value=INVIA></td></tr>\n";
	echo "</table>\n";
	echo "<BR></center></FORM><br>\n";


	### list of agent rank or skill-level for this inbound group
	echo "<center>\n";
	echo "<br><b>CLASSIFICA OPERATORI PER QUESTO GRUPPO INBOUND:</b><br>\n";
	echo "<TABLE width=400 cellspacing=3>\n";
	echo "<tr><td>UTENTE</td><td> &nbsp; &nbsp; CLASSIFICA</td><td> &nbsp; &nbsp; CHIAMATE OGGI</td></tr>\n";

		$stmt="SELECT user,group_rank,calls_today from vicidial_inbound_group_agents where group_id='$group_id'";
		$rsltx=mysql_query($stmt, $link);
		$users_to_print = mysql_num_rows($rsltx);

		$o=0;
		while ($users_to_print > $o) {
			$rowx=mysql_fetch_row($rsltx);
			$o++;

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=3&user=$rowx[0]\">$rowx[0]</a></td><td><font size=1>$rowx[1]</td><td><font size=1>$rowx[2]</td></tr>\n";
		}

	echo "</table></center><br>\n";

	echo "</table></center><br>\n";

	echo "<a href=\"./AST_CLOSERstats.php?group=$group_id\">Clicca qui per visualizzare un report per questo gruppo inbound</a><BR><BR>\n";

	echo "<center><b>\n";

	if ($LOGdelete_ingroups > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=53&campaign_id=$group_id&stage=IN\">EMERGENCY VDAC CLEAR FOR THIS IN-GROUP</a><BR><BR>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=5111&group_id=$group_id\">CANCELLA QUESTO GRUPPO INBOUND</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}



######################
# ADD=3311 modify did info in the system
######################

if ($ADD==3311)
{
	if ($LOGmodify_dids==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_inbound_dids where did_id='$did_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$did_id = 				$row[0];
	$did_pattern = 			$row[1];
	$did_description = 		$row[2];
	$did_active = 			$row[3];
	$did_route = 			$row[4];
	$extension = 			$row[5];
	$exten_context = 		$row[6];
	$voicemail_ext = 		$row[7];
	$phone = 				$row[8];
	$server_ip = 			$row[9];
	$user = 				$row[10];
	$user_unavailable_action = 	$row[11];
	$user_route_settings_ingroup = 	$row[12];
	$group_id = 			$row[13];
	$call_handle_method = 	$row[14];
	$agent_search_method =	$row[15];
	$list_id = 				$row[16];
	$campaign_id = 			$row[17];
	$phone_code = 			$row[18];


	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rslt);
	$campaigns_list='';
	$o=0;
	while ($campaigns_to_print > $o) {
		$rowx=mysql_fetch_row($rslt);
		$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
	}

	##### get in-groups listings for dynamic pulldown
	$stmt="SELECT group_id,group_name from vicidial_inbound_groups order by group_id";
	$rslt=mysql_query($stmt, $link);
	$Xgroups_to_print = mysql_num_rows($rslt);
	$Xgroups_menu='';
	$Xgroups_selected=0;
	$o=0;
	while ($Xgroups_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		$Xgroups_menu .= "<option ";
		if ($user_route_settings_ingroup == "$rowx[0]") 
			{
			$Xgroups_menu .= "SELECTED ";
			$Xgroups_selected++;
			}
		$Xgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
		}
	if ($Xgroups_selected < 1) 
		{$Xgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
	else 
		{$Xgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}


	##### get in-groups listings for dynamic pulldown
	$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT') order by group_id";
	$rslt=mysql_query($stmt, $link);
	$Dgroups_to_print = mysql_num_rows($rslt);
	$Dgroups_menu='';
	$Dgroups_selected=0;
	$o=0;
	while ($Dgroups_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		$Dgroups_menu .= "<option ";
		if ($group_id == "$rowx[0]") 
			{
			$Dgroups_menu .= "SELECTED ";
			$Dgroups_selected++;
			}
		$Dgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
		}
	if ($Dgroups_selected < 1) 
		{$Dgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
	else 
		{$Dgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}


	echo "<br>MODIFY A DID RECORD: $row[0]<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=4311>\n";
	echo "<input type=hidden name=did_id value=\"$did_id\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>DID Extension: </td><td align=left><input type=text name=did_pattern size=30 maxlength=50 value=\"$did_pattern\">$NWB#vicidial_inbound_dids-did_pattern$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>DID Descrizione: </td><td align=left><input type=text name=did_description size=40 maxlength=50 value=\"$did_description\">$NWB#vicidial_inbound_dids-did_description$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=did_active><option>Y</option><option>N</option><option SELECTED>$did_active</option></select>$NWB#vicidial_inbound_dids-did_active$NWE</td></tr>\n";
	# <option>AGENT</option>
	echo "<tr bgcolor=#99FFCC><td align=right>DID Route: </td><td align=left><select size=1 name=did_route><option>EXTEN</option><option>VOICEMAIL</option><option>PHONE</option><option>IN_GROUP</option><option SELECTED>$did_route</option></select>$NWB#vicidial_inbound_dids-did_route$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Extension: </td><td align=left><input type=text name=extension size=40 maxlength=50 value=\"$extension\">$NWB#vicidial_inbound_dids-extension$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Extension Context: </td><td align=left><input type=text name=exten_context size=40 maxlength=50 value=\"$exten_context\">$NWB#vicidial_inbound_dids-exten_context$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Buzon de voz: </td><td align=left><input type=text name=voicemail_ext size=10 maxlength=10 value=\"$voicemail_ext\">$NWB#vicidial_inbound_dids-voicemail_ext$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Phone Extension: </td><td align=left><input type=text name=phone size=20 maxlength=100 value=\"$phone\">$NWB#vicidial_inbound_dids-phone$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>IP Server: </td><td align=left><select size=1 name=server_ip>\n";
	echo "$servers_list";
	echo "<option SELECTED>$server_ip</option>\n";
	echo "</select>$NWB#vicidial_inbound_dids-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>User Agent: </td><td align=left><input type=text name=user size=20 maxlength=20 value=\"$user\">$NWB#vicidial_inbound_dids-user$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>User Unavailable Action: </td><td align=left><select size=1 name=user_unavailable_action><option>EXTEN</option><option>VOICEMAIL</option><option>PHONE</option><option>IN_GROUP</option><option SELECTED>$user_unavailable_action</option></select>$NWB#vicidial_inbound_dids-user_unavailable_action$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>User Route Settings In-Gruppo: </td><td align=left><select size=1 name=user_route_settings_ingroup>";
	echo "$Xgroups_menu";
	echo "</select>$NWB#vicidial_inbound_dids-user_route_settings_ingroup$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=3111&group_id=$group_id\">In-ID Gruppo</a>: </td><td align=left><select size=1 name=group_id>";
	echo "$Dgroups_menu";
	echo "</select>$NWB#vicidial_inbound_dids-group_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>In-Group Call Handle Method: </td><td align=left><select size=1 name=call_handle_method><option>CID</option><option>CIDLOOKUP</option><option>CIDLOOKUPRL</option><option>CIDLOOKUPRC</option><option>ANI</option><option>ANILOOKUP</option><option>ANILOOKUPRL</option><option>CLOSER</option><option>3DIGITID</option><option>4DIGITID</option><option>5DIGITID</option><option>10DIGITID</option><option SELECTED>$call_handle_method</option></select>$NWB#vicidial_inbound_dids-call_handle_method$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>In-Group Agent Search Method: </td><td align=left><select size=1 name=agent_search_method><option value=\"LB\">LB - Load Balanced</option><option value=\"LO\">LO - Load Balanced Overflow</option><option value=\"SO\">SO - Server Only</option><option SELECTED>$agent_search_method</option></select>$NWB#vicidial_inbound_dids-agent_search_method$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>In-Group ID Lista: </td><td align=left><input type=text name=list_id size=14 maxlength=14 value=\"$list_id\">$NWB#vicidial_inbound_dids-list_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>In-ID Gruppo Campagna: </td><td align=left><select size=1 name=campaign_id>\n";
	echo "$campaigns_list";
	echo "<option SELECTED>$campaign_id</option>\n";
	echo "</select>$NWB#vicidial_inbound_dids-campaign_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>In-Group Phone Code: </td><td align=left><input type=text name=phone_code size=14 maxlength=14 value=\"$phone_code\">$NWB#vicidial_inbound_dids-phone_code$NWE</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</table>\n";
	echo "<BR></center></FORM><br>\n";



	if ($LOGdelete_dids > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=5311&did_id=$did_id\">DELETE THIS DID</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}



######################
# ADD=31111 modify remote agents info in the system
######################

if ($ADD==31111)
{
	if ($LOGmodify_remoteagents==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_remote_agents where remote_agent_id='$remote_agent_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$remote_agent_id =	$row[0];
	$user_start =		$row[1];
	$number_of_lines =	$row[2];
	$server_ip =		$row[3];
	$conf_exten =		$row[4];
	$status =			$row[5];
	$campaign_id =		$row[6];

	echo "<br>MODIFICAR UNA ENTRADA DE LOS AGENTES REMOTOS: $row[0]<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=41111>\n";
	echo "<input type=hidden name=remote_agent_id value=\"$row[0]\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Inizio ID Utente: </td><td align=left><input type=text name=user_start size=6 maxlength=6 value=\"$user_start\"> (solo cifre, incremented)$NWB#vicidial_remote_agents-user_start$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Numero di Linee: </td><td align=left><input type=text name=number_of_lines size=3 maxlength=3 value=\"$number_of_lines\"> (solo cifre)$NWB#vicidial_remote_agents-number_of_lines$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>IP Server: </td><td align=left><select size=1 name=server_ip>\n";
	echo "$servers_list";
	echo "<option SELECTED>$row[3]</option>\n";
	echo "</select>$NWB#vicidial_remote_agents-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Numero Di Interno Remoto: </td><td align=left><input type=text name=conf_exten size=20 maxlength=20 value=\"$conf_exten\"> (numero del dialplan usato per raggiungere gli operatori)$NWB#vicidial_remote_agents-conf_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Esito: </td><td align=left><select size=1 name=status><option SELECTED>ATTIVO</option><option>INACTIVE</option><option SELECTED>$status</option></select>$NWB#vicidial_remote_agents-status$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Campagna: </td><td align=left><select size=1 name=campaign_id>\n";
	echo "$campaigns_list";
	echo "<option SELECTED>$campaign_id</option>\n";
	echo "</select>$NWB#vicidial_remote_agents-campaign_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Gruppi Inbound: </td><td align=left>\n";
	echo "$groups_list";
	echo "$NWB#vicidial_remote_agents-closer_campaigns$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	echo "NOTA: Potrebbero passare fino a 30 secondi prima che le modifiche qui effettuate possano essere accettate\n";


	if ($LOGdelete_remote_agents > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=51111&remote_agent_id=$remote_agent_id\">SUPRIMA ESTE AGENTE ALEJADO</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=311111 modify user group info in the system
######################

if ($ADD==311111)
{
	if ($LOGmodify_usergroups==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_user_groups where user_group='$user_group';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$user_group =		$row[0];
	$group_name =		$row[1];
	$GROUP_shifts =		$row[5];
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>MODIFICA UN GRUPPO UTENTI<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=411111>\n";
	echo "<input type=hidden name=OLDuser_group value=\"$user_group\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Gruppo: </td><td align=left><input type=text name=user_group size=15 maxlength=20 value=\"$user_group\"> (senza spazi e punteggiatura)$NWB#vicidial_user_groups-user_group$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Descrizione: </td><td align=left><input type=text name=group_name size=40 maxlength=40 value=\"$group_name\"> (Descrizione del gruppo)$NWB#vicidial_user_groups-group_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Campagne Permesse: <BR>$NWB#vicidial_user_groups-allowed_campaigns$NWE</td><td align=left>\n";
	echo "$campaigns_list <BR>&nbsp;";
	echo "</td></tr>\n";


	echo "<tr bgcolor=#B6D3FC><td align=right>Group Shifts: <BR>$NWB#vicidial_user_groups-group_shifts$NWE</td><td align=left>\n";
	$stmt="SELECT shift_id,shift_name from vicidial_shifts order by shift_id";
	$rslt=mysql_query($stmt, $link);
	$shifts_to_print = mysql_num_rows($rslt);
	$o=0;
	while ($shifts_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$shift_id_value = $rowx[0];
		$shift_name_value = $rowx[1];
		echo "<input type=\"checkbox\" name=\"group_shifts[]\" value=\"$shift_id_value\"";
		$p=0;
		while ($p<100)
			{
			if (ereg(" $shift_id_value ", $GROUP_shifts))
				{
				echo " CHECKED";
				}
			$p++;
			}
		echo "> <a href=\"$PHP_SELF?ADD=331111111&shift_id=$shift_id_value\">$shift_id_value</a> - $shift_name_value<BR>\n";
		$o++;
		}
	echo " <BR>&nbsp;</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=right>QC Campagne Permesse: <BR>$NWB#vicidial_user_groups-qc_allowed_campaigns$NWE</td><td align=left>\n";
	echo "$qc_campaigns_list";
	echo " <BR>&nbsp;</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>QC Grupos De entrada Permitidos: <BR>$NWB#vicidial_user_groups-qc_allowed_inbound_groups$NWE</td><td align=left>\n";
	echo "$qc_groups_list";
	echo " <BR>&nbsp;</td></tr>\n";

	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";


	### list of users in this user group

		$active_confs = 0;
		$stmt="SELECT user,full_name,user_level from vicidial_users where user_group='$user_group'";
		$rsltx=mysql_query($stmt, $link);
		$users_to_print = mysql_num_rows($rsltx);

		echo "<center>\n";
		echo "<br><b>UTENTI IN QUESTO GRUPPO: $users_to_print</b><br>\n";
		echo "<TABLE width=400 cellspacing=3>\n";
		echo "<tr><td>UTENTE</td><td>NOME COMPLETO</td><td>LIVELLO</td></tr>\n";

		$o=0;
		while ($users_to_print > $o) 
		{
			$rowx=mysql_fetch_row($rsltx);
			$o++;

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		echo "<tr $bgcolor>\n";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3&user=$rowx[0]\">$rowx[0]</a></td>\n";
		echo "<td><font size=1>$rowx[1]</td>\n";
		echo "<td><font size=1>$rowx[2]</td>\n";
		echo "</tr>\n";
		}

	echo "</table></center><br>\n";



	echo "<br><br><a href=\"$PHP_SELF?ADD=8111&user_group=$user_group\">Clicca qui per visualizzare tutti i richiami di questo utente</a><BR><BR>\n";
	echo "<br><br><a href=\"./timeclock_status.php?user_group=$user_group\">Click here to see the Timeclock Status for this user group</a><BR><BR>\n";

	if ($LOGdelete_user_groups > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=511111&user_group=$user_group\">CANCELLA QUESTO GRUPPO UTENTI</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=3111111 modify script info in the system
######################

if ($ADD==3111111)
{
	if ($LOGmodify_scripts==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_scripts where script_id='$script_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$script_name =		$row[1];
	$script_comments =	$row[2];
	$script_text =		$row[3];
	$active =			$row[4];
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>MODIFICA SCRIPT<form name=scriptForm action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=4111111>\n";
	echo "<input type=hidden name=script_id value=\"$script_id\">\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Script:: </td><td align=left><B>$script_id</B>$NWB#vicidial_scripts-script_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Script: </td><td align=left><input type=text name=script_name size=40 maxlength=50 value=\"$script_name\"> (titolo script)$NWB#vicidial_scripts-script_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Note Script: </td><td align=left><input type=text name=script_comments size=50 maxlength=255 value=\"$script_comments\"> $NWB#vicidial_scripts-script_comments$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option SELECTED>Y</option><option>N</option><option selected>$active</option></select>$NWB#vicidial_scripts-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Testo Script: <BR><BR><B><a href=\"javascript:openNewWindow('$PHP_SELF?ADD=7111111&script_id=$script_id')\">Anteprima Script</a></B> </td><td align=left>";
	# BEGIN Insert Field
	echo "<select id=\"selectedField\" name=\"selectedField\">";
	echo "<option>vendor_lead_code</option>";
	echo "<option>source_id</option>";
	echo "<option>list_id</option>";
	echo "<option>gmt_offset_now</option>";
	echo "<option>called_since_last_reset</option>";
	echo "<option>phone_code</option>";
	echo "<option>phone_number</option>";
	echo "<option>title</option>";
	echo "<option>first_name</option>";
	echo "<option>middle_initial</option>";
	echo "<option>last_name</option>";
	echo "<option>address1</option>";
	echo "<option>address2</option>";
	echo "<option>address3</option>";
	echo "<option>city</option>";
	echo "<option>state</option>";
	echo "<option>province</option>";
	echo "<option>postal_code</option>";
	echo "<option>country_code</option>";
	echo "<option>gender</option>";
	echo "<option>date_of_birth</option>";
	echo "<option>alt_phone</option>";
	echo "<option>email</option>";
	echo "<option>security_phrase</option>";
	echo "<option>comments</option>";
	echo "<option>lead_id</option>";
	echo "<option>campaign</option>";
	echo "<option>phone_login</option>";
	echo "<option>group</option>";
	echo "<option>channel_group</option>";
	echo "<option>SQLdate</option>";
	echo "<option>epoch</option>";
	echo "<option>uniqueid</option>";
	echo "<option>customer_zap_channel</option>";
	echo "<option>server_ip</option>";
	echo "<option>SIPexten</option>";
	echo "<option>session_id</option>";
	echo "</select>";
	echo "<input type=\"button\" name=\"insertField\" value=\"Insert\" onClick=\"scriptInsertField();\"><BR>";
	# END Insert Field
	echo "<TEXTAREA NAME=script_text ROWS=20 COLS=50>$script_text</TEXTAREA> $NWB#vicidial_scripts-script_text$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";

	if ($LOGdelete_scripts > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=5111111&script_id=$script_id\">CANCELLA QUESTO SCRIPT</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=31111111 modify filter info in the system
######################

if ($ADD==31111111)
{
	if ($LOGmodify_filters==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_lead_filters where lead_filter_id='$lead_filter_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$lead_filter_name =		$row[1];
	$lead_filter_comments =	$row[2];
	$lead_filter_sql =		$row[3];
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br>MODIFICA UN FILTRO<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=41111111>\n";
	echo "<input type=hidden name=lead_filter_id value=\"$lead_filter_id\">\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Filtro:</td><td align=left><B>$lead_filter_id</B>$NWB#vicidial_lead_filters-lead_filter_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Del Filtro:</td><td align=left><input type=text name=lead_filter_name size=40 maxlength=50 value=\"$lead_filter_name\"> (breve descrizione del filtro)$NWB#vicidial_lead_filters-lead_filter_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Commenti Del Filtro: </td><td align=left><input type=text name=lead_filter_comments size=50 maxlength=255 value=\"$lead_filter_comments\"> $NWB#vicidial_lead_filters-lead_filter_comments$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Filtro Sql:</td><td align=left><TEXTAREA NAME=lead_filter_sql ROWS=20 COLS=50>$lead_filter_sql</TEXTAREA> $NWB#vicidial_lead_filters-lead_filter_sql$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
	echo "</TABLE></center></form>\n";

		##### get campaigns listing for dynamic pulldown
		$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
		$rslt=mysql_query($stmt, $link);
		$campaigns_to_print = mysql_num_rows($rslt);
		$campaigns_list='';

		$o=0;
		while ($campaigns_to_print > $o)
			{
			$rowx=mysql_fetch_row($rslt);
			$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}

	echo "<BR><BR>";
	echo "<br>PRUEBE EN CAMPAÑA: <form action=$PHP_SELF method=POST target=\"_blank\">\n";
	echo "<input type=hidden name=lead_filter_id value=\"$lead_filter_id\">\n";
	echo "<input type=hidden name=ADD value=\"73\">\n";
	echo "<select size=1 name=campaign_id>\n";
	echo "$campaigns_list";
	echo "</select>\n";
	echo "<input type=submit name=INVIA value=INVIA>\n";


	if ($LOGdelete_filters > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=51111111&lead_filter_id=$lead_filter_id\">CANCELLA QUESTO FILTRO</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=321111111 modify call time definition info in the system
######################

if ($ADD==321111111)
{
if ($LOGmodify_call_times==1)
{

if ( ($stage=="ADD") and (strlen($state_rule)>0) )
	{
	$stmt="SELECT ct_state_call_times from vicidial_call_times where call_time_id='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$ct_state_call_times = $row[0];

	if (eregi("\|$",$ct_state_call_times))
		{$ct_state_call_times = "$ct_state_call_times$state_rule\|";}
	else
		{$ct_state_call_times = "$ct_state_call_times\|$state_rule\|";}
	$stmt="UPDATE vicidial_call_times set ct_state_call_times='$ct_state_call_times' where call_time_id='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	echo "Regla Del Estado Agregada: $state_rule<BR>\n";
	}
if ( ($stage=="REMOVE") and (strlen($state_rule)>0) )
	{
	$stmt="SELECT ct_state_call_times from vicidial_call_times where call_time_id='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$ct_state_call_times = $row[0];

	$ct_state_call_times = eregi_replace("\|$state_rule\|",'|',$ct_state_call_times);
	$stmt="UPDATE vicidial_call_times set ct_state_call_times='$ct_state_call_times' where call_time_id='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	echo "Regla Del Estado Quitada: $state_rule<BR>\n";
	}

$ADD=311111111;
}
else
{
echo "Le no autorizan a visio`n esta página. Vaya por favor detrás.";
}

}


######################
# ADD=311111111 modify call time definition info in the system
######################

if ($ADD==311111111)
{

if ($LOGmodify_call_times==1)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_call_times where call_time_id='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$call_time_name =		$row[1];
	$call_time_comments =	$row[2];
	$ct_default_start =		$row[3];
	$ct_default_stop =		$row[4];
	$ct_sunday_start =		$row[5];
	$ct_sunday_stop =		$row[6];
	$ct_monday_start =		$row[7];
	$ct_monday_stop =		$row[8];
	$ct_tuesday_start =		$row[9];
	$ct_tuesday_stop =		$row[10];
	$ct_wednesday_start =	$row[11];
	$ct_wednesday_stop =	$row[12];
	$ct_thursday_start =	$row[13];
	$ct_thursday_stop =		$row[14];
	$ct_friday_start =		$row[15];
	$ct_friday_stop =		$row[16];
	$ct_saturday_start =	$row[17];
	$ct_saturday_stop =		$row[18];
	$ct_state_call_times =	$row[19];

echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>MODIFICA ORARIO CHIAMATE<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=411111111>\n";
echo "<input type=hidden name=call_time_id value=\"$call_time_id\">\n";
echo "<tr bgcolor=#B6D3FC><td align=right>ID Orario Chiamate: </td><td align=left colspan=3><B>$call_time_id</B>$NWB#vicidial_call_times-call_time_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Nome Orario Chiamate: </td><td align=left colspan=3><input type=text name=call_time_name size=40 maxlength=50 value=\"$call_time_name\"> (breve descrizione dell`orario chiamate)$NWB#vicidial_call_times-call_time_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Note Orario Chiamate: </td><td align=left colspan=3><input type=text name=call_time_comments size=50 maxlength=255 value=\"$call_time_comments\"> $NWB#vicidial_call_times-call_time_comments$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio di Default:</td><td align=left><input type=text name=ct_default_start size=5 maxlength=4 value=\"$ct_default_start\"> </td><td align=right>Fine di Default:</td><td align=left><input type=text name=ct_default_stop size=5 maxlength=4 value=\"$ct_default_stop\"> $NWB#vicidial_call_times-ct_default_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Domenica:</td><td align=left><input type=text name=ct_sunday_start size=5 maxlength=4 value=\"$ct_sunday_start\"> </td><td align=right>Fine Domenica:</td><td align=left><input type=text name=ct_sunday_stop size=5 maxlength=4 value=\"$ct_sunday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Lunedi:</td><td align=left><input type=text name=ct_monday_start size=5 maxlength=4 value=\"$ct_monday_start\"> </td><td align=right>Fine Lunedi:</td><td align=left><input type=text name=ct_monday_stop size=5 maxlength=4 value=\"$ct_monday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Martedi:</td><td align=left><input type=text name=ct_tuesday_start size=5 maxlength=4 value=\"$ct_tuesday_start\"> </td><td align=right>Fine Martedi:</td><td align=left><input type=text name=ct_tuesday_stop size=5 maxlength=4 value=\"$ct_tuesday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Mercoledi:</td><td align=left><input type=text name=ct_wednesday_start size=5 maxlength=4 value=\"$ct_wednesday_start\"> </td><td align=right>Fine Mercoledi:</td><td align=left><input type=text name=ct_wednesday_stop size=5 maxlength=4 value=\"$ct_wednesday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Giovedi:</td><td align=left><input type=text name=ct_thursday_start size=5 maxlength=4 value=\"$ct_thursday_start\"> </td><td align=right>Fine Giovedi:</td><td align=left><input type=text name=ct_thursday_stop size=5 maxlength=4 value=\"$ct_thursday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Venerdi:</td><td align=left><input type=text name=ct_friday_start size=5 maxlength=4 value=\"$ct_friday_start\"> </td><td align=right>Fine Venerdi:</td><td align=left><input type=text name=ct_friday_stop size=5 maxlength=4 value=\"$ct_friday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Sabato:</td><td align=left><input type=text name=ct_saturday_start size=5 maxlength=4 value=\"$ct_saturday_start\"> </td><td align=right>Fine Sabato:</td><td align=left><input type=text name=ct_saturday_stop size=5 maxlength=4 value=\"$ct_saturday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=4><input type=submit name=INVIA value=INVIA></FORM></td></tr>\n";

$ct_srs=1;
$b=0;
$srs_SQL ='';
if (strlen($ct_state_call_times)>2)
	{
	$state_rules = explode('|',$ct_state_call_times);
	$ct_srs = ((count($state_rules)) - 1);
	}
echo "<tr bgcolor=#B6D3FC><td align=center rowspan=$ct_srs>Definiciones activas del tiempo de la llamada del estado para estoexpediente: </td>\n";
echo "<td align=center colspan=3>&nbsp;</td></tr>\n";
while($ct_srs >= $b)
	{
	if (strlen($state_rules[$b])>0)
		{
		$stmt="SELECT state_call_time_state,state_call_time_name from vicidial_state_call_times where state_call_time_id='$state_rules[$b]';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=3111111111&call_time_id=$state_rules[$b]\">$state_rules[$b] </a> - <a href=\"$PHP_SELF?ADD=321111111&call_time_id=$call_time_id&state_rule=$state_rules[$b]&stage=REMOVE\">REMOVE </a></td><td align=left colspan=2>$row[0] - $row[1]</td></tr>\n";
		$srs_SQL .= "'$state_rules[$b]',";
		$srs_state_SQL .= "'$row[0]',";
		}
	$b++;
	}
if (strlen($srs_SQL)>2)
	{
	$srs_SQL = "$srs_SQL''";
	$srs_state_SQL = "$srs_state_SQL''";
	$srs_SQL = "where state_call_time_id NOT IN($srs_SQL) and state_call_time_state NOT IN($srs_state_SQL)";
	}
else
	{$srs_SQL='';}
$stmt="SELECT state_call_time_id,state_call_time_name from vicidial_state_call_times $srs_SQL order by state_call_time_id;";
$rslt=mysql_query($stmt, $link);
$sct_to_print = mysql_num_rows($rslt);
$sct_list='';

$o=0;
while ($sct_to_print > $o) {
	$rowx=mysql_fetch_row($rslt);
	$sct_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
	$o++;
}
echo "<tr bgcolor=#B6D3FC><td align=right><form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=321111111>\n";
echo "<input type=hidden name=stage value=\"ADD\">\n";
echo "<input type=hidden name=call_time_id value=\"$call_time_id\">\n";
echo "Add state call time rule: </td><td align=left colspan=2><select size=1 name=state_rule>\n";
echo "$sct_list";
echo "</select></td>\n";
echo "<td align=center colspan=4><input type=submit name=INVIA value=INVIA></FORM></td></tr>\n";

echo "</TABLE><BR><BR>\n";
echo "<B>CAMPAGNE CHE UTILIZZANO QUESTO ORARIO:</B><BR>\n";
echo "<TABLE>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns where local_call_time='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	$camps_to_print = mysql_num_rows($rslt);
	$o=0;
	while ($camps_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		echo "<TR><TD><a href=\"$PHP_SELF?ADD=31&campaign_id=$row[0]\">$row[0] </a></TD><TD> $row[1]<BR></TD></TR>\n";
		$o++;
	}

echo "</TABLE>\n";
echo "<B>GRUPPI INBOUND CHE UTILIZZANO QUESTO ORARIO:</B><BR>\n";
echo "<TABLE>\n";

	$stmt="SELECT group_id,group_name from vicidial_inbound_groups where call_time_id='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	$camps_to_print = mysql_num_rows($rslt);
	$o=0;
	while ($camps_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		echo "<TR><TD><a href=\"$PHP_SELF?ADD=3111&group_id=$row[0]\">$row[0] </a></TD><TD> $row[1]<BR></TD></TR>\n";
		$o++;
	}

echo "</TABLE>\n";
echo "</center><BR><BR>\n";

if ($LOGdelete_call_times > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=511111111&call_time_id=$call_time_id\">ELIMINA QUESTO ORARIO CHIAMATE</a>\n";
	}
}
else
{
echo "Le no autorizan a visio`n esta página. Vaya por favor detrás.";
}

}


######################
# ADD=3111111111 modify state call time definition info in the system
######################

if ($ADD==3111111111)
{

if ($LOGmodify_call_times==1)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_state_call_times where state_call_time_id='$call_time_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$state_call_time_state =$row[1];
	$call_time_name =		$row[2];
	$call_time_comments =	$row[3];
	$ct_default_start =		$row[4];
	$ct_default_stop =		$row[5];
	$ct_sunday_start =		$row[6];
	$ct_sunday_stop =		$row[7];
	$ct_monday_start =		$row[8];
	$ct_monday_stop =		$row[9];
	$ct_tuesday_start =		$row[10];
	$ct_tuesday_stop =		$row[11];
	$ct_wednesday_start =	$row[12];
	$ct_wednesday_stop =	$row[13];
	$ct_thursday_start =	$row[14];
	$ct_thursday_stop =		$row[15];
	$ct_friday_start =		$row[16];
	$ct_friday_stop =		$row[17];
	$ct_saturday_start =	$row[18];
	$ct_saturday_stop =		$row[19];

echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>_ MODIFICAR Uno ESTADO LLAMAR TIEMPO<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=4111111111>\n";
echo "<input type=hidden name=call_time_id value=\"$call_time_id\">\n";
echo "<tr bgcolor=#B6D3FC><td align=right>ID Orario Chiamate: </td><td align=left colspan=3><B>$call_time_id</B>$NWB#vicidial_call_times-call_time_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>State Call Time State: </td><td align=left colspan=3><input type=text name=state_call_time_state size=4 maxlength=2 value=\"$state_call_time_state\"> $NWB#vicidial_call_times-state_call_time_state$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>_ Estado Llamar Tiempo Nombre: </td><td align=left colspan=3><input type=text name=call_time_name size=40 maxlength=50 value=\"$call_time_name\"> (breve descrizione dell`orario chiamate)$NWB#vicidial_call_times-call_time_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Comentarios Del Tiempo De la Llamada Del Estado: </td><td align=left colspan=3><input type=text name=call_time_comments size=50 maxlength=255 value=\"$call_time_comments\"> $NWB#vicidial_call_times-call_time_comments$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio di Default:</td><td align=left><input type=text name=ct_default_start size=5 maxlength=4 value=\"$ct_default_start\"> </td><td align=right>Fine di Default:</td><td align=left><input type=text name=ct_default_stop size=5 maxlength=4 value=\"$ct_default_stop\"> $NWB#vicidial_call_times-ct_default_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Domenica:</td><td align=left><input type=text name=ct_sunday_start size=5 maxlength=4 value=\"$ct_sunday_start\"> </td><td align=right>Fine Domenica:</td><td align=left><input type=text name=ct_sunday_stop size=5 maxlength=4 value=\"$ct_sunday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Lunedi:</td><td align=left><input type=text name=ct_monday_start size=5 maxlength=4 value=\"$ct_monday_start\"> </td><td align=right>Fine Lunedi:</td><td align=left><input type=text name=ct_monday_stop size=5 maxlength=4 value=\"$ct_monday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Martedi:</td><td align=left><input type=text name=ct_tuesday_start size=5 maxlength=4 value=\"$ct_tuesday_start\"> </td><td align=right>Fine Martedi:</td><td align=left><input type=text name=ct_tuesday_stop size=5 maxlength=4 value=\"$ct_tuesday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Mercoledi:</td><td align=left><input type=text name=ct_wednesday_start size=5 maxlength=4 value=\"$ct_wednesday_start\"> </td><td align=right>Fine Mercoledi:</td><td align=left><input type=text name=ct_wednesday_stop size=5 maxlength=4 value=\"$ct_wednesday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Giovedi:</td><td align=left><input type=text name=ct_thursday_start size=5 maxlength=4 value=\"$ct_thursday_start\"> </td><td align=right>Fine Giovedi:</td><td align=left><input type=text name=ct_thursday_stop size=5 maxlength=4 value=\"$ct_thursday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Venerdi:</td><td align=left><input type=text name=ct_friday_start size=5 maxlength=4 value=\"$ct_friday_start\"> </td><td align=right>Fine Venerdi:</td><td align=left><input type=text name=ct_friday_stop size=5 maxlength=4 value=\"$ct_friday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inizio Sabato:</td><td align=left><input type=text name=ct_saturday_start size=5 maxlength=4 value=\"$ct_saturday_start\"> </td><td align=right>Fine Sabato:</td><td align=left><input type=text name=ct_saturday_stop size=5 maxlength=4 value=\"$ct_saturday_stop\"> $NWB#vicidial_call_times-ct_sunday_start$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=center colspan=4><input type=submit name=INVIA value=INVIA></td></tr>\n";
echo "</TABLE><BR><BR>\n";
echo "<B>TIEMPOS DE LA LLAMADA USANDO ESTE TIEMPO DE LA LLAMADA DEL ESTADO:</B><BR>\n";
echo "<TABLE>\n";

	$stmt="SELECT call_time_id,call_time_name from vicidial_call_times where ct_state_call_times LIKE \"%|$call_time_id|%\";";
	$rslt=mysql_query($stmt, $link);
	$camps_to_print = mysql_num_rows($rslt);
	$o=0;
	while ($camps_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		echo "<TR><TD><a href=\"$PHP_SELF?ADD=311111111&call_time_id=$row[0]\">$row[0] </a></TD><TD> $row[1]<BR></TD></TR>\n";
		$o++;
	}

echo "</TABLE>\n";
echo "</center><BR><BR>\n";

if ($LOGdelete_call_times > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=5111111111&call_time_id=$call_time_id\">SUPRIMA ESTA DEFINICIo`N DEL TIEMPO DE LA LLAMADA DEL ESTADO</a>\n";
	}

}
else
{
echo "Le no autorizan a visio`n esta página. Vaya por favor detrás.";
}

}



######################
# ADD=331111111 modify shift definition info in the system
######################

if ($ADD==331111111)
{

if ($LOGmodify_call_times==1)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_shifts where shift_id='$shift_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$shift_name =		$row[1];
	$shift_start_time =	$row[2];
	$shift_length =		$row[3];
	$shift_weekdays =	$row[4];

	$shift_start_hour = substr($shift_start_time,0,2);
	$shift_start_min = substr($shift_start_time,2,2);
	$shift_length_hour = substr($shift_length,0,2);
	$shift_length_min = substr($shift_length,3,2);
	$shift_end_hour = ($shift_start_hour + $shift_length_hour);
	$shift_end_min = ($shift_start_min + $shift_length_min);
	if ($shift_end_min >=60) 
		{
		$shift_end_min = ($shift_end_min - 60);
		$shift_end_hour++;
		}
	if ($shift_end_hour >=24) 
		{
		$shift_end_hour = ($shift_end_hour - 24);
		}
	$shift_end_hour = sprintf("%02s", $shift_end_hour);	
	$shift_end_min = sprintf("%02s", $shift_end_min);	
	$shift_end = "$shift_end_hour$shift_end_min";

echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>MODIFY A SHIFT<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=431111111>\n";
echo "<input type=hidden name=shift_id value=\"$shift_id\">\n";
echo "<center><TABLE width=$section_width cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Shift ID: </td><td align=left><B>$shift_id</B></td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Shift Name: </td><td align=left><input type=text name=shift_name size=50 maxlength=50 value=\"$shift_name\"> (short description of the shift)$NWB#vicidial_shifts-shift_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Shift Start Time: </td><td align=left><input type=text name=shift_start_time size=5 maxlength=4 id=shift_start_time value=\"$shift_start_time\">\n";
echo " &nbsp; Shift End Time: <input type=text name=shift_end_time size=5 maxlength=4 id=shift_end_time value=\"$shift_end\">\n";
echo "<input type=button name=shift_calc value=\"Calculate Shift Length\" onClick=\"shift_time();\"> $NWB#vicidial_shifts-shift_start_time$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Shift Length: </td><td align=left><input type=text name=shift_length id=shift_length size=6 maxlength=5 value=\"$shift_length\"> $NWB#vicidial_shifts-shift_length$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Shift Weekdays: <BR>$NWB#vicidial_shifts-shift_weekdays$NWE</td><td align=left>\n";
echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"0\"";
	if (ereg('0',$shift_weekdays)) {echo " CHECKED";}
echo ">Sunday<BR>\n";
echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"1\"";
	if (ereg('1',$shift_weekdays)) {echo " CHECKED";}
echo ">Monday<BR>\n";
echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"2\"";
	if (ereg('2',$shift_weekdays)) {echo " CHECKED";}
echo ">Tuesday<BR>\n";
echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"3\"";
	if (ereg('3',$shift_weekdays)) {echo " CHECKED";}
echo ">Wednesday<BR>\n";
echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"4\"";
	if (ereg('4',$shift_weekdays)) {echo " CHECKED";}
echo ">Thursday<BR>\n";
echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"5\"";
	if (ereg('5',$shift_weekdays)) {echo " CHECKED";}
echo ">Friday<BR>\n";
echo "<input type=\"checkbox\" name=\"shift_weekdays[]\" value=\"6\"";
	if (ereg('6',$shift_weekdays)) {echo " CHECKED";}
echo ">Saturday<BR>\n";
echo "</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=INVIA value=INVIA></td></tr>\n";
echo "</TABLE></center>\n";

echo "</TABLE><BR><BR>\n";
echo "<B>GRUPPI UTENTI USING THIS SHIFT:</B><BR>\n";
echo "<TABLE>\n";


	$stmt="SELECT user_group,group_name from vicidial_user_groups where group_shifts LIKE\"% $shift_id %\";";
	$rslt=mysql_query($stmt, $link);
	$camps_to_print = mysql_num_rows($rslt);
	$o=0;
	while ($camps_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		echo "<TR><TD><a href=\"$PHP_SELF?ADD=311111&user_group=$row[0]\">$row[0] </a></TD><TD> $row[1]<BR></TD></TR>\n";
		$o++;
	}


echo "</TABLE>\n";
echo "</center><BR><BR>\n";

if ($LOGdelete_call_times > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=531111111&shift_id=$shift_id\">DELETE THIS SHIFT DEFINITION</a>\n";
	}
}
else
{
echo "Le no autorizan a visio`n esta página. Vaya por favor detrás.";
}

}


######################
# ADD=31111111111 modify phone record in the system
######################

if ($ADD==31111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from phones where extension='$extension' and server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);

	echo "<br>MODIFICANDO EL telefonO: $row[1]<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=41111111111>\n";
	echo "<input type=hidden name=old_extension value=\"$row[0]\">\n";
	echo "<input type=hidden name=old_server_ip value=\"$row[5]\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Interno Telefono: </td><td align=left><input type=text name=extension size=20 maxlength=100 value=\"$row[0]\">$NWB#phones-extension$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Numero De Dial plan: </td><td align=left><input type=text name=dialplan_number size=15 maxlength=20 value=\"$row[1]\"> (solo cifre)$NWB#phones-dialplan_number$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Buzon de voz: </td><td align=left><input type=text name=voicemail_id size=10 maxlength=10 value=\"$row[2]\"> (solo cifre)$NWB#phones-voicemail_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>CallerID De salida: </td><td align=left><input type=text name=outbound_cid size=10 maxlength=20 value=\"$row[65]\"> (solo cifre)$NWB#phones-outbound_cid$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Direccion IP del telefono: </td><td align=left><input type=text name=phone_ip size=20 maxlength=15 value=\"$row[3]\"> (optional)$NWB#phones-phone_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Direccion IP del ordenador: </td><td align=left><input type=text name=computer_ip size=20 maxlength=15 value=\"$row[4]\"> (optional)$NWB#phones-computer_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=311111111111&server_ip=$row[5]\">IP Server</a>: </td><td align=left><select size=1 name=server_ip>\n";

	echo "$servers_list";
	echo "<option SELECTED>$row[5]</option>\n";
	echo "</select>$NWB#phones-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Login: </td><td align=left><input type=text name=login size=10 maxlength=10 value=\"$row[6]\">$NWB#phones-login$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Password: </td><td align=left><input type=text name=pass size=10 maxlength=10 value=\"$row[7]\">$NWB#phones-pass$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Esito: </td><td align=left><select size=1 name=status><option>ATTIVO</option><option>SUSPENDED</option><option>CLOSED</option><option>PENDING</option><option>ADMIN</option><option selected>$row[8]</option></select>$NWB#phones-status$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Activa: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option selected>$row[9]</option></select>$NWB#phones-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Tipo Del telefono: </td><td align=left><input type=text name=phone_type size=20 maxlength=50 value=\"$row[10]\">$NWB#phones-phone_type$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nome Completo: </td><td align=left><input type=text name=fullname size=20 maxlength=50 value=\"$row[11]\">$NWB#phones-fullname$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Email: </td><td align=left><input type=text name=email size=50 maxlength=100 value=\"$row[67]\"> $NWB#phones-email$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Compania: </td><td align=left><input type=text name=company size=10 maxlength=10 value=\"$row[12]\">$NWB#phones-company$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Foto: </td><td align=left><input type=text name=picture size=20 maxlength=19 value=\"$row[13]\">$NWB#phones-picture$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Messaggi Nuovi: </td><td align=left><b>$row[14]</b>$NWB#phones-messages$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Messaggi Vecchi: </td><td align=left><b>$row[15]</b>$NWB#phones-old_messages$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Protocollo Client: </td><td align=left><select size=1 name=protocol><option>SIP</option><option>Zap</option><option>IAX2</option><option>EXTERNAL</option><option selected>$row[16]</option></select>$NWB#phones-protocol$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Fuso Orario Locale: </td><td align=left><select size=1 name=local_gmt><option>12.75</option><option>12.00</option><option>11.00</option><option>10.00</option><option>9.50</option><option>9.00</option><option>8.00</option><option>7.00</option><option>6.50</option><option>6.00</option><option>5.75</option><option>5.50</option><option>5.00</option><option>4.50</option><option>4.00</option><option>3.50</option><option>3.00</option><option>2.00</option><option>1.00</option><option>0.00</option><option>-1.00</option><option>-2.00</option><option>-3.00</option><option>-3.50</option><option>-4.00</option><option>-5.00</option><option>-6.00</option><option>-7.00</option><option>-8.00</option><option>-9.00</option><option>-10.00</option><option>-11.00</option><option>-12.00</option><option selected>$row[17]</option></select> (No ajustar para el DST)$NWB#phones-local_gmt$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Login del Manager: </td><td align=left><input type=text name=ASTmgrUSERNAME size=20 maxlength=20 value=\"$row[18]\">$NWB#phones-ASTmgrUSERNAME$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Contraseña del Manager: </td><td align=left><input type=text name=ASTmgrSECRET size=20 maxlength=20 value=\"$row[19]\">$NWB#phones-ASTmgrSECRET$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Usuario por defecto de VICIDIAL: </td><td align=left><input type=text name=login_user size=20 maxlength=20 value=\"$row[20]\">$NWB#phones-login_user$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Contraseña por defecto  de VICIDIAL: </td><td align=left><input type=text name=login_pass size=20 maxlength=20 value=\"$row[21]\">$NWB#phones-login_pass$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Campaña por defecto de VICIDIAL: </td><td align=left><input type=text name=login_campaign size=10 maxlength=10 value=\"$row[22]\">$NWB#phones-login_campaign$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Extension del parking: </td><td align=left><input type=text name=park_on_extension size=10 maxlength=10 value=\"$row[23]\">$NWB#phones-park_on_extension$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Extension de la conferencia: </td><td align=left><input type=text name=conf_on_extension size=10 maxlength=10 value=\"$row[24]\">$NWB#phones-conf_on_extension$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Exten. Del parking de VICIDIAL: </td><td align=left><input type=text name=VICIDIAL_park_on_extension size=10 maxlength=10 value=\"$row[25]\">$NWB#phones-VICIDIAL_park_on_extension$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Archivo para música del parking de VICIDIAL: </td><td align=left><input type=text name=VICIDIAL_park_on_filename size=10 maxlength=10 value=\"$row[26]\">$NWB#phones-VICIDIAL_park_on_filename$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Prefijo al monitorizar: </td><td align=left><input type=text name=monitor_prefix size=10 maxlength=10 value=\"$row[27]\">$NWB#phones-monitor_prefix$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Exten de grabacion: </td><td align=left><input type=text name=recording_exten size=10 maxlength=10 value=\"$row[28]\">$NWB#phones-recording_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Exten de VmailMain: </td><td align=left><input type=text name=voicemail_exten size=10 maxlength=10 value=\"$row[29]\">$NWB#phones-voicemail_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Exten de VmaiDumpl: </td><td align=left><input type=text name=voicemail_dump_exten size=20 maxlength=20 value=\"$row[30]\">$NWB#phones-voicemail_dump_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Contexto De Exten: </td><td align=left><input type=text name=ext_context size=20 maxlength=20 value=\"$row[31]\">$NWB#phones-ext_context$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Canal de envío del DTMF: </td><td align=left><input type=text name=dtmf_send_extension size=40 maxlength=100 value=\"$row[32]\">$NWB#phones-dtmf_send_extension$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Grupo de las llamadas de salida: </td><td align=left><input type=text name=call_out_number_group size=40 maxlength=100 value=\"$row[33]\">$NWB#phones-call_out_number_group$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Localizacio`n del Navegador: </td><td align=left><input type=text name=client_browser size=40 maxlength=100 value=\"$row[34]\">$NWB#phones-client_browser$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Directorio de instalacio`n: </td><td align=left><input type=text name=install_directory size=40 maxlength=100 value=\"$row[35]\">$NWB#phones-install_directory$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>URL CallerID: </td><td align=left><input type=text name=local_web_callerID_URL size=40 maxlength=255 value=\"$row[36]\">$NWB#phones-local_web_callerID_URL$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>URL por defecto de VICIDIAL: </td><td align=left><input type=text name=VICIDIAL_web_URL size=40 maxlength=255 value=\"$row[37]\">$NWB#phones-VICIDIAL_web_URL$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Call Logging: </td><td align=left><select size=1 name=AGI_call_logging_enabled><option>1</option><option>0</option><option selected>$row[38]</option></select>$NWB#phones-AGI_call_logging_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Cambio de Usuario: </td><td align=left><select size=1 name=user_switching_enabled><option>1</option><option>0</option><option selected>$row[39]</option></select>$NWB#phones-user_switching_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Conferenze: </td><td align=left><select size=1 name=conferencing_enabled><option>1</option><option>0</option><option selected>$row[40]</option></select>$NWB#phones-conferencing_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Colgar del Admin: </td><td align=left><select size=1 name=admin_hangup_enabled><option>1</option><option>0</option><option selected>$row[41]</option></select>$NWB#phones-admin_hangup_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Captura del Admin: </td><td align=left><select size=1 name=admin_hijack_enabled><option>1</option><option>0</option><option selected>$row[42]</option></select>$NWB#phones-admin_hijack_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Monitorizacio`n del Admin: </td><td align=left><select size=1 name=admin_monitor_enabled><option>1</option><option>0</option><option selected>$row[43]</option></select>$NWB#phones-admin_monitor_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Parking de Llamada: </td><td align=left><select size=1 name=call_parking_enabled><option>1</option><option>0</option><option selected>$row[44]</option></select>$NWB#phones-call_parking_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Uptader Check: </td><td align=left><select size=1 name=updater_check_enabled><option>1</option><option>0</option><option selected>$row[45]</option></select>$NWB#phones-updater_check_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>AF Logging: </td><td align=left><select size=1 name=AFLogging_enabled><option>1</option><option>0</option><option selected>$row[46]</option></select>$NWB#phones-AFLogging_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Colas permitidas: </td><td align=left><select size=1 name=QUEUE_ACTION_enabled><option>1</option><option>0</option><option selected>$row[47]</option></select>$NWB#phones-QUEUE_ACTION_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Ventana emergente del CallerID: </td><td align=left><select size=1 name=CallerID_popup_enabled><option>1</option><option>0</option><option selected>$row[48]</option></select>$NWB#phones-CallerID_popup_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Boto`n Vmail: </td><td align=left><select size=1 name=voicemail_button_enabled><option>1</option><option>0</option><option selected>$row[49]</option></select>$NWB#phones-voicemail_button_enabled$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Aggiornamento Veloce: </td><td align=left><select size=1 name=enable_fast_refresh><option>1</option><option>0</option><option selected>$row[50]</option></select>$NWB#phones-enable_fast_refresh$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Intervallo Aggiornamento Veloce: </td><td align=left><input type=text size=5 name=fast_refresh_rate value=\"$row[51]\">(in ms)$NWB#phones-fast_refresh_rate$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Persistant MySQL: </td><td align=left><select size=1 name=enable_persistant_mysql><option>1</option><option>0</option><option selected>$row[52]</option></select>$NWB#phones-enable_persistant_mysql$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Auto Marcar el Siguiente Número: </td><td align=left><select size=1 name=auto_dial_next_number><option>1</option><option>0</option><option selected>$row[53]</option></select>$NWB#phones-auto_dial_next_number$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Parar de Grabar despue`s de cada llamada: </td><td align=left><select size=1 name=VDstop_rec_after_each_call><option>1</option><option>0</option><option selected>$row[54]</option></select>$NWB#phones-VDstop_rec_after_each_call$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Abilita messaggi SIPSAK: </td><td align=left><select size=1 name=enable_sipsak_messages><option>1</option><option>0</option><option selected>$row[66]</option></select>$NWB#phones-enable_sipsak_messages$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Servidor de DBX: </td><td align=left><input type=text name=DBX_server size=15 maxlength=15 value=\"$row[55]\"> (Primario DB Server)$NWB#phones-DBX_server$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Base de datos de DBX: </td><td align=left><input type=text name=DBX_database size=15 maxlength=15 value=\"$row[56]\"> (Primario Server Database)$NWB#phones-DBX_database$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Usuario de DBX: </td><td align=left><input type=text name=DBX_user size=15 maxlength=15 value=\"$row[57]\"> (Primario DB Login)$NWB#phones-DBX_user$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Contraseña de DBX: </td><td align=left><input type=text name=DBX_pass size=15 maxlength=15 value=\"$row[58]\"> (Primario DB Secret)$NWB#phones-DBX_pass$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Puerto de DBX: </td><td align=left><input type=text name=DBX_port size=6 maxlength=6 value=\"$row[59]\"> (Primario DB Port)$NWB#phones-DBX_port$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Servidor de DBY: </td><td align=left><input type=text name=DBY_server size=15 maxlength=15 value=\"$row[60]\"> (Secondario DB Server)$NWB#phones-DBY_server$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Base de datos de DBY: </td><td align=left><input type=text name=DBY_database size=15 maxlength=15 value=\"$row[61]\"> (Secondario Server Database)$NWB#phones-DBY_database$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Usuario de DBY: </td><td align=left><input type=text name=DBY_user size=15 maxlength=15 value=\"$row[62]\"> (Secondario DB Login)$NWB#phones-DBY_user$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Contraseña de DBY: </td><td align=left><input type=text name=DBY_pass size=15 maxlength=15 value=\"$row[63]\"> (Secondario DB Secret)$NWB#phones-DBY_pass$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Puerto de DBY: </td><td align=left><input type=text name=DBY_port size=6 maxlength=6 value=\"$row[64]\"> (Secondario DB Port)$NWB#phones-DBY_port$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";

	echo "<br><br><a href=\"./phone_stats.php?extension=$row[0]&server_ip=$row[5]\">Pinchar aquí­ para ver las estadísticas del telefono</a>\n";

	if ($LOGast_delete_phones > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=51111111111&extension=$extension&server_ip=$server_ip\">CANCELLA QUESTO TELEFONO</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=32111111111 modify phone alias record in the system
######################

if ($ADD==32111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from phones_alias where alias_id='$alias_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);

	echo "<br>MODIFY A PHONE ALIAS RECORD: $row[0]<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=42111111111>\n";
	echo "<input type=hidden name=alias_id value=\"$row[0]\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Alias ID: </td><td align=left><B>$row[0]</B> $NWB#phones-alias_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Alias Name: </td><td align=left><input type=text name=alias_name size=30 maxlength=50 value=\"$row[1]\"> $NWB#phones-alias_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Phones Logins List: </td><td align=left><input type=text name=logins_list size=50 maxlength=255 value=\"$row[2]\"> (comma separated)$NWB#phones-logins_list$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";


	### list of phones in this phones alias
	$phone_alias_SQL = ereg_replace(',',"','",$row[2]);
 
	echo "<center>\n";
	echo "<br><b>PHONES WITHIN THIS PHONES ALIAS:</b><br>\n";
	echo "<TABLE width=600 cellspacing=3>\n";
	echo "<tr><td>LOGIN</td><td>INTERNO</td><td>SERVER</td><td>PROTOCOL</td><td>IP</td></tr>\n";

		$stmt="SELECT login,extension,server_ip,protocol,phone_ip from phones where login IN ('$phone_alias_SQL');";
		if ($DB) {echo "|$stmt|";}
		$rsltx=mysql_query($stmt, $link);
		$lists_to_print = mysql_num_rows($rsltx);

		$o=0;
		while ($lists_to_print > $o) {
			$rowx=mysql_fetch_row($rsltx);
			$o++;

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31111111111&extension=$rowx[1]&server_ip=$rowx[2]\">$rowx[0]</a></td><td><font size=1>$rowx[1]</td><td><font size=1>$rowx[2]</td><td><font size=1>$rowx[3]</td><td><font size=1>$rowx[4]</td></tr>\n";
		}

	echo "</table></center><br>\n";








	if ($LOGast_delete_phones > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=52111111111&alias_id=$row[0]\">CANCELLA QUESTO TELEFONO ALIAS</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=311111111111 modify server record in the system
######################

if ($ADD==311111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from servers where server_id='$server_id' or server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$server_id = $row[0];
	$server_ip = $row[2];

	echo "<br>MODIFICAR UN REGISTRO DEL SERVIDOR: $row[0]<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=411111111111>\n";
	echo "<input type=hidden name=old_server_id value=\"$server_id\">\n";
	echo "<input type=hidden name=old_server_ip value=\"$row[2]\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>ID Server: </td><td align=left><input type=text name=server_id size=10 maxlength=10 value=\"$row[0]\">$NWB#servers-server_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Descrizione Server: </td><td align=left><input type=text name=server_description size=30 maxlength=255 value=\"$row[1]\">$NWB#servers-server_description$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Indirizzo IP del Server: </td><td align=left><input type=text name=server_ip size=20 maxlength=15 value=\"$row[2]\">$NWB#servers-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Attivo: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option selected>$row[3]</option></select>$NWB#servers-active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Versione Di Asterisk: </td><td align=left><input type=text name=asterisk_version size=20 maxlength=20 value=\"$row[4]\">$NWB#servers-asterisk_version$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Máx. Trunks en VICIDIAL: </td><td align=left><input type=text name=max_vicidial_trunks size=5 maxlength=4 value=\"$row[5]\">$NWB#servers-max_vicidial_trunks$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>El Marcar Del Balance de VICIDIAL: </td><td align=left><select size=1 name=vicidial_balance_active><option>Y</option><option>N</option><option selected>$row[20]</option></select>$NWB#servers-vicidial_balance_active$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Balance Offlimits de VICIDIAL: </td><td align=left><input type=text name=balance_trunks_offlimits size=5 maxlength=4 value=\"$row[21]\">$NWB#servers-balance_trunks_offlimits$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Host Telnet: </td><td align=left><input type=text name=telnet_host size=20 maxlength=20 value=\"$row[6]\">$NWB#servers-telnet_host$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Porta Telnet: </td><td align=left><input type=text name=telnet_port size=6 maxlength=5 value=\"$row[7]\">$NWB#servers-telnet_port$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Usuario Del Manager: </td><td align=left><input type=text name=ASTmgrUSERNAME size=20 maxlength=20 value=\"$row[8]\">$NWB#servers-ASTmgrUSERNAME$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Contraseña del Manager: </td><td align=left><input type=text name=ASTmgrSECRET size=20 maxlength=20 value=\"$row[9]\">$NWB#servers-ASTmgrSECRET$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Usuario del Updater del Manager: </td><td align=left><input type=text name=ASTmgrUSERNAMEupdate size=20 maxlength=20 value=\"$row[10]\">$NWB#servers-ASTmgrUSERNAMEupdate$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Usuario Listen del Manager: </td><td align=left><input type=text name=ASTmgrUSERNAMElisten size=20 maxlength=20 value=\"$row[11]\">$NWB#servers-ASTmgrUSERNAMElisten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Usuario Send del Manager: </td><td align=left><input type=text name=ASTmgrUSERNAMEsend size=20 maxlength=20 value=\"$row[12]\">$NWB#servers-ASTmgrUSERNAMEsend$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Fuso Orario Locale: </td><td align=left><select size=1 name=local_gmt><option>12.75</option><option>12.00</option><option>11.00</option><option>10.00</option><option>9.50</option><option>9.00</option><option>8.00</option><option>7.00</option><option>6.50</option><option>6.00</option><option>5.75</option><option>5.50</option><option>5.00</option><option>4.50</option><option>4.00</option><option>3.50</option><option>3.00</option><option>2.00</option><option>1.00</option><option>0.00</option><option>-1.00</option><option>-2.00</option><option>-3.00</option><option>-3.50</option><option>-4.00</option><option>-5.00</option><option>-6.00</option><option>-7.00</option><option>-8.00</option><option>-9.00</option><option>-10.00</option><option>-11.00</option><option>-12.00</option><option selected>$row[13]</option></select> (No ajustar para el DST)$NWB#servers-local_gmt$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Extension de Vmail Dump : </td><td align=left><input type=text name=voicemail_dump_exten size=20 maxlength=20 value=\"$row[14]\">$NWB#servers-voicemail_dump_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Extension del AD de VICIDIAL: </td><td align=left><input type=text name=answer_transfer_agent size=20 maxlength=20 value=\"$row[15]\">$NWB#servers-answer_transfer_agent$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Contexto por Defecto: </td><td align=left><input type=text name=ext_context size=20 maxlength=20 value=\"$row[16]\">$NWB#servers-ext_context$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Performance Di Sistema: </td><td align=left><select size=1 name=sys_perf_log><option>Y</option><option>N</option><option selected>$row[17]</option></select>$NWB#servers-sys_perf_log$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Log Server: </td><td align=left><select size=1 name=vd_server_logs><option>Y</option><option>N</option><option selected>$row[18]</option></select>$NWB#servers-vd_server_logs$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Salida de AGI: </td><td align=left><select size=1 name=agi_output><option>NESSUNO</option><option>STDERR</option><option>FILE</option><option>BOTH</option><option selected>$row[19]</option></select>$NWB#servers-agi_output$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center></form>\n";


	### vicidial server trunk records for this server
	echo "<br><br><b>TRONCOS DE VICIDIAL PARA ESTE SERVIDOR: &nbsp; $NWB#vicidial_server_trunks$NWE</b><br>\n";
	echo "<TABLE width=500 cellspacing=3>\n";
	echo "<tr><td> CAMPAGNA</td><td> TRONCOS </td><td> RESTRICCIo`N </td><td> </td><td> DELETE </td></tr>\n";

		$stmt="SELECT * from vicidial_server_trunks where server_ip='$server_ip' order by campaign_id";
		$rslt=mysql_query($stmt, $link);
		$recycle_to_print = mysql_num_rows($rslt);
		$o=0;
		while ($recycle_to_print > $o) {
			$rowx=mysql_fetch_row($rslt);
			$o++;

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		echo "<tr $bgcolor><td><font size=1>$rowx[1]<form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=server_ip value=\"$server_ip\">\n";
		echo "<input type=hidden name=campaign_id value=\"$rowx[1]\">\n";
		echo "<input type=hidden name=ADD value=421111111111></td>\n";
		echo "<td><font size=1><input size=6 maxlength=4 name=dedicated_trunks value=\"$rowx[2]\"></td>\n";
		echo "<td><select size=1 name=trunk_restriction><option>MAXIMUM_LIMIT</option><option>OVERFLOW_ALLOWED</option><option SELECTED>$rowx[3]</option></select></td>\n";
		echo "<td><font size=1><input type=submit name=submit value=MODIFY></form></td>\n";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=621111111111&campaign_id=$rowx[1]&server_ip=$server_ip\">CANCELLA</a></td></tr>\n";
		}

	echo "</table>\n";

	echo "<br><b>AGREGUE EL NUEVO EXPEDIENTE DEL TRONCO DEL SERVIDOR VICIDIAL</b><BR><form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=221111111111>\n";
	echo "<input type=hidden name=server_ip value=\"$server_ip\">\n";
	echo "TRUNKS: <input size=6 maxlength=4 name=dedicated_trunks><BR>\n";
	echo "CAMPAGNA: <select size=1 name=campaign_id>\n";
	echo "$campaigns_list\n";
	echo "</select><BR>\n";
	echo "RESTRICTION: <select size=1 name=trunk_restriction><option>MAXIMUM_LIMIT</option><option>OVERFLOW_ALLOWED</option></select><BR>\n";
	echo "<input type=submit name=submit value=ADD><BR>\n";

	echo "</center></FORM><br>\n";


	### list of phones on this server
	echo "<center>\n";
	echo "<br><b>TELEFONI IN QUESTO SERVER:</b><br>\n";
	echo "<TABLE width=400 cellspacing=3>\n";
	echo "<tr><td>INTERNO</td><td>NOME</td><td>ATTIVO</td></tr>\n";

		$active_phones = 0;
		$inactive_phones = 0;
		$stmt="SELECT extension,active,fullname from phones where server_ip='$row[2]'";
		$rsltx=mysql_query($stmt, $link);
		$lists_to_print = mysql_num_rows($rsltx);
		$camp_lists='';

		$o=0;
		while ($lists_to_print > $o) {
			$rowx=mysql_fetch_row($rsltx);
			$o++;
		if (ereg("Y", $rowx[1])) {$active_phones++;   $camp_lists .= "'$rowx[0]',";}
		if (ereg("N", $rowx[1])) {$inactive_phones++;}

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31111111111&extension=$rowx[0]&server_ip=$row[2]\">$rowx[0]</a></td><td><font size=1>$rowx[2]</td><td><font size=1>$rowx[1]</td></tr>\n";
		}

	echo "</table></center><br>\n";


	### list of conferences on this server
	echo "<center>\n";
	echo "<br><b>CONFERENCES WITHIN THIS SERVER:</b><br>\n";
	echo "<TABLE width=400 cellspacing=3>\n";
	echo "<tr><td>CONFERENCE</td><td>INTERNO</td></tr>\n";

		$active_confs = 0;
		$stmt="SELECT conf_exten,extension from conferences where server_ip='$row[2]'";
		$rsltx=mysql_query($stmt, $link);
		$lists_to_print = mysql_num_rows($rsltx);
		$camp_lists='';

		$o=0;
		while ($lists_to_print > $o) {
			$rowx=mysql_fetch_row($rsltx);
			$o++;
			$active_confs++;

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=3111111111111&conf_exten=$rowx[0]&server_ip=$row[2]\">$rowx[0]</a></td><td><font size=1>$rowx[2]</td></tr>\n";
		}

	echo "</table></center><br>\n";


	### list of vicidial conferences on this server
	echo "<center>\n";
	echo "<br><b>VICIDIAL CONFERENCES WITHIN THIS SERVER:</b><br>\n";
	echo "<TABLE width=400 cellspacing=3>\n";
	echo "<tr><td>VD CONFERENCE</td><td>INTERNO</td></tr>\n";

		$active_vdconfs = 0;
		$stmt="SELECT conf_exten,extension from vicidial_conferences where server_ip='$row[2]'";
		$rsltx=mysql_query($stmt, $link);
		$lists_to_print = mysql_num_rows($rsltx);
		$camp_lists='';

		$o=0;
		while ($lists_to_print > $o) {
			$rowx=mysql_fetch_row($rsltx);
			$o++;
			$active_vdconfs++;

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31111111111111&conf_exten=$rowx[0]&server_ip=$row[2]\">$rowx[0]</a></td><td><font size=1>$rowx[2]</td></tr>\n";
		}

	echo "</table></center><br>\n";


	echo "<center><b>\n";

		$camp_lists = eregi_replace(".$","",$camp_lists);
	echo "Questo server ha $active_phones telefoni attivi e $inactive_phones telefoni inattivi<br><br>\n";
	echo "Questo server ha $active_confs active conferences<br><br>\n";
	echo "Questo server ha $active_vdconfs active vicidial conferences<br><br>\n";
	echo "</b></center>\n";
	if ($LOGast_delete_phones > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=511111111111&server_id=$server_id&server_ip=$server_ip\">CANCELLA QUESTO SERVER</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=3111111111111 modify conference record in the system
######################

if ($ADD==3111111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from conferences where conf_exten='$conf_exten' and server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$conf_exten = $row[0];
	$server_ip = $row[1];

	echo "<br>MODIFICA DELLA CONFERENZA: $row[0]<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=4111111111111>\n";
	echo "<input type=hidden name=old_conf_exten value=\"$row[0]\">\n";
	echo "<input type=hidden name=old_server_ip value=\"$row[1]\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Conferenza: </td><td align=left><input type=text name=conf_exten size=10 maxlength=7 value=\"$row[0]\">$NWB#conferences-conf_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=311111111111&server_ip=$row[1]\">IP Server</a>: </td><td align=left><select size=1 name=server_ip>\n";

	echo "$servers_list";
	echo "<option SELECTED>$row[1]</option>\n";
	echo "</select>$NWB#conferences-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Interno Corrente: </td><td align=left><input type=text name=extension size=20 maxlength=20 value=\"$row[2]\"></td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";

	echo "<center><b>\n";
	if ($LOGast_delete_phones > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=5111111111111&conf_exten=$conf_exten&server_ip=$server_ip\">CANCELLA QUESTA CONFERENZA</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}


######################
# ADD=31111111111111 modify vicidial conference record in the system
######################

if ($ADD==31111111111111)
{
	if ($LOGast_admin_access==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_conferences where conf_exten='$conf_exten' and server_ip='$server_ip';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$conf_exten = $row[0];
	$server_ip = $row[1];

	echo "<br>MODIFY A VICIDIAL CONFERENCE RECORD: $row[0]<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=41111111111111>\n";
	echo "<input type=hidden name=old_conf_exten value=\"$row[0]\">\n";
	echo "<input type=hidden name=old_server_ip value=\"$row[1]\">\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Conferenza: </td><td align=left><input type=text name=conf_exten size=10 maxlength=7 value=\"$row[0]\">$NWB#conferences-conf_exten$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=311111111111&server_ip=$row[1]\">IP Server</a>: </td><td align=left><select size=1 name=server_ip>\n";

	echo "$servers_list";
	echo "<option SELECTED>$row[1]</option>\n";
	echo "</select>$NWB#conferences-server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Interno Corrente: </td><td align=left><input type=text name=extension size=20 maxlength=20 value=\"$row[2]\"></td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";

	echo "<center><b>\n";
	if ($LOGast_delete_phones > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=51111111111111&conf_exten=$conf_exten&server_ip=$server_ip\">CANCELLA QUESTA CONFERENZA VICIDIAL</a>\n";
		}
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}



######################
# ADD=311111111111111 modify vicidial system settings
######################

if ($ADD==311111111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT version,install_date,use_non_latin,webroot_writable,enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_url,queuemetrics_log_id,queuemetrics_eq_prepend,vicidial_agent_disable,allow_sipsak_messages,admin_home_url,enable_agc_xfer_log,db_schema_version,auto_user_add_value,timeclock_end_of_day,timeclock_last_reset_date,vdc_header_date_format,vdc_customer_date_format,vdc_header_phone_format,vdc_agent_api_active,qc_last_pull_time from system_settings;";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$version =						$row[0];
	$install_date =					$row[1];
	$use_non_latin =				$row[2];
	$webroot_writable =				$row[3];
	$enable_queuemetrics_logging =	$row[4];
	$queuemetrics_server_ip =		$row[5];
	$queuemetrics_dbname =			$row[6];
	$queuemetrics_login =			$row[7];
	$queuemetrics_pass =			$row[8];
	$queuemetrics_url =				$row[9];
	$queuemetrics_log_id =			$row[10];
	$queuemetrics_eq_prepend =		$row[11];
	$vicidial_agent_disable =		$row[12];
	$allow_sipsak_messages =		$row[13];
	$admin_home_url =				$row[14];
	$enable_agc_xfer_log =			$row[15];
	$db_schema_version =			$row[16];
	$auto_user_add_value =			$row[17];
	$timeclock_end_of_day =			$row[18];
	$timeclock_last_reset_date =	$row[19];
	$vdc_header_date_format =		$row[20];
	$vdc_customer_date_format =		$row[21];
	$vdc_header_phone_format =		$row[22];
	$vdc_agent_api_active =			$row[23];
	$qc_last_pull_time = 			$row[24];

	echo "<br>MODIFICA IMPOSTAZIONI DI SISTEMA<form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=411111111111111>\n";
	echo "<center><TABLE width=$section_width cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Versione: </td><td align=left> $version</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>DB Schema Versione: </td><td align=left> $db_schema_version</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Auto User-add Value: </td><td align=left> $auto_user_add_value</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Install Date: </td><td align=left> $install_date</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>UsA Non-Latino: </td><td align=left><select size=1 name=use_non_latin><option>1</option><option>0</option><option selected>$use_non_latin</option></select>$NWB#settings-use_non_latin$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Webroot Escribible: </td><td align=left><select size=1 name=webroot_writable><option>1</option><option>0</option><option selected>$webroot_writable</option></select>$NWB#settings-webroot_writable$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Permita La Registracion De QueueMetrics: </td><td align=left><select size=1 name=enable_queuemetrics_logging><option>1</option><option>0</option><option selected>$enable_queuemetrics_logging</option></select>$NWB#settings-enable_queuemetrics_logging$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>IP Del Servidor De QueueMetrics: </td><td align=left><input type=text name=queuemetrics_server_ip size=18 maxlength=15 value=\"$queuemetrics_server_ip\">$NWB#settings-queuemetrics_server_ip$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Nombre del DB De QueueMetrics: </td><td align=left><input type=text name=queuemetrics_dbname size=18 maxlength=50 value=\"$queuemetrics_dbname\">$NWB#settings-queuemetrics_dbname$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>conexion del DB De QueueMetrics: </td><td align=left><input type=text name=queuemetrics_login size=18 maxlength=50 value=\"$queuemetrics_login\">$NWB#settings-queuemetrics_login$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Contraseña del DB De QueueMetrics: </td><td align=left><input type=text name=queuemetrics_pass size=18 maxlength=50 value=\"$queuemetrics_pass\">$NWB#settings-queuemetrics_pass$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>QueueMetrics URL: </td><td align=left><input type=text name=queuemetrics_url size=50 maxlength=255 value=\"$queuemetrics_url\">$NWB#settings-queuemetrics_url$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Log ID QueueMetrics: </td><td align=left><input type=text name=queuemetrics_log_id size=12 maxlength=10 value=\"$queuemetrics_log_id\">$NWB#settings-queuemetrics_log_id$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>QueueMetrics EnterQueue Prepend: </td><td align=left><select size=1 name=queuemetrics_eq_prepend>\n";
	echo "<option value=\"NONE\">NESSUNO</option>\n";
	echo "<option value=\"lead_id\">lead_id</option>\n";
	echo "<option value=\"list_id\">list_id</option>\n";
	echo "<option value=\"source_id\">source_id</option>\n";
	echo "<option value=\"vendor_lead_code\">vendor_lead_code</option>\n";
	echo "<option value=\"address3\">address3</option>\n";
	echo "<option value=\"security_phrase\">security_phrase</option>\n";
	echo "<option selected value=\"$queuemetrics_eq_prepend\">$queuemetrics_eq_prepend</option>\n";
	echo "</select>$NWB#settings-queuemetrics_eq_prepend$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>El Agente de VICIDIAL Inhabilita La Exhibicio`n:</td><td align=left><select size=1 name=vicidial_agent_disable>\n";
	echo "<option value=\"NOT_ACTIVE\">NOT_ACTIVE</option>\n";
	echo "<option value=\"LIVE_AGENT\">LIVE_AGENT</option>\n";
	echo "<option value=\"EXTERNAL\">EXTERNAL</option>\n";
	echo "<option value=\"ALL\">ALL</option>\n";
	echo "<option selected value=\"$vicidial_agent_disable\">$vicidial_agent_disable</option>\n";
	echo "</select>$NWB#settings-vicidial_agent_disable$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Permetti messaggi SIPSAK: </td><td align=left><select size=1 name=allow_sipsak_messages><option>1</option><option>0</option><option selected>$allow_sipsak_messages</option></select>$NWB#settings-allow_sipsak_messages$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>URL Home Amministrazione: </td><td align=left><input type=text name=admin_home_url size=50 maxlength=255 value=\"$admin_home_url\">$NWB#settings-admin_home_url$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Permita El Logfile De la Transferencia Del Agente: </td><td align=left><select size=1 name=enable_agc_xfer_log><option>1</option><option>0</option><option selected>$enable_agc_xfer_log</option></select>$NWB#settings-enable_agc_xfer_log$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Timeclock End Of Day: </td><td align=left><input type=text name=timeclock_end_of_day size=5 maxlength=4 value=\"$timeclock_end_of_day\">$NWB#settings-timeclock_end_of_day$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Timeclock Last Auto Logout: </td><td align=left> $timeclock_last_reset_date</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>QC Last Pull Time: </td><td align=left> $qc_last_pull_time</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Agent Screen Header Date Format: </td><td align=left><select size=1 name=vdc_header_date_format>\n";
	echo "<option>MS_DASH_24HR  2008-06-24 23:59:59</option>\n";
	echo "<option>US_SLASH_24HR 06/24/2008 23:59:59</option>\n";
	echo "<option>EU_SLASH_24HR 24/06/2008 23:59:59</option>\n";
	echo "<option>AL_TEXT_24HR  JUN 24 23:59:59</option>\n";
	echo "<option>MS_DASH_AMPM  2008-06-24 11:59:59 PM</option>\n";
	echo "<option>US_SLASH_AMPM 06/24/2008 11:59:59 PM</option>\n";
	echo "<option>EU_SLASH_AMPM 24/06/2008 11:59:59 PM</option>\n";
	echo "<option>AL_TEXT_AMPM  JUN 24 11:59:59 PM</option>\n";
	echo "<option selected value=\"$vdc_header_date_format\">$vdc_header_date_format</option>\n";
	echo "</select>$NWB#settings-vdc_header_date_format$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Agent Screen Customer Date Format: </td><td align=left><select size=1 name=vdc_customer_date_format>\n";
	echo "<option>MS_DASH_24HR  2008-06-24 23:59:59</option>\n";
	echo "<option>US_SLASH_24HR 06/24/2008 23:59:59</option>\n";
	echo "<option>EU_SLASH_24HR 24/06/2008 23:59:59</option>\n";
	echo "<option>AL_TEXT_24HR  JUN 24 23:59:59</option>\n";
	echo "<option>MS_DASH_AMPM  2008-06-24 11:59:59 PM</option>\n";
	echo "<option>US_SLASH_AMPM 06/24/2008 11:59:59 PM</option>\n";
	echo "<option>EU_SLASH_AMPM 24/06/2008 11:59:59 PM</option>\n";
	echo "<option>AL_TEXT_AMPM  JUN 24 11:59:59 PM</option>\n";
	echo "<option selected value=\"$vdc_customer_date_format\">$vdc_customer_date_format</option>\n";
	echo "</select>$NWB#settings-vdc_customer_date_format$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Agent Screen Customer Phone Format: </td><td align=left><select size=1 name=vdc_header_phone_format>\n";
	echo "<option>US_DASH 000-000-0000</option>\n";
	echo "<option>US_PARN (000)000-0000</option>\n";
	echo "<option>MS_NODS 0000000000</option>\n";
	echo "<option>UK_DASH 00 0000-0000</option>\n";
	echo "<option>AU_SPAC 000 000 000</option>\n";
	echo "<option>IT_DASH 0000-000-000</option>\n";
	echo "<option>FR_SPAC 00 00 00 00 00</option>\n";
	echo "<option selected value=\"$vdc_header_phone_format\">$vdc_header_phone_format</option>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Agent API Attivo: </td><td align=left><select size=1 name=vdc_agent_api_active><option>1</option><option>0</option><option selected>$vdc_agent_api_active</option></select>$NWB#settings-vdc_agent_api_active$NWE</td></tr>\n";
	echo "</select>$NWB#settings-vdc_header_phone_format$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=submit VALUE=INVIA></td></tr>\n";
	echo "</TABLE></center>\n";
	echo "</form>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}






######################
# ADD=321111111111111 modify vicidial system statuses
######################

if ($ADD==321111111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br><center>\n";
	echo "<b>ESITI DI DEFAULT IN QUESTO SISTEMA: &nbsp; $NWB#vicidial_statuses$NWE</b><br>\n";
	echo "<TABLE width=700 cellspacing=3>\n";
	echo "<tr><td>ESITO</td><td>DESCRIZIONE</td><td>SELEZIO<BR>NABILE</td><td>RISPOSTA<BR>UMANA</td><td>CATEGORIA</td><td>MODIFICA/CANCELLA</td></tr>\n";

	##### get status category listings for dynamic pulldown
	$stmt="SELECT vsc_id,vsc_name from vicidial_status_categories order by vsc_id desc";
	$rslt=mysql_query($stmt, $link);
	$cats_to_print = mysql_num_rows($rslt);
	$cats_list="";

	$o=0;
	while ($cats_to_print > $o)
		{
		$rowx=mysql_fetch_row($rslt);
		$cats_list .= "<option value=\"$rowx[0]\">$rowx[0] - " . substr($rowx[1],0,20) . "</option>\n";
		$catsname_list["$rowx[0]"] = substr($rowx[1],0,20);
		$o++;
		}


	$stmt="SELECT * from vicidial_statuses order by status;";
	$rslt=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rslt);
	$o=0;
	while ($statuses_to_print > $o) 
		{
		$rowx=mysql_fetch_row($rslt);
		$AScategory = $rowx[4];
		$o++;

		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		echo "<tr $bgcolor><td><form action=$PHP_SELF method=POST>\n";
		echo "<input type=hidden name=ADD value=421111111111111>\n";
		echo "<input type=hidden name=stage value=modify>\n";
		echo "<input type=hidden name=status value=\"$rowx[0]\">\n";
		echo "<font size=2><B>$rowx[0]</B></td>\n";
		echo "<td><input type=text name=status_name size=20 maxlength=30 value=\"$rowx[1]\"></td>\n";
		echo "<td><select size=1 name=selectable><option>Y</option><option>N</option><option selected>$rowx[2]</option></select></td>\n";
		echo "<td><select size=1 name=human_answered><option>Y</option><option>N</option><option selected>$rowx[3]</option></select></td>\n";
		echo "<td>\n";
		echo "<select size=1 name=category>\n";
		echo "$cats_list";
		echo "<option selected value=\"$AScategory\">$AScategory - $catsname_list[$AScategory]</option>\n";
		echo "</select>\n";
		echo "</td>\n";
		echo "<td align=center nowrap><font size=1><input type=submit name=submit value=MODIFY> &nbsp; &nbsp; &nbsp; &nbsp; \n";
		echo " &nbsp; \n";
		
		if (preg_match("/^B$|^NA$|^DNC$|^NA$|^DROP$|^INCALL$|^QUEUE$|^NEW$/i",$rowx[0]))
			{
			echo "<DEL>CANCELLA</DEL>\n";
			}
		else
			{
			echo "<a href=\"$PHP_SELF?ADD=421111111111111&status=$rowx[0]&stage=delete\">CANCELLA</a>\n";
			}
		echo "</form></td></tr>\n";
		}

	echo "</table>\n";

	echo "<br>AGGIUNGI UN NUOVO ESITO DI DEFAULT<BR><form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=221111111111111>\n";
	echo "Esito: <input type=text name=status size=7 maxlength=6> &nbsp; \n";
	echo "Descrizione: <input type=text name=status_name size=30 maxlength=30><BR>\n";
	echo "Selezionabile: <select size=1 name=selectable><option>Y</option><option>N</option></select> &nbsp; \n";
	echo "Risposta Umana: <select size=1 name=human_answered><option>Y</option><option>N</option></select> &nbsp; \n";
	echo "Categoria: \n";
	echo "<select size=1 name=category>\n";
	echo "$cats_list";
	echo "<option selected value=\"$AScategory\">$AScategory - $catsname_list[$AScategory]</option>\n";
	echo "</select> &nbsp; <BR>\n";
	echo "<input type=submit name=submit value=ADD><BR>\n";

	echo "</FORM><br>\n";

	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}





######################
# ADD=331111111111111 modify vicidial status categories
######################

if ($ADD==331111111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br><center>\n";
	echo "<b>VICIDIAL STATUS CATEGORIES: &nbsp; $NWB#vicidial_status_categories$NWE</b><br>\n";
	echo "<TABLE width=700 cellspacing=3>\n";
	echo "<tr><td>CATEGORIA</td><td>NOME</td><td>STATUSES IN THIS CATEGORY</td></tr>\n";

		$stmt="SELECT * from vicidial_status_categories order by vsc_id;";
		$rslt=mysql_query($stmt, $link);
		$statuses_to_print = mysql_num_rows($rslt);
		$o=0;
		while ($statuses_to_print > $o) 
			{
			$rowx=mysql_fetch_row($rslt);
			$Avsc_id[$o] =				$rowx[0];
			$Avsc_name[$o] =			$rowx[1];
			$Avsc_description[$o] =		$rowx[2];
			$Atovdad_display[$o] =		$rowx[3];
			$Asale_category[$o] =		$rowx[4];
			$Adead_lead_category[$o] =	$rowx[5];
			$o++;
			}
		$p=0;
		while ($o > $p)
			{
			if (eregi("1$|3$|5$|7$|9$", $p))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}

			$CATstatuses='';
			$stmt="SELECT status from vicidial_statuses where category='$Avsc_id[$p]' order by status;";
			$rslt=mysql_query($stmt, $link);
			$statuses_to_print = mysql_num_rows($rslt);
			$q=0;
			while ($statuses_to_print > $q) 
				{
				$rowx=mysql_fetch_row($rslt);
				$CATstatuses.=" $rowx[0]";
				$q++;
				}
			$stmt="SELECT status from vicidial_campaign_statuses where category='$Avsc_id[$p]' order by status;";
			$rslt=mysql_query($stmt, $link);
			$statuses_to_print = mysql_num_rows($rslt);
			$q=0;
			while ($statuses_to_print > $q) 
				{
				$rowx=mysql_fetch_row($rslt);
				$CATstatuses.=" $rowx[0]";
				$q++;
				}

			echo "<tr $bgcolor><td><form action=$PHP_SELF method=POST>\n";
			echo "<input type=hidden name=ADD value=431111111111111>\n";
			echo "<input type=hidden name=stage value=modify>\n";
			echo "<input type=hidden name=vsc_id value=\"$Avsc_id[$p]\">\n";
			echo "<font size=2><B>$Avsc_id[$p]</B></td>\n";
			echo "<td><input type=text name=vsc_name size=30 maxlength=50 value=\"$Avsc_name[$p]\"></td>\n";
			echo "<td><font size=1>\n";
			echo "$CATstatuses";
			echo "</td></tr>\n";
			echo "<tr $bgcolor>\n";
			echo "<td colspan=3>TO VDAD Display: <select size=1 name=tovdad_display><option>Y</option><option>N</option><option selected>$Atovdad_display[$p]</option></select> &nbsp; &nbsp; Sale Categoria: <select size=1 name=sale_category><option>Y</option><option>N</option><option selected>$Asale_category[$p]</option></select> &nbsp; &nbsp; Dead Lead Categoria: <select size=1 name=dead_lead_category><option>Y</option><option>N</option><option selected>$Adead_lead_category[$p]</option></select> &nbsp; </td></tr>\n";
			echo "<tr $bgcolor><td colspan=3><font size=1>Descrizione: <input type=text name=vsc_description size=90 maxlength=255 value=\"$Avsc_description[$p]\"></td></tr>\n";
			echo "<tr $bgcolor><td colspan=3 align=center><font size=1><input type=submit name=submit value=MODIFY> &nbsp; &nbsp; &nbsp; &nbsp; \n";
			echo " &nbsp; <a href=\"$PHP_SELF?ADD=431111111111111&vsc_id=$Avsc_id[$p]&stage=delete\">CANCELLA</a></td></tr>\n";
			echo "<tr><td colspan=4><font size=1> &nbsp; </form></td></tr>\n";

			$p++;
			}

	echo "</table>\n";

	echo "<br>AGGIUNGI NUOVA CATEGORIA DI ESITI<BR><form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=231111111111111>\n";
	echo "Category ID: <input type=text name=vsc_id size=20 maxlength=20> &nbsp; \n";
	echo "Name: <input type=text name=vsc_name size=20 maxlength=50> &nbsp; <BR>\n";
	echo "TimeOnVDAD Display: <select size=1 name=tovdad_display><option>Y</option><option selected>N</option></select> &nbsp; \n";
	echo "Sale Categoria: <select size=1 name=sale_category><option>Y</option><option selected>N</option></select> &nbsp; \n";
	echo "Dead Lead Categoria: <select size=1 name=dead_lead_category><option>Y</option><option selected>N</option></select> &nbsp; <BR>\n";
	echo "Descrizione: <input type=text name=vsc_description size=80 maxlength=255> &nbsp; \n";
	echo "<input type=submit name=submit value=ADD><BR>\n";

	echo "</FORM><br>\n";

	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}





######################
# ADD=341111111111111 modify vicidial QC status code
######################

if ($ADD==341111111111111)
{
	if ($LOGmodify_servers==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	echo "<br><center>\n";
	echo "<b>VICIDIAL QC STATUS CODES WITHIN THIS SYSTEM: &nbsp; $NWB#vicidial_qc_status_codes$NWE</b><br>\n";
	echo "<TABLE width=600 cellspacing=3>\n";
	echo "<tr><td>STATUS CODE</td><td>DESCRIZIONE</td><td>MODIFICA/CANCELLA</td></tr>\n";

	##### go through each QC status code
	$stmt="SELECT count(*) from vicidial_qc_codes;";
	$rslt=mysql_query($stmt, $link);
	$rowx=mysql_fetch_row($rslt);
	if ($rowx[0] > 0)
		{
		$stmt="SELECT code,code_name from vicidial_qc_codes order by code;";
		$rslt=mysql_query($stmt, $link);
		$statuses_to_print = mysql_num_rows($rslt);
		$o=0;
		while ($statuses_to_print > $o) 
			{
			$rowx=mysql_fetch_row($rslt);
			$o++;

			if (eregi("1$|3$|5$|7$|9$", $o))
				{$bgcolor='bgcolor="#B9CBFD"';} 
			else
				{$bgcolor='bgcolor="#9BB9FB"';}

			echo "<tr $bgcolor><td><form action=$PHP_SELF method=POST>\n";
			echo "<input type=hidden name=ADD value=441111111111111>\n";
			echo "<input type=hidden name=stage value=modify>\n";
			echo "<input type=hidden name=code value=\"$rowx[0]\">\n";
			echo "<font size=2><B>$rowx[0]</B></td>\n";
			echo "<td><input type=text name=code_name size=20 maxlength=30 value=\"$rowx[1]\"></td>\n";
			echo "<td align=center nowrap><font size=1><input type=submit name=submit value=MODIFY> &nbsp; &nbsp; &nbsp; &nbsp; \n";
			echo " &nbsp; \n";
			
			if (preg_match("/^B$|^NA$|^DNC$|^NA$|^DROP$|^INCALL$|^QUEUE$|^NEW$/i",$rowx[0]))
				{
				echo "<DEL>CANCELLA</DEL>\n";
				}
			else
				{
				echo "<a href=\"$PHP_SELF?ADD=441111111111111&status=$rowx[0]&stage=delete\">CANCELLA</a>\n";
				}
			echo "</form></td></tr>\n";
			}
		}
	echo "</table>\n";

	echo "<br>ADD NEW QC STATUS CODE<BR><form action=$PHP_SELF method=POST>\n";
	echo "<input type=hidden name=ADD value=241111111111111>\n";
	echo "Esito: <input type=text name=code size=9 maxlength=8> &nbsp; \n";
	echo "Descrizione: <input type=text name=code_name size=30 maxlength=30><BR>\n";
	echo "<input type=submit name=submit value=ADD><BR>\n";

	echo "</FORM><br>\n";

	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}






######################
# ADD=550 search form
######################

if ($ADD==550)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>RICERCA UTENTI<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=660>\n";
echo "<center><TABLE width=$section_width cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Numero Utente: </td><td align=left><input type=text name=user size=20 maxlength=20></td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Nome Completo: </td><td align=left><input type=text name=full_name size=30 maxlength=30></td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Livello Utente: </td><td align=left><select size=1 name=user_level><option selected>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option></select></td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Gruppo Utente: </td><td align=left><select size=1 name=user_group>\n";

	$stmt="SELECT * from vicidial_user_groups order by user_group";
	$rslt=mysql_query($stmt, $link);
	$groups_to_print = mysql_num_rows($rslt);
	$o=0;
	$groups_list='';
	while ($groups_to_print > $o) {
		$rowx=mysql_fetch_row($rslt);
		$groups_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
	}
echo "$groups_list</select></td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=search value=search></td></tr>\n";
echo "</TABLE></center>\n";

}

######################
# ADD=660 user search results
######################

if ($ADD==660)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$SQL = '';
	if ($user) {$SQL .= " user LIKE \"%$user%\" and";}
	if ($full_name) {$SQL .= " full_name LIKE \"%$full_name%\" and";}
	if ($user_level > 0) {$SQL .= " user_level LIKE \"%$user_level%\" and";}
	if ($user_group) {$SQL .= " user_group = '$user_group' and";}
	$SQL = eregi_replace(" and$", "", $SQL);
	if (strlen($SQL)>5) {$SQL = "where $SQL";}

	$stmt="SELECT * from vicidial_users $SQL order by full_name desc;";
#	echo "\n|$stmt|\n";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>RESULTADOS DE LA BÚSQUEDA:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1>$row[1]</td><td><font size=1>$row[3]</td><td><font size=1>$row[4]</td><td><font size=1>$row[5]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3&user=$row[1]\">MODIFICA</a> | <a href=\"./user_stats.php?user=$row[1]\">STATISTICHE</a> | <a href=\"./user_status.php?user=$row[1]\">ESITO</a> | <a href=\"./AST_agent_time_sheet.php?agent=$row[1]\">TIME</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";

}


######################################################################################################
######################################################################################################
#######   8 series, Callback lists
######################################################################################################
######################################################################################################

######################
# ADD=8 find all callbacks on hold by a User
######################
if ($ADD==8)
{
	if ($LOGmodify_users==1)
	{
		if ($SUB==89)
		{
		$stmt="UPDATE vicidial_callbacks SET status='INACTIVE' where user='$user' and status='LIVE' and callback_time < '$past_month_date';";
		$rslt=mysql_query($stmt, $link);
		echo "<br>User($user) callback listings LIVE for more than one month have been made INACTIVE\n";
		}
		if ($SUB==899)
		{
		$stmt="UPDATE vicidial_callbacks SET status='INACTIVE' where user='$user' and status='LIVE' and callback_time < '$past_week_date';";
		$rslt=mysql_query($stmt, $link);
		echo "<br>User($user) callback listings LIVE for more than one week have been made INACTIVE\n";
		}
	}
$CBinactiveLINK = "<BR><a href=\"$PHP_SELF?ADD=8&SUB=89&user=$user\">Remove LIVE Callbacks older than one month for this user</a><BR><a href=\"$PHP_SELF?ADD=8&SUB=899&user=$user\">Remove LIVE Callbacks older than one week for this user</a><BR>";

echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$CBquerySQLwhere = "and user='$user'";

echo "<br>ELENCO RICHIAMI DA EFFETTUARE PER L`UTENTE: $user\n";
$oldADD = "ADD=8&user=$user";
$ADD='82';
}

######################
# ADD=81 find all callbacks on hold within a Campaign
######################
if ($ADD==81)
{
	if ($LOGmodify_campaigns==1)
	{
		if ($SUB==89)
		{
		$stmt="UPDATE vicidial_callbacks SET status='INACTIVE' where campaign_id='$campaign_id' and status='LIVE' and callback_time < '$past_month_date';";
		$rslt=mysql_query($stmt, $link);
		echo "<br>campaign($campaign_id) callback listings LIVE for more than one month have been made INACTIVE\n";
		}
		if ($SUB==899)
		{
		$stmt="UPDATE vicidial_callbacks SET status='INACTIVE' where campaign_id='$campaign_id' and status='LIVE' and callback_time < '$past_week_date';";
		$rslt=mysql_query($stmt, $link);
		echo "<br>campaign($campaign_id) callback listings LIVE for more than one week have been made INACTIVE\n";
		}
	}
$CBinactiveLINK = "<BR><a href=\"$PHP_SELF?ADD=81&SUB=89&campaign_id=$campaign_id\">Remove LIVE Callbacks older than one month for this campaign</a><BR><a href=\"$PHP_SELF?ADD=81&SUB=899&campaign_id=$campaign_id\">Remove LIVE Callbacks older than one week for this campaign</a><BR>";

echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$CBquerySQLwhere = "and campaign_id='$campaign_id'";

echo "<br>CAMPAIGN CALLBACK HOLD LISTINGS: $campaign_id\n";
$oldADD = "ADD=81&campaign_id=$campaign_id";
$ADD='82';
}

######################
# ADD=811 find all callbacks on hold within a List
######################
if ($ADD==811)
{
	if ($LOGmodify_lists==1)
	{
		if ($SUB==89)
		{
		$stmt="UPDATE vicidial_callbacks SET status='INACTIVE' where list_id='$list_id' and status='LIVE' and callback_time < '$past_month_date';";
		$rslt=mysql_query($stmt, $link);
		echo "<br>list($list_id) callback listings LIVE for more than one month have been made INACTIVE\n";
		}
		if ($SUB==899)
		{
		$stmt="UPDATE vicidial_callbacks SET status='INACTIVE' where list_id='$list_id' and status='LIVE' and callback_time < '$past_week_date';";
		$rslt=mysql_query($stmt, $link);
		echo "<br>list($list_id) callback listings LIVE for more than one week have been made INACTIVE\n";
		}
	}
$CBinactiveLINK = "<BR><a href=\"$PHP_SELF?ADD=811&SUB=89&list_id=$list_id\">Remove LIVE Callbacks older than one month for this list</a><BR><a href=\"$PHP_SELF?ADD=811&SUB=899&list_id=$list_id\">Remove LIVE Callbacks older than one week for this list</a><BR>";

echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$CBquerySQLwhere = "and list_id='$list_id'";

echo "<br>LIST CALLBACK HOLD LISTINGS: $list_id\n";
$oldADD = "ADD=811&list_id=$list_id";
$ADD='82';
}

######################
# ADD=8111 find all callbacks on hold within a user group
######################
if ($ADD==8111)
{
	if ($LOGmodify_usergroups==1)
	{
		if ($SUB==89)
		{
		$stmt="UPDATE vicidial_callbacks SET status='INACTIVE' where user_group='$user_group' and status='LIVE' and callback_time < '$past_month_date';";
		$rslt=mysql_query($stmt, $link);
		echo "<br>user group($user_group) callback listings LIVE for more than one month have been made INACTIVE\n";
		}
		if ($SUB==899)
		{
		$stmt="UPDATE vicidial_callbacks SET status='INACTIVE' where user_group='$user_group' and status='LIVE' and callback_time < '$past_week_date';";
		$rslt=mysql_query($stmt, $link);
		echo "<br>user group($user_group) callback listings LIVE for more than one week have been made INACTIVE\n";
		}
	}
	$CBinactiveLINK = "<BR><a href=\"$PHP_SELF?ADD=8111&SUB=89&user_group=$user_group\">Remove LIVE Callbacks older than one month for this user group</a><BR><a href=\"$PHP_SELF?ADD=8111&SUB=899&user_group=$user_group\">Remove LIVE Callbacks older than one week for this user group</a><BR>";

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$CBquerySQLwhere = "and user_group='$user_group'";

echo "<br>USER GROUP CALLBACK HOLD LISTINGS: $list_id\n";
$oldADD = "ADD=8111&user_group=$user_group";
$ADD='82';
}

######################
# ADD=82 display all callbacks on hold
######################
if ($ADD==82)
{

$USERlink='stage=USERIDDOWN';
$GROUPlink='stage=GROUPDOWN';
$ENDATElink='stage=ENDATEDOWN';
$SQLorder='order by ';
if (eregi("USERIDDOWN",$stage)) {$SQLorder='order by user desc,';   $USERlink='stage=USERIDUP';}
if (eregi("GROUPDOWN",$stage)) {$SQLorder='order by user_group desc,';   $NAMElink='stage=NAMEUP';}
if (eregi("ENDATEDOWN",$stage)) {$SQLorder='order by entry_time desc,';   $LEVELlink='stage=LEVELUP';}

	$stmt="SELECT * from vicidial_callbacks where status IN('ACTIVE','LIVE') $CBquerySQLwhere $SQLorder recipient,status desc,callback_time";
	$rslt=mysql_query($stmt, $link);
	$cb_to_print = mysql_num_rows($rslt);

echo "<TABLE><TR><TD>\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr bgcolor=black>\n";
echo "<td><font size=1 color=white>CONTATTO</td><td><font size=1 color=white>LIST</td>\n";
echo "<td><font size=1 color=white> CAMPAGNA</td>\n";
echo "<td><a href=\"$PHP_SELF?$oldADD&$ENDATElink\"><font size=1 color=white><B>ENTRY DATA</B></a></td>\n";
echo "<td><font size=1 color=white>CALLBACK DATA</td>\n";
echo "<td><a href=\"$PHP_SELF?$oldADD&$USERlink\"><font size=1 color=white><B>UTENTE</B></a></td>\n";
echo "<td><font size=1 color=white>RECIPIENT</td>\n";
echo "<td><font size=1 color=white>ESITO</td>\n";
echo "<td><a href=\"$PHP_SELF?$oldADD&$GROUPlink\"><font size=1 color=white><B>GRUPPO</B></a></td></tr>\n";

	$o=0;
	while ($cb_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor>";
		echo "<td><font size=1><A HREF=\"admin_modify_lead.php?lead_id=$row[1]\" target=\"_blank\">$row[1]</A></td>";
		echo "<td><font size=1><A HREF=\"$PHP_SELF?ADD=311&list_id=$row[2]\">$row[2]</A></td>";
		echo "<td><font size=1><A HREF=\"$PHP_SELF?ADD=31&campaign_id=$row[3]\">$row[3]</A></td>";
		echo "<td><font size=1>$row[5]</td>";
		echo "<td><font size=1>$row[6]</td>";
		echo "<td><font size=1><A HREF=\"$PHP_SELF?ADD=3&user=$row[8]\">$row[8]</A></td>";
		echo "<td><font size=1>$row[9]</td>";
		echo "<td><font size=1>$row[4]</td>";
		echo "<td><font size=1><A HREF=\"$PHP_SELF?ADD=311111&user_group=$row[11]\">$row[11]</A></td>";
		echo "</tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";

echo "$CBinactiveLINK";
}



######################################################################################################
######################################################################################################
#######   0 series, displays and searches
######################################################################################################
######################################################################################################

######################
# ADD=0 display all active users
######################
if ($ADD==0)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

$USERlink='stage=USERIDDOWN';
$NAMElink='stage=NAMEDOWN';
$LEVELlink='stage=LEVELDOWN';
$GROUPlink='stage=GROUPDOWN';
$SQLorder='order by full_name';
if (eregi("USERIDUP",$stage)) {$SQLorder='order by user asc';   $USERlink='stage=USERIDDOWN';}
if (eregi("USERIDDOWN",$stage)) {$SQLorder='order by user desc';   $USERlink='stage=USERIDUP';}
if (eregi("NAMEUP",$stage)) {$SQLorder='order by full_name asc';   $NAMElink='stage=NAMEDOWN';}
if (eregi("NAMEDOWN",$stage)) {$SQLorder='order by full_name desc';   $NAMElink='stage=NAMEUP';}
if (eregi("LEVELUP",$stage)) {$SQLorder='order by user_level asc';   $LEVELlink='stage=LEVELDOWN';}
if (eregi("LEVELDOWN",$stage)) {$SQLorder='order by user_level desc';   $LEVELlink='stage=LEVELUP';}
if (eregi("GROUPUP",$stage)) {$SQLorder='order by user_group asc';   $GROUPlink='stage=GROUPDOWN';}
if (eregi("GROUPDOWN",$stage)) {$SQLorder='order by user_group desc';   $GROUPlink='stage=GROUPUP';}
	$stmt="SELECT * from vicidial_users $SQLorder";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO UTENTI:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr bgcolor=black>";
echo "<td><a href=\"$PHP_SELF?ADD=0&$USERlink\"><font size=1 color=white><B>ID UTENTE</B></a></td>";
echo "<td><a href=\"$PHP_SELF?ADD=0&$NAMElink\"><font size=1 color=white><B>NOME COMPLETO</B></a></td>";
echo "<td><a href=\"$PHP_SELF?ADD=0&$LEVELlink\"><font size=1 color=white><B>LIVELLO</B></a></td>";
echo "<td><a href=\"$PHP_SELF?ADD=0&$GROUPlink\"><font size=1 color=white><B>GRUPPO</B></a></td>";
echo "<td align=center><font size=1 color=white><B>LINKS</B></td></tr>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><a href=\"$PHP_SELF?ADD=3&user=$row[1]\"><font size=1 color=black>$row[1]</a></td><td><font size=1>$row[3]</td><td><font size=1>$row[4]</td><td><font size=1>$row[5]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3&user=$row[1]\">MODIFICA</a> | <a href=\"./user_stats.php?user=$row[1]\">STATISTICHE</a> | <a href=\"./user_status.php?user=$row[1]\">ESITO</a> | <a href=\"./AST_agent_time_sheet.php?agent=$row[1]\">TIME</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=10 display all campaigns
######################
if ($ADD==10)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO CAMPAGNE:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=34&campaign_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1] </td>";
		echo "<td><font size=1> $row[2]</td>";
		echo "<td><font size=1> $row[3]</td><td><font size=1>$row[4]</td><td><font size=1>$row[5]</td>";
		echo "<td><font size=1> $row[6]</td><td><font size=1>$row[7]</td><td><font size=1> &nbsp;</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31&campaign_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=100 display all lists
######################
if ($ADD==100)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_lists order by list_id";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO LISTE:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=311&list_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[2]</td><td><font size=1>$row[4]</td><td><font size=1>$row[5]</td>";
		echo "<td><font size=1> $row[3]</td><td><font size=1>$row[7]</td><td><font size=1> &nbsp;</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=311&list_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}



######################
# ADD=1000 display all inbound groups
######################
if ($ADD==1000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_inbound_groups order by group_id";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO GRUPPI INBOUND:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<TR BGCOLOR=BLACK>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>IN-GROUP</TD>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>NOME</TD>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>PRIORITY</TD>\n";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>ATTIVO</TD>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>TIME</TD>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>COLOR</TD>\n";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>MODIFICA</TD>\n";
echo "</TR>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=3111&group_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[29]</td>";
		echo "<td><font size=1> $row[3]</td>";
		echo "<td><font size=1> $row[17]</td>";
		echo "<td bgcolor=\"$row[2]\"><font size=1> &nbsp;</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3111&group_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=1300 display all inbound dids
######################
if ($ADD==1300)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_inbound_dids order by did_pattern";
	$rslt=mysql_query($stmt, $link);
	$dids_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO GRUPPI INBOUND:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<TR BGCOLOR=BLACK>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>#</TD>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>DID</TD>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>DESCRIZIONE</TD>\n";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>ATTIVO</TD>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>ROUTE</TD>";
echo "<TD><FONT FACE=\"Arial,Helvetica\" size=2 color=white>MODIFICA</TD>\n";
echo "</TR>\n";

	$o=0;
	while ($dids_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=3311&did_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[2]</td>";
		echo "<td><font size=1> $row[3]</td>";
		echo "<td><font size=1> $row[4]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3311&did_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=10000 display all remote agents
######################
if ($ADD==10000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_remote_agents order by server_ip,campaign_id,user_start";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO OPERATORI REMOTI:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31111&remote_agent_id=$row[0]\">$row[1]</a></td>";
		echo "<td><font size=1> $row[2]</td>";
		echo "<td><font size=1> $row[3]</td>";
		echo "<td><font size=1> $row[4]</td>";
		echo "<td><font size=1> $row[5]</td>";
		echo "<td><font size=1> $row[6]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31111&remote_agent_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=100000 display all user groups
######################
if ($ADD==100000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_user_groups order by user_group";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO GRUPPI UTENTI:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=311111&user_group=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=311111&user_group=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=1000000 display all scripts
######################
if ($ADD==1000000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_scripts order by script_id";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO SCRIPT:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=3111111&script_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3111111&script_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=10000000 display all filters
######################
if ($ADD==10000000)
{
echo "<TABLE><TR><TD>\n";

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_lead_filters order by lead_filter_id";
	$rslt=mysql_query($stmt, $link);
	$filters_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO FILTRI CONTATTI:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($filters_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31111111&lead_filter_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31111111&lead_filter_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=100000000 display all call times
######################
if ($ADD==100000000)
{
echo "<TABLE><TR><TD>\n";

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_call_times order by call_time_id";
	$rslt=mysql_query($stmt, $link);
	$filters_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO ORARI CHIAMATE:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($filters_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=311111111&call_time_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[3] </td>";
		echo "<td><font size=1> $row[4] </td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=311111111&call_time_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=1000000000 display all state call times
######################
if ($ADD==1000000000)
{
echo "<TABLE><TR><TD>\n";

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_state_call_times order by state_call_time_id";
	$rslt=mysql_query($stmt, $link);
	$filters_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO ORARI CHIAMATE PER STATO:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($filters_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=3111111111&call_time_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[2]</td>";
		echo "<td><font size=1> $row[3] </td>";
		echo "<td><font size=1> $row[4] </td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3111111111&call_time_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=130000000 display all shifts
######################
if ($ADD==130000000)
{
echo "<TABLE><TR><TD>\n";

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_shifts order by shift_id";
	$rslt=mysql_query($stmt, $link);
	$filters_to_print = mysql_num_rows($rslt);

echo "<br>SHIFT LISTINGS:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($filters_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=331111111&shift_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[2] </td>";
		echo "<td><font size=1> $row[3] </td>";
		echo "<td><font size=1> $row[4] </td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=331111111&shift_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=10000000000 display all phones
######################
if ($ADD==10000000000)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

$EXTENlink='stage=EXTENDOWN';
$PROTOlink='stage=PROTODOWN';
$SERVERlink='stage=SERVERDOWN';
$STATUSlink='stage=STATUSDOWN';
$SQLorder='order by extension,server_ip';
if (eregi("EXTENUP",$stage)) {$SQLorder='order by extension asc';   $EXTENlink='stage=EXTENDOWN';}
if (eregi("EXTENDOWN",$stage)) {$SQLorder='order by extension desc';   $EXTENlink='stage=EXTENUP';}
if (eregi("PROTOUP",$stage)) {$SQLorder='order by protocol asc';   $PROTOlink='stage=PROTODOWN';}
if (eregi("PROTODOWN",$stage)) {$SQLorder='order by protocol desc';   $PROTOlink='stage=PROTOUP';}
if (eregi("SERVERUP",$stage)) {$SQLorder='order by server_ip asc';   $SERVERlink='stage=SERVERDOWN';}
if (eregi("SERVERDOWN",$stage)) {$SQLorder='order by server_ip desc';   $SERVERlink='stage=SERVERUP';}
if (eregi("STATUSUP",$stage)) {$SQLorder='order by status asc';   $STATUSlink='stage=STATUSDOWN';}
if (eregi("STATUSDOWN",$stage)) {$SQLorder='order by status desc';   $STATUSlink='stage=STATUSUP';}
	$stmt="SELECT * from phones $SQLorder";
	$rslt=mysql_query($stmt, $link);
	$phones_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO TELEFONI:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr bgcolor=black>";
echo "<td><a href=\"$PHP_SELF?ADD=10000000000&$EXTENlink\"><font size=1 color=white><B>EXTEN</B></a></td>";
echo "<td><a href=\"$PHP_SELF?ADD=10000000000&$PROTOlink\"><font size=1 color=white><B>PROTO</B></a></td>";
echo "<td><a href=\"$PHP_SELF?ADD=10000000000&$SERVERlink\"><font size=1 color=white><B>SERVER</B></a></td>";
echo "<td colspan=2><font size=1 color=white><B>DIAL PLAN</B></td>";
echo "<td><a href=\"$PHP_SELF?ADD=10000000000&$STATUSlink\"><font size=1 color=white><B>ESITO</B></a></td>";
echo "<td><font size=1 color=white><B>NOME</B></td>";
echo "<td colspan=2><font size=1 color=white><B>VMAIL</B></td>";
echo "<td align=center><font size=1 color=white><B>LINKS</B></td></tr>\n";

	$o=0;
	while ($phones_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><a href=\"$PHP_SELF?ADD=31111111111&extension=$row[0]&server_ip=$row[5]\"><font size=1 color=black>$row[0]</font></a></td><td><font size=1>$row[16]</td><td><font size=1>$row[5]</td><td><font size=1>$row[1]</td><td><font size=1>$row[2]</td><td><font size=1>$row[8]</td><td><font size=1>$row[11]</td><td><font size=1>$row[14]</td><td><font size=1>$row[15]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31111111111&extension=$row[0]&server_ip=$row[5]\">MODIFICA</a> | <a href=\"./phone_stats.php?extension=$row[0]&server_ip=$row[5]\">STATISTICHE</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=12000000000 display all phones alias
######################
if ($ADD==12000000000)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from phones_alias order by alias_id;";
	$rslt=mysql_query($stmt, $link);
	$phones_to_print = mysql_num_rows($rslt);

echo "<br>PHONE ALIAS LISTINGS:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";
echo "<tr bgcolor=black>";
echo "<td><font size=1 color=white><B>ALIAS ID</B></a></td>";
echo "<td><font size=1 color=white><B>ALIAS NAME</B></a></td>";
echo "<td><font size=1 color=white><B>PHONE LOGINS LIST</B></a></td>";
echo "<td align=center><font size=1 color=white><B>MODIFICA</B></td></tr>\n";

	$o=0;
	while ($phones_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><a href=\"$PHP_SELF?ADD=32111111111&alias_id=$row[0]\"><font size=1 color=black>$row[0]</font></a></td><td><font size=1>$row[1]</td><td><font size=1>$row[2]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=32111111111&alias_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=100000000000 display all servers
######################
if ($ADD==100000000000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from servers order by server_id";
	$rslt=mysql_query($stmt, $link);
	$phones_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO SERVER:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($phones_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=311111111111&server_id=$row[0]\">$row[0]</a></td><td><font size=1>$row[1]</td>";
		echo "<td><font size=1> $row[2]</td>";
		echo "<td><font size=1> $row[4]</td>";
		echo "<td><font size=1> $row[3]</td><td><font size=1> &nbsp;</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=311111111111&server_id=$row[0]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=1000000000000 display all conferences
######################
if ($ADD==1000000000000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from conferences order by conf_exten";
	$rslt=mysql_query($stmt, $link);
	$phones_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO CONFERENZE:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($phones_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=3111111111111&conf_exten=$row[0]&server_ip=$row[1]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[2]</td><td><font size=1>$row[4]</td><td><font size=1> &nbsp;</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3111111111111&conf_exten=$row[0]&server_ip=$row[1]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=10000000000000 display all vicidial conferences
######################
if ($ADD==10000000000000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_conferences order by conf_exten";
	$rslt=mysql_query($stmt, $link);
	$phones_to_print = mysql_num_rows($rslt);

echo "<br>ELENCO CONFERENZE:\n";
echo "<center><TABLE width=$section_width cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($phones_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=31111111111111&conf_exten=$row[0]&server_ip=$row[1]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[2]</td><td><font size=1>$row[4]</td><td><font size=1> &nbsp;</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31111111111111&conf_exten=$row[0]&server_ip=$row[1]\">MODIFICA</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=999999 display reports section
######################
if ($ADD==999999)
{
	if ($LOGview_reports==1)
	{
	echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_conferences order by conf_exten";
	$rslt=mysql_query($stmt, $link);
	$phones_to_print = mysql_num_rows($rslt);

	$stmt="select * from servers;";
	$rslt=mysql_query($stmt, $link);
	if ($DB) {echo "$stmt\n";}
	$servers_to_print = mysql_num_rows($rslt);
	$i=0;
	while ($i < $servers_to_print)
		{
		$row=mysql_fetch_row($rslt);
		$server_id[$i] =			$row[0];
		$server_description[$i] =	$row[1];
		$server_ip[$i] =			$row[2];
		$active[$i] =				$row[3];
		$i++;
		}

	$stmt="SELECT enable_queuemetrics_logging,queuemetrics_url from system_settings;";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$enable_queuemetrics_logging_LU =	$row[0];
	$queuemetrics_url_LU =				$row[1];

	?>

	<HTML>
	<HEAD>

	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>VICIDIAL: Statistiche e Report</TITLE></HEAD><BODY BGCOLOR=WHITE>
	<FONT SIZE=4><B>VICIDIAL: Statistiche e Report</B></font><BR><BR>
	<UL>
	<LI><a href="AST_timeonVDADall.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>TIME ON VDAD (per campaign)</a> &nbsp;  <a href="AST_timeonVDADallSUMMARY.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>(all campaigns SUMMARY)</a> &nbsp; &nbsp; SIP <a href="AST_timeonVDADall.php?SIPmonitorLINK=1"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>Listen</a> - <a href="AST_timeonVDADall.php?SIPmonitorLINK=2"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>Barge</a> &nbsp; &nbsp; IAX <a href="AST_timeonVDADall.php?IAXmonitorLINK=1"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>Listen</a> - <a href="AST_timeonVDADall.php?IAXmonitorLINK=2"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>Barge</a></FONT>
	<LI><a href="AST_VDADstats.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>REPORT VDAD</a></FONT>
	<LI><a href="AST_CLOSERstats.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>INBOUND/INFORME CLOSER</a></FONT>
	<LI><a href="AST_CLOSER_service_level.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>INBOUND/CLOSER SERVICE_LEVEL REPORT</a></FONT>
	<LI><a href="AST_agent_performance_detail.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>DETTAGLI PERFORMANCE OPERATORE</a></FONT>
	<LI><a href="fcstats.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>FRONTER - INFORME CLOSER</a></FONT>
	<LI><a href="vicidial_sales_viewer.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>AGENT SPREADSHEET PERFORMANCE</a></FONT>
	<LI><a href="timeclock_report.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>USER TIMECLOCK REPORT</a></FONT>  &nbsp; &nbsp; 
	    <a href="timeclock_status.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>USER GROUP TIMECLOCK STATUS REPORT</a></FONT>
	<LI><a href="AST_server_performance.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=2>SERVER PERFORMANCE</a></FONT>
<?
	if ($enable_queuemetrics_logging_LU > 0)
		{
		echo "<LI><a href=\"$queuemetrics_url_LU\"><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>QUEUEMETRICS REPORT</a></FONT>\n";
		}
?>
	</UL>
	<PRE><TABLE Border=1 CELLPADDING=0 cellspacing=0>
	<TR><TD>SERVER</TD><TD>DESCRIZIONE</TD><TD>INDIRIZZO IP</TD><TD>ATTIVO</TD><TD>VDAD time</TD><TD>PARK time</TD><TD>CLOSER/INBOUND time</TD></TR>
	<? 

		$o=0;
		while ($servers_to_print > $o)
		{
		echo "<TR>\n";
		echo "<TD>$server_id[$o]</TD>\n";
		echo "<TD>$server_description[$o]</TD>\n";
		echo "<TD>$server_ip[$o]</TD>\n";
		echo "<TD>$active[$o]</TD>\n";
		echo "<TD><a href=\"AST_timeonVDAD.php?server_ip=$server_ip[$o]\">LINK</a></TD>\n";
		echo "<TD><a href=\"AST_timeonpark.php?server_ip=$server_ip[$o]\">LINK</a></TD>\n";
		echo "<TD><a href=\"AST_timeonVDAD.php?server_ip=$server_ip[$o]&closer_display=1\">LINK</a></TD>\n";
		echo "</TR>\n";
		$o++;
		}

	echo "</TABLE>\n";
	}
	else
	{
	echo "Non hai l`autorizzazione per accedere a questa pagina\n";
	exit;
	}
}





echo "</TD></TR></TABLE></center>\n";

$ENDtime = date("U");

$RUNtime = ($ENDtime - $STARTtime);

echo "\n\n\n<br><br><br>\n<center>\n";


echo "<font size=0>\n\n\n<br><br><br>\nTempo Esecuzione Script: $RUNtime seconds";
echo " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; VERSIONE: $admin_version";
echo " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; BUILD: $build</font>\n";


?>


</TD></TR><TABLE>
</body>
</html>

<?
	
exit;




##### CALCULATE DIALABLE LEADS #####
function dialable_leads($DB,$link,$local_call_time,$dial_statuses,$camp_lists,$fSQL)
{
##### BEGIN calculate what gmt_offset_now values are within the allowed local_call_time setting ###
if (isset($camp_lists))
	{
	if (strlen($camp_lists)>1)
		{
		if (strlen($dial_statuses)>2)
			{
			$g=0;
			$p='13';
			$GMT_gmt[0] = '';
			$GMT_hour[0] = '';
			$GMT_day[0] = '';
			while ($p > -13)
				{
				$pzone=3600 * $p;
				$pmin=(gmdate("i", time() + $pzone));
				$phour=( (gmdate("G", time() + $pzone)) * 100);
				$pday=gmdate("w", time() + $pzone);
				$tz = sprintf("%.2f", $p);	
				$GMT_gmt[$g] = "$tz";
				$GMT_day[$g] = "$pday";
				$GMT_hour[$g] = ($phour + $pmin);
				$p = ($p - 0.25);
				$g++;
				}

			$stmt="SELECT * FROM vicidial_call_times where call_time_id='$local_call_time';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_query($stmt, $link);
			$rowx=mysql_fetch_row($rslt);
			$Gct_default_start =	"$rowx[3]";
			$Gct_default_stop =		"$rowx[4]";
			$Gct_sunday_start =		"$rowx[5]";
			$Gct_sunday_stop =		"$rowx[6]";
			$Gct_monday_start =		"$rowx[7]";
			$Gct_monday_stop =		"$rowx[8]";
			$Gct_tuesday_start =	"$rowx[9]";
			$Gct_tuesday_stop =		"$rowx[10]";
			$Gct_wednesday_start =	"$rowx[11]";
			$Gct_wednesday_stop =	"$rowx[12]";
			$Gct_thursday_start =	"$rowx[13]";
			$Gct_thursday_stop =	"$rowx[14]";
			$Gct_friday_start =		"$rowx[15]";
			$Gct_friday_stop =		"$rowx[16]";
			$Gct_saturday_start =	"$rowx[17]";
			$Gct_saturday_stop =	"$rowx[18]";
			$Gct_state_call_times = "$rowx[19]";

			$ct_states = '';
			$ct_state_gmt_SQL = '';
			$ct_srs=0;
			$b=0;
			if (strlen($Gct_state_call_times)>2)
				{
				$state_rules = explode('|',$Gct_state_call_times);
				$ct_srs = ((count($state_rules)) - 2);
				}
			while($ct_srs >= $b)
				{
				if (strlen($state_rules[$b])>1)
					{
					$stmt="SELECT * from vicidial_state_call_times where state_call_time_id='$state_rules[$b]';";
					$rslt=mysql_query($stmt, $link);
					$row=mysql_fetch_row($rslt);
					$Gstate_call_time_id =		"$row[0]";
					$Gstate_call_time_state =	"$row[1]";
					$Gsct_default_start =		"$row[4]";
					$Gsct_default_stop =		"$row[5]";
					$Gsct_sunday_start =		"$row[6]";
					$Gsct_sunday_stop =			"$row[7]";
					$Gsct_monday_start =		"$row[8]";
					$Gsct_monday_stop =			"$row[9]";
					$Gsct_tuesday_start =		"$row[10]";
					$Gsct_tuesday_stop =		"$row[11]";
					$Gsct_wednesday_start =		"$row[12]";
					$Gsct_wednesday_stop =		"$row[13]";
					$Gsct_thursday_start =		"$row[14]";
					$Gsct_thursday_stop =		"$row[15]";
					$Gsct_friday_start =		"$row[16]";
					$Gsct_friday_stop =			"$row[17]";
					$Gsct_saturday_start =		"$row[18]";
					$Gsct_saturday_stop =		"$row[19]";

					$ct_states .="'$Gstate_call_time_state',";

					$r=0;
					$state_gmt='';
					while($r < $g)
						{
						if ($GMT_day[$r]==0)	#### Sunday ora locale
							{
							if (($Gsct_sunday_start==0) and ($Gsct_sunday_stop==0))
								{
								if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							else
								{
								if ( ($GMT_hour[$r]>=$Gsct_sunday_start) and ($GMT_hour[$r]<$Gsct_sunday_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							}
						if ($GMT_day[$r]==1)	#### Monday ora locale
							{
							if (($Gsct_monday_start==0) and ($Gsct_monday_stop==0))
								{
								if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							else
								{
								if ( ($GMT_hour[$r]>=$Gsct_monday_start) and ($GMT_hour[$r]<$Gsct_monday_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							}
						if ($GMT_day[$r]==2)	#### Tuesday ora locale
							{
							if (($Gsct_tuesday_start==0) and ($Gsct_tuesday_stop==0))
								{
								if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							else
								{
								if ( ($GMT_hour[$r]>=$Gsct_tuesday_start) and ($GMT_hour[$r]<$Gsct_tuesday_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							}
						if ($GMT_day[$r]==3)	#### Wednesday ora locale
							{
							if (($Gsct_wednesday_start==0) and ($Gsct_wednesday_stop==0))
								{
								if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							else
								{
								if ( ($GMT_hour[$r]>=$Gsct_wednesday_start) and ($GMT_hour[$r]<$Gsct_wednesday_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							}
						if ($GMT_day[$r]==4)	#### Thursday ora locale
							{
							if (($Gsct_thursday_start==0) and ($Gsct_thursday_stop==0))
								{
								if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							else
								{
								if ( ($GMT_hour[$r]>=$Gsct_thursday_start) and ($GMT_hour[$r]<$Gsct_thursday_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							}
						if ($GMT_day[$r]==5)	#### Friday ora locale
							{
							if (($Gsct_friday_start==0) and ($Gsct_friday_stop==0))
								{
								if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							else
								{
								if ( ($GMT_hour[$r]>=$Gsct_friday_start) and ($GMT_hour[$r]<$Gsct_friday_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							}
						if ($GMT_day[$r]==6)	#### Saturday ora locale
							{
							if (($Gsct_saturday_start==0) and ($Gsct_saturday_stop==0))
								{
								if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							else
								{
								if ( ($GMT_hour[$r]>=$Gsct_saturday_start) and ($GMT_hour[$r]<$Gsct_saturday_stop) )
									{$state_gmt.="'$GMT_gmt[$r]',";}
								}
							}
						$r++;
						}
					$state_gmt = "$state_gmt'99'";
					$ct_state_gmt_SQL .= "or (state='$Gstate_call_time_state' and gmt_offset_now IN($state_gmt)) ";
					}

				$b++;
				}
			if (strlen($ct_states)>2)
				{
				$ct_states = eregi_replace(",$",'',$ct_states);
				$ct_statesSQL = "and state NOT IN($ct_states)";
				}
			else
				{
				$ct_statesSQL = "";
				}

			$r=0;
			$default_gmt='';
			while($r < $g)
				{
				if ($GMT_day[$r]==0)	#### Sunday ora locale
					{
					if (($Gct_sunday_start==0) and ($Gct_sunday_stop==0))
						{
						if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					else
						{
						if ( ($GMT_hour[$r]>=$Gct_sunday_start) and ($GMT_hour[$r]<$Gct_sunday_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					}
				if ($GMT_day[$r]==1)	#### Monday ora locale
					{
					if (($Gct_monday_start==0) and ($Gct_monday_stop==0))
						{
						if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					else
						{
						if ( ($GMT_hour[$r]>=$Gct_monday_start) and ($GMT_hour[$r]<$Gct_monday_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					}
				if ($GMT_day[$r]==2)	#### Tuesday ora locale
					{
					if (($Gct_tuesday_start==0) and ($Gct_tuesday_stop==0))
						{
						if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					else
						{
						if ( ($GMT_hour[$r]>=$Gct_tuesday_start) and ($GMT_hour[$r]<$Gct_tuesday_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					}
				if ($GMT_day[$r]==3)	#### Wednesday ora locale
					{
					if (($Gct_wednesday_start==0) and ($Gct_wednesday_stop==0))
						{
						if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					else
						{
						if ( ($GMT_hour[$r]>=$Gct_wednesday_start) and ($GMT_hour[$r]<$Gct_wednesday_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					}
				if ($GMT_day[$r]==4)	#### Thursday ora locale
					{
					if (($Gct_thursday_start==0) and ($Gct_thursday_stop==0))
						{
						if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					else
						{
						if ( ($GMT_hour[$r]>=$Gct_thursday_start) and ($GMT_hour[$r]<$Gct_thursday_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					}
				if ($GMT_day[$r]==5)	#### Friday ora locale
					{
					if (($Gct_friday_start==0) and ($Gct_friday_stop==0))
						{
						if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					else
						{
						if ( ($GMT_hour[$r]>=$Gct_friday_start) and ($GMT_hour[$r]<$Gct_friday_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					}
				if ($GMT_day[$r]==6)	#### Saturday ora locale
					{
					if (($Gct_saturday_start==0) and ($Gct_saturday_stop==0))
						{
						if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					else
						{
						if ( ($GMT_hour[$r]>=$Gct_saturday_start) and ($GMT_hour[$r]<$Gct_saturday_stop) )
							{$default_gmt.="'$GMT_gmt[$r]',";}
						}
					}
				$r++;
				}

			$default_gmt = "$default_gmt'99'";
			$all_gmtSQL = "(gmt_offset_now IN($default_gmt) $ct_statesSQL) $ct_state_gmt_SQL";


			$dial_statuses = preg_replace("/ -$/","",$dial_statuses);
			$Dstatuses = explode(" ", $dial_statuses);
			$Ds_to_print = (count($Dstatuses) - 0);
			$Dsql = '';
			$o=0;
			while ($Ds_to_print > $o) 
				{
				$o++;
				$Dsql .= "'$Dstatuses[$o]',";
				}
			$Dsql = preg_replace("/,$/","",$Dsql);

			$stmt="SELECT count(*) FROM vicidial_list where called_since_last_reset='N' and status IN($Dsql) and list_id IN($camp_lists) and ($all_gmtSQL) $fSQL";
			#$DB=1;
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_query($stmt, $link);
			$rslt_rows = mysql_num_rows($rslt);
			if ($rslt_rows)
				{
				$rowx=mysql_fetch_row($rslt);
				$active_leads = "$rowx[0]";
				}
			else {$active_leads = '0';}

			echo "|$DB|\n";
			echo "Questa campagna ha $active_leads contatti da chiamare in queste liste\n";
			}
		else
			{
			echo "nessun esito di chiamata selezionato per questa campagna\n";
			}
		}
	else
		{
		echo "nessuna lista attiva selezionata per questa campagna\n";
		}
	}
else
	{
	echo "nessuna lista attiva selezionata per questa campagna\n";
	}
##### END calculate what gmt_offset_now values are within the allowed local_call_time setting ###
}
?>
