ALTER TABLE auth_sessions ADD COLUMN api binary(1) NOT NULL DEFAULT '0';
CREATE TABLE api_keys (
  id int(11) NOT NULL AUTO_INCREMENT,
  apikey varchar(50) NOT NULL,
  description varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
UPDATE misc SET value = "v3.1" WHERE object = "general" AND attribute = "version";