UPDATE system_settings SET db_schema_version='1404',version='2.11rc1tk',db_schema_update_date=NOW() where db_schema_version < 1404;

UPDATE system_settings SET db_schema_version='1405',version='2.12b0.5',db_schema_update_date=NOW() where db_schema_version < 1405;

ALTER TABLE system_settings ADD meetme_enter_login_filename VARCHAR(255) default '';
ALTER TABLE system_settings ADD meetme_enter_leave3way_filename VARCHAR(255) default '';

UPDATE system_settings SET db_schema_version='1406',db_schema_update_date=NOW() where db_schema_version < 1406;

ALTER TABLE system_settings ADD enable_did_entry_list_id ENUM('0','1') default '0';

ALTER TABLE vicidial_inbound_dids ADD entry_list_id BIGINT(14) UNSIGNED default '0';
ALTER TABLE vicidial_inbound_dids ADD filter_entry_list_id BIGINT(14) UNSIGNED default '0';

UPDATE system_settings SET db_schema_version='1407',db_schema_update_date=NOW() where db_schema_version < 1407;

ALTER TABLE system_settings ADD enable_third_webform ENUM('0','1') default '0';

ALTER TABLE vicidial_campaigns ADD web_form_address_three TEXT;
ALTER TABLE vicidial_lists ADD web_form_address_three TEXT;
ALTER TABLE vicidial_inbound_groups ADD web_form_address_three TEXT;

ALTER TABLE vicidial_campaigns MODIFY get_call_launch ENUM('NONE','SCRIPT','WEBFORM','WEBFORMTWO','WEBFORMTHREE','FORM') default 'NONE';
ALTER TABLE vicidial_inbound_groups MODIFY get_call_launch ENUM('NONE','SCRIPT','WEBFORM','WEBFORMTWO','WEBFORMTHREE','FORM') default 'NONE';

UPDATE system_settings SET db_schema_version='1408',db_schema_update_date=NOW() where db_schema_version < 1408;

ALTER TABLE vicidial_users ADD api_list_restrict ENUM('1','0') default '0';

UPDATE system_settings SET db_schema_version='1409',db_schema_update_date=NOW() where db_schema_version < 1409;

ALTER TABLE vicidial_users ADD api_allowed_functions VARCHAR(1000) default ' ALL_FUNCTIONS ';

UPDATE system_settings SET db_schema_version='1410',db_schema_update_date=NOW() where db_schema_version < 1410;

ALTER TABLE vicidial_email_accounts ADD pop3_auth_mode ENUM('BEST','PASS','APOP','CRAM-MD5') default 'BEST' AFTER email_account_pass;

UPDATE system_settings SET db_schema_version='1411',db_schema_update_date=NOW() where db_schema_version < 1411;

ALTER TABLE system_settings ADD chat_url VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE system_settings ADD chat_timeout INT(3) UNSIGNED DEFAULT NULL;

ALTER TABLE vicidial_inbound_groups MODIFY group_handling ENUM('PHONE','EMAIL','CHAT') default 'PHONE';

