CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password TEXT NOT NULL,
    email TEXT NOT NULL,
    UNIQUE KEY (username),
    UNIQUE KEY (email)
);

DELIMITER $$
CREATE OR REPLACE FUNCTION check_if_user_exists(i_username VARCHAR(30), i_email TEXT)
RETURNS INT
DETERMINISTIC
BEGIN
DECLARE username int;
DECLARE email int;
SELECT COUNT(*) INTO username FROM users WHERE users.username = i_username;
SELECT COUNT(*) INTO email FROM users WHERE users.email = i_email;

IF (username) THEN 
    RETURN 2;
ELSEIF (email) THEN 
    RETURN 1;
ELSE 
    RETURN 0;
END IF;
END$$
DELIMITER ;