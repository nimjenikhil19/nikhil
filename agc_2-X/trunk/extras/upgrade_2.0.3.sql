ALTER TABLE vicidial_campaigns ADD concurrent_transfers ENUM('AUTO','1','2','3','4','5','6','7','8','9','10') default 'AUTO';
ALTER TABLE vicidial_campaigns ADD auto_alt_dial ENUM('NONE','ALT_ONLY','ADDR3_ONLY','ALT_AND_ADDR3') default 'NONE';
ALTER TABLE vicidial_campaigns ADD auto_alt_dial_statuses VARCHAR(255) default ' B N NA DC -';

ALTER TABLE vicidial_auto_calls ADD alt_dial ENUM('NONE','MAIN','ALT','ADDR3') default 'NONE';

ALTER TABLE vicidial_hopper ADD alt_dial ENUM('NONE','ALT','ADDR3') default 'NONE';
ALTER TABLE vicidial_hopper MODIFY status ENUM('READY','QUEUE','INCALL','DONE','HOLD') default 'READY';

ALTER TABLE vicidial_log ADD user_group VARCHAR(20);
ALTER TABLE vicidial_closer_log ADD user_group VARCHAR(20);
ALTER TABLE vicidial_user_log ADD user_group VARCHAR(20);
ALTER TABLE vicidial_agent_log ADD user_group VARCHAR(20);
ALTER TABLE vicidial_callbacks ADD user_group VARCHAR(20);

ALTER TABLE vicidial_users ADD modify_users ENUM('0','1') default '0';
ALTER TABLE vicidial_users ADD modify_campaigns ENUM('0','1') default '0';
ALTER TABLE vicidial_users ADD modify_lists ENUM('0','1') default '0';
ALTER TABLE vicidial_users ADD modify_scripts ENUM('0','1') default '0';
ALTER TABLE vicidial_users ADD modify_filters ENUM('0','1') default '0';
ALTER TABLE vicidial_users ADD modify_ingroups ENUM('0','1') default '0';
ALTER TABLE vicidial_users ADD modify_usergroups ENUM('0','1') default '0';
ALTER TABLE vicidial_users ADD modify_remoteagents ENUM('0','1') default '0';
ALTER TABLE vicidial_users ADD modify_servers ENUM('0','1') default '0';
ALTER TABLE vicidial_users ADD view_reports ENUM('0','1') default '0';

UPDATE vicidial_users SET modify_users='1',view_reports='1' where user_level>7;
UPDATE vicidial_users SET modify_campaigns='1' where campaign_detail='1';
UPDATE vicidial_users SET modify_campaigns='1' where delete_campaigns='1';
UPDATE vicidial_users SET modify_lists='1' where delete_lists='1';
UPDATE vicidial_users SET modify_scripts='1' where delete_scripts='1';
UPDATE vicidial_users SET modify_filters='1' where delete_filters='1';
UPDATE vicidial_users SET modify_ingroups='1' where delete_ingroups='1';
UPDATE vicidial_users SET modify_usergroups='1' where delete_user_groups='1';
UPDATE vicidial_users SET modify_remoteagents='1' where delete_remote_agents='1';
UPDATE vicidial_users SET modify_servers='1' where ast_admin_access='1';

ALTER TABLE inbound_numbers ADD department VARCHAR(30);

ALTER TABLE vicidial_agent_log ADD comments VARCHAR(20);
ALTER TABLE vicidial_agent_log ADD sub_status VARCHAR(6);
ALTER TABLE vicidial_live_agents ADD comments VARCHAR(20);

ALTER TABLE vicidial_campaigns ADD agent_pause_codes_active ENUM('Y','N') default 'N';

 CREATE TABLE vicidial_pause_codes (
pause_code VARCHAR(6) NOT NULL,
pause_code_name VARCHAR(30),
billable ENUM('NO','YES','HALF') default 'NO',
campaign_id VARCHAR(8),
index (campaign_id)
);

ALTER TABLE vicidial_list DROP INDEX lead_id;
ALTER TABLE recording_log DROP INDEX recording_id;
ALTER TABLE call_log DROP INDEX uniqueid;
ALTER TABLE park_log DROP INDEX uniqueid;
ALTER TABLE vicidial_manager DROP INDEX man_id;
ALTER TABLE vicidial_hopper DROP INDEX hopper_id;
ALTER TABLE vicidial_live_agents DROP INDEX live_agent_id;
ALTER TABLE vicidial_auto_calls DROP INDEX auto_call_id;
ALTER TABLE vicidial_log DROP INDEX uniqueid;
ALTER TABLE vicidial_closer_log DROP INDEX closecallid;
ALTER TABLE vicidial_xfer_log DROP INDEX xfercallid;
ALTER TABLE vicidial_users DROP INDEX user_id;
ALTER TABLE vicidial_user_log DROP INDEX user_log_id;
ALTER TABLE vicidial_campaigns DROP INDEX campaign_id;
ALTER TABLE vicidial_lists DROP INDEX list_id;
ALTER TABLE vicidial_statuses DROP INDEX status;
ALTER TABLE vicidial_inbound_groups DROP INDEX group_id;
ALTER TABLE vicidial_stations DROP INDEX agent_station;
ALTER TABLE vicidial_remote_agents DROP INDEX remote_agent_id;
ALTER TABLE vicidial_agent_log DROP INDEX agent_log_id;
ALTER TABLE vicidial_scripts DROP INDEX script_id;
ALTER TABLE vicidial_lead_recycle DROP INDEX recycle_id;

ALTER TABLE vicidial_lists ADD list_description VARCHAR(255);
ALTER TABLE vicidial_lists ADD list_changedate DATETIME;
ALTER TABLE vicidial_lists ADD list_lastcalldate DATETIME;
ALTER TABLE vicidial_campaigns ADD campaign_description VARCHAR(255);
ALTER TABLE vicidial_campaigns ADD campaign_changedate DATETIME;
ALTER TABLE vicidial_campaigns ADD campaign_stats_refresh ENUM('Y','N') default 'N';
ALTER TABLE vicidial_campaigns ADD campaign_logindate DATETIME;

