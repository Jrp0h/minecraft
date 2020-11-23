CREATE TABLE users (
    id int (11) NOT NULL UNIQUE PRIMARY KEY,
    dc_username varchar(255) NOT NULL UNIQUE,
    mc_username varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL
)