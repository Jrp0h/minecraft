CREATE TABLE enchantments (
    id int (11) NOT NULL UNIQUE PRIMARY KEY,
    user_id int(11) NOT NULL,
    poi_id int(11) NOT NULL,
    price int(11) NOT NULL
)