CREATE TABLE vicidial_chat_archive (
chat_id INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
chat_start_time DATETIME DEFAULT NULL,
status VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
chat_creator VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
group_id VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
lead_id INT(9) UNSIGNED DEFAULT NULL,
PRIMARY KEY (chat_id),
KEY vicidial_chat_archive_lead_id_key (lead_id),
KEY vicidial_chat_archive_start_time_key (chat_start_time)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE vicidial_chat_log (
message_row_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
chat_id VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
message MEDIUMTEXT COLLATE utf8_unicode_ci,
message_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
poster VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
chat_member_name VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
chat_level ENUM('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
PRIMARY KEY (message_row_id),
KEY vicidial_chat_log_user_key (poster)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE vicidial_chat_log_archive (
message_row_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
chat_id VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
message MEDIUMTEXT COLLATE utf8_unicode_ci,
message_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
poster VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
chat_member_name VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
chat_level ENUM('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
PRIMARY KEY (message_row_id),
KEY vicidial_chat_log_archive_user_key (poster)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE vicidial_chat_participants (
chat_participant_id INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
chat_id INT(9) UNSIGNED DEFAULT NULL,
chat_member VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
chat_member_name VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
ping_date DATETIME DEFAULT NULL,
vd_agent ENUM('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
PRIMARY KEY (chat_participant_id),
UNIQUE KEY vicidial_chat_participants_key (chat_id,chat_member)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE vicidial_live_chats (
chat_id INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
chat_start_time DATETIME DEFAULT NULL,
status VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
chat_creator VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
group_id VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
lead_id INT(9) UNSIGNED DEFAULT NULL,
PRIMARY KEY (chat_id),
KEY vicidial_live_chats_lead_id_key (lead_id),
KEY vicidial_live_chats_start_time_key (chat_start_time)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE vicidial_manager_chat_log (
manager_chat_message_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
manager_chat_id INT(10) UNSIGNED DEFAULT NULL,
manager_chat_subid TINYINT(3) UNSIGNED DEFAULT NULL,
manager VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
user VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
message MEDIUMTEXT COLLATE utf8_unicode_ci,
message_date DATETIME DEFAULT NULL,
message_viewed_date DATETIME DEFAULT NULL,
message_posted_by VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
audio_alerted ENUM('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
PRIMARY KEY (manager_chat_message_id)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE vicidial_manager_chat_log_archive (
manager_chat_message_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
manager_chat_id INT(10) UNSIGNED DEFAULT NULL,
manager_chat_subid TINYINT(3) UNSIGNED DEFAULT NULL,
manager VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
user VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
message MEDIUMTEXT COLLATE utf8_unicode_ci,
message_date DATETIME DEFAULT NULL,
message_viewed_date DATETIME DEFAULT NULL,
message_posted_by VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
audio_alerted ENUM('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
PRIMARY KEY (manager_chat_message_id)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE vicidial_manager_chats (
manager_chat_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
chat_start_date DATETIME DEFAULT NULL,
manager VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
selected_agents MEDIUMTEXT COLLATE utf8_unicode_ci,
selected_user_groups MEDIUMTEXT COLLATE utf8_unicode_ci,
selected_campaigns MEDIUMTEXT COLLATE utf8_unicode_ci,
allow_replies ENUM('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
PRIMARY KEY (manager_chat_id)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE vicidial_manager_chats_archive (
manager_chat_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
chat_start_date DATETIME DEFAULT NULL,
manager VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
selected_agents MEDIUMTEXT COLLATE utf8_unicode_ci,
selected_user_groups MEDIUMTEXT COLLATE utf8_unicode_ci,
selected_campaigns MEDIUMTEXT COLLATE utf8_unicode_ci,
allow_replies ENUM('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
PRIMARY KEY (manager_chat_id)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

UPDATE system_settings SET db_schema_version='1412',db_schema_update_date=NOW() where db_schema_version < 1412;

ALTER TABLE vicidial_campaigns ADD manual_dial_override_field ENUM('ENABLED','DISABLED') default 'ENABLED';

UPDATE system_settings SET db_schema_version='1413',db_schema_update_date=NOW() where db_schema_version < 1413;

ALTER TABLE vicidial_campaigns ADD status_display_ingroup ENUM('ENABLED','DISABLED') default 'ENABLED';

ALTER TABLE vicidial_inbound_groups ADD populate_lead_ingroup ENUM('ENABLED','DISABLED') default 'ENABLED';

ALTER TABLE vicidial_scripts ADD script_color VARCHAR(7) default 'white';

UPDATE system_settings SET db_schema_version='1414',db_schema_update_date=NOW() where db_schema_version < 1414;

ALTER TABLE vicidial_campaigns ADD customer_gone_seconds SMALLINT(5) UNSIGNED default '30';

UPDATE system_settings SET db_schema_version='1415',db_schema_update_date=NOW() where db_schema_version < 1415;

UPDATE vicidial_inbound_groups set group_handling='PHONE' where group_handling='';

UPDATE system_settings SET db_schema_version='1416',db_schema_update_date=NOW() where db_schema_version < 1416;

ALTER TABLE vicidial_campaigns MODIFY lead_filter_id VARCHAR(20) default 'NONE';

ALTER TABLE vicidial_lead_filters MODIFY lead_filter_id VARCHAR(20) NOT NULL;

ALTER TABLE vicidial_users ADD lead_filter_id VARCHAR(20) default 'NONE';

UPDATE system_settings SET db_schema_version='1417',db_schema_update_date=NOW() where db_schema_version < 1417;

ALTER TABLE vicidial_inbound_dids ADD max_queue_ingroup_calls SMALLINT(5) default '0';
ALTER TABLE vicidial_inbound_dids ADD max_queue_ingroup_id VARCHAR(20) default '';
ALTER TABLE vicidial_inbound_dids ADD max_queue_ingroup_extension VARCHAR(50) default '9998811112';

UPDATE system_settings SET db_schema_version='1418',db_schema_update_date=NOW() where db_schema_version < 1418;

CREATE TABLE vicidial_url_multi (
url_id INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
campaign_id VARCHAR(20) NOT NULL,
entry_type ENUM('campaign','ingroup','list','') default '',
active ENUM('Y','N') default 'N',
url_type ENUM('dispo','start','addlead','noagent','') default '',
url_rank SMALLINT(5) default '1',
url_statuses VARCHAR(1000) default '',
url_description VARCHAR(255) default '',
url_address TEXT,
PRIMARY KEY (url_id),
KEY vicidial_url_multi_campaign_id_key (campaign_id)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

UPDATE system_settings SET db_schema_version='1419',db_schema_update_date=NOW() where db_schema_version < 1419;

CREATE TABLE vicidial_dtmf_log (
dtmf_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
dtmf_time DATETIME,
channel VARCHAR(100) NOT NULL,
server_ip VARCHAR(15) NOT NULL,
uniqueid VARCHAR(20) default '',
digit VARCHAR(1) default '',
direction ENUM('Received','Sent') default 'Received',
state ENUM('BEGIN','END') default 'BEGIN',
PRIMARY KEY (dtmf_id),
KEY vicidial_dtmf_uniqueid_key (uniqueid)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

UPDATE system_settings SET db_schema_version='1420',db_schema_update_date=NOW() where db_schema_version < 1420;

CREATE TABLE vicidial_ajax_log (
user VARCHAR(20) default '',
start_time DATETIME NOT NULL,
db_time DATETIME NOT NULL,
run_time VARCHAR(20) default '0',
php_script VARCHAR(40) NOT NULL,
action VARCHAR(100) default '',
lead_id INT(10) UNSIGNED default '0',
stage VARCHAR(100) default '',
session_name VARCHAR(40) default '',
last_sql TEXT,
KEY ajax_dbtime_key (db_time)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE system_settings ADD agent_debug_logging VARCHAR(20) default '0';

UPDATE system_settings SET db_schema_version='1421',db_schema_update_date=NOW() where db_schema_version < 1421;
