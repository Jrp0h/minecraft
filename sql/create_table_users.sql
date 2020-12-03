CREATE TABLE users (
    id int (11) NOT NULL AUTO_INCREMENT,
    dc_username varchar(255) NOT NULL UNIQUE,
    mc_username varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    PRIMARY KEY(id)
)
