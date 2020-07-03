CREATE TABLE IF NOT EXISTS user (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key',
  login_id VARCHAR(64) UNIQUE KEY NOT NULL DEFAULT '' COMMENT 'Login ID',
  user_passwd VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Password',
  display_name VARCHAR(128) DEFAULT '' COMMENT 'User name (optional)',
  register_date DATE NOT NULL DEFAULT (CURRENT_DATE) COMMENT 'Registration date',
  del_flag TINYINT/*(1)*/ NOT NULL DEFAULT '0' COMMENT 'Delete flag'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
