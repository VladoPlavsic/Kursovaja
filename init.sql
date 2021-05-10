CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password TEXT NOT NULL,
    email TEXT NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT false, 
    UNIQUE KEY (username),
    UNIQUE KEY (email)
);

/**/
DELIMITER $$
CREATE OR REPLACE PROCEDURE add_user(i_username VARCHAR(30), i_password TEXT, i_email TEXT)
DETERMINISTIC
BEGIN
INSERT INTO users (username, password, email) VALUES (i_username, i_password, i_email);
END $$;
DELIMITER ;

/**/
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

CREATE TABLE availableArticles (
    orderNum INT PRIMARY KEY NOT NULL,
    articleName VARCHAR(200) NOT NULL,
    UNIQUE KEY (articleName),
    UNIQUE KEY (orderNum)
);

/**/
DELIMITER $$
CREATE OR REPLACE PROCEDURE check_if_admin(i_username VARCHAR(30))
DETERMINISTIC
BEGIN
SELECT is_admin FROM users WHERE username = i_username;
END$$;
DELIMITER ;

/**/
DELIMITER $$
CREATE OR REPLACE PROCEDURE add_availableArticle(i_orderNum INT, i_articleName VARCHAR(200))
DETERMINISTIC
BEGIN

INSERT INTO availableArticles (orderNum, articleName) VALUES (i_orderNum, i_articleName) RETURNING orderNum, articleName;

END $$;
DELIMITER ;

/**/
DELIMITER $$
CREATE OR REPLACE PROCEDURE get_availableArticles()
BEGIN

SELECT * FROM availableArticles ORDER BY orderNum;

END $$;
DELIMITER ;

/**/
DELIMITER $$
CREATE OR REPLACE PROCEDURE delete_availableArticle(i_orderNum INT)
BEGIN
DELETE FROM availableArticles WHERE orderNum = i_orderNum;
END $$;
DELIMITER ;

/**/
CREATE TABLE articles (
    id INT NOT NULL,
    content TEXT,
    CONSTRAINT fk_article FOREIGN KEY (id)
    REFERENCES availableArticles(orderNum)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

/**/
DELIMITER $$
CREATE OR REPLACE FUNCTION check_article_exists(i_id INT)
RETURNS INT
DETERMINISTIC
BEGIN
DECLARE count_ int;

SELECT COUNT(*) INTO count_ FROM articles WHERE id = i_id;
RETURN count_;

END $$;
DELIMITER ;


/**/
DELIMITER $$
CREATE OR REPLACE PROCEDURE add_article(i_id INT, i_content TEXT)
DETERMINISTIC
BEGIN

INSERT INTO articles (id, content) VALUES (i_id, i_content) RETURNING id, content;

END $$;
DELIMITER ;

/**/
DELIMITER $$
CREATE OR REPLACE PROCEDURE update_article(i_id INT, i_content TEXT)
DETERMINISTIC
BEGIN

UPDATE articles SET 
    content = i_content
WHERE id = i_id;
SELECT * FROM articles WHERE id = i_id;

END $$;
DELIMITER ;

/**/
DELIMITER $$
CREATE OR REPLACE PROCEDURE get_article(i_id INT)
DETERMINISTIC
BEGIN

SELECT * FROM articles WHERE id = i_id;

END $$;
DELIMITER ;
