CREATE TABLE T_H_PERSON(
	id int NOT NULL AUTO_INCREMENT,
	first_name varchar(20) NOT NULL,
	second_name varchar(20) NOT NULL,
	phone_number varchar(64) NOT NULL,
	email varchar(255) NOT NULL,
	roles_id int NOT NULL UNIQUE,
	notes TEXT,
	
	PRIMARY KEY (id)
);

