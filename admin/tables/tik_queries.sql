CREATE TABLE IF NOT EXISTS tik_queries (
  `id` int(11) NOT NULL auto_increment,
  `adm_login` varchar(64) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  `in_reply_of_id` int(11) NOT NULL default '0',
  `got_reply` enum('yes','no') NOT NULL default 'no',
  `reply_id` int(11) NOT NULL default '0',
  `admin_or_user` enum('admin','user') NOT NULL default 'user',
  `subject` varchar(255) NOT NULL default '',
  `text` text,
  PRIMARY KEY  (id),
  INDEX in_reply (in_reply_of_id),
  INDEX reply_id (reply_id),
  INDEX got_reply2 (got_reply)
) TYPE=MyISAM;